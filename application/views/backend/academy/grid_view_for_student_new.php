<?php
  $school_title = get_settings('system_title');
  $theme        = get_frontend_settings('theme');
  $active_school_id = $this->frontend_model->get_active_school_id();
  $profile_data = $this->user_model->get_profile_data();
?>
<html lang="en">

<head>
    <!-- AKADEMIK PULGIN START-->
    <!-- third party css -->
    <link href="<?php echo base_url(); ?>assets/backend/css/vendor/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/vendor/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/vendor/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/vendor/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/vendor/select.bootstrap4.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/vendor/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/vendor/simplemde.min.css" rel="stylesheet" type="text/css" />
    <!-- third party css end -->

    <!-- App css -->
    <link href="<?php echo base_url(); ?>assets/backend/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/app.min.css" rel="stylesheet" type="text/css" />

    <!-- CUSTOM CSS FILES -->
    <link href="<?php echo base_url(); ?>assets/backend/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/content-placeholder.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/backend/css/addon.css" rel="stylesheet" type="text/css" />

    <!--Notify for ajax-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!--Jquery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <style>
        tr.odd td:first-child,
        tr.even td:first-child {
            padding-left: 4em;
        }
        .dtrg-level-1 td{
            padding-left: 2em !important;
        }
    </style>
    <!-- AKADEMIK PULGIN END-->

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

