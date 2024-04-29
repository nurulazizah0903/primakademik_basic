<!--title-->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-chart-timeline title_icon"></i> <?php echo get_phrase('question_bank'); ?>
                    <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/question_bank/create'); ?>', '<?php echo get_phrase('create_question_bank'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_question_bank'); ?></button>
                    <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/question_bank/excel_question'); ?>', '<?php echo get_phrase('excel_upload'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('excel_upload'); ?></button>
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
                    <div class="col-md-2 mb-1">
                      <select name="class" id="class_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
                          <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                          <?php
                          $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
                          foreach($classes as $class){
                              ?>
                              <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                          <?php } ?>
                      </select>
                  </div>
                  <div class="col-md-2 mb-1">
                      <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSubject(this.value)">
                          <option value=""><?php echo get_phrase('select_section'); ?></option>
                      </select>
                  </div>
                  <div class="col-md-2 mb-1">
                    <select name="subject_id" id="subject_id" class="form-control select2" data-toggle = "select2" required onchange="subjectWiseBase(this.value)">
                        <option value=""><?php echo get_phrase('select_subject'); ?></option>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
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
    initSelect2(['#base_id', '#subject_id','#class_id', '#section_id']);
});

function filter_base(){
    var subject_id = $('#subject_id').val();
    if(subject_id != ""){
      showAllKnowledgeBase();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_subject'); ?>');
    }
}

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
            classWiseSubject(classId);
        }
    });
}

function classWiseSubject(classId) {
    $.ajax({
        url: "<?php echo route('class_wise_subject/'); ?>"+classId,
        success: function(response){
            $('#subject_id').html(response);
        }
    });
}

function subjectWiseBase(subjectId) {
    $.ajax({
        url: "<?php echo route('subject_wise_base/list/'); ?>"+subjectId,
        success: function(response){
            $('#base_id').html(response);
        }
    });
}

// function filter_question_bank(){
//     var class_id = $('#class_id').val();
//     var section_id = $('#section_id').val();
//     var subject_id = $('#subject_id').val();
//     var base_id = $('#base_id').val();
//     if(subject_id!= "" && base_id!= "" && section_id!= "" && class_id!= ""){
//         showAllQuestionBank();
//     }else{
//         toastr.error('<?php echo get_phrase('please_select_in_all_fields'); ?>');
//     }
// }

// var showAllQuestionBank = function () {
//     var class_id = $('#class_id').val();
//     var section_id = $('#section_id').val();
//     var subject_id = $('#subject_id').val();
//     var base_id = $('#base_id').val();
//     if(subject_id!= "" && base_id!= "" && section_id!= "" && class_id!= ""){
//         $.ajax({
//             url: '<?php echo route('question_bank/list/') ?>'+subject_id+'/'+base_id+'/'+class_id+'/'+section_id,
//             success: function(response){
//                 $('.question_bank_content').html(response);
//                 initDataTable('basic-datatable');
//             }
//         });
//     }
// }

function filter_question_bank(){
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject_id = $('#subject_id').val();
    var base_id = $('#base_id').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('question_bank/filter/') ?>',
        data: {class_id : class_id, section_id : section_id, subject_id : subject_id, base_id : base_id},
        success: function(response){
            $('.question_bank_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}

var showAllQuestionBank = function () {
        $.ajax({
            url: '<?php echo route('question_bank/list/') ?>',
            success: function(response){
                $('.question_bank_content').html(response);
                initDataTable('basic-datatable');
            }
        });
}
</script>
