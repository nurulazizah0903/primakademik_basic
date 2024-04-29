<!--title-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="page-title">
                        <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('achievements'); ?>
                        <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/achievements/create'); ?>', '<?php echo get_phrase('add_achievements'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_achievements'); ?></button>
                    </h4>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body achievements_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
    var showAllAchievements = function () {
        var url = '<?php echo route('achievements/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.achievements_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>