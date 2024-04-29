<?php
$school_id = school_id();
$active_session = active_session();
if(isset($class_id) && $class_id != ''){
  $this->db->where('class_id', $class_id);
}
if(isset($section_id) && $section_id != ''){
  $this->db->where('section_id', $section_id);
}
if(isset($subject_id) && $subject_id != ''){
    $this->db->where('subject_id', $subject_id);
}
if(isset($base_id) && $base_id != ''){
    $this->db->where('base_id', $base_id);
}
$this->db->where('school_id', $school_id);
$question_banks = $this->db->get('question_bank')->result_array();
if(count($question_banks) > 0):
?>
    <table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('question'); ?></th>
                <th><?php echo get_phrase('subject'); ?></th>
                <th><?php echo get_phrase('question_type'); ?></th>
                <th><?php echo get_phrase('level_of_difficulty'); ?></th>
                <th><?php echo get_phrase('option'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($question_banks as $question_bank): ?>
                <tr>
                    <td>
                    <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/question_bank/detail/'.$question_bank['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $question_bank['question']; ?></a>
                    </td>
                    <td><?php echo $this->db->get_where('subjects', array('id' => $question_bank['subject_id']))->row('name'); ?></td>
                    <td>
                        <?php
                        if ($question_bank['question_type'] == "text") {
                            echo get_phrase('text'); 
                        } elseif ($question_bank['question_type'] == "file") {
                            echo get_phrase('file'); 
                        } elseif ($question_bank['question_type'] == "choices") {
                            echo get_phrase('choices'); 
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
                    <td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/question_bank/edit/'.$question_bank['id'])?>', '<?php echo get_phrase('update_question_bank'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('question_bank/delete/'.$question_bank['id']); ?>', showAllQuestionBank)"><?php echo get_phrase('delete'); ?></a>
						</div>
					</div>
				    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>