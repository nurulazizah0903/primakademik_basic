<?php  
  $item_pendidikan = [
    get_phrase('No_school'),
    get_phrase('Not_completed_in_primary_school'),
    get_phrase('Primary_school'),
    get_phrase('junior_high'),
    get_phrase('high_school'),
    get_phrase('diploma'),
    get_phrase('Bachelor'),
    get_phrase('master'),
    get_phrase('doctor')
  ];

  $item_pekerjaan = [
    get_phrase('civil_servant'),
    get_phrase('Farmer'),
    get_phrase('Private_employees'),
    get_phrase('entrepreneur'),
    get_phrase('army_police'),
    get_phrase('Merchants'),
    get_phrase('Labor'),
    get_phrase('unemployment'),
    get_phrase('Others')
  ];

  $item_penghasilan = [
    get_phrase('034'),
    get_phrase('034_069'),
    get_phrase('069_14'),
    get_phrase('14_34'),
    get_phrase('34_69'),
    get_phrase('69_138'),
    get_phrase('138'),
    get_phrase('0')
  ];

  $item_agama = [
    get_phrase('Islam'),
    get_phrase('catholic'),
    get_phrase('Buddha'),
    get_phrase('Christian'),
    get_phrase('Hindu'),
    get_phrase('Others')
  ];

  $item_golongan_darah = [
    "A",
    "B",
    "AB",
    "O"
  ];
?>

<div class="wrapper">

