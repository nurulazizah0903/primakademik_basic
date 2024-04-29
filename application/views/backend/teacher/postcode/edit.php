<?php $postcodeis = $this->db->get_postcode_by_id($param1)->result_array(); ?>
<?php foreach($postcodeis as $postcode){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('postcode/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('districts'); ?></label>
            <select name="districts_id" id="districts_id" class="form-control" required>
                <option value=""><?php echo get_phrase('select_districts'); ?></option>
                <?php
                $districtss = $this->crud_model->get_districts()->result_array();
                foreach ($districtss as $districts): ?>
                    <option value="<?php echo $districts['id']; ?>" <?php if ($postcode['infrastructure_id'] == $infrastructure['id']): ?> selected <?php endif; ?>><?php echo $districts['name'];?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('postcode'); ?></label>
            <input type="text" class="form-control" value="<?php echo $postcode['postcode']; ?>" id="postcode" name = "postcode" required>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_postcode'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllPostcodes);
});
</script>
