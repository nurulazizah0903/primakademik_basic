    <div class="row ">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="page-title">
                        <i class="mdi mdi-account-multiple-plus title_icon"></i> <?php echo get_phrase('form_registrasi'); ?>
                    </h4>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <div class="card">
        <div class="card-body student_list">
            <form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('registration/create_single_student'); ?>" enctype="multipart/form-data">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('nik'); ?> <font style="color:red;">*</font></h5>
                                <input type="number" id="nik" name="nik" class="form-control" placeholder="NIK" required>
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('nama_lengkap_anak'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="nama" name="nama" class="form-control" placeholder="<?php echo get_phrase('nama_lengkap_anak'); ?>" required>
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('gender'); ?> <font style="color:red;">*</font></h5>
                                <select name="student_gender" id="student_gender" class="form-control select2" data-toggle = "select2"  required>
                                    <option value=""><?php echo get_phrase('select_gender'); ?></option>
                                    <option value="Male"><?php echo get_phrase('male'); ?></option>
                                    <option value="Female"><?php echo get_phrase('female'); ?></option>
                                    <option value="Others"><?php echo get_phrase('others'); ?></option>
                                </select>
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('birthday_place'); ?> </h5>
                                <select name="birthday_place" id="birthday_place" class="form-control select2" data-toggle = "select2" >
                                    <option value=""><?php echo get_phrase('select_birthday_place'); ?></option>
                                    <?php $districts = $this->db->get_where('district')->result_array(); ?>
                                    <?php foreach($districts as $district){ ?>
                                        <option value="<?php echo $district['id']; ?>"><?php echo $district['name']; ?></option>
                                    <?php } ?>
                                </select> 
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('birthday'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true" name = "student_birthday" required value="<?php echo date('m/d/Y'); ?>">
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('nisn'); ?> <font style="color:red;">*</font></h5>
                                <input type="number" id="nisn" name="nisn" class="form-control" placeholder="<?php echo get_phrase('nisn'); ?>" required>                        
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('sekolah_asal'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="sekolah_asal" name="sekolah_asal" class="form-control" placeholder="<?php echo get_phrase('school_before'); ?>" required>
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('section'); ?> <font style="color:red;">*</font></h5>
                            <select name="jurusan" id="section_id" class="form-control select2" data-toggle = "select2" required>
                                <option value=""><?php echo get_phrase('select_a_section'); ?></option>
                                <option value="<?php echo get_phrase('Multimedia'); ?>"><?php echo get_phrase('Multimedia'); ?></option>
                                <option value="<?php echo get_phrase('Akutansi'); ?>"><?php echo get_phrase('Akutansi'); ?></option>
                                <option value="<?php echo get_phrase('Adminitrasi_perkatoran'); ?>"><?php echo get_phrase('Adminitrasi_perkatoran'); ?></option>
                            </select>
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('nama_orang_tua/wali'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="nama_orang_tua" name="nama_orang_tua" class="form-control" placeholder="<?php echo get_phrase('nama_orang_tua/wali'); ?>" required>
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('pekerjaan_orang_tua/wali'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="pekerjaan_orang_tua" name="pekerjaan_orang_tua" class="form-control" placeholder="<?php echo get_phrase('pekerjaan_orang_tua/wali'); ?>" required>
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('address'); ?> <font style="color:red;">*</font></h5>
                                <textarea class="form-control" id="example-textarea" rows="5" name = "alamat" placeholder="address" required></textarea>
                        </div> <!-- end col-->
                        <div class="col-lg-6">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('telephone'); ?> <font style="color:red;">*</font></h5>
                                <input type="text" id="telephone" name="telephone" class="form-control" placeholder="<?php echo get_phrase('telephone'); ?>" required>
                        </div> <!-- end col-->
                        <div class="col-lg-6" id="info_sekolah">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('info_sekolah'); ?> <font style="color:red;">*</font></h5>
                                <select name="info_sekolah" id="info_sekolah" class="form-control select2" data-toggle = "select2">
                                <option value=""><?php echo get_phrase('select_info_sekolah'); ?></option>
                                <option value="<?php echo get_phrase('teman'); ?>"><?php echo get_phrase('teman'); ?></option>
                                <option value="<?php echo get_phrase('guru'); ?>"><?php echo get_phrase('guru'); ?></option>
                                <option value="<?php echo get_phrase('internet'); ?>"><?php echo get_phrase('internet'); ?></option>
                                <option value="<?php echo get_phrase('brosur'); ?>"><?php echo get_phrase('brosur'); ?></option>
                                <option value="<?php echo get_phrase('presentasi'); ?>"><?php echo get_phrase('presentasi'); ?></option>
                                <option value="<?php echo get_phrase('lainnya'); ?>"><?php echo get_phrase('lainnya'); ?></option>
                            </select>
                        </div> <!-- end col-->
                        <div class="col-lg-6" id="jalur_pendaftaran">
                            <h5 style="font-weight: bold;"> <?php echo get_phrase('jalur_pendaftaran'); ?> <font style="color:red;">*</font></h5>
                                <select name="jalur_pendaftaran" id="jalur_pendaftaran" class="form-control select2" data-toggle = "select2">
                                <option value=""><?php echo get_phrase('select_jalur_pendaftaran'); ?></option>
                                <?php foreach ($registration_paths as $item) { ?>
                                    <option value="<?= $item['id'] ?>"><?= $item['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div> <!-- end col-->
                        <div class="col-lg-12">
                            <label for="status"><?php echo get_phrase('status'); ?></label>
                            <select name="status" id="status_on_create" class="form-control select2" data-toggle = "select2"  required>
                                <option value="Not Yet Paid"><?php echo get_phrase('belum_bayar'); ?></option>
                                <option value="Installment"><?php echo get_phrase('Inden_Angsur'); ?></option>
                                <option value="Accepted"><?php echo get_phrase('diterima'); ?></option>  
                                <option value="Not Accepted"><?php echo get_phrase('tidak_diterima'); ?></option>
                                <option value="Removed"><?php echo get_phrase('mengundurkan_diri'); ?></option>
                            </select>
                        </div>
                    </div> <!-- end row -->
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4"><?php echo get_phrase('add_student'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script type="text/javascript">
    'use strict';
    $('document').ready(function(){

    });
    function classWiseSection(classId) {
        $.ajax({
            url: "<?php echo route('section/list/'); ?>"+classId,
            success: function(response){
                $('#section_id').html(response);
            }
        });
    }

    function sectionWiseClassroomsOnCreate(sectionId) {
        $.ajax({
            url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
            success: function(response){
            $('#room_id').html(response);
            }
        });
    }

    function districtWiseSectionStudent(province_id) {
        $.ajax({
            url: "<?php echo route('district_dropdown/dropdown/'); ?>"+province_id,
            success: function(response){
                $('#student_district_id').html(response);
                districtsWiseSectionStudent(district_id);
            }
        });
    }

    function districtsWiseSectionStudent(district_id) {
        $.ajax({
            url: "<?php echo route('districts_dropdown/dropdown/'); ?>"+district_id,
            success: function(response){
                $('#student_districts_id').html(response);
                postcodeWiseSectionStudent(districts_id),
                wardWiseSectionStudent(districts_id);
            }
        });
    }

    function postcodeWiseSectionStudent(districts_id) {
        $.ajax({
            url: "<?php echo route('postcode_dropdown/dropdown/'); ?>"+districts_id,
            success: function(response){
                $('#student_postcode_id').html(response);
            }
        });
    }

    function wardWiseSectionStudent(districts_id) {
        $.ajax({
            url: "<?php echo route('ward_dropdown/dropdown/'); ?>"+districts_id,
            success: function(response){
                $('#student_ward_id').html(response);
            }
        });
    }

    $(document).ready(function(){
        initCustomFileUploader();
    });
</script>
