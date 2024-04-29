<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
$profile_data = $this->user_model->get_profile_data();
?>
<?php $assignment = $this->db->get_where('assignments', array('id' => $param1))->row_array(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('addons/assignment/index/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="title"><?php echo get_phrase('title'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="assignment_types_id" name="assignment_types_id" required>
                <option value=""><?php echo get_phrase('select_a_assignment_types'); ?></option>
                <?php $assignment_types = $this->db->get_where('assignment_types', array('school_id' => school_id()))->result_array(); ?>
                <?php foreach($assignment_types as $assignment_type): ?>
                    <option value="<?php echo $assignment_type['id']; ?>" <?php if($assignment['assignment_types_id'] == $assignment_type['id']) echo 'selected'; ?>><?php echo $assignment_type['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="deadline"><?php echo get_phrase('tenggat_waktu'); ?></label>
            <input type="text" value="<?php echo date('m/d/Y', $assignment['deadline']); ?>" class="form-control date" id="deadline" data-toggle="date-picker" data-single-date-picker="true" name = "deadline" value="" required>
        </div>

        <div class="form-group col-md-12">
          <label for="subject_id_on_create"><?php echo get_phrase('subject'); ?></label>
          <select name="subject_id" id = "subject_id_on_create" class="form-control select2" required>
            <option value=""><?php echo get_phrase('select_a_subject'); ?></option>
            <?php $subjects = $this->db->get_where('subjects', array('school_id' => school_id(), 'teacher_id' => $teacher_id))->result_array(); ?>
            <?php foreach($subjects as $subject): ?>
                <option value="<?php echo $subject['id']; ?>" <?php if($assignment['subject_id'] == $subject['id']) echo 'selected'; ?>><?php echo $subject['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group col-md-12">
            <label for="course_id"><?php echo get_phrase('course_list'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="course_id_on_create" name="course_id">
                <option value=""><?php echo get_phrase('select_course_list'); ?></option>
                <?php $courses = $this->db->get_where('course', array('school_id' => school_id()))->result_array(); ?>
                <?php foreach($courses as $course): ?>
                    <option value="<?php echo $course['id']; ?>" <?php if($assignment['course_id'] == $course['id']) echo 'selected'; ?>><?php echo $course['title']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mt-2 col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_assignment'); ?></button>
        </div>
    </div>
</form>

<?php include 'common_script.php'; ?>

<script>
  'use strict';

  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
      var form = $(this);
      ajaxSubmit(e, form, showAssignments);
  });

  $(function(){
      $('.select2').select2();
  });

  if($('select').hasClass('select2') == true){
      $('div').attr('tabindex', "");
      $(function(){$(".select2").select2()});
  }


  $('#deadline').daterangepicker();
</script>
