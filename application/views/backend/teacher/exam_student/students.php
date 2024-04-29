<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo $exam_details['title']; ?>
            <a href="<?php echo site_url('addons/exam/student_exam/expired'); ?>" class="btn btn-outline-secondary ml-1 btn-rounded alignToTitle"> <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('expired'); ?></a>
            <a href="<?php echo site_url('addons/exam/student_exam/pending'); ?>" class="btn btn-outline-danger ml-1 btn-rounded alignToTitle"> <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('drafted'); ?></a>
            <a href="<?php echo site_url('addons/exam/student_exam/published'); ?>" class="btn btn-outline-success ml-1 btn-rounded alignToTitle"> <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('published'); ?></a>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body exam_result_content">
                <?php include 'student_list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
	'use strict';
    var showExamQuestion = function () {
        var url = "<?php echo site_url('addons/exam/results/list/'.$exam_details['id']); ?>";

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.exam_result_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
