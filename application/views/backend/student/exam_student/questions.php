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
						<a href="<?php echo site_url('addons/exam/submit_exam/'.$exam_details['id']); ?>" class="btn btn-success float-right" id="save_all_exam"><?= get_phrase('submit_exam'); ?></a>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<h4 class="border-bottom mb-2 pb-2"><?php echo get_phrase('deadline'); ?></h4>
				<div class="alert alert-primary" role="alert">
					<h5><?php echo get_phrase('countdown'); ?></h5>
					<p id="countdown" class="alert alert-warning" style="text-align: center; font-size: 17px; font-weight: bold;"></p>
                </div>
				<div class="alert alert-primary" role="alert">
                    <h5><?php echo get_phrase('notice'); ?> !!</h5>
                    <?php echo get_phrase('be_aware_of_the_date'); ?>. <?php echo get_phrase('you_will_not_be_able_to_submit_exams_after_the_due_date'); ?>.
                    <hr>
                    <strong><?php echo get_phrase('deadline'); ?> :</strong> <?php echo date('d M Y', $exam_details['deadline']); ?>
                </div>
			</div>
		</div>
    </div>
</div>

<script>
// Set the date we're counting down to
var countDownDate = new Date(<?php echo '"'.date('M d, Y H:i:s', $exam_details['time_finish']).'"'; ?>).getTime();

// Update the count down every 1 second
var x = setInterval(function() {
	
  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("countdown").innerHTML = hours+" : "+minutes+" : "+seconds;
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown").innerHTML = "FINISH";
	document.getElementById("save_all_exam").click();
  }
}, 1000);
</script>

<?php include 'common_script.php'; ?>