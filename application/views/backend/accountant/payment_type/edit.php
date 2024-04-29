<?php $payment_types = $this->db->get_where('payment_types', array('id' => $param1))->result_array(); ?>
<?php foreach($payment_types as $payment_type){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('payment_type/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $payment_type['name']; ?>" id="name" name = "name" required>
        </div>
		<div class="form-group col-md-12">
            <label for="price"><?php echo get_phrase('price'); ?></label>
            <input type="number" class="form-control" value="<?php echo $payment_type['price']; ?>" id="price" name = "price" required>
        </div>
        <?PHP /*  
		<div class="form-group col-md-12">
            <label for="units"><?php echo get_phrase('units'); ?></label>
            <input type="text" class="form-control" value="<?php echo $payment_type['units']; ?>" id="units" name = "units" required>
        </div> 
        */ ?>
        <div class="form-group col-md-12">
            <label for="session"><?php echo get_phrase('session'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="session" name="session" required> 
                <?php $sessions = $this->db->get('sessions')->result_array(); ?> 
                <?php foreach($sessions as $session): ?>
                    <option value="<?php echo $session['id']; ?>"  <?php if ($session['id'] == $payment_type['session']): ?> selected <?php endif; ?> ><?php echo $session['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label for="note"><?php echo get_phrase('note'); ?></label>      
            <textarea class="form-control" id="note" name="note" rows="3"  ><?php echo $payment_type['note']; ?></textarea>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('edit_invoice_types'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

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
