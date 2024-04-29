<?php $accounts = $this->db->get_where('accounts', array('id' => $param1))->result_array(); ?>
<?php foreach($accounts as $account){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('account/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $account['name']; ?>" id="name" name = "name" required>
        </div>
		<div class="form-group col-md-12">
            <label for="code"><?php echo get_phrase('code'); ?></label>
            <input type="text" class="form-control" value="<?php echo $account['code']; ?>" id="price" name = "code" required>
        </div> 
		<div class="form-group col-md-12">
            <label for="type"><?php echo get_phrase('type'); ?></label>
            <input type="text" class="form-control" value="<?php echo $account['type']; ?>" id="type" name = "type" required>
        </div>   

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('edit_account'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(document).ready(function () {
  initSelect2(['#session']);
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllaccount);
});
</script>
