<?php $school_id = school_id(); ?>

<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
                <i class="mdi mdi-update title_icon"></i> <?php echo get_phrase('registration_employee'); ?>
            </h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card pt-0">
            <h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('registration_employee'); ?></h4>
    <form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('employee/create_single_employee'); ?>" enctype="multipart/form-data">
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-3">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('nip'); ?><font style="color:red;">*</font></h5>
                            <input type="number" id="nip" name="nip" class="form-control" required placeholder="<?php echo get_phrase('nip'); ?>">
                </div> <!-- end col-->

                <div class="col-lg-3">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('npwp'); ?></h5>
                        <input type="number" id="npwp" name="npwp" class="form-control" placeholder="No NPWP">
                </div> <!-- end col-->

                <div class="col-lg-3">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('no_rekening'); ?> <font style="color:red;">*</font></h5>
                        <input type="number" id="norek" name="norek" class="form-control" required placeholder="Nomor Rekening">
                </div> <!-- end col-->

                <div class="col-lg-3">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('last_study'); ?> <font style="color:red;">*</font></h5>
                    <select name="last_study" id="last_study" class="form-control select2" data-toggle = "select2">
                        <option value=""><?php echo get_phrase('last_study'); ?></option>
                        <option value="1" ><?php echo get_phrase('SMA'); ?></option>
                        <option value="2"><?php echo get_phrase('S1'); ?></option>
                        <option value="3"><?php echo get_phrase('S2'); ?></option>
                    </select>
                </div>
            </div> <!-- end row -->

            <div class="row">

                <div class="col-lg-3">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('married_status'); ?></h5>
                        <select name="status" id="status" class="form-control select2" data-toggle = "select2">
                            <option value=""><?php echo get_phrase('select_status'); ?></option>
                            <option value="married"><?php echo get_phrase('married'); ?></option>
                            <option value="not married yet"><?php echo get_phrase('not_married_yet'); ?></option>
                        </select>
                </div> <!-- end col-->

                <div class="col-lg-3">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('employee_status'); ?> <font style="color:red;">*</font></h5>
                    <select name="employee_status_id" id="employee_status_id" class="form-control select2" required data-toggle = "select2" >
                        <option value=""><?php echo get_phrase('select_employee_status'); ?></option>
                        <?php $employee_statusies = $this->db->get_where('employee_status', array('school_id' => $school_id))->result_array(); ?>
                        <?php foreach($employee_statusies as $employee_status): ?>
                            <option value="<?php echo $employee_status['id']; ?>"><?php echo $employee_status['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> <!-- end col-->

                <div class="col-lg-3">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('certification'); ?> <font style="color:red;">*</font></h5>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="certificate" value="yes" checked><?php echo get_phrase('certificated'); ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="certificate" value="no"><?php echo get_phrase('non-certificated'); ?>
                        </label>
                    </div>
                </div> <!-- end col-->

                <div class="col-lg-3">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('term_work'); ?></h5>
                        <input type="number" id="term_work" name="term_work" class="form-control" placeholder="Periode Jabatan">
                </div> <!-- end col-->
            </div> <!-- end row -->

            <div class="row">
                <div class="col-lg-3">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('tahun_awal_jabatan'); ?> <font style="color:red;">*</font></h5>
                        <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" name = "start_date"   value="<?php echo date('m/d/Y'); ?>" required>
                </div>

                <!-- <div class="col-lg-6">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('finish_date'); ?> <font style="color:red;">*</font></h5>
                        <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" name = "finish_date"   value="<?php echo date('m/d/Y'); ?>" required>
                </div>  -->
                <div class="col-lg-3">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('role'); ?> <font style="color:red;">*</font></h5>
                    <select name="role" id="role" class="form-control select2" data-toggle = "select2"  required>
                        <option value=""><?php echo get_phrase('select_role'); ?></option>
                        <option value="teacher" ><?php echo get_phrase('teacher'); ?></option>
                        <option value="accountant"><?php echo get_phrase('accountant'); ?></option>
                        <option value="librarian"><?php echo get_phrase('librarian'); ?></option>
                        <option value="other_employee"><?php echo get_phrase('other_employee'); ?></option>
                    </select>
                </div>

                <div class="col-lg-3">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('ptk_type'); ?></h5>
                    <select name="ptk_type" id="ptk_type" class="form-control select2" data-toggle = "select2">
                        <option value=""><?php echo get_phrase('ptk_type'); ?></option>
                        <option value="1" ><?php echo get_phrase('Kepala Sekolah'); ?></option>
                        <option value="2"><?php echo get_phrase('Wakil Kepala Sekolah'); ?></option>
                        <option value="3"><?php echo get_phrase('Kepala TU'); ?></option>
                    </select>
                </div>

                <div class="col-lg-3">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('department'); ?></h5>
                    <select name="department_id" id="department_id" class="form-control select2" data-toggle = "select2">
                    <option value=""><?php echo get_phrase('select_department'); ?></option>
                    <?php $departments = $this->db->get_where('departments', array('school_id' => $school_id))->result_array(); ?>
                        <?php foreach($departments as $department): ?>
                            <option value="<?php echo $department['id']; ?>"><?php echo $department['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div> <!-- end row -->
            <br><br>

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
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('nik'); ?></h5>
                                <input type="number" id="nik" name="nik" class="form-control"  placeholder="<?php echo get_phrase('nik'); ?>">
                        </div> <!-- end col-->

                        <div class="col-lg-4">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('gender'); ?></h5>
                                <select name="gender" id="gender" class="form-control select2" data-toggle = "select2" >
                                    <option value=""><?php echo get_phrase('select_gender'); ?></option>
                                    <option value="Male"><?php echo get_phrase('male'); ?></option>
                                    <option value="Female"><?php echo get_phrase('female'); ?></option>
                                    <option value="Others"><?php echo get_phrase('others'); ?></option>
                                </select>
                        </div> <!-- end col-->

                        <div class="col-lg-4">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('religion'); ?></h5>
                                <select name="religion" id="religion" class="form-control select2" data-toggle = "select2">
                                <option value=""><?php echo get_phrase('select_a_religion'); ?></option>
                                <option value="islam" selected><?php echo get_phrase('islam'); ?></option>
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
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('birthday'); ?></h5>
                                <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" name = "birthday"   value="<?php echo date('m/d/Y'); ?>">
                        </div> <!-- end col-->

                        <div class="col-lg-8">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('phone'); ?></h5>
                                <input type="number" id="phone" name="phone" class="form-control" placeholder="phone">
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
                        <div class="col-lg-3">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('province'); ?> </h5>
                                <select name="province_id" id="province_id" class="form-control select2" data-toggle = "select2"  onchange="districtWiseSection(this.value)">
                                        <option value=""><?php echo get_phrase('select_province'); ?></option>
                                        <?php $provinces = $this->db->get_where('province')->result_array(); ?>
                                        <?php foreach($provinces as $province){ ?>
                                            <option value="<?php echo $province['id']; ?>"><?php echo $province['name']; ?></option>
                                        <?php } ?>
                                    </select>
                        </div> <!-- end col-->

                        <div class="col-lg-3">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('district'); ?> </h5>
                                <select name="district_id" id="district_id" class="form-control select2" data-toggle = "select2"  onchange="districtsWiseSection(this.value)">
                                        <option value=""><?php echo get_phrase('select_district'); ?></option>
                                    </select>
                        </div> <!-- end col-->

                        <div class="col-lg-3">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('districts'); ?></h5>
                                <select name="districts_id" id="districts_id" class="form-control select2" data-toggle = "select2" onchange="wardWiseSection(this.value), postcodeWiseSection(this.value)">
                                    <option value=""><?php echo get_phrase('select_districts'); ?></option>
                                </select>
                        </div> <!-- end col-->

                        <div class="col-lg-3">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('ward'); ?> </h5>
                                <select name="ward_id" id="ward_id" class="form-control select2" data-toggle = "select2">
                                    <option value=""><?php echo get_phrase('select_ward'); ?></option>
                                </select>
                        </div> <!-- end col-->
                    </div> <!-- end row --><br>

                    <div class="row">
                        <div class="col-lg-7">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('address'); ?></h5>
                                <textarea class="form-control" id="example-textarea" rows="5" name = "address" placeholder="<?php echo get_phrase('address'); ?>"></textarea>
                        </div> <!-- end col-->

                        <div class="col-lg-2">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('postcode'); ?> </h5>
                                <select name="postcode_id" id="postcode_id" class="form-control select2" data-toggle = "select2" >
                                        <option value=""><?php echo get_phrase('select_postcode'); ?></option>
                                    </select>
                        </div> <!-- end col-->

                        <div class="col-lg-3">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('blood_group'); ?> </h5>
                                <select name="blood_group" id="blood_group" class="form-control select2" data-toggle = "select2" >
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
                        <div class="col-lg-12">
                            <h5 style="font-weight: bold;"><?php echo get_phrase('employee_profile_image'); ?></h5>
                                <div class="col-md-9 custom-file-upload">
                                    <div class="wrapper-image-preview" style="margin-left: -6px;">
                                        <div class="box" style="width: 250px;">
                                            <div class="js--image-preview" style="background-image: url(<?php echo base_url('uploads/users/placeholder.jpg'); ?>); background-color: #F5F5F5;"></div>
                                                <div class="upload-options">
                                                    <label for="image_file" class="btn"> <i class="mdi mdi-camera"></i> <?php echo get_phrase('upload_an_image'); ?> </label>
                                                    <!-- <input type="file" class="form-control" id="image_file" name = "image_file"> -->
                                                    <input id="image_file" style="visibility:hidden;" type="file" class="image-upload" name="image_file" accept="image/*">
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
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
  initSelect2(['#department', '#role', '#status', '#gender', '#blood_group', '#show_on_website']);
});

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

var form;
$(".ajaxForm").submit(function(e) {
  form = $(this);
  ajaxSubmit(e, form, refreshForm);
});
var refreshForm = function () {
    form.trigger("reset");
}
</script>
