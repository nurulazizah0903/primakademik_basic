<?php $student_data = $this->user_model->get_logged_in_student_details(); ?>
<!--title-->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"><i class="mdi mdi-chart-timeline title_icon"></i> <?php echo get_phrase('materials'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-2 mb-1"></div>
                <div class="col-md-4 mb-1">
                    <select name="subject" id="subject_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_subject'); ?></option>
                        <?php $school_id = school_id();
                        $subjects = $this->db->get_where('subjects', array('school_id' => $school_id,'class_id' => $student_data['class_id'],'section_id' => $student_data['section_id'], 'session' => active_session()))->result_array();
                        foreach($subjects as $subject){ ?>
                            <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-block btn-secondary" onclick="filter_materials()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="materials_content">
                <?php  include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>
</div>
<script>
function filter_materials(){
    var class_id = <?= $student_data['class_id'] ?>;
    var section_id = <?= $student_data['section_id'] ?>;
    var subject_id = $('#subject_id').val();
    if(class_id != "" && section_id!= "" && subject_id!= ""){
        showAllMaterials();
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields'); ?>');
    }
}

var showAllMaterials = function () {
    var class_id = <?= $student_data['class_id'] ?>;
    var section_id = <?= $student_data['section_id'] ?>;
    var subject_id = $('#subject_id').val();
    if(class_id != "" && section_id!= "" && subject_id!= ""){
        $.ajax({
            url: '<?php echo route('materials/list/') ?>'+class_id+'/'+section_id+'/'+subject_id,
            success: function(response){
                $('.materials_content').html(response);
            }
        });
    }
}
</script>
