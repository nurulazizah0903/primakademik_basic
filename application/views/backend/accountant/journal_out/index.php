<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('Jurnal Keluar'); ?>
          <?php /*<button type="button" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('Cetak Ke Excel'); ?></button> */ ?>
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
        <div class="row justify-content-md-center" style="margin-bottom: 10px;">

          <div class="col-xl-5 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <div class="form-group">
              <div id="reportrange" class="form-control" data-toggle="date-picker-range" data-target-display="#selectedValue"  data-cancel-class="btn-light">
                <i class="mdi mdi-calendar"></i>&nbsp;
                <span id="selectedValue"> <?php echo date('F d, Y', $date_from).' - '.date('F d, Y', $date_to); ?> </span>
              </div>
            </div>
          </div>     

          <div class="col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <button type="button" class="btn btn-icon btn-secondary form-control" onclick="showAlljournal_out()"><?php echo get_phrase('filter'); ?></button>
          </div>

        </div>
        <div class="journal_out_content">
          <?php include 'list.php'; ?>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->

    </div> <!-- end card -->
  </div><!-- end col-->
</div>


<script>
$(document).ready(function() {
  initSelect2(['#expense_category_id']);
});
var showAlljournal_out= function () {
  var url = '<?php echo route('journal_out/list'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    data : {date : $('#selectedValue').text()},
    success : function(response) {
      $('.journal_out_content').html(response);
      initDataTable("basic-datatable");
    }
  });
}
</script>
