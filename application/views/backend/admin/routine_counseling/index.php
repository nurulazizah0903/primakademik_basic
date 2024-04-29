<!--title-->
<div class="row ">
  <div class="col-xl-12 d-print-none">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
			<i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('routine_counseling'); ?>
			<button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/routine_counseling/create'); ?>', '<?php echo get_phrase('create_routine_counseling'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_routine_counseling'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="mt-3 row">
				<div class="mb-1 col-md-2"></div>
				<div class="mb-1 col-md-2">
					<select name="class" id="class_id" class="form-control select2" data-toggle="select2" required onchange="classWiseSection(this.value)">
						<option value=""><?php echo get_phrase('select_a_class'); ?></option>
						<?php
						$classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
						foreach($classes as $class){
							?>
							<option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="mb-1 col-md-2">
					<select name="section" id="section_id" class="form-control select2" data-toggle="select2" onchange="sectionWiseClassroomsOnCreate(this.value)" required>
						<option value=""><?php echo get_phrase('select_section'); ?></option>
					</select>
				</div>
				<div class="mb-1 col-md-2">
					<select name="room_id" id="room_id" class="form-control select2" data-toggle = "select2" required>
							<option value=""><?php echo get_phrase('select_class_rooms'); ?></option>
					</select>
				</div>
				<div class="col-md-2">
					<button class="btn btn-block btn-secondary" onclick="filter_class_routine()" ><?php echo get_phrase('filter'); ?></button>
				</div>
			</div>
			<div class="card-body routine_counseling_content">
				<?php include 'list.php'; ?>
			</div>
		</div>
	</div>
</div>

<script>

function classWiseSection(classId) {
	$.ajax({
		url: "<?php echo route('section/list/'); ?>"+classId,
		success: function(response){
			$('#section_id').html(response);
		}
	});
}

function filter_class_routine(){
	var class_id = $('#class_id').val();
	var section_id = $('#section_id').val();
	$.ajax({
		type : 'post',
		url: '<?php echo route('routine_counseling/filter/') ?>',
		data: {class_id : class_id, section_id : section_id},
		success: function(response){
			$('.routine_counseling_content').html(response);
			initDataTable('basic-datatable');
		}
	});
}

function sectionWiseClassroomsOnCreate(sectionId) {
  $.ajax({
    url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
    success: function(response){
      $('#room_id').html(response);
    }
  });
}


var getFilteredClassRoutine = function() {
		$.ajax({
			url: '<?php echo route('routine_counseling/list/') ?>'+class_id+'/'+section_id,
			success: function(response){
				$('.routine_counseling_content').html(response);
        		initDataTable('basic-datatable');
			}
		});
}
</script>
