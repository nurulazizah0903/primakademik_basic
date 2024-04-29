<?php
$school_id = school_id();
$registration_paths = $this->db->get_where('registration_path')->result_array();
if (count($registration_paths) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('total_ppdb'); ?></th>
			<th><?php echo get_phrase('minimum_first_inden'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($registration_paths as $registration_path): ?>
			<tr>
				<td><?php echo $registration_path['name']; ?></td>
				<td><?= currency( number_format($registration_path['total'],0,",","."));?></td>
				<td><?= currency( number_format($registration_path['minimum_cicilan_pertama'],0,",","."));?></td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/registration_path/edit/'.$registration_path['id'])?>', '<?php echo get_phrase('update_registration_path'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('registration_path/delete/'.$registration_path['id']); ?>', showAllRegistrationPath)"><?php echo get_phrase('delete'); ?></a>
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
