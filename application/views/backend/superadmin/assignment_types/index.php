<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon title_icon"></i> <?php echo get_phrase('assignment_types'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/assignment_types/create'); ?>', '<?php echo get_phrase('create_assignment_types'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_assignment_types'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body assignment_types_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllAssigmentTypes = function () {
        var url = '<?php echo route('assignment_types/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.assignment_types_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
