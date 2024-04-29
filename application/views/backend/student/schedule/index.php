<?php
$student_data = $this->user_model->get_logged_in_student_details(); 
?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('student_schedule'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body class_routine_content">
				<?php include 'list.php'; ?>
			</div>
		</div>
	</div>
</div>

<script>
$('document').ready(function(){
    getFilteredClassRoutine();
});

var getFilteredClassRoutine = function() {
	var class_id = <?= $student_data['class_id'] ?>;
	var section_id = <?= $student_data['section_id'] ?>;
	if(class_id != "" && section_id!= ""){
		$.ajax({
			url: '<?php echo route('schedule/filter/') ?>'+class_id+'/'+section_id,
			success: function(response){
				$('.class_routine_content').html(response);
			}
		});
	}
}
</script>
