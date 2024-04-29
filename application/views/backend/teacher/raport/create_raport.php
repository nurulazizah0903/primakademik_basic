<?php
$school_id = school_id();
$active_session = active_session();
$student_data = $this->user_model->get_student_details_by_id('student', $student_id);

// print_r($student_data);
?>
<?php
if (!empty($student_id)):
$student_data = $this->user_model->get_student_details_by_id('student', $student_id);
$subjects = $this->db->get_where('subjects', array('class_id' => $student_data['class_id'],'section_id' => $student_data['section_id']))->result_array();

if (count($subjects) > 0):
?>
<div class="row ">
    <div class="col-xl-12">
        <div class="card ">
            <div class="card-body">
                <div class="row ">
                    <div class="col-md-8">
                        <div class="table-responsive">
                        <table border="1" class="table table-bordered table-centered mb-0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><?php echo get_phrase('subject'); ?></th>
                                        <th><?php echo get_phrase('mark_knowledge'); ?></th>
                                        <th><?php echo get_phrase('mark_skills'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    foreach($subjects as $subject):
                                    $average = $this->db->get_where('marks', array('subject_id' => $subject['id'],'student_id' => $student_data['student_id'],'session' => $active_session))->row_array();
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?php echo $subject['name']; ?></td>
                                            <td>
                                            <?php
                                            if (empty($average['mark_knowledge'])){
                                                echo  get_phrase('no_value_yet');
                                            }else{
                                            echo $average['mark_knowledge'];
                                            }
                                            ?>
                                            </td>
                                            <td>
                                            <?php
                                            if (empty($average['mark_skills'])){
                                                echo  get_phrase('no_value_yet');
                                            }else{
                                            echo $average['mark_skills'];
                                            }
                                            ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <?php
                    $attendance_permission = $this->db->query('SELECT COUNT(status) total FROM daily_attendances WHERE status = 2 AND student_id = '.$student_id.' AND school_id = '.$school_id.' AND class_id = '.$student_data['class_id'].' AND section_id = '.$student_data['section_id'].'')->result_array();
                    $attendance_sick = $this->db->query('SELECT COUNT(status) total FROM daily_attendances WHERE status = 3 AND student_id = '.$student_id.' AND school_id = '.$school_id.' AND class_id = '.$student_data['class_id'].' AND section_id = '.$student_data['section_id'].'')->result_array();
                    $attendance_absent = $this->db->query('SELECT COUNT(status) total FROM daily_attendances WHERE status = 0 AND student_id = '.$student_id.' AND school_id = '.$school_id.' AND class_id = '.$student_data['class_id'].' AND section_id = '.$student_data['section_id'].'')->result_array();
                    ?>
                    <table border="1" class="table table-bordered table-centered mb-0" width="100%">
                        <tr>
                            <th colspan="3"><?php echo get_phrase('attendance'); ?></th>
                        </tr>
                        <tr>
                            <th><?php echo get_phrase('permission'); ?></th>
                            <th><?php echo get_phrase('sick'); ?></th>
                            <th><?php echo get_phrase('absent'); ?></th>
                        </tr>
                            <tr>
                                <td>
                                <?php
                                foreach ($attendance_permission as $count) {
                                    echo $count['total'];
                                }
                                ?>
                                </td>
                                <td>
                                <?php
                                foreach ($attendance_sick as $count) {
                                    echo $count['total'];
                                }
                                ?>    
                                </td>
                                <td>
                                <?php
                                foreach ($attendance_absent as $count) {
                                    echo $count['total'];
                                }
                                ?>
                                </td>
                            </tr>
                    </table>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-md-12">
                        <?php
                        $raport = $this->db->get_where('raport', array('class_id' => $student_data['class_id'], 'section_id' => $student_data['section_id'],'student_id' => $student_id))->row_array();
                        $student_extracurriculars = $this->db->get_where('student_extracurricular', array('student_id' => $student_id))->row_array();
                        $student_eks = $student_extracurriculars['organizations_id'];
                        $organization = explode(",", $student_eks);                                  
                        ?>
                        <form method="POST" class="d-block ajaxForm" action="<?php echo route('raport/create_raport'); ?>"><form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('parent/create'); ?>" id = "student_admission_form" enctype="multipart/form-data">
                        <input type="hidden" id="student_id" name="student_id" value="<?= $student_id?>">
                        <input type="hidden" id="class_id" name="class_id" value="<?= $student_data['class_id']?>">
                        <input type="hidden" id="section_id" name="section_id" value="<?= $student_data['section_id']?>">
                        <input type="hidden" id="attendance_permission" name="attendance_permission" value="<?= $attendance_permission[0]['total']?>">
                        <input type="hidden" id="attendance_sick" name="attendance_sick" value="<?= $attendance_sick[0]['total']?>">
                        <input type="hidden" id="attendance_absent" name="attendance_absent" value="<?= $attendance_absent[0]['total']?>">
                        <input type="hidden" id="organizations_id" name="organizations_id" value="<?= $student_extracurriculars['organizations_id']?>">

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="extracurricular_mark"><?php echo get_phrase('extracurricular_mark'); ?></label>
                                    <?php if (!empty($student_extracurriculars)) { ?>
                                        <?php  if(!empty($raport)){ ?>
                                            <div class="col-md-4">
                                                <?php 
                                                    $raport_or = $raport['organizations_id'];
                                                        $raport_eskul = explode(",", $raport_or);
                                                        foreach($raport_eskul as $raport_esk){
                                                        $organizations = $this->db->get_where('organizations', array('id' => $raport_esk))->row_array();
                                                        ?>
                                                        <h5 style="font-weight: bold;"><?= $organizations['name'];?> </h5><br>
                                                <?php } ?>
                                            </div>
                                            <div class="col-md-4">
                                                <?php 
                                                    $extracurricular_mark = $raport['extracurricular_mark'];
                                                        $raport_mark = explode(",", $extracurricular_mark);
                                                        foreach($raport_mark as $mark){
                                                        ?>
                                                        <input type="text" name="extracurricular_mark[]" id="extracurricular_mark" class="form-control" placeholder="<?php echo get_phrase('extracurricular_mark'); ?>" 
                                                        value="<?= $mark?>"><br>
                                                <?php } ?>
                                            </div>
                                        <?php }else{ ?>
                                            <div class="col-md-9">
                                                <table width="100%">
                                                    <?php 
                                                        $student_eks = $student_extracurriculars['organizations_id'];
                                                            $organization = explode(",", $student_eks);
                                                            foreach($organization as $organ){
                                                            $eksul = $this->db->get_where('organizations', array('id' => $organ))->row_array();
                                                            ?>
                                                            <tr>
                                                                <th>
                                                                    <input type="text" name="extracurricular_mark[]" id="extracurricular_mark" class="form-control" placeholder="<?php echo get_phrase('extracurricular_mark'); ?>" value="<?= $eksul['name'];?>" disabled><br>
                                                                </th>
                                                                <th>
                                                                    <input type="text" name="extracurricular_mark[]" id="extracurricular_mark" class="form-control" placeholder="<?php echo get_phrase('extracurricular_mark'); ?>"><br>
                                                                </th>
                                                            </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        <?php } ?>
                                    
                                    <?php } else { ?>

                                        <div class="col-md-4">
                                            <?php echo get_phrase('tidak_mengikuti_ekstrakurikuler'); ?>
                                        </div>

                                    <?php } ?>
                                    
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="achievements_student"><?php echo get_phrase('achievements_student'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" name="achievements_student" id="achievements_student" class="form-control" placeholder="<?php echo get_phrase('achievements_student'); ?>" value="<?= $raport['achievements_student'];?>">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="raport_caption"><?php echo get_phrase('raport_caption'); ?></label>
                                <div class="col-md-9">
                                    <textarea name="raport_caption" class="form-control" id="raport_caption" cols="10" rows="10" placeholder="<?php echo get_phrase('achievements_student'); ?>" required><?= $raport['raport_caption'];?></textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="spiritual"><?php echo get_phrase('sikap_spiritual'); ?></label>
                                <div class="col-md-9">
                                    <textarea name="spiritual" class="form-control" id="spiritual" cols="10" rows="10" placeholder="<?php echo get_phrase('sikap_spiritual'); ?>" required><?= $raport['spiritual'];?></textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="social"><?php echo get_phrase('sikap_sosial'); ?></label>
                                <div class="col-md-9">
                                    <textarea name="social" class="form-control" id="social" cols="10" rows="10" placeholder="<?php echo get_phrase('sikap_sosial'); ?>" required><?= $raport['social'];?></textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="hearing"><?php echo get_phrase('hearing'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" name="hearing" id="hearing" class="form-control" placeholder="<?php echo get_phrase('hearing'); ?>" required value="<?= $raport['hearing'];?>">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="vision"><?php echo get_phrase('vision'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" name="vision" id="vision" class="form-control" placeholder="<?php echo get_phrase('vision'); ?>" required value="<?= $raport['vision'];?>">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="hand"><?php echo get_phrase('hand'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" name="hand" id="hand" class="form-control" placeholder="<?php echo get_phrase('hand'); ?>" required value="<?= $raport['hand'];?>">
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-md-3 col-form-label" for="foot"><?php echo get_phrase('foot'); ?></label>
                                <div class="col-md-9">
                                    <input type="text" name="foot" id="foot" class="form-control" placeholder="<?php echo get_phrase('foot'); ?>" required value="<?= $raport['foot'];?>">
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4"><?php echo get_phrase('save'); ?></button>
                                <a href="<?php echo route('raport/print_raport/'.$raport['id']); ?>" class="btn btn-secondary col-md-4 col-sm-12 mb-4" target="_blank"><?php echo get_phrase('print_raport'); ?></a>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script type="text/javascript">
var form;
$(".ajaxForm").submit(function(e) {
  form = $(this);
  ajaxSubmit(e, form, refreshForm);
  location.reload();
});
var refreshForm = function () {
    form.trigger("reset");
}
</script>