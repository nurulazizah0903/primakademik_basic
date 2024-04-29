<?php $visit_datas_details = $this->crud_model->get_visit_data_by_id($param1); 
// print_r($visit_datas_details['name']);
// die;
?>

<form method="POST" class="d-block ajaxForm" action="<?php echo route('visit_data/update/'.$param1); ?>">
  <div class="form-group row mb-3">
    <label class="col-md-3 col-form-label" for="date"><?php echo get_phrase('date_visit'); ?></label>
    <div class="col-md-9">
      <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="<?php echo date('m/d/Y', $visit_datas_details['date']); ?>" required>
    </div>
  </div>

<?php if (!empty($visit_datas_details['user_id'])) { ?>

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

<?php }else {?>

  <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="nik"><?php echo get_phrase('nik'); ?></label>
            <div class="col-md-9">
                <input type="number" class="form-control" name = "nik" value="<?= $visit_datas_details['nik']; ?>" >
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="name"><?php echo get_phrase('name'); ?></label>
            <div class="col-md-9">
                <input type="text" class="form-control" name = "name" value="<?= $visit_datas_details['name']; ?>" >
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="address"><?php echo get_phrase('alamat'); ?></label>
            <div class="col-md-9">
                <textarea id="address" class="form-control" name="address" rows="4" cols="50" ><?= $visit_datas_details['address']; ?></textarea>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="phone"><?php echo get_phrase('phone'); ?></label>
            <div class="col-md-9">
                <input type="number" class="form-control" name = "phone" value="<?= $visit_datas_details['phone']; ?>" >
            </div>
        </div>

<?php } ?>

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
