<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase('subject'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/subject/create'); ?>', '<?php echo get_phrase('create_subject'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_subject'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row mt-3">
            <div class="col-md-2"></div>
            <div class="col-md-2 mb-1">
                    <select name="session_id" id="session_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_session'); ?></option>
                        <?php
                        $sessions = $this->db->get_where('sessions')->result_array();
                        foreach($sessions as $session){
                            ?>
                            <option value="<?php echo $session['id']; ?>"><?php echo $session['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                    <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
                        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                        <?php
                        $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();?>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="section" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="sectionWiseClassroomsOnCreate(this.value)">
                        <option value=""><?php echo get_phrase('select_section'); ?></option>
                    </select>
                </div>
                <?php /*<div class="col-md-2 mb-1">
                    <select name="room_id" id="room_id" class="form-control select2" data-toggle = "select2" required>
                            <option value=""><?php echo get_phrase('select_class_rooms'); ?></option>
                    </select>
                </div>*/?>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_class()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="card-body subject_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>


<script>

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

function filter_class(){
    var class_id = $('#class_id').val();
    var section_id = $('#section_id').val();
    var room_id = $('#room_id').val();
    var session_id = $('#session_id').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('subject/filter/') ?>',
        data: {class_id : class_id, section_id : section_id, room_id : room_id, session_id : session_id},
        success: function(response){
            $('.subject_content').html(response);
        }
    });
}

var showAllSubjects = function () {
        $.ajax({
            url: '<?php echo route('subject/list/') ?>',
            success: function(response){
                $('.subject_content').html(response);
            }
        });
}
</script>
