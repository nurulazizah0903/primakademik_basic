<?php
$registrations = $this->db->get_where('registrations', array('id' => $param1))->result_array();
// var_dump($registrations);
// die;
foreach ($registrations as $item)
?>
  <form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('registration/update/'.$param1.'/'.$param2); ?>">
  <input type="hidden" id="id" name="id" value="<?= $item['id'];?>">
  <input type="hidden" id="kode_registrasi" name="kode_registrasi" value="<?= $item['kode_registrasi'];?>">
  <input type="hidden" id="nisn" name="nisn" value="<?= $item['nisn'];?>">
  <input type="hidden" id="nama_lengkap" name="nama_lengkap" value="<?= $item['nama_lengkap'];?>">
  <input type="hidden" id="bukti_bayar" name="bukti_bayar" value="<?= $item['bukti_bayar'];?>">
  <div class="form-row">
        <div class="form-group col-md-12">
        <label for="status"><?php echo get_phrase('status'); ?></label>
           <select name="status" id="status_on_create" class="form-control select2" data-toggle = "select2"  required>
                <option value=""><?php echo get_phrase('select_a_status'); ?></option>
                <option value="Not Yet Paid"  <?php if($item['status'] == 'Not Yet Paid') echo 'selected'; ?>><?php echo get_phrase('lulus_seleksi'); ?></option>
                <option value="Not Accepted"  <?php if($item['status'] == 'Not Accepted') echo 'selected'; ?>><?php echo get_phrase('tidak_lulus_seleksi'); ?></option>
                <option value="Not Yet Paid"  <?php if($item['status'] == 'Not Yet Paid') echo 'selected'; ?>><?php echo get_phrase('belum_bayar'); ?></option>
                <option value="Processed"  <?php if($item['status'] == 'Processed') echo 'selected'; ?>><?php echo get_phrase('diproses'); ?></option>
                <option value="Accepted"  <?php if($item['status'] == 'Accepted') echo 'selected'; ?>><?php echo get_phrase('diterima'); ?></option>
                <option value="Not Accepted"  <?php if($item['status'] == 'Not Accepted') echo 'selected'; ?>><?php echo get_phrase('tidak_diterima'); ?></option>
                <option value="Removed" <?php if($item['status'] == 'Removed') echo 'selected'; ?>><?php echo get_phrase('mengundurkan_diri'); ?></option>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('keterangan'); ?></label>
            <textarea name="ket" id="ket" class="form-control" cols="5" rows="5"></textarea>
        </div>
  </div>
            <button class="btn btn-primary col-sm-12" type="submit"><?php echo get_phrase('update') ?></button>
  </form>

<script>
$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}


$(document).ready(function () {
  initSelect2(['#status_on_create']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllStudents);
  location.reload();
});


// initCustomFileUploader();
</script>
