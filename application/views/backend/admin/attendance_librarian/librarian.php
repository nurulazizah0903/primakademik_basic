<?php $school_id = school_id(); ?>
<div class="row" style="margin-bottom: 10px; width: 100%;">
    <div class="col-4"><a href="javascript:" class="btn btn-sm btn-secondary" onclick="present_all()"><?php echo get_phrase('present_all'); ?></a></div>
    <div class="col-4"><a href="javascript:" class="btn btn-sm btn-secondary" onclick="holiday()"><?php echo get_phrase('holiday'); ?></a></div>
    <div class="col-4"><a href="javascript:" class="btn btn-sm btn-secondary float-right" onclick="absent_all()"><?php echo get_phrase('absent_all'); ?></a></div>
</div>

<div class="table-responsive-sm row col-md-12" style="padding-right: 0px;">
    <table class="table table-bordered table-centered mb-0">
        <thead>
            <tr>
                <th><?php echo get_phrase('name'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $librarians = $this->db->get_where('users', array('school_id' => $school_id, 'role' => 'librarian'))->result_array(); ?>
                <?php foreach($librarians as $librarian): ?>
                <tr>
                    <td>
                    <?= $librarian['name']; ?>
                    </td>
                    <td>
                        <input type="hidden" name="user_id[]" value="<?php echo $librarian['id']; ?>">
                        <div class="custom-control custom-radio">
                            <?php $update_attendance = $this->db->get_where('daily_attendance_librarians', array('timestamp' => $attendance_date, 'session_id' => active_session(), 'school_id' => $school_id, 'user_id' => $librarian['id'])); ?>
                            <?php if($update_attendance->num_rows() > 0): ?>
                                <?php $row = $update_attendance->row(); ?>
                                <input type="hidden" name="attendance_id[]" value="<?php echo $row->id; ?>">
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="1" class="present" <?php if($row->status == 1) echo 'checked'; ?> required> <?php echo get_phrase('present'); ?> <br/>
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="2" class="permission" <?php if($row->status == 2) echo 'checked'; ?> required> <?php echo get_phrase('permission'); ?> <br/>
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="3" class="sick" <?php if($row->status == 3) echo 'checked'; ?> required> <?php echo get_phrase('sick'); ?> <br/>
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="0" class="absent" <?php if($row->status == 0) echo 'checked'; ?> required> <?php echo get_phrase('absent'); ?>
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="-1" class="holiday" <?php if($row->status == -1) echo 'checked'; ?> required style="display: none;">
                            <?php else: ?>
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="1" class="present" required> <?php echo get_phrase('present'); ?> <br/>
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="2" class="permission" required> <?php echo get_phrase('permission'); ?> <br/>
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="3" class="sick" required> <?php echo get_phrase('sick'); ?> <br/>
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="0" class="absent" checked required> <?php echo get_phrase('absent'); ?>
                                <input type="radio" id="" name="status-<?php echo $librarian['id']; ?>" value="-1" class="holiday" required style="display: none;">
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

<script type="text/javascript">
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
