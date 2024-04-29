<option value=""><?php echo get_phrase('select_ward'); ?></option>
<?php
$wards = $this->db->get_where('ward', array('districts_id' => $districts_id))->result_array();
if (count($wards) > 0):
  foreach ($wards as $ward): ?>
    <option value="<?php echo $ward['id']; ?>"><?php echo $ward['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_data_found'); ?></option>
<?php endif; ?>
