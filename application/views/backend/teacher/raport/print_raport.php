<style type="text/css">
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        /* font: 12pt "Tahoma"; */
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
        margin: 10mm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }
    
    @page {
        size: A4;
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
        .page {
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
    }
    .garis_tepi1 {
        border: 1px solid black;
    }
    .upper { 
        text-transform: uppercase; 
    }
</style>
<?php
  $school_id = school_id();
  $active_session = active_session();
  $raport_details = $this->crud_model->get_raport_by_id($raport_id);
  $student_details = $this->user_model->get_student_details_by_id('student', $raport_details['student_id']);
  $class = $this->crud_model->get_class_details_by_id($student_details['class_id'])->row_array();
  $section = $this->crud_model->get_section_details_by_id('section',$student_details['section_id'])->row_array();
  $sessions = $this->db->get_where('sessions', array('id' => $raport_details['session']))->row_array();
  $school_data = $this->settings_model->get_current_school_data();
  $date = Date('d-m-Y H:i:s'); 
  $tahun = date('Y', strtotime($date));
 ?>
<div class="book">

    <div class="page">
        <div class="subpage">
            <center>
                <img class="img-mid-places" src="<?php echo base_url();?>assets/backend/images/tut_wuri.jpg" alt="" width="250px" height="170px">
                <div class="upper"><h1><?php echo get_phrase('rapor_peserta_didik'); ?></h1><br><br></div>
                <img class="img-mid-places" src="<?php echo $this->settings_model->get_logo_dark(); ?>" alt="" width="170px" height="150px"><br><br>
                <div class="upper"><h3><?php echo get_phrase('nama_peserta_didik'); ?></h3><br></div>
                <div class="upper"><div class="garis_tepi1"><h3><?= $student_details['name'];?></h3></div></div><br><br>
                <div class="upper"><h3><?php echo get_phrase('nisn'); ?></h3><br></div>
                <div class="upper"><div class="garis_tepi1"><h3><?= $student_details['nisn'];?></h3></div></div>
                <div class="upper"><h3><?php echo get_phrase('kementerian_pendidikan_dan_kebudayaan_republik_indonesia'); ?></h3><br></div>
                <div class="upper"><h3><?php echo get_phrase('tahun'); ?> <?=$tahun?></h3><br></div>
            </center>
        </div>    
    </div>

    <div class="page">
        <div class="subpage">
        <table width="100%">
            <tr>
                <td><?php echo get_phrase('name'); ?></td>
                <td>:</td>
                <td><?= $student_details['name'];?></td>
                <td><?php echo get_phrase('class'); ?></td>
                <td>:</td>
                <td><?= $class['name'];?> <?= $section['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('nisn'); ?></td>
                <td>:</td>
                <td><?= $student_details['nisn'];?></td>
                <td><?php echo get_phrase('session'); ?></td>
                <td>:</td>
                <td><?= $sessions['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('school_name'); ?></td>
                <td>:</td>
                <td><?= $school_data['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('address'); ?></td>
                <td>:</td>
                <td><?= $school_data['address'];?></td>
            </tr>
        </table><br>

        <h5><?php echo get_phrase('a_sikap'); ?></h5>
<div class="row ">
    <div class="col-md-12">
        <table class="table table-bordered" width="100%" style="text-align: center;">
            <thead>
                
                <tr>
                    <th colspan="2"><?php echo get_phrase('deskripsi'); ?></th>
                </tr>
                </thead>
            <tbody>
                <tr>
                    <th><?php echo get_phrase('1_sikap_spiritual'); ?></th>
                    <td><?php echo $raport_details['spiritual']; ?></td>
                </tr>
                    <tr>
                    <th><?php echo get_phrase('2_sikap_sosial'); ?></th>
                    <td><?php echo $raport_details['social']; ?></td>
                    </tr>
            </tbody>
        </table> 
    </div>
</div>       
        </div>    
    </div>

    <div class="page">
        <div class="subpage">
        <table width="100%">
            <tr>
                <td><?php echo get_phrase('name'); ?></td>
                <td>:</td>
                <td><?= $student_details['name'];?></td>
                <td><?php echo get_phrase('class'); ?></td>
                <td>:</td>
                <td><?= $class['name'];?> <?= $section['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('nisn'); ?></td>
                <td>:</td>
                <td><?= $student_details['nisn'];?></td>
                <td><?php echo get_phrase('session'); ?></td>
                <td>:</td>
                <td><?= $sessions['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('school_name'); ?></td>
                <td>:</td>
                <td><?= $school_data['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('address'); ?></td>
                <td>:</td>
                <td><?= $school_data['address'];?></td>
            </tr>
        </table><br>

        <h5><?php echo get_phrase('b_nilai_akademik'); ?></h5>
<div class="row ">
    <div class="col-md-12">
        <table class="table table-bordered" width="100%" style="text-align: center;">
            <thead>
                <tr>
                    <th rowspan="2"><?php echo get_phrase('nomor'); ?></th>
                    <th rowspan="2"><?php echo get_phrase('subject'); ?></th>
                    <th colspan="3"><?php echo get_phrase('knowledge'); ?></th>
                    <th colspan="3"><?php echo get_phrase('skills'); ?></th>
                </tr>
                <tr>
                    <th><?php echo get_phrase('nilai'); ?></th>
                    <th><?php echo get_phrase('predikat'); ?></th>
                    <th><?php echo get_phrase('deskripsi'); ?></th>
                    <th><?php echo get_phrase('nilai'); ?></th>
                    <th><?php echo get_phrase('predikat'); ?></th>
                    <th><?php echo get_phrase('deskripsi'); ?></th>
                </tr>
            </thead>
            <?php
            $no = 1;
            $subjects = $this->db->get_where('subjects', array('class_id' => $student_details['class_id'],'section_id' => $student_details['section_id']))->result_array();
            foreach($subjects as $subject):
            $average = $this->db->get_where('marks', array('subject_id' => $subject['id'],'student_id' => $raport_details['student_id'], 'session' => $active_session))->row_array();
            ?>
            <tbody>
                    <tr>
                        <td><?=$no++;?></td>
                        <td><?php echo $subject['name']; ?></td>
                        <td>
                        <?php
                        if ($average == 0){
                            echo  get_phrase('no_value_yet');
                        }else{
                        echo $average['mark_knowledge'];
                        }
                        ?>
                        </td>
                        <td><span id="grade-for-mark-<?php echo $raport_details['student_id']; ?>"><?php echo get_grade($average['mark_knowledge']); ?></span> </td>
                        <td><?php echo $subject['description']; ?></td>
                        <td>
                        <?php
                        if ($average == 0){
                            echo  get_phrase('no_value_yet');
                        }else{
                        echo $average['mark_skills'];
                        }
                        ?>
                        </td>
                        <td><span id="grade-for-mark-<?php echo $raport_details['student_id']; ?>"><?php echo get_grade($average['mark_skills']); ?></span> </td>
                        <td><?php echo $subject['description']; ?></td>
                    </tr>
            </tbody>
            <?php endforeach; ?>
        </table> 
    </div>
</div>       
        </div>    
    </div>

    <div class="page">
        <div class="subpage">
        <table width="100%">
            <tr>
                <td><?php echo get_phrase('name'); ?></td>
                <td>:</td>
                <td><?= $student_details['name'];?></td>
                <td><?php echo get_phrase('class'); ?></td>
                <td>:</td>
                <td><?= $class['name'];?> <?= $section['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('nisn'); ?></td>
                <td>:</td>
                <td><?= $student_details['nisn'];?></td>
                <td><?php echo get_phrase('session'); ?></td>
                <td>:</td>
                <td><?= $sessions['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('school_name'); ?></td>
                <td>:</td>
                <td><?= $school_data['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('address'); ?></td>
                <td>:</td>
                <td><?= $school_data['address'];?></td>
            </tr>
        </table><br>

        <h5><?php echo get_phrase('c_extracurricular'); ?></h5>
        <div class="row ">
        <div class="col-md-12">
            <table class="table table-bordered" width="100%">
                <tr>
                <?php 
                $raport_or = $raport_details['organizations_id'];
                    $raport_eskul = explode(",", $raport_or);
                    foreach($raport_eskul as $raport_esk){
                    $organizations = $this->db->get_where('organizations', array('id' => $raport_esk))->row_array();
                    ?>
                    <td><h5 style="font-weight: bold;"><?= $organizations['name'];?> </h5></td>
                <?php
                    }
                    ?>
                </tr>
            
                <tr>
                <?php 
                $extracurricular_mark = $raport_details['extracurricular_mark'];
                    $raport_mark = explode(",", $extracurricular_mark);
                    foreach($raport_mark as $mark){
                    ?>
                    <td><h5 style="font-weight: bold;"><?= $mark?></h5></td>
                <?php
                    }
                    ?>
                </tr>
            </table> 
        </div>
        </div>
        
        <h5><?php echo get_phrase('d_achievements'); ?></h5>
        <div class="row ">
            <div class="col-md-12">
                <table class="table table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th><?php echo get_phrase('achievements_student'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $raport_details['achievements_student']; ?></td>
                        </tr>
                    </tbody>
                </table> 
            </div>
        </div>

        <h5><?php echo get_phrase('e_attendance'); ?></h5>
        <div class="row ">
            <div class="col-md-12">
                <table class="table table-bordered" width="100%">
                        <tr>
                            <td><?php echo get_phrase('permission'); ?></td>
                            <td><?php echo $raport_details['attendance_permission']; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('sick'); ?></td>
                            <td><?php echo $raport_details['attendance_sick']; ?></td>
                        </tr>
                        <tr>
                            <td><?php echo get_phrase('absent'); ?></td>
                            <td><?php echo $raport_details['attendance_absent']; ?></td>
                        </tr>
                </table> 
            </div>
        </div>
        </div>
    </div>
    <div class="page">
        <div class="subpage">
        <table width="100%">
            <tr>
                <td><?php echo get_phrase('name'); ?></td>
                <td>:</td>
                <td><?= $student_details['name'];?></td>
                <td><?php echo get_phrase('class'); ?></td>
                <td>:</td>
                <td><?= $class['name'];?> <?= $section['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('nisn'); ?></td>
                <td>:</td>
                <td><?= $student_details['nisn'];?></td>
                <td><?php echo get_phrase('session'); ?></td>
                <td>:</td>
                <td><?= $sessions['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('school_name'); ?></td>
                <td>:</td>
                <td><?= $school_data['name'];?></td>
            </tr>
            <tr>
                <td><?php echo get_phrase('address'); ?></td>
                <td>:</td>
                <td><?= $school_data['address'];?></td>
            </tr>
        </table><br>

        <h5><?php echo get_phrase('f_catatan_walikelas'); ?></h5>
        <div class="row ">
            <div class="col-md-12">
                <table class="table table-bordered" width="100%">
                        <tr>
                            <td><?php echo $raport_details['raport_caption']; ?></td>
                        </tr>
                </table> 
            </div>
        </div>

        <h5><?php echo get_phrase('g_tinggi_dan_berat_badan_siswa'); ?></h5>
        <div class="row ">
            <div class="col-md-12">
                <table class="table table-bordered" width="100%" style="text-align: center;">
                <thead>
                    <tr>
                        <th><?php echo get_phrase('nomor'); ?></th>
                        <th><?php echo get_phrase('aspek_yang_dinilai'); ?></th>
                        <th><?php echo get_phrase('nilai'); ?></th>
                    </tr>
                </thead>
                <?php
                $no = 1;
                ?>
                <tbody>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?php echo get_phrase('height'); ?></td>
                            <td><?= $student_details['height'];?> <?php echo get_phrase('cm'); ?></td>
                        </tr>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?php echo get_phrase('weight'); ?></td>
                            <td><?= $student_details['weight'];?> <?php echo get_phrase('kg'); ?></td>
                        </tr>
                </tbody>
                </table>
            </div>
        </div>

        <h5><?php echo get_phrase('h_kondisi_kesehatan'); ?></h5>
        <div class="row ">
            <div class="col-md-12">
            <table class="table table-bordered" width="100%" style="text-align: center;">
                <thead>
                    <tr>
                        <th><?php echo get_phrase('nomor'); ?></th>
                        <th><?php echo get_phrase('aspek_fisik'); ?></th>
                        <th><?php echo get_phrase('ket'); ?></th>
                    </tr>
                </thead>
                <?php
                $no = 1;
                ?>
                <tbody>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?php echo get_phrase('hearing'); ?></td>
                            <td><?= $raport_details['hearing'];?></td>
                        </tr>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?php echo get_phrase('vision'); ?></td>
                            <td><?= $raport_details['vision'];?></td>
                        </tr>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?php echo get_phrase('hand'); ?></td>
                            <td><?= $raport_details['hand'];?></td>
                        </tr>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?php echo get_phrase('foot'); ?></td>
                            <td><?= $raport_details['foot'];?></td>
                        </tr>
                </tbody>
                </table>
            </div>
        </div>

        </div>    
    </div>

    <div class="d-print-none mt-4">
        <div class="text-right">
            <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> <?php echo get_phrase('print'); ?></a>
        </div>
    </div>
</div>
<script>
function get_grade(exam_mark, id){
            $.ajax({
              url : '<?php echo route('get_grade'); ?>/'+exam_mark,
              success : function(response){
                $('#grade-for-'+id).text(response);
              }
            });
          }
</script>