<?php
$school_id = school_id();
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
$subjects = $this->db->get_where('subjects', array('teacher_id' => $teacher_id))->result_array();

if(!empty($subject_id)){
	$this->db->where('subject_id', $subject_id);
}else{
	foreach($subjects as $subject){
		$this->db->where('subject_id', $subject['id']);
	}
}
$this->db->where('school_id', $school_id);
$knowledge_bases_subject = $this->db->get('knowledge_base')->result_array();
if (count($knowledge_bases_subject) > 0): ?>
<div class="table-responsive">
<table id="example" class="table table-striped dt-responsive" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('subject'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($knowledge_bases_subject as $knowledge_subject):
			$subjects = $this->crud_model->get_subject_by_id($knowledge_subject['subject_id']);
			$class_details = $this->crud_model->get_class_details_by_id($subjects['class_id'])->row_array();
            $section_details = $this->crud_model->get_section_details_by_id('section', $subjects['section_id'])->row_array();
		?>
			<tr>
				<td><?php echo $knowledge_subject['name']; ?></td>
				<td>[ <?php echo $class_details['name']; ?> - <?php echo $section_details['name']; ?> ] <?php echo $subjects['name']; ?></td>
				<td>
					<a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-sm" style="margin-right:3px;" onclick="largeModal('<?php echo site_url('modal/popup/knowledge_base/edit/'.$knowledge_base['id'])?>', '<?php echo get_phrase('update_knowledge_base'); ?>');" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></a>
					<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('knowledge_base/delete/'.$knowledge_base['id']); ?>', showAllKnowledgeBase )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
					<!-- <div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/knowledge_base/edit/'.$knowledge_subject['id'])?>', '<?php echo get_phrase('update_knowledge_base'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('knowledge_base/delete/'.$knowledge_subject['id']); ?>', showAllKnowledgeBase)"><?php echo get_phrase('delete'); ?></a>
						</div>
					</div> -->
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</div>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        "paging":   false,
        "info":     false
    } );
} );
</script>