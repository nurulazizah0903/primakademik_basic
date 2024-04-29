<?php $provinces = $this->db->get_province_by_id($param1)->result_array(); ?>
<?php foreach($provinces as $province){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('province/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="province_name"><?php echo get_phrase('province_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $class_room['name']; ?>" id="name" name = "name" required>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_province'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllProvinces);
});
</script>
