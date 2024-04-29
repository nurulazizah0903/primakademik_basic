<form method="POST" class="d-block ajaxForm" action="<?php echo route('expense2/create'); ?>">
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="date"><?php echo get_phrase('date'); ?></label>
      <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
    </div>

    <div class="form-group col-md-12">
      <label for="name"><?php echo get_phrase('in_charge'); ?></label>
      <input type="text" class="form-control" id="in_charge" name = "in_charge" required>
    </div>

    <div class="form-group col-md-12">
      <label for="description"><?php echo get_phrase('expense'); ?></label>      
      <textarea class="form-control" id="description" name="description" rows="3"></textarea>
    </div>

    <div class="form-group col-md-12">
      <label for="amount"><?php echo get_phrase('amount').' ('.currency_code_and_symbol('code').')'; ?></label>
      <input type="number" class="form-control" id="amount" name = "amount" required>
    </div> 

   <div class="form-group  col-md-12">
    <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_expense'); ?></button>
  </div>
</div>
</form>

<script>
$(document).ready(function() {
  initSelect2(['#expense_category_id_on_create']);
  $('#date').daterangepicker();
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, showAllExpenses);
});
</script>
