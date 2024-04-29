<<<<<<< HEAD
=======

>>>>>>> c29b7342027e46f29cd8549192695ff29b91f0c5
<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"> <i class="mdi mdi-file-document-box title_icon"></i> <?php echo get_phrase('student_bill'); ?></h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body invoice_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
$var = showAllInvoices = function () {
    var url = '<?php echo route('invoice/list'); ?>';
    $.ajax({
        type : 'GET',
        url: url,
        data : {date : $('#selectedValue').text()},
        success : function(response) {
            $('.invoice_content').html(response);
            initDataTable("basic-datatable");
        }
    });
}
</script>