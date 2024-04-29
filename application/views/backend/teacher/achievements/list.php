<?php
$school_id = school_id();
$achievements = $this->db->get_where('achievements', array('school_id' => $school_id))->result_array();
if (count($achievements) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('awards'); ?></th>
			<th><?php echo get_phrase('point'); ?></th>
			<th><?php echo get_phrase('description'); ?></th>
			<th><?php echo get_phrase('date'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($achievements as $achievement){ 
		$student_data = $this->user_model->get_student_details_by_id('student', $achievement['student_id']);
      	$awards = $this->db->get_where('awards', array('id' => $achievement['award_id']))->row_array();
      ?>
		<tr>
      <td><?= $student_data['name']; ?> (<?= $student_data['section_name']; ?> <?= $student_data['class_name']; ?>)</td>
      <td><?php echo $awards['name']; ?></td>
	  <td><?php echo $achievement['point']; ?></td>
      <td><?php echo $achievement['description']; ?></td>
      <td>
          <?php echo date('D, d/M/Y', $achievement['date']); ?>
      </td>
				<td>
					<a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-sm" style="margin-right:3px;" onclick="largeModal('<?php echo site_url('modal/popup/achievements/update/'.$achievement['id'])?>', '<?php echo get_phrase('update_achievements'); ?>');" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></a>
					<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('achievements/delete/'.$achievement['id']); ?>', showAllAchievements)" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
					<!-- <div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/achievements/update/'.$achievement['id'])?>', '<?php echo get_phrase('update_achievements'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('achievements/delete/'.$achievement['id']); ?>', showAllAchievements)" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
						</div>
					</div> -->
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<br><br>
<?php
$points = $this->crud_model->get_achievements_top_student()->result_array();
if (count($points) > 0): ?>
<h4 class="header-title mt-3"><?php echo get_phrase('tree_top_student_achievement'); ?></h4>
	<div class="table-responsive">
	<table class="table table-hover" width="100%">
		<thead>
			<tr>
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('section'); ?></th>
			<th><?php echo get_phrase('point'); ?></th>
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
		</tr>
		</tbody>
		<?php } ?>
	</table>
	</div>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>