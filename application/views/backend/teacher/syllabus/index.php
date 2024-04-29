<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
?>
<!--title-->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-chart-timeline title_icon"></i> <?php echo get_phrase('syllabus'); ?>
                    <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/syllabus/create'); ?>', '<?php echo get_phrase('create_syllabus'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_syllabus'); ?></button>
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
                    <div class="col-md-3 mb-1"></div>
                    <div class="col-md-4 mb-1">
                        <select name="class" id="subject_id" class="form-control select2" data-toggle = "select2" required>
                            <option value=""><?php echo get_phrase('select_a_subject'); ?></option>
                            <?php
                            $subjects = $this->db->get_where('subjects', array('school_id' => school_id(), 'teacher_id' => $teacher_id))->result_array();
                            foreach($subjects as $subject){
                                $class_details = $this->crud_model->get_class_details_by_id($subject['class_id'])->row_array();
                                $section_details = $this->crud_model->get_section_details_by_id('section', $subject['section_id'])->row_array();
                            ?>
                                <option value="<?php echo $subject['id']; ?>">(<?php echo $class_details['name']; ?> - <?php echo $section_details['name']; ?>)  <?php echo $subject['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_syllabus()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="syllabus_content">
                <?php  include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>
</div>
<script>

$('document').ready(function(){
    initSelect2(['#subject_id']);
});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}

function filter_syllabus(){
    var subject_id = $('#subject_id').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('syllabus/filter/') ?>',
        data: {subject_id : subject_id},
        success: function(response){
            $('.syllabus_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}

var showAllSyllabuses = function () {
        $.ajax({
            url: '<?php echo route('syllabus/list/') ?>',
            success: function(response){
                $('.syllabus_content').html(response);
                initDataTable('basic-datatable');
            }
        });
}
</script>
