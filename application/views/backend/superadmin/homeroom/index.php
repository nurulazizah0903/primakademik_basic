<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-account-multiple-check title_icon"></i> <?php echo get_phrase('homeroom'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body homeroom_content">
                <?php include 'list.php'; ?>    
            </div>
        </div>
    </div>
</div>

<!-- modyfy section -->
<script>
    var showAllHomerooms = function () {
        var url = '<?php echo route('homeroom/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.homeroom_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>