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
                    <h1 class="ms-3 font-poppins font-size-sm-6 text-start">Ujian <br> Saya</h1>
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

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo $exam_details['title']; ?>
            <a href="<?= site_url('addons/exam/my_active_exam'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('back_to_my_exam'); ?></a>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>


<div class="card">
    <div class="card-body exam_question_content">
        <div class="row">
			<div class="col-md-8">
				<h4 class="border-bottom mb-2 pb-2">
					<?php echo get_phrase('questions'); ?>
				</h4>
				<div class="row">
					<?php $student_id = $this->session->userdata('user_id'); ?>
					<?php $question_ids_arr = array(); ?>
					<?php foreach($questions->result_array() as $key => $question):
						array_push($question_ids_arr, $question['id']);
						$question_answer = $this->db->get_where('exam_answers', array('question_id' => $question['id'], 'student_id' => $student_id)); ?>

						<div class="col-md-12 bg-light border-bottom pb-2 mb-2">
							<p class="my-1">
								<?php echo get_phrase('question'); ?>: <span class="text-muted"><?php echo $question['question']; ?></span>
								<span class="float-right"><?php echo get_phrase('bobot'); ?> : <?php echo $question['mark']; ?></span>
							</p>
							<form action="<?php echo site_url('addons/exam/save_answers'); ?>" method="POST" enctype="multipart/form-data" id="mainForm" name="mainForm">
								<div class="form-group">
									<?php if($question['question_type'] == 'text'): ?>
										<textarea id="question_answer_<?= $question['id']; ?>" name="question_answer" class="question_answer form-control" rows="5"><?php echo $question_answer->row('answer'); ?></textarea>

									<?php elseif($question['question_type'] == 'choices'): ?>
										<?php 
											$choices_array = $question['choices'];
											if(!is_null($choices_array)) {
												$choices = explode(";", $choices_array);
												foreach($choices as $choice){ ?>

												<div class="form-check">
													<input type="radio" name="question_answer_<?= $question['id'];?>" value="<?= $choice ?>"
													<?php if ($question_answer->row('answer') == $choice):?> checked <?php endif; ?>>
													<label class="form-check-label" for="question_answer">
														<?= $choice?>
													</label>
												</div>
												
												<?php
												}
											}
										?>
									<?php else: ?>
										<div class="custom-file">
						                    <div class="custom-file">
												<input type="file" class="custom-file-input" id="question_answer_<?= $question['id']; ?>" onchange="changeTitleOfImageUploader(this)">
												<label class="custom-file-label ellipsis" for="scorm_zip"><?php echo get_phrase('choose_file'); ?></label>


												<small class="badge badge-light"><?php echo 'maximum_upload_size'; ?>: <?php echo ini_get('upload_max_filesize'); ?></small>
											    <small class="badge badge-light"><?php echo 'post_max_size'; ?>: <?php echo ini_get('post_max_size'); ?></small>
											    <small class="badge badge-info-lighten">
											    	<?php echo '"post_max_size" '.get_phrase("has_to_be_bigger_than").' "upload_max_filesize"'; ?>
											    </small>

											    <?php if($question_answer->num_rows('answer') > 0): ?>
											    	<small class="float-right"><a href="<?php echo base_url('uploads/assignment_files/'.$question_answer->row('answer')); ?>" download><?php echo get_phrase('download_previews_file'); ?></a></small>
											    <?php endif; ?>
											</div>
										</div>
									<?php endif; ?>
								</div>

								<button type="button" onclick="save_question_answer('<?php echo $question['id']; ?>', '<?php echo $exam_details['id']; ?>', this)" class="btn btn-primary float-right btn-sm"><span class="px-20"><?php echo get_phrase('save'); ?></span></button>
							</form>
						</div>
					<?php endforeach; ?>
					<div class="col-md-12 p-0 mt-4">
						<a href="<?php echo site_url('addons/exam/submit_exam/'.$exam_details['id']); ?>" class="btn btn-success float-right"><?= get_phrase('submit_exam'); ?></a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<h4 class="border-bottom mb-2 pb-2"><?php echo get_phrase('tenggat_waktu'); ?></h4>
				<div class="alert alert-primary" role="alert">
                    <h5><?php echo get_phrase('notice'); ?> !!</h5>
                    <?php echo get_phrase('be_aware_of_the_date'); ?>. <?php echo get_phrase('anda_tidak_dapat_mengumpulkan_jika_sudah_tenggat_waktu'); ?>.
                    <hr>
                    <strong><?php echo get_phrase('tenggat_waktu'); ?> :</strong> <?php echo date('d M Y', $exam_details['deadline']); ?>
                </div>
			</div>
		</div>
    </div>
</div>

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

<?php include 'common_script.php'; ?>