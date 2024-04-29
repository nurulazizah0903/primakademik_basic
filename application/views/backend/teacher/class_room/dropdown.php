<option value=""><?php echo get_phrase('select_class_room'); ?></option>
<?php
$class_rooms = $this->db->get_where('class_rooms', array('section_id' => $section_id))->result_array();
if (count($class_rooms) > 0):
  foreach ($class_rooms as $class_room): ?>
    <?php if ($exclude != "" && $class_room['id'] == $exclude) continue; ?>
    <option value="<?php echo $class_room['id']; ?>"><?php echo $class_room['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_data_found'); ?></option>
<?php endif; ?>
