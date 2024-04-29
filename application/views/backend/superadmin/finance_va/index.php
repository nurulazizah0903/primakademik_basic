<?php
// if($settings_type == 'system_settings')
// $class = 'col-xl-12';
// else if($settings_type == 'payment_settings')
// $class = 'col-xl-10 offset-xl-1';
// else if($settings_type == 'language_settings')
// $class = 'col-xl-10 offset-xl-1';
// else if($settings_type == 'sms_settings')
// $class = 'col-xl-10 offset-xl-1';
// else if($settings_type == 'smtp_settings')
// $class = 'col-xl-10 offset-xl-1';
// else if($settings_type == 'school_settings')
// $class = 'col-xl-10 offset-xl-1';
// else if($settings_type == 'sms_settings')
// $class = 'col-xl-10 offset-xl-1';
?>

<!-- start page title -->
<?PHP /*  
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-settings title_icon"></i><?php echo ucfirst(get_phrase('system_settings')); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
*/ ?>
<!-- end page title -->
<div class="row">
  <div class='col-xl-12'>
    <div class="settings_content">
<!--------------------------------------------------------------------  --------------------------------------------------------------------->
<div class="row">
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-body">
        <h4> Pembayaran via Virtual Account</h4>
        <br>
        <form method="POST" class="col-12 systemAjaxForm" action="<?php echo route('finance/finance_va_add') ;?>" >
          <div class="col-12">

            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="namasantri"> Nama Siswa</label>
              <div class="col-md-9">
                <input type="text" id="namasantri" name="namasantri" class="form-control" required>
              </div>
            </div>
            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="va">No. Virtual Account</label>
              <div class="col-md-9">
                <input type="text" id="va" name="va" class="form-control" required>
              </div>
            </div>
            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="tanggaltransaksi"> Tanggal Transaksi</label>
              <div class="col-md-9">
                <input type="text" id="tanggaltransaksi" name="tanggaltransaksi" class="form-control" required>
              </div>
            </div>
            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="codeproduk"> Kode Produk</label>
              <div class="col-md-9">
                <input type="text" id="codeproduk" name="codeproduk" class="form-control" required>
              </div>
            </div> 
            <div class="mb-3 form-group row">
              <label class="col-md-3 col-form-label" for="nominal"> Nominal</label>
              <div class="col-md-9">
                <input type="text" id="nominal" name="nominal" class="form-control" required>
              </div>
            </div>
             
            <div class="text-center">
              <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="updateSystemInfo($('#system_name').val())">Simpan</button>
            </div>
          </div>
        </form>

      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div> 
</div> 

<!--------------------------------------------------------------------  --------------------------------------------------------------------->
    </div>
  </div>
</div>
<script>
function updateSystemInfo(system_name) {
  $(".systemAjaxForm").validate({});
  $(".systemAjaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}
 
function reload() {
  setTimeout(
    function()
    {
      location.reload();
    }, 1000);
}
function doNothing() {

}
  </script>
