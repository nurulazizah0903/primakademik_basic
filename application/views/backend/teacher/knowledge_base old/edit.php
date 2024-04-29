<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
$knowledge_bases = $this->db->get_where('knowledge_base', array('id' => $param1))->result_array();
foreach($knowledge_bases as $knowledge_base){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('knowledge_base/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="subject_id_on_create"><?php echo get_phrase('subject'); ?></label>
            <select name="subject_id" id="subject_id_on_create" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_a_subject'); ?></option>
                <?php
                $subjects = $this->db->get_where('subjects', array('school_id' => school_id(), 'teacher_id' => $teacher_id))->result_array();
                foreach($subjects as $subject){
                    $class_details = $this->crud_model->get_class_details_by_id($subject['class_id'])->row_array();
                    $section_details = $this->crud_model->get_section_details_by_id('section', $subject['section_id'])->row_array();
                ?>
                    <option value="<?php echo $subject['id']; ?>" <?php if($subject['id'] == $knowledge_base['subject_id']){ echo 'selected'; } ?>>(<?php echo $class_details['name']; ?> - <?php echo $section_details['name']; ?>)  <?php echo $subject['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('knowledge_base_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $knowledge_base['name']; ?>" id="name" name = "name" required>
        </div>
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_knowledge_base'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(document).ready(function () {

initSelect2(['#subject_id_on_create', '#class_id_on_create', '#section_id_on_create']);

});

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllKnowledgeBase);
});
</script>
