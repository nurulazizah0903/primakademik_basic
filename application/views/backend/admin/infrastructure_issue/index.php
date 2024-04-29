<?php $school_id = school_id(); ?>
<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon"></i> <?php echo get_phrase('infrastructure_issue_back'); ?>
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
        <div class="row mb-3">
          <div class="col-md-2 mb-1"></div>
            <div class="col-md-3 mb-1">
                  <select name="infrastructure_id" id="infrastructure_id" class="form-control select2" data-toggle = "select2" required>
                      <option value=""><?php echo get_phrase('select_infrastructure'); ?></option>
                      <?php
                      $infrastructures = $this->crud_model->get_infrastructure()->result_array();
                      foreach ($infrastructures as $infrastructure): ?>
                      <option value="<?php echo $infrastructure['id']; ?>"><?php echo $infrastructure['name']; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3 mb-1">
              <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
              
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-secondary" onclick="filter_infrastructure_list()" ><?php echo get_phrase('filter'); ?></button>
            </div>
          </div>
        <div class="table-responsive-sm infrastructure_issue_content">
          <?php include 'list.php'; ?>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->
    </div> <!-- end card -->
    
<script>

$('document').ready(function(){
    initSelect2(['#infrastructure_id']);
});

function filter_infrastructure_list(){
    var infrastructure_id = $('#infrastructure_id').val();
    var date = $('#date').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('infrastructure_issue/filter_list/') ?>',
        data: {infrastructure_id : infrastructure_id, date : date},
        success: function(response){
            $('.infrastructure_issue_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}

var showAllInfrastructureIssuesBack = function () {
  var url = '<?php echo route('infrastructure_issue/list'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.infrastructure_issue_content').html(response);
    }
  });
}
</script>
