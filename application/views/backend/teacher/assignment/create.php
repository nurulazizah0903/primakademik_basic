<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('addons/assignment/index/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="assignment_types"><?php echo get_phrase('assignment_types'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="assignment_types_id" name="assignment_types_id" required>
                <option value=""><?php echo get_phrase('select_a_assignment_types'); ?></option>
                <?php $assignment_types = $this->db->get_where('assignment_types', array('school_id' => school_id()))->result_array(); ?>
                <?php foreach($assignment_types as $assignment_type): ?>
                    <option value="<?php echo $assignment_type['id']; ?>"><?php echo $assignment_type['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="deadline"><?php echo get_phrase('tenggat_waktu'); ?></label>
            <input type="text" class="form-control date" id="deadline" data-toggle="date-picker" data-single-date-picker="true" name = "deadline" value="" required>
        </div>

        <div class="form-group col-md-12">
            <label for="subject_id_on_create"><?php echo get_phrase('subject'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="subject_id_on_create" name="subject_id" requied>
                <option value=""><?php echo get_phrase('select_subject'); ?></option>
                <?php
                $subjects = $this->db->get_where('subjects', array('school_id' => school_id(), 'teacher_id' => $teacher_id))->result_array();
                foreach($subjects as $subject){
                    $class_details = $this->crud_model->get_class_details_by_id($subject['class_id'])->row_array();
                    $section_details = $this->crud_model->get_section_details_by_id('section', $subject['section_id'])->row_array();
                ?>
                    <option value="<?php echo $subject['id']; ?>">(<?php echo $class_details['name']; ?> - <?php echo $section_details['name']; ?>)  <?php echo $subject['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="number of questions"><?php echo get_phrase('number_of_questions'); ?></label><br>
            <div class="col-md-6">
                <select class="form-control select2" data-toggle = "select2" id="question_type_one" name="question_type_one" requied>
                <option value="choices" selected><?php echo get_phrase('multiple_choice'); ?></option>
                <option value="text"><?php echo get_phrase('short_answer'); ?></option>
                <option value="file"><?php echo get_phrase('stuffing'); ?></option>
            </select>
            </div>
            <div class="col-md-6">
                <input type="number" class="form-control" name="question_total_one" id="question_total_one" value="0" requied>
            </div><br>

            <div class="col-md-6">
                <select class="form-control select2" data-toggle = "select2" id="question_type_two" name="question_type_two" requied>
                <option value="choices"><?php echo get_phrase('multiple_choice'); ?></option>
                <option value="text" selected><?php echo get_phrase('short_answer'); ?></option>
                <option value="file"><?php echo get_phrase('stuffing'); ?></option>
            </select>
            </div>
            <div class="col-md-6">
                <input type="number" class="form-control" name="question_total_two" id="question_total_two" value="0" requied>
            </div><br>
            
            <div class="col-md-6">
                <select class="form-control select2" data-toggle = "select2" id="question_type_tree" name="question_type_tree" requied>
                <option value="choices"><?php echo get_phrase('multiple_choice'); ?></option>
                <option value="text"><?php echo get_phrase('short_answer'); ?></option>
                <option value="file" selected><?php echo get_phrase('stuffing'); ?></option>
            </select>
            </div>
            <div class="col-md-6">
                <input type="number" class="form-control" name="question_total_tree" id="question_total_tree" value="0" requied><br>
            </div>
        </div>

        <div class="form-group col-md-12">
            <label for="course_id"><?php echo get_phrase('course_list'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="course_id_on_create" name="course_id">
                <option value=""><?php echo get_phrase('select_course_list'); ?></option>
                <?php $courses = $this->db->get_where('course', array('school_id' => school_id()))->result_array(); ?>
                <?php foreach($courses as $course): ?>
                    <option value="<?php echo $course['id']; ?>"><?php echo $course['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mt-2 col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_assignment'); ?></button>
        </div>
    </div>
</form>

<?php include 'common_script.php'; ?>

<script>
    'use strict';

    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAssignments);
    });

    $(function(){
        $('.select2').select2();
    });

    if($('select').hasClass('select2') == true){
        $('div').attr('tabindex', "");
        $(function(){$(".select2").select2()});
    }

    $('#deadline').daterangepicker();
</script>
