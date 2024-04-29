<?php $school_id = school_id(); ?>
<div class="row">
    <div class="col-12">
        <div class="card pt-0">
            <h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('create_mean_issue'); ?></h4>
                <form method="POST" class="d-block ajaxForm" action="<?php echo route('mean_issue/add'); ?>">
                <div class="col-md-12">
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
                            <select name="mean_id" id="mean_id_on_modal" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_mean'); ?></option>
                                <?php
                                $means = $this->crud_model->get_means()->result_array();
                                foreach ($means as $mean): 
                                    $number_of_issued_mean = $this->crud_model->get_number_of_issued_mean_by_id($mean['id']);
                                    $total = $mean['amount'] - $number_of_issued_mean;
                                    if ($total >= 1) { ?>
                                    <option value="<?php echo $mean['id']; ?>"><?php echo $mean['name'];?></option>
                                    <?php } else {
                                    }
                                    ?>
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
                </div>
                </form>
        </div>
    </div>
</div>

<script>

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllMeanIssues);
});

$(document).ready(function () {
  initSelect2(['#role', '#user_id', '#mean_id_on_modal']);
});

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

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
