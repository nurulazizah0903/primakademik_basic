<?php $school_id = school_id(); ?>
<?php $subjects = $this->db->get_where('subjects', array('id' => $param1))->result_array(); ?>
<?php foreach($subjects as $subject){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('subject/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="class"><?php echo get_phrase('class'); ?></label>
            <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required onchange="classWiseSectionForSubjectCreate(this.value)">
                <option value=""><?php echo get_phrase('select_section'); ?></option>
                    <?php
                    $classes = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
                    foreach($classes as $class){
                        ?>
                        <option value="<?php echo $class['id']; ?>" <?php if ($subject['room_id'] == $class['id']): ?> selected <?php endif; ?>><?php echo $class['name']; ?></option>
                    <?php } ?>
            </select>
        </div>

    <?php /*<<div class="form-group col-md-12">
        <label for="section_id_on_creation"><?php echo get_phrase('section'); ?></label>
            <select name="section_id" id = "section_id_on_creation" class="form-control select2" data-toggle="select2"  required onchange="sectionWiseClassroomsOnCreate(this.value)">
                <option value=""><?php echo get_phrase('select_section'); ?></option>
                <?php $sections = $this->db->get_where('sections', array('class_id' => $subject['class_id']))->result_array(); ?>
                <?php foreach($sections as $section): ?>
                <option value="<?php echo $section['id']; ?>" <?php if ($subject['section_id'] == $section['id']): ?> selected <?php endif; ?>><?php echo $section['name']; ?></option>
                <?php endforeach; ?>
            </select>
    </div>

    <?php /*<div class="form-group col-md-12">
        <label for="room_id_on_creation"><?php echo get_phrase('class_rooms'); ?></label>
            <select name="room_id" id="room_id_on_creation" class="form-control select2" data-toggle = "select2" required>
                    <option value=""><?php echo get_phrase('select_class_rooms'); ?></option>
                    <?php
                    $class_rooms = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
                    foreach ($class_rooms as $class_room): ?>
                    <option value="<?php echo $class_room['id']; ?>" <?php if($class_room['id'] == $subject['room_id']){ echo 'selected'; } ?>><?php echo $class_room['name']; ?></option>
                <?php endforeach; ?>
            </select>
    </div>*/ ?>

    <div class="form-group col-md-12">
        <label for="teacher"><?php echo get_phrase('pengajar'); ?></label>
            <select name="teacher_id" id = "teacher_id" class="form-control select2" data-toggle="select2"  required>
                <option value=""><?php echo get_phrase('assign_a_teacher'); ?></option>
                <?php $teachers = $this->db->get_where('teachers', array('school_id' => school_id()))->result_array(); ?>
                <?php foreach($teachers as $teacher): ?>
                    <option value="<?php echo $teacher['id']; ?>" <?php if($subject['teacher_id'] == $teacher['id']) echo 'selected'; ?>><?php echo $this->user_model->get_user_details($teacher['user_id'], 'name'); ?></option>
                <?php endforeach; ?>
          </select>
    </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('subject_name'); ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $subject['name']; ?>" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_subject_name'); ?></small>
        </div>

        <div class="form-group col-md-12">
        <label for="description"><?php echo get_phrase('description'); ?></label>
            <textarea name="description" class="form-control" id="description" cols="5" rows="5"><?= $subject['description'];?></textarea>
    </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSubjects);
});

function classWiseSectionForSubjectCreate(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_on_creation').html(response);
        }
    });
}

function sectionWiseClassroomsOnCreate(sectionId) {
  $.ajax({
    url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
    success: function(response){
      $('#room_id_on_creation').html(response);
    }
  });
}

$(document).ready(function() {
  initSelect2(['#class_id_on_create', '#section_id_on_creation', '#room_id_on_creation', '#teacher_id']);
});
</script>
