<?php
$student_data = $this->user_model->get_student_list_of_logged_in_parent();

$subjects = $this->db->get_where('subjects', array('class_id' => $student_data[0]['class_id'], 'session' => active_session()))->result_array();
$exams = $this->db->get_where('exams', array('school_id' => school_id(), 'session' => active_session()))->result_array();
$subject_data = [];
$exam_data = [];
foreach ($subjects as $subject) {
    $subject_data[$subject['id']] = $subject['name'];
}
foreach ($exams as $exam) {
    $exam_data[$exam['id']] = $exam['name'];
}
?>
<?php
$checker = array(
    'student_id' => $student_data[0]['id'],
);
$marks = $this->db->get_where('marks', $checker)->result_array();
// $marks = $this->crud_model->get_all_marks($student_data['class_id'], $student_data['section_id'], "", $student_data['id'])->result_array();

//echo  active_session();
?>
<?php if (count($marks) > 0): ?>
<table id="basic-datatable" class="table table-bordered table-responsive-sm"  width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('subject'); ?></th>
                <th><?php echo get_phrase('exam'); ?></th>
                <th><?php echo get_phrase('mark'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($marks as $mark):?>
                <?php if ($mark['student_id'] == $student_data[0]['id']): ?>
                    <tr>
                        <td><?php echo $subject_data[$mark['subject_id']]; ?></td>
                        <td><?php echo $exam_data[$mark['exam_id']]; ?></td>
                        <td><?php echo $mark['mark_obtained']; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
<script type="text/javascript">
initDataTable('basic-datatable');
</script>