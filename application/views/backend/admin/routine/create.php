<div class="row">
    <div class="col-12">
        <div class="card pt-0">
        <div class="card-body">
            <h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('create_routine'); ?></h4>
                <form method="POST" class="d-block ajaxForm" action="<?php echo route('routine/add'); ?>" style="min-width: 300px;">
                    <?php $school_id = school_id(); ?>
                    <div class="form-group row">
                        <label for="class_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('class'); ?></label>
                        <div class="col-md-9">
                            <select name="class_id" id="class_id_on_routine_creation" class="form-control select2" data-toggle="select2"  required onchange="classWiseSectionForRoutineCreate(this.value)">
                                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                                <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                                <?php foreach($classes as $class): ?>
                                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="section_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('section'); ?></label>
                        <div class="col-md-9">
                            <select name="section_id" id = "section_id_on_routine_creation" class="form-control select2" data-toggle="select2"  required onchange="classWiseSubjectForRoutineCreate(this.value), sectionWiseClassroomsOnCreate(this.value)">
                                <option value=""><?php echo get_phrase('select_section'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="class_room_id" class="col-md-3 col-form-label"><?php echo get_phrase('class_room'); ?></label>
                        <div class="col-md-9">
                            <select name="class_room_id" id = "class_room_id_on_routine_creation" class="form-control select2" data-toggle="select2"  required>
                                <option value=""><?php echo get_phrase('select_a_class_room'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="subject_id_on_routine_creation" class="col-md-3 col-form-label"><?php echo get_phrase('subject'); ?></label>
                        <div class="col-md-6">
                            <select name="subject_id" id = "subject_id_on_routine_creation" class="form-control select2" data-toggle="select2"  required>
                                <option value=""><?php echo get_phrase('select_subject'); ?></option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="rightModal('<?php echo site_url('modal/popup/subject/create'); ?>', '<?php echo get_phrase('create_subject'); ?>')"> <i class="mdi mdi-plus fa-sm"></i></button>
                    </div>

                    <!-- <div class="form-group row">
                        <label for="teacher" class="col-md-3 col-form-label"><?php echo get_phrase('teacher'); ?></label>
                        <div class="col-md-9">
                            <select name="teacher_id" id = "teacher_on_routine_creation" class="form-control select2" data-toggle="select2"  required>
                                <option value=""><?php echo get_phrase('assign_a_teacher'); ?></option>
                                <?php $teachers = $this->db->get_where('teachers', array('school_id' => $school_id))->result_array(); ?>
                                <?php foreach($teachers as $teacher): ?>
                                    <option value="<?php echo $teacher['id']; ?>"><?php echo $this->user_model->get_user_details($teacher['user_id'], 'name'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group row">
                        <label for="day" class="col-md-3 col-form-label"><?php echo get_phrase('day'); ?></label>
                        <div class="col-md-9">
                            <select name="day" id = "day_on_routine_creation" class="form-control select2" data-toggle="select2"  required>
                                <option value=""><?php echo get_phrase('select_a_day'); ?></option>
                                <option value="Sunday"><?php echo get_phrase('sunday'); ?></option>
                                <option value="Monday"><?php echo get_phrase('monday'); ?></option>
                                <option value="Tuesday"><?php echo get_phrase('tuesday'); ?></option>
                                <option value="Wednesday"><?php echo get_phrase('wednesday'); ?></option>
                                <option value="Thursday"><?php echo get_phrase('thursday'); ?></option>
                                <option value="Friday"><?php echo get_phrase('friday'); ?></option>
                                <option value="Saturday"><?php echo get_phrase('saturday'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="starting_hour" class="col-md-3 col-form-label"><?php echo get_phrase('time_start'); ?></label>
                        <div class="col-md-6">
                        <input type="time" class="form-control" name="time_start" value="00:00:00">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ending_hour" class="col-md-3 col-form-label"><?php echo get_phrase('time_finish'); ?></label>
                        <div class="col-md-6">
                        <input type="time" class="form-control" name="time_finish" value="00:00:00">
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_class_routine'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    initSelect2(['#class_id_on_routine_creation',
    '#section_id_on_routine_creation',
    '#subject_id_on_routine_creation',
    '#teacher_on_routine_creation',
    '#class_room_id_on_routine_creation',
    '#day_on_routine_creation']);
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, getFilteredClassRoutine);
});

function classWiseSectionForRoutineCreate(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_on_routine_creation').html(response);
            classWiseSubjectForRoutineCreate(classId);
        }
    });
}

function classWiseSubjectForRoutineCreate(classId) {
    $.ajax({
        url: "<?php echo route('class_wise_subject/'); ?>"+classId,
        success: function(response){
            $('#subject_id_on_routine_creation').html(response);
        }
    });
}
</script>
<script>

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
      $('#class_room_id_on_routine_creation').html(response);
    }
  });
}

function filter_class(){
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    if(class_id != "" && section_id!= ""){
        showAllSubjects();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_class'); ?>');
    }
}

var showAllSubjects = function () {
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    if(class_id != "" && section_id!= ""){
        $.ajax({
            url: '<?php echo route('subject/list/') ?>'+class_id+'/'+section_id,
            success: function(response){
                $('.subject_content').html(response);
            }
        });
    }
}
</script>