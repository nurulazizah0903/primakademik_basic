<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon title_icon"></i> <?php echo get_phrase('postcode'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/postcode/create'); ?>', '<?php echo get_phrase('create_postcode'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_postcode'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body postcode_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllPostcodes = function () {
        var url = '<?php echo route('postcode/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.postcode_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>