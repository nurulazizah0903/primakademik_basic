<?php
    $registration = $this->db->get_where('registrations', array('id' => $param1))->row_array();
    // $teacherdetails = $this->db->get_where('users', array('id' => $teacher['user_id']))->row_array();
?>
<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a 
                        class="nav-link active" 
                        id="profile-tab" 
                        data-toggle="tab" 
                        href="#profile" 
                        role="tab" 
                        aria-controls="profile" 
                        aria-selected="false"
                    >
                        <?php echo get_phrase('profile'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a 
                        class="nav-link" 
                        id="parent_info-tab" 
                        data-toggle="tab" 
                        href="#parent_info" 
                        role="tab" 
                        aria-controls="parent_info" 
                        aria-selected="false"
                    >
                        <?php echo get_phrase('parent_info'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a 
                        class="nav-link" 
                        id="data_periodik-tab" 
                        data-toggle="tab"
                        href="#data_periodik" 
                        role="tab" 
                        aria-controls="data_periodik" 
                        aria-selected="false"
                    >
                        <?php echo get_phrase('data_periodik'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a 
                        class="nav-link" 
                        id="data_akademik-tab" 
                        data-toggle="tab"
                        href="#data_akademik" 
                        role="tab"
                        aria-controls="data_akademik" 
                        aria-selected="false"
                    >
                        <?php echo get_phrase('data_akademik_profil'); ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a 
                        class="nav-link" 
                        id="kelengkapan_persyaratan-tab" 
                        data-toggle="tab"
                        href="#kelengkapan_persyaratan" 
                        role="tab" 
                        aria-controls="kelengkapan_persyaratan" 
                        aria-selected="false"
                    >
                        <?php echo get_phrase('kelengkapan_persyaratan'); ?>
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                                <td><?= $registration['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                                <td><?= get_phrase($registration['jenis_kelamin']) ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('address'); ?>:</td>
                                <td><?= $registration['alamat']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('phone'); ?>:</td>
                                <td><?= $registration['telephone']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nisn'); ?>:</td>
                                <td><?= $registration['nisn']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('NIS'); ?>:</td>
                                <td><?= $registration['NIS']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nik'); ?>:</td>
                                <td><?= $registration['nik']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('birth_place'); ?>:</td>
                                <td><?= $registration['tempat_lahir']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('religion'); ?>:</td>
                                <td><?= $registration['agama']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('blood_type'); ?>:</td>
                                <td><?= $registration['golongan_darah']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('email'); ?>:</td>
                                <td><?= $registration['email_siswa']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('penerima_kartu_kps'); ?>:</td>
                                <td><?= $registration['kartu']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('penerima_bsm'); ?>:</td>
                                <td><?= $registration['bsm']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="parent_info" role="tabpanel" aria-labelledby="parent_info-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <?php 
                                $field_names = [
                                    "nama_orang_tua",
                                    "tgl_lahir_orang_tua",
                                    "pendidikan_orang_tua",
                                    "keadaan_orang_tua",
                                    "pekerjaan_orang_tua",
                                    "penghasilan_orang_tua",
                                    "alamat_orang_tua",
                                    "nama_wali",
                                    "tgl_lahir_wali",
                                    "pendidikan_wali",
                                    "keadaan_wali",
                                    "pekerjaan_wali",
                                    "penghasilan_wali",
                                    "alamat_wali",
                                ];

                                foreach ($field_names as $item) {
                                    echo '
                                    <tr>
                                        <td style="font-weight: bold;">'. get_phrase($item) .':</td>
                                        <td>'. $registration[$item] .'</td>
                                    </tr>
                                    ';
                                }   
                            ?>
        
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="data_periodik" role="tabpanel" aria-labelledby="data_periodik-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <?php 
                                $field_names = [
                                    "berat_badan",
                                    "tinggi_badan",
                                    "jarak_tempat_tinggal",
                                    "waktu_tempuh",
                                    "anak_ke",
                                    "jumlah_saudara",
                                ];

                                foreach ($field_names as $item) {
                                    echo '
                                    <tr>
                                        <td style="font-weight: bold;">'. get_phrase($item) .':</td>
                                        <td>'. $registration[$item] .'</td>
                                    </tr>
                                    ';
                                }   
                            ?>
        
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="data_akademik" role="tabpanel" aria-labelledby="data_akademik-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <?php 
                                $field_names = [
                                    "sekolah_asal",
                                    "alamat_sekolah_asal",
                                    "no_peserta_ujian",
                                    "no_seri_ijazah",
                                    "tahun_kelulusan",
                                    "nilai_bhs_indo",
                                    "nilai_bhs_inggris",
                                    "nilai_matematika",
                                    "nilai_ipa",
                                ];

                                foreach ($field_names as $item) {
                                    echo '
                                    <tr>
                                        <td style="font-weight: bold;">'. get_phrase($item) .':</td>
                                        <td>'. $registration[$item] .'</td>
                                    </tr>
                                    ';
                                }   
                            ?>
        
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="kelengkapan_persyaratan" role="tabpanel" aria-labelledby="kelengkapan_persyaratan-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                        <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('upload_skhun'); ?>:</td>
                                <td>
                                    <?php if (isset($registration['skhun'])) { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $registration['skhun']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>
                                    <?php } else { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('upload_ijazah'); ?>:</td>
                                <td>
                                    <?php if (!isset($registration['ijazah'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $registration['ijazah']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>    
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('rapor_semester'); ?>:</td>
                                <td>
                                    <?php if (!isset($registration['rapor_semester'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                    <a href="<?= base_url();?>uploads/registrations/<?= $registration['rapor_semester']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>    
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('sertifikat_lainnya'); ?>:</td>
                                <td>
                                    <?php if (!isset($registration['sertifikat_lainnya'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $registration['sertifikat_lainnya']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>    
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('dokumen_lainnya'); ?>:</td>
                                <td>
                                    <?php if (!isset($registration['dokumen_lainnya'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $registration['dokumen_lainnya']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>        
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('bukti_bayar'); ?>:</td>
                                <td>
                                    <?php if (!isset($registration['bukti_bayar'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $registration['bukti_bayar']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>        
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
