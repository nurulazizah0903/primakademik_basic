<?php $school_id = school_id(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('mean_issue/add'); ?>">
    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="issue_date"><?php echo get_phrase('issue_date'); ?></label>
        <div class="col-md-9">
            <input type="text" class="form-control date" id="issue_date" data-toggle="date-picker" data-single-date-picker="true" name = "issue_date" value="" required>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="return_date"><?php echo get_phrase('return_date'); ?></label>
        <div class="col-md-9">
        <input type="text" class="form-control date" id="return_date" data-toggle="date-picker" data-single-date-picker="true" name = "return_date" value="" required>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="mean_id"> <?php echo get_phrase('mean'); ?></label>
        <div class="col-md-9">
            <select name="mean_id" id="mean_id_on_modal" class="form-control" required>
                <option value=""><?php echo get_phrase('select_mean'); ?></option>
                <?php
                $meanes = $this->db->get_where('means')->result_array();
                $number_of_issued_mean = $this->crud_model->get_number_of_issued_mean_by_id($meanes['id']);
                $means = $this->crud_model->get_means()->result_array();
                foreach ($means as $mean): ?>
                    <option value="<?php echo $mean['id']; ?>"><?php echo $mean['name'];?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="role"><?php echo get_phrase('role'); ?></label>
        <div class="col-md-9">
            <select name="role" id="role" class="form-control select2" data-toggle = "select2"  required onchange="roleWiseOnCreate(this.value)">
                <option value=""><?php echo get_phrase('select_role'); ?></option>
                <option value="teacher" ><?php echo get_phrase('teacher'); ?></option>
                <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                <option value="student"><?php echo get_phrase('student'); ?></option>
                <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="user_id"> <?php echo get_phrase('name'); ?></label>
        <div class="col-md-9">
        <select name="user_id" id="user_id" class="form-control select2" data-toggle="select2" required >
            <option value=""><?php echo get_phrase('select_a_name'); ?></option>
        </select>
        </div>
    </div>

    <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save_mean_issue_info'); ?></button>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#issue_date').daterangepicker();
});

$(document).ready(function() {
    $('#return_date').daterangepicker();
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, showAllMeanIssues);
  location.reload();
});

$(document).ready(function () {
  initSelect2(['#role', '#user_id', '#mean_id_on_modal']);
});

function roleWiseOnCreate(role) {
    $.ajax({
        url: "<?php echo route('mean_issue/role/'); ?>"+role,
        success: function(response){
            $('#user_id').html(response);
            // classWiseStudent(role);
        }
    });
}
</script>