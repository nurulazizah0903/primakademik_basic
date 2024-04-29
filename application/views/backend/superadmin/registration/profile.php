<?php
    $registration = $this->db->get_where('registrations', array('id' => $param1))->row_array();
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
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nik'); ?>:</td>
                                <td><?= $registration['nik']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                                <td><?= $registration['nama_lengkap']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('jenis_kelamin'); ?>:</td>
                                <td><?php
                    if($registration['jenis_kelamin'] == "Male"){
                        echo 'Laki - Laki';
                    }else{
                        echo 'Perempuan';
                    }
                    ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('birth_place'); ?>:</td>
                                <td><?= $registration['tempat_lahir']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('birthday'); ?>:</td>
                                <td><?= $registration['tgl_lahir']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('sekolah_asal'); ?>:</td>
                                <td><?= $registration['sekolah_asal']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nama_orang_tua/wali'); ?>:</td>
                                <td><?= $registration['nama_orang_tua']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('pekerjaan_orang_tua/wali'); ?>:</td>
                                <td><?= $registration['pekerjaan_orang_tua']; ?></td>
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
                                <td style="font-weight: bold;"><?php echo get_phrase('info_sekolah'); ?>:</td>
                                <td><?= $registration['info_sekolah']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('jalur_pendaftaran'); ?>:</td>
                                <td><?php echo $this->db->get_where('registration_path', array('id' => $registration['jalur_pendaftaran']))->row('name');?></td>
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
