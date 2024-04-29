<?php $school_id = school_id(); ?>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="text-center">
                    <h4><?php echo get_phrase('attendance_report').' '.get_phrase('of').' '.date('F', $attendance_date); ?></h4>
                    <h5>
                        <?php echo get_phrase('last_updated_at'); ?> :
                        <?php if (get_settings('date_of_last_updated_attendance') == ""): ?>
                            <?php echo get_phrase('not_updated_yet'); ?>
                        <?php else: ?>
                            <?php echo date('d-M-Y', get_settings('date_of_last_updated_attendance')); ?> <br>
                            <?php echo get_phrase('time'); ?> : <?php echo date('H:i:s', get_settings('date_of_last_updated_attendance')); ?>
                        <?php endif; ?>
                    </h5>
                </div>
            </div> <!-- end card-body-->
        </div>
    </div>
    <div class="col-md-4"></div>
</div>

<div class="w-100 table-responsive">
    <table  class="table table-bordered table-sm">
        <thead class="thead-dark">
            <tr style="font-size: 12px;">
                <th width = "40px"><?php echo get_phrase('teacher'); ?> <i class="mdi mdi-arrow-down"></i> <?php echo get_phrase('date'); ?> <i class="mdi mdi-arrow-right"></i></th>
                <?php
                    $number_of_days = date('m', $attendance_date) == 2 ? (date('Y', $attendance_date) % 4 ? 28 : (date('m', $attendance_date) % 100 ? 29 : (date('m', $attendance_date) % 400 ? 28 : 29))) : ((date('m', $attendance_date) - 1) % 7 % 2 ? 30 : 31);
                    for ($i = 1; $i <= $number_of_days; $i++): ?>
                    <th><?php echo $i; ?></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $teacher_id_count = 0;
            $active_sesstion = active_session();
            $this->db->order_by('teacher_id', 'asc');
            $attendance_of_teachers = $this->db->get_where('daily_attendance_teachers', array('school_id' => $school_id, 'session_id' => $active_sesstion))->result_array();
                foreach($attendance_of_teachers as $attendance_of_teacher){ ?>
                    <?php if(date('m', $attendance_date) == date('m', $attendance_of_teacher['timestamp'])): ?>
                        <?php if($teacher_id_count != $attendance_of_teacher['teacher_id']): ?>
                            <tr>
                                <td><?php echo $this->user_model->get_user_details($this->db->get_where('teachers', array('id' => $attendance_of_teacher['teacher_id']))->row('user_id'), 'name'); ?></td>
                                <?php for ($i = 1; $i <= $number_of_days; $i++): ?>
                                    <?php $date = $i.' '.$month.' '.$year; ?>
                                    <?php $timestamp = strtotime($date); ?>
                                    <?php $weekday = date('N', $timestamp); ?>
                                    <td class="text-center" <?= ($weekday == 7) ? "style=\"background-color: #ff000011;\"" : "" ?>>
                                        <?php $status = $this->db->get_where('daily_attendance_teachers', array('school_id' => $school_id, 'session_id' => $active_sesstion, 'teacher_id' => $attendance_of_teacher['teacher_id'], 'timestamp' => $timestamp))->row('status'); ?>
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
                        <?php $teacher_id_count = $attendance_of_teacher['teacher_id']; ?>
                    <?php endif; ?>                 
                <?php } ?>
        </tbody>
    </table>
</div>
<div class="row d-print-none mt-3">
    <div class="col-12 text-right"><a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i><?php echo get_phrase('print'); ?></a></div>
</div>