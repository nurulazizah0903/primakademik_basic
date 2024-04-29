<?php
$school_id = school_id();
if($role != ''){
  $this->db->where('role', $role);
}else{
  $role_name = array('teacher', 'librarian', 'other_employee', 'accountant');
  $this->db->or_where_in('role', $role_name);
}

$this->db->where('school_id', $school_id);
$employees = $this->db->get('users')->result_array();
// $employees = $this->user_model->get_employees()->result_array();
if (count($employees) > 0): 
?>
  <div class="table-responsive-sm">
    <table id="example" class="table table-striped dt-responsive" width="100%">
      <thead class="thead-dark">
        <tr>
          <th><?php echo get_phrase('name'); ?></th>
          <th><?php echo get_phrase('role'); ?></th>
          <th><?php echo get_phrase('department'); ?></th>
          <th><?php echo get_phrase('option'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($employees as $employee):
        $departments = $this->db->get_where('departments', array('id' => $employee['department_id']))->row_array(); 
        ?>
          <tr>
            <!-- <td> <?php echo $employee['name']; ?> </td> -->
            <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/employee/detail/'.$employee['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $employee['nip']; ?> - <?php echo $employee['name']; ?><br></a> </td>
            <td> <?php  
                    if ($employee['role'] == 'teacher') {
                        echo get_phrase('teacher');
                    }elseif ($employee['role'] == 'librarian') {
                        echo get_phrase('librarian');
                    }elseif ($employee['role'] == 'accountant') {
                        echo get_phrase('accountant');
                    }elseif ($employee['role'] == 'other_employee') {
                      echo get_phrase('other_employee');
                    }else{
                      
                    } ?> 
            </td>
            <td> <?php echo $departments['name']; ?></td>
            <td>
              <a href="<?php echo route('employee/edit/'.$employee['id']); ?>"><button type="button" class="btn btn-icon btn-warning btn-sm" style="margin-right:3px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></button></a>
              <button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('employee/delete/'.$employee['id']); ?>', showAllEmployee )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
              <a href="<?php echo route('print_employee_card/'.$employee['id']); ?>" class="btn btn-icon btn-info btn-sm" target="_blank" style="margin-right:3px;"> <i class="mdi mdi-card-bulleted-outline" title="" data-original-title="<?php echo get_phrase('cetak_kartu'); ?>"></i></a>
              <a onclick="confirmModal('<?php echo route('employee/reset_password_by_id/'.$employee['id']); ?>', showAllEmployee )" style="margin-right:3px;" class="btn btn-icon btn-warning btn-sm" title="" data-original-title="<?php echo get_phrase('reset_password'); ?>"> <i class="mdi mdi-autorenew"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions : {
                    columns: [ 0 , 1 , 2 , 3 , 4 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>