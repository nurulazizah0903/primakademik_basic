<?php
$school_id = school_id();
$active_session = active_session();
if(isset($class_id) && $class_id != ''){
  $this->db->where('class_id', $class_id);
}
if(isset($section_id) && $section_id != ''){
  $this->db->where('section_id', $section_id);
}
// if(isset($room_id) && $room_id != ''){
//   $this->db->where('room_id', $room_id);
// }
$this->db->where('school_id', $school_id);
// $this->db->where('session', $active_session);
$enrols = $this->db->get('enrols')->result_array();
// $enrols = $this->db->get_where('enrols', array('school_id' => $school_id, 'session' => active_session()))->result_array();
if (count($enrols) > 0): 
?>
<form method="POST" action="<?= route('student/move_students') ?>" class="ajaxForm" id="move_students_form">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="table-responsive">
        <table id="example" class="table table-striped dt-responsive nowrap" width="100%">
          <thead>
            <tr style="background-color: #313a46; color: #ababab;">
              <th>No</th>
              <th><input type="checkbox"  id="checkedAll"> <?php echo get_phrase('select_all'); ?></th>
              <!-- <th><?php echo get_phrase('session'); ?></th> -->
              <th><?php echo get_phrase('name'); ?></th>
              <th><?php echo get_phrase('nis'); ?></th>
              <th><?php echo get_phrase('nisn'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i=1;
            foreach($enrols as $enroll){
              $student = $this->db->get_where('students', array('id' => $enroll['student_id']))->row_array();
              $session = $this->db->get_where('sessions', array('id' => $enroll['session']))->row_array();
              ?>
              <tr>
                <td><?= $i; ?> </td>
                <td><input type="checkbox" name="enrol_ids[]" value="<?= $enroll['id'] ?>" class="checkSingle"></td>
                <!-- <td><?php echo $session['name']; ?></td> -->
                <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
                <td><?php echo $student['NIS']; ?></td>
                <td><?php echo $student['nisn']; ?></td>
              </tr>
            <?php 
            $i++;
            } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

  <h5 class="mt-3">
    <?= get_phrase('move_to') ?>:
  </h5>
  <div class="row">
    <div class="col-md-3">
      <select name="session_id" id="move_session_id" class="form-control select2" data-toggle = "select2">
        <option value=""><?php echo get_phrase('select_a_session'); ?></option>
        <?php
        $sessions = $this->db->get('sessions')->result_array();
        foreach($sessions as $session){
        ?>
        <option value="<?php echo $session['id']; ?>" <?php if($session['status'] == 1)echo 'selected'; ?>><?php echo $session['name']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md-3">
      <select name="class_id" id="move_class_id" class="form-control select2" data-toggle = "select2" onchange="classWiseSectionMove(this.value)">
        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
        <?php
        $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
        foreach($classes as $class){
          ?>
        <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="col-md-3">
      <select name="section_id" id="move_section_id" class="form-control select2" data-toggle = "select2" onchange="sectionWiseClassroomsOnCreate(this.value)">>
        <option value=""><?php echo get_phrase('select_section'); ?></option>
      </select>
    </div>
    <div class="col-md-3">
      <select name="room_id" id="move_room_id" class="form-control select2" data-toggle = "select2">
        <option value=""><?php echo get_phrase('select_class_room'); ?></option>
      </select>
    </div>
  </div><br>
  <div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-4">
      <input type="submit" id="submit_move" name="submit_move" onclick="validation(this.id)" class="btn btn-success" value="<?= get_phrase('move_student') ?>" />
    </div>
    <div class="col-md-4">
      <input type="submit" id="submit_alumni" name="submit_alumni" onclick="validation(this.id)" class="btn btn-warning" value="<?= get_phrase('make_alumni') ?>" />
    </div>
  </div>
</form>

<script type="text/javascript">
initDataTable('basic-datatable');
initSelect2(['#move_section_id', '#move_class_id', '#move_session_id', '#move_room_id']);

$(document).ready(function() {
    $("#checkedAll").change(function() {
        if (this.checked) {
            $(".checkSingle").each(function() {
                this.checked=true;
            });
        } else {
            $(".checkSingle").each(function() {
                this.checked=false;
            });
        }
    });
});

function classWiseSectionMove(classId) {
  $.ajax({
    url: "<?php echo route('section/list/'); ?>"+classId+"/"+<?= $section_id ?>,
    success: function(response){
      $('#move_section_id').html(response);
    }
  });
}

function sectionWiseClassroomsOnCreate(sectionId) {
    $.ajax({
        url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
        success: function(response){
        $('#move_room_id').html(response);
        }
    });
    }

var validated = false;
var action = "";
function validation(id) {
  action = id;
  if (action == "submit_move") {
    if ($('#move_session_id').val() == "" || $('#move_class_id').val() == "" || $('move_section_id').val() == "") {
      validated = false;
      toastr.error('<?php echo get_phrase('please_select_the_fields'); ?>');
    } else {
      validated = true;
    }
  } else {
    validated = true;
  }
}

var form;
$(".ajaxForm").submit(function(e) {
  e.preventDefault();
  form = $(this);
  if(validated) {
    var add = {action:action};
    ajaxSubmit(e, form, refreshForm, add);
  }
});
var refreshForm = function () {
  filter_student();
}

$(document).ready(function () {
    $('#example').DataTable({
        paging: false,
        info: false,
    });
});
</script>
