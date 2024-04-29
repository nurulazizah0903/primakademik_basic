<?php if($working_page == 'filter'): ?>
    <!--title-->
    <div class="row d-print-none">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="page-title">
                        <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('student'); ?>
                        <!-- <a href="<?php echo route('student/create'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_new_student'); ?></a>
                        <a href="<?php echo route('student/move'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-account-switch"></i> <?php echo get_phrase('move_student'); ?></a> -->
                    </h4>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row d-print-none">
        <div class="col-12">
            <div class="card ">
                <div class="container">
                    <div class="row mt-3">
                        <div class="col-md-4 mb-1">
                            <input type="text" name="keyword" class="form-control keyword" id="keyword" placeholder="Masukkan keyword">    
                        </div>
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
                            <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="sectionWiseClassroomsOnCreate(this.value)">
                                <option value=""><?php echo get_phrase('select_section'); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-1">
                            <select name="room" id="room_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_class_room'); ?></option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-block btn-secondary" onclick="filter_student()" ><?php echo get_phrase('filter'); ?></button>
                        </div>
                    </div>
                </div>
                <div class="card-body student_content">
                    <div class="empty_box">
                        <img class="mb-3" width="150px" src="<?php echo base_url('assets/backend/images/empty_box.png'); ?>" />
                        <br>
                        <span class=""><?php echo get_phrase('no_data_found'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif($working_page == 'create'): ?>
    <?php include 'create.php'; ?>
<?php elseif($working_page == 'edit'): ?>
    <?php include 'update.php'; ?>
    <?php elseif($working_page == 'manage_student'): ?>
    <?php include 'manage_student.php'; ?>
<?php endif; ?>

<script>
    'use strict';
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

function sectionWiseClassroomsOnCreate(sectionId) {
    $.ajax({
        url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
        success: function(response){
        $('#room_id').html(response);
        }
    });
}

// function filter_student(){
//     var class_id = $('#class_id').val();
//     var section_id = $('#section_id').val();
//     if(class_id != "" && section_id!= ""){
//         showAllStudents();
//     }else{
//         toastr.error('<?php echo get_phrase('please_select_a_class_and_section'); ?>');
//     }
// }

// var showAllStudents = function() {
//     var class_id = $('#class_id').val();
//     var section_id = $('#section_id').val();
//     if(class_id != "" && section_id!= ""){
//         $.ajax({
//             url: '<?php echo route('student/filter/') ?>'+class_id+'/'+section_id,
//             success: function(response){
//                 $('.student_content').html(response);
//             }
//         });
//     }
// }

function filter_student(){
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var room_id = $('#room_id').val();
    var keyword = $('#keyword').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('student/filter/') ?>',
        data: {class_id : class_id, section_id : section_id, room_id : room_id, keyword : keyword},
        success: function(response){
            $('.student_content').html(response);
        }
    });
}

var showAllStudents = function() {
        $.ajax({
            url: '<?php echo route('student/list/') ?>',
            success: function(response){
                $('.student_content').html(response);
            }
        });
}
</script>
