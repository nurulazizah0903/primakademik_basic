<form method="POST" class="d-block ajaxForm" action="<?php echo route('question_bank/create'); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <?php $school_id = school_id(); ?>
        <input type="hidden" name="school_id" value="<?php echo $school_id; ?>">

        <div class="form-group col-md-12">
            <label for="subject_id_on_create"><?php echo get_phrase('subject'); ?></label>
            <select name="subject_id" id="subject_id_on_create" class="form-control select2" data-toggle = "select2" onchange="subjectWiseBase(this.value)" required>
                <option value=""><?php echo get_phrase('select_subject'); ?></option>
                <?php $subjects = $this->db->get_where('subjects', array('school_id' => school_id()))->result_array();
                    foreach($subjects as $subject){ ?>
                    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?> - <?php echo $this->db->get_where('class_rooms', array('id' => $subject['room_id']))->row('name');?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="section_id_on_create"><?php echo get_phrase('knowledge_base'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="section_id_on_create" name="base_id" required>
                <option value=""><?php echo get_phrase('select_knowledge_base'); ?></option>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="question"><?php echo get_phrase('question'); ?></label>
            <textarea class="form-control" id="question" name = "question" required cols="3" rows="3"></textarea>
        </div>

        <div class="form-group col-md-12">
            <label><?php echo get_phrase('question_type'); ?><font style="color:red;">*</font></label><br>
            &nbsp;&nbsp;&nbsp;<input type="radio" value="text" id="question_type_text" name="question_type" required>
            <label for="question_type_text"><?php echo get_phrase('short_answer'); ?></label><br>
            <input type="radio" value="file" id="question_type_file" name="question_type" class="ml-2" required>
            <label for="question_type_file"><?php echo get_phrase('stuffing'); ?></label><br>
            <input type="radio" value="choices" id="question_type_choices" name="question_type" class="ml-2" required>
            <label for="question_type_choices"><?php echo get_phrase('multiple_choice'); ?></label>
        </div>

        <div class="form-group col-md-12">
            <label for="level_of_difficulty"><?php echo get_phrase('level_of_difficulty'); ?><font style="color:red;">*</font></label><br>
            &nbsp;&nbsp;&nbsp;<input type="radio" value="mudah" id="level" name="level" required>
            <label for="level"><?php echo get_phrase('mudah'); ?></label><br>
            <input type="radio" value="sedang" id="level" name="level" class="ml-2" checked required>
            <label for="level"><?php echo get_phrase('sedang'); ?></label><br>
            <input type="radio" value="sulit" id="level" name="level" class="ml-2" required>
            <label for="level"><?php echo get_phrase('sulit'); ?></label>
        </div>

        <div id ="first">
    <label for="question"><?php echo get_phrase('choices'); ?></label>
        <div class="form-group row">
            <input type="hidden" name="correct_choices" id="correct" value="">
            
            <div class="form-group col-md-10">
                <input type="text" class="form-control" id="choices_array" data-quest="1" name= "choices_array[]" >
            </div>
            <div class="col-md-2">
                <input type="radio" id="correct_choices" name="radioAns" class="setCorrect" data-ans="1" value="1">
                <label><?= get_phrase('correct_choices'); ?></label>
            </div>
            
        
            <div class="col-md-2">
                <button type="button" class="btn btn-icon btn-success" onclick="appendRow()"> <i class="mdi mdi-plus"></i> </button>
            </div>
        </div>
    </div>

        </div>
        <div class="form-group col-md-12 mt-2">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_question_bank'); ?></button>
        </div>
    </div>
</form>

<script>
// var blank_field = $('#blank-row').html();
var countQuest = 2;

function appendRow() {
    $('#first').append(`
    <div>
        <div class = "student">
            <label for="question"><?php echo get_phrase('choices'); ?></label>
            <div class="form-group row">
                <div class="form-group col-md-10">
                    
                    <input data-quest="${countQuest}" type="text" class="form-control" id="choices_array" name = "choices_array[]" >
                </div>
                <div class="col-md-2">
                    <input class="setCorrect" data-ans="${countQuest}" name="radioAns" type="radio" value="1">
                    <label><?= get_phrase('correct_choices'); ?></label>
                    </div>
                <div class="form-group col-md-2">
                    <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
                </div>
            </div>
        </div>
        </div>
    `);
    countQuest++;
}

function removeRow(elem) {
    $(elem).closest('.student').remove();
}

'use strict';

    $("#first").on('click', '.setCorrect', function(){
        var questId = $(this).attr('data-ans')
        var value = $("[data-quest='"+ questId +"'").val();
        
        // console.log(value);
        document.getElementById("correct").value = (value);
    })

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit2(e, form, showAllQuestionBank);
    location.reload();
});

$('document').ready(function(){
    initSelect2(['#section_id_on_create', '#subject_id_on_create', '#class_id_on_create', '#section_id_create']);
});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_create').html(response);
            classWiseSubject(classId);
        }
    });
}

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

function classWiseSubject(classId) {
    $.ajax({
        url: "<?php echo route('class_wise_subject/'); ?>"+classId,
        success: function(response){
            $('#subject_id_on_create').html(response);
        }
    });
}

function subjectWiseBase(subjectId) {
    $.ajax({
        url: "<?php echo route('subject_wise_base/list/'); ?>"+subjectId,
        success: function(response){
            $('#section_id_on_create').html(response);
        }
    });
}
</script>