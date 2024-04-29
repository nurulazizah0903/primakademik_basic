<!--title-->
<div class="row ">
  <div class="col-xl-12 d-print-none">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase('manage_alumni'); ?>
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/alumni/create'); ?>', '<?php echo get_phrase('add_new_alumni'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_new_alumni'); ?></button>
            
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/alumni/create_job_fair'); ?>', '<?php echo get_phrase('add_exclusive_job_fair'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_exclusive_job_fair'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12 d-print-none">
        <div class="card">
            <div class="card-body alumni_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllAlumni = function () {
        var url = '<?php echo site_url('addons/alumni/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.alumni_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
    var redirectToDashboard = function () {
        var url = '<?php echo route('dashboard'); ?>';
        window.location.replace(url);
    }
</script>
