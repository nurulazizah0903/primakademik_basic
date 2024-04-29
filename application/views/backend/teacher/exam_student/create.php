<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('addons/exam/index/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="exam_types"><?php echo get_phrase('exam_types'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="exam_types_id" name="exam_types_id" required>
                <option value=""><?php echo get_phrase('select_a_exam_types'); ?></option>
                <?php $exam_types = $this->db->get_where('exam_types', array('school_id' => school_id()))->result_array(); ?>
                <?php foreach($exam_types as $exam_type): ?>
                    <option value="<?php echo $exam_type['id']; ?>"><?php echo $exam_type['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="deadline"><?php echo get_phrase('tenggat_waktu'); ?></label>
            <input type="text" class="form-control date" id="deadline" data-toggle="date-picker" data-single-date-picker="true" name = "deadline" value="" required>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <label for="time_start"><?php echo get_phrase('time_start'); ?></label>
                    <input type="time" class="form-control time" id="time_start" name = "time_start" required>
                </div>
                <div class="col-md-6">
                    <label for="time_finish"><?php echo get_phrase('time_finish'); ?></label>
                    <input type="time" class="form-control time" id="time_finish" name = "time_finish" required>
                </div>
            </div>
        </div>        

        <div class="form-group col-md-12">
            <label for="subject_id_on_create"><?php echo get_phrase('subject'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="subject_id_on_create" name="subject_id" requied>
                <option><?php echo get_phrase('select_a_subject'); ?></option>
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

        <div class="form-group mt-2 col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_exam'); ?></button>
        </div>
    </div>
</form>

<?php include 'common_script.php'; ?>

<script>
    'use strict';

    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showExams);
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
