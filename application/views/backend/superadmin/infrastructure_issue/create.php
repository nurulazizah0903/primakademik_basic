<?php $school_id = school_id(); ?>
<div class="row">
    <div class="col-12">
        <div class="card pt-0">
        <h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('create_infrastructure_issue'); ?></h4>
            <form method="POST" class="d-block ajaxForm" action="<?php echo route('infrastructure_issue/add'); ?>">
            <div class="col-md-12">
                <div class="form-group row mb-3">
                    <label class="col-md-3 col-form-label" for="date"><?php echo get_phrase('date'); ?></label>
                    <div class="col-md-9">
                    <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
                    </div>
                </div>

                <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label" for="issue_start"><?php echo get_phrase('issue_start'); ?></label>
                <div class="col-md-9">
                <input type="time" class="form-control" name="issue_start" value="">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label" for="return_start"><?php echo get_phrase('return_start'); ?></label>
                <div class="col-md-9">
                <input type="time" class="form-control" name="return_start" value="">
                </div>
            </div>

                <div class="form-group row mb-3">
                    <label class="col-md-3 col-form-label" for="infrastructure_id"> <?php echo get_phrase('infrastructure'); ?></label>
                    <div class="col-md-9">
                        <select name="infrastructure_id" id="infrastructure_id_on_modal" class="form-control select2" data-toggle = "select2" required>
                            <option value=""><?php echo get_phrase('select_infrastructure'); ?></option>
                            <?php
                            $infrastructures = $this->crud_model->get_infrastructure()->result_array();
                            foreach ($infrastructures as $infrastructure): 
                                $number_of_issued_infrastructure = $this->crud_model->get_infrastructure_issue_by_id($infrastructure['id']);
                                $total = $infrastructure['amount'] - $number_of_issued_infrastructure;
                                if ($total >= 1) { ?>
                                <option value="<?php echo $infrastructure['id']; ?>"><?php echo $infrastructure['name'];?></option>
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
                    <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save_infrastructure_issue_info'); ?></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#date').daterangepicker();
});

$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, showAllInfrastructureIssues);
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
  initSelect2(['#role', '#user_id', '#infrastructure_id_on_modal']);
});

function roleWiseOnCreate(role) {
    $.ajax({
        url: "<?php echo route('infrastructure_issue/role/'); ?>"+role,
        success: function(response){
            $('#user_id').html(response);
            // classWiseStudent(role);
        }
    });
}
</script>
