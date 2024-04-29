<?php 
$school_id = school_id();
$profile_data = $this->user_model->get_profile_data();
$active_session = active_session();
if(isset($class_id) && $class_id != ''){
  $this->db->where('class_id', $class_id);
}
if(isset($section_id) && $section_id != ''){
  $this->db->where('section_id', $section_id);
}
$this->db->where('teacher_id', $profile_data['id']);
$this->db->where('school_id', $school_id);
$this->db->where('session_id', $active_session);
$routine_counseling = $this->db->get('routine_counseling')->result_array();
// $routine_counseling = $this->db->get_where('routine_counseling', array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session()))->result_array();
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
                <th><?php echo get_phrase('option'); ?></th>
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
                    <td>
                        <div class="dropdown text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if ($counseling['status'] == 0): ?>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_counseling/edit/'.$counseling['id'])?>', '<?php echo get_phrase('update_routine_couseling_information'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('routine_counseling/status/'.$counseling['id']); ?>', showAllRoutineCounseling )"><?php echo get_phrase('counseling_finish'); ?></a>
                                    <?php endif; ?>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('routine_counseling/delete/'.$counseling['id']); ?>', showAllRoutineCounseling )"><?php echo get_phrase('delete'); ?></a>
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