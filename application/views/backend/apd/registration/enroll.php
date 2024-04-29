<?php
$school_id = school_id();
$registrations = $this->db->get_where('registrations', array('id' => $param1))->result_array();
foreach ($registrations as $item)
?>
  <form method="POST" class="d-block ajaxForm" action="<?php echo route('registration/ppdb_enroll_single_student'); ?>">
    <div class="form-row">
      <input type="hidden" name="registrasi_id" value="<?php echo $item['id']; ?>">
      <!-- START SELECT -->
      <div class="form-group col-md-12">
        <label for="class_id"><?php echo get_phrase('class'); ?></label>
        <select required name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" onchange="classWiseSection(this.value)" required>
          <option value=""><?php echo get_phrase('select_a_class'); ?></option>
          <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
          <?php foreach($classes as $class){ ?>
              <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group col-md-12">
        <label for="section_id"><?php echo get_phrase('section') ?></label>
        <select required name="section_id" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="sectionWiseClassroomsOnCreate(this.value)">
          <option value=""><?php echo get_phrase('select_section'); ?></option>
        </select>
      </div>
      <div class="form-group col-md-12">
        <label for="room_id"><?php echo get_phrase('class_rooms'); ?></label>
        <select name="room_id" id="room_id" class="form-control select2" data-toggle = "select2" required>
          <option value=""><?php echo get_phrase('select_class_rooms'); ?></option>
        </select>
      </div>

      <!-- END SELECT -->
        <button class="btn btn-primary" type="submit"><?php echo get_phrase('enroll') ?></button>
    </div>
  </form>

<script>
  function sectionWiseClassroomsOnCreate(sectionId) {
    $.ajax({
        url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
        success: function(response){
        $('#room_id').html(response);
        }
    });
    }

$(document).ready(function () {
  initSelect2(['#room_id', '#section_id', '#class_id', '#show_on_website']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, showAllAdmittedStudents);
  location.reload();
});

//   var form = $(this);
//   var url = form.attr('action');

//   $.ajax({
//         type: "POST",
//         url: url,
//         data: form.serialize(),
//         success: function(data) {
//           showAllAdmittedStudents(data);
//         },
//       });
// });

// initCustomFileUploader();
</script>
