<!--title-->
<div class="row ">
  <div class="col-xl-12 d-print-none">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
					<i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('routine_extracurricular'); ?>
					<button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_extracurricular/create'); ?>', '<?php echo get_phrase('create_routine_extracurricular'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_routine_extracurricular'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="mt-3 row">
				<div class="mb-1 col-md-3"></div>
				<div class="mb-1 col-md-4">
					<select name="organizations_id" id="organizations_id" class="form-control select2" data-toggle="select2" required>
						<option value=""><?php echo get_phrase('select_organizations'); ?></option>
						<?php
						$organizations = $this->db->get_where('organizations', array('school_id' => school_id()))->result_array();
						foreach($organizations as $organization){
							?>
							<option value="<?php echo $organization['id']; ?>"><?php echo $organization['name']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-2">
					<button class="btn btn-block btn-secondary" onclick="filter_routine_extracurricular()" ><?php echo get_phrase('filter'); ?></button>
				</div>
			</div>
			<div class="card-body routine_extracurricular_content">
				<?php include 'list.php'; ?>
			</div>
		</div>
	</div>
</div>

<script>
function filter_routine_extracurricular(){
	var organizations_id = $('#organizations_id').val();
	if(organizations_id != ""){
		getFilteredRoutineExtracurricular();
	}else{
		toastr.error('<?php echo get_phrase('please_select_a_organizations'); ?>');
	}
}

var getFilteredRoutineExtracurricular = function() {
	var organizations_id = $('#organizations_id').val();
	if(organizations_id != ""){
		$.ajax({
			url: '<?php echo route('routine_extracurricular/filter/') ?>'+organizations_id,
			success: function(response){
				$('.routine_extracurricular_content').html(response);
			}
		});
	}
}
</script>
