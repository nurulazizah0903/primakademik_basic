<?php
if (!empty($student_id)):
$school_id = school_id();
$student_data = $this->user_model->get_student_details_by_id('student', $student_id);
$violations = $this->db->get_where('violations', array('student_id' => $student_data['student_id'],'school_id' => $school_id))->result_array();
if (count($violations) > 0):
?>
<div class="table-responsive">
<table class="table table-bordered table-responsive-sm" id="basic-datatable" width="100%">
        <thead class="thead-dark">
            <tr>
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('class'); ?></th>
            <th><?php echo get_phrase('section'); ?></th>
            <th><?php echo get_phrase('mistakes'); ?></th>
            <th><?php echo get_phrase('point'); ?></th>
            <th><?php echo get_phrase('description'); ?></th>
            <th><?php echo get_phrase('date'); ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($violations as $violation){ 
            $student = $this->db->get_where('students', array('id' => $violation['student_id']))->row_array();
            $enrols = $this->db->get_where('enrols', array('student_id' => $violation['student_id']))->row_array();
            $mistakes = $this->db->get_where('mistakes', array('id' => $violation['mistake_id']))->row_array();
            $class = $this->crud_model->get_class_details_by_id($enrols['class_id'])->row_array();
            $section = $this->db->get_where('sections', array('id' => $enrols['section_id']))->row_array();
            ?>
            <tr>
            <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
            <td><?php echo $class['name']; ?></td>
            <td><?php echo $section['name']; ?></td>
            <td><?php echo $mistakes['name']; ?></td>
            <td><?php echo $violation['point']; ?></td>
            <td><?php echo $violation['description']; ?></td>
            <td>
                <?php echo date('D, d/M/Y', $violation['date']); ?>
            </td>
                </tr>
		<?php } ?>
        </tbody>
    </table>
    </div>
<script type="text/javascript">
    initDataTable('basic-datatable');
</script>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<br><br>
<?php
$points = $this->crud_model->get_violations_top_student()->result_array();
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
		  <td><?php echo $user_id['nisn']; ?> - <?php echo $users_details['name']; ?></td>
		  <td><?php echo $point['jumlah']; ?></td>
		</tr>
		</tbody>
		<?php } ?>
	</table>
	</div>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>