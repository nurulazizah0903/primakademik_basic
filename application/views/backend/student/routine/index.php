<?php $student_data = $this->user_model->get_logged_in_student_details(); 
// var_dump($student_data);
?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"><i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('class_routine'); ?></h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<!-- <div class="row mt-3">
				<div class="col-md-1 mb-1"></div>
				<div class="col-md-4 mb-1">
					<select name="class" id="class_id" class="form-control select2" data-toggle="select2" required>
						<option value=""><?php echo get_phrase('select_a_class'); ?></option>
						<option value="<?php echo $student_data['class_id']; ?>"><?php echo $student_data['class_name']; ?></option>
					</select>
				</div>
				<div class="col-md-4 mb-1">
					<select name="section" id="section_id" class="form-control select2" data-toggle="select2" required>
						<option value=""><?php echo get_phrase('select_section'); ?></option>
						<option value="<?php echo $student_data['section_id']; ?>"><?php echo $student_data['section_name']; ?></option>
					</select>
				</div>
				<div class="col-md-2">
					<button class="btn btn-block btn-secondary" onclick="filter_class_routine()" ><?php echo get_phrase('filter'); ?></button>
				</div>
			</div> -->
			<div class="card-body class_routine_content">
				<?php include 'list.php'; ?>
			</div>
		</div>
	</div>
</div>

<script>

$('document').ready(function(){
    filter_class_routine();
});

function classWiseSection(classId) {
	$.ajax({
		url: "<?php echo route('section/list/'); ?>"+classId,
		success: function(response){
			$('#section_id').html(response);
		}
	});
}

function filter_class_routine(){
	var class_id = <?= $student_data['class_id'] ?>;
	var section_id = <?= $student_data['section_id'] ?>;
	if(class_id != "" && section_id!= ""){
		getFilteredClassRoutine();
	}else{
		toastr.error('<?php echo get_phrase('please_select_a_class_and_section'); ?>');
	}
}

var getFilteredClassRoutine = function() {
	var class_id = <?= $student_data['class_id'] ?>;
	var section_id = <?= $student_data['section_id'] ?>;
	if(class_id != "" && section_id!= ""){
		$.ajax({
			url: '<?php echo route('routine/filter/') ?>'+class_id+'/'+section_id,
			success: function(response){
				$('.class_routine_content').html(response);
			}
		});
	}
}
</script>