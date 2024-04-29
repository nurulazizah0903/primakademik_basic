<?php 
$questions = $this->db->get_where('assignment_questions', array('id' => $param1))->row_array();
$assignment = $this->db->get_where('assignments', array('id' => $questions['assignment_id']))->row_array();
$this->db->where('subject_id', $assignment['subject_id']);
$this->db->where('question_type', $questions['question_type']);
$question_banks = $this->db->get('question_bank')->result_array(); 
if (count($question_banks) > 0): ?>
<table id="datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('question'); ?></th>
                <th><?php echo get_phrase('question_type'); ?></th>
                <th><?php echo get_phrase('level_of_difficulty'); ?></th>
                <th><?php echo get_phrase('action'); ?></th>
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
                    <td><center>
                    <a href="<?php echo site_url('addons/assignment/questions/take_question/'.$question_bank['id'].'/'.$questions['id']); ?>" class="btn btn-primary btn-sm"><?php echo get_phrase('pilih'); ?></a>
                    </center></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
<script>
    initDataTable('datatable');
    'use strict';
    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAssignmentQuestion);
    });
    var refreshForm = function () {
    }
</script>