<?php $school_data = $this->settings_model->get_current_school_data(); ?>
<div class="row justify-content-md-center">
        <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="dropdown text-right">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                              <!-- item-->
                              <a href="javascript:;" type="button" onclick="confirmModal('<?php echo route('school_settings/delete_all/'.$school_data['id'].''); ?>')" class="dropdown-item"><?php echo get_phrase('delete_all_data'); ?></a>
                              <!-- item-->
                              <a href="javascript:;" type="button" onclick="confirmModal('<?php echo route('school_settings/delete_classes/'.$school_data['id'].''); ?>')" class="dropdown-item"><?php echo get_phrase('hapus_semua_jurusan'); ?></a>
                              <!-- item-->
                              <a href="javascript:;" type="button" onclick="confirmModal('<?php echo route('school_settings/delete_students/'.$school_data['id'].''); ?>')" class="dropdown-item"><?php echo get_phrase('delete_all_students'); ?></a>
                              <!-- item-->
                              <a href="javascript:;" type="button" onclick="confirmModal('<?php echo route('school_settings/delete_departments/'.$school_data['id'].''); ?>')" class="dropdown-item"><?php echo get_phrase('hapus_semua posisi'); ?></a>
                              <!-- item-->
                              <a href="javascript:;" type="button" onclick="confirmModal('<?php echo route('school_settings/delete_teachers/'.$school_data['id'].''); ?>')" class="dropdown-item"><?php echo get_phrase('delete_all_teachers'); ?></a>
                              <!-- item-->
                              <a href="javascript:;" type="button" onclick="confirmModal('<?php echo route('school_settings/delete_subjects/'.$school_data['id'].''); ?>')" class="dropdown-item"><?php echo get_phrase('delete_all_subjects'); ?></a>
                              <!-- item-->
                              <a href="javascript:;" type="button" onclick="confirmModal('<?php echo route('school_settings/delete_routines/'.$school_data['id'].''); ?>')" class="dropdown-item"><?php echo get_phrase('delete_all_routines'); ?></a>
                            </div>
                          </div><br>
                    <h4 class="header-title"><?php echo get_phrase('school_settings') ;?></h4><br>
                    <form method="POST" class="col-12 schoolForm" action="<?php echo route('school_settings/update') ;?>" id = "schoolForm">
                        <div class="col-12">
                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="school_name"> <?php echo get_phrase('school_name') ;?></label>
                                <div class="col-md-9">
                                    <input type="text" id="school_name" name="school_name" class="form-control"  value="<?php echo $school_data['name'] ;?>" required>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="npsn"> <?php echo get_phrase('npsn') ;?></label>
                                <div class="col-md-9">
                                    <input type="text" id="npsn" name="npsn" class="form-control"  value="<?php echo $school_data['npsn'] ;?>" required>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="nss"> <?php echo get_phrase('nss') ;?></label>
                                <div class="col-md-9">
                                    <input type="text" id="nss" name="nss" class="form-control"  value="<?php echo $school_data['nss'] ;?>" required>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="longitudinal"> <?php echo get_phrase('longitudinal') ;?></label>
                                <div class="col-md-9">
                                    <input type="text" id="longitudinal" name="longitudinal" class="form-control"  value="<?php echo $school_data['longitudinal'] ;?>" required>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="phone"><?php echo get_phrase('phone') ;?></label>
                                <div class="col-md-9">
                                    <input type="text" id="phone" name="phone" class="form-control"  value="<?php echo $school_data['phone'] ;?>" required>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="address"> <?php echo get_phrase('address') ;?></label>
                                <div class="col-md-9">
                                    <textarea class="form-control" id="address" name = "address" rows="5" required><?php echo $school_data['address'] ;?></textarea>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-secondary col-xl-4 col-lg-4 col-md-12 col-sm-12" onclick="updateSchoolInfo()"><?php echo get_phrase('update_settings') ;?></button>
                            </div>
                        </div>
                    </form>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div>
    </div>
    <div class="card">
    <div class="card-body">
        <form method="POST" class="col-md-12 excelForm mb-3" action="<?php echo route('upload_excel'); ?>" id = "student_admission_form" enctype="multipart/form-data">
            <div class="row">
                <h5 class="mt-2 col-md-12">
                Upload data csv <?= !empty($activeSchool['name']) ? $activeSchool['name'] : '' ?> <span class="text-danger">(<?php echo get_phrase('harus_sesuai_urutan'); ?>)</span></label>
                </h5>
            </div>
            <div class="row">
                <div class="col-md-4" id = "section_content">
                    <select name="mode" id="mode" class="form-control select2" data-toggle = "select2" required >
                    <option value=""><?php echo get_phrase('select_data'); ?></option>
                        <option value="tahun">1. <?php echo get_phrase('year'); ?></option>
                        <option value="pelanggaran">2. <?php echo get_phrase('mistakes'); ?></option>
                        <option value="penghargaan">3. <?php echo get_phrase('awards'); ?></option>
                        <option value="lokasi">4. <?php echo get_phrase('location'); ?></option>
                        <option value="jenisbuku">5. <?php echo get_phrase('book_types'); ?></option>
                        <option value="eskul">6. <?php echo get_phrase('organization'); ?></option>
                        <option value="jenistugas">7. <?php echo get_phrase('assignment_types'); ?></option>
                        <option value="jenisujian">8. <?php echo get_phrase('exam_types'); ?></option>
                        <option value="kelas">9. <?php echo get_phrase('class'); ?></option>
                        <option value="ruangkelas">10. <?php echo get_phrase('class_rooms'); ?></option>
                        <option value="siswa">11. <?php echo get_phrase('student'); ?></option>
                        <option value="departemen">12. <?php echo get_phrase('department'); ?></option>
                        <option value="guru">13. <?php echo get_phrase('employee'); ?></option>
                        <option value="matapelajaran">14. <?php echo get_phrase('subject'); ?></option>
                        <option value="jam_operasional">15. <?php echo get_phrase('operational_hour'); ?></option>
                        <option value="jadualkelas">16. <?php echo get_phrase('class_routine'); ?></option>
                        <!-- <option value="eskul_siswa">15. <?php echo get_phrase('student_extracurricular'); ?></option> -->
                    </select>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <div class="custom-file-upload">
                            <input type="file" id="csv_file" class="form-control" name="csv_file" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="<?php echo base_url('assets/csv_file/format_xlsx.zip'); ?>" class="btn btn-success col-md-4 col-sm-12 mb-4 mt-3" download><?php echo get_phrase('generate_csv_file'); ?><i class="mdi mdi-download"></i></a>
                <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4 mt-3"><?php echo get_phrase('add_data'); ?></button>
            </div>
            <?php echo get_phrase('Setelah_klik_tombol'); ?>
        </form>
    </div>
</div>

<script>
$(document).ready(function(){
    initCustomFileUploader();
});

var form;
$(".excelForm").submit(function(e) {
form = $(this);
    ajaxSubmit(e, form, refreshForm);
});
var refreshForm = function () {
    form.trigger("reset");
}
</script>