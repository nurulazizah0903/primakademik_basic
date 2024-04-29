<?php $student_lists = $this->user_model->get_student_list(); ?>
<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('partner_ledger'); ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end page title -->

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
        <div class="row mt-3">

			<?php /*  
			<div class="col-md-3 mb-1"></div>
				<div class="col-md-4 mb-1">
					<select name="student_id" id="student_id" class="form-control select2" data-toggle="select2" required >
						<option value=""><?php echo get_phrase('select_a_student'); ?></option>
						<?php foreach ($student_lists as $student_list): ?>
							<option value="<?php echo $student_list['id']; ?>"><?php echo $student_list['name']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<!-- <input type="hidden" name="class_id" id="class_id" value="">
				<input type="hidden" name="secion_id" id="section_id" value=""> -->
				<div class="col-md-2">
					<button class="btn btn-block btn-secondary" onclick="filter_class_partner_ledger()" ><?php echo get_phrase('filter'); ?></button>
				</div>
			</div>
			*/ ?> 
			<div class="col-md-1 mb-1"></div>
			<div class="col-md-2 mb-1">
				<select name="class" id="class_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
					<option value=""><?php echo get_phrase('select_a_class'); ?></option>
					<?php
					$classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
					foreach($classes as $class){
						?>
						<option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-md-2 mb-1">
				<select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseStudentOnCreate(this.value), sectionWiseClassroomsOnCreate(this.value)">
					<option value=""><?php echo get_phrase('select_section'); ?></option>
				</select>
			</div>
			<div class="col-md-2 mb-1">
				<select name="room" id="room_id" class="form-control select2" data-toggle = "select2" required>
					<option value=""><?php echo get_phrase('select_class_room'); ?></option>
				</select>
			</div>
			<div class="col-md-3">
				<select name="student_id" id="student_id" class="form-control select2" data-toggle = "select2" required>
					<option value=""><?php echo get_phrase('select_student'); ?></option>
				</select>
			</div>
			<div class="col-md-1">
				<button class="btn btn-block btn-secondary" onclick="filter_class_partner_ledger()" ><span><i class="dripicons-search"></i></span></button>
			</div> 

			<div class="card-body partner_ledger_content">
				<?php include 'list.php'; ?>
             </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script>

$('document').ready(function(){
	initSelect2(['#student_id']);
});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}

function sectionWiseClassroomsOnCreate(sectionId) {
    $.ajax({
        url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
        success: function(response){
        $('#room_id').html(response);
        }
    });
}

function classWiseStudentOnCreate(classId) {
  $.ajax({
    url: "<?php echo route('student_extracurricular/student/'); ?>"+classId,
    success: function(response){
      $('#student_id').html(response);
    }
  });
} 

function filter_class_partner_ledger(){
	var student_id = $('#student_id').val();
	if(student_id != ""){
		getFilteredClasspartner_ledger();
	}else{
		toastr.error('<?php echo get_phrase('please_select_a_student'); ?>');
	}
}

var getFilteredClasspartner_ledger = function() {
	var student_id = $('#student_id').val();
	if(student_id != ""){
		$.ajax({
			url: '<?php echo route('partner_ledger/list/') ?>'+student_id,
			success: function(response){
				$('.partner_ledger_content').html(response); 
			}
		});
	}
}
 

</script>