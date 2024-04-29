<?php
date_default_timezone_set('Asia/Jakarta');
$date = Date('d-m-Y H:i:s'); 
$school_id = school_id();
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
                            $search = array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'sunday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $sunday_routines = $this->db->get()->result_array();
                        	foreach($sunday_routines as $sunday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($sunday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $sunday_routine['time_start'].' - '.$sunday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $sunday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$sunday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$sunday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('monday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $monday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'monday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'monday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $monday_routines = $this->db->get()->result_array();
                        	foreach($monday_routines as $monday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($monday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $monday_routine['time_start'].' - '.$monday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $monday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$monday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$monday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('tuesday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $tuesday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'tuesday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'tuesday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $tuesday_routines = $this->db->get()->result_array();
                        	foreach($tuesday_routines as $tuesday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($tuesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $tuesday_routine['time_start'].' - '.$tuesday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $tuesday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$tuesday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$tuesday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('wednesday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $wednesday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'wednesday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'wednesday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $wednesday_routines = $this->db->get()->result_array();
                        	foreach($wednesday_routines as $wednesday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($wednesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $wednesday_routine['time_start'].' - '.$wednesday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $wednesday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$wednesday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$wednesday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('thursday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $thursday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'thursday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'thursday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $thursday_routines = $this->db->get()->result_array();
                        	foreach($thursday_routines as $thursday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($thursday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $thursday_routine['time_start'].' - '.$thursday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $thursday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$thursday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$thursday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('friday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $friday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'friday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'friday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $friday_routines = $this->db->get()->result_array();
                        	foreach($friday_routines as $friday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($friday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $friday_routine['time_start'].' - '.$friday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $friday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$friday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$friday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('saturday'); ?></td>
                <td class="m-1">

                        <?php
                            // $satureday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'saturday'))->result_array();
                            $search = array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'saturday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $satureday_routines = $this->db->get()->result_array();
                        	foreach($satureday_routines as $satureday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($satureday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $satureday_routine['time_start'].' - '.$satureday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-account"></i>
                                	<?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $satureday_routine['teacher_id']))->row('user_id'), 'name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$satureday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$satureday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
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
                            $search = array('session_id' => active_session(), 'lower(day)' => 'sunday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $sunday_routines = $this->db->get()->result_array();
                        	foreach($sunday_routines as $sunday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($sunday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $sunday_routine['time_start'].' - '.$sunday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $sunday_routine['organizations_id']))->row('name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$sunday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$sunday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('monday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $monday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'monday'))->result_array();
                            $search = array('session_id' => active_session(), 'lower(day)' => 'monday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $monday_routines = $this->db->get()->result_array();
                        	foreach($monday_routines as $monday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($monday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $monday_routine['time_start'].' - '.$monday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $monday_routine['organizations_id']))->row('name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$monday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$monday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('tuesday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $tuesday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'tuesday'))->result_array();
                            $search = array('session_id' => active_session(), 'lower(day)' => 'tuesday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $tuesday_routines = $this->db->get()->result_array();
                        	foreach($tuesday_routines as $tuesday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($tuesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $tuesday_routine['time_start'].' - '.$tuesday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $tuesday_routine['organizations_id']))->row('name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$tuesday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$tuesday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('wednesday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $wednesday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'wednesday'))->result_array();
                            $search = array('session_id' => active_session(), 'lower(day)' => 'wednesday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $wednesday_routines = $this->db->get()->result_array();
                        	foreach($wednesday_routines as $wednesday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($wednesday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $wednesday_routine['time_start'].' - '.$wednesday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $wednesday_routine['organizations_id']))->row('name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$wednesday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$wednesday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('thursday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $thursday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'thursday'))->result_array();
                            $search = array('session_id' => active_session(), 'lower(day)' => 'thursday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $thursday_routines = $this->db->get()->result_array();
                        	foreach($thursday_routines as $thursday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($thursday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $thursday_routine['time_start'].' - '.$thursday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $thursday_routine['organizations_id']))->row('name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$thursday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$thursday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('friday'); ?></td>
                <td class="m-1">

                        <?php
                        	// $friday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'friday'))->result_array();
                            $search = array('session_id' => active_session(), 'lower(day)' => 'friday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $friday_routines = $this->db->get()->result_array();
                        	foreach($friday_routines as $friday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($friday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $friday_routine['time_start'].' - '.$friday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $friday_routine['organizations_id']))->row('name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$friday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$friday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
                            </div>
                        <?php } ?>

                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('saturday'); ?></td>
                <td class="m-1">

                        <?php
                            // $satureday_routines = $this->db->get_where('routine_extracurricular', array('organizations_id' => $organizations_id, 'session_id' => active_session(), 'lower(day)' => 'saturday'))->result_array();
                            $search = array('session_id' => active_session(), 'lower(day)' => 'saturday');
                            $this->db->select('*');
                            $this->db->from('routine_extracurricular');
                            $this->db->where($search);
                            $this->db->where('school_id', $school_id);
                            $this->db->order_by('time_start', 'asc');
                            $satureday_routines = $this->db->get()->result_array();
                        	foreach($satureday_routines as $satureday_routine){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($satureday_routine['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                	<?php echo $satureday_routine['time_start'].' - '.$satureday_routine['time_finish']; ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                <?php echo $this->db->get_where('organizations', array('id' => $satureday_routine['organizations_id']))->row('name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/edit/'.$satureday_routine['id'])?>', '<?php echo get_phrase('update_routine_extracurricular'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <a class="dropdown-item" onclick="confirmModal('<?php echo route('routine_extracurricular/delete/'.$satureday_routine['id']); ?>', getFilteredRoutineExtracurricular)"><?php echo get_phrase('delete'); ?></a>
                                </div>
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
