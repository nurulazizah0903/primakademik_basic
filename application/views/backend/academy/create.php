<?php
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row_array()['id'];
?>
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('add_new_course'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <h4 class="header-title mb-3"><?php echo get_phrase('course_adding_form'); ?>
                    <a href="<?php echo site_url('addons/courses'); ?>" class="alignToTitle btn btn-outline-secondary btn-rounded btn-sm"> <i class=" mdi mdi-keyboard-backspace"></i> <?php echo get_phrase('back_to_course_list'); ?></a>
                </h4>

                <div class="row">
                    <div class="col-xl-12">
                        <form class="required-form" action="<?php echo site_url('addons/courses/index/create'); ?>" method="post" enctype="multipart/form-data">
                            <div id="basicwizard">

                                <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                    <li class="nav-item">
                                        <a href="#basic" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-fountain-pen-tip mr-1"></i>
                                            <span class="d-none d-sm-inline"><?php echo get_phrase('basic'); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#academic" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class=" mdi mdi-ballot-outline mr-1"></i>
                                            <span class="d-none d-sm-inline"><?php echo get_phrase('academic'); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#outcomes" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-camera-control mr-1"></i>
                                            <span class="d-none d-sm-inline"><?php echo get_phrase('tujuan_pembelajaran'); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#media" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-library-video mr-1"></i>
                                            <span class="d-none d-sm-inline"><?php echo get_phrase('media'); ?></span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#finish" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                            <span class="d-none d-sm-inline"><?php echo get_phrase('finish'); ?></span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content b-0 mb-0">
                                    <div class="tab-pane" id="basic">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-8">
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="course_title"><?php echo get_phrase('nama_materi'); ?> <span class="required">*</span> </label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" id="course_title" name = "title" placeholder="<?php echo get_phrase('enter_course_title'); ?>" required>
                                                    </div>
                                                </div>

                                                
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="description"><?php echo get_phrase('description'); ?> *</label>
                                                    <div class="col-md-10">
                                                        <textarea name="description" rows="5" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div> <!-- end tab pane -->

                                    <div class="tab-pane" id="academic">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-8">
                                                <?php if($this->session->userdata('teacher_login') == 1): ?>
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="subject_id"><?php echo get_phrase('subject'); ?><span class="required">*</span></label>
                                                    <div class="col-md-10">
                                                        <select class="form-control select2" data-toggle="select2" name="subject_id" id="subject_id" required>
                                                            <option value=""><?php echo get_phrase('select_subject'); ?></option>
                                                            <?php
                                                            $subjects = $this->db->get_where('subjects', array('school_id' => school_id(), 'teacher_id' => $teacher_id))->result_array();
                                                            foreach($subjects as $subject){
                                                                $class_details = $this->crud_model->get_classes($subject['class_id'])->row_array();
                                                                $section_details = $this->crud_model->get_sections($subject['section_id'])->row_array();
                                                            ?>
                                                                <option value="<?php echo $subject['id']; ?>">(<?php echo $class_details['name']; ?> <?php echo $section_details['name']; ?>)  <?php echo $subject['name']; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                    <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                                                <?php else: ?>
                                                    <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="subject_id"><?php echo get_phrase('subject'); ?><span class="required">*</span></label>
                                                    <div class="col-md-10">
                                                        <select class="form-control select2" data-toggle="select2" onchange="get_section()" name="subject_id" id="subject_id" required>
                                                            <option value=""><?php echo get_phrase('select_subject'); ?></option>
                                                            <?php foreach ($subejcts->result_array() as $mapel): 
                                                                $section_details = $this->crud_model->get_sections($mapel['section_id'])->row_array();
                                                                $class_details = $this->crud_model->get_classes($mapel['class_id'])->row_array();
                                                            ?>
                                                                <option value="<?php echo $mapel['id']; ?>"><?php echo $class_details['name']; ?> <?php echo $section_details['name'];?> - <?php echo $mapel['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php /* 
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="section_id"><?php echo get_phrase('section'); ?><span class="required">*</span></label>
                                                    <div class="col-md-10">
                                                        <select class="form-control select2" data-toggle="select2" name="section_id" id="section_id" onchange="get_subject_section(), sectionWiseClassroomsOnCreate(this.value)" required>
                                                            <option value=""><?php echo get_phrase('select_section'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="subject_id"><?php echo get_phrase('subject'); ?><span class="required">*</span></label>
                                                    <div class="col-md-10">
                                                        <select class="form-control select2" data-toggle="select2" name="subject_id" id="subject_id" required>
                                                            <option value=""><?php echo get_phrase('select_subject'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="user_id"><?php echo get_phrase('pengajar'); ?><span class="required">*</span></label>
                                                    <div class="col-md-10">
                                                        <select class="form-control select2" data-toggle="select2" name="user_id" id="user_id" required>
                                                            <option value=""><?php echo get_phrase('pilih_pengajar'); ?></option>
                                                            <?php foreach ($all_teachers->result_array() as $teacher): ?>
                                                                <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div> */?>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="outcomes">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-8">
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="outcomes_desc"><?php echo get_phrase('tujuan_pembelajaran'); ?> *</label>
                                                    <div class="col-md-10">
                                                        <textarea name="outcomes" rows="5" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <div class="tab-pane" id="media">
                                        <div class="row justify-content-center">

                                            <!-- <div class="col-xl-8">
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="course_overview_provider"><?php echo get_phrase('course_overview_provider'); ?></label>
                                                    <div class="col-md-10">
                                                        <select class="form-control select2" data-toggle="select2" name="course_overview_provider" id="course_overview_provider">
                                                            <option value="youtube"><?php echo get_phrase('youtube'); ?></option>
                                                            <option value="vimeo"><?php echo get_phrase('vimeo'); ?></option>
                                                            <option value="html5"><?php echo get_phrase('HTML5'); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-8">
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="course_overview_url"><?php echo get_phrase('course_overview_url'); ?></label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" name="course_overview_url" id="course_overview_url" placeholder="E.g: https://www.youtube.com/watch?v=oBtf8Yglw2w" required>
                                                    </div>
                                                </div>
                                            </div>  -->

                                            <div class="col-xl-8">
                                                <div class="form-group row mb-3">
                                                <label class="col-md-2 col-form-label" for="course_thumbnail' ?>"><?php echo get_phrase('cover_materi'); ?></label>
                                                <div class="col-md-10">
                                                    <!-- <input type="file" class="image-upload" id="course_thumbnail vb-hidden" name = "course_thumbnail" accept="image/*"> -->
                                                    <div class="wrapper-image-preview ml--6">
                                                        <div class="box w-250">
                                                            <div class="js--image-preview bg-F5F5F5" style="background-image: url(<?php echo base_url('uploads/course_thumbnail/placeholder.png'); ?>);"></div>
                                                          <div class="upload-options">
                                                            <label for="course_thumbnail" class="btn pb-1"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('course_thumbnail'); ?> <br> <small>(800 X 530)</small> </label>
                                                            <!-- <input id="course_thumbnail" type="file" class="image-upload" name="course_thumbnail" accept="image/*"> -->
                                                            <input id="course_thumbnail" style="visibility:hidden;" type="file" class="image-upload" name="course_thumbnail" accept="image/*">
                                                          </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>

                                        </div> <!-- end row -->
                                    </div>
                                    
                                    <div class="tab-pane" id="finish">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h2 class="mt-0"><i class="mdi mdi-check-all"></i></h2>
                                                    <h3 class="mt-0"><?php echo get_phrase("thank_you"); ?> !</h3>

                                                    <p class="w-75 mb-2 mx-auto"><?php echo get_phrase('you_are_just_one_click_away'); ?></p>

                                                    <div class="mb-3 mt-3">
                                                        <button type="button" class="btn btn-primary text-center" onclick="checkRequiredFields()"><?php echo get_phrase('submit'); ?></button>
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>

                                    <ul class="list-inline mb-0 wizard text-center">
                                        <li class="previous list-inline-item">
                                            <a href="javascript::" class="btn btn-info"> <i class="mdi mdi-arrow-left-bold"></i> </a>
                                        </li>
                                        <li class="next list-inline-item">
                                            <a href="javascript::" class="btn btn-info"> <i class="mdi mdi-arrow-right-bold"></i> </a>
                                        </li>
                                    </ul>

                                </div> <!-- tab-content -->
                            </div> <!-- end #progressbarwizard-->
                        </form>
                    </div>
                </div><!-- end row-->
            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>
<?php include 'common_scripts.php'; ?>
<style media="screen">
    body {
      overflow-x: hidden;
    }
</style>