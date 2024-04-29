<?php
$school_id = school_id();
$check_data = $this->db->get_where('users', array('school_id' => $school_id, 'role' => 'guardian'));
if($check_data->num_rows() > 0):?>
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
		$users = $this->db->get_where('users', array('school_id' => $school_id, 'role' => 'guardian'))->result_array();
		foreach($users as $user){
			?>
			<tr>
				<!-- <td><?php echo $user['id']; ?></td> -->
				<td><a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/guardian/profile/'.$user['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $this->user_model->get_user_details($user['id'], 'name'); ?></a></td>
				<td><?php echo $user['email']; ?></td>
				<td><?php echo $user['phone']; ?></td>
				<td><?php echo $user['address']; ?></td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/guardian/edit/'.$user['id'])?>', '<?php echo get_phrase('update_guardian'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('guardian/delete/'.$user['id']); ?>', showAllGuardians )"><?php echo get_phrase('delete'); ?></a>
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
                    columns: [ 0 , 1 , 2 , 3 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>