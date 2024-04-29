<?php $infrastructure_details = $this->crud_model->get_infrastructure_by_id($param1); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('infrastructure/update/'.$param1); ?>">
    <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" value="<?php echo $infrastructure_details['name']; ?>" required>
        </div>

        <div class="form-group col-md-12">
        <label for="condition"><?php echo get_phrase('condition'); ?></label>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition" value="baik" <?php if ($infrastructure_details['condition'] == 'baik'): ?>checked<?php endif; ?>>
        <label class="form-check-label" for="condition"><?php echo get_phrase('good'); ?></label>
        </div>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition2" value="kurang baik" <?php if ($infrastructure_details['condition'] == 'kurang baik'): ?>checked<?php endif; ?>>
        <label class="form-check-label" for="condition2"><?php echo get_phrase('not_bad'); ?></label>
        </div>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition3" value="buruk" <?php if ($infrastructure_details['condition'] == 'buruk'): ?>checked<?php endif; ?>>
        <label class="form-check-label" for="condition3"><?php echo get_phrase('bad'); ?></label>
        </div>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition4" value="sangat buruk" <?php if ($infrastructure_details['condition'] == 'sangat buruk'): ?>checked<?php endif; ?>>
        <label class="form-check-label" for="condition4"><?php echo get_phrase('very_bad'); ?></label>
        </div>

        </div>

        <div class="form-group col-md-12">
            <label for="author"><?php echo get_phrase('amount'); ?></label>
            <input type="number" class="form-control" id="amount" name = "amount" value="<?= $infrastructure_details['amount'];?>" required>
        </div>

        <div class="form-group col-md-12">
            <label for="copies"><?php echo get_phrase('description'); ?></label>
            <textarea name="status" class="form-control" id="status" cols="3" rows="3"><?=$infrastructure_details['status'];?></textarea>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('location'); ?></label>
            <select name="location_id" id="location_id" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_location'); ?></option>
                <?php
                $locations = $this->crud_model->get_locations()->result_array();
                foreach ($locations as $location): ?>
                    <option value="<?php echo $location['id']; ?>" <?php if ($infrastructure_details['location_id'] == $location['id']): ?> selected <?php endif; ?>><?php echo $location['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
        </div>
    </div>
</form>

<script>
    
$(document).ready(function () {
    initSelect2(['#location_id']);
});

$(function(){
        $('.select2').select2();
});

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

    $(".ajaxForm").validate({});
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllInfrastructure);
    });
</script>
