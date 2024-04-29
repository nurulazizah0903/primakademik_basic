<!--title-->
<div class="row ">
  <div class="col-xl-12 d-print-none">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-card-bulleted-settings-outline title_icon"></i> <?php echo get_phrase('internship'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/internship/create'); ?>', '<?php echo get_phrase('create_internship'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_internship'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body internship_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>

var showAllInternship = function () {
    var url = '<?php echo route('internship/list'); ?>';

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            console.log(response);
            $('.internship_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}
</script>
