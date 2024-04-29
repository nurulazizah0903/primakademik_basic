<form method="POST" class="d-block ajaxForm" action="<?php echo route('knowledge_base/create'); ?>">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">

        <div class="form-group col-md-12">
            <label for="subject_id_on_create"><?php echo get_phrase('subject'); ?></label>
            <select name="subject_id" id="subject_id_on_create" class="form-control select2" data-toggle="select2" required >
                <option value=""><?php echo get_phrase('select_a_subject'); ?></option>
                <?php
                $subjects = $this->db->get_where('subjects', array('school_id' => school_id()))->result_array();
                foreach($subjects as $subject){
                ?>
                <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('knowledge_base_name'); ?></label>
            <textarea class="form-control" id="name" name = "name" cols="5" rows="5" required></textarea>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_knowledge_base'); ?></button>
        </div>
    </div>
</form>

<script>
$(document).ready(function () {

initSelect2(['#subject_id_on_create']);

});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllKnowledgeBase);
});
</script>
