<!--title-->
<div class="row ">
  <div class="col-xl-12 d-print-none">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
			<i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('industry_company'); ?>
			<button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/industry_company/create'); ?>', '<?php echo get_phrase('create_industry_company'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_industry_company'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body industry_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
var showAllIndustry = function () {
    var url = '<?php echo route('industry_company/list'); ?>';

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            console.log(response);
            $('.industry_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}
</script>
