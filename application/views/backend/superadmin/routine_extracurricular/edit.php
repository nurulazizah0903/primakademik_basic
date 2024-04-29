<?php $school_id = school_id(); ?>
<?php $routine_extracurriculars = $this->db->get_where('routine_extracurricular', array('id' => $param1))->result_array(); ?>
<?php foreach($routine_extracurriculars as $routine_extracurricular): ?>
    <form method="POST" class="d-block ajaxForm" action="<?php echo route('routine_extracurricular/update/'.$param1); ?>" style="min-width: 300px;">
        <div class="form-group row">
            <label for="class_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('class'); ?></label>
            <div class="col-md-8">
                <select name="organizations_id" id="class_on_routine_creation" class="form-control select2" data-toggle="select2"  required>
                    <option value=""><?php echo get_phrase('select_organizations'); ?></option>
                    <?php $organizations = $this->db->get_where('organizations', array('school_id' => $school_id))->result_array(); ?>
                    <?php foreach($organizations as $organization): ?>
                        <option value="<?php echo $organization['id']; ?>" <?php if($routine_extracurricular['organizations_id'] == $organization['id']) echo 'selected'; ?>><?php echo $organization['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="teacher_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('mentor'); ?></label>
            <div class="col-md-8">
                <select name="teacher_id" id = "teacher_on_routine_creation" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('assign_a_mentor'); ?></option>
                    <?php $teachers = $this->db->get_where('teachers', array('school_id' => $school_id))->result_array(); ?>
                    <?php foreach($teachers as $teacher): ?>
                        <option value="<?php echo $teacher['id']; ?>" <?php if($routine_extracurricular['teacher_id'] == $teacher['id']) echo 'selected'; ?>><?php echo $this->user_model->get_user_details($teacher['user_id'], 'name'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="day_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('day'); ?></label>
            <div class="col-md-8">
                <select name="day" id = "day_on_routine_creation" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('select_a_day'); ?></option>
                    <option value="Sunday" <?php if($routine_extracurricular['day'] == 'Sunday') echo 'selected'; ?>><?php echo get_phrase('sunday'); ?></option>
                    <option value="Monday" <?php if($routine_extracurricular['day'] == 'Monday') echo 'selected'; ?>><?php echo get_phrase('monday'); ?></option>
                    <option value="Tuesday" <?php if($routine_extracurricular['day'] == 'Tuesday') echo 'selected'; ?>><?php echo get_phrase('tuesday'); ?></option>
                    <option value="Wednesday" <?php if($routine_extracurricular['day'] == 'Wednesday') echo 'selected'; ?>><?php echo get_phrase('wednesday'); ?></option>
                    <option value="Thursday" <?php if($routine_extracurricular['day'] == 'Thursday') echo 'selected'; ?>><?php echo get_phrase('thursday'); ?></option>
                    <option value="Friday" <?php if($routine_extracurricular['day'] == 'Friday') echo 'selected'; ?>><?php echo get_phrase('friday'); ?></option>
                    <option value="Saturday" <?php if($routine_extracurricular['day'] == 'Saturday') echo 'selected'; ?>><?php echo get_phrase('saturday'); ?></option>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="hour_id" class="col-md-3 col-form-label"><?php echo get_phrase('operational_hour'); ?></label>
            <div class="col-md-8">
                <select name="hour_id" id = "hour_id" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('select_a_time'); ?></option>
                    <?php $operational_hours = $this->db->get_where('operational_hour', array('school_id' => $school_id))->result_array(); ?>
                    <?php foreach($operational_hours as $operational_hour): ?>
                        <option value="<?php echo $operational_hour['id']; ?>" <?php if($routine_extracurricular['hour_id'] == $operational_hour['id']) echo 'selected'; ?>><?php echo $operational_hour['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_routine_extracurricular'); ?></button>
        </div>
    </form>
<?php endforeach; ?>


<script>
$(document).ready(function () {
    initSelect2(['#hour_id',
    '#teacher_on_routine_creation',
    '#day_on_routine_creation']);
});

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, getFilteredRoutineExtracurricular);
});
</script>
