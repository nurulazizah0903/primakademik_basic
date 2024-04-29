<?php $school_id = school_id(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('violations/create'); ?>">
<input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="date"><?php echo get_phrase('date'); ?></label>
        <div class="col-md-9">
            <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
        </div>
    </div>
    
    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="class_id"><?php echo get_phrase('class'); ?></label>
        <div class="col-md-9">
            <select name="class_id" id="class_id_on_modal" class="form-control select2" data-toggle="select2"  required onchange="classWiseSectionOnCreate(this.value)">
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                <?php $classes = $this->crud_model->get_classes()->result_array(); ?>
                <?php foreach($classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="section_id"> <?php echo get_phrase('section'); ?></label>
        <div class="col-md-9">
        <select name="section_id" id="section_id_on_modal" class="form-control select2" data-toggle="select2" required onchange="classWiseStudentOnCreate(this.value)">
            <option value=""><?php echo get_phrase('select_a_section'); ?></option>
        </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="student_id"> <?php echo get_phrase('student'); ?></label>
        <div class="col-md-9" id = "student_content">
            <select name="student_id" id="student_id_on_modal" class="form-control select2" data-toggle="select2" required >
                <option value=""><?php echo get_phrase('select_a_student'); ?></option>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="award_id"><?php echo get_phrase('mistakes'); ?></label>
        <div class="col-md-9">
            <select name="mistake_id" id="mistake_id" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_a_mistakes'); ?></option>
                <?php $mistakes = $this->db->get_where('mistakes')->result_array(); ?>
                <?php foreach($mistakes as $mistake){ ?>
                    <option value="<?php echo $mistake['id']; ?>"><?php echo $mistake['name']; ?> - <?php echo $mistake['point']; ?> <?php echo get_phrase('point'); ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="description"> <?php echo get_phrase('description'); ?></label>
        <div class="col-md-9">
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>
    </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#date').daterangepicker();
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllViolations);
});

$(document).ready(function () {
  initSelect2(['#class_id_on_modal', '#section_id_on_modal', '#student_id_on_modal', '#mistake_id']);
});

function classWiseSectionOnCreate(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_on_modal').html(response);
            classWiseStudentOnCreate(classId);
        }
    });
}

function classWiseStudentOnCreate(classId) {
  $.ajax({
    url: "<?php echo route('student_extracurricular/student/'); ?>"+classId,
    success: function(response){
      $('#student_id_on_modal').html(response);
    }
  });
}
</script>
