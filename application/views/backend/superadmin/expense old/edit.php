<?php
  $expense_details = $this->crud_model->get_expense_by_id($param1);
 ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('expense2/update/'.$param1); ?>">
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="date"><?php echo get_phrase('date'); ?></label>
      <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="<?php echo date('m/d/Y', $expense_details['date']) ?>" required>
    </div>

    <div class="form-group col-md-12">
      <label for="name"><?php echo get_phrase('in_charge'); ?></label>
      <input type="text" class="form-control" id="in_charge" name = "in_charge" value="<?php echo $expense_details['in_charge']; ?>" required>
    </div>

    <div class="form-group col-md-12">
      <label for="description"><?php echo get_phrase('expense'); ?></label>      
      <textarea class="form-control" id="description" name="description" rows="3"> <?php echo $expense_details['description']; ?> </textarea>
    </div>

    <div class="form-group col-md-12">
      <label for="amount"><?php echo get_phrase('amount').' ('.currency_code_and_symbol('code').')'; ?></label>
      <input type="number" class="form-control" id="amount" name = "amount" value="<?php echo $expense_details['amount']; ?>" required>
    </div> 
  <div class="form-group  col-md-12">
    <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_expense'); ?></button>
  </div>
</div>
</form>

<script>
$(document).ready(function() {
  initSelect2(['#expense_category_id_on_update']);
  $('#date').daterangepicker();
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, showAllExpenses);
});
</script>
