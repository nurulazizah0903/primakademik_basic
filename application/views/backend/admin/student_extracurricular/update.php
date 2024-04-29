<?php 
$student_extracurricular_details = $this->crud_model->get_student_extracurricular_by_id($param1); 
$enrols = $this->db->get_where('enrols', array('student_id' => $param1, 'session' => active_session()))->result_array();
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('student_extracurricular/update/'.$param1.'/'.$enrols[0]['class_id'].'/'.$enrols[0]['section_id'].'/'.$enrols[0]['room_id']); ?>">
<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="class_id"><?php echo get_phrase('class'); ?></label>
    <div class="col-md-9">
      <select name="class_id" id="class_id_on_modal" class="form-control select2" data-toggle="select2"  required onchange="classWiseSectionOnCreate(this.value)" disabled>
        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
        <?php $classes = $this->crud_model->get_classes()->result_array(); ?>
        <?php foreach($classes as $class): ?>
          <option value="<?php echo $class['id']; ?>" <?php if ($enrols[0]['class_id'] == $class['id']): ?> selected <?php endif; ?>><?php echo $class['name']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="section_id"><?php echo get_phrase('section'); ?></label>
    <div class="col-md-9">
      <select name="section_id" id="section_id_on_modal" class="form-control select2" data-toggle="select2"  required onchange="classWiseStudentOnCreate(this.value)" disabled>
        <option value=""><?php echo get_phrase('select_a_section'); ?></option>
        <?php $sections = $this->db->get_where('sections', array('class_id' => $enrols[0]['class_id']))->result_array(); ?>
        <?php foreach($sections as $section): ?>
          <option value="<?php echo $section['id']; ?>" <?php if ($enrols[0]['section_id'] == $section['id']): ?> selected <?php endif; ?>><?php echo $section['name']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="room_id"><?php echo get_phrase('class_rooms'); ?></label>
        <div class="col-md-9">
            <select name="room_id" id="room_id_on_modal" class="form-control select2" data-toggle = "select2" required disabled>
                    <option value=""><?php echo get_phrase('select_class_rooms'); ?></option>
                    <?php
                    $class_rooms = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
                    foreach ($class_rooms as $class_room): ?>
                    <option value="<?php echo $class_room['id']; ?>" <?php if ($enrols[0]['room_id'] == $class_room['id']): ?> selected <?php endif; ?>><?php echo $class_room['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

  <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="student_id"> <?php echo get_phrase('student'); ?></label>
    <div class="col-md-9" id = "student_content">
      <select name="student_id" id="student_id_on_modal" class="form-control select2" data-toggle="select2" required disabled>
        <option value=""><?php echo get_phrase('select_a_student'); ?></option>
        <?php $enrolments = $this->user_model->get_student_details_by_id('class', $enrols[0]['class_id']);
        foreach ($enrolments as $enrolment): ?>
        <option value="<?php echo $enrolment['student_id']; ?>" <?php if ($enrols[0]['student_id'] == $enrolment['student_id']): ?>selected<?php endif; ?>><?php echo $enrolment['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="organizations_id"> <?php echo get_phrase('organizations'); ?></label>
        <div class="col-md-9">
            <?php $organizations = $this->db->get_where('organizations', array('school_id' => school_id()))->result_array();
            foreach($organizations as $organization){
                $extracurricular_id = explode(',', $student_extracurricular_details['organizations_id']); ?>
                <input type="checkbox" name="organizations_id[]" id="organizations_id" value="<?php echo $organization['id']; ?>" <?php foreach($extracurricular_id as $ekstra){  
                    if ($ekstra['organizations_id'] == $organization['id']): ?>checked<?php endif; 

                } ?>>
                <label><?php echo $organization['name']; ?></label><br>
            <?php } ?>
        </div>
    </div>

<div class="form-group  col-md-12">
  <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
</div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllStudentsextracurricular);
});

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

$(document).ready(function () {
  initSelect2(['#class_id_on_modal', '#section_id_on_modal', '#student_id_on_modal', '#room_id_on_modal']);
});

function classWiseSectionOnCreate(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_on_modal').html(response);
            classWiseStudentOnCreate(classId);
        }
    });
}

function classWiseStudentOnCreate(classId) {
  $.ajax({
    url: "<?php echo route('student_extracurricular/student/'); ?>"+classId,
    success: function(response){
      $('#student_id_on_modal').html(response);
    }
  });
}

// function roleWiseOnCreate(role) {
//     $.ajax({
//         url: "<?php echo route('book_issue/role/'); ?>"+role,
//         success: function(response){
//             $('#user_id').html(response);
//             // classWiseStudent(role);
//         }
//     });
// }
</script>
