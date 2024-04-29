<!--title-->
<div class="row d-print-none">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('daily_attendance'); ?>
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
          <div class="col-md-4 mb-1">
            <div id="reportrange" class="form-control" data-toggle="date-picker-range" data-target-display="#selectedValue"  data-cancel-class="btn-light">
              <i class="mdi mdi-calendar"></i>&nbsp;
              <span id="selectedValue"> <?php echo date('F d, Y', strtotime(' -30 day')).' - '.date('F d, Y'); ?> </span>
            </div>
          </div>
        <div class="col-md-2 mb-1">
          <select name="class" id="class_id" class="form-control select2" data-toggle="select2" onchange="classWiseSection(this.value)" required>
            <option value=""><?php echo get_phrase('select_a_class'); ?></option>
            <?php
            $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
            foreach($classes as $class){
              ?>
              <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="col-md-2 mb-1">
          <select name="section" id="section_id" class="form-control select2" data-toggle="select2" required onchange="sectionWiseClassroomsOnCreate(this.value)">
            <option value=""><?php echo get_phrase('select_section'); ?></option>
          </select>
        </div>
      </div>
      <div class="row mt-3 d-print-none">
        <div class="col-md-4 mb-1"></div>
        <div class="col-md-2 mb-1">
        <select name="room_id" id="room_id" class="form-control select2" data-toggle="select2" required>
            <option value=""><?php echo get_phrase('select_class_room'); ?></option>
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
  initSelect2(['#class_id', '#section_id', '#room_id']);
});

function classWiseSection(classId) {
  $.ajax({
    url: "<?php echo route('section/list/'); ?>"+classId,
    success: function(response){
      $('#section_id').html(response);
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
  var class_id = $('#class_id').val();
  var section_id = $('#section_id').val();
  var room_id = $('#room_id').val();
  if(class_id != "" && section_id != "" && room_id != ""){
    getDailtyAttendance();
  }else{
    toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
  }
}

var getDailtyAttendance = function () {
  var class_id = $('#class_id').val();
  var section_id = $('#section_id').val();
  if(class_id != "" && section_id != ""){
    $.ajax({
      type: 'POST',
      url: '<?php echo route('attendance_report/filter') ?>',
      data: {class_id : class_id, section_id : section_id, date : $('#selectedValue').text()},
      success: function(response){
        $('.attendance_content').html(response);
        initDataTable('basic-datatable');
      }
    });
  }
}
</script>
