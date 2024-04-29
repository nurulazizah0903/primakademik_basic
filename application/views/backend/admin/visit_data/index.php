<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon"></i> <?php echo get_phrase('visit_data'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/visit_data/create'); ?>', '<?php echo get_phrase('visit_data'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('visit_data'); ?></button>
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
        <div class="table-responsive-sm visit_data_content">
          <?php include 'list.php'; ?>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<script>
var showAllVisitData = function () {
  var url = '<?php echo route('visit_data/list'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.visit_data_content').html(response);
      initDataTable("basic-datatable");
    }
  });
}
</script>
