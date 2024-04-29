<form method="POST" action="<?= route('mark/mark_update') ?>" class="ajaxForm" id="mark_update">
    <div class="row mb-3">
      <div class="col-md-4"></div>
      <div class="col-md-4 toll-free-box text-center text-white pb-2" style="background-color: #6c757d; border-radius: 10px;">
        <h4><?php echo get_phrase('manage_marks'); ?></h4>
        <span><?php echo get_phrase('class'); ?> : <?php echo $this->db->get_where('classes', array('id' => $class_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('section'); ?> : <?php echo $this->db->get_where('sections', array('id' => $section_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('class_rooms'); ?> : <?php echo $this->db->get_where('class_rooms', array('id' => $room_id))->row('name'); ?></span><br>
        <span><?php echo get_phrase('subject'); ?> : <?php echo $this->db->get_where('subjects', array('id' => $subject_id))->row('name'); ?></span>
      </div>
    </div>
    <?php
    $school_id = school_id();
    $marks = $this->crud_model->get_marks($class_id, $section_id, $room_id, $subject_id)->result_array();
    ?>
    <?php if (count($marks) > 0): ?>
      <table class="table table-bordered table-responsive-sm" width="100%">
        <thead class="thead-dark">
          <tr>
            <th><?php echo get_phrase('student_name'); ?></td>
            <th><?php echo get_phrase('mark_knowledge'); ?></td>
            <th><?php echo get_phrase('mark_skills'); ?></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach($marks as $mark):
            $student = $this->db->get_where('students', array('id' => $mark['student_id']))->row_array(); ?>
            <tr>
              <td><?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?></td>
              <td><input class="form-control" type="number" id="mark_knowledge-<?php echo $mark['student_id']; ?>" name="mark_knowledge[]" placeholder="<?php echo get_phrase('mark_knowledge'); ?>" min="0" value="<?= $mark['mark_knowledge']; ?>"></td>
              <td><input class="form-control" type="number" id="mark_skills-<?php echo $mark['student_id']; ?>" name="mark_skills[]" placeholder="<?php echo get_phrase('mark_skills'); ?>" min="0" value="<?= $mark['mark_skills']; ?>"></td>
              <input type="hidden" name="student_id[]" id="student_id" value="<?php echo $mark['student_id']; ?>">
              <input type="hidden" name="class_id[]" id="class_id" value="<?= $class_id ?>">
              <input type="hidden" name="section_id[]" id="section_id" value="<?= $section_id ?>">
              <input type="hidden" name="room_id[]" id="room_id" value="<?= $room_id ?>">
              <input type="hidden" name="subject_id[]" id="subject_id" value="<?= $subject_id ?>">
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <center>
        <input type="submit" id="mark_update" name="mark_update" onclick="validation(this.id)" class="btn btn-success" value="<?= get_phrase('mark_update') ?>" />
      </center>
    <?php else: ?>
      <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
</form>

<script>
  var validated = false;
  var action = "";
  function validation(id) {
    action = id;
    if (action == "submit_move") {
      if ($('#move_session_id').val() == "" || $('#move_class_id').val() == "" || $('move_section_id').val() == "") {
        validated = false;
        toastr.error('<?php echo get_phrase('please_select_the_fields'); ?>');
      } else {
        validated = true;
      }
    } else {
      validated = true;
    }
  }
  
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
    filter_attendance();
  }

// function mark_update(student_id){
//   var class_id = '<?php echo $class_id; ?>';
//   var section_id = '<?php echo $section_id; ?>';
//   var subject_id = '<?php echo $subject_id; ?>';
//   var room_id = '<?php echo $room_id; ?>';
//   var mark_skills = $('#mark_skills-' + student_id).val();
//   var mark_knowledge = $('#mark_knowledge-' + student_id).val();
//   if(subject_id != ""){
//     $.ajax({
//       type : 'POST',
//       url : '<?php echo route('mark/mark_update'); ?>',
//       data : {student_id : student_id, class_id : class_id, section_id : section_id, room_id : room_id, subject_id : subject_id, mark_skills : mark_skills, mark_knowledge : mark_knowledge},
//       success : function(response){
//         toastr.success('<?php echo get_phrase('mark_hass_been_updated_successfully'); ?>');
//       }
//     });
//   }else{
//     toastr.error('<?php echo get_phrase('required_mark_field'); ?>');
//   }
// }

// function get_grade(exam_mark, id){
//   $.ajax({
//     url : '<?php echo route('get_grade'); ?>/'+exam_mark,
//     success : function(response){
//       $('#grade-for-'+id).text(response);
//     }
//   });
// }
</script>
