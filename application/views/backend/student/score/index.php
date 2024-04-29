<?php $student_data = $this->user_model->get_logged_in_student_details(); ?>
<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-format-list-numbered title_icon"></i> <?php echo get_phrase('student_score'); ?>
        </h4>
      </div> <!-- end car~d body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body class_score_content">
				<?php include 'list.php'; ?>
			</div>
		</div>
	</div>
</div>