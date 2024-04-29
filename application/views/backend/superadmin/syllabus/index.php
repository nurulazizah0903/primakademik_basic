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
                    <div class="col-md-2 mb-1"></div>
                    <div class="col-md-2 mb-1">
                        <select name="class" id="class_id" class="form-control select2" data-toggle = "select2" onchange="classWiseSection(this.value)" required>
                            <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                            <?php
                            $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
                            foreach ($classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                    <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="sectionWiseClassroomsOnCreate(this.value)">
                        <option value=""><?php echo get_phrase('select_section'); ?></option>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                    <select name="room_id" id="room_id" class="form-control select2" data-toggle = "select2" required>
                            <option value=""><?php echo get_phrase('select_class_rooms'); ?></option>
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
    initSelect2(['#class_id', '#section_id', '#room_id']);
});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}

function sectionWiseClassroomsOnCreate(sectionId) {
  $.ajax({
    url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
    success: function(response){
      $('#room_id').html(response);
    }
  });
}

function filter_syllabus(){
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var room_id = $('#room_id').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('syllabus/filter/') ?>',
        data: {class_id : class_id, section_id : section_id, room_id : room_id},
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