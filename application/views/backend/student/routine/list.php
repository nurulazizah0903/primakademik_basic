<?php
date_default_timezone_set('Asia/Jakarta');
$date = Date('d-m-Y H:i:s'); 
$namahari = date('l', strtotime($date));
$school_id = school_id();
$active_session = active_session();
?>
<div class="w-100 table-responsive">
    <table class="table mb-0 table-striped table-bordered table-centered">
        <tbody>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('sunday'); ?></td>
                <td class="m-1">
                        <?php
                        	// $sunday_routines = $this->db->get_where('routines', array('class_id' => $class_id, 'room_id' => $room_id, 'section_id' => $section_id, 'school_id' => $school_id, 'session_id' => $active_session, 'lower(day)' => 'sunday'))->result_array();
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
                            </div>
                        <?php } ?>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
<div class="row d-print-none mt-3">
    <div class="col-12 text-right"><a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i><?php echo get_phrase('print'); ?></a></div>
</div>
<style>
    .dropdown-toggle::after{
        display: none;
    }
</style>
