<script>
function hide(){
document.button.butt.style.visibility = 'hidden';
return;
}
</script>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('visit_data/create'); ?>">
    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="date"><?php echo get_phrase('date_visit'); ?></label>
        <div class="col-md-9">
            <input type="text" class="form-control date" id="date" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
        </div>
    </div>

    <div class="form-group row mb-3">
        <label class="col-md-3 col-form-label" for="role"><?php echo get_phrase('role'); ?></label>
        <div class="col-md-9">
            <select name="role" id="role" class="form-control select2" data-toggle = "select2" required onchange="roleWiseOnCreate(this.value)">
                <option value=""><?php echo get_phrase('select_role'); ?></option>
                <option value="teacher"><?php echo get_phrase('teacher'); ?></option>
                <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                <option value="student"><?php echo get_phrase('student'); ?></option>
                <option value="tamu"><?php echo get_phrase('tamu'); ?></option>
                <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
            </select>
        </div>
    </div>

    <div id="user">
        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="user_id"> <?php echo get_phrase('name'); ?></label>
            <div class="col-md-9">
            <select name="user_id" id="user_id" class="form-control select2" data-toggle="select2" >
                <option value=""><?php echo get_phrase('select_a_name'); ?></option>
            </select>
            </div>
        </div>
    </div>

    <div id="tamu">
        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="nik"><?php echo get_phrase('nik'); ?></label>
            <div class="col-md-9">
                <input type="number" class="form-control" name = "nik" value="" >
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="name"><?php echo get_phrase('name'); ?></label>
            <div class="col-md-9">
                <input type="text" class="form-control" name = "name" value="" >
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="address"><?php echo get_phrase('alamat'); ?></label>
            <div class="col-md-9">
                <textarea id="address" class="form-control" name="address" rows="4" cols="50" ></textarea>
            </div>
        </div>

        <div class="form-group row mb-3">
            <label class="col-md-3 col-form-label" for="phone"><?php echo get_phrase('phone'); ?></label>
            <div class="col-md-9">
                <input type="number" class="form-control" name = "phone" value="" >
            </div>
        </div>
    </div>

    <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
    </div>
</form>

<script>
document.getElementById("user").style.visibility = "hidden";
document.getElementById("tamu").style.visibility = "hidden";

$("#role").change(function(){
var val = $(this).val();

    if(val == 'tamu'){
        document.getElementById("tamu").style.visibility = "visible";
        document.getElementById("user").style.visibility = "hidden";
    } else {
        document.getElementById("user").style.visibility = "visible";
        document.getElementById("tamu").style.visibility = "hidden";
    }
});

$(document).ready(function() {
    $('#date').daterangepicker();
});

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit(e, form, showAllVisitData);
});

$(document).ready(function () {
  initSelect2(['#role', '#user_id']);
});

function roleWiseOnCreate(role) {
    $.ajax({
        url: "<?php echo route('visit_data/role/'); ?>"+role,
        success: function(response){
            $('#user_id').html(response);
        }
    });
}
</script>
