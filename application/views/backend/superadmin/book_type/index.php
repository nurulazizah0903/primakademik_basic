<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase('book_type'); ?>
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/book_type/create'); ?>', '<?php echo get_phrase('create_book_type'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_book_type'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body book_type_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllBookTypes = function () {
        var url = '<?php echo route('book_types/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.book_type_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
