<?php
$school_id = school_id();
$violations = $this->db->get_where('violations', array('school_id' => $school_id))->result_array();
if (count($violations) > 0): ?>
<div class="table-responsive">
<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
		<th><?php echo get_phrase('name'); ?></th>
		<th><?php echo get_phrase('mistakes'); ?></th>
		<th><?php echo get_phrase('point'); ?></th>
		<th><?php echo get_phrase('description'); ?></th>
		<th><?php echo get_phrase('date'); ?></th>
		<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($violations as $violation){ 
		$student_data = $this->user_model->get_student_details_by_id('student', $violation['student_id']);
      	$mistakes = $this->db->get_where('mistakes', array('id' => $violation['mistake_id']))->row_array();
      ?>
	<tr>
		<td><?= $student_data['name']; ?> (<?= $student_data['section_name']; ?> <?= $student_data['class_name']; ?>)</td>
		<td><?php echo $mistakes['name']; ?></td>
		<td><?php echo $mistakes['point']; ?></td>
		<td><?php echo $violation['description']; ?></td>
		<td>
			<?php echo date('D, d/M/Y', $violation['date']); ?>
		</td>
		<td>
			<a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-sm" style="margin-right:3px;" onclick="largeModal('<?php echo site_url('modal/popup/violations/update/'.$violation['id'])?>', '<?php echo get_phrase('update_achievements'); ?>');" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></a>
			<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('violations/delete/'.$violation['id']); ?>', showAllViolations)" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
			<!-- <div class="dropdown text-center">
				<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
				<div class="dropdown-menu dropdown-menu-right">
					<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/violations/update/'.$violation['id'])?>', '<?php echo get_phrase('update_violations'); ?>');"><?php echo get_phrase('edit'); ?></a>
					<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('violations/delete/'.$violation['id']); ?>', showAllViolations)"><?php echo get_phrase('delete'); ?></a>
				</div>
			</div> -->
		</td>
	</tr>
		<?php } ?>
	</tbody>
</table>
</div>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<br><br>
<?php 
$points = $this->crud_model->get_violations_top_student()->result_array();
if (count($points) > 0): ?>
<h4 class="header-title mt-3"><?php echo get_phrase('tree_top_student_violation'); ?></h4>
	<div class="table-responsive">
	<table class="table table-hover" width="100%">
		<thead>
			<tr>
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('section'); ?></th>
			<th><?php echo get_phrase('point'); ?></th>
			<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($points as $point){ 
			$student_data = $this->user_model->get_student_details_by_id('student', $point['student_id']);
			?>
		<tr>
		  <td><?php echo $student_data['NIS']; ?> - <?php echo $student_data['name']; ?></td>
		  <td><?php echo $student_data['section_name']; ?> <?php echo $student_data['class_name']; ?></td>
		  <td><?php echo $point['jumlah']; ?></td>
		  <td>
			<button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/violations/create_routine/'.$point['student_id']); ?>', '<?php echo get_phrase('create_routine_counseling'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('create_routine_counseling'); ?></button>
		</tr>
		</tbody>
		<?php } ?>
	</table>
	</div>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>