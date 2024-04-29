<?php $school_id = school_id(); ?>
<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon"></i> <?php echo get_phrase('infrastructure_issue'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/infrastructure_issue/create'); ?>', '<?php echo get_phrase('issue_infrastructure'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('issue_infrastructure'); ?></button>
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
        
        <!-- <h4 class="header-title mt-3"><?php echo get_phrase('issues_mean_list'); ?></h4>
        <div class="row justify-content-md-center" style="margin-bottom: 10px;">
          <div class="col-xl-5 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <div class="form-group">
              <div id="reportrange" class="form-control" data-toggle="date-picker-range" data-target-display="#selectedValue"  data-cancel-class="btn-light">
                <i class="mdi mdi-calendar"></i>&nbsp;
                <span id="selectedValue"> <?php echo date('F d, Y', strtotime(' -30 day')).' - '.date('F d, Y'); ?> </span>
              </div>
            </div>
          </div>
          <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <button type="button" class="btn btn-icon btn-secondary form-control" onclick="showAllMeanIssues()"><?php echo get_phrase('filter'); ?></button>
          </div>
        </div> -->

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
