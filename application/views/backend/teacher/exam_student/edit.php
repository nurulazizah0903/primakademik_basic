<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
?>
<?php $exam = $this->db->get_where('exam_students', array('id' => $param1))->row_array(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('addons/exam/index/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="title"><?php echo get_phrase('title'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="exam_types_id" name="exam_types_id" required>
                <option value=""><?php echo get_phrase('select_a_exam_types'); ?></option>
                <?php $exam_types = $this->db->get_where('exam_types', array('school_id' => school_id()))->result_array(); ?>
                <?php foreach($exam_types as $exam_type): ?>
                    <option value="<?php echo $exam_type['id']; ?>" <?php if($exam['exam_types_id'] == $exam_type['id']) echo 'selected'; ?>><?php echo $exam_type['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="deadline"><?php echo get_phrase('tenggat_waktu'); ?></label>
            <input type="text" value="<?php echo date('m/d/Y', $exam['deadline']); ?>" class="form-control date" id="deadline" data-toggle="date-picker" data-single-date-picker="true" name = "deadline" value="" required>
        </div>

        <div class="form-group col-md-12">
          <label for="subject_id_on_create"><?php echo get_phrase('subject'); ?></label>
          <select name="subject_id" id = "subject_id_on_create" class="form-control select2" required>
            <option value=""><?php echo get_phrase('select_a_subject'); ?></option>
            <?php $subjects = $this->db->get_where('subjects', array('school_id' => school_id(), 'teacher_id' => $teacher_id))->result_array(); ?>
            <?php foreach($subjects as $subject): ?>
                <option value="<?php echo $subject['id']; ?>" <?php if($exam['subject_id'] == $subject['id']) echo 'selected'; ?>><?php echo $subject['name']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group mt-2 col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_exam'); ?></button>
        </div>
    </div>
</form>

<?php include 'common_script.php'; ?>

<script>
  'use strict';

  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
      var form = $(this);
      ajaxSubmit(e, form, showExams);
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
