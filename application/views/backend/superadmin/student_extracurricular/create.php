<?php $school_id = school_id(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('student_extracurricular/create'); ?>">

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="student_id"> <?php echo get_phrase('student'); ?></label>
        <div class="col-md-9" id = "student_content">
            <select name="student_id" id="student_id_on_modal" class="form-control select2" data-toggle="select2"  required >
                <option value=""><?php echo get_phrase('select_a_student'); ?></option>
                <?php $students = $this->user_model->get_user_students()->result_array(); ?>
                <?php foreach($students as $student): ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo $this->db->get_where('students', array('user_id' => $student['id']))->row('nisn'); ?> - <?php echo $student['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="organizations_id"> <?php echo get_phrase('organizations'); ?></label>
        <div class="col-md-9">
            <?php $organizations = $this->db->get_where('organizations', array('school_id' => school_id()))->result_array(); ?>
            <?php foreach($organizations as $organization){ ?>
            <input type="checkbox" name="organizations_id[]" id="organizations_id" value="<?php echo $organization['id']; ?>">
            <label><?php echo $organization['name']; ?></label><br>
            <?php } ?>
        </div>
    </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllStudentsextracurricular);
    location.reload();
});

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

$(document).ready(function () {
  initSelect2(['#class_id_on_modal', '#section_id_on_modal', '#student_id_on_modal', '#room_id_on_modal']);
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

function sectionWiseClassroomsOnCreate(sectionId) {
    $.ajax({
        url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
        success: function(response){
        $('#room_id_on_modal').html(response);
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
