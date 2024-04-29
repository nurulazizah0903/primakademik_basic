<?php
$school_title = get_settings('system_title');
$theme        = get_frontend_settings('theme');
$active_school_id = $this->frontend_model->get_active_school_id();
$profile_data = $this->user_model->get_profile_data();
$student_lists = $this->user_model->get_student_list_of_logged_in_parent();
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
    <link rel="stylesheet" id="switcher-id" href="">

    <link rel="shortcut icon" href="<?php echo $this->settings_model->get_favicon(); ?>">
    <title><?php echo get_phrase($page_title); ?> | <?= get_frontend_settings('website_title'); ?></title>

</head>

<body class="bg-imgs-2">

    <!-- Nav Layout -->
    <div class="container-fluid">
        <div class="row d-flex flex-lg-row flex-column-reverse">
            <div class="col">
                <div class="cards-profiles px-4 shadow-sm">
                <img class="profile-user-size" draggable="false" src="<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>" alt="">
                    <div class="d-block flex-wrap pt-2 px-lg-4 px-2 mx-2 mx-lg-0 text-wrap">
                        <h1 class="font-size-sm-2 fs-xs-1 font-size-3 mb-0"><?php echo $profile_data['name']; ?></h1>
                        <h1 class="font-size-sm-2 fs-xs-2 font-size-5 mt-2"><?php echo $profile_data['email']; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col">
                <div
                    class="d-flex my-3 my-lg-1 ms-lg-0 ms-3 flex-row align-items-start justify-content-lg-center justify-content-start">
                    <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/checklistIcon.svg" class="mt-lg-2 logo-checks-resp" draggable="false" alt="">
                    <h1 class="ms-3 font-poppins font-size-sm-6 text-start">Pengumuman <br> Sekolah</h1>
                </div>
            </div>
            <div class="col d-lg-flex align-items-center d-none">
                <div class="position-absolute right-0">
                    <img draggable="false" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/logo_tut.png" class="logo-tut-resp" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- End:Nav Layout -->

    <!-- Main Layout -->
    <div class="container min-vh-80 d-flex py-lg-0 py-4 align-items-center justify-content-center w-100">
        <div class="row">
            <div class="col d-flex justify-content-center">
                <div class="d-flex flex-column font-poppins justify-content-center w-100">
                <?php
                    $this->db->where('return_date <=', date('m/d/Y'));
                    $this->db->where('user_id', $student_lists[0]['user_id']);
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
                    <!-- <div class="row px-3 d-flex mt-5 font-size-sm-7 flex-wrap">
                        <div class="col px-1 text-lg-center text-start">
                            <p class="">Pembayaran sekolah tertunda</p>
                        </div>
                        <div class="col px-1 text-end">
                            <p class="">tidak ada</p>
                        </div> 
                    </div>-->
                </div>
            </div>
        </div>
    </div>
    <!-- End:Main Layout -->


    <footer class="container-fluid mt-lg-n5 d-flex align-items-center position-relative foo-height bg-gradie">
        <img class="mb-5 mt-n5" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/icon_footer.png" draggable="false" width="100" alt="">
        <button class="btn bg-7 text-white position-absolute right-0 shadow-none"
        onclick="location.href='<?php echo route('dashboard'); ?>'">
                <?php echo get_phrase('back'); ?>
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
    <?php include 'assets/frontend/edn/script.php'; ?>

</body>

</html>