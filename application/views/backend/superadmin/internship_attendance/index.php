<!--title-->
<div class="row d-print-none">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <?php
            $this->db->where("internship.school_id", school_id());
            $this->db->where("internship.id", $internship_id);
            $this->db->join("industry_company", "internship.company_id=industry_company.id");
            $company_name = $this->db->get("internship")->row_array();
          ?>
          <i class="mdi mdi-calendar-today title_icon"></i> <?php echo $company_name['company_name']; ?>
          <!-- <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/attendance/confirm_all'); ?>', '<?php echo get_phrase('attendance_confirm'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('attendance_confirm'); ?></button> -->
          <!-- <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/attendance/take_attendance'); ?>', '<?php echo get_phrase('take_attendance'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('take_attendance'); ?></button> -->
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
          <input type="hidden" name="internship_id" id="internship_id" value="<?= $internship_id; ?>">
          <div class="col-md-3 mb-1">
            <select name="month" id="month" class="form-control select2" data-toggle="select2" required>
              <option value=""><?php echo get_phrase('select_a_month'); ?></option>
              <?php
                $start_date = $this->db->get_where('internship', array('school_id' => school_id(), 'id' => $internship_id))->row('start_date');
                $end_date = $this->db->get_where('internship', array('school_id' => school_id(), 'id' => $internship_id))->row('end_date');
                $d1 = $start_date;
                $d2 = $end_date;

                // print_r($d1); die;

                while ($d1 <= $d2) {
              ?>
              <option value="<?php echo date('m', $d1); ?>"><?php echo get_phrase(date('F', $d1)); ?></option>
              <?php
                  $d1 = strtotime("+1 month", $d1);
                } 
              ?>
            </select>
          </div>
        <div class="col-md-2">
          <button class="btn btn-block btn-secondary" onclick="filter_attendance()" ><?php echo get_phrase('filter'); ?></button>
        </div>
        <!-- <div class="col-md-2 mb-1">
          <select name="section" id="section_id" class="form-control select2" data-toggle="select2" required onchange="sectionWiseClassroomsOnCreate(this.value)">
            <option value=""><?php echo get_phrase('select_section'); ?></option>
          </select>
        </div> -->
      </div>
      <!-- <div class="row mt-3 d-print-none">
        <div class="col-md-4 mb-1"></div>
          <div class="col-md-2 mb-1">
        <select name="room_id" id="room_id" class="form-control select2" data-toggle="select2" required>
            <option value=""><?php echo get_phrase('select_class_room'); ?></option>
          </select>
        </div> 
        <div class="col-md-2">
          <button class="btn btn-block btn-secondary" onclick="filter_attendance()" ><?php echo get_phrase('filter'); ?></button>
        </div>
      </div> -->
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
  initSelect2(['#company_id']);
});

function classWiseSection(classId) {
  $.ajax({
    url: "<?php echo route('section/list/'); ?>"+classId,
    success: function(response){
      $('#company_id').html(response);
    }
  });
}

function sectionWiseClassroomsOnCreate(sectionId) {
  $.ajax({
    url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
    success: function(response){
      $('#room_id').html(response);
    }
  });
}

function filter_attendance(){
  var internship_id = $('#internship_id').val();
  var month = $('#month').val();
  if(month != "" && internship_id != ""){
    getDailtyAttendance();
  }else{
    toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
  }
}

var getDailtyAttendance = function () {
  var internship_id = $('#internship_id').val();
  var month = $('#month').val();
  if(month != "" && internship_id != ""){
    $.ajax({
      type: 'POST',
      url: '<?php echo route('internship/attendance_filter') ?>',
      data: {month: month, internship_id: internship_id},
      success: function(response){
        $('.attendance_content').html(response);
        initDataTable('basic-datatable');
      }
    });
  }
}
</script>
