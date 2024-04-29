<!--title-->
<div class="row ">
  <div class="col-xl-12 d-print-none">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
		    <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('manage_employee_info'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="mt-3 row">
				<div class="col-md-2 mb-1"></div>
                    <div class="col-md-2 mb-1">
                        <select name="role" id="role_on_create" class="form-control select2"  data-toggle = "select2" required onchange="roleWiseOnCreate(this.value)">
                            <option value=""><?php echo get_phrase('select_role'); ?></option>
                            <option value="teacher" ><?php echo get_phrase('teacher'); ?></option>
                            <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                            <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
                            <option value="librarian"><?php echo get_phrase('librarian'); ?></option>
                        </select>
                    </div>
					<div class="col-md-4 mb-1">
                        <select name="user_id" id="user_id_on_create" class="form-control select2"  data-toggle = "select2" required >
                            <option value=""><?php echo get_phrase('select_a_name'); ?></option>
                        </select>
                    </div>
				<div class="col-md-2">
					<button class="btn btn-block btn-secondary" onclick="filter_employee()" ><?php echo get_phrase('filter'); ?></button>
				</div>
			</div>
			<div class="card-body employee_info_content">
			<div class="empty_box">
                        <img class="mb-3" width="150px" src="<?php echo base_url('assets/backend/images/empty_box.png'); ?>" />
                        <br>
                        <span class=""><?php echo get_phrase('no_data_found'); ?></span>
                    </div>
			</div>
		</div>
	</div>
</div>

<script>
$('document').ready(function(){
    initSelect2(['#user_id_on_create', '#role_on_create']);
});

function roleWiseOnCreate(role) {
    $.ajax({
        url: "<?php echo route('book_issue/role/'); ?>"+role,
        success: function(response){
            // console.log(response);
            $('#user_id_on_create').html(response);
            // classWiseStudent(role);
        }
    });
}

function filter_employee(){
	var user_id = $('#user_id_on_create').val();
	if(user_id != ""){
		getFilteredEmployeeInfo();
	}else{
		toastr.error('<?php echo get_phrase('please_select_a_field'); ?>');
	}
}

var getFilteredEmployeeInfo = function() {
	var user_id = $('#user_id_on_create').val();
	if(user_id != ""){
		$.ajax({
			url: '<?php echo route('employee_info/employee_info/') ?>'+user_id,
			success: function(response){
				$('.employee_info_content').html(response);
			}
		});
	}
}
</script>