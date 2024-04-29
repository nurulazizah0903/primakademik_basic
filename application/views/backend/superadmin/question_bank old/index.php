<!--title-->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-chart-timeline title_icon"></i> <?php echo get_phrase('question_bank'); ?>
                    <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/question_bank/create'); ?>', '<?php echo get_phrase('create_question_bank'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_question_bank'); ?></button>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-1 mb-1"></div>
                    <div class="col-md-4 mb-1">
                        <select name="subject_id" id="subject_id" class="form-control select2" data-toggle = "select2" onchange="subjectWiseBase(this.value)" required>
                            <option value=""><?php echo get_phrase('select_subject'); ?></option>
                            <?php
                            $subjects = $this->db->get_where('subjects', array('school_id' => school_id()))->result_array();
                            foreach ($subjects as $subject): ?>
                            <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-1">
                    <select name="base_id" id="base_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_knowledge_base'); ?></option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_question_bank()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="question_bank_content">
                <?php  include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>
</div>
<script>

$('document').ready(function(){
    initSelect2(['#base_id', '#subject_id']);
});

function subjectWiseBase(subjectId) {
    $.ajax({
        url: "<?php echo route('subject_wise_base/list/'); ?>"+subjectId,
        success: function(response){
            $('#base_id').html(response);
        }
    });
}

function filter_question_bank(){
    var subject_id = $('#subject_id').val();
    var base_id = $('#base_id').val();
    if(subject_id!= "" && base_id!= ""){
        showAllQuestionBank();
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields'); ?>');
    }
}

var showAllQuestionBank = function () {
    var subject_id = $('#subject_id').val();
    var base_id = $('#base_id').val();
    if(subject_id!= "" && base_id!= ""){
        $.ajax({
            url: '<?php echo route('question_bank/list/') ?>'+subject_id+'/'+base_id,
            success: function(response){
                $('.question_bank_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
}
</script>
