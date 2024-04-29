<?php
$school_id = school_id();
if (isset($subject_id) && isset($base_id)):
    $question_banks = $this->db->get_where('question_bank', array('subject_id' => $subject_id, 'base_id' => $base_id, 'session_id' => active_session()))->result_array();
    if(count($question_banks) > 0):?>
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('question'); ?></th>
                <th><?php echo get_phrase('option'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($question_banks as $question_bank):?>
                <tr>
                    <td>
                    <!-- <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/question_bank/detail/'.$question_bank['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $question_bank['question']; ?></a> -->
                    <?php echo $question_bank['question']; ?>
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
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
