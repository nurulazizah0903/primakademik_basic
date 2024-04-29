<?php $school_id = school_id(); ?>
<form method="POST" class="col-md-12 ajaxForm" action="<?php echo route('student/create_bulk_student'); ?>" id = "student_admission_form">
    <div class="row justify-content-md-center">
        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" onchange="classWiseSection(this.value)" required>
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($classes as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0" id = "section_content">
            <select name="section_id" id="section_id" class="form-control select2" data-toggle = "select2" required >
                <option value=""><?php echo get_phrase('select_section'); ?></option>
            </select>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <select name="room_id" id="room_id" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_class_room'); ?></option>
                <?php $class_rooms = $this->db->get_where('class_rooms', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($class_rooms as $class_room){ ?>
                    <option value="<?php echo $class_room['id']; ?>"><?php echo $class_room['name']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <br>
    <div id = "first-row">
        <div class="row">
            <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <div class="row justify-content-md-center">
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input type="text" name="student_name[]" class="form-control"  value="" placeholder="<?php echo get_phrase('student_name'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input type="text" name="student_email[]" class="form-control"  value="" placeholder="<?php echo get_phrase('student_email'); ?>/<?php echo get_phrase('phone'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input type="password" name="student_password[]" class="form-control"  value="" placeholder="<?php echo get_phrase('student_password'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <select name="student_gender[]" class="form-control" required>
                            <option value=""><?php echo get_phrase('select_gender'); ?></option>
                            <option value="Male"><?php echo get_phrase('male'); ?></option>
                            <option value="Female"><?php echo get_phrase('female'); ?></option>
                            <option value="Others"><?php echo get_phrase('others'); ?></option>
                        </select>
                    </div>
                </div><br>
                <div class="row justify-content-md-center">
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input type="text" name="parent_name[]" class="form-control"  value="" placeholder="<?php echo get_phrase('parent_name'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input type="text" name="parent_email[]" class="form-control"  value="" placeholder="<?php echo get_phrase('parent_email'); ?>/<?php echo get_phrase('phone'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input type="password" name="parent_password[]" class="form-control"  value="" placeholder="<?php echo get_phrase('parent_password'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <select name="parent_gender[]" class="form-control" required>
                            <option value=""><?php echo get_phrase('select_gender'); ?></option>
                            <option value="Male"><?php echo get_phrase('male'); ?></option>
                            <option value="Female"><?php echo get_phrase('female'); ?></option>
                            <option value="Others"><?php echo get_phrase('others'); ?></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <div class="row justify-content-md-center">
                    <div class="form-group col">
                        <button type="button" class="btn btn-icon btn-success" onclick="appendRow()"> <i class="mdi mdi-plus"></i> </button>
                    </div>
                </div>
            </div>
        </div><br>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4 mt-2"><?php echo get_phrase('add_students'); ?></button>
    </div>
</form>

<div id = "blank-row" style="display: none;">
    <div class="row student-row">
        <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <div class="row justify-content-md-center">
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <input type="text" name="student_name[]" class="form-control"  value="" placeholder="<?php echo get_phrase('student_name'); ?>" required>
                </div>
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <input type="text" name="student_email[]" class="form-control"  value="" placeholder="<?php echo get_phrase('student_email'); ?>/<?php echo get_phrase('phone'); ?>" required>
                </div>
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <input type="password" name="student_password[]" class="form-control"  value="" placeholder="<?php echo get_phrase('student_password'); ?>" required>
                </div>
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <select name="student_gender[]" class="form-control" required>
                        <option value=""><?php echo get_phrase('select_gender'); ?></option>
                        <option value="Male"><?php echo get_phrase('male'); ?></option>
                        <option value="Female"><?php echo get_phrase('female'); ?></option>
                        <option value="Others"><?php echo get_phrase('others'); ?></option>
                    </select>
                </div>
            </div><br>
            <div class="row justify-content-md-center">
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input type="text" name="parent_name[]" class="form-control"  value="" placeholder="<?php echo get_phrase('parent_name'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input type="text" name="parent_email[]" class="form-control"  value="" placeholder="<?php echo get_phrase('parent_email'); ?>/<?php echo get_phrase('phone'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input type="password" name="parent_password[]" class="form-control"  value="" placeholder="<?php echo get_phrase('parent_password'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <select name="parent_gender[]" class="form-control" required>
                            <option value=""><?php echo get_phrase('select_gender'); ?></option>
                            <option value="Male"><?php echo get_phrase('male'); ?></option>
                            <option value="Female"><?php echo get_phrase('female'); ?></option>
                            <option value="Others"><?php echo get_phrase('others'); ?></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <div class="row justify-content-md-center">
                <div class="form-group col">
                    <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
                </div>
            </div>
        </div>
    </div><br>
</div>

<script>
var blank_field = $('#blank-row').html();

function appendRow() {
    $('#first-row').append(blank_field);
}

function removeRow(elem) {
    $(elem).closest('.student-row').remove();
}
</script>

<script>
var form;
$(".ajaxForm").submit(function(e) {
    form = $(this);
    ajaxSubmit(e, form, refreshForm);
});
var refreshForm = function () {
    form.trigger("reset");
}
</script>
