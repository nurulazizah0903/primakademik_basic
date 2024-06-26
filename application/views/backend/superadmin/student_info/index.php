<!--title-->
<div class="row ">
  <div class="col-xl-12 d-print-none">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
		    <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('manage_student_info'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="mt-3 row">
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
					<div class="col-md-2 mb-1">
                        <select name="student_id" id="student_id" class="form-control select2" data-toggle = "select2" required>
                            <option value=""><?php echo get_phrase('select_student'); ?></option>
                        </select>
                    </div>
				<div class="col-md-2">
					<button class="btn btn-block btn-secondary" onclick="filter_student()" ><?php echo get_phrase('filter'); ?></button>
				</div>
			</div>
			<div class="card-body student_info_content">
			<div class="empty_box">
                        <img class="mb-3" width="150px" src="<?php echo base_url('assets/backend/images/empty_box.png'); ?>" />
                        <br>
                        <span class=""><?php echo get_phrase('no_data_found'); ?></span>
                    </div>
			</div>
		</div>
	</div>
</div>

<script>
$('document').ready(function(){
    initSelect2(['#student_id']);
});

function filter_student(){
	var student_id = $('#student_id').val();
	if(student_id != ""){
		getFilteredStudentInfo();
	}else{
		toastr.error('<?php echo get_phrase('please_select_a_field'); ?>');
	}
}

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

var getFilteredStudentInfo = function() {
	var student_id = $('#student_id').val();
	if(student_id != ""){
		$.ajax({
			url: '<?php echo route('student_info/student_info/') ?>'+student_id,
			success: function(response){
                // console.log(student_id);
				$('.student_info_content').html(response);
			}
		});
	}
}
</script>