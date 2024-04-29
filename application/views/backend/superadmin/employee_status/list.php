<?php
$school_id = school_id();
$employee_statusies = $this->db->get_where('employee_status', array('school_id' => $school_id))->result_array();
if (count($employee_statusies) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($employee_statusies as $employee_status): ?>
			<tr>
				<td><?php echo $employee_status['name']; ?></td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/employee_status/edit/'.$employee_status['id'])?>', '<?php echo get_phrase('update_employee_status'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('employee_status/delete/'.$employee_status['id']); ?>', showAllEmployeeStatus)"><?php echo get_phrase('delete'); ?></a>
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
