<?php
    $alumnus = $this->db->get_where('alumni', array('id' => $param1))->row_array();
    // var_dump($subjects);
    // var_dump($average);
?>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="text-center">
                    <img class="rounded-circle" width="50" height="50" src="<?php echo $this->user_model->get_user_image($student_data['user_id']); ?>">
                    <br>
                    <span style="font-weight: bold;">
                        <?php echo get_phrase('name'); ?>: <?php echo $alumnus['name']; ?>
                    </span>
                    <br>
                    <span style="font-weight: bold;">
                        <?php echo get_phrase('student_code'); ?>: <?php echo $alumnus['student_code']; ?>
                    </span>
                </div>                
            </div>
            <div class="col-md-8">
                <table class="table table-centered mb-0">
                    <tbody>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('name'); ?></td>
                            <td><?= $alumnus['name']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('student_code'); ?></td>
                            <td><?= $alumnus['student_code']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('email'); ?></td>
                            <td><?= $alumnus['email']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('phone_number'); ?></td>
                            <td><?= $alumnus['phone']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('enter_session'); ?></td>
                            <td><?= $alumnus['session2']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('passing_session'); ?></td>
                            <td><?= $alumnus['session1']; ?></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold;"><?php echo get_phrase('profession'); ?></td>
                            <td><?= $alumnus['profession']; ?></td>
                        </tr>
                        <?php
                            if($alumnus['profession'] == 'Kuliah'){
                        ?>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('university'); ?></td>
                                <td><?= $alumnus['university']; ?></td>
                            </tr>
                        <?php
                            } else if($alumnus['profession'] == 'Bekerja'){
                        ?>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('company'); ?></td>
                                <td><?= $alumnus['company']; ?></td>
                            </tr>                        
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>