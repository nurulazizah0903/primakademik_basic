<?php $mistakes = $this->db->get_where('mistakes', array('id' => $param1))->result_array(); ?>
<?php foreach($mistakes as $mistake){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('mistakes/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('mistakes_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $mistake['name']; ?>" id="name" name = "name" required>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_mistakes_name'); ?></small>
        </div>

        <div class="form-group col-md-12">
            <label for="point"><?php echo get_phrase('mistakes_point'); ?></label>
            <input type="text" class="form-control" value="<?php echo $mistake['point']; ?>" id="point" name = "point" required>
            <small id="point_help" class="form-text text-muted"><?php echo get_phrase('provide_mistakes_point'); ?></small>
        </div>
        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_mistakes'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllMistakes);
});
</script>
