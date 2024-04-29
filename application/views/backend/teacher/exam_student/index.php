<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase('exam_student'); ?>
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/exam_student/create'); ?>', '<?php echo get_phrase('create_exam'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_exam'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link <?php if($exam_type =='published') echo 'active'; ?>" href="<?php echo site_url('addons/exam/student_exam/published'); ?>"><i class="dripicons-cloud-upload"></i> <?php echo get_phrase('published_exam'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($exam_type =='pending') echo 'active'; ?>" href="<?php echo site_url('addons/exam/student_exam/pending'); ?>"><i class="mdi mdi-folder-outline"></i> <?php echo get_phrase('draft_exam'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if($exam_type =='expired') echo 'active'; ?>" href="<?php echo site_url('addons/exam/student_exam/expired'); ?>"><i class=" mdi mdi-folder-clock-outline"></i> <?php echo get_phrase('tenggat_waktu'); ?></a>
                    </li>
                </ul>
                <form class="mb-3 mt-4 pt-3" action="javascript:void(0)" method="get">
                    <div class="row justify-content-center">
                        <!-- Course subject -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2" data-toggle = "select2" id="selected_class_id" name="class_id" onchange="select_section(this.value)">
                                    <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                                    <?php $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array(); ?>
                                    <?php foreach($classes as $class): ?>
                                        <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2" data-toggle = "select2" id="selected_section_id" name="section_id" onchange="select_subject(this.value), sectionWiseClassroomsOnCreate(this.value)">
                                    <option value=""><?php echo get_phrase('select_a_section'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2" data-toggle = "select2" id="selected_room_id" name="room_id">
                                    <option value=""><?php echo get_phrase('select_class_room'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select class="form-control select2" data-toggle = "select2" id="selected_subject_id" name="subject_id">
                                    <option value=""><?php echo get_phrase('select_a_subject'); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary btn-block" onclick="filterExam()" name="button"><?php echo get_phrase('filter'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body table-responsive exam_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'common_script.php'; ?>

<script>
    'use strict';

    function filterExam(){
        var class_id = $('#selected_class_id').val();
        var section_id = $('#selected_section_id').val();
        var subject_id = $('#selected_subject_id').val();
        var room_id = $('#selected_room_id').val();
        $.ajax({
            type : 'post',
            url: '<?php echo site_url('addons/exam/filter_student_exam/'.$exam_type); ?>',
            data: {class_id : class_id, section_id : section_id, room_id : room_id, subject_id : subject_id},
            success : function(response) {
                $('.exam_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
</script>
