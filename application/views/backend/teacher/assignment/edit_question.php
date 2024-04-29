<?php $question = $this->db->get_where('assignment_questions', array('id' => $param1))->row_array(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('addons/assignment/questions/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="question"><?php echo get_phrase('question'); ?></label>
            <textarea class="form-control" name="question" id="question" cols="3" rows="3" required><?php echo $question['question']; ?></textarea>
            <small id="title_help" class="form-text text-muted"><?php echo get_phrase('provide_question_title'); ?></small>
        </div>

        <div id ="first">
        <input type="hidden" name="correct_choices" id="correct" value="<?=$question['correct_choices']?>"> 
        <?php 
        $choices_array = $question['choices'];
        if(!is_null($choices_array)) {
            $choices = explode(";", $choices_array);
            $num = 1;
            foreach($choices as $choice){ 
        ?>
        <div id = "student">
        <label for="question"><?php echo get_phrase('choices'); ?></label>
            <div class="form-group row">
                
                <div class="form-group col-md-8">
                    <input type="text" class="form-control" id="choices_array" value="<?= $choice?>" data-quest="<?= $num;?>" name= "choices_array[]" >
                </div>
                <div class="form-group col-md-2">
                <button type="button" class="btn btn-icon btn-danger" onclick="removeRow1(this)"> <i class="mdi mdi-window-close"></i> </button>
                </div>
                <div class="col-md-2">
                    <input type="radio" id="correct_choices" <?php if ($question['correct_choices'] == $choice): ?>checked<?php endif; ?> name="radioAns" class="setCorrect" data-ans="<?= $num;?>" value="1">
                    <label><?= get_phrase('correct_choices'); ?></label>
                </div>
            </div>
        </div>
        <?php 
        $num++;
        }
        } ?>
        <div class="form-group col-md-12"><?= get_phrase('add_choices'); ?>
            <button type="button" class="btn btn-icon btn-success" onclick="appendRow()"> <i class="mdi mdi-plus"></i> </button>
        </div><br>
        </div>

        <div class="form-group col-md-12">
            <label for="mark"><?php echo get_phrase('bobot'); ?></label>
            <input type="number" value="<?php echo $question['mark'] ?>" class="form-control" id="mark" name = "mark" min="0" required>
        </div>

        <div class="form-group col-md-12">
            <label><?php echo get_phrase('question_type'); ?></label><br>
            <input type="radio" value="text" id="question_type_text" name="question_type" <?php if($question['question_type'] == 'text') echo 'checked'; ?> required>
            <label for="question_type_text"><?php echo get_phrase('short_answer'); ?></label>
            <input type="radio" value="file" id="question_type_file" name="question_type" class="ml-2" <?php if($question['question_type'] == 'file') echo 'checked'; ?> required>
            <label for="question_type_file"><?php echo get_phrase('stuffing'); ?></label>
            <input type="radio" value="choices" id="question_type_choices" name="question_type" class="ml-2" <?php if($question['question_type'] == 'choices') echo 'checked'; ?> required>
            <label for="question_type_choices"><?php echo get_phrase('multiple_choice'); ?></label>
        </div>

        <div class="form-group col-md-12">
            <label for="level_of_difficulty"><?php echo get_phrase('level_of_difficulty'); ?><font style="color:red;">*</font></label><br>
            &nbsp;&nbsp;&nbsp;<input type="radio" value="mudah" id="level" name="level" <?php if($question['level'] == 'mudah') echo 'checked'; ?> required>
            <label for="level"><?php echo get_phrase('mudah'); ?></label><br>
            <input type="radio" value="sedang" id="level" name="level" class="ml-2" <?php if($question['level'] == 'sedang') echo 'checked'; ?> required>
            <label for="level"><?php echo get_phrase('sedang'); ?></label><br>
            <input type="radio" value="sulit" id="level" name="level" class="ml-2" <?php if($question['level'] == 'sulit') echo 'checked'; ?> required>
            <label for="level"><?php echo get_phrase('sulit'); ?></label>
        </div>

        <div class="form-group mt-2 col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
        </div>
    </div>
</form>

<script>
var countQuest = 2;

function appendRow() {
    $('#first').append(`
    <div>
        <div class = "student">
            <label for="question"><?php echo get_phrase('choices'); ?></label>
            <div class="form-group row">
                <div class="form-group col-md-8">
                    <input data-quest="${countQuest}" type="text" class="form-control" id="choices_array" name = "choices_array[]" >
                </div>
                <div class="form-group col-md-2">
                    <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
                </div>
                <div class="col-md-2">
                    <input class="setCorrect" data-ans="${countQuest}" name="radioAns" type="radio" value="1">
                    <label><?= get_phrase('correct_choices'); ?></label>
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

function removeRow1(elem) {
    $(elem).closest('#student').remove();
}

    'use strict';
    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAssignmentQuestion);
    });

    $("#first").on('click', '.setCorrect', function(){
        var questId = $(this).attr('data-ans')
        var value = $("[data-quest='"+ questId +"'").val();
        
        // console.log(value);
        document.getElementById("correct").value = (value);
    })
    $("#student").on('click', '.setCorrect', function(){
        var questId = $(this).attr('data-ans')
        var value = $("[data-quest='"+ questId +"'").val();
        
        // console.log(value);
        document.getElementById("correct").value = (value);
    })
</script>
