<?php
$teacher_data = $this->user_model->get_profile_data();
?>
<!--title-->
<div class="row d-print-none">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('daily_attendance_employee'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="row mt-3 d-print-none">
        <div class="col-md-3 mb-1"></div>
        <div class="col-md-2 mb-1">
          <select name="month" id="month" class="form-control select2" data-toggle="select2" required>
            <option value=""><?php echo get_phrase('select_a_month'); ?></option>
            <option value="Jan"<?php if(date('M') == 'Jan') echo 'selected'; ?>><?php echo get_phrase('january'); ?></option>
            <option value="Feb"<?php if(date('M') == 'Feb') echo 'selected'; ?>><?php echo get_phrase('february'); ?></option>
            <option value="Mar"<?php if(date('M') == 'Mar') echo 'selected'; ?>><?php echo get_phrase('march'); ?></option>
            <option value="Apr"<?php if(date('M') == 'Apr') echo 'selected'; ?>><?php echo get_phrase('april'); ?></option>
            <option value="May"<?php if(date('M') == 'May') echo 'selected'; ?>><?php echo get_phrase('may'); ?></option>
            <option value="Jun"<?php if(date('M') == 'Jun') echo 'selected'; ?>><?php echo get_phrase('june'); ?></option>
            <option value="Jul"<?php if(date('M') == 'Jul') echo 'selected'; ?>><?php echo get_phrase('july'); ?></option>
            <option value="Aug"<?php if(date('M') == 'Aug') echo 'selected'; ?>><?php echo get_phrase('august'); ?></option>
            <option value="Sep"<?php if(date('M') == 'Sep') echo 'selected'; ?>><?php echo get_phrase('september'); ?></option>
            <option value="Oct"<?php if(date('M') == 'Oct') echo 'selected'; ?>><?php echo get_phrase('october'); ?></option>
            <option value="Nov"<?php if(date('M') == 'Nov') echo 'selected'; ?>><?php echo get_phrase('november'); ?></option>
            <option value="Dec"<?php if(date('M') == 'Dec') echo 'selected'; ?>><?php echo get_phrase('december'); ?></option>
          </select>
        </div>
        <div class="col-md-2 mb-1">
          <select name="year" id="year" class="form-control select2" data-toggle="select2" required>
            <option value=""><?php echo get_phrase('select_a_year'); ?></option>
            <?php for($year = 2015; $year <= date('Y'); $year++){ ?>
              <option value="<?php echo $year; ?>"<?php if(date('Y') == $year) echo 'selected'; ?>><?php echo $year; ?></option>
            <?php } ?>

          </select>
        </div>
        <!-- <div class="col-md-2 mb-1"> -->
          <input type="hidden" value="<?= $teacher_data['role'];?>" name="role" id="role">
        <!-- </div> -->
        <div class="col-md-2">
          <button class="btn btn-block btn-secondary" onclick="filter_attendance_employee()" ><?php echo get_phrase('filter'); ?></button>
        </div>
      </div>
      <div class="card-body attendance_employee_content">
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
  initSelect2(['#month', '#year']);
});

function filter_attendance_employee(){
  var month = $('#month').val();
  var year = $('#year').val();
  var role = $('#role').val();

  if(month != "" && year != "" && role != ""){
    getDailtyAttendanceEmployee();
  }else{
    toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
  }
}

var getDailtyAttendanceEmployee = function () {
  var month = $('#month').val();
  var year = $('#year').val();
  var role = $('#role').val();
  if(month != "" && year != "" && role != ""){
    $.ajax({
      type: 'POST',
      url: '<?php echo route('attendance_employee/filter') ?>',
      data: {month : month, year : year, role : role},
      success: function(response){
        // console.log(response);
        $('.attendance_employee_content').html(response);
        initDataTable('basic-datatable');
      }
    });
  }
}
</script>
