<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row()->id;
?>
<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-format-list-numbered title_icon"></i> <?php echo get_phrase('student_raport'); ?>
        </h4>
      </div> <!-- end car~d body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row d-print-none">
        <div class="col-12">
            <div class="card ">
                <div class="row mt-3">
                    <div class="col-md-3 mb-1"></div>
                    <?php /* if($this->session->userdata('teacher_login') == 1): ?>
                        <div class="col-md-4 mb-1">
                            <select name="permission_id" id="permission_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_section'); ?></option>
                                <?php 
                                $permissions = $this->db->get_where('teacher_permissions', array('teacher_id' => $teacher_id, 'homeroom' => 1))->result_array();
                                foreach($permissions as $permission){
                                    $class_details = $this->crud_model->get_class_details_by_id($permission['class_id'])->row_array();
                                    $section_details = $this->crud_model->get_section_details_by_id('section', $permission['section_id'])->row_array();
                                    ?>
                                    <option value="<?php echo $permission['id']; ?>"><?php echo $class_details['name']; ?> - <?php echo $section_details['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php else: */?>
                        <div class="col-md-4 mb-1">
                            <select name="section_id" id="section_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_section'); ?></option>
                                <?php 
                                $sections = $this->db->get_where('sections', array('school_id' => school_id()))->result_array();
                                foreach($sections as $section){
                                    $class_details = $this->db->get_where('classes', array('id' => $section['class_id']))->row_array();
                                    ?>
                                    <option value="<?php echo $section['id']; ?>"><?php echo $class_details['name']; ?> <?php echo $section['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php /*endif;*/ ?>
                    <div class="col-md-2">
                        <button class="btn btn-block btn-secondary" onclick="filter_student()" ><?php echo get_phrase('filter'); ?></button>
                    </div>
                </div>
                <div class="card-body student_content">
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
  'use strict';
$('document').ready(function(){

});

function filter_student(){
    var section_id = $('#section_id').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('raport/filter/') ?>',
        data: {section_id : section_id},
        success: function(response){
            $('.student_content').html(response);
        }
    });
}

var showAllStudents = function() {
        $.ajax({
            url: '<?php echo route('raport/list/') ?>',
            success: function(response){
                $('.student_content').html(response);
            }
        });
}
</script>
