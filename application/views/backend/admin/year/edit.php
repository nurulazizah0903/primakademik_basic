<?php $years = $this->db->get_where('years', array('id' => $param1))->result_array(); ?>
<?php foreach($years as $year){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('years/edit/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('year'); ?></label>
            <input type="text" class="form-control" value="<?php echo $year['name']; ?>" id="name" name = "name" required>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_year'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
      var form = $(this);
      ajaxSubmit(e, form, showAllYears);
  });
</script>
