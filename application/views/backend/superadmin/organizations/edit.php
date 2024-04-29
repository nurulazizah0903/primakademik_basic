<?php $organizations = $this->db->get_where('organizations', array('id' => $param1))->result_array(); ?>
<?php foreach($organizations as $organization){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('organizations/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('organizations_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $organization['name']; ?>" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_organizations_name'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_organizations'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllOrganizations);
});
</script>
