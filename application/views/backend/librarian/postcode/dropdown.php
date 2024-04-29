<option value=""><?php echo get_phrase('select_postcode'); ?></option>
<?php
$postcodes = $this->db->get_where('postcode', array('districts_id' => $districts_id))->result_array();
if (count($postcodes) > 0):
  foreach ($postcodes as $postcode): ?>
    <option value="<?php echo $postcode['postcode']; ?>"><?php echo $postcode['postcode']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_data_found'); ?></option>
<?php endif; ?>
