<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon title_icon"></i> <?php echo get_phrase('master_payment_type'); ?>          
          <button type="button" class="btn btn-outline-danger btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/payment_type/create'); ?>', '<?php echo get_phrase('add_invoice_types'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_invoice_types'); ?></button>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" style="margin-right: 10px;" onclick="largeModal('<?php echo site_url('modal/popup/payment_type/create_mass'); ?>', '<?php echo get_phrase('add_mass_invoice_types'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_mass_invoice_types'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body payment_type_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllPaymentType = function () {
        var url = '<?php echo route('payment_type/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.payment_type_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
