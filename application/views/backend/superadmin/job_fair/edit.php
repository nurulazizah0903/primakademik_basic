<?php $job_fair = $this->crud_model->get_job_fairs_by_id($param1); ?>
  <form method="POST" class="d-block ajaxForm" action="<?php echo route('job_fair/update/'.$param1); ?>">
    <div class="form-row">

      <div class="form-group col-md-12">
          <label for="title"><?php echo get_phrase('title'); ?></label>
          <textarea class="form-control" id="title" name = "title" placeholder="<?php echo get_phrase('title'); ?>" required cols="5" rows="5"><?php echo $job_fair['title']; ?></textarea>
      </div>

      <div class="form-group col-md-12">
          <label for="copies"><?php echo get_phrase('photo'); ?></label>
          <input type="file" class="form-control" id="photo"  value="<?php echo $job_fair['photo']; ?>" name = "photo" required>
      </div>

      <div class="form-group col-md-12">
          <label for="description"><?php echo get_phrase('description'); ?></label>
          <textarea name="description" class="form-control" id="description" cols="5" rows="5" required><?php echo $job_fair['description']; ?></textarea>
      </div>

      <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_job_fair'); ?></button>
      </div>
    </div>
  </form>
<script>
    $(document).ready(function(){
    initCustomFileUploader();
    });
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllJobfairs);
  });
</script>
