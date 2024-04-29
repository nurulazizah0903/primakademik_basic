<?php $student_lists = $this->user_model->get_student_list_of_logged_in_parent(); ?>
<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('student_bill'); ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end page title -->

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
        <div class="row mt-3">
			<div class="col-md-3 mb-1"></div>
				<div class="col-md-4 mb-1">
					<select name="student_id" id="student_id" class="form-control select2" data-toggle="select2" required >
						<option value=""><?php echo get_phrase('select_a_student'); ?></option>
						<?php foreach ($student_lists as $student_list): ?>
							<option value="<?php echo $student_list['id']; ?>"><?php echo $student_list['name']; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<!-- <input type="hidden" name="class_id" id="class_id" value="">
				<input type="hidden" name="secion_id" id="section_id" value=""> -->
				<div class="col-md-2">
					<button class="btn btn-block btn-secondary" onclick="filter_class_invoice()" ><?php echo get_phrase('filter'); ?></button>
				</div>
			</div>
			<div class="card-body invoice_content">
				<?php include 'list.php'; ?>
             </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script>

$('document').ready(function(){
	initSelect2(['#student_id']);
});
 

function filter_class_invoice(){
	var student_id = $('#student_id').val();
	if(student_id != ""){
		getFilteredClassinvoice();
	}else{
		toastr.error('<?php echo get_phrase('please_select_a_student'); ?>');
	}
}

var getFilteredClassinvoice = function() {
	var student_id = $('#student_id').val();
	if(student_id != ""){
		$.ajax({
			url: '<?php echo route('invoice/list/') ?>'+student_id,
			success: function(response){
				$('.invoice_content').html(response);
			}
		});
	}
}
 

</script>