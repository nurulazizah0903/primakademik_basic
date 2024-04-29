<option value=""><?php echo get_phrase('select_district'); ?></option>
<?php
$users = $this->db->get_where('users', array('id' => $user_id))->row_array();
$districts = $this->db->get_where('district', array('province_id' => $users['province_id']))->result_array();
  foreach ($districts as $district): ?>
    <option value="<?php echo $district['id']; ?>" <?php if($user_id['district_id'] == $district['id']) echo 'selected'; ?>><?php echo $district['name']; ?></option>
  <?php endforeach; ?>