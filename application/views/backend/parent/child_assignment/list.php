<?php
if (!empty($student_id)):
$student_data = $this->user_model->get_student_details_by_id('student', $student_id);
$assignments = $this->db->get_where('assignments', array('school_id' => school_id()))->result_array();

if (count($assignments) > 0):
?>
<div class="table-responsive">
<table class="table table-bordered table-responsive-sm" id="basic-datatable" width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('name'); ?></th>
                <th><?php echo get_phrase('deadline'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($assignments as $assignment): 
            $assignment_types = $this->db->get_where('assignment_types', array('id' => $assignment['assignment_types_id']))->row_array();
            $assignment_student = $this->db->get_where('assignment_answers', array('student_id' => $student_id, 'assignment_id' => $assignment['id']))->row_array();
            ?>
          <tr>
            <td> <?php echo $assignment_types['name']; ?> </td>
            <td> <?php echo date('D, d/M/Y', $assignment['deadline']); ?></td>
            <td> <?php 
                    if ($assignment_student['status'] == 1): ?>
                        <span class="badge badge-danger"><?php echo get_phrase('not_working_yet'); ?> </span>
                    <?php else: ?>
                        <span class="badge badge-success"><?php echo get_phrase('done');?></span>
                    <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
<script type="text/javascript">
    initDataTable('basic-datatable');
</script>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>