<body class="bg-imgs-2 min-vh-100">

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
                    <h1 class="ms-3 font-poppins font-size-sm-6 text-start">Jadwal <br>Pelajaran Saya</h1>
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
<?php $check_data = $this->db->get('sessions');
if($check_data->num_rows() > 0): ?>

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title mdi mdi-library-video"> <?php echo get_phrase('subject_matter'); ?></h4>
                <form class="row justify-content-center" action="javascript:void(0)" method="get">
                    <div class="col-md-10">
                        <div class="row justify-content-center">
                            <!-- Course Teacher -->
                                <div class="col-md-3" <?php if($this->session->userdata('teacher_login') == 1) echo 'hidden'; ?>>
                                    <div class="form-group">
                                        <label for="user_id"><?php echo get_phrase('pengajar'); ?></label>
                                        <select class="form-control select2" data-toggle="select2" name="user_id" id = 'user_id'>
                                            <option value="all" <?php if($selected_user_id == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                                            <?php foreach ($all_teachers->result_array() as $teacher): ?>
                                                <option value="<?php echo $teacher['id']; ?>" <?php if($selected_user_id == $teacher['id']) echo 'selected'; ?>><?php echo $teacher['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            <!-- Course subject -->
                                <div class="col-md-3"<?php if($this->session->userdata('student_login') != 1) echo 'hidden'; ?>>
                                    <div class="form-group">
                                        <?php $class_id = $this->lms_model->get_class_id_by_user($this->session->userdata('user_id'));; ?>
                                            <?php $subjects = $this->lms_model->get_subject_by_class_id($class_id); ?>
                                        <label for="subject_id"><?php echo get_phrase('subject'); ?></label>
                                        <select class="form-control select2" data-toggle="select2" name="subject" id = 'subject_id'>
                                            <option value="all" <?php if($selected_subject == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                                            
                                            <?php foreach($subjects as $subject){ ?>
                                                <option value="<?php echo $subject['id']; ?>" <?php if($selected_subject == $subject['id']) echo 'selected'; ?>><?php echo $subject['name']; ?></option>
                                            <?php } ?>
                                            
                                        </select>
                                    </div>
                                </div>

                            <div class="col-md-3">
                                <label for=".." class="text-white">..</label>
                                <button type="submit" class="btn btn-primary btn-block" onclick="filterCourse()" name="button"><?php echo get_phrase('filter'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Simple card -->
        <?php if (count($courses) > 0): ?>
            <div class="row">
                <?php foreach ($courses as $key => $course):
                    $teacher_details = $this->user_model->get_user_details($course['user_id']);
                    $class_details = $this->crud_model->get_classes($course['class_id'])->row_array();
                    $sections = $this->lms_model->get_section('course', $course['id']);
                    $subject = $this->crud_model->get_subject_by_id($course['subject_id']);
                    $lessons = $this->lms_model->get_lessons('course', $course['id']); ?>
                    
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="card d-block">
                            <?php if(file_exists('uploads/course_thumbnail/'.$course['thumbnail'])):
                              $course_thumbnail = base_url("uploads/course_thumbnail/".$course["thumbnail"]);
                            else:
                              $course_thumbnail = base_url("uploads/course_thumbnail/placeholder.png");
                            endif; ?>
                            <div class="w-100 bg_course_thumbnail" style="background-image: url('<?php echo $course_thumbnail; ?>');">
                                <span class="badge badge-success float-right mt-2 mr-2 p-1"><?php echo $subject['name']; ?></span>
                            </div>
                            <div class="card-body ">
                                <h4 class="card-title"><?php echo $course['title']; ?></h4>
                                <div class="w-100 mb-3">
                                    <div class="media">
                                        <img class="mr-2 rounded-circle" src="<?= $this->user_model->get_user_image($course['user_id']); ?>" width="30" alt="Generic placeholder image">
                                        <div class="media-body pt-1">
                                            <span class="font-13 text-muted"><?php echo $this->user_model->get_user_details($course['user_id'], 'name'); ?></span>

                                            <div class="btn-group float-right">
                                                <div class="btn-group">
                                                    <button class="mdi mdi-dots-vertical bg-white border-0" data-toggle="dropdown" aria-expanded="false"></button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item pl-1" onclick="previewModal('<?php echo site_url('addons/courses/course_preview/'.$course['id']); ?>', '<?php echo $course['title']; ?>');" href="javascript:void(0)">
                                                            <i class="mdi mdi-eye-outline"></i>
                                                            <?php echo get_phrase('course_preview'); ?>
                                                        </a>
                                                        <a class="dropdown-item mdi pl-1" onclick="showAjaxModal('<?php echo site_url('addons/courses/course_information/'.$course['id']); ?>', '<?php echo get_phrase('course_informations'); ?>');" href="javascript:void(0)">
                                                            <i class="mdi mdi-information-outline"></i>
                                                            <?php echo get_phrase('course_information'); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $progress_value = course_progress($course['id']); ?>
                                <div class="row">
                                    <div class="col-sm-10 col-md-10">
                                        <?php if($progress_value >= 100): ?>
                                            <div class="progress mb-2 h-5px">
                                                <div class="progress-bar bg-green-low" role="progressbar" style="width: <?php echo $progress_value; ?>%;" aria-valuenow="<?php echo $progress_value; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        <?php else: ?>
                                            <div class="progress mb-2 h-5px">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $progress_value; ?>%;" aria-valuenow="<?php echo $progress_value; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-sm-2 col-md-2 text-left p-0 progress_value_count"><p><?php echo ceil($progress_value); ?>%</p></div>
                                </div>
                                <div class="w-100 text-center">
                                    <?php if($progress_value > 0): ?>
                                        <a href="<?php echo site_url('addons/lessons/play/'.slugify($course['title']).'/'.$course['id'].'/'.$lessons->row('id')); ?>" class="btn btn-secondary mw-50"><?php echo get_phrase('continue_lesson'); ?></a>
                                    <?php else: ?>
                                        <a href="<?php echo site_url('addons/lessons/play/'.slugify($course['title']).'/'.$course['id'].'/'.$lessons->row('id')); ?>" class="btn btn-primary mw-50"><?php echo get_phrase('start_course'); ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <?php include APPPATH.'views/backend/empty.php'; ?>
        <?php endif; ?>
    </div>

<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script>
    $('.select2').select2();
</script>
<footer class="container-fluid px-0 fixed-lg-bottom">
        <div class="position-relative d-flex align-items-center foo-height bg-gradie">
            <img class="mb-5 mt-n5" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/icon_footer.png" draggable="false" width="100" alt="">
            <a href = "javascript:history.back()" style="text-decoration:none;">
            <button class="btn bg-7 text-white position-absolute right-0 shadow-none">
                <!-- onclick="location.href='siswaMainPage.html'"> -->
					<?php echo get_phrase('back'); ?>
            </button></a>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/calender/js/script.js"></script>

    <!-- AKADEMIK PULGIN START-->
    <!-- bundle -->
    <script src="<?php echo base_url(); ?>assets/backend/js/app.min.js"></script>

    <!-- third party js -->
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.bootstrap4.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/responsive.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/buttons.bootstrap4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/Chart.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.datatable-init.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.form-wizard.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery-ui.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/fullcalendar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/summernote-bs4.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.summernote.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>

    <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>

    <!--Notify for ajax-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
    <!-- demo app -->
    <script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.dashboard.js"></script>
    <!-- end demo js-->

    <!--Custom JS-->
    <script src="<?php echo base_url(); ?>assets/backend/js/ajax_form_submission.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/ajax_form_submission2.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/content-placeholder.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/addon.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/init.js"></script>

    <!-- dragula js-->
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/dragula.min.js"></script>
    <!-- component js -->
    <script src="<?php echo base_url(); ?>assets/backend/js/ui/component.dragula.js"></script>

    <script src="https://cdn.datatables.net/rowgroup/1.1.3/js/dataTables.rowGroup.min.js"></script>

    <script>
        function error_required_field() {
        $.NotificationApp.send("<?php echo get_phrase('oh_snap'); ?>!", "<?php echo get_phrase('please_fill_all_the_required_fields'); ?>" ,"top-right","rgba(0,0,0,0.2)","error");
        }
    </script>
    <!-- AKADEMIK PULGIN END-->

</body>

</html>