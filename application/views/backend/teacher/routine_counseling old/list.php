<?php 
$profile_data = $this->user_model->get_profile_data();
$routine_counseling = $this->db->get_where('routine_counseling', array('teacher_id' => $profile_data['id'], 'session_id' => active_session()))->result_array();
if (count($routine_counseling) > 0): 
?>
    <div class="table-responsive">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('name'); ?></th>
                <th><?php echo get_phrase('class'); ?></th>
                <th><?php echo get_phrase('date_counseling'); ?></th>
                <th><?php echo get_phrase('time_counseling'); ?></th>
                <th><?php echo get_phrase('mentor'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
                <th><?php echo get_phrase('option'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($routine_counseling as $counseling):
                $enrols = $this->db->get_where('enrols', array('student_id' => $counseling['student_id']))->row_array();
                $class = $this->db->get_where('classes', array('id' => $enrols['class_id']))->row_array();
                $section = $this->db->get_where('sections', array('id' => $enrols['section_id']))->row_array();
                $student = $this->db->get_where('students', array('id' => $enroll['student_id']))->row_array();
                $student = $this->user_model->get_student_details_by_id('student', $counseling['student_id']);
                $users = $this->user_model->get_user_details($student['user_id']);
                $teacher_detail = $this->user_model->get_user_details($counseling['teacher_id']);
                ?>
                <tr>
                    <td><?php echo $users['name']; ?></td>
                    <td><?php echo $class['name']; ?> <?php echo $section['name']; ?></td>
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
                    <td>
                        <div class="dropdown text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if ($counseling['status'] == 0): ?>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('routine_counseling/status/'.$counseling['id']); ?>', showAllRoutineCounseling )"><?php echo get_phrase('counseling_finish'); ?></a>
                                    <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>