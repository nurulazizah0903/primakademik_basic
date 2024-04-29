<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-account-circle title_icon"></i> <?php echo get_phrase('employee_mutation'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/employee_mutation/create'); ?>', '<?php echo get_phrase('create_employee_mutation'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('create_employee_mutation'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body employee_mutation_content">
        <?php include 'list.php'; ?>
      </div>
    </div>
  </div>
</div>

<script>
var showAllEmployeeMutation = function () {
  var url = '<?php echo route('employee_mutation/list'); ?>';

  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.employee_mutation_content').html(response);
      initDataTable('basic-datatable');
    }
  });
}
</script>
