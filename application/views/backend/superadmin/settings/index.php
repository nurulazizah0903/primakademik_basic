<?php
if($settings_type == 'system_settings')
$class = 'col-xl-12';
else if($settings_type == 'payment_settings')
$class = 'col-xl-10 offset-xl-1';
else if($settings_type == 'language_settings')
$class = 'col-xl-10 offset-xl-1';
else if($settings_type == 'sms_settings')
$class = 'col-xl-10 offset-xl-1';
else if($settings_type == 'smtp_settings')
$class = 'col-xl-10 offset-xl-1';
else if($settings_type == 'school_settings')
$class = 'col-xl-10 offset-xl-1';
else if($settings_type == 'sms_settings')
$class = 'col-xl-10 offset-xl-1';
?>

<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-settings title_icon"></i><?php echo ucfirst(get_phrase($settings_type)); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->
<div class="row">
  <div class="<?php echo $class; ?>">
    <div class="settings_content">
      <?php include $settings_type.'.php'; ?>
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

// permission insert and update 
function togglePermission(checkbox_id, column_name, menu_id){

var value = $('#'+checkbox_id).val();
if(value == 1){
    value = 0;
}else{
    value = 1;
}

$.ajax({
    type: 'POST',
    url: '<?php echo route('menu_settings/modify_menu_settings/') ?>',
    data: {menu_id : menu_id, column_name : column_name,  value : value},
    success: function(response){
        location.reload();
        toastr.success('<?php echo get_phrase('menu_settings_updated_successfully.'); ?>');
    }
});

}

function updateSystemLogo() {
  $(".systemLogoAjaxForm").validate({});
  $(".systemLogoAjaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updateSystemApk() {
  $(".systemApkAjaxForm").validate({});
  $(".systemApkAjaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}


function updateSystemCurrencyInfo() {
  $(".systemAjaxForm").validate({});
  $(".systemAjaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updatePaypalInfo() {
  $(".paypalAjaxForm").validate({});
  $(".paypalAjaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updateStripeInfo() {
  $(".stripeAjaxForm").validate({});
  $(".stripeAjaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updateSmsInfo() {
  $(".smsForm").validate({});
  $(".smsForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updateSmtpInfo() {
  $(".smtpForm").validate({});
  $(".smtpForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, reload);
  });
}

function updateSchoolInfo() {
  $(".schoolForm").validate({});
  $(".schoolForm").submit(function(e) {
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
