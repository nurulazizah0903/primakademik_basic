<?php
if (isset($subject_id)):
$school_id = school_id();
$knowledge_bases_subject = $this->db->get_where('knowledge_base', array('subject_id' => $subject_id,'school_id' => $school_id))->result_array();
if (count($knowledge_bases_subject) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
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
		?>
			<tr>
				<td><?php echo $knowledge_subject['name']; ?></td>
				<td><?php echo $subjects['name']; ?></td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/knowledge_base/edit/'.$knowledge_subject['id'])?>', '<?php echo get_phrase('update_knowledge_base'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('knowledge_base/delete/'.$knowledge_subject['id']); ?>', showAllKnowledgeBase)"><?php echo get_phrase('delete'); ?></a>
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
<?php else: 
$knowledge_bases = $this->db->get_where('knowledge_base', array('school_id' => $school_id))->result_array();
if (count($knowledge_bases) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('subject'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($knowledge_bases as $knowledge_base):
			$subject = $this->crud_model->get_subject_by_id($knowledge_base['subject_id']);
		?>
			<tr>
				<td><?php echo $knowledge_base['name']; ?></td>
				<td><?php echo $subject['name']; ?></td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/knowledge_base/edit/'.$knowledge_base['id'])?>', '<?php echo get_phrase('update_knowledge_base'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('knowledge_base/delete/'.$knowledge_base['id']); ?>', showAllKnowledgeBase)"><?php echo get_phrase('delete'); ?></a>
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
<?php endif; ?>