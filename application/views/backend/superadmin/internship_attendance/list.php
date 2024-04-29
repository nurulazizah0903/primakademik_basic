<?php 
    $school_id = school_id(); 
    $active_session = active_session();
?>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="text-center">
                    <h4><?php echo get_phrase('internship_attendance_report') ?></h4>
                    <h5><?php echo get_phrase('month'); ?> : <?php echo  get_phrase(date("F", mktime(0, 0, 0, $month, 10))); ?></h5>
                </div>
            </div> <!-- end card-body-->
        </div>
    </div>
    <div class="col-md-4"></div>
</div>

<div class="w-100">
    <table class="table table-bordered table-sm table-responsive">
        <thead class="thead-dark">
            <tr style="font-size: 10px;">
                <th width = "35px"><?php echo get_phrase('student'); ?> <i class="mdi mdi-arrow-down"></i> <?php echo get_phrase('date'); ?> <i class="mdi mdi-arrow-right"></i></th>
                <?php

                    $month_of_start = date('m', $start_date);
                    $month_of_end = date('m', $end_date);

                    if($month != $month_of_start && $month == $month_of_end){

                        for ($i = 1; $i <= date('d', $end_date); $i++): 
                ?>
                    <th><?= $i; ?></th>
                <?php
                        endfor;

                    } else if($month == $month_of_start && $month != $month_of_end){

                        for ($i = date('d', $start_date); $i <= date('t', $start_date); $i++): 
                ?>
                    <th><?= $i; ?></th>
                <?php
                        endfor;  

                    } else if($month != $month_of_start && $month != $month_of_end){
                        for ($i = 1; $i <= date('t', strtotime(date("Y", $end_date).'-'.$month.'-01')); $i++): 
                ?>
                    <th><?= $i; ?></th>
                <?php
                        endfor; 
                    }

                ?>
            </tr>
        </thead>
        <tbody>
            <?php
                $this->db->select('users.name, students.id AS student_id');
                $this->db->where('internship_student.internship_id', $internship_id);
                $this->db->where('internship_student.school_id', $school_id);
                $this->db->join('students', 'internship_student.student_id=students.id');
                $this->db->join('users', 'students.user_id=users.id');
                $internship_teams = $this->db->get("internship_student")->result_array();

                foreach($internship_teams AS $list){
            ?>
                <tr>
                    <td>
                        <?= $list['name'] ?>
                    </td>
                    <?php

                        $month_of_start = date('m', $start_date);
                        $month_of_end = date('m', $end_date);

                        if($month != $month_of_start && $month == $month_of_end){

                            for ($i = 1; $i <= date('d', $end_date); $i++): 
                            $date = $i.'-'.$month.'-'.date("Y", $end_date);
                            $timestamp = strtotime($date);
                            $weekday = date('N', $timestamp);
                    ?>
                            <td class="text-center" <?= ($weekday == 7) ? "style=\"background-color: #ff000011;\"" : "" ?>>
                        <?php
                            $attendance = $this->db->get_where('internship_attendances', array('student_id' => $list['student_id'], 'school_id' => $school_id, 'session_id' => $active_session, 'timestamp' => $timestamp))->row_array();
                            
                            if($attendance['status'] == '1'){
                        ?>
                            <i class="mdi mdi-circle text-success" title="Masuk"></i>
                        <?php
                            } else if($attendance['status'] == '2'){
                        ?>
                            <i class="mdi mdi-circle text-warning" title="Izin"></i>
                        <?php
                            } else if($attendance['status'] == '3'){
                        ?>
                            <i class="mdi mdi-circle text-primary" title="Sakit"></i>
                        <?php
                            } else if($attendance['status'] == '0'){
                        ?>
                            <i class="mdi mdi-circle text-danger" title="Absen"></i>
                        <?php
                            } else if($attendance['status'] == '-1'){
                        ?>
                            <i class="mdi mdi-circle text-secondary"></i>
                        <?php
                            }
                        ?>
                            </td>
                        <?php
                            endfor;

                        } else if($month == $month_of_start && $month != $month_of_end){

                            for ($i = date('d', $start_date); $i <= date('t', $start_date); $i++): 
                                $date = $i.'-'.$month.'-'.date("Y", $end_date);
                                $timestamp = strtotime($date);
                                $weekday = date('N', $timestamp);
                        ?>
                                <td class="text-center" <?= ($weekday == 7) ? "style=\"background-color: #ff000011;\"" : "" ?>>
                            <?php
                                $attendance = $this->db->get_where('internship_attendances', array('student_id' => $list['student_id'], 'school_id' => $school_id, 'session_id' => $active_session, 'timestamp' => $timestamp))->row_array();
                                if($attendance['status'] == '1'){
                            ?>
                                <i class="mdi mdi-circle text-success" title="Masuk"></i>
                            <?php
                                } else if($attendance['status'] == '2'){
                            ?>
                                <i class="mdi mdi-circle text-warning" title="Izin"></i>
                            <?php
                                } else if($attendance['status'] == '3'){
                            ?>
                                <i class="mdi mdi-circle text-primary" title="Sakit"></i>
                            <?php
                                } else if($attendance['status'] == '0'){
                            ?>
                                <i class="mdi mdi-circle text-danger" title="Absen"></i>
                            <?php
                                } else if($attendance['status'] == '-1'){
                            ?>
                                <i class="mdi mdi-circle text-secondary"></i>
                            <?php
                                }
                            ?>
                                </td>
                            <?php
                            endfor;  

                        } else if($month != $month_of_start && $month != $month_of_end){
                            for ($i = 1; $i <= date('t', strtotime(date("Y", $end_date).'-'.$month.'-01')); $i++): 
                                $date = $i.'-'.$month.'-'.date("Y", $end_date);
                                $timestamp = strtotime($date);
                                $weekday = date('N', $timestamp);
                        ?>
                                <td class="text-center" <?= ($weekday == 7) ? "style=\"background-color: #ff000011;\"" : "" ?>>
                            <?php
                                $attendance = $this->db->get_where('internship_attendances', array('student_id' => $list['student_id'], 'school_id' => $school_id, 'session_id' => $active_session, 'timestamp' => $timestamp))->row_array();
                                if($attendance['status'] == '1'){
                            ?>
                                <i class="mdi mdi-circle text-success" title="Masuk"></i>
                            <?php
                                } else if($attendance['status'] == '2'){
                            ?>
                                <i class="mdi mdi-circle text-warning" title="Izin"></i>
                            <?php
                                } else if($attendance['status'] == '3'){
                            ?>
                                <i class="mdi mdi-circle text-primary" title="Sakit"></i>
                            <?php
                                } else if($attendance['status'] == '0'){
                            ?>
                                <i class="mdi mdi-circle text-danger" title="Absen"></i>
                            <?php
                                } else if($attendance['status'] == '-1'){
                            ?>
                                <i class="mdi mdi-circle text-secondary"></i>
                            <?php
                                }
                            ?>
                                </td>
                            <?php
                            endfor; 
                        }

                    ?>
                        
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="row d-print-none mt-3">
    <div class="col-12 text-right">
        <font color="red">*</font><b><?php echo get_phrase('klik_date_for_attendance'); ?></b>
        <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i><?php echo get_phrase('print'); ?></a></div>
</div>