<?php $school_id = school_id(); ?>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="text-center">
                    <h4><?php echo get_phrase('attendance_report').' '.get_phrase('of').' '.date('F', strtotime($month)); ?></h4>
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

<div class="w-100">
    <table  class="table table-bordered table-sm">
        <thead class="thead-dark">
            <tr style="font-size: 10px;">
                <th width = "40px"><?= $role ?> <i class="mdi mdi-arrow-down"></i> <?php echo get_phrase('date'); ?> <i class="mdi mdi-arrow-right"></i></th>
                <?php
                    $number_of_days = date('t', strtotime($month.' '.$year));
                    for ($i = 1; $i <= $number_of_days; $i++): 
                    $tanggal = $i.'-'.$month.'-'.$year;
                    ?>
                    <th><a onclick="largeModal('<?php echo site_url('modal/popup/attendance_employee/modal_add/'.$tanggal.'/'.$role)?>', '<?= get_phrase('take_attendance_employee'); ?>')" data-toggle="tooltip" data-placement="top" title=""><?php echo $i; ?></a></th>
                <?php endfor; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $empolyee_id_count = 0;
            $active_sesstion = active_session();
            $this->db->order_by('user_id', 'asc');
            $attendance_of_empolyees = $this->db->get_where('daily_attendance_employee', array('school_id' => $school_id, 'session_id' => $active_sesstion, 'role' => $role))->result_array();
            // var_dump($attendance_of_empolyees[0]);
            //, 'session_id' => $active_sesstion, 'role' => $role
                foreach($attendance_of_empolyees as $attendance_of_empolyee){ ?>
                    <?php if(date('m', strtotime($month)) == date('m', $attendance_of_empolyee['timestamp'])): ?>
                        <?php if($empolyee_id_count != $attendance_of_empolyee['user_id']): ?>
                            <tr>
                                <td style="font-size: 12px;">
                                <?php echo $this->user_model->get_user_details($attendance_of_empolyee['user_id'], 'name'); ?>
                                </td>
                                <?php for ($i = 1; $i <= $number_of_days; $i++): ?>
                                    <?php $date = $i.' '.$month.' '.$year; ?>
                                    <?php $timestamp = strtotime($date); ?>
                                    <?php $weekday = date('N', $timestamp); ?>
                                    <td class="text-center" <?= ($weekday == 7) ? "style=\"background-color: #ff000011;\"" : "" ?>>
                                        <?php 
                                        $attendance = $this->db->get_where('daily_attendance_employee', array('school_id' => $school_id, 'session_id' => $active_sesstion, 'user_id' => $attendance_of_empolyee['user_id'], 'timestamp' => $timestamp))->row_array();
                                        $status = $this->db->get_where('daily_attendance_employee', array('school_id' => $school_id, 'session_id' => $active_sesstion, 'user_id' => $attendance_of_empolyee['user_id'], 'timestamp' => $timestamp))->row('status'); 
                                        // var_dump($status);
                                        ?>
                                        <?php if($status == 1){ ?>
                                            <a onclick="largeModal('<?php echo site_url('modal/popup/attendance_employee/confirm/'.$attendance['id'])?>', '<?= get_phrase('attendance_confirm'); ?>')" data-toggle="tooltip" data-placement="top" title=""><i class="mdi mdi-circle text-success" title="Masuk"></i></a>
                                        <?php }elseif($status === "2"){ ?>
                                            <a onclick="largeModal('<?php echo site_url('modal/popup/attendance_employee/confirm/'.$attendance['id'])?>', '<?= get_phrase('attendance_confirm'); ?>')" data-toggle="tooltip" data-placement="top" title=""><i class="mdi mdi-circle text-warning" title="Izin"></i></a>
                                        <?php }elseif($status === "3"){ ?>
                                            <a onclick="largeModal('<?php echo site_url('modal/popup/attendance_employee/confirm/'.$attendance['id'])?>', '<?= get_phrase('attendance_confirm'); ?>')" data-toggle="tooltip" data-placement="top" title=""><i class="mdi mdi-circle text-primary" title="Sakit"></i></a>
                                        <?php }elseif($status === "0"){ ?>
                                            <a onclick="largeModal('<?php echo site_url('modal/popup/attendance_employee/confirm/'.$attendance['id'])?>', '<?= get_phrase('attendance_confirm'); ?>')" data-toggle="tooltip" data-placement="top" title=""><i class="mdi mdi-circle text-danger" title="Absen"></i></a>
                                        <?php }elseif($status === "-1"){ ?>
                                            <a onclick="largeModal('<?php echo site_url('modal/popup/attendance_employee/confirm/'.$attendance['id'])?>', '<?= get_phrase('attendance_confirm'); ?>')" data-toggle="tooltip" data-placement="top" title=""><i class="mdi mdi-circle text-secondary"></i></a>
                                        <?php } ?>
                                    </td>
                                <?php endfor; ?>
                            </tr>
                        <?php endif; ?>
                        <?php $empolyee_id_count = $attendance_of_empolyee['user_id']; ?>
                    <?php endif; ?>                  
                <?php } ?>
        </tbody>
    </table>
</div>
<div class="row d-print-none mt-3">
    <div class="col-12 text-right"><a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i><?php echo get_phrase('print'); ?></a></div>
</div>