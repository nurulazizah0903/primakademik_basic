<?php
$school_id = school_id();
$this->db->where('school_id', $school_id);
$this->db->where('subject_id', $subject_id);
$this->db->where('section_id', $section_id);
$this->db->where('exam_types_id', $exam_type_id);
$exams = $this->db->get('exam_students')->result_array();
if (count($exams) > 0): ?>
<table id="example" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('student'); ?></th>
            <th><?php echo get_phrase('subjects'); ?></th>
			<th><?php echo get_phrase('exam_types'); ?></th>
			<th><?php echo get_phrase('mark'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($exams as $exam):
            $exam_mark = $this->db->get_where('exam_remarks', array('exam_id' => $exam['id']))->row_array();
            $subjects = $this->db->get_where('subjects', array('id' => $exam['subject_id']))->row_array();
            $exam_type = $this->db->get_where('exam_types', array('id' => $exam['exam_types_id']))->row_array();
            $student_data = $this->user_model->get_user_details($exam_mark['student_id']);
            $student = $this->db->get_where('students', array('user_id' => $exam_mark['student_id']))->row_array();
            $student_list = $this->user_model->get_student_details_by_id('student', $student['id']);
            ?>
			<tr>
            <td>
                <?= $student_list['nisn']; ?><br>
                <?= $student_data['name']; ?><br>
                <small> <strong><?php echo get_phrase('student_class'); ?> : </strong> 
                <?php
                    echo $this->db->get_where('class_rooms', array('section_id' => $student_list['section_id']))->row('name');
                ?> </small>
            </td>
            <td>
                <?php echo $subjects['name']; ?><br>
                <small> <strong><?php echo get_phrase('teacher'); ?> : </strong> <?php echo $this->user_model->get_user_details($exam['teacher_id'], 'name'); ?></small>
            </td>
            <td>
                <?php echo $exam_type['name']; ?>
            </td>
            <td>
                <?= $exam_mark['total_mark']; ?>
            </td>
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
