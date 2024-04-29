<?php $routine_counseling_details = $this->crud_model->get_routine_counseling_issue_by_id($param1); ?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('routine_counseling/update/'.$param1); ?>">
<div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="date"><?php echo get_phrase('date_counseling'); ?></label>
        <div class="col-md-9">
            <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="<?php echo date('m/d/Y', $routine_counseling_details['date']); ?>" required>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="routine_start"><?php echo get_phrase('time_counseling'); ?></label>
        <div class="col-md-9">
            <input type="time" class="form-control" id="routine_start" name = "routine_start" value="<?php echo $routine_counseling_details['routine_start']; ?>" required>
            </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="student_id"> <?php echo get_phrase('name'); ?></label>
        <div class="col-md-9">
        <select name="student_id" id="student_id_on_modal" class="form-control select2" data-toggle="select2" required >
          <option value=""><?php echo get_phrase('select_a_student'); ?></option>
          <?php $students = $this->user_model->get_students()->result_array(); 
          foreach($students as $student){ ?>
          <option value="<?php echo $student['id']; ?>" <?php if($student['id'] == $routine_counseling_details['student_id']) echo 'selected'; ?>><?php echo $student['nisn']; ?> - <?php echo $this->db->get_where('users', array('id' => $student['user_id']))->row('name'); ?></option>
        <?php } ?>
        </select>
        </div>
    </div>

    <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="teacher_id"> <?php echo get_phrase('mentor'); ?></label>
    <div class="col-md-9">
        <select name="teacher_id" id="teacher_id" class="form-control select2" data-toggle="select2" required>
        <option value=""><?php echo get_phrase('select_mentor'); ?></option>
        <?php
        $teachers = $this->db->get_where('users', array('role' => "teacher"))->result_array();
        foreach ($teachers as $teacher): ?>
        <option value="<?php echo $teacher['id']; ?>" <?php if ($routine_counseling_details['teacher_id'] == $teacher['id']): ?>selected<?php endif; ?>><?php echo $teacher['nip']; ?> - <?php echo $teacher['name']; ?></option>
        <?php endforeach; ?>
    </select>
    </div>
    </div>

<div class="form-group  col-md-12">
  <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
</div>
</form>

<script>
$(document).ready(function() {
  $('#issue_date').daterangepicker();
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, getFilteredClassRoutine);
});

$(document).ready(function () {
  initSelect2(['#student_id_on_modal', '#class_id_on_modal', '#section_id_on_modal', '#teacher_id', '#room_id']);
});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_on_modal').html(response);
            classWiseStudent(classId);
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

function classWiseStudent(classId) {
  $.ajax({
    url: "<?php echo route('marks_archives/student/'); ?>"+classId,
    success: function(response){
      $('#student_id_on_modal').html(response);
    }
  });
}
</script>
