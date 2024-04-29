<?php
$school_id = school_id();
$achievements = $this->db->get_where('achievements', array('school_id' => $school_id))->result_array();
if (count($achievements) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('class'); ?></th>
			<th><?php echo get_phrase('section'); ?></th>
			<th><?php echo get_phrase('awards'); ?></th>
			<th><?php echo get_phrase('point'); ?></th>
			<th><?php echo get_phrase('description'); ?></th>
			<th><?php echo get_phrase('date'); ?></th>
			<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($achievements as $achievement){ 
      $student = $this->db->get_where('students', array('id' => $achievement['student_id']))->row_array();
      $enrols = $this->db->get_where('enrols', array('student_id' => $achievement['student_id']))->row_array();
      $awards = $this->db->get_where('awards', array('id' => $achievement['award_id']))->row_array();
      $class = $this->crud_model->get_class_details_by_id($enrols['class_id'])->row_array();
      $section = $this->db->get_where('sections', array('id' => $enrols['section_id']))->row_array();
      ?>
			<tr>
      <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
      <td><?php echo $class['name']; ?></td>
      <td><?php echo $section['name']; ?></td>
      <td><?php echo $awards['name']; ?></td>
	  <td><?php echo $achievement['point']; ?></td>
      <td><?php echo $achievement['description']; ?></td>
      <td>
          <?php echo date('D, d/M/Y', $achievement['date']); ?>
      </td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/achievements/update/'.$achievement['id'])?>', '<?php echo get_phrase('update_achievements'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('achievements/delete/'.$achievement['id']); ?>', showAllAchievements)"><?php echo get_phrase('delete'); ?></a>
						</div>
					</div>
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
			<th><?php echo get_phrase('point'); ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($points as $point){ 
			$user_id = $this->db->get_where('students', array('id' => $point['student_id']))->row_array();
			$users_details = $this->db->get_where('users', array('id' => $user_id['user_id']))->row_array();	
			?>
		<tr>
		  <td><?php echo $user_id['NIS']; ?> - <?php echo $users_details['name']; ?></td>
		  <td><?php echo $point['jumlah']; ?></td>
		</tr>
		</tbody>
		<?php } ?>
	</table>
	</div>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>