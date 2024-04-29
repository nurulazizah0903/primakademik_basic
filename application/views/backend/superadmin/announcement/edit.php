<?php $announcements = $this->db->get_where('announcements', array('id' => $param1))->result_array(); ?>
<?php foreach($announcements as $announcement){ ?>
  <form method="POST" class="d-block ajaxForm" action="<?php echo route('announcement/update/'.$param1); ?>">
    <div class="form-row">
      <div class="form-group col-md-12">
        <label for="announcement_name"><?php echo get_phrase('announcement_name'); ?></label>
        <input type="text" value="<?php echo $announcement['name']; ?>" class="form-control" id="announcement_name" name = "announcement_name" placeholder="name" required>
      </div>

      <div class="form-group col-md-12">
        <label for="date"><?php echo get_phrase('date'); ?></label>
        <input type="text" value="<?php echo date('m/d/Y', $announcement['date']); ?>" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" required>
      </div>

      <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_announcement'); ?></button>
      </div>
    </div>
  </form>
<?php } ?>
<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllAnnouncements);
  });
  $("#date" ).daterangepicker();
</script>
