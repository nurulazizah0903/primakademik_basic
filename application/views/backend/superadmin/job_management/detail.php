<?php $roles = $this->db->get_where('users', array('id' => $user_id))->result_array(); ?>
    <option value=""><?php echo $roles[0]['name']; ?></option>