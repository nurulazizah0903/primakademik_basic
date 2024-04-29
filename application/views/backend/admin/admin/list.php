<?php
$school_id = school_id();
$check_data = $this->db->get_where('users', array('role' => 'admin'));
if($check_data->num_rows() > 0):?>
<div class="table-responsive">
<table id="example" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('email'); ?></th>
            <th><?php echo get_phrase('admin_of'); ?></th>
            <th><?php echo get_phrase('phone'); ?></th>
            <th><?php echo get_phrase('address'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $admins = $this->db->get_where('users', array('role' => 'admin'))->result_array();
        foreach($admins as $admin){
            ?>
            <tr>
                <td><?php echo $admin['name']; ?></td>
                <td><?php echo $admin['email']; ?></td>
                <td>
                    <?php
                        $school_details = $this->crud_model->get_school_details_by_id($admin['school_id']);
                        echo $school_details['name'];
                     ?>
                     <br><small> <strong><?php echo get_phrase('phone'); ?></strong>: <?php echo $school_details['phone']; ?></small>
                     <br><small> <strong><?php echo get_phrase('address'); ?></strong>: <?php echo $school_details['address']; ?></small>
                </td>
                <td><?php echo $admin['phone']; ?></td>
                <td><?php echo $admin['address']; ?></td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/admin/edit/'.$admin['id']); ?>', '<?php echo get_phrase('update_admin'); ?>')"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('admin/delete/'.$admin['id']); ?>', showAllAdmins )"><?php echo get_phrase('delete'); ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
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
                    columns: [ 0 , 1 , 2 , 3, 4 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>