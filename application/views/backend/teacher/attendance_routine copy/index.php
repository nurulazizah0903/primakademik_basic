<!--title-->
<div class="row d-print-none">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('daily_attendance_routine'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/attendance_routine/confirm_all'); ?>', '<?php echo get_phrase('attendance_confirm'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('attendance_confirm'); ?></button>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/attendance_routine/take_attendance_routine'); ?>', '<?php echo get_phrase('take_attendance_routine'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('take_attendance_routine'); ?></button>
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
          <select name="section" id="section_id" class="form-control select2" data-toggle="select2" required onchange="classWiseSubject(this.value), sectionWiseClassroomsOnCreate(this.value)">
            <option value=""><?php echo get_phrase('select_section'); ?></option>
          </select>
        </div>
          </div>
        <div class="row mt-3 d-print-none">
        <div class="col-md-3 mb-1"></div>
       
        <div class="col-md-2 mb-1">
            <select name="subject_id" id = "subject_id" class="form-control select2" data-toggle="select2"  required>
                <option value=""><?php echo get_phrase('select_subject'); ?></option>
            </select>
        </div>
        <div class="col-md-2 mb-1">
          <select name="room_id" id="room_id" class="form-control select2" data-toggle="select2" required>
            <option value=""><?php echo get_phrase('select_class_room'); ?></option>
          </select>
        </div>
        <div class="col-md-2">
          <button class="btn btn-block btn-secondary" onclick="filter_attendance_routine()" ><?php echo get_phrase('filter'); ?></button>
        </div>
      </div>
      <div class="card-body attendance_routine_content">
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
  initSelect2(['#month', '#year', '#class_id', '#section_id', '#subject_id', '#room_id']);
});

function classWiseSection(classId) {
  $.ajax({
    url: "<?php echo route('section/list/'); ?>"+classId,
    success: function(response){
      $('#section_id').html(response);
      classWiseSubject(classId);
    }
  });
}

function classWiseSubject(classId) {
    $.ajax({
        url: "<?php echo route('class_wise_subject/'); ?>"+classId,
        success: function(response){
            $('#subject_id').html(response);
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

function filter_attendance_routine(){
  var month = $('#month').val();
  var year = $('#year').val();
  var class_id = $('#class_id').val();
  var section_id = $('#section_id').val();
  var subject_id = $('#subject_id').val();
  if(class_id != "" && section_id != "" && month != "" && year != "" && subject_id != ""){
    getDailtyAttendanceRoutine();
  }else{
    toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
  }
}

var getDailtyAttendanceRoutine = function () {
  var month = $('#month').val();
  var year = $('#year').val();
  var class_id = $('#class_id').val();
  var section_id = $('#section_id').val();
  var subject_id = $('#subject_id').val();
  if(class_id != "" && section_id != "" && month != "" && year != "" && subject_id != ""){
    $.ajax({
      type: 'POST',
      url: '<?php echo route('attendance_routine/filter') ?>',
      data: {month : month, year : year, class_id : class_id, section_id : section_id, subject_id : subject_id},
      success: function(response){
        $('.attendance_routine_content').html(response);
        initDataTable('basic-datatable');
      }
    });
  }
}
</script>
