<?php $student_data = $this->user_model->get_logged_in_student_details(); ?>
<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"> <i class="mdi mdi-format-list-numbered title_icon"></i> <?php echo get_phrase('raport'); ?> </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
    <div class="row w-100 raport-height ">
            <div class="col d-flex justify-content-center bg-5">
			<div class="card-body class_score_content">
          <?php include 'list.php'; ?>
			</div>
            </div>
    </div>
		</div>
	</div>
</div>

<script>
var showRaport = function() {
        $.ajax({
            url: '<?php echo route('raport/list/') ?>',
            success: function(response){
                $('.class_score_content').html(response);
            }
        });
}
</script>