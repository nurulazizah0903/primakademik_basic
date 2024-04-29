<?php
$mean_issue = $this->crud_model->get_mean_issue_id($param1);
$means = $this->crud_model->get_means_by_id($mean_issue['mean_id']);
$users = $this->user_model->get_user_details($mean_issue['user_id']);
$students = $this->db->get_where('students', array('user_id' => $mean_issue['user_id']))->row_array();
$student_details = $this->user_model->get_student_details_by_id('student', $students['id']);
?>

<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('mean_issue_data'); ?></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('mean_name'); ?>:</td>
                                <td><?= $means['name']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('mean_location'); ?>:</td>
                                <td><?= $means['location']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('issue_date'); ?>:</td>
                                <td><?= date('D, d/M/Y', strtotime($mean_issue['issue_date'])); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('return_date'); ?>:</td>
                                <td><?= date('D, d/M/Y', strtotime($mean_issue['return_date'])); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                                <td><?= $users['name'];?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">
                                <?php 
                                    if ($users['role'] == 'teacher') {
                                        echo get_phrase('nip');
                                    }elseif ($users['role'] == 'student') {
                                        echo get_phrase('nisn');
                                        print_r("<br>");
                                        echo get_phrase('classes');
                                        print_r("<br>");
                                        echo get_phrase('section');
                                        print_r("<br>");
                                        echo get_phrase('class_room');
                                    }elseif ($users['role'] == 'accountant') {
                                        echo get_phrase('nip');
                                    }else{
                                        echo get_phrase('nip');
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                    if ($users['role'] == 'teacher') {
                                        echo $users['nip'];
                                    }elseif ($users['role'] == 'student') {
                                        echo $students['nisn'];
                                        echo $students['NIS'];
                                        
                                        print_r("<br>");
                                        echo $this->db->get_where('classes', array('id' => $student_details['class_id']))->row('name');
                                        print_r("<br>");
                                        echo $this->db->get_where('sections', array('id' => $student_details['section_id']))->row('name');
                                        print_r("<br>");
                                        echo $this->db->get_where('class_rooms', array('id' => $student_details['room_id']))->row('name');
                                    }elseif ($users['role'] == 'accountant') {
                                        echo $users['nip'];
                                    }else{
                                        echo $users['nip'];
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('role'); ?>:</td>
                                <td>
                                    <?php 
                                    if ($users['role'] == 'teacher') {
                                        echo get_phrase('teacher');
                                    }elseif ($users['role'] == 'student') {
                                        echo get_phrase('student');
                                    }elseif ($users['role'] == 'accountant') {
                                        echo get_phrase('accountant');
                                    }else{

                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('status'); ?>:</td>
                                <td>
                                    <?php if ($book_issue['status']): ?>
                                        <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('returned'); ?>
                                    <?php else: ?>
                                        <i class="mdi mdi-circle text-disable"></i> <?php echo get_phrase('pending'); ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>