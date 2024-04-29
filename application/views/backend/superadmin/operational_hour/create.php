<form method="POST" class="d-block ajaxForm" action="<?php echo route('operational_hour/create'); ?>">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('operational_hour_name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
        </div>

        <div class="form-group col-md-12">
            <label for="starting_hour"><?php echo get_phrase('time_start'); ?></label>
            <input type="time" class="form-control" name="time_start" value="00:00:00">
        </div>

        <div class="form-group col-md-12">
            <label for="ending_hour"><?php echo get_phrase('time_finish'); ?></label>
            <input type="time" class="form-control" name="time_finish" value="00:00:00">
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_operational_hour'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllOperationalHour);
});
</script>