<div class="main-section" id="home">

    <header>
        <div class="container">
            <div class="header-content d-flex flex-wrap align-items-center">
                <div class="logo">
                    <a href="<?= base_url() ?>" title="">
                        <img src="<?php echo $this->settings_model->get_favicon(); ?>" alt="" width="50" length="50"> 
                    </a> 
                    <h2></h2>
                </div><!--logo end-->
                <div class="menu-btn">
                    <a href="#">
                        <span class="bar1"></span>
                        <span class="bar2"></span>
                        <span class="bar3"></span>
                    </a>
                </div><!--menu-btn end-->
            </div><!--header-content end-->
            <div class="navigation-bar d-flex flex-wrap align-items-center">
                <nav>
                    <ul>
                        <li><a href="<?php echo base_url(); ?>" title=""><i class="fas fa-arrow-left"></i></a></li>
                    </ul>
                </nav><!--nav end-->
            </div><!--navigation-bar end-->
            <!-- <div class="navigation-bar d-flex flex-wrap align-items-center">
                <nav>
                    <ul>
                    <li><a href="<?php echo base_url().'home/search'; ?>" title=""><?php echo get_phrase('cari'); ?></a></li>
                    </ul>
                </nav>
            </div> -->
        </div>
    </header><!--header end-->

    <div class="responsive-menu">
        <ul>
            <li><a href="<?php echo base_url();?>" title=""><i class="fas fa-arrow-left"></i></a></li>
        </ul>
    </div><!--responsive-menu end-->

    <section style="margin-bottom: 6em;">
        <div class="container">
            <div class="col align-items-center">
                <h2 class="mb-3 text-center" style="font-size:28px; color: #2b2b2b;"><?php echo get_phrase('daftar_ppdb_online'); ?></h2>
                <font color="black"><?php echo get_phrase('yang_bertanda'); ?> <font color="red">*</font> <?php echo get_phrase('wajib_diisi'); ?></font>
                <div class="container-md shadow-sm bg-light rounded px-4 py-4" style="">
                  <?php /* echo form_open_multipart('home/registration'); */?>
                  <form method="POST" name="myForm" class="col-12 d-block ajaxForm" action="<?php echo site_url('home/registration'); ?>" onsubmit="return validateForm()" enctype="multipart/form-data">
                    <!-- page 1 -->
                    <div id="page_1">
                      <h2 class="text-center mb-3"><?php echo get_phrase('identitas_calon'); ?></h2>
                      <?php /*<div class="form-group row">
                          <label for="name" class="col-sm-3"><?php echo get_phrase('select_school'); ?> <font color="red">*</font></label></label>
                          <select name="schoolId" id="schoolId" class="form-control col-sm-8" required>
                              <option value=""><?php echo get_phrase('select_school'); ?></option>
                              <?php
                              $schools = $this->crud_model->get_schools()->result_array();
                              foreach ($schools as $school): ?>
                                  <option value="<?php echo $school['id']; ?>"><?php echo $school['name']; ?></option>
                              <?php endforeach; ?>
                          </select>
                      </div> */?>
                      <div class="form-group row">
                        <label for="namaLengkap" class="col-sm-3"><?php echo get_phrase('nama_lengkap'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['nama_lengkap'] ?>" type="text" class="form-control col-sm-8" name="namaLengkap" id="namaLengkap" aria-describedby="" placeholder="">
                      </div>
                      <div class="form-group row">
                        <label for="namaPanggilan" class="col-sm-3"><?php echo get_phrase('nama_panggilan'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['nama_panggilan'] ?>" type="text" class="form-control col-sm-8" name="namaPanggilan" id="namaPanggilan" placeholder="">
                      </div>

                      <div class="form-group row">
                        <label for="" class='col-sm-3'><?php echo get_phrase('jenis_kelamin'); ?> <font color="red">*</font></label>
                        <div>
                          <div class="form-check">
                            <input checked class="form-check-input" type="radio" name="jenisKelamin" id="jenisKelaminL" value="Male">
                            <label class="form-check-label" for="jenisKelaminL">
                            <?php echo get_phrase('laki_laki'); ?>
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="jenisKelamin" id="jenisKelaminP" value="Female">
                            <label class="form-check-label" for="jenisKelaminP">
                            <?php echo get_phrase('perempuan'); ?>
                            </label>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <label for="nisn" class="col-sm-3"><?php echo get_phrase('nisn'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['nisn'] ?>" type="number" class="form-control col-sm-8" name="nisn" id="nisn" placeholder="">
                        <i style="float: left;font-size: 12px;color: red" class="col-sm-3"><?php echo get_phrase('NISN_untuk_passwod'); ?></i>
                      </div>
                      <div class="form-group row">
                        <label for="nik" class="col-sm-3"><?php echo get_phrase('nik'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['nik'] ?>" type="number" class="form-control col-sm-8" name="nik" id="nik" placeholder="">
                      </div>
                      <div class="form-group row">
                        <label for="tempatLahir" class="col-sm-3"><?php echo get_phrase('tempat_lahir'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['tempat_lahir'] ?>" type="text" class="form-control col-sm-8" name="tempatLahir" id="tempatLahir" placeholder="">
                      </div>
                      <div class="form-group row">
                        <label for="tglLahir" class="col-sm-3"><?php echo get_phrase('tgl_lahir'); ?> <font color="red">*</font></label>
                        <!-- <div class="input-group date" data-provide="datepicker"> -->
                            <input required value="<?= $data['tgl_lahir'] ?>" type="text" id="tglLahir" placeholder="dd/mm/yyyy" class="form-control col-sm-8" name="tglLahir">
                            <!-- <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div> -->
                      </div>

                      <!-- FIELD AGAMA -->
                      <?php 
                        $field_name = "agama";
                        $field_label = get_phrase('agama');

                        $items = $item_agama;

                        $field_form_check = "";
                        $checked = 'checked';
                        foreach ($items as $item) {
                          $html_item = '
                            <div class="form-check">
                              <input '. $checked .' class="form-check-input" type="radio" name="'. $field_name .'" id="'. $field_name . $item .'" value="'. $item .'">
                              <label class="form-check-label" for="'. $field_name . $item .'">
                                '. $item .'
                              </label>
                            </div>
                          ';

                          $checked = "";

                          $field_form_check .= $html_item;
                        }
                        
                        echo '
                          <div class="form-group row">
                            <label for="'. $field_name .'" class="col-sm-3">'. $field_label .'<font color="red">*</font></label>
                            <div>
                              '. $field_form_check .'
                            </div>
                          </div>
                        ';
                      ?>

                      <!-- FIELD GOLONGAN DARAH -->
                      <?php 
                        $field_name = "golonganDarah";
                        $field_label = get_phrase('gol_darah');

                        $items = $item_golongan_darah;

                        $field_form_check = "";
                        $checked = 'checked';
                        foreach ($items as $item) {
                          $html_item = '
                            <div class="form-check">
                              <input '. $checked .' class="form-check-input" type="radio" name="'. $field_name .'" id="'. $field_name . $item .'" value="'. $item .'">
                              <label class="form-check-label" for="'. $field_name . $item .'">
                                '. $item .'
                              </label>
                            </div>
                          ';
                          $checked = "";
                          $field_form_check .= $html_item;
                        }
                        
                        echo '
                          <div class="form-group row">
                            <label for="'. $field_name .'" class="col-sm-3">'. $field_label .'<font color="red">*</font></label>
                            <div>
                              '. $field_form_check .'
                            </div>
                          </div>
                        ';
                      ?>

                      <div class="form-group row">
                        <label for="alamat" class="col-sm-3"> <?php echo get_phrase('alamat'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['alamat'] ?>" type="text" class="form-control col-sm-8" name="alamat" id='alamat'>
                      </div>
                      <div class="form-group row">
                        <label for="telephone" class="col-sm-3"><?php echo get_phrase('telephone'); ?> <font color="red">*</font></label>
                        <input  required value="<?= $data['telephone'] ?>"type="number" class="form-control col-sm-8" name="telephone" id='telephone'>
                      </div>
                      <div class="form-group row">
                        <label for="emailSiswa" class="col-sm-3"><?php echo get_phrase('email_siswa'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['email_siswa'] ?>" type="email" class="form-control col-sm-8" name="emailSiswa" id='emailSiswa'>
                      </div>

                      <br />
                      
                      <div class="row">
                        <button type="button" data-id="1" class="btn btn-primary ml-auto nextTab">Next</button>
                      </div>
                    </div>

                    <!-- page 2 -->
                    <div id='page_2' style='display: none;'>
                      <h2 class="text-center mb-3"><?php echo get_phrase('data_ortu'); ?></h2>

                      <div class="form-group row">
                        <label for="namaOrangTua" class="col-sm-3"><?php echo get_phrase('nama_orang_tua'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['nama_orang_tua'] ?>" type="text" class="form-control col-sm-8" name="namaOrangTua" id='namaOrangTua'>
                      </div>

                      <div class="form-group row">
                        <label for="emailOrangTua" class="col-sm-3"><?php echo get_phrase('email_orang_tua'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['email_orang_tua'] ?>" type="email" class="form-control col-sm-8" name="emailOrangTua" id='emailOrangTua'>
                      </div>
                      
                      <div class="form-group row">
                        <label for="tglLahirOrangTua" class="col-sm-3"><?php echo get_phrase('tgl_lahir_orang_tua'); ?> <font color="red">*</font></label>
                        <!-- <div class="input-group date" data-provide="datepicker"> -->
                            <input required value="<?= $data['tgl_lahir_orang_tua'] ?>" type="text" id="tgl_lahir_orang_tua" placeholder="dd/mm/yyyy" class="form-control col-sm-8" name="tglLahirOrangTua">
                            <!-- <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div> -->
                        <!-- </div> -->
                      </div>
                      
                      <!-- FIELD PENDIDIKAN AYAH -->
                      <?php 
                        $field_name = "pendidikanOrangTua";
                        $field_label = get_phrase('pendidikan_orang_tua');

                        $items = $item_pendidikan;

                        $field_form_options = "";

                        foreach ($items as $item) {
                          $html_item = '
                            <option value="'. $item .'">'. $item .'</option>
                          ';

                          $field_form_options .= $html_item;
                        }
                        
                        echo '
                          <div class="form-group row">
                            <label for="'. $field_name .'" class="col-sm-3">'. $field_label .'<font color="red">*</font></label>
                            <select class="form-select form-control col-sm-5" aria-label="pendidikan ayah" name="'. $field_name .'" id="'. $field_name .'">
                              <option value="'. $data['pendidikanOrangTua'].'" selected>'. get_phrase('silahkan_pilih') .'</option>
                              '. $field_form_options .'
                            </select>
                          </div>
                        ';
                      ?>

                      <div class="form-group row">
                        <label for="keadaanOrangTua" class="col-sm-3"><?php echo get_phrase('keadaan_orang_tua'); ?> <font color="red">*</font></label>
                        <div>
                        <div class="form-check">
                          <input checked class="form-check-input" type="radio" name="keadaanOrangTua" id="keadaanOrangTuaHidup" value="HIDUP">
                          <label class="form-check-label" for="keadaanOrangTuaHidup">
                          <?php echo get_phrase('masih_hidup'); ?>
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="keadaanOrangTua" id="keadaanOrangTuaMeninggal" value="MENINGGAL">
                          <label class="form-check-label" for="keadaanOrangTuaMeninggal">
                          <?php echo get_phrase('sudah_meninggal'); ?>
                          </label>
                        </div>
                        </div>
                      </div>

                      <!-- FIELD PEKERJAAN AYAH -->
                      <?php 
                        $field_name = "pekerjaanOrangTua";
                        $field_label = get_phrase('pekerjaan_orang_tua'); 

                        $items = $item_pekerjaan;

                        $field_form_check = "";

                        $checked = "checked";

                        foreach ($items as $item) {
                          $html_item = '
                            <div class="form-check">
                              <input '.$checked.' class="form-check-input" type="radio" name="'. $field_name .'" id="'. $field_name . $item .'" value="'. $item .'">
                              <label class="form-check-label" for="'. $field_name . $item .'">
                                '. $item .'
                              </label>
                            </div>
                          ';
                          $checked = '';

                          $field_form_check .= $html_item;
                        }
                        
                        echo '
                          <div class="form-group row">
                            <label for="'. $field_name .'" class="col-sm-3">'. $field_label .'<font color="red">*</font></label>
                            <div>
                              '. $field_form_check .'
                            </div>
                          </div>
                        ';
                      ?>

                      <!-- FIELD PENGHASILAN AYAH -->
                      <?php 
                        $field_name = "penghasilanOrangTua";
                        $field_label = get_phrase('penghasilan_orang_tua');
                        $pilih = get_phrase('silahkan_pilih'); 

                        $items = $item_penghasilan;

                        $field_form_options = "";

                        foreach ($items as $item) {
                          $html_item = '
                            <option value="'. $item .'">'. $item .'</option>
                          ';

                          $field_form_options .= $html_item;
                        }
                        
                        echo '
                          <div class="form-group row">
                            <label for="'. $field_name .'" class="col-sm-3">'. $field_label .'<font color="red">*</font></label>
                            <select class="form-select form-control col-sm-5" aria-label="pendidikan ayah" name="'. $field_name .'" id="'. $field_name .'">
                              <option value="'. $data['penghasilanOrangTua'].'" selected>'. $pilih .'</option>
                              '. $field_form_options .'
                            </select>
                          </div>
                        ';
                      ?>

                      <div class="form-group row">
                        <label for="alamatOrangTua" class="col-sm-3"><?php echo get_phrase('alamat_orang_tua'); ?> <font color="red">*</font></label>
                        <textarea value="<?php $data['alamat_orang_tua'] ?>" name="alamatOrangTua" id="alamatOrangTua" cols="30" rows="4" class="form-control col-sm-8" required><?php echo $data['alamat_orang_tua'] ?></textarea>
                      </div>

                      <br />
                      
                      <div class="row">
                        <button type="button" onClick="prevPage(this)" class="btn btn-primary">Back</button>
                        <!-- <button type="button" onClick="nextPage(this)" class="btn btn-primary ml-auto">Next</button> -->
                        <button type="button" data-id="2" class="btn btn-primary ml-auto nextTab">Next</button>
                      </div>
                    </div>

                    <!-- page 3 -->
                    <div id='page_3' style='display: none;'>
                      <h2 class="text-center mb-3"><?php echo get_phrase('data_wali'); ?></h2>

                      <div class="form-group row">
                        <label for="namaWali" class="col-sm-3"><?php echo get_phrase('nama_wali'); ?></label>
                        <input value="<?= $data['nama_wali'] ?>" type="text" class="form-control col-sm-8" name="namaWali" id='namaWali'>
                      </div>

                      <div class="form-group row">
                        <label for="emailWali" class="col-sm-3"><?php echo get_phrase('email_wali'); ?></label>
                        <input value="<?= $data['email_wali'] ?>" type="email" class="form-control col-sm-8" name="emailWali" id='emailWali'>
                      </div>
                      
                      <div class="form-group row">
                        <label for="tglLahirWali" class="col-sm-3"><?php echo get_phrase('tgl_lahir_wali'); ?></label>
                        <!-- <div class="input-group date" data-provide="datepicker"> -->
                            <input value="<?= $data['tgl_lahir_wali'] ?>" type="text" id="tgl_lahir_wali" placeholder="dd/mm/yyyy" class="form-control col-sm-8" name="tglLahirWali">
                            <!-- <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div> -->
                        <!-- </div> -->
                      </div>
                      
                      <!-- FIELD PENDIDIKAN AYAH -->
                      <?php 
                        $field_name = "pendidikanWali";
                        $field_label = get_phrase('pendidikan_wali');

                        $items = $item_pendidikan;

                        $field_form_options = "";

                        foreach ($items as $item) {
                          $html_item = '
                            <option value="'. $item .'">'. $item .'</option>
                          ';

                          $field_form_options .= $html_item;
                        }
                        
                        echo '
                          <div class="form-group row">
                            <label for="'. $field_name .'" class="col-sm-3">'. $field_label .'</label>
                            <select class="form-select form-control col-sm-5" aria-label="pendidikan ayah" name="'. $field_name .'" id="'. $field_name .'">
                              <option value="'. $data['pendidikanWali'].'" >'. get_phrase('silahkan_pilih') .'</option>
                              '. $field_form_options .'
                            </select>
                          </div>
                        ';
                      ?>

                      <div class="form-group row">
                        <label for="keadaanWali" class="col-sm-3"><?php echo get_phrase('keadaan_wali'); ?></label>
                        <div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="keadaanWali" id="keadaanWali" value="HIDUP">
                          <label class="form-check-label" for="keadaanWali">
                          <?php echo get_phrase('masih_hidup'); ?>
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="keadaanWali" id="keadaanWali" value="MENINGGAL">
                          <label class="form-check-label" for="keadaanWali">
                          <?php echo get_phrase('sudah_meninggal'); ?>
                          </label>
                        </div>
                        </div>
                      </div>

                      <!-- FIELD PEKERJAAN AYAH -->
                      <?php 
                        $field_name = "pekerjaanWali";
                        $field_label = get_phrase('pekerjaan_wali'); 

                        $items = $item_pekerjaan;

                        $field_form_check = "";

                        $checked = "checked";

                        foreach ($items as $item) {
                          $html_item = '
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="'. $field_name .'" id="'. $field_name . $item .'" value="'. $item .'">
                              <label class="form-check-label" for="'. $field_name . $item .'">
                                '. $item .'
                              </label>
                            </div>
                          ';
                          $checked = '';

                          $field_form_check .= $html_item;
                        }
                        
                        echo '
                          <div class="form-group row">
                            <label for="'. $field_name .'" class="col-sm-3">'. $field_label .'</label>
                            <div>
                              '. $field_form_check .'
                            </div>
                          </div>
                        ';
                      ?>

                      <!-- FIELD PENGHASILAN AYAH -->
                      <?php 
                        $field_name = "penghasilanWali";
                        $field_label = get_phrase('penghasilan_wali');
                        $pilih = get_phrase('silahkan_pilih'); 

                        $items = $item_penghasilan;

                        $field_form_options = "";

                        foreach ($items as $item) {
                          $html_item = '
                            <option value="'. $item .'">'. $item .'</option>
                          ';

                          $field_form_options .= $html_item;
                        }
                        
                        echo '
                          <div class="form-group row">
                            <label for="'. $field_name .'" class="col-sm-3">'. $field_label .'</label>
                            <select class="form-select form-control col-sm-5" aria-label="pendidikan ayah" name="'. $field_name .'" id="'. $field_name .'">
                              <option value="'. $data['penghasilanWali'].'" selected>'. $pilih .'</option>
                              '. $field_form_options .'
                            </select>
                          </div>
                        ';
                      ?>

                      <div class="form-group row">
                        <label for="alamatWali" class="col-sm-3"><?php echo get_phrase('alamat_wali'); ?></label>
                        <textarea value="<?php $data['alamat_wali'] ?>" name="alamatWali" id="alamatWali" cols="30" rows="4" class="form-control col-sm-8"></textarea>
                      </div>

                      <br />
                      
                      <div class="row">
                        <button type="button" onClick="prevPage(this)" class="btn btn-primary">Back</button>
                        <!-- <button type="button" onClick="nextPage(this)" class="btn btn-primary ml-auto">Next</button> -->
                        <button type="button" data-id="3" class="btn btn-primary ml-auto nextTab">Next</button>
                      </div>
                    </div>

                    <!-- page 4 -->
                    <div id="page_4" style="display: none;">
                      <h2 class="text-center mb-3"><?php echo get_phrase('data_akademik_(3/5)'); ?></h2>

                      <div class="form-group row">
                        <label for="beratBadan" class="col-sm-3"><?php echo get_phrase('berat_badan'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['berat_badan'] ?>" name="beratBadan" type="number" id="beratBadan" class="form-control col-sm-5">
                      </div>

                      <div class="form-group row">
                        <label for="tinggiBadan" class="col-sm-3"><?php echo get_phrase('tinggi_badan'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['tinggi_badan'] ?>" name="tinggiBadan" type="number" id="tinggiBadan" class="form-control col-sm-5">
                      </div>

                      <div class="form-group row">
                        <label for="jarakTempatTinggal" class="col-sm-3"><?php echo get_phrase('jarak_tempat_tinggal'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['jarak_tempat_tinggal'] ?>" name="jarakTempatTinggal" type="number" id="jarakTempatTinggal" class="form-control col-sm-5">
                      </div>

                      <div class="form-group row">
                        <label for="waktuTempuh" class="col-sm-3"><?php echo get_phrase('waktu_tempuh'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['waktu_tempuh'] ?>" name="waktuTempuh" type="number" id="waktuTempuh" class="form-control col-sm-5">
                      </div>

                      <div class="form-group row">
                        <label for="anakKe" class="col-sm-3"><?php echo get_phrase('anak_ke'); ?><font color="red">*</font></label>
                        <input required value="<?= $data['anak_ke'] ?>" name="anakKe" type="number" id="anakKe" class="form-control col-sm-5">
                      </div>

                      <div class="form-group row">
                        <label for="jumlahSaudara" class="col-sm-3"><?php echo get_phrase('jumlah_saudara'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['jumlah_saudara'] ?>" name="jumlahSaudara" type="number" id="jumlahSaudara" class="form-control col-sm-5">
                      </div>

                      <br />

                      <div class="row">
                        <button type="button" onClick="prevPage(this)" class="btn btn-primary">Back</button>
                        <!-- <button type="button" onClick="nextPage(this)" class="btn btn-primary ml-auto">Next</button> -->
                        <button type="button" data-id="4" class="btn btn-primary ml-auto nextTab">Next</button>
                      </div>

                    </div>

                    <!-- page 5 -->
                    <div id="page_5" style="display: none;">
                      <h2 class="text-center mb-4"><?php echo get_phrase('data_akademik'); ?></h2>

                      <div class="form-group row">
                        <label for="sekolahAsal" class="col-sm-3"><?php echo get_phrase('sekolah_asal'); ?></label>
                        <input value="<?= $data['sekolah_asal'] ?>" name="sekolahAsal" id="sekolahAsal" class="form-control col-sm-8">
                      </div>

                      <div class="form-group row">
                        <label for="alamatSekolahAsal" class="col-sm-3"><?php echo get_phrase('alamat_sekolah_asal'); ?></label>
                        <textarea value="<?= $data['alamat_sekolah_asal'] ?>" name="alamatSekolahAsal" id="alamatSekolahAsal" col="30" row="4" class="form-control col-sm-8"></textarea>
                      </div>

                      <div class="form-group row">
                        <label for="noPesertaUjian" class="col-sm-3"><?php echo get_phrase('no_peserta_ujian'); ?></label>
                        <input value="<?= $data['no_peserta_ujian'] ?>" name="noPesertaUjian" type="number" id="noPesertaUjian" class="form-control col-sm-5">
                      </div>

                      <div class="form-group row">
                        <label for="noSeriIjazah" class="col-sm-3"><?php echo get_phrase('no_seri_ijazah'); ?></label>
                        <input value="<?= $data['no_seri_ijazah'] ?>" name="noSeriIjazah"  id="noSeriIjazah" class="form-control col-sm-5">
                      </div>

                      <div class="form-group row">
                        <label for="tahunKelulusan" class="col-sm-3"><?php echo get_phrase('tahun_kelulusan'); ?></label>
                        <input value="<?= $data['tahun_kelulusan'] ?>" name="tahunKelulusan" type="number" id="tahunKelulusan" class="form-control col-sm-5">
                      </div>

                      <h3>Nilai Ujian Nasional</h3>

                      <div class="form-group row">
                        <label for="nilaiBhsIndo" class="col-sm-3"><?php echo get_phrase('nilai_bhs_indo'); ?></label>
                        <input value="<?= $data['nilai_bhs_indo'] ?>" name="nilaiBhsIndo" type="number" id="nilaiBhsIndo" class="form-control col-sm-3">
                      </div>

                      <div class="form-group row">
                        <label for="nilaiBhsInggris" class="col-sm-3"><?php echo get_phrase('nilai_bhs_inggris'); ?></label>
                        <input value="<?= $data['nilai_bhs_inggris'] ?>" name="nilaiBhsInggris" type="number" id="nilaiBhsInggris" class="form-control col-sm-3">
                      </div>

                      <div class="form-group row">
                        <label for="nilaiMatematika" class="col-sm-3"><?php echo get_phrase('nilai_mtk'); ?></label>
                        <input value="<?= $data['nilai_matematika'] ?>" name="nilaiMatematika" type="number" id="nilaiMatematika" class="form-control col-sm-3">
                      </div>

                      <div class="form-group row">
                        <label for="nilaiIpa" class="col-sm-3"><?php echo get_phrase('nilai_ipa'); ?> </label>
                        <input value="<?= $data['nilai_ipa'] ?>" name="nilaiIpa" id="nilaiIpa" type="number" class="form-control col-sm-3">
                      </div>

                      <br />

                      <div class="row">
                        <button type="button" onClick="prevPage(this)" class="btn btn-primary">Back</button>
                        <!-- <button type="button" onClick="nextPage(this)" class="btn btn-primary ml-auto">Next</button> -->
                        <button type="button" data-id="5" class="btn btn-primary ml-auto nextTab">Next</button>
                      </div>

                    </div>

                    <!-- page 6 -->
                    <div id="page_6" style="display:none;">
                      <h2 class="text-center mb-4"><?php echo get_phrase('upload_file_(5/5)'); ?></h2>

                      <div class="form-group row">
                        <label for="fotoSiswa" class="col-sm-3"><?php echo get_phrase('upload_foto'); ?> <font color="red">*</font></label>
                        <input type="file" name="fotoSiswa" id="fotoSiswa" class="form-control col-sm-3">
                        <i style="float: left;font-size: 12px;color: red" class="col-sm-3"><?php echo get_phrase('file_berformat_gambar'); ?></i>
                      </div>

                      <div class="form-group row">
                        <label for="skhun" class="col-sm-3"><?php echo get_phrase('skhun'); ?> <font color="red">*</font></label>
                        <input type="file" name="skhun" id="skhun" class="form-control col-sm-3">
                        <i style="float: left;font-size: 12px;color: red" class="col-sm-3"><?php echo get_phrase('file_berformat_gambar'); ?></i>
                      </div>

                      <div class="form-group row">
                        <label for="ijazah" class="col-sm-3"><?php echo get_phrase('ijazah'); ?> <font color="red">*</font></label>
                        <input type="file" name="ijazah" id="ijazah" class="form-control col-sm-3">
                        <i style="float: left;font-size: 12px;color: red" class="col-sm-3"><?php echo get_phrase('file_berformat_gambar'); ?></i>
                      </div>

                      <div class="form-group row">
                        <label for="raporSemester" class="col-sm-3"> <?php echo get_phrase('rapor'); ?> <font color="red">*</font></label>
                        <input type="file" name="raporSemester" id="raporSemester" class="form-control col-sm-3">
                        <i style="float: left;font-size: 12px;color: red" class="col-sm-3"><?php echo get_phrase('file_berformat_gambar'); ?></i>
                      </div>

                      <div class="form-group row">
                        <label for="sertifikatLainnya" class="col-sm-3"><?php echo get_phrase('sertifikat'); ?></label>
                        <input type="file" name="sertifikatLainnya" id="sertifikatLainnya" class="form-control col-sm-3">
                        <i style="float: left;font-size: 12px;color: red" class="col-sm-3"><?php echo get_phrase('file_berformat_gambar'); ?></i>
                      </div>

                      <div class="form-group row">
                        <label for="dokumenLainnya" class="col-sm-3"><?php echo get_phrase('dokumen'); ?></label>
                        <input type="file" name="dokumenLainnya" id="dokumenLainnya" class="form-control col-sm-3">
                        <i style="float: left;font-size: 12px;color: red" class="col-sm-3"><?php echo get_phrase('file_berformat_gambar'); ?></i>
                      </div>

                      <br />

                      <div class="row">
                        <button type="button" onClick="prevPage(this)" class="btn btn-primary">Back</button>
                        <button type="submit" class="btn btn-primary ml-auto">Submit</button>
                      </div>

                    </div>
                  </form>
                  <?php /*echo form_close(); */ ?>
                  

                  <script>

                    function nextPage(id, idFull) {
                      // alert(e.parentNode.parentNode.id);                
                      var num = parseInt(id);
                      num++;
                      var currPage = document.getElementById(idFull);
                      var nextPage = document.getElementById('page' + "_" + num);

                      currPage.style.display = 'none';
                      nextPage.style.display = 'block';

                      window.scrollTo(0, 0);
                    };

                    function prevPage(e) {
                      // alert(e.parentNode.id);                      
                      var id = e.parentNode.parentNode.id.split("_")
                      var num = parseInt(id[1]);
                      num--;
                      var currPage = document.getElementById(e.parentNode.parentNode.id);
                      var prevPage = document.getElementById(id[0] + "_" + num);

                      currPage.style.display = 'none';
                      prevPage.style.display = 'block';

                      window.scrollTo(0, 0);
                    };
                  </script>
                </div>
            </div>
        </div>
    </section><!--main-banner end-->

</div><!--main-section end-->


</div>

<script src="<?php echo base_url();?>assets/frontend/alanwar/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/isotope.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/html5lightbox.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/slick.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/tweenMax.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    $('.nextTab').click(function(){
      var thisBtn = $(this);
      var id_tab = $(this).attr('data-id');
      // console.log($('#page_'+id_tab).find('input[required]'));
      var isNext = [];
      $('#page_'+id_tab).find('input[required]').each(function(row,el){
        $(el).parent().find("small").remove();
        // console.log(row);
        // console.log();
        if($(el).val() == ""){
          $(el).parent().append("<small class='text-danger'>"+ $(el).attr('name') +" Kosong </small>")
          isNext.push(false);
        }
      })

      if(isNext.length == 0){
        nextPage(id_tab, 'page_'+id_tab) 
      }
    })

      $('#tglLahir').datepicker({
        //merubah format tanggal datepicker ke dd-mm-yyyy
          format: "dd-mm-yyyy",
          //aktifkan kode dibawah untuk melihat perbedaanya, disable baris perintah diatasa
          //format: "dd-mm-yyyy",
          autoclose: true
      });
  });
  $(document).ready(function () {
      $('#tgl_lahir_orang_tua').datepicker({
        //merubah format tanggal datepicker ke dd-mm-yyyy
          format: "dd-mm-yyyy",
          //aktifkan kode dibawah untuk melihat perbedaanya, disable baris perintah diatasa
          //format: "dd-mm-yyyy",
          autoclose: true
      });
  });
  $(document).ready(function () {
      $('#tgl_lahir_wali').datepicker({
        //merubah format tanggal datepicker ke dd-mm-yyyy
          format: "dd-mm-yyyy",
          //aktifkan kode dibawah untuk melihat perbedaanya, disable baris perintah diatasa
          //format: "dd-mm-yyyy",
          autoclose: true
      });
  });
</script>
<script>
  $('.datepicker').datepicker();

  // isi tahun lahir ayah
  for(i = 1930; i <= 2000; i++) {
    $('#tahunLahirAyah').append("<option value='" + i +"'>" + i + "</option>");
  }

  // isi pendidikan ayah
  for(i = 1930; i <= 2000; i++) {
    $('#tahunLahirIbu').append("<option value='" + i +"'>" + i + "</option>");
  }

  <?php 
  
  
    if ($error) {
      $err_str = "";

      foreach ($error as $key => $item) {
        $err = "[" . str_replace("_", " ", $key) . "]: " . $item . "<br />" ;
        $err_str .= $err; 
      }

      echo '
        swal("Something Went Wrong", "'. $err_str .'", "error");
      ';
    } 
    
    if ($success) {
      
      echo '
        swal({
          title:  "Successful Registration",
          text: "Data Successfully Registered",
          type: "success"
        }, function() {
          window.location = "'. base_url() .'home/registration/success/'. $data['kode_registrasi'] .'";
        });
      ';
    }
  ?>

</script>