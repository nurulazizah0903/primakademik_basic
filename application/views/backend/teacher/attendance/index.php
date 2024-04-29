<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row()->id;
?>
<!--title-->
<div class="row d-print-none">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('daily_attendance'); ?>
          <!-- <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/attendance/confirm_all'); ?>', '<?php echo get_phrase('attendance_confirm'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('attendance_confirm'); ?></button> -->
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="row mt-3 d-print-none">
        <div class="col-md-2 mb-1"></div>
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
        <div class="col-md-2 mb-1">
            <select name="permission_id" id="permission_id" class="form-control select2" data-toggle = "select2" required>
              <option value=""><?php echo get_phrase('select_section'); ?></option>
              <?php 
              $this->db->or_where('attendance', 1);
              $this->db->or_where('homeroom', 1);
              $this->db->where('teacher_id', $teacher_id);
              $permissions = $this->db->get('teacher_permissions')->result_array();
              foreach($permissions as $permission){
                  $class_details = $this->crud_model->get_class_details_by_id($permission['class_id'])->row_array();
                  $section_details = $this->crud_model->get_section_details_by_id('section', $permission['section_id'])->row_array();
                  ?>
                  <option value="<?php echo $permission['id']; ?>"><?php echo $class_details['name']; ?> - <?php echo $section_details['name']; ?></option>
              <?php } ?>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-block btn-secondary" onclick="filter_attendance()" ><?php echo get_phrase('filter'); ?></button>
        </div>
      </div>
      <div class="card-body attendance_content">
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
  initSelect2(['#month', '#year', '#permission_id']);
});

function filter_attendance(){
  var month = $('#month').val();
  var year = $('#year').val();
  var permission_id = $('#permission_id').val();
  if(permission_id != "" && month != "" && year != ""){
    getDailtyAttendance();
  }else{
    toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
  }
}

var getDailtyAttendance = function () {
  var month = $('#month').val();
  var year = $('#year').val();
  var permission_id = $('#permission_id').val();
  if(permission_id != "" && month != "" && year != ""){
    $.ajax({
      type: 'POST',
      url: '<?php echo route('attendance/filter') ?>',
      data: {month : month, year : year, permission_id : permission_id},
      success: function(response){
        $('.attendance_content').html(response);
        initDataTable('basic-datatable');
      }
    });
  }
}
</script>
