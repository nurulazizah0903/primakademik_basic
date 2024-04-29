<?php $student_lists = $this->user_model->get_student_list_of_logged_in_parent(); ?>
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
                <div class="col-md-3 mb-1"></div>
                <div class="col-md-2 mb-1">
                    <select name="student_id" id="student_id" name="student_id" class="form-control select2" data-toggle="select2" required onchange="studentWiseClassId(this.value)">
                        <option value=""><?php echo get_phrase('select_a_student'); ?></option>
                        <?php foreach ($student_lists as $student_list): ?>
                            <option value="<?php echo $student_list['id']; ?>"><?php echo $student_list['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                        <select name="mark_type" id="mark_type" class="form-control select2" data-toggle = "select2" required>
                            <option value=""><?php echo get_phrase('select_mark'); ?></option>
                            <option value="assignments"><?php echo get_phrase('assignment_mark'); ?></option>
                            <option value="exams"><?php echo get_phrase('exam_mark'); ?></option>
                        </select>
                    </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_attendance()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="card-body mark_content">
                <div class="empty_box">
                    <img class="mb-3" width="150px" src="<?php echo base_url('assets/backend/images/empty_box.png'); ?>" />
                    <br>
                    <span class=""><?php echo get_phrase('no_data_found'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('document').ready(function(){
    initSelect2(['#student_id']);
});
function studentWiseClassId(student_id) {
    if (student_id > 0) {
        $.ajax({
            url: "<?php echo route('get_student_details_by_id/class_id/'); ?>"+student_id,
            success: function(response){
                $('#class_id').val(response);
                studentWiseSectionId(student_id);
                // classWiseSubject(response);
            }
        });
    }else{
        $('#class_id').val("");
        $('#section_id').val("");
    }
}


function filter_attendance(){
    var student_id = $('#student_id').val();
    var mark_type = $('#mark_type').val();
    if(mark_type != "" && student_id != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('mark/list') ?>',
            data: {student_id : student_id, mark_type : mark_type},
            success: function(response){
                $('.mark_content').html(response);
            }
        });
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
    }
}
</script>
