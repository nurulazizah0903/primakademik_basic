<?php 
$school_id = school_id();
$profile_data = $this->user_model->get_profile_data();
$enrols = $this->db->get_where('enrols', array('student_id' => $param1))->row_array();
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('violations/create_routine'); ?>">
    <input type="hidden" name="class_id" value="<?= $enrols['class_id'];?>">
    <input type="hidden" name="section_id" value="<?= $enrols['section_id'];?>">
    <input type="hidden" name="room_id" value="<?= $enrols['room_id'];?>">
    <input type="hidden" name="student_id" value="<?= $enrols['student_id'];?>">
    <input type="hidden" name="teacher_id" value="<?= $profile_data['id'];?>">

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="date"><?php echo get_phrase('date_counseling'); ?></label>
        <div class="col-md-9">
            <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="routine_start"><?php echo get_phrase('time_counseling'); ?></label>
        <div class="col-md-9">
            <input type="time" class="form-control" id="routine_start" name = "routine_start" required value="00:00:00">
            </div>
    </div>

    <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
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
</script>
