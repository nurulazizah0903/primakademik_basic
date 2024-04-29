<?php $school_id = school_id(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('achievements/create'); ?>">
<input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="date"><?php echo get_phrase('date'); ?></label>
        <div class="col-md-9">
            <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="student_id"> <?php echo get_phrase('student'); ?></label>
        <div class="col-md-9" id = "student_content">
            <select name="student_id" id="student_id_on_modal" class="form-control select2" data-toggle="select2" required >
                <option value=""><?php echo get_phrase('select_a_student'); ?></option>
                <?php $students = $this->user_model->get_students()->result_array(); ?>
                <?php foreach($students as $student): ?>
                    <option value="<?php echo $student['id']; ?>"><?php echo $student['nisn']; ?> - <?php echo $this->db->get_where('users', array('id' => $student['user_id']))->row('name'); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="award_id"><?php echo get_phrase('awards'); ?></label>
        <div class="col-md-9">
            <select name="award_id" id="award_id" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_a_awards'); ?></option>
                <?php $awards = $this->db->get_where('awards', array('school_id' => school_id()))->result_array(); ?>
                <?php foreach($awards as $award){ ?>
                    <option value="<?php echo $award['id']; ?>"><?php echo $award['name']; ?> - <?= $award['point'];?> Point</option>
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
    ajaxSubmit2(e, form, showAllAchievements);
    location.reload();
});

$(document).ready(function () {
  initSelect2(['#student_id_on_modal', '#award_id']);
});

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}
</script>
