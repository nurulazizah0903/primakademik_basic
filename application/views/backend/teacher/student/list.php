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
  $this->db->where('enrols.session', $active_session);

  $this->db->like('users.name', $keyword);
  $this->db->or_like('students.nis', $keyword);
  $this->db->or_like('students.nisn', $keyword);

  $this->db->join('enrols', 'students.id = enrols.student_id');
  $this->db->join('users', 'students.user_id = users.id');
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
  $this->db->where('session', $active_session);
  $enrols = $this->db->get('enrols')->result_array();

}
// $enrols = $this->db->get_where('enrols', array('school_id' => $school_id, 'session' => active_session()))->result_array();
if (count($enrols) > 0): 
?>
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
              <td>
                <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/student/profile/'.$student['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?><br></a>
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
              <!-- <td>
                <img class="rounded-circle" width="50" height="50" src="<?php echo $this->user_model->get_user_image($student['user_id']); ?>">
              </td> -->
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

<script type="text/javascript">
initDataTable('basic-datatable');

</script>