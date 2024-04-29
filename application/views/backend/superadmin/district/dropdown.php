<option value=""><?php echo get_phrase('select_district'); ?></option>
<?php
$districts = $this->db->get_where('district', array('province_id' => $province_id))->result_array();
if (count($districts) > 0):
  foreach ($districts as $district): ?>
    <option value="<?php echo $district['id']; ?>"><?php echo $district['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_data_found'); ?></option>
<?php endif; ?>
