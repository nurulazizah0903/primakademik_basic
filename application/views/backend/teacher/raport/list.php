<?php
$school_id = school_id();
$active_session = active_session();
$permissions = $this->db->get_where('teacher_permissions', array('id' => $permission_id))->row_array();
if(isset($permissions['class_id']) && $permissions['class_id'] != ''){
  $this->db->where('class_id', $permissions['class_id']);
}
if(isset($permissions['section_id']) && $permissions['section_id'] != ''){
  $this->db->where('section_id', $permissions['section_id']);
}
$this->db->where('school_id', $school_id);
$this->db->where('session', $active_session);
$enrols = $this->db->get('enrols')->result_array();
if (count($enrols) > 0): 
?>
<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="table-responsive">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%"> 
        <thead>
          <tr style="background-color: #313a46; color: #ababab;">
            <th width = 25%><?php echo get_phrase('nis'); ?></th>
            <th width = 25%><?php echo get_phrase('nisn'); ?></th>
            <th width = 25%><?php echo get_phrase('name'); ?></th>
            <th width = 25%><?php echo get_phrase('daftar_nilai_siswa'); ?></th>
            <th width = 25%><?php echo get_phrase('set_raport'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($enrols as $enroll){
            $student = $this->db->get_where('students', array('id' => $enroll['student_id']))->row_array();
            $parent = $this->db->get_where('parents', array('id' => $student['parent_id']))->row_array();
            ?>
            <tr>
              <td><?php echo $student['NIS']; ?></td>
              <td><?php echo $student['nisn']; ?></td>
              <td>
                <?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?>
              </td>
              <td>
                <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/raport/list_mark/'.$student['id'])?>', '<?php echo get_phrase('daftar_nilai_siswa'); ?>')" class="btn btn-info mdi mdi-clipboard-text"></a>
              </td>
              <td>
                <a href="<?php echo route('raport/create/'.$student['id']); ?>" class="btn btn-success mdi mdi-grease-pencil"></a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script type="text/javascript">
initDataTable('basic-datatable');
</script>