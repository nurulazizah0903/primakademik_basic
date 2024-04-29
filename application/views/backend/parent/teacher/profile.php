<?php
    $teacher = $this->db->get_where('teachers', array('id' => $param1))->row_array();
    $teacherdetails = $this->db->get_where('users', array('id' => $teacher['user_id']))->row_array();
?>
<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-4 pb-2">
            <div class="text-center">
                <img class="rounded-circle" width="50" height="50" src="<?php echo $this->user_model->get_user_image($teacher['user_id']); ?>">
                <br>
                <span style="font-weight: bold;">
                    <?php echo get_phrase('name'); ?>: <?= $teacherdetails['name'] ?>
                </span>
                <br>
                <span style="font-weight: bold;">
                    <?php echo get_phrase('department'); ?>: <?php echo $this->db->get_where('departments', array('id' => $teacher['department_id']))->row_array()['name']; ?>
                </span>
            </div>
        </div>
        <div class="col-md-8">
            <div id="profile">
                <table class="table table-centered mb-0">
                    <tbody>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                            <td><?= $teacherdetails['name']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                            <td><?= get_phrase($teacherdetails['gender']) ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('address'); ?>:</td>
                            <td><?= $teacherdetails['address']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('phone'); ?>:</td>
                            <td><?= $teacherdetails['phone']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('about'); ?>:</td>
                            <td><?= $teacher['about']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
