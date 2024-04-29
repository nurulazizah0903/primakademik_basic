<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-content-paste title_icon"></i> <?php echo get_phrase('operational_hour'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/operational_hour/create'); ?>', '<?php echo get_phrase('create_operational_hour'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_operational_hour'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body operational_hour_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllOperationalHour = function () {
        var url = '<?php echo route('operational_hour/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.operational_hour_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
