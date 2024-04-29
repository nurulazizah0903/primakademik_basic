<?php $book_types = $this->crud_model->get_book_types_by_id($param1)->result_array(); ?>
<?php foreach($book_types as $book_type){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('book_types/edit/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('book_type'); ?></label>
            <input type="text" class="form-control" value="<?php echo $book_type['name']; ?>" id="name" name = "name" required>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_book_type'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
      var form = $(this);
      ajaxSubmit(e, form, showAllBookTypes);
  });
</script>
