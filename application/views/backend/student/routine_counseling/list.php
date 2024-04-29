<?php 
    $student_data = $this->user_model->get_logged_in_student_details();
    $routine_counseling = $this->db->get_where('routine_counseling', array('student_id' => $student_data['student_id'], 'school_id' => school_id(), 'session_id' => active_session()))->result_array();
    if (count($routine_counseling) > 0):
?>
    <div class="table-responsive">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('name'); ?></th>
                <th><?php echo get_phrase('date_counseling'); ?></th>
                <th><?php echo get_phrase('time_counseling'); ?></th>
                <th><?php echo get_phrase('mentor'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($routine_counseling as $counseling):
                $student = $this->user_model->get_student_details_by_id('student', $counseling['student_id']);
                $users = $this->user_model->get_user_details($student['user_id']);
                $teacher_detail = $this->user_model->get_user_details($counseling['teacher_id']);
                ?>
                <tr>
                    <td><?php echo $users['name']; ?></td>
                    <td>
                        <?php echo date('D, d/M/Y', $counseling['date']); ?>
                    </td>
                    <td><?php echo $counseling['routine_start']; ?></td>
                    <td><?= $teacher_detail['name'];?></td>
                    <td>
                        <?php if ($counseling['status'] == 1): ?>
                            <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('counseling_finish'); ?>
                        <?php else: ?>
                            <i class="mdi mdi-circle text-disable"></i> <?php echo get_phrase('not_yet_counseling'); ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>