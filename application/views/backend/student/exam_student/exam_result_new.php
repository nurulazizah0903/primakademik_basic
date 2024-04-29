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
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase($page_title); ?>
            <a href="<?= site_url('addons/exam/my_expired_exam'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('back'); ?></a>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<?php $student_id = $this->session->userdata('user_id'); ?>

<div class="card">
    <div class="card-body exam_question_content">
        <div class="row">
        	<div class="col-md-12">
        		<h4 class="mb-2 pb-2 pl-0">
					<?php echo get_phrase('your_answers'); ?>
				</h4>
        	</div>
			<div class="col-md-8">
				<div class="row">
					<?php $total_marks = 0; ?>
					<?php foreach($questions->result_array() as $key => $question):
						$question_answer = $this->db->get_where('exam_answers', array('question_id' => $question['id'], 'student_id' => $student_id, 'status' => 1))->row_array();
						$total_marks += $question['mark'];
					?>
						<div class="col-md-12 bg-light border-bottom pb-2 mb-2">
							<p class="my-1">
							<span class="float-right">
									<?php echo get_phrase('total_bobot'); ?> : 
									<?php if($question['mark'] > 0): ?>
										<?php echo $question['mark']; ?>
									<?php else: ?>
										<?php echo 0; ?>
									<?php endif; ?>
								</span>
								<?php echo get_phrase('question'); ?>: 
								<strong><span class="text-muted"><?php echo $question['question']; ?></strong>
									<?php 
								if ($question['question_type'] == 'choices') {
									$choices_array = $question['choices'];
									if(!is_null($choices_array)) {
										$choices = explode(";", $choices_array);
										foreach($choices as $choice){ ?>
										<ul>
											<li><?= $choice?></li>
										</ul>
										<?php
										}
									}
								}
								?>
								</span>
							</p>
							<p class="mb-1"><?php echo get_phrase('answer'); ?> :
                            <?php if($question_answer['id'] <= 0): ?>
                                <span class="badge badge-danger-lighten ml-1"><?php echo get_phrase('there_is_no_answer'); ?></span>
                            <?php endif; ?>
                            	<span class="float-right">
                            		<?php echo get_phrase('obtained_mark') ?> : 
                            		<?php if($question_answer['obtained_mark'] > 0): ?>
										<?php echo $question_answer['obtained_mark']; ?>
									<?php else: ?>
										<?php echo 0; ?>
									<?php endif; ?>
                            	</span>
                            </p>

                            <?php if($question_answer['id'] > 0): ?>
                                <form action="javascript:;" method="POST" enctype="multipart/form-data">
                                        <?php if($question['question_type'] == 'text'): ?>
										<div class="form-group bg-white p-3">
                                            <?php echo nl2br($question_answer['answer']); ?>
										</div>
										<?php elseif($question['question_type'] == 'choices'): ?>
											<strong><?php echo nl2br($question_answer['answer']); ?></strong>
											<div class="form-group mb-3">
                                            <p class="mb-0"><?php echo get_phrase('answer'); ?> :
                                                <?php
                                                if ($question_answer['obtained_mark'] > 0) { ?>
                                                    <span class="badge badge-success-lighten ml-1"><?php echo get_phrase('true'); ?></span>
                                                <?php } else { ?>
                                                    <span class="badge badge-danger-lighten ml-1"><?php echo get_phrase('false'); ?></span>
                                                <?php } ?>
                                            </div>
										<?php elseif($question['question_type'] == 'file'): ?>
											<a href="<?php echo base_url('uploads/assignment_files/'.$question_answer['answer']); ?>" class="btn btn-primary btn-sm ml-4" download><i class="mdi mdi-download"></i> <?php echo get_phrase('download'); ?></a>
                                        <?php else: ?>
                                            
                                        <?php endif; ?>
									
                                </form>                                
                            <?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card">
		            <h5 class="text-center mt-3 mb-0"><?php echo get_phrase('total_marks'); ?></h5>
		            <div class="card-body text-center"><?php echo $total_marks; ?></div>
		        </div>
				<div class="card">
		            <h5 class="text-center mt-3 mb-0"><?php echo get_phrase('total_obtained_marks'); ?></h5>
		            <div class="card-body text-center">
		                <?php
		                    $this->db->select_sum('obtained_mark');
		                    $this->db->where('exam_id', $exam_details['id']);
		                    $this->db->where('student_id', $student_id);
		                    $this->db->where('status', 1);
		                    $student_answers = $this->db->get('exam_answers');
		                    $student_obtained_marks = $student_answers->row('obtained_mark');
		                    if($student_obtained_marks > 0){
		                        echo $student_obtained_marks;
		                    }else{
		                        echo 0;
		                    }
		                ?>
		            </div>
		        </div>
		        <div class="card">
		            <h5 class="text-center mt-3 mb-0"><?php echo get_phrase('remark'); ?></h5>
		            <div class="card-body text-center">
		                <?php echo $this->db->get_where('exam_remarks',array('exam_id' => $exam_details['id'], 'student_id' => $student_id))->row('remark'); ?>
		            </div>
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