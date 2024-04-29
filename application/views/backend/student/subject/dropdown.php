<option value=""><?php echo get_phrase('select_subject'); ?></option>
<?php
$subjects = $this->db->get_where('subjects', array('class_id' => $class_id, 'session' => active_session()))->result_array();
if (count($subjects) > 0):
  foreach ($subjects as $subject): ?>
    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_subject_found'); ?></option>
<?php endif; ?>
