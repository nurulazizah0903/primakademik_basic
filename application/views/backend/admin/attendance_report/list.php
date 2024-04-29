<?php
print_r($class_id);
print_r($section_id);
print_r($date_from);
print_r($date_to);

?>
<?php $school_id = school_id(); ?>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="text-center">
                    <h5><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('classes', array('id' => $class_id))->row('name'); ?></h5>
                    <h5><?php echo get_phrase('section'); ?> : <?php echo $this->db->get_where('sections', array('id' => $section_id))->row('name'); ?></h5>
                </div>
            </div> <!-- end card-body-->
        </div>
    </div>
    <div class="col-md-4"></div>
</div>

<div class="w-100">
    <table  class="table table-bordered table-sm">
        <thead class="thead-dark">
            <tr style="font-size: 10px;">
                <th width = "40px"><?php echo get_phrase('student'); ?> <i class="mdi mdi-arrow-down"></i> <?php echo get_phrase('date'); ?> <i class="mdi mdi-arrow-right"></i></th>
                <?php
                    // $number_of_days = date('m', $attendance_date) == 2 ? (date('Y', $attendance_date) % 4 ? 28 : (date('m', $attendance_date) % 100 ? 29 : (date('m', $attendance_date) % 400 ? 28 : 29))) : ((date('m', $attendance_date) - 1) % 7 % 2 ? 30 : 31);
                    for ($i = $date_from; $i <= $date_to; $i++): ?>
                    <th><?php echo $i; ?></th>
                <?php endfor; die; ?>

            </tr>
        </thead>
        <tbody>
            <?php
            $student_id_count = 0;
            $active_sesstion = active_session();
            $this->db->order_by('student_id', 'asc');
            $attendance_of_students = $this->db->get_where('daily_attendances', array('class_id' => $class_id, 'section_id' => $section_id, 'school_id' => $school_id, 'session_id' => $active_sesstion))->result_array();
                foreach($attendance_of_students as $attendance_of_student){ ?>
                    <?php if(date('m', $attendance_date) == date('m', $attendance_of_student['timestamp'])): ?>
                        <?php if($student_id_count != $attendance_of_student['student_id']): ?>
                            <tr>
                                <td style="font-size: 12px;"><?php echo $this->user_model->get_user_details($this->db->get_where('students', array('id' => $attendance_of_student['student_id']))->row('user_id'), 'name'); ?></td>
                                <?php for ($i = $date_from; $i <= $date_to; $i++): ?>
                                    <?php $date = $i.' '.$month.' '.$year; ?>
                                    <?php $timestamp = strtotime($date); ?>
                                    <?php $weekday = date('N', $timestamp); ?>
                                    <td class="text-center" <?= ($weekday == 7) ? "style=\"background-color: #ff000011;\"" : "" ?>>
                                        <?php 
                                        $attendance = $this->db->get_where('daily_attendances', array('class_id' => $class_id, 'section_id' => $section_id, 'school_id' => $school_id, 'session_id' => $active_sesstion, 'student_id' => $attendance_of_student['student_id'], 'timestamp' => $timestamp))->row_array();
                                        $status = $this->db->get_where('daily_attendances', array('class_id' => $class_id, 'section_id' => $section_id, 'school_id' => $school_id, 'session_id' => $active_sesstion, 'student_id' => $attendance_of_student['student_id'], 'timestamp' => $timestamp))->row('status'); ?>
                                        <?php if($status == 1){ ?>
                                            <i class="mdi mdi-circle text-success" title="Masuk"></i>
                                        <?php }elseif($status === "2"){ ?>
                                            <i class="mdi mdi-circle text-warning" title="Izin"></i>
                                        <?php }elseif($status === "3"){ ?>
                                            <i class="mdi mdi-circle text-primary" title="Sakit"></i>
                                        <?php }elseif($status === "0"){ ?>
                                            <i class="mdi mdi-circle text-danger" title="Absen"></i>
                                        <?php }elseif($status === "-1"){ ?>
                                            <i class="mdi mdi-circle text-secondary"></i>
                                        <?php } ?>
                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endif; ?>
                        <?php $student_id_count = $attendance_of_student['student_id']; ?>
                    <?php endif; ?>                 
                <?php } ?>
        </tbody>
    </table>
</div>
<div class="row d-print-none mt-3">
    <div class="col-12 text-right"><a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i><?php echo get_phrase('print'); ?></a></div>
</div>