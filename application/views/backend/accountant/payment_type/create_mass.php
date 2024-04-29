<?PHP  $active_session = active_session(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('payment_type/create_mass'); ?>" id="form1">
<p class="text-muted font-14">
    Dapat menambah Tipe Tagihan secara banyak dengan cara <code>memilih dan otomatis menyalin Tipe Tagihan yang ada di Tahun Kurikulum tersebut</code>. 
</p>
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="session_from"><?php echo get_phrase('Salin dari tahun ajaran :'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="session_from" name="session_from" required> 
                <?php $sessions = $this->db->get('sessions')->result_array(); ?> 
                <?php foreach($sessions as $session): ?>
                    <option value="<?php echo $session['id']; ?>"  <?php if ($session['id'] == $active_session): ?> selected <?php endif; ?> ><?php echo $session['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="session_to"><?php echo get_phrase('Ke tahun ajaran :'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="session_to" name="session_to" required> 
                <?php $sessions = $this->db->get('sessions')->result_array(); ?> 
                <?php foreach($sessions as $session): ?>
                    <option value="<?php echo $session['id']; ?>"  <?php if ($session['id'] == $active_session): ?> selected <?php endif; ?> ><?php echo $session['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_invoice_types'); ?></button>
        </div>
    </div>
</form> 
<script>
    $(document).ready(function () {
  initSelect2(['#session_from', '#session_to']);
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit2(e, form, showAllPaymentType);
});
</script>
