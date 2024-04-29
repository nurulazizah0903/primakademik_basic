<?php
date_default_timezone_set('Asia/Jakarta');
$date = Date('d-m-Y H:i:s'); 
$namahari = date('l', strtotime($date));
?>
<?php if(isset($teacher_id)): ?>
    <table class="table mb-0 table-striped table-bordered table-centered">
        <tbody>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('class_routine'); ?></td>
                <td class="m-1">
                        <?php
                            $this->db->from('routines');
                            
                            $sunday_schedules = $this->db->get_where('routines', array('teacher_id' => $teacher_id, 'session_id' => active_session(), 'day' => $namahari))->result_array();
                        	foreach($sunday_schedules as $sunday_schedule){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($sunday_schedule['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                	<?php echo $this->db->get_where('subjects', array('id' => $sunday_schedule['subject_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                    <?php echo $this->db->get_where('operational_hour', array('id' => $sunday_routine['hour_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-home-automation"></i>
                                	<?php echo $this->db->get_where('class_rooms', array('id' => $sunday_schedule['room_id']))->row('name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                            </div>
                        <?php } ?>
                </td>
            </tr>
            <tr>
                <td style="font-weight: bold; width : 100px;"><?php echo get_phrase('routine_extracurricular'); ?></td>
                <td class="m-1">

                        <?php
                            $this->db->from('routine_extracurricular');
                            
                        	$monday_schedule_extracurriculars = $this->db->get_where('routine_extracurricular', array('teacher_id' => $teacher_id, 'session_id' => active_session(), 'day' => $namahari))->result_array();
                        	foreach($monday_schedule_extracurriculars as $monday_schedule_extracurriculars){
                        ?>
                            <div class="text-left btn-group">
                            <button type="button" class="btn <?= ($monday_schedule_extracurriculars['day'] == $namahari) ? 'btn-success' : 'btn-secondary' ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-book-open-variant"></i>
                                	<?php echo $this->db->get_where('organizations', array('id' => $monday_schedule_extracurriculars['organizations_id']))->row('name'); ?>
                                </p>
                                <p style="margin-bottom: 0px; font-size: 10px;"><i class="mdi mdi-clock"></i>
                                    <?php echo $this->db->get_where('operational_hour', array('id' => $monday_schedule_extracurriculars['hour_id']))->row('name'); ?>
                                </p>
                                <span class="caret"></span>
                                </button>
                            </div>
                        <?php } ?>

                </td>
            </tr>
        </tbody>
    </table>
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
