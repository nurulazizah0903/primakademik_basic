<?php
$school_id = school_id(); 
$accounts = $this->db->get_where('accounts', array('school_id' => $school_id))->result_array(); 
// print_r($accounts ); die;
if (count($accounts) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('code'); ?></th>
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('type'); ?></th>
			<th><?php echo get_phrase('options'); ?></th> 
		</tr>
	</thead>
	<tbody>
		<?php foreach($accounts as $account):?>
			<tr>
				<td><?php echo $account['code']; ?></td>
				<td><?php echo $account['name']; ?></td>
				<td><?php echo $account['type']; ?></td> 
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/account/edit/'.$account['id'])?>', '<?php echo get_phrase('edit_account'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('account/delete/'.$account['id']); ?>', showAllaccount)"><?php echo get_phrase('delete'); ?></a>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>


