<form method="POST" class="d-block ajaxForm" action="<?php echo route('postcode/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('districts'); ?></label>
            <select name="districts_id" id="districts_id" class="form-control" required>
                <option value=""><?php echo get_phrase('select_districts'); ?></option>
                <?php
                $districtss = $this->crud_model->get_districts()->result_array();
                foreach ($districtss as $districts): ?>
                    <option value="<?php echo $districts['id']; ?>"><?php echo $districts['name'];?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group col-md-12">
            <label for="postcode"><?php echo get_phrase('postcode'); ?></label>
            <input type="text" class="form-control" id="postcode" name = "postcode" required>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_class_room'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllPostcodes);
});
</script>
