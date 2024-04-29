<?php
$school_id = school_id();
$active_session = active_session();

if (!empty($student_id)):
$student_data = $this->user_model->get_student_details_by_id('student', $student_id);

if ($mark_type == 'assignments'): 

    $this->db->where('school_id', $school_id);
    $this->db->where('session_id', $active_session);
    $this->db->where('class_id', $student_data['class_id']);
    $this->db->where('section_id', $student_data['section_id']);
    $this->db->where('deadline <', strtotime(date('m/d/Y')));
    $assignments = $this->db->get('assignments')->result_array();
    if (count($assignments) > 0): ?>
    <table id="example" class="table table-striped dt-responsive" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('subjects'); ?></th>
                <th><?php echo get_phrase('assignment_types'); ?></th>
                <th><?php echo get_phrase('mark'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($assignments as $assignment):
                $assignment_mark = $this->db->get_where('assignment_remarks', array('assignment_id' => $assignment['id']))->row_array();
                $subjects = $this->db->get_where('subjects', array('id' => $assignment['subject_id']))->row_array();
                $assignment_type = $this->db->get_where('assignment_types', array('id' => $assignment['assignment_types_id']))->row_array();
                ?>
                <tr>
                <td>
                    <?php echo $subjects['name']; ?><br>
                    <small> <strong><?php echo get_phrase('teacher'); ?> : </strong> <?php echo $this->user_model->get_user_details($assignment['teacher_id'], 'name'); ?></small>
                </td>
                <td>
                    <?php echo $assignment_type['name']; ?>
                </td>
                <td>
                    <?= $assignment_mark['total_mark']; ?>
                </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>

<?php elseif($mark_type == 'exams'): 

    $this->db->where('school_id', $school_id);
    $this->db->where('session_id', $active_session);
    $this->db->where('class_id', $student_data['class_id']);
    $this->db->where('section_id', $student_data['section_id']);
    $this->db->where('deadline <', strtotime(date('m/d/Y')));
    $exam_students = $this->db->get('exam_students')->result_array();
    if (count($exam_students) > 0): ?>
    <table id="example" class="table table-striped dt-responsive" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('subjects'); ?></th>
                <th><?php echo get_phrase('exam_types'); ?></th>
                <th><?php echo get_phrase('mark'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($exam_students as $exam):
                $exam_mark = $this->db->get_where('exam_remarks', array('exam_id' => $exam['id']))->row_array();
                $subjects = $this->db->get_where('subjects', array('id' => $exam['subject_id']))->row_array();
                $exam_type = $this->db->get_where('exam_types', array('id' => $exam['exam_types_id']))->row_array();
                ?>
                <tr>
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
    
    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?> 

    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>

<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "info":     false
    } );
} );
</script>