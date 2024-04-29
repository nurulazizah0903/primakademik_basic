<form method="POST" class="d-block ajaxForm" action="<?php echo route('payment_type/create'); ?>" id="form1">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('invoice_name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
        </div>
		<div class="form-group col-md-12">
            <label for="price"><?php echo get_phrase('price'); ?></label>
            <input type="number" class="form-control" id="price" name = "price" required>
        </div> 
        <input type="hidden" class="form-control" id="units" name = "units"> 
		<div class="form-group col-md-12">
            <label for="session"><?php echo get_phrase('session'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="session" name="session" required>
                <option value="0"><?php echo get_phrase('select_a_session'); ?></option>
                <?php $sessions = $this->db->get_where('sessions', array('status' => 1))->result_array(); ?> 
                <?php foreach($sessions as $session): ?>
                    <option value="<?php echo $session['id']; ?>"><?php echo $session['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="note"><?php echo get_phrase('note'); ?></label>      
            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_invoice_types'); ?></button>
        </div>
    </div>
</form> 
<script>
    $(document).ready(function () {
  initSelect2(['#session']);
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit2(e, form, showAllPaymentType);
});
</script>
