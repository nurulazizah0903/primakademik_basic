<?php $visit_datas_details = $this->crud_model->get_visit_data_by_id($param1); ?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('visit_data/update/'.$param1); ?>">
  <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="date"><?php echo get_phrase('date'); ?></label>
    <div class="col-md-9">
      <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="<?php echo date('m/d/Y', $visit_datas_details['date']); ?>" required>
    </div>
  </div>

  <div class="form-group row mb-3">
  <label class="col-md-3 col-form-label" for="user_id"> <?php echo get_phrase('user_name'); ?></label>
  <div class="col-md-9">
    <select name="user_id" id="user_id" class="form-control" required>
      <option value=""><?php echo get_phrase('select_a_user_id'); ?></option>
      <?php
      $users = $this->crud_model->get_users()->result_array();
      foreach ($users as $user): ?>
      <option value="<?php echo $user['id']; ?>" <?php if ($visit_datas_details['user_id'] == $user['id']): ?> selected <?php endif; ?>><?php echo $user['name']; ?></option>
    <?php endforeach; ?>
  </select>
</div>
</div>

<div class="form-group  col-md-12">
  <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
</div>
</form>

<script>
$(document).ready(function() {
  $('#date').daterangepicker();
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllVisitData);
});

$(document).ready(function () {
  initSelect2(['#user_id']);
});
</script>
