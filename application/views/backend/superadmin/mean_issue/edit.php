<?php $mean_issue_details = $this->crud_model->get_mean_issue_id($param1); ?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('mean_issue/update/'.$param1); ?>">
  <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="issue_date"><?php echo get_phrase('issue_date'); ?></label>
    <div class="col-md-9">
      <input type="text" class="form-control date" id="issue_date" data-toggle="date-picker" data-single-date-picker="true" name = "issue_date" value="<?php echo date($mean_issue_details['issue_date']); ?>" required>
    </div>
  </div>

  <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="return_date"><?php echo get_phrase('return_date'); ?></label>
    <div class="col-md-9">
      <input type="text" class="form-control date" id="return_date" data-toggle="date-picker" data-single-date-picker="true" name = "return_date" value="<?php echo date($mean_issue_details['return_date']); ?>" required>
    </div>
  </div>

<div class="form-group row mb-3">
  <label class="col-md-3 col-form-label" for="mean_id"> <?php echo get_phrase('mean'); ?></label>
  <div class="col-md-9">
    <select name="mean_id" id="mean_id_on_modal" class="form-control select2" data-toggle = "select2" required>
      <option value=""><?php echo get_phrase('select_mean'); ?></option>
      <?php
      $means = $this->crud_model->get_means()->result_array();
      foreach ($means as $mean): ?>
      <option value="<?php echo $mean['id']; ?>" <?php if ($mean_issue_details['mean_id'] == $mean['id']): ?> selected <?php endif; ?>><?php echo $mean['name']; ?></option>
    <?php endforeach; ?>
  </select>
</div>
</div>

  <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="role"><?php echo get_phrase('role'); ?></label>
        <div class="col-md-9">
            <select name="role" id="role" class="form-control select2" data-toggle = "select2"  required onchange="roleWiseOnCreate(this.value)">
                <option value=""><?php echo get_phrase('select_role'); ?></option>
                <option value="teacher" <?php if(strtolower($this->user_model->get_user_details($mean_issue_details['user_id'], 'role')) == 'teacher') echo 'selected'; ?>><?php echo get_phrase('teacher'); ?></option>
                <option value="accountant" <?php if(strtolower($this->user_model->get_user_details($mean_issue_details['user_id'], 'role')) == 'accountant') echo 'selected'; ?>><?php echo get_phrase('accountant'); ?></option>
                <option value="student" <?php if(strtolower($this->user_model->get_user_details($mean_issue_details['user_id'], 'role')) == 'student') echo 'selected'; ?>><?php echo get_phrase('student'); ?></option>
                <option value="other_employee" <?php if(strtolower($this->user_model->get_user_details($mean_issue_details['user_id'], 'role')) == 'other_employee') echo 'selected'; ?>><?php echo get_phrase('other_employee'); ?></option>
            </select>
        </div>
    </div>

  <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="user_id"> <?php echo get_phrase('name'); ?></label>
        <div class="col-md-9">
        <select name="user_id" id="user_id" class="form-control select2" data-toggle="select2" required >
            <option value=""><?php echo get_phrase('select_a_name'); ?></option>
            <?php $users = $this->db->get_where('users', array('id' => $mean_issue_details['user_id']))->result_array();
            foreach ($users as $user): ?>
            <option value="<?php echo $user['id']; ?>" <?php if ($mean_issue_details['user_id'] == $user['id']): ?>selected<?php endif; ?>><?php echo $user['name']; ?></option>
            <?php endforeach; ?>
        </select>
        </div>
    </div>

<div class="form-group  col-md-12">
  <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_mean_issue_info'); ?></button>
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
  ajaxSubmit(e, form, showAllMeanIssues);
  location.reload();
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
