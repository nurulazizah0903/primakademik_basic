<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-content-paste title_icon"></i> <?php echo get_phrase('registration_path'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/registration_path/create'); ?>', '<?php echo get_phrase('create_registration_path'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_registration_path'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body registration_path_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllRegistrationPath = function () {
        var url = '<?php echo route('registration_path/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.registration_path_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
