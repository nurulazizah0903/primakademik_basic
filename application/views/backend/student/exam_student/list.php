<?php if($deadline_status == 'active'): ?>
    <h4 class="mb-4"><?php echo get_phrase('published_exam'); ?></h4>
<?php else: ?>
    <h4 class="mb-4"><?php echo get_phrase('tenggat_waktu'); ?></h4>
<?php endif; ?>
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link text-success <?php if($deadline_status =='active') echo 'active'; ?>" href="<?php echo site_url('addons/exam/my_active_exam'); ?>"><i class="dripicons-cloud-upload"></i> <?php echo get_phrase('published_exam'); ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-muted <?php if($deadline_status =='expired') echo 'active'; ?>" href="<?php echo site_url('addons/exam/my_expired_exam'); ?>"><i class=" mdi mdi-folder-clock-outline"></i> <?php echo get_phrase('tenggat_waktu'); ?></a>
    </li>
</ul>

<form class="mb-3 mt-4 pt-3" action="javascript:void(0)" method="get">
    <div class="row justify-content-center">
        <!-- Course subject -->
        <div class="col-md-3">
            <div class="form-group">
                <?php
                    $this->db->where('class_id', $class_id);
                    $subjects = $this->db->get('subjects')->result_array();
                ?>
                <select class="form-control select2" data-toggle="select2" name="subject" id = 'subject_id'>
                    <option value="all" <?php if($selected_subject == 'all') echo 'selected'; ?>><?php echo get_phrase('all_subject'); ?></option>
                    
                    <?php foreach($subjects as $subject){ ?>
                        <option value="<?php echo $subject['id']; ?>" <?php if($selected_subject == $subject['id']) echo 'selected'; ?>><?php echo $subject['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <select class="form-control select2" data-toggle="select2" name="teacher" id = 'teacher_id'>
                    <option value="all" <?php if($selected_teacher == 'all') echo 'selected'; ?>><?php echo get_phrase('all_teachers'); ?></option>
                    
                    <?php foreach($this->user_model->get_teachers()->result_array() as $teacher){ ?>
                        <option value="<?php echo $teacher['id']; ?>" <?php if($selected_teacher == $teacher['id']) echo 'selected'; ?>><?php echo $teacher['name']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-primary btn-block" onclick="filterExamBySubject()" name="button"><?php echo get_phrase('filter'); ?></button>
        </div>
    </div>
</form>
<?php if ($exams->num_rows() > 0): ?>
<div class="row">
    <?php foreach($exams->result_array() as $exam):

        $student_id = $this->session->userdata('user_id');
        $questions = $this->db->get_where('exam_questions', array('exam_id' => $exam['id']));
        $total_questions = $questions->num_rows();
        $total_marks = array_sum(array_column($questions->result_array(), 'mark'));

        $exam_type = $this->db->get_where('exam_types', array('id' => $exam['exam_types_id']))->row_array();
        $obtained_mark = $this->db->get_where('exam_answers', array('exam_id' => $exam['id'], 'student_id' => $student_id, 'mark' => 1));
        $question_answer = $this->db->get_where('exam_answers', array('exam_id' => $exam['id'], 'student_id' => $student_id, 'status' => 1));
        $student_question_answer = array_sum(array_column($question_answer->result_array(), 'status'));
        $student_obtained_marks = array_sum(array_column($obtained_mark->result_array(), 'obtained_mark'));
        ?>
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card d-block">
                <div class="card-body ">
                    <h4 class="card-title my-3 text-center">
                        <?php echo $exam_type['name']; ?>
                    </h4>
                    <div class="w-100 text-center p-0"><span class="text-muted"><?php echo get_phrase('total'); ?> <?php echo $total_questions; ?> <?php echo get_phrase('questions'); ?></span></div>
                    <div class="w-100 text-center p-0">
                        <span class="text-muted">
                            <?php echo get_phrase('total_marks') ?> : <span class="badge badge-secondary"><b><?php echo $total_marks; ?></b></span>
                        </span>
                    </div>
                    <div class="w-100 text-center p-0">
                        <span class="text-muted">
                            <?php echo get_phrase('total_obtained_marks') ?> : <span class="badge badge-success"><b>
                                <?php 
                                if ($exam['deadline'] < strtotime(date('m/d/Y'))) {
                                    echo $student_obtained_marks; 
                                }else {
                                    echo '0'; 
                                }
                                ?></b></span>
                        </span>
                    </div>
                    <div class="w-100 text-center p-0">
                        <span class="text-muted">
                            <?php echo get_phrase('start_exam') ?> : <span class="badge badge-warning"><b><?php echo date('d M Y', $exam['deadline'])." ".date("H:i:s", $exam['time_start']); ?></b></span>
                        </span>
                    </div>
                    <div class="w-100 text-center p-0">
                        <span class="text-muted">
                            <?php echo get_phrase('deadline') ?> : <span class="badge badge-warning"><b><?php echo date('d M Y', $exam['deadline'])." ".date("H:i:s", $exam['time_finish']); ?></b></span>
                        </span>
                    </div>
                    <div class="w-100 text-center p-0">
                        <span class="text-muted">
                            <?php echo get_phrase('subject') ?> : <span class="badge badge-info"><b><?php echo $this->db->get_where('subjects', array('id' => $exam['subject_id']))->row('name'); ?></b></span>
                        </span>
                    </div>
                    <hr>
                    <div class="w-100 mb-3">
                        <div class="media">
                            <img class="mr-2 rounded-circle" src="<?= $this->user_model->get_user_image($exam['teacher_id']); ?>" width="30" alt="Generic placeholder image">
                            <div class="media-body pt-1">
                                <span class="font-13 text-muted"><?php echo $this->user_model->get_user_details($exam['teacher_id'], 'name'); ?></span>
                            </div>

                            <!-- <div class="btn-group float-right">
                                <div class="btn-group">
                                    <span class="badge badge-info-lighten float-right mt-2 mr-2" data-toggle="tooltip" data-placement="top" data-original-title="<?php echo get_phrase('subject'); ?>">
                                        <?php echo $this->db->get_where('subjects', array('id' => $exam['subject_id']))->row('name'); ?>
                                    </span>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <?php
                    $progress_value = round(($question_answer->num_rows() / $questions->num_rows()) * 100, 2);
                    // if (!empty($question_answer->num_rows())) {
                        // round(($question_answer->num_rows() / $questions->num_rows()) * 100, 2);
                    // }
                    ?>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <?php if($progress_value >= 100): ?>
                                <div class="progress mb-2 h-10px cursor-pointer" data-toggle="tooltip" data-placement="top" data-original-title="<?= $progress_value.'% '.get_phrase('submitted_answers'); ?>">
                                    <div class="progress-bar bg-green-low" role="progressbar" style="width: <?php echo $progress_value; ?>%;" aria-valuenow="<?php echo $progress_value; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            <?php else: ?>
                                <div class="progress mb-2 h-10px cursor-pointer" data-toggle="tooltip" data-placement="top" data-original-title="<?= $progress_value.'% '.get_phrase('submitted_answers'); ?>">
                                    <div class="progress-bar" role="progressbar" style="width: <?php echo $progress_value; ?>%;" aria-valuenow="<?php echo $progress_value; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center p-0 progress_value_count"><p><?php echo ceil($progress_value); ?>%</p></div>
                    </div>

                    <div class="w-100 text-center">
                        <?php if(date("H:i:s") < date("H:i:s", $exam['time_start'])): ?>
                            <strong><?php echo get_phrase('Not Yet Started'); ?></strong>
                        <?php elseif(($exam['deadline'] >= strtotime(date('m/d/Y'))) AND (date("H:i:s", $exam['time_finish']) >= date("H:i:s") ) ): ?>
                            <?php if ($student_question_answer <= 0) {?>
                                <a href="<?= site_url('addons/exam/exam_questions/'.$exam['id']); ?>" class="btn btn-success mw-50"><?php echo get_phrase('buka_ujian'); ?></a>
                            <?php } else if ($question_answer > 0) {?>
                                <strong><?php echo get_phrase('not_yet_evaluation'); ?></strong>
                            <?php } else { ?>
                                ga bisa
                            <?php } ?>
                        <?php elseif($exam['deadline'] < strtotime(date('m/d/Y'))): ?>
                            <?php if ($student_obtained_marks > 0) { ?>
                                <a href="<?= site_url('addons/exam/my_exam_result/'.$exam['id']); ?>" class="btn btn-light mw-50"><?php echo get_phrase('view_result'); ?></a>
                            <?php }else { ?>
                                <strong><?php echo get_phrase('not_yet_evaluation'); ?></strong>
                            <?php } ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script>
    $('.select2').select2();
</script>