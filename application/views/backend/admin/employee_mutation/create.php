<?php $school_id = school_id(); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('employee_mutation/create'); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="role"><?php echo get_phrase('role'); ?></label>
                <select name="role" id="role" class="form-control select2" data-toggle = "select2"  required onchange="roleWiseOnCreate(this.value)">
                    <option value=""><?php echo get_phrase('select_role'); ?></option>
                    <option value="teacher" ><?php echo get_phrase('teacher'); ?></option>
                    <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                    <option value="librarian"><?php echo get_phrase('librarian'); ?></option>
                    <option value="admin"><?php echo get_phrase('admin'); ?></option>
                    <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
                </select>
        </div>

        <div class="form-group col-md-12">
            <label for="user_id"> <?php echo get_phrase('name'); ?></label>
            <select name="user_id" id="user_id" class="form-control select2" data-toggle="select2" required >
                <option value=""><?php echo get_phrase('select_a_name'); ?></option>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="date"><?php echo get_phrase('date'); ?></label>
                <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
        </div>

        <div class="form-group col-md-12">
            <label for="caption"><?php echo get_phrase('caption'); ?></label>
            <textarea class="form-control" id="caption" name = "caption" rows="5" required></textarea>
        </div>

        <div class="form-group mt-2 col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
    $('#date').daterangepicker();
    });

    $(document).ready(function () {
        initSelect2(['#user_id', '#role']);
    });

    function roleWiseOnCreate(role) {
    $.ajax({
        url: "<?php echo route('book_issue/role/'); ?>"+role,
        success: function(response){
            $('#user_id').html(response);
            // classWiseStudent(role);
        }
    });
    }

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
        ajaxSubmit(e, form, showAllEmployeeMutation);
    });
</script>