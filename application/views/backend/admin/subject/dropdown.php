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
