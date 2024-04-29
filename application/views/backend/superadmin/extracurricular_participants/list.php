<?php
$school_id = school_id();
$active_session = active_session();
if(isset($organizations_id) && $organizations_id != ''){
  $this->db->like('organizations_id', $organizations_id);
}
$this->db->where('school_id', $school_id);
$this->db->where('session',  $active_session);
$extracurricular_participants = $this->db->get_where('student_extracurricular')->result_array();
?>
<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="table-responsive">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%"> 
        <thead>
          <tr style="background-color: #313a46; color: #ababab;">
            <th width = 25%><?php echo get_phrase('name'); ?></th>
            <th width = 25%><?php echo get_phrase('class'); ?></th>
            <th width = 25%><?php echo get_phrase('section'); ?></th>
            <th width = 25%><?php echo get_phrase('class_room'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach($extracurricular_participants as $extracurricular){
            $student = $this->user_model->get_student_details_by_id('student', $extracurricular['student_id']);
            ?>
            <tr>
              <td>
                <?= $student['nisn'];?> - <?= $student['name']; ?>
              </td>
              <td>
                <?php
                  echo $this->db->get_where('classes', array('id' => $student['class_id']))->row('name');
                ?>
              </td>
              <td>
                <?php
                  echo $this->db->get_where('sections', array('id' => $student['section_id']))->row('name');
                ?>
              </td>
              <td>
                <?php
                  echo $this->db->get_where('class_rooms', array('id' => $student['room_id']))->row('name');
                ?>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>