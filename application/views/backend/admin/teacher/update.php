<?php 
$school_id = school_id(); 
$users = $this->db->get_where('users', array('id' => $teacher_id))->result_array();
foreach($users as $user):
$teacher = $this->db->get_where('teachers', array('user_id' => $user['id']))->row_array();
$job = $this->db->get_where('job_management', array('user_id' => $teacher_id))->result_array();
$job_teacher = $this->db->get_where('job_management', array('user_id' => $teacher_id, 'status' => 1))->row_array();
?>
<!--title-->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
                <i class="mdi mdi-update title_icon"></i> <?php echo get_phrase('teacher_update_form'); ?>
            </h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card pt-0">
            <h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('update_teacher_information'); ?></h4>
            <form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('teacher/update_employee/'.$teacher_id); ?>"  enctype="multipart/form-data">
            <div class="col-md-12">
        <div class="row">
            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('nip'); ?> <font style="color:red;">*</font></h5>
                        <input type="text" id="nip" name="nip" class="form-control" value="<?= $user['nip'] ?>" required>
                
            </div> <!-- end col-->

            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('npwp'); ?></h5>
                    <input type="text" id="npwp" name="npwp" class="form-control" value="<?= $user['npwp'] ?>">
                
            </div> <!-- end col-->
        </div> <!-- end row -->

        <div class="row">
            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('jabatan'); ?> <font style="color:red;">*</font></h5>
                    <select name="role" id="role" class="form-control select2" data-toggle = "select2"  required disabled>
                        <option value=""><?php echo get_phrase('select_role'); ?></option>
                        <option value="teacher" <?php if($user['role'] == 'teacher') echo 'selected'; ?>><?php echo get_phrase('teacher'); ?></option>
                        <option value="accountant" <?php if($user['role'] == 'accountant') echo 'selected'; ?>><?php echo get_phrase('accountant'); ?></option>
                        <option value="librarian" <?php if($user['role'] == 'librarian') echo 'selected'; ?>><?php echo get_phrase('librarian'); ?></option>
                        <option value="other_employee" <?php if($user['role'] == 'other_employee') echo 'selected'; ?>><?php echo get_phrase('other_employee'); ?></option>
                    </select>
            </div> <!-- end col-->

            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('status'); ?> <font style="color:red;">*</font></h5>
                    <select name="status" id="status" class="form-control select2" data-toggle = "select2"  required>
                        <option value=""><?php echo get_phrase('select_status'); ?></option>
                        <option value="married" <?php if($user['status'] == 'married') echo 'selected'; ?>><?php echo get_phrase('married'); ?></option>
                        <option value="not married yet" <?php if($user['status'] == 'not married yet') echo 'selected'; ?>><?php echo get_phrase('not_married_yet'); ?></option>
                    </select>
            </div> <!-- end col-->
        </div> <!-- end row -->
        
        <div class="row">
            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('start_date'); ?> <font style="color:red;">*</font></h5>
                    <input type="text" class="form-control" name = "start_date" value="<?php echo date('D, d/M/Y', strtotime($job_teacher['start_date'])); ?>" disabled>
            </div> <!-- end col-->

            <div class="col-lg-6">
                <h5 style="font-weight: bold;"> <?php echo get_phrase('finish_date'); ?> <font style="color:red;">*</font></h5>
                    <input type="text" class="form-control" name = "finish_date" value="<?php echo get_phrase('--'); ?>" disabled>
            </div> <!-- end col-->
        </div> <!-- end row --><br><br>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('basic_data'); ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="job-tab" data-toggle="tab" href="#job" role="tab" aria-controls="job" aria-selected="false"><?php echo get_phrase('job_management'); ?></a>
                </li>
            </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show" id="job" role="tabpanel" aria-labelledby="job-tab"><br>
                <?php 
                $date = date('m/d/Y');
                if (count($job) > 0): ?>
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
                    <thead>
                        <tr style="background-color: #313a46; color: #ababab;">
                            <th><?php echo get_phrase('nip'); ?></th>
                            <th><?php echo get_phrase('role'); ?></th>
                            <th><?php echo get_phrase('start_date'); ?></th>
                            <th><?php echo get_phrase('finish_date'); ?></th>
                            <th><?php echo get_phrase('status'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($job as $job_management):?>
                            <tr>
                                <td>
                                    <?php echo $user['nip']; ?><br>
                                    <small> <strong><?php echo get_phrase('name'); ?> : <?php echo $user['name']; ?></strong> </small>
                                </td>
                                <td>
                                <?php 
                                        if ($job_management['role'] == 'teacher') {
                                            echo get_phrase('teacher');
                                        }elseif ($job_management['role'] == 'librarian') {
                                            echo get_phrase('librarian');
                                        }elseif ($job_management['role'] == 'accountant') {
                                            echo get_phrase('accountant');
                                        }else{

                                        }
                                ?>    
                                </td>
                                <td><?php echo date('D, d/M/Y', strtotime($job_management['start_date'])); ?></td>
                                <td>--</td>
                                <td>
                                <?php if ($job_management['status'] == "1") { ?>
                                        <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('active'); ?>
                                    <?php
                                    }elseif ($job_management['status'] == "0") { ?>
                                        <i class="mdi mdi-circle text-disabled"></i> <?php echo get_phrase('inactive'); ?>
                                <?php } ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                    <?php include APPPATH.'views/backend/empty.php'; ?>
                <?php endif; ?>
            </div>

            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <br>
                <div class="row">
                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('nik'); ?> <font style="color:red;">*</font></h5>
                            <input type="number" id="nik" name="nik" class="form-control"  value="<?= $user['nik'] ?>" required>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('gender'); ?> <font style="color:red;">*</font></h5>
                            <select name="gender" id="gender" class="form-control select2" data-toggle = "select2"  required>
                                <option value=""><?php echo get_phrase('select_gender'); ?></option>
                                <option value="Male" <?php if($user['gender'] == 'Male') echo 'selected'; ?>><?php echo get_phrase('male'); ?></option>
                                <option value="Female" <?php if($user['gender'] == 'Female') echo 'selected'; ?>><?php echo get_phrase('female'); ?></option>
                                <option value="Others" <?php if($user['gender'] == 'Others') echo 'selected'; ?>><?php echo get_phrase('others'); ?></option>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('religion'); ?> <font style="color:red;">*</font></h5>
                            <select name="religion" id="religion" class="form-control select2" data-toggle = "select2">
                            <option value=""><?php echo get_phrase('select_a_religion'); ?></option>
                            <option value="islam" <?php if($user['religion'] == 'islam') echo 'selected'; ?>><?php echo get_phrase('islam'); ?></option>
                            <option value="katolik" <?php if($user['religion'] == 'katolik') echo 'selected'; ?>><?php echo get_phrase('katolik'); ?></option>
                            <option value="hindu" <?php if($user['religion'] == 'hindu') echo 'selected'; ?>><?php echo get_phrase('hindu'); ?></option>
                            <option value="buddha" <?php if($user['religion'] == 'buddha') echo 'selected'; ?>><?php echo get_phrase('buddha'); ?></option>
                            <option value="khonghucu" <?php if($user['religion'] == 'khonghucu') echo 'selected'; ?>><?php echo get_phrase('khonghucu'); ?></option>
                            <option value="protestan" <?php if($user['religion'] == 'protestan') echo 'selected'; ?>><?php echo get_phrase('protestan'); ?></option>
                        </select>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('department'); ?> <font style="color:red;">*</font></h5>
                        <select name="department" id="department" class="form-control select2" data-toggle = "select2" disabled required>
                            <option value=""><?php echo get_phrase('select_a_department'); ?></option>
                            <?php $departments = $this->db->get_where('departments', array('school_id' => school_id()))->result_array();
                            foreach($departments as $department){
                                ?>
                                <option value="<?php echo $department['id']; ?>" <?php if($department['id'] == $teacher['department_id']) echo 'selected'; ?>><?php echo $department['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('birthday'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" name = "birthday"   value="<?php echo date('m/d/Y', strtotime($user['birthday'])); ?>" required>
                    </div> <!-- end col-->

                    <div class="col-lg-4">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('phone'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" id="phone" name="phone" class="form-control" value="<?= $user['phone'] ?>" required>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-6">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('name'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" id="name" name="name" class="form-control" value="<?= $user['name'] ?>" required>
                    </div> <!-- end col-->

                    <div class="col-lg-6">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('email'); ?> <font style="color:red;">*</font></h5>
                            <input type="text" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('province'); ?> <font style="color:red;">*</font></h5>
                            <select name="province_id" id="province_id" class="form-control select2" data-toggle = "select2" required onchange="districtWiseSection(this.value)">
                                    <option value=""><?php echo get_phrase('select_province'); ?></option>
                                    <?php $provinces = $this->db->get_where('province')->result_array(); ?>
                                    <?php foreach($provinces as $province){ ?>
                                        <option value="<?php echo $province['id']; ?>" <?php if($province['id'] == $user['province_id']) echo 'selected'; ?>><?php echo $province['name']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('district'); ?> <font style="color:red;">*</font></h5>
                            <select name="district_id" id="district_id" class="form-control select2" data-toggle = "select2" required onchange="districtsWiseSection(this.value)">
                                    <option value=""><?php echo get_phrase('select_district'); ?></option>
                                    <?php $districts = $this->db->get_where('district', array('id' => $user['district_id']))->result_array(); ?>
                                    <?php foreach($districts as $district){ ?>
                                        <option value="<?php echo $district['id']; ?>" <?php if($district['id'] == $user['district_id']) echo 'selected'; ?>><?php echo $district['name']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('districts'); ?> <font style="color:red;">*</font></h5>
                            <select name="districts_id" id="districts_id" class="form-control select2" data-toggle = "select2" required onchange="wardWiseSection(this.value), postcodeWiseSection(this.value)">
                                <option value=""><?php echo get_phrase('select_districts'); ?></option>
                                <?php $districtss = $this->db->get_where('districts', array('id' => $user['districts_id']))->result_array(); ?>
                                <?php foreach($districtss as $districts){ ?>
                                    <option value="<?php echo $districts['id']; ?>" <?php if($districts['id'] == $user['districts_id']) echo 'selected'; ?>><?php echo $districts['name']; ?></option>
                                <?php } ?>
                            </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('ward'); ?> <font style="color:red;">*</font></h5>
                            <select name="ward_id" id="ward_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_ward'); ?></option>
                                <?php $wards = $this->db->get_where('ward', array('id' => $user['ward_id']))->result_array(); ?>
                                <?php foreach($wards as $ward){ ?>
                                    <option value="<?php echo $ward['id']; ?>" <?php if($ward['id'] == $user['ward_id']) echo 'selected'; ?>><?php echo $ward['name']; ?></option>
                                <?php } ?>
                            </select>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>

                <div class="row">
                    <div class="col-lg-7">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('address'); ?> <font style="color:red;">*</font></h5>
                            <textarea class="form-control" id="example-textarea" rows="5" name = "address"><?= $user['address'] ?></textarea>
                    </div> <!-- end col-->

                    <div class="col-lg-2">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('postcode'); ?> <font style="color:red;">*</font></h5>
                            <select name="postcode_id" id="postcode_id" class="form-control select2" data-toggle = "select2" required>
                                    <option value=""><?php echo get_phrase('select_postcode'); ?></option>
                                    <?php $postcodes = $this->db->get_where('postcode', array('postcode' => $user['post_code']))->result_array(); ?>
                                    <?php foreach($postcodes as $postcode){ ?>
                                        <option value="<?php echo $postcode['postcode']; ?>" <?php if($postcode['postcode'] == $user['post_code']) echo 'selected'; ?>><?php echo $postcode['postcode']; ?></option>
                                    <?php } ?>
                                </select>
                    </div> <!-- end col-->

                    <div class="col-lg-3">
                        <h5 style="font-weight: bold;"> <?php echo get_phrase('blood_group'); ?> <font style="color:red;">*</font></h5>
                            <select name="blood_group" id="blood_group" class="form-control select2" data-toggle = "select2"  required>
                                <option value=""><?php echo get_phrase('select_a_blood_group'); ?></option>
                                <option value="a+" <?php if($user['blood_group'] == 'a+') echo 'selected'; ?>>A+</option>
                                <option value="a-" <?php if($user['blood_group'] == 'a-') echo 'selected'; ?>>A-</option>
                                <option value="b+" <?php if($user['blood_group'] == 'b+') echo 'selected'; ?>>B+</option>
                                <option value="b-" <?php if($user['blood_group'] == 'b-') echo 'selected'; ?>>B-</option>
                                <option value="ab+" <?php if($user['blood_group'] == 'ab+') echo 'selected'; ?>>AB+</option>
                                <option value="ab-" <?php if($user['blood_group'] == 'ab-') echo 'selected'; ?>>AB-</option>
                                <option value="o+" <?php if($user['blood_group'] == 'o+') echo 'selected'; ?>>O+</option>
                                <option value="o-" <?php if($user['blood_group'] == '0-') echo 'selected'; ?>>O-</option>
                            </select>
                    </div> <!-- end col-->
                </div> <!-- end row --><br>
                
                <div class="row">
                    <div class="col-lg-12">
                        <h5 style="font-weight: bold;"><?php echo get_phrase('employee_profile_image'); ?></h5>
                            <div class="col-md-9 custom-file-upload">
                                <div class="wrapper-image-preview" style="margin-left: -6px;">
                                    <div class="box" style="width: 250px;">
                                        <div class="js--image-preview" style="background-image: url(<?php echo $this->user_model->get_user_image($user['id']); ?>); background-color: #F5F5F5;"></div>
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
                    <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4"><?php echo get_phrase('save'); ?></button>
                </div>
    </div>
            </form>
            <?php endforeach; ?>
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