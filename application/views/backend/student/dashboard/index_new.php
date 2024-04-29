<?php
  $school_title = get_settings('system_title');
  $theme        = get_frontend_settings('theme');
  $active_school_id = $this->frontend_model->get_active_school_id();
  $profile_data = $this->user_model->get_profile_data();

  $student_data = $this->db->get_where('students', array('user_id' => $profile_data['id']))->row_array();
  $enroll = $this->db->get_where('enrols', array('student_id' => $student_data['id']))->row_array(); 
  $class = $this->crud_model->get_class_details_by_id($enroll['class_id'])->row_array();
  $section = $this->crud_model->get_section_details_by_id('section',$enroll['section_id'])->row_array();
  $parent_data = $this->db->get_where('parents', array('id' => $student_data['parent_id']))->row_array();
  $parent = $this->db->get_where('users', array('id' => $parent_data['user_id']))->row_array();
  $achievement = $this->crud_model->get_achievements_point__by_student_id($student_data['id']);
  $violations = $this->crud_model->get_violations_point__by_student_id($student_data['id']);
  $routine_counseling = $this->db->get_where('routine_counseling', array('student_id' => $student_data['id']))->result_array();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/calender/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/style.css">
    <link rel="shortcut icon" href="<?php echo $this->settings_model->get_favicon(); ?>">
    <title><?php echo get_phrase($page_title); ?> | <?= get_frontend_settings('website_title'); ?></title>

</head>

