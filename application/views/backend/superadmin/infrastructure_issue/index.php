<?php $school_id = school_id(); ?>
<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon"></i> <?php echo get_phrase('infrastructure_issue'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/infrastructure_issue/create'); ?>', '<?php echo get_phrase('issue_infrastructure'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('issue_infrastructure'); ?></button>
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

        <div class="table-responsive-sm infrastructure_issue_content">
          <?php include 'list.php'; ?>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->
    </div> <!-- end card -->
    
<script>
var showAllInfrastructureIssues = function () {
  var url = '<?php echo route('infrastructure_issue/list'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    data : {date : $('#selectedValue').text()},
    success : function(response) {
      $('.infrastructure_issue_content').html(response);
    }
  });
}
</script>