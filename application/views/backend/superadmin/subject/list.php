<?php
$school_id = school_id();
if(isset($class_id) && $class_id != ''){
  $this->db->where('class_id', $class_id);
}
if(isset($section_id) && $section_id != ''){
  $this->db->where('section_id', $section_id);
}
if(isset($room_id) && $room_id != ''){
  $this->db->where('room_id', $room_id);
}
if(isset($session_id) && $session_id != ''){
  $this->db->where('session', $session_id);
}
$this->db->where('school_id', $school_id);
$subjects = $this->db->get('subjects')->result_array();
if (count($subjects) > 0): 
?>
  <table id="example" class="table table-striped dt-responsive" width="100%">
    <thead>
      <tr style="background-color: #313a46; color: #ababab;">
        <th><?php echo get_phrase('name'); ?></th>
        <th><?php echo get_phrase('section'); ?></th>
        <th><?php echo get_phrase('pengajar'); ?></th>
        <th><?php echo get_phrase('options'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($subjects as $subject){
        $teachers = $this->db->get_where('teachers', array('id' => $subject['teacher_id']))->row_array();
        ?>
        <tr>
          <td><?php echo $subject['name']; ?></td>
          <td><?php echo $this->db->get_where('class_rooms', array('id' => $subject['room_id']))->row('name'); ?></td>
          <td><?php echo $this->user_model->get_user_details($teachers['user_id'], 'name'); ?></td>
          <td>
          <a href="javascript:void(0);" onclick="showAjaxModal('<?php echo site_url('modal/popup/subject/edit/'.$subject['id'])?>', '<?php echo get_phrase('update_subject'); ?>');"><button type="button" class="btn btn-icon btn-warning btn-sm" style="margin-right:3px;" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></button></a>
				  <button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('subject/delete/'.$subject['id']); ?>', showAllSubjects )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
            <!-- <div class="dropdown text-center">
    					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
    					<div class="dropdown-menu dropdown-menu-right">
    						<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/subject/edit/'.$subject['id'])?>', '<?php echo get_phrase('update_subject'); ?>');"><?php echo get_phrase('edit'); ?></a>
    						<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('subject/delete/'.$subject['id']); ?>', showAllSubjects)"><?php echo get_phrase('delete'); ?></a>
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
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions : {
                    columns: [ 0 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>