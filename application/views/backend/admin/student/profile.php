<?php
    $student_data = $this->user_model->get_student_details_by_id('student', $param1);
    $parent = $this->db->get_where('parents', array('id' => $student_data['parent_id']))->row_array();
    $guardian = $this->db->get_where('guardians', array('id' => $student_data['guardian_id']))->row_array();
    $school_id = school_id();
    date_default_timezone_set('Asia/Jakarta');
    $date = Date('d-m-Y H:i:s'); 
    $namahari = date('l', strtotime($date));
    $active_session = active_session();
    $class_id = $student_data['class_id'];
    $section_id = $student_data['section_id'];
    $room_id = $student_data['room_id'];
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
                    <a class="nav-link" id="routine-tab" data-toggle="tab" href="#class_routine" role="tab" aria-controls="class_routine" aria-selected="false"><?php echo get_phrase('class_routine'); ?></a>
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
                <div class="tab-pane fade show" id="class_routine" role="tabpanel" aria-labelledby="routine-tab">
                    <div class="w-100 table-responsive">
                        <table class="table mb-0 table-striped table-bordered table-centered">
                            <tbody>
                                <tr>
                                    <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('sunday'); ?></td>
                                    <td class="m-1">
                                            <?php
                                                // $sunday_routines = $this->db->get_where('routines', array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'sunday'))->result_array();
                                                // $search = array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'sunday');
                                                if(isset($class_id) && $class_id != ''){
                                                $this->db->where('class_id', $class_id);
                                                }
                                                if(isset($section_id) && $section_id != ''){
                                                $this->db->where('section_id', $section_id);
                                                }
                                                if(isset($room_id) && $room_id != ''){
                                                $this->db->where('room_id', $room_id);
                                                }
                                                $this->db->where('lower(day)', 'sunday');
                                                $this->db->where('school_id', $school_id);
                                                $this->db->where('session_id', $active_session);
                                                $sunday_routines = $this->db->get('routines')->result_array();
                                                foreach($sunday_routines as $sunday_routine){
                                            ?>
                                                <div class="text-left btn-group">
                                                <button type="button" class="btn <?= ($sunday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                                        <?php echo $this->db->get_where('subjects', array('id' => $sunday_routine['subject_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                                        <?php echo $this->db->get_where('operational_hour', array('id' => $sunday_routine['hour_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                                        <?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $sunday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-home-automation"></i>
                                                        <?php echo $this->db->get_where('class_rooms', array('id' => $sunday_routine['room_id']))->row('name'); ?>
                                                    </p>
                                                    <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine/edit/'.$sunday_routine['id'])?>', '<?php echo get_phrase('update_routine'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                                        <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine/delete/'.$sunday_routine['id']); ?>', getFilteredClassRoutine)"><?php echo get_phrase('delete'); ?></a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('monday'); ?></td>
                                    <td class="m-1">

                                            <?php
                                                // $monday_routines = $this->db->get_where('routines', array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'monday'))->result_array();
                                                // $search = array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'monday');
                                                if(isset($class_id) && $class_id != ''){
                                                $this->db->where('class_id', $class_id);
                                                }
                                                if(isset($section_id) && $section_id != ''){
                                                $this->db->where('section_id', $section_id);
                                                }
                                                if(isset($room_id) && $room_id != ''){
                                                $this->db->where('room_id', $room_id);
                                                }
                                                $this->db->where('lower(day)', 'monday');
                                                $this->db->where('school_id', $school_id);
                                                $this->db->where('session_id', $active_session);
                                                $monday_routines = $this->db->get('routines')->result_array();
                                                foreach($monday_routines as $monday_routine){
                                            ?>
                                                <div class="text-left btn-group">
                                                <button type="button" class="btn <?= ($monday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                                        <?php echo $this->db->get_where('subjects', array('id' => $monday_routine['subject_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                                        <?php echo $this->db->get_where('operational_hour', array('id' => $monday_routine['hour_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                                        <?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $monday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-home-automation"></i>
                                                        <?php echo $this->db->get_where('class_rooms', array('id' => $monday_routine['room_id']))->row('name'); ?>
                                                    </p>
                                                    <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine/edit/'.$monday_routine['id'])?>', '<?php echo get_phrase('update_routine'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                                        <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine/delete/'.$monday_routine['id']); ?>', getFilteredClassRoutine)"><?php echo get_phrase('delete'); ?></a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('tuesday'); ?></td>
                                    <td class="m-1">

                                            <?php
                                                // $tuesday_routines = $this->db->get_where('routines', array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'tuesday'))->result_array();
                                                // $search = array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'tuesday');
                                                if(isset($class_id) && $class_id != ''){
                                                $this->db->where('class_id', $class_id);
                                                }
                                                if(isset($section_id) && $section_id != ''){
                                                $this->db->where('section_id', $section_id);
                                                }
                                                if(isset($room_id) && $room_id != ''){
                                                $this->db->where('room_id', $room_id);
                                                }
                                                $this->db->where('lower(day)', 'tuesday');
                                                $this->db->where('school_id', $school_id);
                                                $this->db->where('session_id', $active_session);
                                                $tuesday_routines = $this->db->get('routines')->result_array();
                                                foreach($tuesday_routines as $tuesday_routine){
                                            ?>
                                                <div class="text-left btn-group">
                                                <button type="button" class="btn <?= ($tuesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                                        <?php echo $this->db->get_where('subjects', array('id' => $tuesday_routine['subject_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                                        <?php echo $this->db->get_where('operational_hour', array('id' => $tuesday_routine['hour_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                                        <?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $tuesday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-home-automation"></i>
                                                        <?php echo $this->db->get_where('class_rooms', array('id' => $tuesday_routine['room_id']))->row('name'); ?>
                                                    </p>
                                                    <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine/edit/'.$tuesday_routine['id'])?>', '<?php echo get_phrase('update_routine'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                                        <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine/delete/'.$tuesday_routine['id']); ?>', getFilteredClassRoutine)"><?php echo get_phrase('delete'); ?></a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('wednesday'); ?></td>
                                    <td class="m-1">

                                            <?php
                                                // $wednesday_routines = $this->db->get_where('routines', array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'wednesday'))->result_array();
                                                // $search = array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'wednesday');
                                                if(isset($class_id) && $class_id != ''){
                                                $this->db->where('class_id', $class_id);
                                                }
                                                if(isset($section_id) && $section_id != ''){
                                                $this->db->where('section_id', $section_id);
                                                }
                                                if(isset($room_id) && $room_id != ''){
                                                $this->db->where('room_id', $room_id);
                                                }
                                                $this->db->where('lower(day)', 'wednesday');
                                                $this->db->where('school_id', $school_id);
                                                $this->db->where('session_id', $active_session);
                                                $wednesday_routines = $this->db->get('routines')->result_array();
                                                foreach($wednesday_routines as $wednesday_routine){
                                            ?>
                                                <div class="text-left btn-group">
                                                <button type="button" class="btn <?= ($wednesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                                        <?php echo $this->db->get_where('subjects', array('id' => $wednesday_routine['subject_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                                        <?php echo $this->db->get_where('operational_hour', array('id' => $wednesday_routine['hour_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                                        <?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $wednesday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-home-automation"></i>
                                                        <?php echo $this->db->get_where('class_rooms', array('id' => $wednesday_routine['room_id']))->row('name'); ?>
                                                    </p>
                                                    <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine/edit/'.$wednesday_routine['id'])?>', '<?php echo get_phrase('update_routine'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                                        <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine/delete/'.$wednesday_routine['id']); ?>', getFilteredClassRoutine)"><?php echo get_phrase('delete'); ?></a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('thursday'); ?></td>
                                    <td class="m-1">

                                            <?php
                                                // $thursday_routines = $this->db->get_where('routines', array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'thursday'))->result_array();
                                                // $search = array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'thursday');
                                                if(isset($class_id) && $class_id != ''){
                                                $this->db->where('class_id', $class_id);
                                                }
                                                if(isset($section_id) && $section_id != ''){
                                                $this->db->where('section_id', $section_id);
                                                }
                                                if(isset($room_id) && $room_id != ''){
                                                $this->db->where('room_id', $room_id);
                                                }
                                                $this->db->where('lower(day)', 'thursday');
                                                $this->db->where('school_id', $school_id);
                                                $this->db->where('session_id', $active_session);
                                                $thursday_routines = $this->db->get('routines')->result_array();
                                                foreach($thursday_routines as $thursday_routine){
                                            ?>
                                                <div class="text-left btn-group">
                                                <button type="button" class="btn <?= ($thursday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                                        <?php echo $this->db->get_where('subjects', array('id' => $thursday_routine['subject_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                                        <?php echo $this->db->get_where('operational_hour', array('id' => $thursday_routine['hour_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                                        <?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $thursday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-home-automation"></i>
                                                        <?php echo $this->db->get_where('class_rooms', array('id' => $thursday_routine['room_id']))->row('name'); ?>
                                                    </p>
                                                    <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine/edit/'.$thursday_routine['id'])?>', '<?php echo get_phrase('update_routine'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                                        <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine/delete/'.$thursday_routine['id']); ?>', getFilteredClassRoutine)"><?php echo get_phrase('delete'); ?></a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('friday'); ?></td>
                                    <td class="m-1">

                                            <?php
                                                // $friday_routines = $this->db->get_where('routines', array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'friday'))->result_array();
                                                // $search = array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'friday');
                                                if(isset($class_id) && $class_id != ''){
                                                $this->db->where('class_id', $class_id);
                                                }
                                                if(isset($section_id) && $section_id != ''){
                                                $this->db->where('section_id', $section_id);
                                                }
                                                if(isset($room_id) && $room_id != ''){
                                                $this->db->where('room_id', $room_id);
                                                }
                                                $this->db->where('lower(day)', 'friday');
                                                $this->db->where('school_id', $school_id);
                                                $this->db->where('session_id', $active_session);
                                                $friday_routines = $this->db->get('routines')->result_array();
                                                foreach($friday_routines as $friday_routine){
                                            ?>
                                                <div class="text-left btn-group">
                                                <button type="button" class="btn <?= ($friday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                                        <?php echo $this->db->get_where('subjects', array('id' => $friday_routine['subject_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                                        <?php echo $this->db->get_where('operational_hour', array('id' => $friday_routine['hour_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                                        <?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $friday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-home-automation"></i>
                                                        <?php echo $this->db->get_where('class_rooms', array('id' => $friday_routine['room_id']))->row('name'); ?>
                                                    </p>
                                                    <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine/edit/'.$friday_routine['id'])?>', '<?php echo get_phrase('update_routine'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                                        <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine/delete/'.$friday_routine['id']); ?>', getFilteredClassRoutine)"><?php echo get_phrase('delete'); ?></a>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('saturday'); ?></td>
                                    <td class="m-1">

                                            <?php
                                                // $satureday_routines = $this->db->get_where('routines', array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'saturday'))->result_array();
                                                // $search = array('class_id' => $class_id, 'section_id' => $section_id, 'session_id' => active_session(), 'lower(day)' => 'saturday');
                                                if(isset($class_id) && $class_id != ''){
                                                $this->db->where('class_id', $class_id);
                                                }
                                                if(isset($section_id) && $section_id != ''){
                                                $this->db->where('section_id', $section_id);
                                                }
                                                if(isset($room_id) && $room_id != ''){
                                                $this->db->where('room_id', $room_id);
                                                }
                                                $this->db->where('lower(day)', 'saturday');
                                                $this->db->where('school_id', $school_id);
                                                $this->db->where('session_id', $active_session);
                                                $satureday_routines = $this->db->get('routines')->result_array();
                                                foreach($satureday_routines as $satureday_routine){
                                            ?>
                                                <div class="text-left btn-group">
                                                <button type="button" class="btn <?= ($satureday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                                        <?php echo $this->db->get_where('subjects', array('id' => $satureday_routine['subject_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                                        <?php echo $this->db->get_where('operational_hour', array('id' => $satureday_routine['hour_id']))->row('name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                                        <?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $satureday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                                    </p>
                                                    <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-home-automation"></i>
                                                        <?php echo $this->db->get_where('class_rooms', array('id' => $satureday_routine['room_id']))->row('name'); ?>
                                                    </p>
                                                    <span class="caret"></span>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine/edit/'.$satureday_routine['id'])?>', '<?php echo get_phrase('update_routine'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                                        <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine/delete/'.$satureday_routine['id']); ?>', getFilteredClassRoutine)"><?php echo get_phrase('delete'); ?></a>
                                                    </div>
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
</div>