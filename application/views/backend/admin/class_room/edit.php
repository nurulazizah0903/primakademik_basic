<?php $class_rooms = $this->db->get_where('class_rooms', array('id' => $param1))->result_array(); ?>
<?php foreach($class_rooms as $class_room){ 
    $sectionies = $this->db->get_where('sections', array('id' => $class_room['section_id']))->row_array();
    ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('class_room/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
        <label for="name"><?php echo get_phrase('class'); ?></label>
        <select name="class_id" id="class_id" class="form-control select2" data-toggle="select2" onchange="classWiseSectionOnCreate(this.value)" required>
            <option value=""><?php echo get_phrase('select_a_class'); ?></option>
            <?php
            $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
            foreach($classes as $class){
              ?>
              <option value="<?php echo $class['id']; ?>" <?php if ($class['id'] == $sectionies['class_id']): ?> selected <?php endif; ?>><?php echo $class['name']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('section'); ?></label>
            <select name="section_id" id="section_id" class="form-control select2" data-toggle="select2" required>
            <option value=""><?php echo get_phrase('select_section'); ?></option>
            <?php $sections = $this->db->get_where('sections', array('class_id' => $sectionies['class_id']))->result_array(); ?>
            <?php foreach($sections as $section): ?>
            <option value="<?php echo $section['id']; ?>" <?php if ($section['id'] == $class_room['section_id']): ?> selected <?php endif; ?>><?php echo $section['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('class_room_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $class_room['name']; ?>" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_class_room_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="description"><?php echo get_phrase('class_room_description'); ?></label>
            <textarea name="description" class="form-control" id="description" rows="5" required><?php echo $class_room['description']; ?></textarea>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_class_room_description'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_class_room'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
function classWiseSectionOnCreate(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
            classWiseStudentOnCreate(classId);
        }
    });
}

$(document).ready(function () {
  initSelect2(['#class_id', '#section_id']);
});


$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllClassRooms);
});
</script>
