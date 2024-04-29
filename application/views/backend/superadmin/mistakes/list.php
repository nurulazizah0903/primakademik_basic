<?php
$school_id = school_id();
$mistakes = $this->db->get_where('mistakes', array('school_id' => $school_id))->result_array();
if (count($mistakes) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('point'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($mistakes as $mistake):?>
			<tr>
				<td><?php echo $mistake['name']; ?></td>
				<td><?php echo $mistake['point']; ?></td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/mistakes/edit/'.$mistake['id'])?>', '<?php echo get_phrase('update_mistakes'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('mistakes/delete/'.$mistake['id']); ?>', showAllMistakes)"><?php echo get_phrase('delete'); ?></a>
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
