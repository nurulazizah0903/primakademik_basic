<?php $school_id = school_id(); ?>
<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon"></i> <?php echo get_phrase('mean_issue_back'); ?>
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
          <div class="col-md-1 mb-1"></div>
            <div class="col-md-3 mb-1">
                  <select name="mean_id" id="mean_id" class="form-control select2" data-toggle = "select2" required>
                      <option value=""><?php echo get_phrase('select_mean'); ?></option>
                      <?php
                      $means = $this->crud_model->get_means()->result_array();
                      foreach ($means as $mean): ?>
                      <option value="<?php echo $mean['id']; ?>"><?php echo $mean['name']; ?></option>
                  <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-2 mb-1">
                  <select name="tgl" id="tgl" class="form-control select2" data-toggle = "select2" required>
                      <option value="issue_date"><?php echo get_phrase('issue_date'); ?></option>
                      <option value="return_date"><?php echo get_phrase('return_date'); ?></option>
              </select>
            </div>
            <div class="col-md-3 mb-1">
              <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
            </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-secondary" onclick="filter_mean_list()" ><?php echo get_phrase('filter'); ?></button>
            </div>
          </div>
        <div class="table-responsive-sm mean_issue_content">
          <?php include 'list.php'; ?>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->
    </div> <!-- end card -->
    
<script>

$('document').ready(function(){
    initSelect2(['#mean_id', '#tgl']);
});

function filter_mean_list(){
    var mean_id = $('#mean_id').val();
    var date = $('#date').val();
    var tgl = $('#tgl').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('mean_issue/filter_list/') ?>',
        data: {mean_id : mean_id, date : date, tgl : tgl},
        success: function(response){
            $('.mean_issue_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}

var showAllMeanIssuesBack = function () {
  var url = '<?php echo route('mean_issue/list'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    data : {date : $('#selectedValue').text()},
    success : function(response) {
      $('.mean_issue_content').html(response);
      initDataTable('basic-datatable');
    }
  });
}
</script>
