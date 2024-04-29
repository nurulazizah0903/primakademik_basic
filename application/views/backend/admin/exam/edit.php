<?php $exams = $this->db->get_where('exams', array('id' => $param1))->result_array(); ?>
<?php foreach($exams as $exam){ ?>
  <form method="POST" class="d-block ajaxForm" action="<?php echo route('exam/update/'.$param1); ?>">
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="exam_name"><?php echo get_phrase('exam_name'); ?></label>
        <input type="text" value="<?php echo $exam['name']; ?>" class="form-control" id="exam_name" name = "exam_name" placeholder="name" required>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_exam_name'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="semester"><?php echo get_phrase('semester'); ?></label>
            <select name="semester_id" id="semester_id" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_a_semester'); ?></option>
                <?php
                $semesters = $this->db->get_where('semester')->result_array();
                foreach($semesters as $semester){ ?>
                    <option value="<?php echo $semester['id']; ?>" <?php if ($exam['semester_id'] == $semester['id']): ?> selected <?php endif; ?>><?php echo $semester['name']; ?></option>
                <?php } ?>
            </select>
            <small id="semester" class="form-text text-muted"><?php echo get_phrase('provide_semester'); ?></small>
        </div>

      <div class="form-group col-md-12">
        <label for="starting_date"><?php echo get_phrase('starting_date'); ?></label>
        <input type="text" value="<?php echo date('m/d/Y', $exam['starting_date']); ?>" class="form-control date" id="starting_date" data-toggle="date-picker" data-single-date-picker="true" name = "starting_date" required>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_starting_date'); ?></small>
      </div>

      <div class="form-group col-md-12">
        <label for="ending_date"><?php echo get_phrase('ending_date'); ?></label>
        <input type="text" value="<?php echo date('m/d/Y', $exam['ending_date']); ?>" class="form-control date" id="ending_date" data-toggle="date-picker" data-single-date-picker="true" name = "ending_date" required>
        <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_ending_date'); ?></small>
      </div>

      <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_exam'); ?></button>
      </div>
    </div>
  </form>
<?php } ?>
<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllExams);
  });
  $("#starting_date" ).daterangepicker();
  $("#ending_date" ).daterangepicker();
</script>
