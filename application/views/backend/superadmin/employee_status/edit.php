<?php $employee_statusies = $this->db->get_where('employee_status', array('id' => $param1))->result_array(); ?>
<?php foreach($employee_statusies as $employee_status){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('employee_status/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('employee_status_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $employee_status['name']; ?>" id="name" name = "name" required>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_employee_status'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllEmployeeStatus);
});
</script>