<body class="bg-imgs">

    <!-- Main Layout -->
    <div class="container-fluid h-100 mb-5 mb-lg-0">
        <div class="position-absolute right-0">
            <img draggable="false" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/logo_tut.png" class="logo-tut-resp" alt="">
        </div>
        <div
            class="d-flex my-3 my-lg-1 ms-lg-0 ms-3 flex-row align-items-start justify-content-lg-center justify-content-start">
            <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/checklistIcon.svg" class="mt-lg-2 logo-checks-resp" draggable="false" alt="">
            <h1 class="text-center ms-3 font-poppins font-size-sm-6"><?php echo get_phrase('login'); ?> <br> <?php echo get_phrase('student'); ?></h1>
        </div>
        <div class="container-fluid h-100">
            <div class="row">
                <div class="col-lg-4">
                    <div class="d-flex flex-column mt-0">
                        <div class="cards-profiles shadow-sm px-4">
                            <img class="profile-user-size" draggable="false" src="<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>" alt="">
                            <div class="d-block flex-wrap pt-2 px-lg-4 px-2 mx-2 mx-lg-0 text-wrap">
                                <h1 class="font-size-sm-2 fs-xs-1 font-size-3 mb-0"><?php echo $profile_data['name']; ?></h1>
                                <h1 class="font-size-sm-2 fs-xs-2 font-size-5 mt-2"><?php echo $profile_data['email']; ?></h1>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column my-4">
                        <div class="cards-profile-detail shadow-sm px-4 py-lg-3 py-4">
                            <h1 class="font-size-7 font-size-sm-1 text-center fs-xs-4"><?php echo get_phrase('routine_counseling'); ?></h1>
                            <ul class="ps-3 ms-1 mt-2">
                                <li class="font-size-5 font-size-sm-7 fs-xs-1"><?php echo get_phrase('achievement_points'); ?> : <?php echo $achievement[0]['point']; ?></li>
                                <li class="font-size-5 font-size-sm-7 fs-xs-1"><?php echo get_phrase('foul_points'); ?> : <?php echo $violations[0]['point']; ?></li>
                            </ul>
                            <div class="d-block">
                            <table class="table mb-lg-0 table-borderless" >
                            <tr>
                                <th><?php echo get_phrase('date_counseling'); ?></th>
                                <th><?php echo get_phrase('mentor'); ?></th>
                                <th><?php echo get_phrase('status'); ?></th>
                            </tr>
                            <?php 
                            foreach ($routine_counseling as $counseling):
                                $teacher_detail = $this->user_model->get_user_details($counseling['teacher_id']);
                                ?>
                                <tr>
                                    <td>
                                        <?php echo date('D, d/M/Y', $counseling['date']); ?>
                                    </td>
                                    <td><?= $teacher_detail['name'];?></td>
                                    <td>
                                        <?php if ($counseling['status'] == 1): ?>
                                            <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('counseling_finish'); ?>
                                        <?php else: ?>
                                            <i class="mdi mdi-circle text-disable"></i> <?php echo get_phrase('not_yet_counseling'); ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                          </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="d-flex flex-column mb-4">
                        <div class="cards-tabs px-lg-4">
                            <div class="w-80 tab-desc w-sm-100 shadow-sm rounded bg-white me-lg-5">
                                <table class="table mb-lg-0 table-borderless ">
                                    <tbody>
                                        <tr class="font-size-sm-7 font-size-xs-1 font-size-5">
                                            <td colspan="0"><?php echo get_phrase('nisn'); ?></td>
                                            <th scope="row">:</th>
                                            <td colspan="4"><?php echo $student_data['nisn']; ?></td>
                                        </tr>
                                        <tr class="font-size-sm-7 font-size-xs-1 font-size-5">
                                            <td colspan="0"><?php echo get_phrase('nis'); ?></td>
                                            <th scope="row">:</th>
                                            <td colspan="4"><?php echo $student_data['NIS']; ?></td>
                                        </tr>
                                        <tr class="font-size-sm-7 font-size-xs-1 font-size-5">
                                            <td colspan="0"><?php echo get_phrase('nik'); ?></td>
                                            <th scope="row">:</th>
                                            <td colspan="4"><?php echo $profile_data['nik']; ?></td>
                                        </tr>
                                        <tr class="font-size-sm-7 font-size-xs-1 font-size-5">
                                            <td colspan="0"><?php echo get_phrase('class'); ?></td>
                                            <th scope="row">:</th>
                                            <td colspan="4"><?php echo $class['name']; ?></td>
                                        </tr>
                                        <tr class="font-size-sm-7 font-size-xs-1 font-size-5">
                                            <td colspan="0"><?php echo get_phrase('section'); ?></td>
                                            <th scope="row">:</th>
                                            <td colspan="4"><?php echo $section['name']; ?></td>
                                        </tr>
                                        <tr class="font-size-sm-7 font-size-xs-1 font-size-5">
                                            <td colspan="0"><?php echo get_phrase('address'); ?></td>
                                            <th scope="row">:</th>
                                            <td colspan="4"><?php echo $profile_data['address']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <br>
                            <div class="w-80 tab-desc w-sm-100 shadow-sm rounded bg-white me-lg-5">
                                <?php
                                $student_details = $this->db->get_where('students', array('user_id' => $this->session->userdata('user_id')))->row_array();
                                $this->db->where('return_date <=', date('m/d/Y'));
                                $this->db->where('user_id', $student_details['user_id']);
                                $book_issues = $this->db->get('book_issues')->result_array();
                                ?>
                                <?php if (count($book_issues) > 0): ?>
                                    <table class="table mb-lg-0 table-borderless">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th><?php echo get_phrase('book_name'); ?></th>
                                                <th><?php echo get_phrase('issue_date'); ?></th>
                                                <th><?php echo get_phrase('return_date'); ?></th>
                                                <th><?php echo get_phrase('status'); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($book_issues as $book_issue):
                                                $book_details = $this->crud_model->get_book_by_id($book_issue['book_id']);
                                                ?>
                                                <tr>
                                                <td><?php echo $book_details['name']; ?></td>
                                                    <td>
                                                        <?php echo date('D, d/M/Y', $book_issue['issue_date']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo date('D, d/M/Y', strtotime($book_issue['return_date'])); ?>
                                                    </td>
                                                    <td>
                                                        <i class="mdi mdi-circle text-danger"></i> <?php echo get_phrase('terlambat'); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                <?php include APPPATH.'views/backend/empty.php'; ?>
                                <?php endif; ?>
                            </div>
                            <div
                                class="d-md-block d-flex flex-row w-100 justify-content-center position-relative mt-lg-3 mt-3">
                                <div class="d-flex flex-md-row flex-column position-relative">
                                    <button class="btn mini-cards shadow-sm"
                                        onclick="location.href='<?php echo route('event_calendar'); ?>'">
                                        <p class="mini-rights mb-0 mb-lg-2 font-size-sm-4">01</p>
                                        <h4
                                            class="mb-0 position-relative  font-size-sm-2 d-flex align-items-center font-size-8 h-50 text-start">
                                            <?php echo get_phrase('event_calender'); ?></h4>
                                        <img draggable="false" class="mini-rights h-25 minis-icon-responsive"
                                            src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconForMinis-cards.svg" alt="">
                                    </button>
                                    <button class="btn mini-cards shadow-sm mx-lg-5 mx-md-3 my-3 my-md-0"
                                        onclick="location.href='<?php echo route('routine'); ?>'">
                                        <p class="mini-rights mb-0 mb-lg-2 font-size-sm-4">02</p>
                                        <h4
                                            class="mb-0 position-relative font-size-sm-2 d-flex align-items-center font-size-8 h-50 text-start">
                                            <?php echo get_phrase('class_routine'); ?></h4>
                                        <img draggable="false" class="mini-rights h-25 minis-icon-responsive"
                                            src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconForMinis-cards.svg" alt="">
                                    </button>
                                    <button class="btn mini-cards shadow-sm"
                                        onclick="location.href='<?php echo site_url('addons/assignment/my_active_assignment'); ?>'">
                                        <p class="mini-rights mb-0 mb-lg-2 font-size-sm-4">03</p>
                                        <h4
                                            class="mb-0 position-relative pe-lg-5 pe-3 font-size-sm-2 d-flex align-items-center font-size-8 h-50 text-start">
                                            <?php echo get_phrase('my_assignment'); ?></h4>
                                        <img draggable="false" class="mini-rights h-25 minis-icon-responsive"
                                            src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconForMinis-cards.svg" alt="">
                                    </button>
                                    <button class="btn mini-cards shadow-sm mx-lg-5 mt-lg-0 mt-md-0 ms-md-3 ms-0 mt-3"
                                        onclick="location.href='<?php echo site_url('addons/exam/my_active_exam'); ?>'">
                                        <p class="mini-rights mb-0 mb-lg-2 font-size-sm-4">04</p>
                                        <h4
                                            class="mb-0 position-relative font-size-sm-2 d-flex align-items-center font-size-8 h-50 text-start">
                                            <?php echo get_phrase('my_exam'); ?></h4>
                                        <img draggable="false" class="mini-rights h-25 minis-icon-responsive"
                                            src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconForMinis-cards.svg" alt="">
                                    </button>
                                </div>
                                <div class="d-flex flex-md-row flex-column mt-lg-5 mt-md-3 mt-0 ms-lg-0 ms-md-0 ms-4">
                                    <button class="btn mini-cards shadow-sm"
                                        onclick="location.href='<?php echo site_url('addons/courses'); ?>'">
                                        <p class="mini-rights mb-0 mb-lg-2 font-size-sm-4">05</p>
                                        <h4
                                            class="mb-0 position-relative  font-size-sm-2 d-flex align-items-center font-size-8 h-50 text-start">
                                            <?php echo get_phrase('course_list'); ?></h4>
                                        <img draggable="false" class="mini-rights h-25 minis-icon-responsive"
                                            src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconForMinis-cards.svg" alt="">
                                    </button>
                                    <button class="btn mini-cards shadow-sm mx-lg-5 mx-md-3 my-3 my-md-0"
                                        onclick="location.href='<?php echo route('mark'); ?>'">
                                        <p class="mini-rights mb-0 mb-lg-2 font-size-sm-4">06</p>
                                        <h4
                                            class="mb-0 position-relative  font-size-sm-2 d-flex align-items-center font-size-8 h-50 text-start">
                                            <?php echo get_phrase('daftar_nilai_siswa'); ?></h4>
                                        <img draggable="false" class="mini-rights h-25 minis-icon-responsive"
                                            src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconForMinis-cards.svg" alt="">
                                    </button>
                                    <button class="btn mini-cards shadow-sm me-lg-5"
                                        onclick="location.href='<?php echo route('attendance'); ?>'">
                                        <p class="mini-rights mb-0 mb-lg-2 font-size-sm-4">07</p>
                                        <h4
                                            class="mb-0 position-relative font-size-sm-2 d-flex align-items-center font-size-8 h-50 text-start">
                                            <?php echo get_phrase('attendance'); ?></h4>
                                        <img draggable="false" class="mini-rights h-25 minis-icon-responsive"
                                            src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconForMinis-cards.svg" alt="">
                                    </button>
                                    <button class="btn mini-cards shadow-sm mt-lg-0 mt-3"
                                        onclick="location.href='<?php echo route('raport'); ?>'">
                                        <p class="mini-rights mb-0 mb-lg-2 font-size-sm-4">08</p>
                                        <h4
                                            class="mb-0 position-relative font-size-sm-2 d-flex align-items-center font-size-8 h-50 text-start pe-5">
                                            <?php echo get_phrase('raport'); ?></h4>
                                        <img draggable="false" class="mini-rights h-25 minis-icon-responsive"
                                            src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconForMinis-cards.svg" alt="">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End:Main Layout -->


    <footer class="container-fluid mt-lg-n5 d-flex align-items-center position-relative foo-height bg-gradie">
        <button class="btn bg-7 text-white position-absolute right-0" >
        <!-- onclick="location.href='index.html'"> -->
          <a href="<?php echo site_url('login/logout'); ?>" style="text-decoration:none;">
            <span><?php echo get_phrase('logout'); ?></span>
        </a>
        </button>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/calender/js/script.js"></script>


</body>

</html>