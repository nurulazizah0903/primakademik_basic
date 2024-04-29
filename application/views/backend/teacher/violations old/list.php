<?php
$school_id = school_id();
$violations = $this->db->get_where('violations', array('school_id' => $school_id))->result_array();
if (count($violations) > 0): ?>
<div class="table-responsive">
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
		<th><?php echo get_phrase('name'); ?></th>
		<th><?php echo get_phrase('class'); ?></th>
		<th><?php echo get_phrase('section'); ?></th>
		<th><?php echo get_phrase('mistakes'); ?></th>
		<th><?php echo get_phrase('point'); ?></th>
		<th><?php echo get_phrase('description'); ?></th>
		<th><?php echo get_phrase('date'); ?></th>
		<th><?php echo get_phrase('options'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($violations as $violation){ 
      $student = $this->db->get_where('students', array('id' => $violation['student_id']))->row_array();
      $enrols = $this->db->get_where('enrols', array('student_id' => $violation['student_id']))->row_array();
      $mistakes = $this->db->get_where('mistakes', array('id' => $violation['mistake_id']))->row_array();
      $class = $this->crud_model->get_class_details_by_id($enrols['class_id'])->row_array();
      $section = $this->db->get_where('sections', array('id' => $enrols['section_id']))->row_array();
	//   $total = $this->db->query("SELECT SUM(point) as jumlah FROM violations WHERE student_id = '".$violation['student_id']."'");
	//   print_r($violation['student_id']);
      ?>
			<tr>
      <td><?php echo $student['nisn']; ?> - <?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
      <td><?php echo $class['name']; ?></td>
      <td><?php echo $section['name']; ?></td>
      <td><?php echo $mistakes['name']; ?></td>
	  <td><?php echo $mistakes['point']; ?></td>
      <td><?php echo $violation['description']; ?></td>
      <td>
          <?php echo date('D, d/M/Y', $violation['date']); ?>
      </td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/violations/update/'.$violation['id'])?>', '<?php echo get_phrase('update_violations'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('violations/delete/'.$violation['id']); ?>', showAllViolations)"><?php echo get_phrase('delete'); ?></a>
						</div>
					</div>
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
			<th><?php echo get_phrase('class'); ?></th>
			<th><?php echo get_phrase('section'); ?></th>
			<th><?php echo get_phrase('point'); ?></th>
			<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($points as $point){ 
			$user_id = $this->db->get_where('students', array('id' => $point['student_id']))->row_array();
			$users_details = $this->db->get_where('users', array('id' => $user_id['user_id']))->row_array();	
			$enrols = $this->db->get_where('enrols', array('student_id' => $point['student_id']))->row_array();
			$class = $this->crud_model->get_class_details_by_id($enrols['class_id'])->row_array();
			$section = $this->db->get_where('sections', array('id' => $enrols['section_id']))->row_array();
			?>
		<tr>
		  <td><?php echo $user_id['nisn']; ?> - <?php echo $users_details['name']; ?></td>
		  <td><?php echo $class['name']; ?></td>
		  <td><?php echo $section['name']; ?></td>
		  <td><?php echo $point['jumlah']; ?></td>
		  <td>
		  	<button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/violations/create_routine/'.$point['student_id']); ?>', '<?php echo get_phrase('create_routine_counseling'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('create_routine_counseling'); ?></button>
		</tr>
		</tbody>
		<?php } ?>
	</table>
	</div>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>