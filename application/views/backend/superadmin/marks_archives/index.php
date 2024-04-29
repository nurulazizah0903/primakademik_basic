<!--title-->
<div class="row d-print-none">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-format-list-numbered title_icon"></i> <?php echo get_phrase('marks_archives'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row mt-3 d-print-none">
            <div class="col-md-1 mb-1"></div>
                <div class="col-md-2 mb-1"> 
                    <select name="session" id="session" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_a_session'); ?></option>
                        <?php 
                        $sessions = $this->db->get_where('sessions')->result_array();
                        foreach($sessions as $session){ ?>
                            <option value="<?php echo $session['id']; ?>"><?php echo $session['name'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                    <select name="semester_id" id="semester_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_a_semester'); ?></option>
                        <?php $school_id = school_id();
                        $semesters = $this->db->get_where('semester')->result_array();
                        foreach($semesters as $semester){ ?>
                            <option value="<?php echo $semester['id']; ?>"><?php echo $semester['name'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                    <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
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
                    <select name="section_id" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseStudent(this.value)">
                        <option value=""><?php echo get_phrase('select_section'); ?></option>
                    </select>
                </div>
                    <div class="col-md-2 mb-1" id = "student_content">
                        <select name="student_id" id="student_id" class="form-control select2" data-toggle="select2" required >
                            <option value=""><?php echo get_phrase('select_a_student'); ?></option>
                        </select>
                    </div>
            </div>
            <div class="row mt-3 d-print-none">
            <div class="col-md-3 mb-1"></div>
            <div class="col-md-6">
                    <button class="btn btn-block btn-secondary" onclick="filter_attendance()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="card-body mark_content">
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
    initSelect2(['#session', '#semester_id','#student_id','#section_id','#class_id']);
});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
            classWiseStudent(classId);
        }
    });
}

function classWiseStudent(classId) {
  $.ajax({
    url: "<?php echo route('marks_archives/student/'); ?>"+classId,
    success: function(response){
      $('#student_id').html(response);
    }
  });
}

function filter_attendance(){
    var session = $('#session').val();
    var semester_id = $('#semester_id').val();
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var student_id = $('#student_id').val();
    if(class_id != "" && section_id != "" && student_id != "" && session != "" && semester_id != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('marks_archives/list') ?>',
            data: {class_id : class_id, section_id : section_id, student_id : student_id, semester_id : semester_id, session : session},
            success: function(response){
                $('.mark_content').html(response);
            }
        });
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
    }
}
</script>
