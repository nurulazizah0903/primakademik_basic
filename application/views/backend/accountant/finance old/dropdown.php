<option value=""><?php echo get_phrase('invoices'); ?></option>
<?php if (count($invoices) > 0): ?>
  <?php foreach ($invoices as $invoice): ?>
    <option value="<?php echo $invoice->id; ?>"><?php echo $invoice->title; ?></option>
  <?php endforeach; ?>
<?php else: ?>
  <option value=""><?php echo "Data Tidak Ditemukan"; ?></option>
<?php endif; ?>

