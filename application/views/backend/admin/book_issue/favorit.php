<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon"></i> <?php echo get_phrase('favorit_book_list'); ?>
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
        <div class="table-responsive-sm book_issue_content">
          <?php include 'list_favorit.php'; ?>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->
    </div> <!-- end card -->

<script>
var showAllBookFavorit = function () {
  var url = '<?php echo route('book_issue/list_favorit'); ?>';
  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.book_favorit_content').html(response);
      initDataTable('basic-datatable');
    }
  });
}
</script>
