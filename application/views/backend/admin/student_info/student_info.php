<?php 
date_default_timezone_set('Asia/Jakarta');
$date = Date('d-m-Y H:i:s'); 
$namahari = date('l', strtotime($date));
$school_id = school_id(); 
$active_session = active_session(); 
$student_data = $this->user_model->get_student_details_by_id('student', $student_id);
$parent = $this->db->get_where('parents', array('id' => $student_data['parent_id']))->row_array();
$guardian = $this->db->get_where('guardians', array('id' => $student_data['guardian_id']))->row_array();
?>
<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('basic_data'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="parent-tab" data-toggle="tab" href="#parent_info" role="tab" aria-controls="parent_info" aria-selected="false"><?php echo get_phrase('parent_data'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="guardian-tab" data-toggle="tab" href="#guardian_info" role="tab" aria-controls="guardian_info" aria-selected="false"><?php echo get_phrase('guardian_data'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="akademik-tab" data-toggle="tab" href="#akademik_info" role="tab" aria-controls="akademik_info" aria-selected="false"><?php echo get_phrase('akademik_data'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="periodik-tab" data-toggle="tab" href="#periodik_info" role="tab" aria-controls="periodik_info" aria-selected="false"><?php echo get_phrase('periodik_data'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="routine-tab" data-toggle="tab" href="#routine_info" role="tab" aria-controls="routine_info" aria-selected="false"><?php echo get_phrase('routine'); ?></a>
                </li>
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
                                <td style="font-weight: bold;"><?php echo get_phrase('nisn'); ?>:</td>
                                <td><?= $student_data['nisn']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nis'); ?>:</td>
                                <td><?= $student_data['NIS']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nik'); ?>:</td>
                                <td><?= $student_data['nik']; ?></td>
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
                                <td style="font-weight: bold;"><?php echo get_phrase('class_room'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('class_rooms', array('id' => $student_data['room_id']))->row('name');
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
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('number_va'); ?>:</td>
                                <td><?= $student_data['va']; ?></td>
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
                                <td><?= $parentdetails['email'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                                <td><?= $parentdetails['gender'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nik'); ?>:</td>
                                <td><?= $parentdetails['nik'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_address'); ?>:</td>
                                <td><?= $parentdetails['address'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_phone_number'); ?>:</td>
                                <td><?= $parentdetails['phone'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="guardian_info" role="tabpanel" aria-labelledby="guardian-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <?php
                            $guardiandetails = $this->user_model->get_user_details($guardian['user_id']);
                            ?>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                                <td><?= $guardiandetails['name'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('email'); ?>:</td>
                                <td><?= $guardiandetails['email'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                                <td><?= $guardiandetails['gender'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nik'); ?>:</td>
                                <td><?= $guardiandetails['nik'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('address'); ?>:</td>
                                <td><?= $guardiandetails['address'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('phone'); ?>:</td>
                                <td><?= $guardiandetails['phone'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="akademik_info" role="tabpanel" aria-labelledby="akademik-tab">
                <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('upload_skhun'); ?>:</td>
                                <td>
                                    <?php if (isset($student_data['skhun'])) { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $student_data['skhun']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>
                                    <?php } else { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('upload_ijazah'); ?>:</td>
                                <td>
                                    <?php if (!isset($student_data['ijazah'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $student_data['ijazah']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>    
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('rapor_semester'); ?>:</td>
                                <td>
                                    <?php if (!isset($student_data['rapor_semester'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                    <a href="<?= base_url();?>uploads/registrations/<?= $student_data['rapor_semester']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>    
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('sertifikat_lainnya'); ?>:</td>
                                <td>
                                    <?php if (!isset($student_data['sertifikat_lainnya'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $student_data['sertifikat_lainnya']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>    
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('dokumen_lainnya'); ?>:</td>
                                <td>
                                    <?php if (!isset($student_data['dokumen_lainnya'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $student_data['dokumen_lainnya']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>        
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="periodik_info" role="tabpanel" aria-labelledby="periodik-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('weight'); ?>:</td>
                                <td><?= $student_data['weight'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('height'); ?>:</td>
                                <td><?= $student_data['height'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('mileage'); ?>:</td>
                                <td><?= $student_data['mileage'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('traveling_time'); ?>:</td>
                                <td><?= $student_data['traveling_time'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('child_of'); ?>:</td>
                                <td><?= $student_data['child_of'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('number_of_siblings'); ?>:</td>
                                <td><?= $student_data['number_of_siblings'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="routine_info" role="tabpanel" aria-labelledby="routine-tab">
                <table class="table mb-0 table-striped table-bordered table-centered">
        <tbody>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('class_routine'); ?></td>
                <td class="m-1">
                        <?php
                            $this->db->where('class_id', $student_data['class_id']);
                            $this->db->where('section_id', $student_data['section_id']);
                            $this->db->where('room_id', $student_data['room_id']);
                            $this->db->where('day', $namahari);
                            $this->db->where('school_id', $school_id);
                            $this->db->where('session_id', $active_session);
                            $this->db->order_by('time_start', 'asc');
                            $sunday_routines = $this->db->get('routines')->result_array();
                        	foreach($sunday_routines as $sunday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($sunday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px;"><i class="mdi mdi-book-open-variant"></i>
                                	<?php echo $this->db->get_where('subjects', array('id' => $sunday_routine['subject_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px;"><i class="mdi mdi-clock"></i>
                                <?php echo $sunday_routine['time_start'].' - '.$sunday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $sunday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                            </button>
                            </div>
                        <?php } ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('routine_extracurricular'); ?></td>
                <td class="m-1">
                        <?php
                            $this->db->where('day', $namahari);
                            $this->db->where('school_id', $school_id);
                            $this->db->where('session_id', $active_session);
                            $this->db->order_by('time_start', 'asc');
                            $sunday_routines_extracurricular = $this->db->get('routine_extracurricular')->result_array();
                        	foreach($sunday_routines_extracurricular as $sunday_routine_extracurricular){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($sunday_routine_extracurricular['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px;"><i class="mdi mdi-clock"></i>
                                <?php echo $sunday_routine_extracurricular['time_start'].' - '.$sunday_routine_extracurricular['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $sunday_routine_extracurricular['organizations_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $sunday_routine_extracurricular['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                            </button>
                            </div>
                        <?php } ?>
                </td>
            </tr>
                </tbody>
            </table>
                </div>
            </div>
        </div>
    </div>
</div>