<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="table-responsive">
      <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead>
<?php
$school_id = school_id();
$marks = $this->crud_model->get_marks_archives($student_id, $semester_id, $session)->result_array();
?>
<?php if (count($marks) > 0): ?>
          <tr style="background-color: #313a46; color: #ababab;">
            <!-- <th><?php echo get_phrase('student_name'); ?></th> -->
            <th><?php echo get_phrase('subject'); ?></th>
            <th><?php echo get_phrase('class'); ?></th>
            <th><?php echo get_phrase('section'); ?></th>
            <th><?php echo get_phrase('exam'); ?></th>
            <th><?php echo get_phrase('mark'); ?></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach($marks as $mark):
        $student = $this->db->get_where('students', array('id' => $mark['student_id']))->row_array();
        ?>
            <tr>
            <!-- <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td> -->
            <td><?php echo $this->db->get_where('subjects', array('id' => $mark['subject_id']))->row('name');?></td>
            <td><?php echo $this->db->get_where('classes', array('id' => $mark['class_id']))->row('name'); ?></td>
            <td><?php echo $this->db->get_where('sections', array('id' => $mark['section_id']))->row('name'); ?></td>
            <td><?php echo $this->db->get_where('exams', array('id' => $mark['exam_id']))->row('name'); ?></td>
            <td><?php echo $mark['mark_obtained']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
      </table>
      <div class="row d-print-none mt-3">
        <div class="col-12 text-right"><a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i><?php echo get_phrase('print'); ?></a></div>
      </div>
<?php else: ?>
<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
    </div>
  </div>
</div>
<script type="text/javascript">
        initDataTable('basic-datatable');
</script>