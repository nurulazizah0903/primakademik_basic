<?php
$payment_ppdb = $this->db->get_where('payment_ppdb', array('id' => $param1))->result_array();
foreach ($payment_ppdb as $item)
?>
  <form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('registration/update_payment_ppdb/'.$param1); ?>">
  <div class="form-row">
    <div class="form-group col-md-12">
      <label for="total"><?php echo get_phrase('total'); ?></label>
      <input type="number" class="form-control" id="total" required name="total" value="<?= $item['total'];?>">
    </div>
  </div>
    <button class="btn btn-primary col-sm-12" type="submit"><?php echo get_phrase('update') ?></button>
  </form>

<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit2(e, form, showAllStudents);
    location.reload();
  });
</script>
