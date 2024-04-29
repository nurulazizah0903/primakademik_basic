<?php  
  $jalur_pendaftaran = [
    get_phrase('umum'),
    get_phrase('alumni_siswa_wh'),
    get_phrase('aws'),
    get_phrase('skm_kaka_adik'),
    get_phrase('orang_tua_alumni'),
    get_phrase('alumni_paud_rw_06')
  ];

  $info_sekolah = [
    get_phrase('teman'),
    get_phrase('guru'),
    get_phrase('internet'),
    get_phrase('brosur'),
    get_phrase('presentasi'),
    get_phrase('lainnya')
  ];

?>

<div class="wrapper">

<div class="main-section" id="home">

    <header>
        <div class="container">
            <div class="header-content d-flex flex-wrap align-items-center">
                <div class="logo">
                    <a target="_blank" href="<?php echo base_url().'login' ?>">
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
                        <li><a target="_blank" href="<?php echo base_url().'login' ?>" title=""><i class="fas fa-arrow-left"></i></a></li>
                    </ul>
                </nav><!--nav end-->
            </div><!--navigation-bar end-->
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
                <h2 class="mb-3 text-center" style="font-size:28px; color: #2b2b2b;"><?= get_frontend_settings('website_title') ?></h2>
                <font color="black"><?php echo get_phrase('yang_bertanda'); ?> <font color="red">*</font> <?php echo get_phrase('wajib_diisi'); ?></font>
                <div class="container-md shadow-sm bg-light rounded px-4 py-4" style="">
                  <?php /* echo form_open_multipart('home/registration'); */?>
                  <form method="POST" name="myForm" class="col-12 d-block ajaxForm" action="<?php echo site_url('home/simple_registration'); ?>" onsubmit="return validateForm()" enctype="multipart/form-data" novalidate>
                    <!-- page 1 -->
                    <div id="page_1">
                      <h2 class="text-center mb-3"><?php echo get_phrase('identitas_calon'); ?></h2>
                      <div class="form-group row">
                        <label for="nik" class="col-sm-3"><?php echo get_phrase('nik'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['nik'] ?>" type="number" class="form-control col-sm-8" name="nik" id="nik">
                      </div>

                      <div class="form-group row">
                        <label for="namaLengkap" class="col-sm-3"><?php echo get_phrase('nama_lengkap_anak'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['nama_lengkap'] ?>" type="text" class="form-control col-sm-8" name="namaLengkap" id="namaLengkap" aria-describedby="" placeholder="">
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
                        <label for="tempatLahir" class="col-sm-3"><?php echo get_phrase('tempat_lahir'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['tempat_lahir'] ?>" type="text" class="form-control col-sm-8" name="tempatLahir" id="tempatLahir" placeholder="">
                      </div>
                      <div class="form-group row">
                        <label for="tglLahir" class="col-sm-3"><?php echo get_phrase('tgl_lahir'); ?> <font color="red">*</font></label>
                            <input value="<?= $data['tgl_lahir'] ?>" type="text" id="tglLahir" placeholder="dd/mm/yyyy" class="form-control col-sm-8" name="tglLahir">
                      </div>

                      <div class="form-group row">
                        <label for="nisn" class="col-sm-3"><?php echo get_phrase('nisn'); ?> <font color="red">*</font></label>
                        <input value="<?= $data['nisn'] ?>" type="number" class="form-control col-sm-8" name="nisn" id="nisn">
                      </div>

                      <div class="form-group row">
                        <label for="sekolahAsal" class="col-sm-3"><?php echo get_phrase('sekolah_asal'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['sekolah_asal'] ?>" name="sekolahAsal" id="sekolahAsal" class="form-control col-sm-8">
                      </div>

                      <div class="form-group row">
                        <label for="jurusan" class="col-sm-3"><?php echo get_phrase('jurusan'); ?> <font color="red">*</font></label>
                        <select name="jurusan" id="jurusan" class="form-control col-sm-8">
                            <option value="Tidak Memilih Jurusan"><?php echo get_phrase('select_a_class'); ?></option>
                            <option value="Multimedia">Multimedia</option>
                            <option value="Akuntansi">Akuntansi</option>
                            <option value="Administrasi Perkantoran">Administrasi Perkantoran</option>
                        </select>
                      </div>

                      <div class="form-group row">
                        <label for="namaOrangTua" class="col-sm-3"><?php echo get_phrase('nama_orang_tua/wali'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['nama_orang_tua'] ?>" type="text" class="form-control col-sm-8" name="namaOrangTua" id='namaOrangTua'>
                      </div>

                      <div class="form-group row">
                        <label for="pekerjaanOrangTua" class="col-sm-3"><?php echo get_phrase('pekerjaan_orang_tua/wali'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['pekerjaan_orang_tua'] ?>" type="text" class="form-control col-sm-8" name="pekerjaanOrangTua" id='pekerjaanOrangTua'>
                      </div>

                      <div class="form-group row">
                        <label for="alamat" class="col-sm-3"> <?php echo get_phrase('alamat'); ?> <font color="red">*</font></label>
                        <input required value="<?= $data['alamat'] ?>" type="text" class="form-control col-sm-8" name="alamat" id='alamat'>
                      </div>

                      <div class="form-group row">
                        <label for="telephone" class="col-sm-3"><?php echo get_phrase('telephone'); ?> <font color="red">*</font> </label>
                        <input required value="<?= $data['telephone'] ?>"type="text" class="form-control col-sm-8" name="telephone" id='telephone'>
                        <i style="float: left;font-size: 12px;color: red" class="col-sm-3"><?php echo get_phrase('yang_dapat_dihubungi'); ?></i>
                      </div>

                      <!-- FIELD Info Sekolah -->
                      <?php 
                        $field_name = "infoSekolah";
                        $field_label = get_phrase('info_sekolah'); 

                        $items = $info_sekolah;

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

                      <?php 
                        $field_name = "jalurPendaftaran";
                        $field_label = get_phrase('jalur_pendaftaran'); 
                        $registration_paths = $this->db->get_where('registration_path')->result_array(); 
                        $items = $registration_paths;

                        $field_form_check = "";

                        $checked = "checked";

                        foreach ($registration_paths as $item) {
                          $html_item = '
                            <div class="form-check">
                              <input '.$checked.' class="form-check-input" type="radio" name="'. $field_name .'" id="'. $field_name . $item .'" value="'. $item['id'] .'">
                              <label class="form-check-label" for="'. $field_name . $item ['name'].'">
                                '. $item['name'] .'
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
                      <br />
                      <font color="red">Pastikan data terisi semua dan benar, sebelum submit</font>
                      <div class="row">
                      <a href="#" data-toggle="modal" class="btn btn-primary ml-auto " data-target="#terms-txt">Daftar</a>
                      </div>
                      <div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="termsLabel">KENTENTUAN – KETENTUAN PPDB</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body" style="color: #2b2b2b;">
                              <p>1.  Calon peserta didik bisa mengambil perlengkapan jika telah lunas.</p>
                              <p>2.  Perlengkapan yang sudah diterima tidak dapat dikembalikan.</p>
                              <p>3.  Siswa yang mengundurkan diri :</p>
                                <p style="display: inline-block; margin-left: 40px;">a.  Sampai dengan 10 Juli <?php echo date('Y')+1; ?>, mendapatkan pengembalian uang pendaftaran sebesar 50%.</p>
                                <p style="display: inline-block; margin-left: 40px;">b.  11 – 31 Juli <?php echo date('Y')+1; ?>, mendapatkan pengembalian uang pendaftaran sebsar 25%.</p>
                                <p style="display: inline-block; margin-left: 40px;">c.  Setelah tanggal 31 Juli <?php echo date('Y')+1; ?>, tidak ada pengembalian uang pendaftaran.</p>
                              <p>4.  Pengunduran diri atau mutasi pada tengah tahun pelajaran, wajib melunasi uang infak bulanan terhitung hingga saat yang bersangkutan mengajukan pengunduran diri atau mutasi.</p>
                              <p>5.  Pengembalian uang pendaftaran bagi siswa yang mengundurkan diri sebagaimana poin 3a dan 3b, dihitung setelah dikurangi biaya perlengkapan sebesar Rp 1.150.000,-.</p>
                              <p>6.  Pengunduran diri khusus pendaftar inden angsur yang belum lunas dihitung sebagaimana poin 3 tanpa dikurangi biaya perlengkapan.</p>
                            </div>
                            <div class="modal-footer">
                            <div class="text-left">
                            <a href="<?php echo site_url('home/simple_registration/error'); ?>" class="btn btn-danger">Tidak Setuju</a>
                            </div>
                              <button type="submit" data-id="1" class="btn btn-primary ml-auto nextTab">Setuju</button>
                            </div>
                          </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                    </div>
                  </form>

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
          // $(el).parent().append("<small class='text-danger'>"+ $(el).attr('name') +" Kosong </small>")
          $(el).parent().append("<small class='text-danger'> Data Belum Diisi </small>")
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
        
        $err = "[" . str_replace("_", " ", $key) . "]: " . $item ;
        // $err_str .= $err; 
      }

      echo '
        swal("Ada Kesalahan", "'. $err_str . $key .'", "error");
      ';
    } 
    
    if ($success) {
      
      echo '
        swal({
          title:  "Successful Registration",
          text: "Data Successfully Registered",
          type: "success"
        }, function() {
          window.location = "'. base_url() .'home/simple_registration/success/'. $data['kode_registrasi'] .'";
        });
      ';
    }
  ?>

</script>
