<option value="all"><?php echo get_phrase('select_section'); ?></option>
<?php
$sections = $this->db->get_where('sections', array('class_id' => $class_id))->result_array();
if (count($sections) > 0):
  foreach ($sections as $section): ?>
    <?php if ($exclude != "" && $section['id'] == $exclude) continue; ?>
    <option value="<?php echo $section['id']; ?>"><?php echo $section['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_section_found'); ?></option>
<?php endif; ?>
