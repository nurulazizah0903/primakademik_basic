<form method="POST" class="d-block ajaxForm" action="<?php echo route('class_room/create'); ?>">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
        <label for="name"><?php echo get_phrase('class'); ?></label>
        <select name="class_id" id="class_id" class="form-control select2" data-toggle="select2" onchange="classWiseSection(this.value)" required>
            <option value=""><?php echo get_phrase('select_a_class'); ?></option>
            <?php
            $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
            foreach($classes as $class){
              ?>
              <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('section'); ?></label>
            <select name="section_id" id="section_id" class="form-control select2" data-toggle="select2" required>
            <option value=""><?php echo get_phrase('select_section'); ?></option>
          </select>
        </div>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('class_room_name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_class_room_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('class_room_description'); ?></label>
            <textarea name="description" class="form-control" id="description" rows="5" required></textarea>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_class_room_description'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_class_room'); ?></button>
        </div>
    </div>
</form>

<script>
$(document).ready(function () {
  initSelect2(['#class_id', '#section_id']);
});

function classWiseSection(classId) {
  $.ajax({
    url: "<?php echo route('section/list/'); ?>"+classId,
    success: function(response){
      $('#section_id').html(response);
    }
  });
}

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllClasses);
});
</script>
