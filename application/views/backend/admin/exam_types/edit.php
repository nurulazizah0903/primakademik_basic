<?php $exam_types = $this->db->get_where('exam_types', array('id' => $param1))->result_array(); ?>
<?php foreach($exam_types as $exam_type){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('exam_types/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('exam_type_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $exam_type['name']; ?>" id="name" name = "name" required>
        </div>
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_exam_type'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$('document').ready(function(){
initSelect2(['#semester_id']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllExamTypes);
});
</script>
