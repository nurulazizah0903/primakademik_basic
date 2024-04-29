<?php $knowledge_base = $this->crud_model->get_knowledge_base_by_id($param1); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('knowledge_base/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="subject_id_on_create"><?php echo get_phrase('subject'); ?></label>
            <select name="subject_id" id="subject_id_on_create" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_a_subject'); ?></option>
                <?php
                $subjects = $this->db->get_where('subjects', array('section_id' => $knowledge_base['section_id']))->result_array();
                foreach($subjects as $subject){
                ?>
                <option value="<?php echo $subject['id']; ?>" <?php if($subject['id'] == $knowledge_base['subject_id']){ echo 'selected'; } ?>><?php echo $subject['name']; ?> - <?php echo $this->db->get_where('class_rooms', array('id' => $subject['room_id']))->row('name');?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('knowledge_base_name'); ?></label>
            <textarea class="form-control" id="name" name = "name" cols="5" rows="5" required><?php echo $knowledge_base['name']; ?></textarea>
        </div>
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_knowledge_base'); ?></button>
        </div>
    </div>
</form>

<script>
$(document).ready(function () {

initSelect2(['#subject_id_on_create', '#class_id_on_create', '#section_id_on_create']);

});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_on_create').html(response);
            classWiseSubject(classId);
        }
    });
}

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

function classWiseSubject(classId) {
    $.ajax({
        url: "<?php echo route('class_wise_subject/'); ?>"+classId,
        success: function(response){
            $('#subject_id_on_create').html(response);
        }
    });
}
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit2(e, form, showAllKnowledgeBase);
    location.reload();
});
</script>
