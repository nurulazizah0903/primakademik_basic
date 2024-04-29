<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon"></i> <?php echo get_phrase('infrastructure_issue_deadline'); ?>
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
        <div class="table-responsive-sm infrastructure_deadline_content">
          <?php include 'list_deadline.php'; ?>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->
    </div> <!-- end card -->

<script>
var showAllInfrastructureDeadline = function () {
  var url = '<?php echo route('infrastructure_issue/list_deadline'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.infrastructure_deadline_content').html(response);
      initDataTable('basic-datatable');
    }
  });
}
</script>
