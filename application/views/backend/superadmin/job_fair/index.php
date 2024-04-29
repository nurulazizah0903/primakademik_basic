<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-grease-pencil title_icon"></i> <?php echo get_phrase('job_fair'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/job_fair/create'); ?>', '<?php echo get_phrase('create_job_fair'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_job_fair'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body job_fair_content">
              <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllJobfairs = function () {
        var url = '<?php echo route('job_fair/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.job_fair_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
