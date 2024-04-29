<?php $awards = $this->db->get_where('awards', array('id' => $param1))->result_array(); ?>
<?php foreach($awards as $award){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('awards/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('awards_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $award['name']; ?>" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_awards_name'); ?></small>
        </div>
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_awards'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllAwards);
});
</script>
