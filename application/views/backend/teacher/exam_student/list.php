<?php
$school_id = school_id();
$this->db->where('teacher_id', $this->session->userdata('user_id'));
if(isset($selected_class_id) && $selected_class_id != ''){
    $this->db->where('class_id', $selected_class_id);
}
if(isset($selected_section_id) && $selected_section_id != ''){
    $this->db->where('section_id', $selected_section_id);
}
if(isset($selected_room_id) && $selected_room_id != ''){
    $this->db->where('room_id', $selected_room_id);
}
if(isset($selected_subject_id) && $selected_subject_id != ''){
    $this->db->where('subject_id', $selected_subject_id);
}
if($exam_type == 'published'){
    $this->db->where('status', 1);
}
if($exam_type == 'pending'){
    $this->db->where('status', 0);
}
if($exam_type == 'expired'){
    $this->db->where('deadline <', strtotime(date('m/d/Y')));
}else{
    $this->db->where('deadline >=', strtotime(date('m/d/Y')));
}
$this->db->where('school_id', $school_id);
$exams = $this->db->get('exam_students')->result_array();
if (count($exams) > 0):
?>
<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
    <thead>
        <tr class="bg-dark text-muted">
            <th><?php echo get_phrase('exam_types'); ?></th>
            <th><?php echo get_phrase('class'); ?></th>
            <th><?php echo get_phrase('subject'); ?></th>
            <th><?php echo get_phrase('tenggat_waktu'); ?></th>
            <th><?php echo get_phrase('submissions'); ?></th>
            <th><?php echo get_phrase('action'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($exams as $exam): 
            $exam_type = $this->db->get_where('exam_types', array('id' => $exam['exam_types_id']))->row_array();
            $mark_null = $this->exam_model->mark_null($exam['id']);
            $mark_not_null = $this->exam_model->mark_not_null($exam['id']);
        ?>
            <tr>
                <td><a href="<?= site_url('addons/exam/questions/'.$exam['id']); ?>">
                    <?php echo $exam_type['name']; ?>
                    </a>
                    <?php 
                    if($mark_null > 0){ ?>
                        <span class="badge badge-danger-lighten" style="font-size:13px;"><?php echo get_phrase('incomplete_mark_value'); ?></span>
                    <?php }else{ ?>
                        <span class="badge badge-success-lighten" style="font-size:13px;"><?php echo get_phrase('mark_has_been_completely_filled'); ?></span>
                    <?php } ?>
                </td>
                <td>
                    <?php $class = $this->crud_model->get_classes($exam['class_id'])->row_array(); ?>
                    <?php echo get_phrase('class') ?> : <?php echo $class['name']; ?>
                    <br>
                    <?php echo get_phrase('section') ?> : <?php echo $section = $this->crud_model->get_section_details_by_id('section', $exam['section_id'])->row('name'); ?>
                    <br>
                    <?php echo get_phrase('class_rooms') ?> : <?php echo $class_rooms = $this->crud_model->get_class_room($exam['room_id'])->row('name'); ?>
                </td>
                <td>
                    <?php $subject = $this->crud_model->get_subject_by_id($exam['subject_id']); ?>
                    <?php echo $subject['name']; ?>
                </td>
                <td>
                    <?php echo date('d M Y', $exam['deadline']); ?><br>
                    <?php echo date('H:i', $exam['time_start'])." - ".date('H:i', $exam['time_finish']); ?><br>
                    
                    <?php if($exam['status'] == 1 && $exam['deadline'] >= strtotime(date('m/d/Y'))): ?>
                        <span class="badge badge-success-lighten"><?php echo get_phrase('published'); ?></span>
                    <?php elseif($exam['deadline'] >= strtotime(date('m/d/Y'))): ?>
                        <span class="badge badge-secondary-lighten"><?php echo get_phrase('drafted'); ?></span>
                    <?php else: ?>
                        <span class="badge badge-danger-lighten"><?php echo get_phrase('tenggat_waktu'); ?></span>
                    <?php endif; ?>
                </td>
                <td class="text-center">
                    <?php $total_enroled_students = $this->db->get_where('enrols', array('class_id' => $exam['class_id'], 'section_id' => $exam['section_id'], 'school_id' => $school_id, 'session' => active_session())); ?>
                    <?php
						$this->db->distinct();
						$this->db->select('student_id');
						$this->db->where('exam_id', $exam['id']);
						$total_participant_students = $this->db->get('exam_answers');
                        echo $total_participant_students->num_rows().' '. get_phrase('students');

                        $percentage = 0;
                        if (!empty($total_enroled_students->num_rows())) {
                            $percentage = ($total_participant_students->num_rows() / $total_enroled_students->num_rows()) * 100;
                        }
					?>
                    <br>
                    <span class="badge badge-info-lighten"><?php echo round($percentage, 2).'% '.get_phrase('submissions'); ?></span>
                </td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="<?= site_url('addons/exam/questions/'.$exam['id']); ?>" class="dropdown-item"><?php echo get_phrase('create_questions'); ?></a>

                            <a href="<?= site_url('addons/exam/students/'.$exam['id'].'/'.$exam['class_id'].'/'.$exam['section_id']); ?>" class="dropdown-item"><?php echo get_phrase('submissions'); ?></a>
                            <!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/exam_student/edit/'.$exam['id'])?>', '<?php echo get_phrase('edit_exam'); ?>');"><?php echo get_phrase('edit'); ?></a> -->
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo site_url('addons/exam/index/delete/'.$exam['id']); ?>', showExams)"><?php echo get_phrase('delete'); ?></a>
                            <?php if($exam['deadline'] >= strtotime(date('m/d/Y'))): ?>
                                <?php if($exam['status'] == 0): ?>
                                    <a href="javascript:;" onclick="confirmModal('<?php echo site_url('addons/exam/publish/'.$exam['id']); ?>', showExams)" class="dropdown-item"><?php echo get_phrase('publish_exam'); ?></a>
                                <?php else: ?>
                                    <a href="<?php echo site_url('addons/exam/pending/'.$exam['id']); ?>" class="dropdown-item"><?php echo get_phrase('draft_ujian'); ?></a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
