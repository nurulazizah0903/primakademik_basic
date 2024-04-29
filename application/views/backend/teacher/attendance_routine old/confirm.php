<?php
    $school_id = school_id();
    $attendance_of_students = $this->db->get_where('daily_attendance_routines', array('id' => $param1))->result_array();
    // $user_data = $this->user_model->get_student_details_by_id('student', $attendance_of_students['student_id']);
    // $date = $i.' '.$month.' '.$year;
    // $timestamp = strtotime($date);
    // $weekday = date('N', $timestamp); 
    // var_dump($user_data);
?>
<div class="h-100">
        <div class="col-md-12">
            <?php foreach($attendance_of_students as $attendance_of_student){ ?>
            <form method="POST" class="d-block ajaxForm" action="<?php echo route('attendance_routine/confirm_routine/'.$param1); ?>" enctype="multipart/form-data">
            <table class="table table-centered mb-0">
                <tbody>
                    <tr>
                        <td style="font-weight: bold;"><?= get_phrase('keterangan_absen'); ?></td>
                        <td>
                            <?php  $status = $this->db->get_where('daily_attendance_routines', array('id' => $attendance_of_student['id']))->row('status');?>
                            <?php if($status == 1){ ?>
                            <i class="mdi mdi-circle text-success" title="Masuk"></i> <?= get_phrase('present'); ?>
                            <?php }elseif($status === "2"){ ?>
                            <i class="mdi mdi-circle text-warning" title="Izin"></i> <?= get_phrase('permission'); ?>
                            <?php }elseif($status === "3"){ ?>
                                <i class="mdi mdi-circle text-primary" title="Sakit"></i> <?= get_phrase('sick'); ?>
                            <?php }elseif($status === "0"){ ?>
                                <i class="mdi mdi-circle text-danger" title="Absen"></i> <?= get_phrase('absent'); ?>
                            <?php }elseif($status === "-1"){ ?>
                                <i class="mdi mdi-circle text-secondary"></i>
                        <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;"><?php echo get_phrase('confirm'); ?></td>
                        <td>
                            <input type="radio" id="konfirmasi" name="confirm" value="Konfirmasi" 
                            <?php if($attendance_of_student['confirm'] == 'Konfirmasi'):?>checked<?php endif; ?>>
                            <label><?= get_phrase('konfirmasi'); ?></label><br>

                            <input type="radio" id="tidak_konfirmasi" name="confirm" value="Tidak Konfirmasi" 
                            <?php if($attendance_of_student['confirm'] == 'Tidak Konfirmasi'):?>checked<?php endif; ?>>
                            <label><?= get_phrase('tidak_konfirmasi'); ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;"><?php echo get_phrase('keterangan'); ?></td>
                        <td>
                            <textarea class="form-control" id="example-textarea" rows="5" name = "caption" placeholder="keterangan"><?= $attendance_of_student['caption']?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold;"><?php echo get_phrase('bukti'); ?>:<br><font style="color:red;"><?= get_phrase('if_need')?></font></td>
                        <td>
                            <?php
                            if (!empty($attendance_of_student['file'])){
                            ?>
                                <a href="<?= base_url();?>uploads/attendances/<?= $attendance_of_student['file']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>
                            <?php  
                            }else{
                            ?>
                            <input type="file" id="file" class="form-control" name="file">
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="text-center">
                <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
            </div>
        </form>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">

initCustomFileUploader();

$(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, getDailtyAttendanceRoutine);
    });
</script>