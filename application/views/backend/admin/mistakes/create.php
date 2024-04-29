<form method="POST" class="d-block ajaxForm" action="<?php echo route('mistakes/create'); ?>">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('mistakes_name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_mistakes_name'); ?></small>
        </div>

        <div class="form-group col-md-12">
            <label for="point"><?php echo get_phrase('mistakes_point'); ?></label>
            <input type="number" class="form-control" id="point" name = "point" required>
            <small id="point_help" class="form-text text-muted"><?php echo get_phrase('provide_mistakes_point'); ?></small>
        </div>
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_mistakes'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllMistakes);
});
</script>
