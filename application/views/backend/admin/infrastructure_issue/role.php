<option value=""><?php echo get_phrase('select_name'); ?></option>
<?php
$roles = $this->db->get_where('users', array('role' => $role))->result_array();

if ($role== 'teacher'):

if (count($roles) > 0):
  foreach ($roles as $role): ?>
    <?php if ($exclude != "" && $role['id'] == $exclude) continue; ?>
    <option value="<?php echo $role['id']; ?>"><?php echo $role['nip']; ?> - <?php echo $role['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_role_found'); ?></option>
<?php endif; ?>

<?php elseif ($role == 'accountant'): 

if (count($roles) > 0):
  foreach ($roles as $role): ?>
    <?php if ($exclude != "" && $role['id'] == $exclude) continue; ?>
    <option value="<?php echo $role['id']; ?>"><?php echo $role['nip']; ?> - <?php echo $role['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_role_found'); ?></option>
<?php endif; ?>

<?php elseif ($role == 'other_employee'): 

if (count($roles) > 0):
  foreach ($roles as $role): ?>
    <?php if ($exclude != "" && $role['id'] == $exclude) continue; ?>
    <option value="<?php echo $role['id']; ?>"><?php echo $role['nip']; ?> - <?php echo $role['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_role_found'); ?></option>
<?php endif; ?>

<?php elseif ($role == 'librarian'): 

if (count($roles) > 0):
  foreach ($roles as $role): ?>
    <?php if ($exclude != "" && $role['id'] == $exclude) continue; ?>
    <option value="<?php echo $role['id']; ?>"><?php echo $role['nip']; ?> - <?php echo $role['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_role_found'); ?></option>
<?php endif; ?>

<?php elseif ($role == 'admin'): 

if (count($roles) > 0):
  foreach ($roles as $role): ?>
    <?php if ($exclude != "" && $role['id'] == $exclude) continue; ?>
    <option value="<?php echo $role['id']; ?>"><?php echo $role['nip']; ?> - <?php echo $role['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_role_found'); ?></option>
<?php endif; ?>

<?php elseif ($role == 'student'): 

if (count($roles) > 0):
  foreach ($roles as $role): ?>
    <?php if ($exclude != "" && $role['id'] == $exclude) continue; ?>
    <option value="<?php echo $role['id']; ?>"><?php  
    $student = $this->db->get_where('students', array('user_id' => $role['id']))->row_array();
    echo $student['NIS'];?> - <?= $student['nisn'];?> - <?php echo $role['name']; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo get_phrase('no_role_found'); ?></option>
<?php endif; ?>



<?php else: ?>
  <option value=""><?php echo get_phrase('no_role_found'); ?></option>
<?php endif; ?>