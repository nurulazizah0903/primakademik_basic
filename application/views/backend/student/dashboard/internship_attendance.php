<?php

$school_id = school_id();
$session_id = active_session();
$student_id = $param1;

$this->db->where('internship.session_id', $session_id);
$this->db->where('internship_student.school_id', $school_id);
$this->db->where('internship_student.student_id', $student_id);
$this->db->join('internship', 'internship_student.internship_id = internship.id');
$internship_data = $this->db->get('internship_student')->row_array();
// print_r($internship_data);

?>

<form method="POST" class="d-block ajaxForm responsive_media_query" action="<?php echo route('update_internship_attendance/create_attendance_internship'); ?>" style="min-width: 300px; max-width: 600px;">
<input type="hidden" name="timestamp" id="timestamp" value="<?= date('Y-m-d')?>">
<input type="hidden" name="internship_id" id="internship_id" value="<?= $internship_data['internship_id'] ?>">
<input type="hidden" name="student_id" value="<?= $internship_data['student_id'] ?>">
<input type="hidden" name="session_id" id="session_id" value="<?= $internship_data['session_id'] ?>">
<input type="hidden" name="school_id" id="school_id" value="<?= $internship_data['school_id'] ?>">

    <div class="row" id = "student_content" style="margin-left: 2px;">
        <div class="table-responsive-sm row col-md-12" style="padding-right: 0px;">
            <table class="table table-centered mb-0">
                <thead>
                    <tr>
                        <th colspan="4"><?php echo get_phrase('status'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="" name="status" value="1" class="present" checked required> <?php echo get_phrase('present'); ?> 
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="" name="status" value="2" class="permission" required> <?php echo get_phrase('permission'); ?> 
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="" name="status" value="3" class="sick" required> <?php echo get_phrase('sick'); ?>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="" name="status" value="0" class="absent" required> <?php echo get_phrase('absent'); ?>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <h5 style="font-weight: bold;"><?php echo get_phrase('upload_image'); ?></h5>
        <div class="col-md-12 custom-file-upload">
            <div class="wrapper-image-preview">
                <div class="box" style="width: 90%;">
                    <div class="js--image-preview" style="background-image: url(<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>); background-color: #F5F5F5;"></div>
                    <div class="upload-options">
                        <label for="photo" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_an_image'); ?> </label>
                        <input id="photo" style="visibility:hidden;" type="file" class="image-upload" name="photo" accept="image/*">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group col-md-12 mt-4">
        <button class="btn w-100 btn-primary" type="submit"><?php echo get_phrase('update_attendance'); ?></button>
    </div>
</form>
</center>
<script>
    initDataTable('datatable');
    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit2(e, form, getDailtyAttendance);
    });

    function present_all() {
        $(".present").prop('checked', true);
    }

    function absent_all() {
        $(".absent").prop('checked',true);
    }

    function holiday() {
        $(".holiday").prop('checked',true);
    }
</script>