<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase('section'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/section/create'); ?>', '<?php echo get_phrase('create_section'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_section'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row mt-3">
            <div class="col-md-3 "></div>
                <div class="col-md-4 mb-1">
                    <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                        <?php
                        $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();?>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_class()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="card-body section_content">
            <?php include 'list_all.php'; ?>
            </div>
        </div>
    </div>
</div>


<script>
function filter_class(){
    var class_id = $('#class_id').val();
    $.ajax({
			type : 'post',
			url: '<?php echo route('section/filter/') ?>',
			data: {class_id : class_id},
			success: function(response){
				$('.section_content').html(response);
			}
		});
}

var showAllSections = function () {
        $.ajax({
            url: '<?php echo route('section/list_all/') ?>',
            success: function(response){
                $('.section_content').html(response);
            }
        });
}
</script>
