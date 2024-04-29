<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-content-paste title_icon"></i> <?php echo get_phrase('employee_status'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/employee_status/create'); ?>', '<?php echo get_phrase('create_employee_status'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_employee_status'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body employee_status_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllEmployeeStatus = function () {
        var url = '<?php echo route('employee_status/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.employee_status_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
