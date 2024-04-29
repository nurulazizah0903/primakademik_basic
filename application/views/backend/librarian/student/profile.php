<?php
    $student_data = $this->user_model->get_student_details_by_id('student', $param1);
    $parent = $this->db->get_where('parents', array('id' => $student_data['parent_id']))->row_array();
    $guardian = $this->db->get_where('guardians', array('id' => $student_data['guardian_id']))->row_array();
    $school_id = school_id();
?>
<div class="h-100">
    <div class="row align-items-center h-100">
        <div class="col-md-4 pb-2">
            <div class="text-center">
                <img class="rounded-circle" width="50" height="50" src="<?php echo $this->user_model->get_user_image($student_data['user_id']); ?>">
                <br>
                <span style="font-weight: bold;">
                    <?php echo get_phrase('name'); ?>: <?php echo $student_data['name']; ?>
                </span>
                <br>
                <span style="font-weight: bold;">
                    <?php echo get_phrase('student_code'); ?>: <?php echo $student_data['code']; ?>
                </span>
            </div>
        </div>
        <div class="col-md-8">
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
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                                <td><?= $student_data['name']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('email'); ?>:</td>
                                <td><?= $student_data['email']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nisn'); ?>:</td>
                                <td><?= $student_data['nisn']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nis'); ?>:</td>
                                <td><?= $student_data['NIS']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nik'); ?>:</td>
                                <td><?= $student_data['nik']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('class'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('classes', array('id' => $student_data['class_id']))->row('name');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('section'); ?>:</td>
                                <td>
                                    <?php
                                        echo $this->db->get_where('sections', array('id' => $student_data['section_id']))->row('name');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                                <td><?= get_phrase($student_data['gender']) ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('address'); ?>:</td>
                                <td><?= $student_data['address']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('phone'); ?>:</td>
                                <td><?= $student_data['phone']; ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('number_va'); ?>:</td>
                                <td><?= $student_data['va']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="parent_info" role="tabpanel" aria-labelledby="parent-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <?php
                            $parentdetails = $this->user_model->get_user_details($parent['user_id']);
                            ?>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_name'); ?>:</td>
                                <td><?= $parentdetails['name'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_email'); ?>:</td>
                                <td><?= $parentdetails['email'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                                <td><?= $parentdetails['gender'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nik'); ?>:</td>
                                <td><?= $parentdetails['nik'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_address'); ?>:</td>
                                <td><?= $parentdetails['address'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('parent_phone_number'); ?>:</td>
                                <td><?= $parentdetails['phone'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="guardian_info" role="tabpanel" aria-labelledby="guardian-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <?php
                            $guardiandetails = $this->user_model->get_user_details($guardian['user_id']);
                            ?>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('name'); ?>:</td>
                                <td><?= $guardiandetails['name'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('email'); ?>:</td>
                                <td><?= $guardiandetails['email'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('gender'); ?>:</td>
                                <td><?= $guardiandetails['gender'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('nik'); ?>:</td>
                                <td><?= $guardiandetails['nik'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('address'); ?>:</td>
                                <td><?= $guardiandetails['address'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('phone'); ?>:</td>
                                <td><?= $guardiandetails['phone'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="akademik_info" role="tabpanel" aria-labelledby="akademik-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('upload_skhun'); ?>:</td>
                                <td>
                                    <?php if (isset($student_data['skhun'])) { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $student_data['skhun']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>
                                    <?php } else { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('upload_ijazah'); ?>:</td>
                                <td>
                                    <?php if (!isset($student_data['ijazah'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $student_data['ijazah']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>    
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('rapor_semester'); ?>:</td>
                                <td>
                                    <?php if (!isset($student_data['rapor_semester'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                    <a href="<?= base_url();?>uploads/registrations/<?= $student_data['rapor_semester']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>    
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('sertifikat_lainnya'); ?>:</td>
                                <td>
                                    <?php if (!isset($student_data['sertifikat_lainnya'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $student_data['sertifikat_lainnya']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>    
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('dokumen_lainnya'); ?>:</td>
                                <td>
                                    <?php if (!isset($student_data['dokumen_lainnya'])) { ?>
                                        <?php echo get_phrase('not_yet_upload'); ?>
                                    <?php } else { ?>
                                        <a href="<?= base_url();?>uploads/registrations/<?= $student_data['dokumen_lainnya']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>        
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade show" id="periodik_info" role="tabpanel" aria-labelledby="periodik-tab">
                    <table class="table table-centered mb-0">
                        <tbody>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('weight'); ?>:</td>
                                <td><?= $student_data['weight'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('height'); ?>:</td>
                                <td><?= $student_data['height'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('mileage'); ?>:</td>
                                <td><?= $student_data['mileage'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('traveling_time'); ?>:</td>
                                <td><?= $student_data['traveling_time'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('child_of'); ?>:</td>
                                <td><?= $student_data['child_of'] ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;"><?php echo get_phrase('number_of_siblings'); ?>:</td>
                                <td><?= $student_data['number_of_siblings'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>