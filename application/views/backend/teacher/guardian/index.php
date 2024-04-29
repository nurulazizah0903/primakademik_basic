<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-account-circle title_icon"></i> <?php echo get_phrase('guardian'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/guardian/create'); ?>', '<?php echo get_phrase('create_guardian'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_guardian'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body guardian_content">
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>


<script>
var showAllGuardians = function () {
  var url = '<?php echo route('guardian/list'); ?>';

  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.guardian_content').html(response);
      initDataTable('basic-datatable');
    }
  });
}
</script>
