<?php $school_id = school_id(); ?>
<center>
<form method="POST" class="d-block ajaxForm responsive_media_query" action="<?php echo route('attendance_employee/take_attendance_employee'); ?>" style="min-width: 300px; max-width: 400px;">
<input type="hidden" name="date" id="date_on_taking_attendance" value="<?= $param1?>">
<input type="hidden" name="role" id="class_id_on_taking_attendance" value="<?= $param2?>">

    <div class="row" id = "student_content" style="margin-left: 2px;">

    <div class="table-responsive-sm row col-md-12" style="padding-right: 0px;">
        <table id="datatable" class="table table-bordered table-centered mb-0">
            <thead>
                <tr>
                    <th><?php echo get_phrase('name'); ?></th>
                    <th><?php echo get_phrase('status'); ?></th>
                </tr>
            </thead>
            <tbody>
            <?php $employees = $this->db->get_where('users', array('school_id' => $school_id, 'role' => $param2))->result_array();?>
                    <?php foreach($employees as $employee): ?>
                    <tr>
                        <td>
                        <?= $employee['name']; ?>
                        </td>
                        <td>
                            <input type="hidden" name="user_id[]" value="<?php echo $employee['id']; ?>">
                            <div class="custom-control custom-radio">
                                <?php $update_attendance = $this->db->get_where('daily_attendance_employee', array('timestamp' => strtotime(($param1)), 'session_id' => active_session(), 'school_id' => $school_id, 'user_id' => $employee['id'])); ?>
                                <?php if($update_attendance->num_rows() > 0): ?>
                                    <?php $row = $update_attendance->row(); ?>
                                    <input type="hidden" name="attendance_id[]" value="<?php echo $row->id; ?>">
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="1" class="present" <?php if($row->status == 1) echo 'checked'; ?> required> <?php echo get_phrase('present'); ?> <br/>
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="2" class="permission" <?php if($row->status == 2) echo 'checked'; ?> required> <?php echo get_phrase('permission'); ?> <br/>
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="3" class="sick" <?php if($row->status == 3) echo 'checked'; ?> required> <?php echo get_phrase('sick'); ?> <br/>
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="0" class="absent" <?php if($row->status == 0) echo 'checked'; ?> required> <?php echo get_phrase('absent'); ?>
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="-1" class="holiday" <?php if($row->status == -1) echo 'checked'; ?> required style="display: none;">
                                <?php else: ?>
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="1" class="present" checked required> <?php echo get_phrase('present'); ?> <br/>
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="2" class="permission" required> <?php echo get_phrase('permission'); ?> <br/>
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="3" class="sick" required> <?php echo get_phrase('sick'); ?> <br/>
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="0" class="absent" required> <?php echo get_phrase('absent'); ?>
                                    <input type="radio" id="" name="status-<?php echo $employee['id']; ?>" value="-1" class="holiday" required style="display: none;">
                                <?php endif; ?>
                            </div>
                        </td>
                        <!-- <td>
                            <div class="form-group">
                                <input class="form-control" type="text" name="info" id="info">
                            </div>
                        </td> -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
        ajaxSubmit2(e, form, getDailtyAttendanceEmployee);
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
