<?php
$school_id = school_id();
$this->db->where('homeroom', 1);
$this->db->where('school_id', $school_id);
$homerooms = $this->db->get('teacher_permissions')->result_array();
if (count($homerooms) > 0): ?>
<table id="example" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('classes'); ?></th>
			<th><?php echo get_phrase('class_rooms'); ?></th>
			<th><?php echo get_phrase('homeroom_name'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($homerooms as $homeroom):
            $teachers = $this->db->get_where('teachers', array('id' => $homeroom['teacher_id']))->row_array();
            ?>
			<tr>
            <td>
                <?php
                    echo $this->db->get_where('classes', array('id' => $homeroom['class_id']))->row('name');
                ?>
            </td>
            <td>
                <?php
                    echo $this->db->get_where('class_rooms', array('section_id' => $homeroom['section_id']))->row('name');
                ?>
            </td>
				<td><?php echo $this->user_model->get_user_details($teachers['user_id'], 'name'); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
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
                    columns: [ 0 , 1 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>
