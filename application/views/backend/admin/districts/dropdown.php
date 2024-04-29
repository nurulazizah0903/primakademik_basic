<option value=""><?php echo get_phrase('select_districts'); ?></option>
<?php
$districtss = $this->db->get_where('districts', array('district_id' => $district_id))->result_array();
if (count($districtss) > 0):
  foreach ($districtss as $districts): ?>
    <option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_data_found'); ?></option>
<?php endif; ?>
