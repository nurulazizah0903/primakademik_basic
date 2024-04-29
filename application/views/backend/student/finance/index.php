<?php $student_data = $this->user_model->get_logged_in_student_details(); 
// echo var_dump($student_data);
// die;
?>
<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('history_student_payment'); ?>
                    <!-- <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/finance/create'); ?>', '<?php echo get_phrase('add_finance'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_finance'); ?></button> -->
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end page title -->

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
        <div class="mt-3 row">
				<!-- <div class="mb-1 col-md-1"></div>
				<div class="mb-1 col-md-4">
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
				<div class="mb-1 col-md-4">
					<select name="section" id="section_id" class="form-control select2" data-toggle="select2" required>
						<option value=""><?php echo get_phrase('select_section'); ?></option>
					</select>
				</div>
				<div class="col-md-2">
					<button class="btn btn-block btn-secondary" onclick="filter_finances()" ><?php echo get_phrase('filter'); ?></button>
				</div>
			</div> -->
            <div class="card-body">
             <div class = "finance_content">
                    <?php include 'list.php'; ?>
             </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script>

$('document').ready(function(){
    filter_finances();
});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}

function filter_finances(){
    var class_id = <?= $student_data['student_id'] ?>; 
    if(class_id != "" ){
        showAllFinances();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_class_and_section'); ?>');
    }
}

var showAllFinances = function () {
    var class_id = <?= $student_data['student_id'] ?>; 
    if(class_id != "" ){
        $.ajax({
            url: '<?php echo route('finance/list/') ?>'+class_id,
            success: function(response){
                $('.finance_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
}
</script>