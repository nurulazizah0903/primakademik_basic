<form method="POST" class="d-block ajaxForm" action="<?php echo route('assignment_types/create'); ?>">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('assignment_types_name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
        </div>
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_assignment_types'); ?></button>
        </div>
    </div>
</form>

<script>
$('document').ready(function(){
initSelect2(['#semester_id']);
});
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllAssigmentTypes);
});
</script>
