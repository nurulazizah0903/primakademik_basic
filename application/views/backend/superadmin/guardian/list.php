<?php
$school_id = school_id();
$this->db->where('school_id', $school_id);
$this->db->where('role', 'guardian');
$this->db->where_not_in('name', '0');
$users = $this->db->get('users')->result_array();
if (count($users) > 0): 
?>
<div class="table-responsive">
<table id="example" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<!-- <th><?php echo get_phrase('parent_id'); ?></th> -->
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('email'); ?></th>
			<th><?php echo get_phrase('phone'); ?></th>
            <th><?php echo get_phrase('address'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($users as $user){
			?>
			<tr>
				<!-- <td><?php echo $user['id']; ?></td> -->
				<td><a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/guardian/profile/'.$user['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $this->user_model->get_user_details($user['id'], 'name'); ?></a></td>
				<td><?php echo $user['email']; ?></td>
				<td><?php echo $user['phone']; ?></td>
				<td><?php echo $user['address']; ?></td>
				<td>
				<a href="<?php echo route('guardian/edit/'.$user['id']); ?>"><button type="button" class="btn btn-icon btn-warning btn-sm" style="margin-right:3px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></button></a>
				<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('guardian/delete/'.$user['id']); ?>', showAllGuardians )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-delete"></i></button>
					<!-- <div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<a href="<?php echo route('guardian/edit/'.$user['id']); ?>" class="dropdown-item"><?php echo get_phrase('edit'); ?></a>
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/guardian/edit/'.$user['id'])?>', '<?php echo get_phrase('update_guardian'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('guardian/delete/'.$user['id']); ?>', showAllGuardians )"><?php echo get_phrase('delete'); ?></a>
						</div>
					</div> -->
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
                    columns: [ 0 , 1 , 2 , 3 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>