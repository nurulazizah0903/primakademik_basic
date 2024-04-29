<?php $school_id = school_id(); ?>

<form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('employee/create_single_employee'); ?>">
<div class="col-md-12">
        <div class="row">
            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('nip'); ?> <font style="color:red;">*</font></h5>
                        <input type="text" id="nip" name="nip" class="form-control" placeholder="<?php echo get_phrase('nip'); ?>" required>
                
            </div> <!-- end col-->

            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('npwp'); ?></h5>
                    <input type="text" id="npwp" name="npwp" class="form-control" placeholder="npwp">
                
            </div> <!-- end col-->
        </div> <!-- end row -->

        <div class="row">
            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('role'); ?> <font style="color:red;">*</font></h5>
                    <select name="role" id="role" class="form-control select2" data-toggle = "select2"  required>
                        <option value=""><?php echo get_phrase('select_role'); ?></option>
                        <option value="teacher"><?php echo get_phrase('teacher'); ?></option>
                        <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                        <option value="librarian"><?php echo get_phrase('librarian'); ?></option>
                        <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
                    </select>
            </div> <!-- end col-->

            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('status'); ?> <font style="color:red;">*</font></h5>
                    <select name="status" id="status" class="form-control select2" data-toggle = "select2"  required>
                        <option value=""><?php echo get_phrase('select_status'); ?></option>
                        <option value="married"><?php echo get_phrase('married'); ?></option>
                        <option value="not married yet"><?php echo get_phrase('not_married_yet'); ?></option>
                    </select>
            </div> <!-- end col-->
        </div> <!-- end row --><br><br>


            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('basic_data'); ?></a>
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
                    <div class="col-lg-7">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('address'); ?> <font style="color:red;">*</font></h5>
                            <textarea class="form-control" id="example-textarea" rows="5" name = "address" placeholder="address"></textarea>
                    </div> <!-- end col-->

                    <div class="col-lg-2">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('postcode'); ?> <font style="color:red;">*</font></h5>
                            <select name="postcode_id" id="postcode_id" class="form-control select2" data-toggle = "select2" required>
                                    <option value=""><?php echo get_phrase('select_postcode'); ?></option>
                                    <?php $postcodes = $this->db->get_where('postcode')->result_array(); ?>
                                    <?php foreach($postcodes as $postcode){ ?>
                                        <option value="<?php echo $postcode['postcode']; ?>"><?php echo $postcode['postcode']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
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
                            <select name="province_id" id="province_id" class="form-control select2" data-toggle = "select2" required>
                                    <option value=""><?php echo get_phrase('select_province'); ?></option>
                                    <?php $provinces = $this->db->get_where('province')->result_array(); ?>
                                    <?php foreach($provinces as $province){ ?>
                                        <option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('district'); ?> <font style="color:red;">*</font></h5>
                            <select name="district_id" id="district_id" class="form-control select2" data-toggle = "select2" required>
                                    <option value=""><?php echo get_phrase('select_district'); ?></option>
                                    <?php $districts = $this->db->get_where('district')->result_array(); ?>
                                    <?php foreach($districts as $district){ ?>
                                        <option value="<?php echo $district['id']; ?>"><?php echo $district['name']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('districts'); ?> <font style="color:red;">*</font></h5>
                            <select name="districts_id" id="districts_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_districts'); ?></option>
                                <?php $districtss = $this->db->get_where('districts')->result_array(); ?>
                                <?php foreach($districtss as $districts){ ?>
                                    <option value="<?php echo $districts['id']; ?>"><?php echo $districts['name']; ?></option>
                                <?php } ?>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('ward'); ?> <font style="color:red;">*</font></h5>
                            <select name="ward_id" id="ward_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_ward'); ?></option>
                                <?php $wards = $this->db->get_where('ward')->result_array(); ?>
                                <?php foreach($wards as $ward){ ?>
                                    <option value="<?php echo $ward['id']; ?>"><?php echo $ward['name']; ?></option>
                                <?php } ?>
                            </select>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>
                
                <div class="row">
                    <div class="col-lg-12">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('employee_profile_image'); ?></h5>
                            <div class="col-md-9 custom-file-upload">
                                <div class="wrapper-image-preview" style="margin-left: -6px;">
                                    <div class="box" style="width: 250px;">
                                        <div class="js--image-preview" style="background-image: url(<?php echo base_url('uploads/users/placeholder.jpg'); ?>); background-color: #F5F5F5;"></div>
                                            <div class="upload-options">
                                                <label for="employee_image" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_an_image'); ?> </label>
                                                <input id="employee_image" style="visibility:hidden;" type="file" class="image-upload" name="employee_image" accept="image/*">
                                            </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div><br><br>
        </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4"><?php echo get_phrase('add_employee'); ?></button>
                </div>
    </div>
</form>

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
