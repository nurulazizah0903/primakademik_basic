<?php $school_id = school_id(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('routine_counseling/create'); ?>">
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
        <label class="col-md-3 col-form-label" for="class_id"><?php echo get_phrase('class'); ?></label>
        <div class="col-md-9">
        <select name="class_id" id="class_id_on_modal" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
            <option value=""><?php echo get_phrase('select_a_class'); ?></option>
            <?php
            $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
            foreach($classes as $class){
                ?>
                <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
            <?php } ?>
        </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="section_id"><?php echo get_phrase('section'); ?></label>
        <div class="col-md-9">
        <select name="section_id" id="section_id_on_modal" class="form-control select2" data-toggle = "select2" required onchange="classWiseStudent(this.value)">
            <option value=""><?php echo get_phrase('select_section'); ?></option>
        </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="room_id"><?php echo get_phrase('class_rooms'); ?></label>
        <div class="col-md-9">
            <select name="room_id" id="room_id_on_modal" class="form-control select2" data-toggle = "select2" required>
                    <option value=""><?php echo get_phrase('select_class_rooms'); ?></option>
                    <?php
                    $class_rooms = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
                    foreach ($class_rooms as $class_room): ?>
                    <option value="<?php echo $class_room['id']; ?>"><?php echo $class_room['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="student_id"> <?php echo get_phrase('name'); ?></label>
        <div class="col-md-9">
        <select name="student_id" id="student_id_on_modal" class="form-control select2" data-toggle="select2" required >
            <option value=""><?php echo get_phrase('select_a_student'); ?></option>
        </select>
        </div>
    </div>

    <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="teacher_id"> <?php echo get_phrase('mentor'); ?></label>
    <div class="col-md-9">
        <select name="teacher_id" id="teacher_id" class="form-control" required>
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
  ajaxSubmit(e, form, getFilteredClassRoutine);
});

$(document).ready(function () {
  initSelect2(['#student_id_on_modal', '#class_id_on_modal', '#section_id_on_modal', '#teacher_id', '#room_id_on_modal']);
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

function classWiseStudent(classId) {
  $.ajax({
    url: "<?php echo route('marks_archives/student/'); ?>"+classId,
    success: function(response){
      $('#student_id_on_modal').html(response);
    }
  });
}
</script>
