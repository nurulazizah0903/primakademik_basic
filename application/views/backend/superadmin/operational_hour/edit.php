<?php $operational_hours = $this->db->get_where('operational_hour', array('id' => $param1))->result_array(); ?>
<?php foreach($operational_hours as $operational_hour){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('operational_hour/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('operational_hour_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $operational_hour['name']; ?>" id="name" name = "name" required>
        </div>

        <div class="form-group col-md-12">
            <label for="time_start"><?php echo get_phrase('time_start'); ?></label>
            <input type="time" class="form-control" name="time_start" value="<?=$operational_hour['time_start']?>">
        </div>
        
        <div class="form-group col-md-12">
            <label for="time_finish"><?php echo get_phrase('time_finish'); ?></label>
            <input type="time" class="form-control" name="time_finish" value="<?=$operational_hour['time_finish']?>">
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_operational_hour'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllOperationalHour);
});
</script>
