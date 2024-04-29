<!--title-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="page-title">
                        <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('student_extracurricular'); ?>
                        <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/student_extracurricular/create'); ?>', '<?php echo get_phrase('add_student_extracurricular'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_student_extracurricular'); ?></button>
                    </h4>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="row mt-3">
                    <div class="col-md-1 mb-1"></div>
                    <div class="col-md-4 mb-1">
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
                    <div class="col-md-4 mb-1">
                        <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required>
                            <option value=""><?php echo get_phrase('select_section'); ?></option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-block btn-secondary" onclick="filter_student()" ><?php echo get_phrase('filter'); ?></button>
                    </div>
                </div>
                <div class="card-body student_content">
                    <?php include 'list.php'; ?>
                </div>
            </div>
        </div>
    </div>

<script>
$('document').ready(function(){

});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}

function filter_student(){
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    if(class_id != "" && section_id!= ""){
        showAllStudentsextracurricular();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_class_and_section'); ?>');
    }
}

var showAllStudentsextracurricular = function() {
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    if(class_id != "" && section_id!= ""){
        $.ajax({
            url: '<?php echo route('student_extracurricular/filter/') ?>'+class_id+'/'+section_id,
            success: function(response){
                $('.student_content').html(response);
                initDataTable("basic-datatable");
            }
        });
    }
}
</script>
