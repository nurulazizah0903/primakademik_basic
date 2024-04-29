<?php
date_default_timezone_set('Asia/Jakarta');
$date = Date('d-m-Y H:i:s'); 
$namahari = date('l', strtotime($date));
?>
<?php if(isset($organizations_id)): ?>
    <div class="w-100 table-responsive">
    <table class="table mb-0 table-striped table-bordered table-centered">
        <tbody>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('sunday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $sunday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'sunday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'sunday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $sunday_routines = $this->db->get()->result_array();
                        	foreach($sunday_routines as $sunday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($sunday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $sunday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $sunday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr></tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('monday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $monday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'monday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'monday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $monday_routines = $this->db->get()->result_array();
                        	foreach($monday_routines as $monday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($monday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $monday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $monday_routine['teacher_id']))->row('user_id'), 'name'); ?>
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
                        	// $tuesday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'tuesday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'tuesday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $tuesday_routines = $this->db->get()->result_array();
                        	foreach($tuesday_routines as $tuesday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($tuesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $tuesday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $tuesday_routine['teacher_id']))->row('user_id'), 'name'); ?>
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
                        	// $wednesday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'wednesday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'wednesday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $wednesday_routines = $this->db->get()->result_array();
                        	foreach($wednesday_routines as $wednesday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($wednesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $wednesday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $wednesday_routine['teacher_id']))->row('user_id'), 'name'); ?>
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
                        	// $thursday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'thursday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'thursday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $thursday_routines = $this->db->get()->result_array();
                        	foreach($thursday_routines as $thursday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($thursday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $thursday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $thursday_routine['teacher_id']))->row('user_id'), 'name'); ?>
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
                        	// $friday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'friday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'friday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $friday_routines = $this->db->get()->result_array();
                        	foreach($friday_routines as $friday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($friday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $friday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $friday_routine['teacher_id']))->row('user_id'), 'name'); ?>
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
                            // $satureday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'saturday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'saturday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $satureday_routines = $this->db->get()->result_array();
                        	foreach($satureday_routines as $satureday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($satureday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $satureday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $satureday_routine['teacher_id']))->row('user_id'), 'name'); ?>
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
<?php elseif(!isset($organizations_id)): ?>
    <div class="w-100 table-responsive">
    <table class="table mb-0 table-striped table-bordered table-centered">
        <tbody>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('sunday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $sunday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'sunday'))->result_array();
                            $search = array('school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'sunday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $sunday_routines = $this->db->get()->result_array();
                        	foreach($sunday_routines as $sunday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($sunday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $sunday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $sunday_routine['organizations_id']))->row('name'); ?>
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
                        	// $monday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'monday'))->result_array();
                            $search = array('school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'monday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $monday_routines = $this->db->get()->result_array();
                        	foreach($monday_routines as $monday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($monday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $monday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $monday_routine['organizations_id']))->row('name'); ?>
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
                        	// $tuesday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'tuesday'))->result_array();
                            $search = array('school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'tuesday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $tuesday_routines = $this->db->get()->result_array();
                        	foreach($tuesday_routines as $tuesday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($tuesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $tuesday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $tuesday_routine['organizations_id']))->row('name'); ?>
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
                        	// $wednesday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'wednesday'))->result_array();
                            $search = array('school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'wednesday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $wednesday_routines = $this->db->get()->result_array();
                        	foreach($wednesday_routines as $wednesday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($wednesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $wednesday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $wednesday_routine['organizations_id']))->row('name'); ?>
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
                        	// $thursday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'thursday'))->result_array();
                            $search = array('school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'thursday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $thursday_routines = $this->db->get()->result_array();
                        	foreach($thursday_routines as $thursday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($thursday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $thursday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $thursday_routine['organizations_id']))->row('name'); ?>
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
                        	// $friday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'friday'))->result_array();
                            $search = array('school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'friday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $friday_routines = $this->db->get()->result_array();
                        	foreach($friday_routines as $friday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($friday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $friday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $friday_routine['organizations_id']))->row('name'); ?>
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
                            // $satureday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'saturday'))->result_array();
                            $search = array('school_id' => school_id(), 'session_id' => active_session(), 'lower(day)' => 'saturday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            
                            $satureday_routines = $this->db->get()->result_array();
                        	foreach($satureday_routines as $satureday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($satureday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $this->db->get_where('operational_hour', array('id' => $satureday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $satureday_routine['organizations_id']))->row('name'); ?>
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
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<style>
    .dropdown-toggle::after{
        display: none;
    }
</style>