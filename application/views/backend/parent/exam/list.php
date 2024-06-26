<?php
$school_id = school_id();
$exams = $this->db->get_where('exams', array('school_id' => $school_id, 'session' => active_session()))->result_array();

if (count($exams) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('exam_name'); ?></th>
            <th><?php echo get_phrase('semester'); ?></th>
            <th><?php echo get_phrase('starting_date'); ?></th>
            <th><?php echo get_phrase('ending_date'); ?></th>
        </tr>
    </thead>
    <tbody>
	<?php foreach($exams as $exam):
    $semester = $this->db->get_where('semester', array('id' => $exam['semester_id']))->row_array();	
    ?>
	<tr>
	    <td><?php echo $exam['name']; ?></td>
        <td><?php echo $semester['name']; ?></td>
	    <td><?php echo date('D, d-M-Y', $exam['starting_date']); ?></td>
	    <td><?php echo date('D, d-M-Y', $exam['ending_date']); ?></td>
	    <td>
        <div class="dropdown text-center">
					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
					<div class="dropdown-menu dropdown-menu-right">
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/exam/edit/'.$exam['id'])?>', '<?php echo get_phrase('update_exam'); ?>');"><?php echo get_phrase('edit'); ?></a>
						<!-- item-->
						<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('exam/delete/'.$exam['id']); ?>', showAllExams)"><?php echo get_phrase('delete'); ?></a>
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
