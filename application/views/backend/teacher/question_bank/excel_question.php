<?php $teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id']; ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('question_bank/excel_question/'); ?>" enctype="multipart/form-data">
<input type="hidden" name="teacher_id" value="<?= $teacher_id ?>">
    <div class="row justify-content-md-center">
        <div class="col-md-8 mt-4">
            <div class="row">
                <div class="col-12">
                    <a href="<?php echo base_url('assets/csv_file/new_template/Tempalte Gudang Soal.csv'); ?>" class="btn btn-success btn-sm mb-1" download><?php echo get_phrase('generate_csv_file'); ?><i class="mdi mdi-download"></i></a>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label class="m-0"><?php echo get_phrase('upload').'CSV'; ?></label>
                <div class="custom-file-upload">
                    <input type="file" id="csv_file" class="form-control" name="csv_file" required>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-secondary col-md-12 col-sm-12 mb-4 mt-3"><?php echo get_phrase('add_question'); ?></button>
    </div>
</form>

<script>
$(document).ready(function(){
    initCustomFileUploader();
});

var form;
$(".ajaxForm").submit(function(e) {
  form = $(this);
  ajaxSubmit(e, form, refreshForm);
});
var refreshForm = function () {
    form.trigger("reset");
}
</script>