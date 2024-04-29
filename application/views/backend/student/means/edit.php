<?php $means_details = $this->crud_model->get_means_by_id($param1); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('means/update/'.$param1); ?>">
    <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" value="<?php echo $means_details['name']; ?>" required>
        </div>

        <div class="form-group col-md-12">
        <label for="condition"><?php echo get_phrase('condition'); ?></label>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition" value="baik" <?php if ($means_details['condition'] == 'baik'): ?>checked<?php endif; ?>>
        <label class="form-check-label" for="condition"><?php echo get_phrase('good'); ?></label>
        </div>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition2" value="kurang baik" <?php if ($means_details['condition'] == 'kurang baik'): ?>checked<?php endif; ?>>
        <label class="form-check-label" for="condition2"><?php echo get_phrase('not_bad'); ?></label>
        </div>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition3" value="buruk" <?php if ($means_details['condition'] == 'buruk'): ?>checked<?php endif; ?>>
        <label class="form-check-label" for="condition3"><?php echo get_phrase('bad'); ?></label>
        </div>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition4" value="sangat buruk" <?php if ($means_details['condition'] == 'sangat buruk'): ?>checked<?php endif; ?>>
        <label class="form-check-label" for="condition4"><?php echo get_phrase('very_bad'); ?></label>
        </div>

        </div>

        <div class="form-group col-md-12">
            <label for="author"><?php echo get_phrase('amount'); ?></label>
            <input type="number" class="form-control" id="amount" name = "amount" value="<?= $means_details['amount'];?>" required>
        </div>

        <div class="form-group col-md-12">
            <label for="copies"><?php echo get_phrase('status'); ?></label>
            <select name="status" id="status" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('select_a_status'); ?></option>
                <option value="terpakai" <?php if ($means_details['status'] == 'terpakai'): ?> selected <?php endif; ?>><?php echo get_phrase('use'); ?></option>
                <option value="tidak terpakai" <?php if ($means_details['status'] == 'tidak terpakai'): ?> selected <?php endif; ?>><?php echo get_phrase('not_use'); ?></option>
            </select>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update'); ?></button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
    initSelect2(['#status']);
    });

    $(".ajaxForm").validate({});
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllMeans);
    });
</script>