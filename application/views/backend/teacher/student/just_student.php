<?php $school_id = school_id(); ?>

<form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('student/just_student'); ?>" id = "student_admission_form" enctype="multipart/form-data">
    <div class="col-md-12">
        <div class="row">
            <div class="col-lg-6 ">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('nomor_un'); ?> <font style="color:red;">*</font></h5>
                        <input type="text" id="nomor_un" name="nomor_un" class="form-control" placeholder="<?php echo get_phrase('nomor_un'); ?>" required>
                
            </div> <!-- end col-->

            <div class="col-lg-6 ">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('nisn'); ?> <font style="color:red;">*</font></h5>
                    <input type="number" id="nisn" name="nisn" class="form-control" placeholder="nisn" required>
                
            </div> <!-- end col-->
        </div> <!-- end row -->

        <div class="row">
            <div class="col-lg-6 ">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('nomor_ijazah'); ?> <font style="color:red;">*</font></h5>
                    <input type="text" id="nomor_ijazah" name="nomor_ijazah" class="form-control" placeholder="<?php echo get_phrase('nomor_ijazah'); ?>" required>
                
            </div> <!-- end col-->

            <div class="col-lg-6 ">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('nomor_skhun'); ?> <font style="color:red;">*</font></h5>
                    <input type="text" id="nomor_skhun" name="nomor_skhun" class="form-control" placeholder="<?php echo get_phrase('nomor_skhun'); ?>" required>
                
            </div> <!-- end col-->
        </div> <!-- end row -->

        <div class="row">
            <div class="col-lg-12 ">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('school_before'); ?> <font style="color:red;">*</font></h5>
                    <input type="text" id="school_before" name="school_before" class="form-control" placeholder="<?php echo get_phrase('school_before'); ?>" required>
                
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
                            <input type="number" id="nik" name="nik" class="form-control"  placeholder="<?php echo get_phrase('nik'); ?>" required>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('gender'); ?> <font style="color:red;">*</font></h5>
                            <select name="gender" id="gender" class="form-control select2" data-toggle = "select2"  required>
                                <option value=""><?php echo get_phrase('select_gender'); ?></option>
                                <option value="Male"><?php echo get_phrase('male'); ?></option>
                                <option value="Female"><?php echo get_phrase('female'); ?></option>
                                <option value="Others"><?php echo get_phrase('others'); ?></option>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('religion'); ?> <font style="color:red;">*</font></h5>
                            <select name="religion" id="religion" class="form-control select2" data-toggle = "select2">
                            <option value=""><?php echo get_phrase('select_a_religion'); ?></option>
                            <option value="islam"><?php echo get_phrase('islam'); ?></option>
                            <option value="katolik"><?php echo get_phrase('katolik'); ?></option>
                            <option value="hindu"><?php echo get_phrase('hindu'); ?></option>
                            <option value="buddha"><?php echo get_phrase('buddha'); ?></option>
                            <option value="khonghucu"><?php echo get_phrase('khonghucu'); ?></option>
                            <option value="protestan"><?php echo get_phrase('protestan'); ?></option>
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
                                        <option value="<?php echo $district['id']; ?>"><?php echo $district['name']; ?></option>
                                    <?php } ?>
                                </select> 
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('birthday'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" name = "birthday"   value="<?php echo date('m/d/Y'); ?>" required>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('phone'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="phone" required>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('name'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" id="name" name="name" class="form-control" placeholder="name" required>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('email'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" class="form-control" id="email" name="email" placeholder="email" required>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('password'); ?> <font style="color:red;">*</font></h5>
                            <input type="password" class="form-control" id="password" name="password" placeholder="password" required>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('class'); ?> <font style="color:red;">*</font></h5>
                            <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" required onchange="classWiseSection(this.value)">
                                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                                <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                                <?php foreach($classes as $class){ ?>
                                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                                <?php } ?>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('section'); ?> <font style="color:red;">*</font></h5>
                            <select name="section_id" id="section_id" class="form-control select2" data-toggle = "select2" required >
                                <option value=""><?php echo get_phrase('select_section'); ?></option>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('blood_group'); ?> <font style="color:red;">*</font></h5>
                            <select name="blood_group" id="blood_group" class="form-control select2" data-toggle = "select2"  required>
                                <option value=""><?php echo get_phrase('select_a_blood_group'); ?></option>
                                <option value="a+">A+</option>
                                <option value="a-">A-</option>
                                <option value="b+">B+</option>
                                <option value="b-">B-</option>
                                <option value="ab+">AB+</option>
                                <option value="ab-">AB-</option>
                                <option value="o+">O+</option>
                                <option value="o-">O-</option>
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
                                        <option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('district'); ?> <font style="color:red;">*</font></h5>
                            <select name="student_district_id" id="district_id" class="form-control select2" data-toggle = "select2" required onchange="districtsWiseSection(this.value)">
                                <option value=""><?php echo get_phrase('select_district'); ?></option>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('districts'); ?> <font style="color:red;">*</font></h5>
                            <select name="student_districts_id" id="districts_id" class="form-control select2" data-toggle = "select2" required onchange="wardWiseSection(this.value), postcodeWiseSection(this.value)">
                                <option value=""><?php echo get_phrase('select_districts'); ?></option>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('ward'); ?> <font style="color:red;">*</font></h5>
                            <select name="student_ward_id" id="ward_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_ward'); ?></option>
                            </select>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>
                
                <div class="row">
                    <div class="col-lg-8">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('address'); ?> <font style="color:red;">*</font></h5>
                            <textarea class="form-control" id="example-textarea" rows="5" name = "address" placeholder="address"></textarea>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('postcode'); ?> <font style="color:red;">*</font></h5>
                            <select name="student_postcode_id" id="postcode_id" class="form-control select2" data-toggle = "select2" required>
                                    <option value=""><?php echo get_phrase('select_postcode'); ?></option>
                                </select>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-12">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('student_profile_image'); ?></h5>
                            <div class="col-md-9 custom-file-upload">
                                <div class="wrapper-image-preview" style="margin-left: -6px;">
                                    <div class="box" style="width: 250px;">
                                        <div class="js--image-preview" style="background-image: url(<?php echo base_url('uploads/users/placeholder.jpg'); ?>); background-color: #F5F5F5;"></div>
                                            <div class="upload-options">
                                                <label for="student_image" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_an_image'); ?> </label>
                                                <input id="student_image" style="visibility:hidden;" type="file" class="image-upload" name="student_image" accept="image/*">
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <!-- <div class="row">
                        <div class="col-lg-6">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="nomor_kip"><?php echo get_phrase('nomor_kip'); ?></label>
                            <div class="col-md-9">
                                <input type="text" id="nomor_kip" name="nomor_kip" class="form-control" placeholder="<?php echo get_phrase('nomor_kip'); ?>">
                            </div>
                        </div>
                        </div>
                        </div> -->
        
                            
                </div>
                    <div class="tab-pane fade show" id="parent_info" role="tabpanel" aria-labelledby="parent-tab"><br><br>
                        <h5 style="font-weight: bold;"><?php echo get_phrase('parent'); ?> <font style="color:red;">*</font></h5>
                        <div class="col-md-9">
                            <select id="parent_id" name="parent_id" class="form-control select2" data-toggle = "select2"  required >
                                <option value=""><?php echo get_phrase('select_a_parent'); ?></option>
                                <?php $parents = $this->db->get_where('parents', array('school_id' => $school_id))->result_array(); ?>
                                <?php foreach($parents as $parent): ?>
                                    <option value="<?php echo $parent['id']; ?>"><?php echo $this->user_model->get_user_details($parent['user_id'], 'name'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="tab-pane fade show" id="guardian_info" role="tabpanel" aria-labelledby="guardian-tab"><br><br>
                        <h5 style="font-weight: bold;"><?php echo get_phrase('guardian'); ?> <font style="color:red;">*</font></h5>
                        <div class="col-md-9">
                            <select id="guardian_id" name="guardian_id" class="form-control select2" data-toggle = "select2"  required >
                                <option value=""><?php echo get_phrase('select_a_guardian'); ?></option>
                                <?php $guardians = $this->db->get_where('guardians', array('school_id' => $school_id))->result_array(); ?>
                                <?php foreach($guardians as $guardian): ?>
                                    <option value="<?php echo $guardian['id']; ?>"><?php echo $this->user_model->get_user_details($guardian['user_id'], 'name'); ?></option>
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
                            </div><br><br>
                    </div><br><br>

                    <div class="tab-pane fade show" id="periodik_info" role="tabpanel" aria-labelledby="periodik-tab">
                    <div class="row">
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('weight'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="weight" name="weight" class="form-control" placeholder="kg" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('height'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="height" name="height" class="form-control" placeholder="cm" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">    
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('mileage'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="mileage" name="mileage" class="form-control" placeholder="mileage" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">        
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('traveling_time'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="traveling_time" name="traveling_time" class="form-control" placeholder="traveling_time" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('child_of'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="child_of" name="child_of" class="form-control" placeholder="child_of" required>
                            </div><br><br><br>
                    </div>
                    <div class="row">
                    <div class="col-lg-9">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('number_of_siblings'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="number_of_siblings" name="number_of_siblings" class="form-control" placeholder="number_of_siblings" required>
                            </div><br><br>
                    </div>
                    </div><br><br>

        </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4"><?php echo get_phrase('add_student'); ?></button>
                </div>
    </div>
</form>

<script type="text/javascript">

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
            wardWiseSection(districts_id),
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

$(document).ready(function(){
    initCustomFileUploader();
});

var form;
$(".ajaxForm").submit(function(e) {
  form = $(this);
  ajaxSubmit(e, form, refreshForm);
});
var refreshForm = function () {
    form.trigger("reset");
}
</script>
