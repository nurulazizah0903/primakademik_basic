<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('addons/exam/questions/create/'.$param1); ?>">
    <div class="form-group row">
        <div class="form-group col-md-12">
            <label for="question"><?php echo get_phrase('question'); ?><font style="color:red;">*</font></label>
            <textarea class="form-control" id="question" name = "question" required cols="3" rows="3"></textarea>
            <small id="title_help" class="form-text text-muted"><?php echo get_phrase('provide_question_title'); ?></small>
        </div>
    </div>

    <div class="form-group row">
        <div class="form-group col-md-12">
            <label><?php echo get_phrase('question_type'); ?><font style="color:red;">*</font></label><br>
            &nbsp;&nbsp;&nbsp;<input type="radio" value="text" id="question_type_text" name="question_type" required>
            <label for="question_type_text"><?php echo get_phrase('short_answer'); ?></label><br>
            <input type="radio" value="file" id="question_type_file" name="question_type" class="ml-2" required>
            <label for="question_type_file"><?php echo get_phrase('stuffing'); ?></label><br>
            <input type="radio" value="choices" id="question_type_choices" name="question_type" class="ml-2" required>
            <label for="question_type_choices"><?php echo get_phrase('multiple_choice'); ?></label>
        </div>
    </div>

    <div class="form-group row">
        <div class="form-group col-md-12">
            <label for="level_of_difficulty"><?php echo get_phrase('level_of_difficulty'); ?><font style="color:red;">*</font></label><br>
            &nbsp;&nbsp;&nbsp;<input type="radio" value="mudah" id="level" name="level" required>
            <label for="level"><?php echo get_phrase('mudah'); ?></label><br>
            <input type="radio" value="sedang" id="level" name="level" class="ml-2" checked required>
            <label for="level"><?php echo get_phrase('sedang'); ?></label><br>
            <input type="radio" value="sulit" id="level" name="level" class="ml-2" required>
            <label for="level"><?php echo get_phrase('sulit'); ?></label>
        </div>
    </div>
    

    <div class="form-group row">
        <div class="form-group col-md-12">
            <label for="bobot"><?php echo get_phrase('bobot'); ?><font style="color:red;">*</font></label>
            <input type="number" class="form-control" id="mark" name = "mark" min="0" required>
        </div>
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
        <div class="form-group mt-2 col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_question'); ?></button>
        </div>
    </div>
</form>

<div id = "blank-row" style="display: none;">
<div class = "student">
    <label for="question"><?php echo get_phrase('choices'); ?></label>
    <div class="form-group row">
        <div class="form-group col-md-10">
            
            <input type="text" class="form-control" id="choices_array" name = "choices_array[]" >
        </div>
        <div class="col-md-2">
            <input type="radio" id="correct_choices" name="correct_choices[]" value="1">
            <label><?= get_phrase('correct_choices'); ?></label>
            </div>
        <div class="form-group col-md-2">
            <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
        </div>
    </div>
</div>
</div>

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
</script>

<script>
    'use strict';
    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showExamQuestion);
    });

    $("#first").on('click', '.setCorrect', function(){
        var questId = $(this).attr('data-ans')
        var value = $("[data-quest='"+ questId +"'").val();
        
        // console.log(value);
        document.getElementById("correct").value = (value);
    })
</script>
