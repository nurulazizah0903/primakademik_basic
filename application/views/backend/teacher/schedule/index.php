<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
?>

<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('teaching_schedule'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body class_routine_content">
				<?php include 'list.php'; ?>
			</div>
		</div>
	</div>
</div>

<script>
$('document').ready(function(){
    getFilteredClassRoutine();
});

var getFilteredClassRoutine = function() {
	var teacher_id = "<?= $teacher_id; ?>";
	if (teacher_id != "") {
		$.ajax({
			url: '<?php echo route('schedule/filter/') ?>'+teacher_id,
			success: function(response){
				$('.class_routine_content').html(response);
			}
		});
	}
}
</script>
