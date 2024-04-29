<?php 
$violations = $this->crud_model->get_violations_by_id($param1); 
$enrols = $this->db->get_where('enrols', array('student_id' => $violations['student_id'], 'session' => active_session()))->result_array();
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('violations/update/'.$param1); ?>">
<div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="date"><?php echo get_phrase('date'); ?></label>
        <div class="col-md-9">
          <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="<?php echo date('m/d/Y', $violations['date']); ?>" required>
        </div>
    </div>

<div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="class_id"><?php echo get_phrase('class'); ?></label>
    <div class="col-md-9">
      <select name="class_id" id="class_id_on_modal" class="form-control select2" data-toggle="select2"  required onchange="classWiseSectionOnCreate(this.value)">
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
      <select name="section_id" id="section_id_on_modal" class="form-control select2" data-toggle="select2"  required onchange="classWiseStudentOnCreate(this.value), sectionWiseClassroomsOnCreate(this.value)">
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
            <select name="room_id" id="room_id" class="form-control select2" data-toggle = "select2" required>
              <option value=""><?php echo get_phrase('select_class_rooms'); ?></option>
              <?php $class_rooms = $this->db->get_where('class_rooms', array('id' => $enrols[0]['room_id']))->result_array(); ?>
              <?php foreach($class_rooms as $class_room): ?>
                <option value="<?php echo $class_room['id']; ?>" <?php if ($enrols[0]['room_id'] == $class_room['id']): ?> selected <?php endif; ?>><?php echo $class_room['name']; ?></option>
              <?php endforeach; ?>
            </select>
        </div>
    </div>

  <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="student_id"> <?php echo get_phrase('student'); ?></label>
    <div class="col-md-9" id = "student_content">
      <select name="student_id" id="student_id_on_modal" class="form-control select2" data-toggle="select2" required>
        <option value=""><?php echo get_phrase('select_a_student'); ?></option>
        <?php $enrolments = $this->user_model->get_student_details_by_id('class', $enrols[0]['class_id']);
        foreach ($enrolments as $enrolment): ?>
        <option value="<?php echo $enrolment['student_id']; ?>" <?php if ($enrols[0]['student_id'] == $enrolment['student_id']): ?>selected<?php endif; ?>><?php echo $enrolment['name']; ?></option>
      <?php endforeach; ?>
    </select>
  </div>
</div>

<div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="award_id"><?php echo get_phrase('mistakes'); ?></label>
        <div class="col-md-9">
            <select name="mistake_id" id="mistake_id" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_a_mistakes'); ?></option>
                <?php $mistakes = $this->db->get_where('mistakes', array('school_id' => school_id()))->result_array(); ?>
                <?php foreach($mistakes as $mistake){ ?>
                    <option value="<?php echo $mistake['id']; ?>" <?php if ($violations['mistake_id'] == $mistake['id']): ?>selected<?php endif; ?>><?php echo $mistake['name']; ?> - <?php echo $mistake['point']; ?> <?php echo get_phrase('point'); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="description"> <?php echo get_phrase('description'); ?></label>
        <div class="col-md-9">
            <textarea class="form-control" name="description" id="description" rows="3"><?php echo $violations['description']; ?></textarea>
        </div>
    </div>

<div class="form-group  col-md-12">
  <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
</div>
</form>

<script>
$(document).ready(function() {
  $('#date').daterangepicker();
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllViolations);
});

$(document).ready(function () {
  initSelect2(['#class_id_on_modal', '#section_id_on_modal', '#student_id_on_modal', '#mistake_id', '#room_id']);
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
