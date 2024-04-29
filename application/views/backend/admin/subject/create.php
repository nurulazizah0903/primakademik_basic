<form method="POST" class="d-block ajaxForm" action="<?php echo route('subject/create'); ?>">
  <div class="form-row">

    <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
    <input type="hidden" name="session" value="<?php echo active_session();?>">

    <div class="form-group col-md-12">
      <label for="class_id_on_create"><?php echo get_phrase('section'); ?></label>
      <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required >
        <option value=""><?php echo get_phrase('select_section'); ?></option>
          <?php
          $classes = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
          foreach($classes as $class){
            ?>
            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
          <?php } ?>
      </select>
    </div>

    <div class="form-group col-md-12">
      <label for="section_id_on_creation"><?php echo get_phrase('section'); ?></label>
      <select name="section_id" id = "section_id_on_creation" class="form-control select2" data-toggle="select2"  required onchange="sectionWiseClassroomsOnCreate(this.value)">
        <option value=""><?php echo get_phrase('select_section'); ?></option>
      </select>
    </div>

    <?php /*<div class="form-group col-md-12">
        <label for="room_id"><?php echo get_phrase('class_rooms'); ?></label>
            <select name="room_id" id="room_id_on_creation" class="form-control select2" data-toggle = "select2" required>
            <option value=""><?php echo get_phrase('select_class_room'); ?></option>
            </select>
    </div> */?>

    <div class="form-group col-md-12">
      <label for="name"><?php echo get_phrase('subject_name'); ?></label>
      <input type="text" class="form-control" id="name" name="name" required>
    </div>

    <div class="form-group col-md-12">
      <label for="teacher"><?php echo get_phrase('pengajar'); ?></label>
      <select name="teacher_id" id = "teacher_id" class="form-control select2" data-toggle="select2"  required>
        <option value=""><?php echo get_phrase('assign_a_teacher'); ?></option>
        <?php $teachers = $this->db->get_where('teachers', array('school_id' => school_id()))->result_array(); ?>
        <?php foreach($teachers as $teacher): ?>
          <option value="<?php echo $teacher['id']; ?>"><?php echo $this->user_model->get_user_details($teacher['user_id'], 'name'); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
                      
    <div class="form-group col-md-12">
      <label for="description"><?php echo get_phrase('description'); ?></label>
      <textarea name="description" class="form-control" id="description" cols="5" rows="5"></textarea>
    </div>

    <div class="form-group  col-md-12">
      <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_subject'); ?></button>
    </div>
  </div>
</form>

<script>
$(document).ready(function () {

initSelect2(['#class_id_on_creation',
'#section_id_on_creation', '#room_id_on_creation', '#teacher_id']);

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

  $(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

$(document).ready(function() {
  initSelect2(['#class_id_on_create']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllSubjects);
});
</script>
