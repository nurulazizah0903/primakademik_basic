<?php
$school_id = school_id();
$active_session = active_session();

if(isset($keyword) && $keyword != ''){

  if(isset($class_id) && $class_id != ''){
    $this->db->where('enrols.class_id', $class_id);
  }
  if(isset($section_id) && $section_id != ''){
    $this->db->where('enrols.section_id', $section_id);
  }
  if(isset($room_id) && $room_id != ''){
    $this->db->where('enrols.room_id', $room_id);
  }
  $this->db->where('enrols.school_id', $school_id);

  $this->db->like('users.name', $keyword);
  $this->db->or_like('students.nis', $keyword);
  $this->db->or_like('students.nisn', $keyword);

  $this->db->join('enrols', 'students.id = enrols.student_id');
  $this->db->join('users', 'students.user_id = users.id');
  // $this->db->where('session', $active_session);
  $enrols = $this->db->get('students')->result_array();

} else {

  if(isset($class_id) && $class_id != ''){
    $this->db->where('class_id', $class_id);
  }
  if(isset($section_id) && $section_id != ''){
    $this->db->where('section_id', $section_id);
  }
  if(isset($room_id) && $room_id != ''){
    $this->db->where('room_id', $room_id);
  }
  $this->db->where('school_id', $school_id);
  // $this->db->where('session', $active_session);
  $enrols = $this->db->get('enrols')->result_array();

}
// $enrols = $this->db->get_where('enrols', array('school_id' => $school_id, 'session' => active_session()))->result_array();
if (count($enrols) > 0): 
?>
<!-- <form method="POST" action="<?= route('student/delete_student') ?>" class="ajaxForm" id="delete_student"> -->
<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="table-responsive">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%"> 
        <thead>
          <tr style="background-color: #313a46; color: #ababab;">
            <th width = 25%><?php echo get_phrase('nis'); ?></th>
            <th width = 25%><?php echo get_phrase('nisn'); ?></th>
            <th width = 25%><?php echo get_phrase('name'); ?></th>
            <th width = 25%><?php echo get_phrase('class'); ?></th>
            <th width = 25%><?php echo get_phrase('section'); ?></th>
            <th width = 25%><?php echo get_phrase('class_room'); ?></th>
            <th width = 25%><?php echo get_phrase('options'); ?></th>
            <!-- <th width = 25%><?php echo get_phrase('choose'); ?></th> -->
          </tr>
        </thead>
        <tbody>
          <?php foreach($enrols as $enroll){
            $student = $this->db->get_where('students', array('id' => $enroll['student_id']))->row_array();
            $parent = $this->db->get_where('parents', array('id' => $student['parent_id']))->row_array();
            ?>
            <tr>
              <td><?php echo $student['NIS']; ?></td>
              <td><?php echo $student['nisn']; ?></td>
              <!-- <td>
                <img class="rounded-circle" width="50" height="50" src="<?php echo $this->user_model->get_user_image($student['user_id']); ?>">
              </td> -->
              <td>
                <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/student/profile/'.$student['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?><br></a>
                <!-- <small> <strong><?php echo get_phrase('student_code'); ?> : </strong> <?php echo $student['code']; ?> </small> -->
              </td>
              <td>
                  <?php
                      echo $this->db->get_where('classes', array('id' => $enroll['class_id']))->row('name');
                  ?>
              </td>
              <td>
                  <?php
                      echo $this->db->get_where('sections', array('id' => $enroll['section_id']))->row('name');
                  ?>
              </td>
              <td>
                  <?php
                      echo $this->db->get_where('class_rooms', array('id' => $enroll['room_id']))->row('name');
                  ?>
              </td>
              <td>
                <div class="dropdown text-center">
                  <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <!-- <a href="javascript:void(0);" class="dropdown-item"  onclick="rightModal('<?php echo site_url('modal/popup/student/profile/'.$student['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo get_phrase('profile'); ?></a> -->
                    <!-- item-->
                    <a href="<?php echo route('student/edit/'.$student['id']); ?>" class="dropdown-item"><?php echo get_phrase('edit'); ?></a>
                    <!-- item -->
                    <!-- <a href="javascript:;" class="dropdown-item" onclick="confirmModal('<?php echo route('student/delete/'.$parent['user_id'].'/'.$student['parent_id'].'/'.$student['id'].'/'.$student['user_id']); ?>', showAllStudents)"><?php echo get_phrase('delete'); ?></a> -->
                  </div>
                </div>
              </td>
              <!-- <td><input type="checkbox" name="enrol_ids[]" value="<?= $enroll['id'] ?>"></td> -->
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<!-- <h5 class="mt-3">
    <?= get_phrase('delete_student') ?>:
</h5>
<div class="row">
    <div class="col-md-12">
      <input type="submit" id="delete_student" name="delete_student" onclick="validation(this.id)" class="btn btn-danger" value="<?= get_phrase('delete_student') ?>" />
    </div>
  </div>
</form> -->

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions : {
                    columns: [ 0 , 1 , 2 , 3 , 4 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>
<script type="text/javascript">
initDataTable('basic-datatable');

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

</script>