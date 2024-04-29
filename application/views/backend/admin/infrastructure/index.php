<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('infrastructure'); ?>
                    <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/infrastructure/create'); ?>', '<?php echo get_phrase('add_infrastructure'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_infrastructure'); ?></button>
                    <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/infrastructure/excel_infrastructure'); ?>', '<?php echo get_phrase('excel_upload'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('excel_upload'); ?></button>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end page title -->

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class = "infrastructure_content">
                    <?php include 'list.php'; ?>
                </div> <!-- end table-responsive-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>


<script>
var showAllInfrastructure = function () {
    var url = '<?php echo route('infrastructure/list'); ?>';

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            $('.infrastructure_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}
</script>
