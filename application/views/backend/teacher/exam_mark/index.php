<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row()->id;
?>
<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-format-list-numbered title_icon"> </i> <?php echo get_phrase('exam_mark'); ?>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
          <div class="row mt-3">
              <div class="col-md-2 mb-1"></div>
                <div class="col-md-4 mb-1">
                    <select name="subject" id="subject_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_subject'); ?></option>
                        <?php
                        $subjects = $this->db->get_where('subjects', array('school_id' => school_id(), 'teacher_id' => $teacher_id))->result_array();
                        foreach($subjects as $subject){
                            $class_details = $this->crud_model->get_class_details_by_id($subject['class_id'])->row_array();
                            $section_details = $this->crud_model->get_section_details_by_id('section', $subject['section_id'])->row_array();
                        ?>
                            <option value="<?php echo $subject['id']; ?>">(<?php echo $class_details['name']; ?> - <?php echo $section_details['name']; ?>)  <?php echo $subject['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                    <select name="exam_type_id" id="exam_type_id" class="form-control select2" data-toggle = "select2" required>
                        <option value=""><?php echo get_phrase('select_exam'); ?></option>
                        <?php
                        $exam_types = $this->db->get_where('exam_types', array('school_id' => school_id()))->result_array();
                        foreach($exam_types as $exam_type){
                            ?>
                            <option value="<?php echo $exam_type['id']; ?>"><?php echo $exam_type['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 mb-1">
                      <button class="btn btn-block btn-secondary" onclick="filter_exam_mark()" ><?php echo get_phrase('filter'); ?></button>
                  </div>
            </div>
            <div class="card-body exam_mark_content">
              <div class="empty_box">
                <img class="mb-3" width="150px" src="<?php echo base_url('assets/backend/images/empty_box.png'); ?>" />
                <br>
                <span class=""><?php echo get_phrase('no_data_found'); ?></span>
              </div>  
            </div>
        </div>
    </div>
</div>

<!-- modyfy section -->
<script>
  function classWiseSubject(classId) {
    $.ajax({
        url: "<?php echo route('class_wise_subject/'); ?>"+classId,
        success: function(response){
            $('#subject_id').html(response);
        }
    });
  }

    var showAllExamMarks = function () {
        var url = '<?php echo route('exam_mark/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.exam_mark_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }

    function filter_exam_mark(){
        var subject_id = $('#subject_id').val();
        var exam_type_id = $('#exam_type_id').val();
        if(subject_id != "" && exam_type_id != ""){
            $.ajax({
                type: 'POST',
                url: '<?php echo route('exam_mark/list') ?>',
                data: {subject_id : subject_id, exam_type_id : exam_type_id},
                success: function(response){
                    $('.exam_mark_content').html(response);
                }
            });
        }else{
            toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
        }
    }
</script>