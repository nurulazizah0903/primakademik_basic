<?php
    $student_data = $this->user_model->get_student_details_by_id('student', $param1);
    $parent = $this->db->get_where('parents', array('id' => $student_data['parent_id']))->row_array();
    $teacher_id = $this->user_model->get_logged_in_teacher_datas()['id'];
    $school_id = school_id();
?>
<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-4 pb-2">
            <div class="text-center">
                <img class="rounded-circle" width="50" height="50" src="<?php echo $this->user_model->get_user_image($student_data['user_id']); ?>">
                <br>
                <span style="font-weight: bold;">
                    <?php echo get_phrase('name'); ?>: <?php echo $student_data['name']; ?>
                </span>
                <br>
                <span style="font-weight: bold;">
                    <?php echo get_phrase('student_code'); ?>: <?php echo $student_data['code']; ?>
                </span>
            </div>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('profile'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="parent-tab" data-toggle="tab" href="#parent_info" role="tab" aria-controls="parent_info" aria-selected="false"><?php echo get_phrase('parent_info'); ?></a>
                </li>
                <!-- <?php if ($this->user_model->is_homeroom($teacher_id, $student_data['section_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" id="raport-tab" data-toggle="tab" href="#raport_info" role="tab" aria-controls="raport_info" aria-selected="false"><?php echo get_phrase('student_raport'); ?></a>
                </li>
                <?php endif; ?> -->
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                                <td><?= $student_data['name']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('email'); ?>:</td>
                                <td><?= $student_data['email']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('class'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('classes', array('id' => $student_data['class_id']))->row('name');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('section'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('sections', array('id' => $student_data['section_id']))->row('name');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                                <td><?= get_phrase($student_data['gender']) ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('address'); ?>:</td>
                                <td><?= $student_data['address']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('phone'); ?>:</td>
                                <td><?= $student_data['phone']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="parent_info" role="tabpanel" aria-labelledby="parent-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <?php
                            $parentdetails = $this->user_model->get_user_details($parent['user_id']);
                            ?>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_name'); ?>:</td>
                                <td><?= $parentdetails['name'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_email'); ?>:</td>
                                <td>
                                    <?php echo $this->user_model->get_user_details($parent['user_id'], 'email'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_address'); ?>:</td>
                                <td><?= $parentdetails['address'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_phone_number'); ?>:</td>
                                <td>
                                    <?php echo $this->user_model->get_user_details($parent['user_id'], 'phone'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php if ($this->user_model->is_homeroom($teacher_id, $student_data['section_id'])): ?>
                <div class="tab-pane fade show" id="raport_info" role="tabpanel" aria-labelledby="raport-tab">
                    <table class="table table-centered mb-0" >
                        <tbody>
                        <?php
                            $subjects = $this->db->get_where('subjects', array('class_id' => $student_data['class_id'],'section_id' => $student_data['section_id'], 'session' => active_session()))->result_array();
                            
                            foreach ($subjects as $subject):
                            ?>
                            <tr>
                                <td style="font-weight: bold;"><?php echo $subject['name']; ?>:</td>
                                <?php
                                    $active_session = active_session();
                                    $average = $this->db->select('AVG(mark_obtained) mark')
                                                ->from('marks')
                                                ->where(array('subject_id' => $subject['id'], 'student_id' => $student_data['student_id'],'class_id' => $student_data['class_id'],'section_id' => $student_data['section_id'], 'session' => $active_session))
                                                ->get()->row_array()['mark'];
                                                ?>
                                <td>
                                <?php
                                if ($average == 0){
                                    echo  get_phrase('no_value_yet');
                                }else{
                                echo round($average);
                                }
                                ?>
                                </td>
                            </tr>
                            <?php
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
