<?php $roles = $this->db->get_where('users', array('id' => $user_id))->result_array(); ?>
    <option value="">
    <?php 
        if ($roles[0]['role'] == 'teacher') {
            echo get_phrase('teacher');
        }elseif ($roles[0]['role'] == 'librarian') {
            echo get_phrase('librarian');
        }elseif ($roles[0]['role'] == 'accountant') {
            echo get_phrase('accountant');
        }elseif ($roles[0]['role'] == 'other_employee') {
            echo get_phrase('other_employee');
        }else{
            
        }       
    ?>
    </option>
