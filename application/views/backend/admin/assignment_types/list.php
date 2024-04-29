<?php
$school_id = school_id();
$assignment_types = $this->db->get_where('assignment_types', array('school_id' => $school_id))->result_array();
if (count($assignment_types) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($assignment_types as $assignment_type):
			$semester = $this->db->get_where('semester', array('id' => $assignment_type['semester_id']))->row_array();	
			?>
			<tr>
				<td><?php echo $assignment_type['name']; ?></td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/assignment_types/edit/'.$assignment_type['id'])?>', '<?php echo get_phrase('update_assignment_type'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('assignment_types/delete/'.$assignment_type['id']); ?>', showAllAssigmentTypes)"><?php echo get_phrase('delete'); ?></a>
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
