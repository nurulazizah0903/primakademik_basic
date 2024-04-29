<?php
$school_id = school_id();
$active_session = active_session();
if(isset($class_id) && $class_id != ''){
  $this->db->where('class_id', $class_id);
}
if(isset($section_id) && $section_id != ''){
  $this->db->where('section_id', $section_id);
}
if(isset($room_id) && $room_id != ''){
    $this->db->where('room_id', $room_id);
}
$this->db->where('school_id', $school_id);
// $this->db->where('session',  $active_session);
$enrols = $this->db->get_where('enrols')->result_array();
if(count($enrols) > 0):?>
<div class="row justify-content-center">
  <div class="col-md-12">
    <div class="table-responsive">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%"> 
        <thead>
          <tr style="background-color: #313a46; color: #ababab;">
            <th width = 25%><?php echo get_phrase('name'); ?></th>
            <th width = 25%><?php echo get_phrase('organizations'); ?></th>
            <th width = 25%><?php echo get_phrase('options'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach($enrols as $enroll){
            $student = $this->db->get_where('students', array('id' => $enroll['student_id']))->row_array();
            $student_extracurriculars = $this->db->get_where('student_extracurricular', array('student_id' => $student['id']))->row_array();
            
            ?>
            <tr>
            <td><?= $student['nisn'];?> - <?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
            <td>
            <?php 
              $student_eks = $student_extracurriculars['organizations_id'];
              if(!is_null($student_eks)) {
                $organization = explode(",", $student_eks);
                foreach($organization as $organ){
                  $organizations = $this->db->get_where('organizations', array('id' => $organ))->row_array();
                  ?>
                  <ul>
                    <li><?= $organizations['name'];?></li>
                  </ul>
                  <?php
                }
              }
            
            ?></td>
              <td>
                <div class="dropdown text-center">
                  <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                  <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/student_extracurricular/update/'.$student['id'])?>', '<?php echo get_phrase('update_student_extracurricular_information'); ?>');"><?php echo get_phrase('edit'); ?></a>
                  </div>
                </div>
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

<script>
// $(document).ready(function() {
//     $('#example').DataTable( {
//         dom: 'Bfrtip',
//         buttons: [
//             {
//                 extend: 'excelHtml5',
//                 exportOptions : {
//                     columns: [ 0 , 1 , 2 , 3 , 4 ]
//                 },
//                 text: 'Export to Excel <i class="far fa-file-excel"></i>',
//                 className: 'btn btn-info btn-md p-2',
//             }
//         ]
//     } );
// } );
</script>
<script type="text/javascript">

var validated = false;
var action = "";

var form;
$(".ajaxForm").submit(function(e) {
  e.preventDefault();
  form = $(this);
  if(validated) {
    var add = {action:action};
    ajaxSubmit(e, form, refreshForm, add);
  }
});
var refreshForm = function () {
  filter_student();
}

</script>