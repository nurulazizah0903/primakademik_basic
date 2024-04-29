<?php 
date_default_timezone_set('Asia/Jakarta');
$date = Date('d-m-Y H:i:s'); 
$namahari = date('l', strtotime($date));
$school_id = school_id(); 
$active_session = active_session(); 
$employee_detail = $this->db->get_where('users', array('id' => $user_id))->row_array();
$job = $this->db->get_where('job_management', array('user_id' => $user_id))->result_array();
$job_teacher = $this->db->get_where('job_management', array('user_id' => $user_id, 'status' => 1))->row_array();
?>
<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('basic_data'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="job-tab" data-toggle="tab" href="#job" role="tab" aria-controls="job" aria-selected="false"><?php echo get_phrase('job_management'); ?></a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show" id="job" role="tabpanel" aria-labelledby="job-tab"><br>
                    <?php 
                    $date = date('m/d/Y');
                    if (count($job) > 0): ?>
                    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
                        <thead>
                            <tr style="background-color: #313a46; color: #ababab;">
                                <th><?php echo get_phrase('nip'); ?></th>
                                <th><?php echo get_phrase('role'); ?></th>
                                <th><?php echo get_phrase('start_date'); ?></th>
                                <th><?php echo get_phrase('finish_date'); ?></th>
                                <th><?php echo get_phrase('status'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach($job as $job_management):?>
                                <tr>
                                    <td>
                                        <?php echo $employee_detail['nip']; ?><br>
                                        <small> <strong><?php echo get_phrase('name'); ?> : <?php echo $employee_detail['name']; ?></strong> </small>
                                    </td>
                                    <td>
                                    <?php 
                                        if ($job_management['role'] == 'teacher') {
                                            echo get_phrase('teacher');
                                        }elseif ($job_management['role'] == 'librarian') {
                                            echo get_phrase('librarian');
                                        }elseif ($job_management['role'] == 'accountant') {
                                            echo get_phrase('accountant');
                                        }else{

                                        }
                                    ?>    
                                    </td>
                                    <td><?php echo date('D, d/M/Y', strtotime($job_management['start_date'])); ?></td>
                                    <td>--</td>
                                    <td>
                                    <?php if ($job_management['status'] == "1") { ?>
                                            <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('active'); ?>
                                        <?php
                                        }elseif ($job_management['status'] == "0") { ?>
                                            <i class="mdi mdi-circle text-disabled"></i> <?php echo get_phrase('inactive'); ?>
                                    <?php } ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php else: ?>
                        <?php include APPPATH.'views/backend/empty.php'; ?>
                    <?php endif; ?>
                </div>
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nip'); ?>:</td>
                                <td><?= $employee_detail['nip']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('npwp'); ?>:</td>
                                <td><?= $employee_detail['npwp']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('jabatan'); ?>:</td>
                                <td>
                                    <?php
                                    if ($employee_detail['role'] == 'teacher') {
                                        echo get_phrase('teacher');
                                    }elseif ($employee_detail['role'] == 'librarian') {
                                        echo get_phrase('librarian');
                                    }elseif ($employee_detail['role'] == 'accountant') {
                                        echo get_phrase('accountant');
                                    }else{
                                        echo get_phrase('other_employee');
                                    }
                                    ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('npwp'); ?>:</td>
                                <td><?= $employee_detail['npwp']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                                <td><?= $employee_detail['name']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('email'); ?>:</td>
                                <td><?= $employee_detail['email']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nik'); ?>:</td>
                                <td><?= $employee_detail['nik']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                                <td><?= get_phrase($employee_detail['gender']) ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('phone'); ?>:</td>
                                <td><?= $employee_detail['phone']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('address'); ?>:</td>
                                <td><?= $employee_detail['address']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('province'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('province', array('id' => $employee_detail['province_id']))->row('name');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('district'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('district', array('id' => $employee_detail['district_id']))->row('name');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('districts'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('districts', array('id' => $employee_detail['districts_id']))->row('name');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('ward'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('ward', array('id' => $employee_detail['ward_id']))->row('name');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('postcode'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('postcode', array('postcode' => $employee_detail['post_code']))->row('name');
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>