<?php
    // $users = $this->db->get_where('users', array('school_id' => $school_id, 'role' => 'parent'))->result_array();
    $parents = $this->db->get_where('users', array('id' => $param1))->row_array();
    $parents_id = $this->db->get_where('parents', array('user_id' => $parents['id']))->row_array();
    $student = $this->db->get_where('students', array('parent_id' => $parents_id['id']))->row_array();
    // var_dump($student);
    // die;
    // $teacherdetails = $this->db->get_where('users', array('id' => $teacher['user_id']))->row_array();
?>
<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-4 pb-2">
            <div class="text-center">
                <img class="rounded-circle" width="50" height="50" src="<?php echo $this->user_model->get_user_image($parents['user_id']); ?>">
                <br>
                <span style="font-weight: bold;">
                    <?php echo get_phrase('name'); ?>: <?php echo $parents['name']; ?>
                </span>
            </div>
        </div>
        <div class="col-md-8">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('profile'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="child-tab" data-toggle="tab" href="#child_info" role="tab" aria-controls="child_info" aria-selected="false"><?php echo get_phrase('child_info'); ?></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <table class="table table-centered mb-0">
                    <tbody>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                            <td><?= $parents['name']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                            <td><?= get_phrase($parents['gender']) ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('address'); ?>:</td>
                            <td><?= $parents['address']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('phone'); ?>:</td>
                            <td><?= $parents['phone']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('about'); ?>:</td>
                            <td><?= $parents['about']; ?></td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <div class="tab-pane fade show" id="child_info" role="tabpanel" aria-labelledby="child-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <?php
                            $studentdetails = $this->user_model->get_user_details($student['user_id']);
                            ?>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('student_name'); ?>:</td>
                                <td><?= $studentdetails['name'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('student_email'); ?>:</td>
                                <td>
                                    <?php echo $this->user_model->get_user_details($student['user_id'], 'email'); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('student_address'); ?>:</td>
                                <td><?= $studentdetails['address'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('student_phone_number'); ?>:</td>
                                <td>
                                    <?php echo $this->user_model->get_user_details($student['user_id'], 'phone'); ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
