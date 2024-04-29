<form method="POST" class="d-block ajaxForm" action="<?php echo route('admin/create'); ?>">
    <div class="form-row">

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('role'); ?></label>
            <select name="role" id="role" class="form-control select2" data-toggle = "select2"  required onchange="roleWiseOnCreate(this.value)">
                <option value=""><?php echo get_phrase('select_role'); ?></option>
                <option value="teacher" ><?php echo get_phrase('teacher'); ?></option>
                <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                <option value="librarian"><?php echo get_phrase('librarian'); ?></option>
                <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('name'); ?></label>
            <select name="user_id" id="user_id" class="form-control select2" data-toggle="select2" required >
                <option value=""><?php echo get_phrase('select_a_name'); ?></option>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="email"><?php echo get_phrase('email'); ?></label>
            <input type="email" class="form-control" id="email" name = "email" required>
        </div>

        <div class="form-group col-md-12">
            <label for="password"><?php echo get_phrase('password'); ?></label>
            <input type="password" class="form-control" id="password" name = "password" required>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_admin_password'); ?></small>
        </div>

        <div class="form-group col-md-12">
            <label for="gender"><?php echo get_phrase('admin_of'); ?></label>
            <select name="school_id" id="school_id" class="form-control select2" data-toggle = "select2">
                <option value=""><?php echo get_phrase('select_a_school'); ?></option>
                <?php $schools = $this->crud_model->get_schools()->result_array(); ?>
                <?php foreach ($schools as $school): ?>
                    <option value="<?php echo $school['id']; ?>"><?php echo $school['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <small id="" class="form-text text-muted"><?php echo get_phrase('provide_admin_gender'); ?></small>
        </div>

        <div class="form-group mt-2 col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_admin'); ?></button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        initSelect2(['#school_id', '#gender', '#blood_group', '#role', '#user_id']);
    });
    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllAdmins);
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
</script>