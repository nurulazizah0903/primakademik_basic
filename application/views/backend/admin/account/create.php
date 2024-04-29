<form method="POST" class="d-block ajaxForm" action="<?php echo route('account/create'); ?>" id="form1">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" id="name" name = "name" required>
        </div>
		<div class="form-group col-md-12">
            <label for="code"><?php echo get_phrase('code'); ?></label>
            <input type="text" class="form-control" id="code" name = "code" required>
        </div> 
        <div class="form-group col-md-12">
            <label for="type"><?php echo get_phrase('type'); ?></label>
            <input type="type" class="form-control" id="type" name = "type" required>
        </div>   
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_account'); ?></button>
        </div>
    </div>
</form> 
<script>
    $(document).ready(function () {
  initSelect2(['#session']);
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit2(e, form, showAllaccount);
});
</script>
