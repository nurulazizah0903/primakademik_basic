<?php
$profile_data = $this->user_model->get_profile_data();
$job = $this->db->get_where('job_management', array('user_id' => $profile_data['id']))->result_array();
$job_teacher = $this->db->get_where('job_management', array('user_id' => $profile_data['id'], 'status' => 1))->row_array();
?>
<div class="row justify-content-md-center">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><?php echo get_phrase('update_profile') ; ?></h4>
                <form method="POST" class="col-12 profileAjaxForm" action="<?php echo route('profile/update_profile') ; ?>" id = "profileAjaxForm" enctype="multipart/form-data">
                    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('basic_data'); ?></a>
                </li>
            </ul>

            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <br>
                <div class="row">
                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('nik'); ?> <font style="color:red;">*</font></h5>
                            <input type="number" id="nik" name="nik" class="form-control"  value="<?= $profile_data['nik'] ?>" required>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('gender'); ?> <font style="color:red;">*</font></h5>
                            <select name="gender" id="gender" class="form-control select2" data-toggle = "select2"  required>
                                <option value=""><?php echo get_phrase('select_gender'); ?></option>
                                <option value="Male" <?php if($profile_data['gender'] == 'Male') echo 'selected'; ?>><?php echo get_phrase('male'); ?></option>
                                <option value="Female" <?php if($profile_data['gender'] == 'Female') echo 'selected'; ?>><?php echo get_phrase('female'); ?></option>
                                <option value="Others" <?php if($profile_data['gender'] == 'Others') echo 'selected'; ?>><?php echo get_phrase('others'); ?></option>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('religion'); ?> <font style="color:red;">*</font></h5>
                            <select name="religion" id="religion" class="form-control select2" data-toggle = "select2">
                            <option value=""><?php echo get_phrase('select_a_religion'); ?></option>
                            <option value="islam" <?php if($profile_data['religion'] == 'islam') echo 'selected'; ?>><?php echo get_phrase('islam'); ?></option>
                            <option value="katolik" <?php if($profile_data['religion'] == 'katolik') echo 'selected'; ?>><?php echo get_phrase('katolik'); ?></option>
                            <option value="hindu" <?php if($profile_data['religion'] == 'hindu') echo 'selected'; ?>><?php echo get_phrase('hindu'); ?></option>
                            <option value="buddha" <?php if($profile_data['religion'] == 'buddha') echo 'selected'; ?>><?php echo get_phrase('buddha'); ?></option>
                            <option value="khonghucu" <?php if($profile_data['religion'] == 'khonghucu') echo 'selected'; ?>><?php echo get_phrase('khonghucu'); ?></option>
                            <option value="protestan" <?php if($profile_data['religion'] == 'protestan') echo 'selected'; ?>><?php echo get_phrase('protestan'); ?></option>
                        </select>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-6">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('birthday'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" name = "birthday"   value="<?php echo date('m/d/Y', strtotime($profile_data['birthday'])); ?>" required>
                    </div> <!-- end col-->

                    <div class="col-lg-6">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('phone'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" id="phone" name="phone" class="form-control" value="<?= $profile_data['phone'] ?>" required>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-6">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('name'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" id="name" name="name" class="form-control" value="<?= $profile_data['name'] ?>" required>
                    </div> <!-- end col-->

                    <div class="col-lg-6">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('email'); ?> <font style="color:red;">*</font></h5>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $profile_data['email'] ?>" required>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('province'); ?> <font style="color:red;">*</font></h5>
                            <select name="province_id" id="province_id" class="form-control select2" data-toggle = "select2" required onchange="districtWiseSection(this.value)">
                                    <option value=""><?php echo get_phrase('select_province'); ?></option>
                                    <?php $provinces = $this->db->get_where('province')->result_array(); ?>
                                    <?php foreach($provinces as $province){ ?>
                                        <option value="<?php echo $province['id']; ?>" <?php if($province['id'] == $profile_data['province_id']) echo 'selected'; ?>><?php echo $province['name']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('district'); ?> <font style="color:red;">*</font></h5>
                            <select name="district_id" id="district_id" class="form-control select2" data-toggle = "select2" required onchange="districtsWiseSection(this.value)">
                                    <option value=""><?php echo get_phrase('select_district'); ?></option>
                                    <?php $districts = $this->db->get_where('district', array('id' => $profile_data['district_id']))->result_array(); ?>
                                    <?php foreach($districts as $district){ ?>
                                        <option value="<?php echo $district['id']; ?>" <?php if($district['id'] == $profile_data['district_id']) echo 'selected'; ?>><?php echo $district['name']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('districts'); ?> <font style="color:red;">*</font></h5>
                            <select name="districts_id" id="districts_id" class="form-control select2" data-toggle = "select2" required onchange="wardWiseSection(this.value), postcodeWiseSection(this.value)">
                                <option value=""><?php echo get_phrase('select_districts'); ?></option>
                                <?php $districtss = $this->db->get_where('districts', array('id' => $profile_data['districts_id']))->result_array(); ?>
                                <?php foreach($districtss as $districts){ ?>
                                    <option value="<?php echo $districts['id']; ?>" <?php if($districts['id'] == $profile_data['districts_id']) echo 'selected'; ?>><?php echo $districts['name']; ?></option>
                                <?php } ?>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('ward'); ?> <font style="color:red;">*</font></h5>
                            <select name="ward_id" id="ward_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_ward'); ?></option>
                                <?php $wards = $this->db->get_where('ward', array('id' => $profile_data['ward_id']))->result_array(); ?>
                                <?php foreach($wards as $ward){ ?>
                                    <option value="<?php echo $ward['id']; ?>" <?php if($ward['id'] == $profile_data['ward_id']) echo 'selected'; ?>><?php echo $ward['name']; ?></option>
                                <?php } ?>
                            </select>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-7">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('address'); ?> <font style="color:red;">*</font></h5>
                            <textarea class="form-control" id="example-textarea" rows="5" name = "address"><?= $profile_data['address'] ?></textarea>
                    </div> <!-- end col-->

                    <div class="col-lg-2">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('postcode'); ?> <font style="color:red;">*</font></h5>
                            <select name="postcode_id" id="postcode_id" class="form-control select2" data-toggle = "select2" required>
                                    <option value=""><?php echo get_phrase('select_postcode'); ?></option>
                                    <?php $postcodes = $this->db->get_where('postcode', array('postcode' => $profile_data['post_code']))->result_array(); ?>
                                    <?php foreach($postcodes as $postcode){ ?>
                                        <option value="<?php echo $postcode['postcode']; ?>" <?php if($postcode['postcode'] == $profile_data['post_code']) echo 'selected'; ?>><?php echo $postcode['postcode']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('blood_group'); ?> <font style="color:red;">*</font></h5>
                            <select name="blood_group" id="blood_group" class="form-control select2" data-toggle = "select2"  required>
                                <option value=""><?php echo get_phrase('select_a_blood_group'); ?></option>
                                <option value="a+" <?php if($profile_data['blood_group'] == 'a+') echo 'selected'; ?>>A+</option>
                                <option value="a-" <?php if($profile_data['blood_group'] == 'a-') echo 'selected'; ?>>A-</option>
                                <option value="b+" <?php if($profile_data['blood_group'] == 'b+') echo 'selected'; ?>>B+</option>
                                <option value="b-" <?php if($profile_data['blood_group'] == 'b-') echo 'selected'; ?>>B-</option>
                                <option value="ab+" <?php if($profile_data['blood_group'] == 'ab+') echo 'selected'; ?>>AB+</option>
                                <option value="ab-" <?php if($profile_data['blood_group'] == 'ab-') echo 'selected'; ?>>AB-</option>
                                <option value="o+" <?php if($profile_data['blood_group'] == 'o+') echo 'selected'; ?>>O+</option>
                                <option value="o-" <?php if($profile_data['blood_group'] == '0-') echo 'selected'; ?>>O-</option>
                            </select>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>
                
                <div class="row">
                    <div class="col-lg-12">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('employee_profile_image'); ?></h5>
                            <div class="col-md-9 custom-file-upload">
                                <div class="wrapper-image-preview" style="margin-left: -6px;">
                                    <div class="box" style="width: 250px;">
                                        <div class="js--image-preview" style="background-image: url(<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>); background-color: #F5F5F5;"></div>
                                            <div class="upload-options">
                                                <label for="employee_image" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_an_image'); ?> </label>
                                                <input id="employee_image" style="visibility:hidden;" type="file" class="image-upload" name="employee_image" accept="image/*">
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                                    </div>
                                    </div>
                        <!-- <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="name"> <?php echo get_phrase('name') ; ?></label>
                            <div class="col-md-9">
                                <input type="text" id="name" name="name" class="form-control"  value="<?php echo $profile_data['name']; ?>" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="email"><?php echo get_phrase('email') ; ?></label>
                            <div class="col-md-9">
                                <input type="email" id="email" name="email" class="form-control"  value="<?php echo $profile_data['email']; ?>" required>
                            </div>
                        </div> -->

                        <!-- <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="phone"> <?php echo get_phrase('phone') ; ?></label>
                            <div class="col-md-9">
                                <input type="text" id="phone" name="phone" class="form-control"  value="<?php echo $profile_data['phone']; ?>">
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="address"> <?php echo get_phrase('address') ; ?></label>
                            <div class="col-md-9">
                                <textarea class="form-control" id="address" name = "address" rows="5"><?php echo $profile_data['address']; ?></textarea>
                            </div>
                        </div> -->

                        <!-- <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="example-fileinput"><?php echo get_phrase('profile_image'); ?></label>
                            <div class="col-md-9 custom-file-upload">
                                <div class="wrapper-image-preview" style="margin-left: -6px;">
                                    <div class="box" style="width: 250px;">
                                        <div class="js--image-preview" style="background-image: url(<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>); background-color: #F5F5F5;"></div>
                                        <div class="upload-options">
                                            <label for="profile_image" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_an_image'); ?> </label>
                                            <input id="profile_image" style="visibility:hidden;" type="file" class="image-upload" name="profile_image" accept="image/*">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="updateProfileInfo()"><?php echo get_phrase('update_profile') ; ?></button>
                        </div>
                    </div>
                </form>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div>

    <div class="col-xl-10 col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><?php echo get_phrase('change_password') ; ?></h4>
                <form method="POST" class="col-12 changePasswordAjaxForm" action="<?php echo route('profile/update_password') ; ?>" id = "changePasswordAjaxForm" enctype="multipart/form-data">
                    <div class="col-12">
                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="current_password"> <?php echo get_phrase('current_password') ; ?></label>
                            <div class="col-md-9">
                                <input type="password" id="current_password" name="current_password" class="form-control"  value="" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="new_password"> <?php echo get_phrase('new_password') ; ?></label>
                            <div class="col-md-9">
                                <input type="password" id="new_password" name="new_password" class="form-control"  value="" required>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label class="col-md-3 col-form-label" for="confirm_password"> <?php echo get_phrase('confirm_password') ; ?></label>
                            <div class="col-md-9">
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control"  value="" required>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="changePassword()"><?php echo get_phrase('change_password') ; ?></button>
                        </div>
                    </div>
                </form>

            </div> <!-- end card body-->
        </div> <!-- end card -->
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
</script>
<script type="text/javascript">
var form;
$(".ajaxForm").submit(function(e) {
  form = $(this);
  ajaxSubmit(e, form, refreshForm);
});
var refreshForm = function () {
    form.trigger("reset");
}
</script>