<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('syllabus/create'); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <?php $school_id = school_id(); ?>
        <input type="hidden" name="school_id" value="<?php echo $school_id; ?>">
        <input type="hidden" name="session_id" value="<?php echo active_session(); ?>">
        <div class="form-group col-md-12">
            <label for="title"><?php echo get_phrase('tittle'); ?></label>
            <input type="text" class="form-control" id="title" name = "title" required>
        </div>

        <div class="form-group col-md-12">
            <label for="subject_id_on_create"><?php echo get_phrase('subject'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="subject_id_on_create" name="subject_id" requied>
                <option><?php echo get_phrase('select_a_subject'); ?></option>
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
        <div class="form-group col-md-12">
            <label for="syllabus_file"><?php echo get_phrase('upload_syllabus'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="syllabus_file" name = "syllabus_file" required>
            </div>
        </div>
        </div>
        <div class="form-group col-md-12 mt-2">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_syllabus'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var imgVal = $('#syllabus_file').val(); 
        if(imgVal=='') 
        { 
            alert("<?php echo get_phrase('please_select_in_all_fields !')?>"); 
            return false; 
        }
    var form = $(this);
    ajaxSubmit(e, form, showAllSyllabuses);
});

$('document').ready(function(){
    initSelect2(['#class_id_on_create',
                '#section_id_on_create',
                '#subject_id_on_create', '#room_id_on_create']);
});

  initCustomFileUploader();

  $(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}
</script>
