<!-- <option value=""><?php echo get_phrase('select_subject'); ?></option>
<?php
$school_id = school_id();
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
$permission = $this->db->get_where('teacher_permissions', array('teacher_id' => $teacher_id, 'section_id' => $section_id))->row_array();    
if ($permission['marks'] == 1) {
$sub = $this->db->get_where('routines', array('school_id' => $school_id,'teacher_id' => $teacher_id,'section_id' => $section_id, 'session_id' => active_session()))->result_array();
foreach($sub as $su){
?>

<option value="<?php echo $su['subject_id']; ?>"><?php echo $this->db->get_where('subjects', array('id' => $su['subject_id']))->row('name'); ?></option>

<?php } 
 }elseif($permission['homeroom'] == 1){ 
$subjects = $this->db->get_where('subjects', array('section_id' => $section_id, 'session' => active_session()))->result_array();
if (count($subjects) > 0):
  foreach ($subjects as $subject): ?>

    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>

<?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_subject_found'); ?></option>
<?php endif; ?>
<?php }else { 
  $subjects = $this->db->get_where('subjects', array('section_id' => $section_id, 'session' => active_session()))->result_array();
if (count($subjects) > 0):
  foreach ($subjects as $subject): ?>

    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>

<?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_subject_found'); ?></option>
<?php endif; ?>

<?php } ?> -->

<option value=""><?php echo get_phrase('select_subject'); ?></option>
<?php
$subjects = $this->db->get_where('subjects', array('section_id' => $section_id))->result_array();
if (count($subjects) > 0):
  foreach ($subjects as $subject): ?>
    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_subject_found'); ?></option>
<?php endif; ?>
