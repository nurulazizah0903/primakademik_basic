<?php
$school_id = school_id();
$organizations = $this->db->get_where('organizations', array('school_id' => $school_id))->result_array();
if (count($organizations) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<!-- <th><?php echo get_phrase('options'); ?></th> -->
		</tr>
	</thead>
	<tbody>
		<?php foreach($organizations as $organization):?>
			<tr>
				<td><?php echo $organization['name']; ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
