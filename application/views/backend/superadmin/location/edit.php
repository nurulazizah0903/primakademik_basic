<?php $location = $this->crud_model->get_locations_by_id($param1); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('locations/edit/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('location'); ?></label>
            <input type="text" class="form-control" value="<?php echo $location['name']; ?>" id="name" name = "name" required>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_location'); ?></button>
        </div>
    </div>
</form>

<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
      var form = $(this);
      ajaxSubmit(e, form, showAllLocations);
  });
</script>
