<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon"></i> <?php echo get_phrase('books_issue'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/book_issue/create'); ?>', '<?php echo get_phrase('issue_book'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('issue_book'); ?></button>
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
        <!-- <div class="row mt-3 d-print-none">
          <div class="col-md-2 mb-1"></div>
            <div class="col-md-5 mb-1">
              <div id="reportrange" class="form-control" data-toggle="date-picker-range" data-target-display="#selectedValue"  data-cancel-class="btn-light">
                <i class="mdi mdi-calendar"></i>&nbsp;
                <span id="selectedValue"> <?php echo date('F d, Y', strtotime(' -30 day')).' - '.date('F d, Y'); ?> </span>
              </div>
            </div>
            <div class="col-md-2 mb-1">
              <button type="button" class="btn btn-icon btn-secondary form-control" onclick="showAllBookIssues()"><?php echo get_phrase('filter'); ?></button>
            </div>
        </div><br> -->

        <div class="table-responsive-sm book_issue_content">
          <?php include 'list.php'; ?>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->
    </div> <!-- end card -->
    
    <!-- <div class="card">
      <div class="card-body">
        <h4 class="header-title mt-3"><?php echo get_phrase('favorit_book_list'); ?></h4>
        <div class="table-responsive-sm book_favorit_content">
          <?php include 'list_favorit.php'; ?>
        </div>
      </div> 
    </div> 
  </div>
</div> -->

<script>
var showAllBookIssues = function () {
  var url = '<?php echo route('book_issue/list'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    data : {date : $('#selectedValue').text()},
    success : function(response) {
      $('.book_issue_content').html(response);
    }
  });
}

var showAllBookFavorit = function () {
  var url = '<?php echo route('book_issue/list_favorit'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    data : {date : $('#selectedValue').text()},
    success : function(response) {
      $('.book_favorit_content').html(response);
    }
  });
}
</script>