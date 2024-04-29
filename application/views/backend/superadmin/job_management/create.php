<?php $school_id = school_id(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('job_management/create_job_management'); ?>">

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="role"><?php echo get_phrase('nip'); ?></label>
        <div class="col-md-9">
            <select name="user_id" id="user_id" class="form-control select2" data-toggle = "select2"  required onchange="roleWiseOnCreate(this.value),NameWiseOnCreate(this.value)">
            <option value=""><?php echo get_phrase('select_nip'); ?></option>
            <?php 
            $users = $this->user_model->get_employees()->result_array();
            ?>
                <?php foreach($users as $user): ?>
                    <option value="<?php echo $user['id']; ?>"><?php echo $user['nip']; ?> - <?= $user['name'];?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>
    
    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="user_id"> <?php echo get_phrase('name'); ?></label>
        <div class="col-md-9">
        <select name="name" id="name" class="form-control select2" data-toggle="select2" disabled>
        </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="user_id"> <?php echo get_phrase('old_role'); ?></label>
        <div class="col-md-9">
        <select name="role" id="role" class="form-control select2" data-toggle="select2" disabled>
        </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="role_new"><?php echo get_phrase('new_role'); ?></label>
        <div class="col-md-9">
            <select name="role_new" id="role_new" class="form-control select2" data-toggle = "select2"  required>
                <option value=""><?php echo get_phrase('select_new_role'); ?></option>
                <option value="teacher" ><?php echo get_phrase('teacher'); ?></option>
                <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                <option value="librarian"><?php echo get_phrase('librarian'); ?></option>
                <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="department"><?php echo get_phrase('department'); ?></label>
        <div class="col-md-9">
            <select name="department" id="department" class="form-control select2" data-toggle = "select2"  required>
            <option value=""><?php echo get_phrase('select_department'); ?></option>
            <?php $departments = $this->db->get_where('departments', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($departments as $department): ?>
                    <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="start_date"> <?php echo get_phrase('start_date'); ?></label>
        <div class="col-md-9">
        <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "start_date" value="<?php echo date('m/d/Y'); ?>" required>
        </div>
    </div>

    <!-- <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="finish_date"> <?php echo get_phrase('finish_date'); ?></label>
        <div class="col-md-9">
        <input type="text" class="form-control date" id="date1" data-toggle="date-picker" data-single-date-picker="true" name = "finish_date" value="<?php echo date('m/d/Y'); ?>" required>
        </div>
    </div> -->

    <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#date').daterangepicker();
});

$(document).ready(function() {
    $('#date1').daterangepicker();
});

$(function(){
        $('.select2').select2();
    });

if($('select').hasClass('select2') == true){
    $('div').attr('tabindex', "");
    $(function(){$(".select2").select2()});
}

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, showAllJobManagement);
});

$(document).ready(function () {
  initSelect2(['#user_id', '#role_new', '#department']);
});

function NameWiseOnCreate(user_id) {
    $.ajax({
        url: "<?php echo route('job_management/detail/'); ?>"+user_id,
        success: function(response){
            $('#name').html(response);
            // classWiseStudent(role);
        }
    });
}

function roleWiseOnCreate(user_id) {
    $.ajax({
        url: "<?php echo route('job_management/detail_role/'); ?>"+user_id,
        success: function(response){
            $('#role').html(response);
            // classWiseStudent(role);
        }
    });
}
</script>
