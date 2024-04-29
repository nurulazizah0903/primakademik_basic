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
            <td> <?php echo $employee['name']; ?> </td>
            <!-- <td> <a href="javascript:void(0);" onclick="rightModal('<?php echo site_url('modal/popup/book/detail/'.$book['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $book['name']; ?><br></a> </td> -->
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
              <div class="dropdown text-center">
      					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
      					<div class="dropdown-menu dropdown-menu-right">
      						<!-- item-->
                            <?php
                            if ($employee['role'] == 'teacher') { ?>
                                <a href="<?php echo route('teacher/edit/'.$employee['id']); ?>" class="dropdown-item"><?php echo get_phrase('edit'); ?></a>
                            <?php } elseif ($employee['role'] == 'librarian') { ?>
                                <a href="<?php echo route('librarian/edit/'.$employee['id']); ?>" class="dropdown-item"><?php echo get_phrase('edit'); ?></a>
                            <?php } elseif ($employee['role'] == 'accountant') { ?>
                                <a href="<?php echo route('accountant/edit/'.$employee['id']); ?>" class="dropdown-item"><?php echo get_phrase('edit'); ?></a>
                            <?php }else {
                                echo "bukan pegawai";
                            } ?>
                            <!-- item-->
      						<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('employee/delete/'.$employee['id']); ?>', showAllEmployee )"><?php echo get_phrase('delete'); ?></a>
                  <a href="<?php echo route('employee_card/'.$employee['id']); ?>" class="dropdown-item"><?php echo get_phrase('employee_card'); ?></a>
                </div>
      				</div>
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