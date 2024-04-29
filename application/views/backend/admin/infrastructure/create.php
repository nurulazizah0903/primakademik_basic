<form method="POST" class="d-block ajaxForm" action="<?php echo route('infrastructure/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
        </div>

        <div class="form-group col-md-12">
        <label for="condition"><?php echo get_phrase('condition'); ?></label>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition" value="baik">
        <label class="form-check-label" for="condition"><?php echo get_phrase('good'); ?></label>
        </div>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition2" value="kurang baik">
        <label class="form-check-label" for="condition2"><?php echo get_phrase('not_bad'); ?></label>
        </div>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition3" value="buruk">
        <label class="form-check-label" for="condition3"><?php echo get_phrase('bad'); ?></label>
        </div>

        <div class="form-check">
        <input class="form-check-input" type="radio" name="condition" id="condition4" value="sangat buruk">
        <label class="form-check-label" for="condition4"><?php echo get_phrase('very_bad'); ?></label>
        </div>

        </div>

        <div class="form-group col-md-12">
            <label for="author"><?php echo get_phrase('amount'); ?></label>
            <input type="number" class="form-control" id="amount" name = "amount" required>
        </div>

        <div class="form-group col-md-12">
            <label for="copies"><?php echo get_phrase('description'); ?></label>
            <textarea name="status" class="form-control" id="status" cols="3" rows="3"></textarea>
        </div>

        <div class="form-group col-md-12">
            <label for="location"><?php echo get_phrase('location'); ?></label>
            <textarea name="location" class="form-control" id="location" cols="3" rows="3"></textarea>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
        </div>
    </div>
</form>

<script>
    $(".ajaxForm").validate({});
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllInfrastructure);
    });
</script>
