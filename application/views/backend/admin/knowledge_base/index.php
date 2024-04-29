<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-library title_icon title_icon"></i> <?php echo get_phrase('knowledge_base'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/knowledge_base/create'); ?>', '<?php echo get_phrase('create_knowledge_base'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_knowledge_base'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
        <div class="row mt-3">
            <div class="col-md-2"></div>
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
                    <select name="subject_id" id="subject_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_subject'); ?></option>
                    </select>
                </div>
            <div class="col-md-2">
                <button class="btn btn-block btn-secondary" onclick="filter_base()" ><?php echo get_phrase('filter'); ?></button>
            </div>
          </div>
            <div class="card-body knowledge_base_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<script>

$(document).ready(function () {

initSelect2(['#subject_id', '#class_id', '#section_id']);

});
function filter_base(){
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject_id = $('#subject_id').val();
    if(subject_id != "" && class_id!= "" && section_id!= ""){
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

var showAllKnowledgeBase = function () {
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var subject_id = $('#subject_id').val();
    if(subject_id != "" && class_id!= "" && section_id!= ""){
        $.ajax({
            url: '<?php echo route('knowledge_base/list/') ?>'+subject_id+'/'+class_id+'/'+section_id,
            success: function(response){
                $('.knowledge_base_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
}
</script>
