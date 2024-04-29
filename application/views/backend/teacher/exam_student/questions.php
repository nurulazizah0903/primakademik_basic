<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase('daftar_soal'); ?>
            <a href = "javascript:history.back()" class="btn btn-outline-secondary ml-1 btn-rounded alignToTitle"><i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('back'); ?></a>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body exam_question_content">
                <?php include 'question_list.php'; ?>
            </div>
        </div>
    </div>
</div>

<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <!-- <table>
            <tr>
                <th><?php echo get_phrase('total_questions'); ?></th>
                <th>:</th>
                <th>ini</th>
            </tr>
        </table> -->
        <h4 class="page-title">
            <a href="<?php echo site_url('addons/exam/student_exam/pending'); ?>" class="btn btn-outline-secondary ml-1 btn-rounded alignToTitle"> <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('save_drafted_exam'); ?></a>
            <a href="<?php echo site_url('addons/exam/questions/add_question/'.$exam_details['id']); ?>" class="btn btn-outline-info ml-1 btn-rounded alignToTitle">  <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_question'); ?></a>
            <!-- <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/exam_student/add_question/'.$exam_details['id']); ?>', '<?php echo get_phrase('create_question'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('create_question'); ?></button>
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/exam_student/excel_question/'.$exam_details['id']); ?>', '<?php echo get_phrase('excel_upload'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('excel_upload'); ?></button>
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/exam_student/question_bank/'.$exam_details['id'].'/'.$exam_details['subject_id']); ?>', '<?php echo get_phrase('add_from_question_bank'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_from_question_bank'); ?></button> -->
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<script>
	'use strict';
    var showExamQuestion = function () {
        var url = "<?php echo site_url('addons/exam/questions/list/'.$exam_details['id']); ?>";

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.exam_question_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
