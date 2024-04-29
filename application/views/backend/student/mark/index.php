<?php $student_data = $this->user_model->get_logged_in_student_details(); ?>
<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"> <i class="mdi mdi-format-list-numbered title_icon"></i> <?php echo get_phrase('manage_marks'); ?> </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row mt-3">
                <div class="col-md-4 mb-1"></div>
                    <div class="col-md-2 mb-1">
                        <select name="mark_type" id="mark_type" class="form-control select2" data-toggle = "select2" required>
                            <option value=""><?php echo get_phrase('select_mark'); ?></option>
                            <option value="assignments"><?php echo get_phrase('assignment_mark'); ?></option>
                            <option value="exams"><?php echo get_phrase('exam_mark'); ?></option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-1">
                        <button class="btn btn-block btn-secondary" onclick="filter_mark()" ><?php echo get_phrase('filter'); ?></button>
                    </div>
                </div>
            <div class="card-body mark_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>
$('document').ready(function(){
    initSelect2(['#mark_type']);
});


function filter_mark(){
    var mark_type = $('#mark_type').val();
    var student_id = <?= $student_data['student_id'] ?>;
    if(mark_type != "" && student_id!= ""){
        showAllMarks();
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields'); ?>');
    }
}

var showAllMarks = function () {
    var mark_type = $('#mark_type').val();
    if(mark_type != ""){
        $.ajax({
            url: '<?php echo route('mark/list/') ?>'+mark_type,
            success: function(response){
                $('.mark_content').html(response);
            }
        });
    }
}
</script>
