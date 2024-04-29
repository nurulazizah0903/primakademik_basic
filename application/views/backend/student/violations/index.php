<!--title-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="page-title">
                        <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('violations'); ?>
                    </h4>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body violations_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllViolations = function () {
        var url = '<?php echo route('violations/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.violations_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>