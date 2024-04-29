<?php
$school_id = school_id();
$active_session = active_session();
$student_data = $this->user_model->get_student_details_by_id('student', $param1);

// print_r($student_data); die;
?>
<?php
if (!empty($param1)):
$student_data = $this->user_model->get_student_details_by_id('student', $param1);
$subjects = $this->db->get_where('subjects', array('class_id' => $student_data['class_id'],'section_id' => $student_data['section_id']))->result_array();

if (count($subjects) > 0):
?>
<div class="row ">
    <div class="col-xl-12">
        <div class="card ">
            <div class="card-body">
                <div class="row ">
                    <div class="col-md-12">
                        <div class="table-responsive">
                        <table border="1" class="table table-bordered table-centered mb-0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><?php echo get_phrase('subject'); ?></th>
                                        <th><?php echo get_phrase('mark_knowledge'); ?></th>
                                        <th><?php echo get_phrase('mark_skills'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    foreach($subjects as $subject):
                                    $average = $this->db->get_where('marks', array('subject_id' => $subject['id'],'student_id' => $student_data['student_id'],'session' => $active_session))->row_array();
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?php echo $subject['name']; ?></td>
                                            <td>
                                            <?php
                                            if (empty($average['mark_knowledge'])){
                                                echo  get_phrase('no_value_yet');
                                            }else{
                                            echo $average['mark_knowledge'];
                                            }
                                            ?>
                                            </td>
                                            <td>
                                            <?php
                                            if (empty($average['mark_skills'])){
                                                echo  get_phrase('no_value_yet');
                                            }else{
                                            echo $average['mark_skills'];
                                            }
                                            ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>