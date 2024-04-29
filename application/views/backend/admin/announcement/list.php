<?php
$school_id = school_id();
$announcements = $this->db->get_where('announcements', array('school_id' => $school_id))->result_array();

if (count($announcements) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('announcement_name'); ?></th>
            <th><?php echo get_phrase('date'); ?></th>
			<th><?php echo get_phrase('section'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
	<?php foreach($announcements as $announcement):
	?>
	<tr>
	    <td><?php echo $announcement['name']; ?></td>
	    <td>
		<?php echo date('d M Y', $announcement['start_date']); ?>
		</td>
		<td><?php echo $this->db->get_where('class_rooms', array('section_id' => $announcement['section_id']))->row('name'); ?></td>
		<td>
			<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:5px;" onclick="confirmModal('<?php echo route('announcement/delete/'.$announcement['id']); ?>', showAllAnnouncements)" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-window-close"></i></button>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
