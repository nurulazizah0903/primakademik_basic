<?php $school_id = school_id(); ?>
<?php $question_banks = $this->db->get_where('question_bank', array('id' => $param1))->result_array(); ?>
<?php foreach($question_banks as $question_bank){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('question_bank/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="subject_id"><?php echo get_phrase('subject'); ?></label>
            <select name="subject_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required disabled>
                <option value=""><?php echo get_phrase('select_subject'); ?></option>
                    <?php
                        $subjects = $this->db->get_where('subjects', array('school_id' => $school_id))->result_array();
                        foreach($subjects as $subject){
                        $class_details = $this->crud_model->get_class_details_by_id($subject['class_id'])->row_array();
                        $section_details = $this->crud_model->get_section_details_by_id('section', $subject['section_id'])->row_array();
                    ?>
                        <option value="<?php echo $subject['id']; ?>" <?php if($subject['id'] == $question_bank['subject_id']){ echo 'selected'; } ?>>(<?php echo $class_details['name']; ?> - <?php echo $section_details['name']; ?>)  <?php echo $subject['name']; ?></option>
                    <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="base_id"> <?php echo get_phrase('knowledge_base'); ?></label>
            <select name="base_id" id="base_id_on_modal" class="form-control select2" data-toggle="select2" required disabled>
                <option value=""><?php echo get_phrase('select_knowledge_base'); ?></option>
                <?php 
                $knowledge_bases = $this->db->get_where('knowledge_base', array('id' => $question_bank['base_id']))->result_array();
                foreach ($knowledge_bases as $knowledge_base): ?>
                <option value="<?php echo $knowledge_base['id']; ?>" <?php if ($knowledge_base['id'] == $question_bank['base_id']): ?>selected<?php endif; ?>><?php echo $knowledge_base['name']; ?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="question"><?php echo get_phrase('question'); ?></label>
            <textarea class="form-control" name="question" id="question" cols="3" rows="3" required><?php echo $question_bank['question']; ?></textarea>
        </div>

        <div id ="first">
        <input type="hidden" name="correct_choices" id="correct" value=""> 
        <?php 
        $choices_array = $question_bank['choices'];
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
                    <input type="checkbox" id="correct_choices" 
                        <?php
                            $str_explode = explode(";", $question_bank['correct_choices']);
                            foreach($str_explode AS $explode){
                                if ($explode == $choice): ?>
                                    checked
                                <?php endif; 
                            }
                        ?>  
                    name="radioAns" class="setCorrect" data-ans="<?= $num;?>" value="1">
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
            <label><?php echo get_phrase('question_type'); ?></label><br>
            &nbsp;&nbsp;&nbsp;<input type="radio" value="text" id="question_type_text" name="question_type" <?php if($question_bank['question_type'] == 'text') echo 'checked'; ?> required>
            <label for="question_type_text"><?php echo get_phrase('short_answer'); ?></label><br>
            <input type="radio" value="file" id="question_type_file" name="question_type" class="ml-2" <?php if($question_bank['question_type'] == 'file') echo 'checked'; ?> required>
            <label for="question_type_file"><?php echo get_phrase('stuffing'); ?></label><br>
            <input type="radio" value="choices" id="question_type_choices" name="question_type" class="ml-2" <?php if($question_bank['question_type'] == 'choices') echo 'checked'; ?> required>
            <label for="question_type_choices"><?php echo get_phrase('multiple_choice'); ?></label>
        </div>

        <div class="form-group col-md-12">
            <label><?php echo get_phrase('level_of_difficulty'); ?></label><br>
            &nbsp;&nbsp;&nbsp;<input type="radio" value="mudah" id="level" name="level" <?php if($question_bank['level'] == 'mudah') echo 'checked'; ?> required>
            <label for="level"><?php echo get_phrase('mudah'); ?></label><br>
            <input type="radio" value="sedang" id="level" name="level" class="ml-2" <?php if($question_bank['level'] == 'sedang') echo 'checked'; ?> required>
            <label for="level"><?php echo get_phrase('sedang'); ?></label><br>
            <input type="radio" value="sulit" id="level" name="level" class="ml-2" <?php if($question_bank['level'] == 'sulit') echo 'checked'; ?> required>
            <label for="level"><?php echo get_phrase('sulit'); ?></label>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_question_bank'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

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
    ajaxSubmit(e, form, showAllQuestionBank);
    });

    $(document).ready(function() {
    initSelect2(['#class_id_on_create', '#base_id_on_modal']);
    });

    function subjectWiseBase(subjectId) {
        $.ajax({
            url: "<?php echo route('subject_wise_base/list/'); ?>"+subjectId,
            success: function(response){
                $('#section_id_on_create').html(response);
            }
        });
    }

    $("#first").on('click', '.setCorrect', function(){
        var final_val = '';
        $('.setCorrect:checked').each(function(){        
            var questId = $(this).attr('data-ans');
            var value = $("[data-quest='"+ questId +"'").val();
            final_val += value+";";
        });
        // var questId = $(this).attr('data-ans')
        // var value = $("[data-quest='"+ questId +"'").val();
        
        // console.log(value);
        document.getElementById("correct").value = (final_val);
    })
    $("#student").on('click', '.setCorrect', function(){
        var final_val = '';
        $('.setCorrect:checked').each(function(){        
            var questId = $(this).attr('data-ans');
            var value = $("[data-quest='"+ questId +"'").val();
            final_val += value+";";
        });        
        // var questId = $(this).attr('data-ans')
        // var value = $("[data-quest='"+ questId +"'").val();
        
        // console.log(value);
        document.getElementById("correct").value = (final_val);
    })
</script>
