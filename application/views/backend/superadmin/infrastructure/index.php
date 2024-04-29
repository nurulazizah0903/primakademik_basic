<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('infrastructure'); ?>
                    <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/infrastructure/create'); ?>', '<?php echo get_phrase('add_infrastructure'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_infrastructure'); ?></button>
                    <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/infrastructure/excel_infrastructure'); ?>', '<?php echo get_phrase('excel_upload'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('excel_upload'); ?></button>
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
                <div class="row mb-3">
                    <div class="col-md-3 mb-1"></div>
                        <div class="col-md-4 mb-1">
                            <select name="location_id" id="location_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_location'); ?></option>
                                <?php
                                $locations = $this->crud_model->get_locations()->result_array();
                                foreach ($locations as $location): ?>
                                    <option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-block btn-secondary" onclick="filter_infrastructure_list()" ><?php echo get_phrase('filter'); ?></button>
                        </div>
                </div>
                <div class = "infrastructure_content">
                    <?php include 'list.php'; ?>
                </div> <!-- end table-responsive-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>


<script>
$('document').ready(function(){
    initSelect2(['#location_id']);
});

function filter_infrastructure_list(){
    var location_id = $('#location_id').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('infrastructure/filter_list/') ?>',
        data: {location_id : location_id},
        success: function(response){
            $('.infrastructure_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}

var showAllInfrastructure = function () {
    var url = '<?php echo route('infrastructure/list'); ?>';

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            $('.infrastructure_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}
</script>
