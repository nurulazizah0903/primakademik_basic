<?php $registration_paths = $this->db->get_where('registration_path', array('id' => $param1))->result_array(); ?>
<?php foreach($registration_paths as $registration_path){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('registration_path/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('registration_path_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $registration_path['name']; ?>" id="name" name = "name" required>
        </div>

        <div class="form-group col-md-12">
            <label for="total"><?php echo get_phrase('total'); ?></label>
            <input type="number" class="form-control" name="total" value="<?=$registration_path['total']?>">
        </div>

        <div class="form-group col-md-12">
            <label for="minimum_cicilan_pertama"><?php echo get_phrase('minimum_first_inden'); ?></label>
            <input type="number" class="form-control" name="minimum_cicilan_pertama" value="<?=$registration_path['minimum_cicilan_pertama']?>">
        </div>        

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_registration_path'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllRegistrationPath);
});
</script>
