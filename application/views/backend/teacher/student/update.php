<!--title-->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
                <i class="mdi mdi-update title_icon"></i> <?php echo get_phrase('student_update_form'); ?>
            </h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card pt-0">
            <?php $school_id = school_id(); ?>
            <?php $student = $this->db->get_where('students', array('id' => $student_id))->row_array(); 
            // print_r($student);
            
            ?>
            <?php $users = $this->db->get_where('users', array('id' => $student['user_id']))->row_array();
            // print_r($users);
            ?>
            <?php $enroll = $this->db->get_where('enrols', array('student_id' => $student_id))->row_array(); 
            // print_r($enroll);
            ?>
            <h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('update_student_information'); ?></h4>
            <form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('student/updated/'.$student_id.'/'.$users['id']); ?>" id = "student_update_form" enctype="multipart/form-data">
                <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-6 ">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('nomor_un'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="nomor_un" name="nomor_un" value="<?php echo $student['nomor_un']; ?>" class="form-control" placeholder="<?php echo get_phrase('nomor_un'); ?>" required>
                        
                    </div> <!-- end col-->

                    <div class="col-lg-6 ">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('nisn'); ?> <font style="color:red;">*</font></h5>
                            <input type="number" id="nisn" name="nisn" value="<?php echo $student['nisn']; ?>" class="form-control" placeholder="nisn" required>
                        
                    </div> <!-- end col-->
                </div> <!-- end row -->

                <div class="row">
                    <div class="col-lg-6 ">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('nomor_ijazah'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" id="nomor_ijazah" name="nomor_ijazah" value="<?php echo $student['nomor_ijazah']; ?>" class="form-control" placeholder="<?php echo get_phrase('nomor_ijazah'); ?>" required>
                        
                    </div> <!-- end col-->

                    <div class="col-lg-6 ">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('nomor_skhun'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" id="nomor_skhun" name="nomor_skhun" value="<?php echo $student['nomor_skhun']; ?>" class="form-control" placeholder="<?php echo get_phrase('nomor_skhun'); ?>" required>
                        
                    </div> <!-- end col-->
                </div> <!-- end row -->

                <div class="row">
                    <div class="col-lg-12 ">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('school_before'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" id="school_before" name="school_before" value="<?php echo $student['school_before']; ?>" class="form-control" placeholder="<?php echo get_phrase('school_before'); ?>" required>
                        
                    </div> <!-- end col-->
                </div> <!-- end row --><br><br>


                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('basic_data'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="parent-tab" data-toggle="tab" href="#parent_info" role="tab" aria-controls="parent_info" aria-selected="false"><?php echo get_phrase('parent_data'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="guardian-tab" data-toggle="tab" href="#guardian_info" role="tab" aria-controls="guardian_info" aria-selected="false"><?php echo get_phrase('guardian_data'); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="akademik-tab" data-toggle="tab" href="#akademik_info" role="tab" aria-controls="akademik_info" aria-selected="false"><?php echo get_phrase('akademik_data'); ?></a>
                        </li> 
                        <li class="nav-item">
                            <a class="nav-link" id="periodik-tab" data-toggle="tab" href="#periodik_info" role="tab" aria-controls="periodik_info" aria-selected="false"><?php echo get_phrase('periodik_data'); ?></a>
                        </li>
                    </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <br>

                        <div class="row">
                            <div class="col-lg-4">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('nik'); ?> <font style="color:red;">*</font></h5>
                                    <input type="number" id="nik" name="nik" class="form-control" value="<?php echo $this->user_model->get_user_details($student['user_id'], 'nik'); ?>" required>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('gender'); ?> <font style="color:red;">*</font></h5>
                                    <select name="gender" id="gender" class="form-control select2"  data-toggle="select2" required>
                                        <option value=""><?php echo get_phrase('select_gender'); ?></option>
                                        <option value="Male" <?php if($this->user_model->get_user_details($student['user_id'], 'gender') == 'Male') echo 'selected'; ?>><?php echo get_phrase('male'); ?></option>
                                        <option value="Female" <?php if($this->user_model->get_user_details($student['user_id'], 'gender') == 'Female') echo 'selected'; ?>><?php echo get_phrase('female'); ?></option>
                                        <option value="Others" <?php if($this->user_model->get_user_details($student['user_id'], 'gender') == 'Others') echo 'selected'; ?>><?php echo get_phrase('others'); ?></option>
                                    </select>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('religion'); ?> <font style="color:red;">*</font></h5>
                                    <select name="religion" id="religion" class="form-control select2" data-toggle = "select2">
                                        <option value=""><?php echo get_phrase('select_a_religion'); ?></option>
                                        <option value="islam" <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'religion')) == 'islam') echo 'selected'; ?>><?php echo get_phrase('islam'); ?></option>
                                        <option value="katolik" <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'religion')) == 'katolik') echo 'selected'; ?>><?php echo get_phrase('katolik'); ?></option>
                                        <option value="hindu" <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'religion')) == 'hindu') echo 'selected'; ?>><?php echo get_phrase('hindu'); ?></option>
                                        <option value="buddha" <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'religion')) == 'buddha') echo 'selected'; ?>><?php echo get_phrase('buddha'); ?></option>
                                        <option value="khonghucu" <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'religion')) == 'khonghucu') echo 'selected'; ?>><?php echo get_phrase('khonghucu'); ?></option>
                                        <option value="protestan" <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'religion')) == 'protestan') echo 'selected'; ?>><?php echo get_phrase('protestan'); ?></option>
                                    </select>
                            </div> <!-- end col-->
                        </div> <!-- end row --><br>

                        <div class="row">
                            <div class="col-lg-4">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('birthday_place'); ?> <font style="color:red;">*</font></h5>
                                    <select name="birthday_place" id="birthday_place" class="form-control select2" data-toggle = "select2" required>
                                        <option value=""><?php echo get_phrase('select_birthday_place'); ?></option>
                                        <?php $districts = $this->db->get_where('district')->result_array(); ?>
                                        <?php foreach($districts as $district){ ?>
                                            <option value="<?php echo $district['id']; ?>" <?php if($this->user_model->get_user_details($student['user_id'], 'birthday_place') == $district['id']) echo 'selected'; ?>><?php echo $district['name']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('birthday'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" name = "birthday"  value="<?php echo date('m/d/Y', $this->user_model->get_user_details($student['user_id'], 'birthday')); ?>" required>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('phone'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo $this->user_model->get_user_details($student['user_id'], 'phone'); ?>" placeholder="phone" required>
                            </div> <!-- end col-->
                        </div> <!-- end row --><br>

                        <div class="row">
                            <div class="col-lg-6">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('name'); ?> <font style="color:red;">*</font></h5>
                                    <input type="text" id="name" name="name" value="<?php echo $this->user_model->get_user_details($student['user_id'], 'name'); ?>" class="form-control" placeholder="name" required>
                            </div> <!-- end col-->

                            <div class="col-lg-6">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('email'); ?> <font style="color:red;">*</font></h5>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $this->user_model->get_user_details($student['user_id'], 'email'); ?>" placeholder="email" required>
                            </div> <!-- end col-->
                        </div> <!-- end row --><br>

                        <div class="row">
                            <div class="col-lg-3">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('class'); ?> <font style="color:red;">*</font></h5>
                                    <select name="class_id" id="class_id" class="form-control select2"  data-toggle="select2" required onchange="classWiseSectionOnStudentEdit(this.value)">
                                        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                                        <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                                        <?php foreach($classes as $class){ ?>
                                            <option value="<?php echo $class['id']; ?>" <?php if($enroll['class_id'] == $class['id']) echo 'selected'; ?>><?php echo $class['name']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div> <!-- end col-->

                            <div class="col-lg-3">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('section'); ?> <font style="color:red;">*</font></h5>
                                    <select name="section_id" id="section_id" class="form-control select2"  data-toggle="select2" required >
                                        <option value=""><?php echo get_phrase('select_a_section'); ?></option>
                                        <?php $sections = $this->db->get_where('sections', array('class_id' => $enroll['class_id']))->result_array(); ?>
                                        <?php foreach($sections as $section){ ?>
                                            <option value="<?php echo $section['id']; ?>" <?php if($enroll['section_id'] == $section['id']) echo 'selected'; ?>><?php echo $section['name']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div> <!-- end col-->

                            <div class="col-lg-3">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('class_room'); ?> <font style="color:red;">*</font></h5>
                                    <select name="room_id" id="room_id" class="form-control select2"  data-toggle="select2" required>
                                        <option value=""><?php echo get_phrase('select_class_room'); ?></option>
                                        <?php $class_rooms = $this->db->get_where('class_rooms', array('school_id' => $school_id))->result_array(); ?>
                                        <?php foreach($class_rooms as $class_room){ ?>
                                            <option value="<?php echo $class_room['id']; ?>" <?php if($enroll['room_id'] == $class_room['id']) echo 'selected'; ?>><?php echo $class_room['name']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div> <!-- end col-->

                            <div class="col-lg-3">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('blood_group'); ?> <font style="color:red;">*</font></h5>
                                    <select name="blood_group" id="blood_group" class="form-control select2" data-toggle = "select2"  required>
                                        <option value=""><?php echo get_phrase('select_a_blood_group'); ?></option>
                                        <option value="a+"  <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'blood_group')) == 'a+') echo 'selected'; ?>>A+</option>
                                        <option value="a-"  <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'blood_group')) == 'a-') echo 'selected'; ?>>A-</option>
                                        <option value="b+"  <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'blood_group')) == 'b+') echo 'selected'; ?>>B+</option>
                                        <option value="b-"  <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'blood_group')) == 'b-') echo 'selected'; ?>>B-</option>
                                        <option value="ab+" <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'blood_group')) == 'ab+') echo 'selected'; ?>>AB+</option>
                                        <option value="ab-" <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'blood_group')) == 'ab-') echo 'selected'; ?>>AB-</option>
                                        <option value="o+"  <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'blood_group')) == 'o+') echo 'selected'; ?>>O+</option>
                                        <option value="o-"  <?php if(strtolower($this->user_model->get_user_details($student['user_id'], 'blood_group')) == '0-') echo 'selected'; ?>>O-</option>
                                    </select>
                            </div> <!-- end col-->
                        </div> <!-- end row --><br>

                        <div class="row">
                            <div class="col-lg-3">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('province'); ?> <font style="color:red;">*</font></h5>
                                    <select name="student_province_id" id="student_province_id" class="form-control select2" data-toggle = "select2" required onchange="districtWiseSection(this.value)">
                                        <option value=""><?php echo get_phrase('select_province'); ?></option>
                                        <?php $provinces = $this->db->get_where('province')->result_array(); ?>
                                        <?php foreach($provinces as $province){ ?>          
                                            <option value="<?php echo $province['id']; ?>" <?php if($this->user_model->get_user_details($student['user_id'], 'province_id') == $province['id']) echo 'selected'; ?>><?php echo $province['name']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div> <!-- end col-->

                            <div class="col-lg-3">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('district'); ?> <font style="color:red;">*</font></h5>
                                    <select name="student_district_id" id="district_id" class="form-control select2" data-toggle = "select2" required onchange="districtsWiseSection(this.value)">
                                        <option value=""><?php echo get_phrase('select_district'); ?></option>
                                        <?php $districts = $this->db->get_where('district', array('id' => $users['district_id']))->result_array(); ?>
                                        <?php foreach($districts as $district){ ?>
                                            <option value="<?php echo $district['id']; ?>" selected><?php echo $district['name']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div> <!-- end col-->

                            <div class="col-lg-3">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('districts'); ?> <font style="color:red;">*</font></h5>
                                    <select name="student_districts_id" id="districts_id" class="form-control select2" data-toggle = "select2" required onchange="wardWiseSection(this.value), postcodeWiseSection(this.value)">
                                        <option value=""><?php echo get_phrase('select_districts'); ?></option>
                                        <?php $districtss = $this->db->get_where('districts', array('id' => $users['districts_id']))->result_array(); ?>
                                        <?php foreach($districtss as $districts){ ?>
                                            <option value="<?php echo $districts['id']; ?>" selected><?php echo $districts['name']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div> <!-- end col-->

                            <div class="col-lg-3">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('ward'); ?> <font style="color:red;">*</font></h5>
                                    <select name="student_ward_id" id="ward_id" class="form-control select2" data-toggle = "select2" required>
                                        <option value=""><?php echo get_phrase('select_ward'); ?></option>
                                        <?php $wards = $this->db->get_where('ward', array('id' => $users['ward_id']))->result_array(); ?>
                                        <?php foreach($wards as $ward){ ?>
                                            <option value="<?php echo $ward['id']; ?>" selected><?php echo $ward['name']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div> <!-- end col-->
                        </div> <!-- end row --><br>

                        <div class="row">
                            <div class="col-lg-8">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('address'); ?> <font style="color:red;">*</font></h5>
                                <textarea class="form-control" id="example-textarea" rows="5" name = "address" placeholder="address"><?php echo $this->user_model->get_user_details($student['user_id'], 'address'); ?></textarea>
                            </div> <!-- end col-->

                            <div class="col-lg-4">
                                <h5 style="font-weight: bold;"> <?php echo get_phrase('postcode'); ?> <font style="color:red;">*</font></h5>
                                    <select name="student_postcode_id" id="postcode_id" class="form-control select2" data-toggle = "select2" required>
                                        <option value=""><?php echo get_phrase('select_postcode'); ?></option>
                                        <?php $postcodes = $this->db->get_where('postcode', array('postcode' => $users['post_code']))->result_array(); ?>
                                        <?php foreach($postcodes as $postcode){ ?>
                                            <option value="<?php echo $postcode['postcode']; ?>" <?php if($this->user_model->get_user_details($student['user_id'], 'post_code') == $postcode['postcode']) echo 'selected'; ?>><?php echo $postcode['postcode']; ?></option>
                                        <?php } ?>
                                    </select>
                            </div> <!-- end col-->
                        </div> <!-- end row --><br>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 style="font-weight: bold;"><?php echo get_phrase('student_profile_image'); ?></h5>
                                    <div class="col-md-9 custom-file-upload">
                                        <div class="wrapper-image-preview" style="margin-left: -6px;">
                                            <div class="box" style="width: 250px;">
                                            <div class="js--image-preview" style="background-image: url(<?php echo $this->user_model->get_user_image($student['user_id']); ?>); background-color: #F5F5F5;"></div>
                                                    <div class="upload-options">
                                                        <label for="student_image" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_an_image'); ?> </label>
                                                        <input id="student_image" style="visibility:hidden;" type="file" class="image-upload" name="student_image" accept="image/*">
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="parent_info" role="tabpanel" aria-labelledby="parent-tab"><br><br>
                        <h5 style="font-weight: bold;"><?php echo get_phrase('parent'); ?> <font style="color:red;">*</font></h5>
                        <div class="col-md-9">
                                <select id="parent_id" name="parent_id" class="form-control select2"  data-toggle="select2" required >
                                    <option value=""><?php echo get_phrase('select_a_parent'); ?></option>
                                    <?php $parents = $this->db->get_where('parents', array('school_id' => $school_id))->result_array(); ?>
                                    <?php foreach($parents as $parent): ?>
                                        <option value="<?php echo $parent['id']; ?>" <?php if($student['parent_id'] == $parent['id']) echo 'selected'; ?>><?php echo $this->user_model->get_user_details($parent['user_id'], 'name'); ?></option>
                                    <?php endforeach; ?>
                                </select>
                        </div>
                    </div>

                        <div class="tab-pane fade show" id="guardian_info" role="tabpanel" aria-labelledby="guardian-tab"><br><br>
                            <h5 style="font-weight: bold;"><?php echo get_phrase('guardian'); ?> <font style="color:red;">*</font></h5>
                            <div class="col-md-9">
                                    <select id="guardian_id" name="guardian_id" class="form-control select2"  data-toggle="select2" required >
                                        <option value=""><?php echo get_phrase('select_a_guardian'); ?></option>
                                        <?php $guardians = $this->db->get_where('guardians', array('school_id' => $school_id))->result_array(); ?>
                                        <?php foreach($guardians as $guardian): ?>
                                            <option value="<?php echo $guardian['id']; ?>" <?php if($student['guardian_id'] == $guardian['id']) echo 'selected'; ?>><?php echo $this->user_model->get_user_details($guardian['user_id'], 'name'); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="akademik_info" role="tabpanel" aria-labelledby="akademik-tab"><br><br>
                        <h5 style="font-weight: bold;"><?php echo get_phrase('upload_skhun'); ?> <font style="color:red;">*</font></h5>
                            <div class="col-md-9 custom-file-upload">
                                <input type="file" id="skhun" class="form-control" name="skhun" required>
                            </div><br><br><br>
                            
                        <h5 style="font-weight: bold;"><?php echo get_phrase('upload_ijazah'); ?> <font style="color:red;">*</font></h5>
                            <div class="col-md-9 custom-file-upload">
                                <input type="file" id="ijazah" class="form-control" name="ijazah" required>
                            </div><br><br><br>
                            
                        <h5 style="font-weight: bold;"><?php echo get_phrase('upload_rapor'); ?> <font style="color:red;">*</font></h5>
                            <div class="col-md-9 custom-file-upload">
                                <input type="file" id="rapor_semester" class="form-control" name="rapor_semester" required>
                            </div><br><br><br>
                            
                        <h5 style="font-weight: bold;"><?php echo get_phrase('sertifikat_lainnya'); ?></h5>
                            <div class="col-md-9 custom-file-upload">
                                <input type="file" id="sertifikat_lainnya" class="form-control" name="sertifikat_lainnya">
                            </div><br><br><br>
                            
                        <h5 style="font-weight: bold;"><?php echo get_phrase('dokumen_lainnya'); ?></h5>
                            <div class="col-md-9 custom-file-upload">
                                <input type="file" id="dokumen_lainnya" class="form-control" name="dokumen_lainnya">
                            </div>
                    </div>

                    <div class="tab-pane fade show" id="periodik_info" role="tabpanel" aria-labelledby="periodik-tab">
                    <div class="row">
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('weight'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="weight" name="weight" class="form-control" value="<?php echo $student['weight']; ?>" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('height'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="height" name="height" class="form-control" value="<?php echo $student['height']; ?>" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">    
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('mileage'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="mileage" name="mileage" class="form-control" value="<?php echo $student['mileage']; ?>" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">        
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('traveling_time'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="traveling_time" name="traveling_time" class="form-control" value="<?php echo $student['traveling_time']; ?>" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('child_of'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="child_of" name="child_of" class="form-control" value="<?php echo $student['child_of']; ?>" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('number_of_siblings'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="number_of_siblings" name="number_of_siblings" class="form-control" value="<?php echo $student['number_of_siblings']; ?>" required>
                            </div><br><br>
                    </div>
                    </div>

                    </div>

                    
                    <br><br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4"><?php echo get_phrase('update_student_information'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function districtWiseSection(province_id) {
    $.ajax({
        url: "<?php echo route('district_dropdown/dropdown/'); ?>"+province_id,
        success: function(response){
            $('#district_id').html(response);
            districtsWiseSection(district_id);
        }
    });
}

function districtsWiseSection(district_id) {
    $.ajax({
        url: "<?php echo route('districts_dropdown/dropdown/'); ?>"+district_id,
        success: function(response){
            $('#districts_id').html(response);
            wardWiseSection(districts_id);
            postcodeWiseSection(districts_id);
        }
    });
}

function wardWiseSection(districts_id) {
    $.ajax({
        url: "<?php echo route('ward_dropdown/dropdown/'); ?>"+districts_id,
        success: function(response){
            $('#ward_id').html(response);
        }
    });
}

function postcodeWiseSection(districts_id) {
    $.ajax({
        url: "<?php echo route('postcode_dropdown/dropdown/'); ?>"+districts_id,
        success: function(response){
            $('#postcode_id').html(response);
        }
    });
}

var form;
$(".ajaxForm").submit(function(e) {
    form = $(this);
    ajaxSubmit(e, form, refreshForm);
});
var refreshForm = function () {

}

$(document).ready(function(){
    initCustomFileUploader();
});

function classWiseSectionOnStudentEdit(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}
</script>
<script>
var showAllParents = function () {
  var url = '<?php echo route('parent/list'); ?>';

  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.parent_content').html(response);
    }
  });
}
</script>
