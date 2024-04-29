<?php 
$school_id = school_id();
$enrols = $this->db->get_where('enrols', array('student_id' => $param1))->row_array();
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('violations/create_routine'); ?>">
    <input type="hidden" name="class_id" value="<?= $enrols['class_id'];?>">
    <input type="hidden" name="section_id" value="<?= $enrols['section_id'];?>">
    <input type="hidden" name="room_id" value="<?= $enrols['room_id'];?>">
    <input type="hidden" name="student_id" value="<?= $enrols['student_id'];?>">

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

    <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="teacher_id"> <?php echo get_phrase('mentor'); ?></label>
    <div class="col-md-9">
        <select name="teacher_id" id="teacher_id" class="form-control select2"  data-toggle = "select2" required>
        <option value=""><?php echo get_phrase('select_mentor'); ?></option>
        <?php
        $teachers = $this->db->get_where('users', array('role' => "teacher"))->result_array();
        foreach ($teachers as $teacher): ?>
        <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['nip']; ?> - <?php echo $teacher['name']; ?></option>
        <?php endforeach; ?>
    </select>
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

$(document).ready(function () {
  initSelect2(['#teacher_id']);
});

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}
</script>
