<?php
$school_id = school_id();
$operational_hours = $this->db->get_where('operational_hour', array('school_id' => $school_id))->result_array();
if (count($operational_hours) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('time'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($operational_hours as $operational_hour): ?>
			<tr>
				<td><?php echo $operational_hour['name']; ?></td>
				<td><?php echo $operational_hour['time_start'].' - '.$operational_hour['time_finish']; ?></td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/operational_hour/edit/'.$operational_hour['id'])?>', '<?php echo get_phrase('update_operational_hour'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('operational_hour/delete/'.$operational_hour['id']); ?>', showAllOperationalHour)"><?php echo get_phrase('delete'); ?></a>
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
