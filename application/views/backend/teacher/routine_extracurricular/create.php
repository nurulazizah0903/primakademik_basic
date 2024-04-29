<form method="POST" class="d-block ajaxForm" action="<?php echo route('routine_extracurricular/create'); ?>" style="min-width: 300px;">
    <?php $school_id = school_id(); ?>
    <div class="form-group row">
        <label for="class_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('organizations'); ?></label>
        <div class="col-md-9">
            <select name="organizations_id" id="class_on_routine_creation" class="form-control select2" data-toggle="select2"  required>
                <option value=""><?php echo get_phrase('select_organizations'); ?></option>
                <?php $organizations = $this->db->get_where('organizations', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($organizations as $organization): ?>
                    <option value="<?php echo $organization['id']; ?>"><?php echo $organization['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="teacher" class="col-md-3 col-form-label"><?php echo get_phrase('mentor'); ?></label>
        <div class="col-md-9">
            <select name="teacher_id" id = "teacher_on_routine_creation" class="form-control select2" data-toggle="select2"  required>
                <option value=""><?php echo get_phrase('assign_a_mentor'); ?></option>
                <?php $teachers = $this->db->get_where('teachers', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['id']; ?>"><?php echo $this->user_model->get_user_details($teacher['user_id'], 'name'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
    <div class="col-lg-4">
        <input type="checkbox" name="day[]" id="day_on_routine_creation" value="Sunday">
            <label><?php echo get_phrase('sunday'); ?></label><br>
    </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_start'); ?></label>
            <input type="time" class="form-control" name="time_start[]" value="00:00:00">
        </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_finish'); ?></label>
            <input type="time" class="form-control" name="time_finish[]" value="00:00:00">
        </div>
    </div>

    <div class="form-group row">
    <div class="col-lg-4">
        <input type="checkbox" name="day[]" id="day_on_routine_creation" value="Monday">
            <label><?php echo get_phrase('monday'); ?></label><br>
    </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_start'); ?></label>
            <input type="time" class="form-control" name="time_start[]" value="00:00:00">
        </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_finish'); ?></label>
            <input type="time" class="form-control" name="time_finish[]" value="00:00:00">
        </div>
    </div>

    <div class="form-group row">
    <div class="col-lg-4">
        <input type="checkbox" name="day[]" id="day_on_routine_creation" value="Tuesday">
            <label><?php echo get_phrase('tuesday'); ?></label><br>
    </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_start'); ?></label>
            <input type="time" class="form-control" name="time_start[]" value="00:00:00">
        </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_finish'); ?></label>
            <input type="time" class="form-control" name="time_finish[]" value="00:00:00">
        </div>
    </div>
    <div class="form-group row">
    <div class="col-lg-4">
        <input type="checkbox" name="day[]" id="day_on_routine_creation" value="Wednesday">
            <label><?php echo get_phrase('wednesday'); ?></label><br>
    </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_start'); ?></label>
            <input type="time" class="form-control" name="time_start[]" value="00:00:00">
        </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_finish'); ?></label>
            <input type="time" class="form-control" name="time_finish[]" value="00:00:00">
        </div>
    </div>
    <div class="form-group row">
    <div class="col-lg-4">
       <input type="checkbox" name="day[]" id="day_on_routine_creation" value="Thursday">
            <label><?php echo get_phrase('thursday'); ?></label><br>
    </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_start'); ?></label>
            <input type="time" class="form-control" name="time_start[]" value="00:00:00">
        </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_finish'); ?></label>
            <input type="time" class="form-control" name="time_finish[]" value="00:00:00">
        </div>
    </div>
    <div class="form-group row">
    <div class="col-lg-4">
        <input type="checkbox" name="day[]" id="day_on_routine_creation" value="Friday">
            <label><?php echo get_phrase('friday'); ?></label><br>
    </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_start'); ?></label>
            <input type="time" class="form-control" name="time_start[]" value="00:00:00">
        </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_finish'); ?></label>
            <input type="time" class="form-control" name="time_finish[]" value="00:00:00">
        </div>
    </div>
    <div class="form-group row">
    <div class="col-lg-4">
        <input type="checkbox" name="day[]" id="day_on_routine_creation" value="Saturday">
            <label><?php echo get_phrase('saturday'); ?></label><br>
    </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_start'); ?></label>
            <input type="time" class="form-control" name="time_start[]" value="00:00:00">
        </div>
        <div class="col-lg-4">
        <label for="starting_hour"><?php echo get_phrase('time_finish'); ?></label>
            <input type="time" class="form-control" name="time_finish[]" value="00:00:00">
        </div>
    </div>
    </div>

    <div class="form-group col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_routine_extracurricular'); ?></button>
    </div>
</form>

<script>
$(document).ready(function () {
    initSelect2(['#class_on_routine_creation',
    '#teacher_on_routine_creation',
    '#day_on_routine_creation',
    '#day1_on_routine_creation']);
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, getFilteredRoutineExtracurricular);
});
</script>