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
            <div class="col-md-3 "></div>
                <div class="col-md-4 mb-1">
                    <select name="subject_id" id="subject_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_subject'); ?></option>
                        <?php
                        $subjects = $this->db->get_where('subjects', array('school_id' => $school_id))->result_array();?>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
                        <?php endforeach; ?>
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
function filter_base(){
    var subject_id = $('#subject_id').val();
    if(subject_id != ""){
      showAllKnowledgeBase();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_subject'); ?>');
    }
}

var showAllKnowledgeBase = function () {
  var subject_id = $('#subject_id').val();
    if(subject_id != ""){
        $.ajax({
            url: '<?php echo route('knowledge_base/list/') ?>'+subject_id,
            success: function(response){
                $('.knowledge_base_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
}
</script>
