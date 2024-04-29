<?php $school_id = school_id(); ?>
<?php $question_banks = $this->db->get_where('question_bank', array('id' => $param1))->result_array(); ?>
<?php foreach($question_banks as $question_bank){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('question_bank/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="subject_id"><?php echo get_phrase('subject'); ?></label>
            <select name="subject_id" id="class_id_on_create" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_subject'); ?></option>
                    <?php
                        $subjects = $this->db->get_where('subjects', array('school_id' => $school_id))->result_array();
                        foreach($subjects as $subject){
                    ?>
                        <option value="<?php echo $subject['id']; ?>" <?php if($subject['id'] == $question_bank['subject_id']){ echo 'selected'; } ?>><?php echo $subject['name']; ?></option>
                    <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="base_id"> <?php echo get_phrase('knowledge_base'); ?></label>
            <select name="base_id" id="base_id_on_modal" class="form-control select2" data-toggle="select2" required >
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

        <?php 
        $choices_array = $question_bank['choices'];
        if(!is_null($choices_array)) {
            $choices = explode(",", $choices_array);
            foreach($choices as $choice){ 
        ?>
        <div id = "student">
            <div class="form-group col-md-12">
            <label for="question"><?php echo get_phrase('choices'); ?></label><br>
                <input type="text" class="form-control" id="choices_array[]" name = "choices_array[]" value="<?= $choice ?>"><br>
                <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
            </div>
        </div>
        <?php }
        } ?>

        <div class="form-group col-md-12">
            <label for="mark"><?php echo get_phrase('bobot'); ?></label>
            <input type="number" value="<?php echo $question_bank['mark'] ?>" class="form-control" id="mark" name = "mark" min="0" required>
        </div>

        <div class="form-group col-md-12">
            <label><?php echo get_phrase('question_type'); ?></label><br>
            <input type="radio" value="text" id="question_type_text" name="question_type" <?php if($question_bank['question_type'] == 'text') echo 'checked'; ?> required>
            <label for="question_type_text"><?php echo get_phrase('text'); ?></label>
            <input type="radio" value="file" id="question_type_file" name="question_type" class="ml-2" <?php if($question_bank['question_type'] == 'file') echo 'checked'; ?> required>
            <label for="question_type_file"><?php echo get_phrase('file'); ?></label>
            <input type="radio" value="choices" id="question_type_choices" name="question_type" class="ml-2" <?php if($question_bank['question_type'] == 'choices') echo 'checked'; ?> required>
            <label for="question_type_choices"><?php echo get_phrase('choices'); ?></label>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_question_bank'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
var blank_field = $('#blank-row').html();
function removeRow(elem) {
    $(elem).closest('#student').remove();
}

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
</script>
