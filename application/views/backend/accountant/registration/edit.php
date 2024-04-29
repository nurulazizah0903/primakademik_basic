<?php
$registrations = $this->db->get_where('registrations', array('id' => $param1))->result_array();
foreach ($registrations as $item)
?>
  <form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('registration/update/'.$param1.'/'.$param2); ?>">
  <input type="hidden" id="id" name="id" value="<?= $item['id'];?>">
    <div class="form-row">
    <div class="form-group col-md-12">
      <label for="kategori_spp"><?php echo get_phrase('kategori_spp'); ?></label>
        <select name="kategori_spp" id="kategori_spp" class="form-control select2" data-toggle = "select2"  required>
        <option value="Umum" <?php if($item['kategori_spp'] == 'Umum') echo 'selected'; ?>><?php echo get_phrase('Umum'); ?></option>
            <option value="SKM" <?php if($item['kategori_spp'] == 'SKM') echo 'selected'; ?>><?php echo get_phrase('SKM'); ?></option>
            <option value="MBR" <?php if($item['kategori_spp'] == 'MBR') echo 'selected'; ?>><?php echo get_phrase('MBR'); ?></option>  
        </select>
      </div>
      <div class="form-group col-md-12">
        <label for="kode_registrasi"><?php echo get_phrase('kode_registrasi'); ?></label>
        <input type="number" class="form-control" id="kode_registrasi" required name="kode_registrasi" value="<?= $item['kode_registrasi'];?>">
      </div>
      <div class="form-group col-md-12">
      <label for="status"><?php echo get_phrase('jurusan'); ?></label>
        <select name="jurusan" id="status_on_create" class="form-control select2" data-toggle = "select2"  required>
            <option value=""><?php echo get_phrase('select_a_classes'); ?></option>
            <option value="Multimedia"  <?php if($item['jurusan'] == 'Multimedia') echo 'selected'; ?>><?php echo get_phrase('Multimedia'); ?></option>
            <option value="Akuntansi"  <?php if($item['jurusan'] == 'Akuntansi') echo 'selected'; ?>><?php echo get_phrase('Akuntansi'); ?></option>
            <option value="Administrasi Perkantoran"  <?php if($item['jurusan'] == 'Administrasi Perkantoran') echo 'selected'; ?>><?php echo get_phrase('Administrasi Perkantoran'); ?></option>  
        </select>
      </div>
      <div class="form-group col-md-12">
        <label for="nik"><?php echo get_phrase('nik'); ?></label>
        <input type="number" class="form-control" id="nik" required name="nik" value="<?= $item['nik'];?>">
      </div>
      <div class="form-group col-md-12">
        <label for="nama_lengkap"><?php echo get_phrase('nama'); ?></label>
        <input type="text" class="form-control" id="nama_lengkap" required name="nama_lengkap" value="<?= $item['nama_lengkap'];?>">
      </div>
      <div class="form-group col-md-12">
        <label for="jenis_kelamin"><?php echo get_phrase('jenis_kelamin'); ?></label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control select2" data-toggle = "select2"  required>
            <option value=""><?php echo get_phrase('gender'); ?></option>
            <option value="Female"  <?php if($item['jenis_kelamin'] == 'Female') echo 'selected'; ?>><?php echo get_phrase('female'); ?></option>
            <option value="Male"  <?php if($item['jenis_kelamin'] == 'Male') echo 'selected'; ?>><?php echo get_phrase('male'); ?></option>
        </select>
      </div>
      <div class="form-group col-md-12">
        <label for="tempat_lahir"><?php echo get_phrase('tempat_lahir'); ?></label>
        <input type="text" class="form-control" id="tempat_lahir" required name="tempat_lahir" value="<?= $item['tempat_lahir'];?>">
      </div>
      <div class="form-group col-md-12">
        <label for="tgl_lahir"><?php echo get_phrase('tgl_lahir'); ?></label>
        <input type="text" class="form-control" id="tgl_lahir" required name="tgl_lahir" value="<?= $item['tgl_lahir'];?>">
      </div>
      <div class="form-group col-md-12">
        <label for="nisn"><?php echo get_phrase('nisn'); ?></label>
        <input type="text" class="form-control" id="nisn" name="nisn" value="<?= $item['nisn'];?>">
      </div>
      <div class="form-group col-md-12">
        <label for="sekolah_asal"><?php echo get_phrase('sekolah_asal'); ?></label>
        <input type="text" class="form-control" id="sekolah_asal" name="sekolah_asal" value="<?= $item['sekolah_asal'];?>">
      </div>
      <div class="form-group col-md-12">
        <label for="nama_orang_tua"><?php echo get_phrase('nama_orang_tua'); ?></label>
        <input type="text" class="form-control" id="nama_orang_tua" required name="nama_orang_tua" value="<?= $item['nama_orang_tua'];?>">
      </div>
      <div class="form-group col-md-12">
        <label for="pekerjaan_orang_tua"><?php echo get_phrase('pekerjaan_orang_tua'); ?></label>
        <input type="text" class="form-control" id="pekerjaan_orang_tua" required name="pekerjaan_orang_tua" value="<?= $item['pekerjaan_orang_tua'];?>">
      </div>
      <div class="form-group col-md-12">
          <label for="name"><?php echo get_phrase('alamat'); ?></label>
          <textarea name="alamat" id="alamat" class="form-control" required cols="5" rows="5"><?=$item['alamat'];?></textarea>
      </div>
      <div class="form-group col-md-12">
        <label for="telephone"><?php echo get_phrase('telephone'); ?></label>
        <input type="text" class="form-control" id="telephone" required name="telephone" value="<?= $item['telephone'];?>">
      </div>
      <div class="form-group col-md-12">
        <label for="info_sekolah"><?php echo get_phrase('info_sekolah'); ?></label>
        <input type="text" class="form-control" id="info_sekolah" required name="info_sekolah" value="<?= $item['info_sekolah'];?>">
      </div>
      <div class="form-group col-md-12">
        <label for="jalur_pendaftaran"><?php echo get_phrase('jalur_pendaftaran'); ?></label>
        <select name="jalur_pendaftaran" id="jalur_pendaftaran" class="form-control select2" data-toggle = "select2"  required>
          <option value=""><?php echo get_phrase('pilih_jalur_pendaftaran'); ?></option>
          <?php $registration_paths = $this->db->get_where('registration_path')->result_array(); ?>
          <?php foreach($registration_paths as $registration_path){ ?>
              <option value="<?php echo $registration_path['id']; ?>" <?php if($item['jalur_pendaftaran'] == $registration_path['id']) echo 'selected'; ?>><?php echo $registration_path['name']; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group col-md-12">
      <label for="status"><?php echo get_phrase('status'); ?></label>
        <select name="status" id="status_on_create" class="form-control select2" data-toggle = "select2"  required>
            <option value=""><?php echo get_phrase('select_a_status'); ?></option>
            <option value="Not Yet Paid"  <?php if($item['status'] == 'Not Yet Paid') echo 'selected'; ?>><?php echo get_phrase('belum_bayar'); ?></option>
            <option value="Installment"  <?php if($item['status'] == 'Installment') echo 'selected'; ?>><?php echo get_phrase('Inden_Angsur'); ?></option>
            <option value="Accepted"  <?php if($item['status'] == 'Accepted') echo 'selected'; ?>><?php echo get_phrase('diterima'); ?></option>  
            <option value="Not Accepted"  <?php if($item['status'] == 'Not Accepted') echo 'selected'; ?>><?php echo get_phrase('tidak_diterima'); ?></option>
            <option value="Removed" <?php if($item['status'] == 'Removed') echo 'selected'; ?>><?php echo get_phrase('mengundurkan_diri'); ?></option>
        </select>
      </div>
      <div class="form-group col-md-12">
          <label for="name"><?php echo get_phrase('keterangan'); ?></label>
          <textarea name="ket" id="ket" class="form-control" cols="5" rows="5"><?=$item['ket'];?></textarea>
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
  ajaxSubmit2(e, form, showAllStudents);
  location.reload();
});


// initCustomFileUploader();
</script>
