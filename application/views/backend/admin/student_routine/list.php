<?php
date_default_timezone_set('Asia/Jakarta');
$date = Date('d-m-Y H:i:s'); 
$namahari = date('l', strtotime($date));
$school_id = school_id();
$active_session = active_session();
?>
<?php if(isset($class_id) && isset($section_id) && isset($room_id)): ?>
<div class="w-100 table-responsive">
    <table class="table mb-0 table-striped table-bordered table-centered">
        <tbody>
        <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('class_routine'); ?></td>
                <td class="m-1">
                        <?php
                            $this->db->where('class_id', $class_id);
                            $this->db->where('section_id', $section_id);
                            $this->db->where('room_id', $room_id);
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
<div class="row d-print-none mt-3">
    <div class="col-12 text-right"><a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i><?php echo get_phrase('print'); ?></a></div>
</div>

<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<style>
    .dropdown-toggle::after{
        display: none;
    }
</style>
