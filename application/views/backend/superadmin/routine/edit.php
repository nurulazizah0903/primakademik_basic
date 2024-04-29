<?php $school_id = school_id(); ?>
<?php $routines = $this->db->get_where('routines', array('id' => $param1))->result_array(); ?>
<?php foreach($routines as $routine): ?>
    <form method="POST" class="d-block ajaxForm" action="<?php echo route('routine/update/'.$param1); ?>" style="min-width: 300px;">

        <div class="form-group row">
            <label for="subject_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('subject'); ?></label>
            <div class="col-md-9">
                <select name="subject_id" id = "subject_id_on_routine_creation" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('select_a_subject'); ?></option>
                    <?php $subjects = $this->db->get_where('subjects', array('class_id' => $routine['class_id'], 'session' => active_session()))->result_array(); ?>
                    <?php foreach($subjects as $subject): ?>
                        <option value="<?php echo $subject['id']; ?>" <?php if($routine['subject_id'] == $subject['id']) echo 'selected'; ?>><?php echo $subject['name']; ?> - <?php echo $this->db->get_where('class_rooms', array('id' => $subject['room_id']))->row('name');?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="class_room_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('select_a_time'); ?></label>
            <div class="col-md-9">
                <select name="hour_id" id = "class_room_id_on_routine_creation" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('select_a_time'); ?></option>
                    <?php $operational_hours = $this->db->get_where('operational_hour', array('school_id' => $school_id))->result_array(); ?>
                    <?php foreach($operational_hours as $operational_hour): ?>
                        <option value="<?php echo $operational_hour['id']; ?>" <?php if($routine['hour_id'] == $operational_hour['id']) echo 'selected'; ?>><?php echo $operational_hour['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="day_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('day'); ?></label>
            <div class="col-md-9">
                <select name="day" id = "day_on_routine_creation" class="form-control select2" required>
                    <option value=""><?php echo get_phrase('select_a_day'); ?></option>
                    <option value="Sunday" <?php if($routine['day'] == 'Sunday') echo 'selected'; ?>><?php echo get_phrase('sunday'); ?></option>
                    <option value="Monday" <?php if($routine['day'] == 'Monday') echo 'selected'; ?>><?php echo get_phrase('monday'); ?></option>
                    <option value="Tuesday" <?php if($routine['day'] == 'Tuesday') echo 'selected'; ?>><?php echo get_phrase('tuesday'); ?></option>
                    <option value="Wednesday" <?php if($routine['day'] == 'Wednesday') echo 'selected'; ?>><?php echo get_phrase('wednesday'); ?></option>
                    <option value="Thursday" <?php if($routine['day'] == 'Thursday') echo 'selected'; ?>><?php echo get_phrase('thursday'); ?></option>
                    <option value="Friday" <?php if($routine['day'] == 'Friday') echo 'selected'; ?>><?php echo get_phrase('friday'); ?></option>
                    <option value="Saturday" <?php if($routine['day'] == 'Saturday') echo 'selected'; ?>><?php echo get_phrase('saturday'); ?></option>
                </select>
            </div>
        </div>

        <div class="form-group col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_class_routine'); ?></button>
        </div>
    </form>
<?php endforeach; ?>


<script>
$(document).ready(function () {
    initSelect2(['#class_id_on_routine_creation',
    '#section_id_on_routine_creation',
    '#subject_id_on_routine_creation',
    '#teacher_on_routine_creation',
    '#class_room_id_on_routine_creation',
    '#day_on_routine_creation']);
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, getFilteredClassRoutine);
    location.reload();
});

function classWiseSectionForRoutineCreate(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_on_routine_creation').html(response);
            classWiseSubjectForRoutineCreate(classId);
        }
    });
}

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

function classWiseSubjectForRoutineCreate(classId) {
    $.ajax({
        url: "<?php echo route('class_wise_subject/'); ?>"+classId,
        success: function(response){
            console.log("<?php echo route('class_wise_subject/'); ?>"+classId);
            $('#subject_id_on_routine_creation').html(response);
        }
    });
}
</script>
