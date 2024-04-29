<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('list_employee'); ?>
                    <a href="<?php echo route('employee/employee_card_bulk'); ?>" target="_blank" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('employee_card_bulk'); ?></a>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end page title -->

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
        <div class="row mt-3">
            <div class="col-md-4"></div>
                <div class="col-md-3 mb-1">
                    <select name="role" id="role" class="form-control select2" data-toggle = "select2">
                        <option value=""><?php echo get_phrase('select_role'); ?></option>
                        <option value="teacher"><?php echo get_phrase('teacher'); ?></option>
                        <option value="librarian"><?php echo get_phrase('librarian'); ?></option>
                        <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                        <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_role()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="card-body">
                <div class = "employee_content">
                    <?php include 'list.php'; ?>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script>
function filter_role(){
    var role = $('#role').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('employee/filter/') ?>',
        data: {role : role},
        success: function(response){
            $('.employee_content').html(response);
        }
    });
}

var showAllEmployee = function () {
    var url = '<?php echo route('employee/list'); ?>';

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            $('.employee_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}
</script>
