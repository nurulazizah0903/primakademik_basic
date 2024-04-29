<form method="POST" class="d-block ajaxForm" action="<?php echo route('registration_path/create'); ?>">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('registration_path_name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
        </div>

        <div class="form-group col-md-12">
            <label for="total"><?php echo get_phrase('total'); ?></label>
            <input type="number" class="form-control" name="total">
        </div>

        <div class="form-group col-md-12">
            <label for="minimum_cicilan_pertama"><?php echo get_phrase('minimum_first_inden'); ?></label>
            <input type="number" class="form-control" name="minimum_cicilan_pertama">
        </div>        

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_registration_path'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllRegistrationPath);
});
</script>
