<style>
    input[type=checkbox] {
    transform: scale(1.5);
}
</style>
<?php 
$this->db->where('subject_id', $param2);
$question_banks = $this->db->get('question_bank')->result_array(); 
if (count($question_banks) > 0):?>
<form method="POST" action="<?php echo site_url('addons/exam/questions/add_question_bank/'.$param1); ?>" class="ajaxForm" id="delete_student">
<table id="table" class="table table-striped dt-responsive nowrap" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('question'); ?></th>
                <th><?php echo get_phrase('question_type'); ?></th>
                <th><?php echo get_phrase('level_of_difficulty'); ?></th>
                <th><?php echo get_phrase('choices'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($question_banks as $question_bank): ?>
                <tr>
                    <td><?php echo $question_bank['question']; ?></td>
                    <td>
                        <?php
                        if ($question_bank['question_type'] == "text") {
                            echo get_phrase('short_answer'); 
                        } elseif ($question_bank['question_type'] == "file") {
                            echo get_phrase('stuffing'); 
                        } elseif ($question_bank['question_type'] == "choices") {
                            echo get_phrase('multiple_choice'); 
                        } 
                        ?>    
                    </td>
                    <td>
                        <?php
                        if ($question_bank['level'] == "mudah") {
                            echo get_phrase('mudah'); 
                        } elseif ($question_bank['level'] == "sedang") {
                            echo get_phrase('sedang'); 
                        } elseif ($question_bank['level'] == "sulit") {
                            echo get_phrase('sulit'); 
                        } 
                        ?>    
                    </td>
                    <td><center><input type="checkbox" name="enrol_ids[]" class="checkSingle" value="<?= $question_bank['id'];?>" data-size="xl"></center></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
    <input type="submit" id="submit_question" name="submit_question" onclick="validation(this.id)" class="btn btn-info" value="<?= get_phrase('add_question') ?>" />
</form>
<script type="text/javascript">
initDataTable('table');
var validated = false;
var action = "";
function validation(id) {
  action = id;
  if (action == "submit_move") {
    if ($('#move_session_id').val() == "" || $('#move_class_id').val() == "" || $('move_section_id').val() == "") {
      validated = false;
      toastr.error('<?php echo get_phrase('please_select_the_fields'); ?>');
    } else {
      validated = true;
    }
  } else {
    validated = true;
  }
}

var form;
$(".ajaxForm").submit(function(e) {
  e.preventDefault();
  form = $(this);
  if(validated) {
    var add = {action:action};
    ajaxSubmit2(e, form, refreshForm, add);
  }
});
var refreshForm = function () {
}

</script>
