<?php $school_id = school_id(); ?>
<?php $routines = $this->db->get_where('routines', array('id' => $param1))->result_array(); ?>
<?php foreach($routines as $routine): ?>
    <form method="POST" class="d-block ajaxForm" action="<?php echo route('routine/update/'.$param1); ?>" style="min-width: 300px;">
        <div class="form-group row">
            <label for="class_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('class'); ?></label>
            <div class="col-md-9">
                <select name="class_id" id="class_id_on_routine_creation" class="form-control" required onchange="classWiseSectionForRoutineCreate(this.value)">
                    <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                    <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                    <?php foreach($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>" <?php if($routine['class_id'] == $class['id']) echo 'selected'; ?>><?php echo $class['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="section_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('section'); ?></label>
            <div class="col-md-9">
                <select name="section_id" id = "section_id_on_routine_creation" class="form-control" required>
                    <option value=""><?php echo get_phrase('select_a_section'); ?></option>
                    <?php $sections = $this->db->get_where('sections', array('class_id' => $routine['class_id']))->result_array(); ?>
                    <?php foreach($sections as $section): ?>
                        <option value="<?php echo $section['id']; ?>" <?php if($routine['section_id'] == $section['id']) echo 'selected'; ?>><?php echo $section['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="subject_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('subject'); ?></label>
            <div class="col-md-9">
                <select name="subject_id" id = "subject_id_on_routine_creation" class="form-control" required>
                    <option value=""><?php echo get_phrase('select_a_subject'); ?></option>
                    <?php $subjects = $this->db->get_where('subjects', array('class_id' => $routine['class_id'], 'session' => active_session()))->result_array(); ?>
                    <?php foreach($subjects as $subject): ?>
                        <option value="<?php echo $subject['id']; ?>" <?php if($routine['subject_id'] == $subject['id']) echo 'selected'; ?>><?php echo $subject['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="teacher_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('teacher'); ?></label>
            <div class="col-md-9">
                <select name="teacher_id" id = "teacher_on_routine_creation" class="form-control" required>
                    <option value=""><?php echo get_phrase('assign_a_teacher'); ?></option>
                    <?php $teachers = $this->db->get_where('teachers', array('school_id' => $school_id))->result_array(); ?>
                    <?php foreach($teachers as $teacher): ?>
                        <option value="<?php echo $teacher['id']; ?>" <?php if($routine['teacher_id'] == $teacher['id']) echo 'selected'; ?>><?php echo $this->user_model->get_user_details($teacher['user_id'], 'name'); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="class_room_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('class_room'); ?></label>
            <div class="col-md-9">
                <select name="class_room_id" id = "class_room_id_on_routine_creation" class="form-control" required>
                    <option value=""><?php echo get_phrase('select_a_class_room'); ?></option>
                    <?php $class_rooms = $this->db->get_where('class_rooms', array('school_id' => $school_id))->result_array(); ?>
                    <?php foreach($class_rooms as $class_room): ?>
                        <option value="<?php echo $class_room['id']; ?>" <?php if($routine['room_id'] == $class_room['id']) echo 'selected'; ?>><?php echo $class_room['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="day_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('day'); ?></label>
            <div class="col-md-9">
                <select name="day" id = "day_on_routine_creation" class="form-control" required>
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

        <div class="form-group row">
            <label for="time_start" class="col-md-3 col-form-label"><?php echo get_phrase('time_start'); ?></label>
            <div class="col-md-4">
            <input type="time" class="form-control" name="time_start" value="<?=$routine['time_start']?>">
            </div>
        </div>
        
        <div class="form-group row">
            <label for="time_finish" class="col-md-3 col-form-label"><?php echo get_phrase('time_finish'); ?></label>
            <div class="col-md-4">
            <input type="time" class="form-control" name="time_finish" value="<?=$routine['time_finish']?>">
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
