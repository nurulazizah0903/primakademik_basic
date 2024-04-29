
<div class="wrapper">

<div class="main-section" id="home">

    <header>
        <div class="container">
            <div class="header-content d-flex flex-wrap align-items-center">
                <div class="logo">
                    <a target="_blank" href="<?php echo base_url().'login' ?>">
                        <img src="<?php echo $this->settings_model->get_favicon(); ?>" alt="" width="50" length="50"> 
                    </a>
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
                        <li><a href="<?php echo base_url().'home/simple_registration'; ?>" title=""><i class="fas fa-arrow-left"></i></a></li>
                    </ul>
                </nav><!--nav end-->
            </div><!--navigation-bar end-->
        </div>
    </header><!--header end-->

    <div class="responsive-menu">
        <ul>
            <li><a href="<?php echo base_url().'home/simple_registration'; ?>" title=""><i class="fas fa-arrow-left"></i></a></li>
        </ul>
    </div><!--responsive-menu end-->

    <section style="margin-bottom: 6em;">
        <div class="container">
            <div class="col align-items-center">
                <div class="container-md shadow-sm bg-light rounded px-4 py-4" style="">
                  <h2 class="mb-3 text-center" style="font-size:28px; color: #2b2b2b;"><?php echo get_phrase('registrasi_berhasil'); ?></h2>
                  <h3 class="text-center">
                  <?php echo get_phrase('kode_registrasi_peserta'); ?> : <?php echo $data['kode_registrasi']; ?>
                  </h3>
                </div>
            </div>
        </div>
    </section><!--main-banner end-->

    <section class="mb-4">
      <div class="container">
        <div class="col algin-items-center">
          <div class="container-md shadow-sm bg-light rounded px-4 py-4" style="">
            <div class="card-body row">
              <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
                <thead>
                  <tr style="background-color: #313a46; color: #ababab;">
                    <th><?php echo get_phrase('kode_registrasi'); ?></th>
                    <th><?php echo get_phrase('nama_siswa'); ?></th>
                    <th><?php echo get_phrase('nama_orang_tua'); ?></th>
                    <th><?php echo get_phrase('nik'); ?></th>
                    <th><?php echo get_phrase('status'); ?></th>
                    <th><?php echo get_phrase('cetak'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <?php echo $data['kode_registrasi']; ?>
                    </td>
                    <td>
                      <?php echo $data['nama_lengkap']; ?>
                    </td>
                    <td>
                      <?php echo $data['nama_orang_tua']; ?>
                    </td>
                    <td>
                      <?php echo $data['nik']; ?>
                    </td>
                    <td>
                      <?php 
                      if ($data['status'] == 'Not Yet Paid') {
                        echo get_phrase('belum_bayar');
                      } elseif ($data['status'] == 'Not Selection') {
                        echo get_phrase('belum_lulus_seleksi');
                      } elseif ($data['status'] == 'Processed') {
                        echo get_phrase('diproses');
                      }elseif ($data['status'] == 'Accepted') {
                        echo get_phrase('diterima');
                      }elseif ($data['status'] == 'Not Accepted') {
                        echo get_phrase('tidak_diterima');
                      }elseif ($data['status'] == 'Removed') {
                        echo get_phrase('dicabut');
                      }
                      ?>
                    </td>
                    <td>
                      <a target="_blank" class="btn btn-info" href="<?php echo base_url().'home/print_ppdb/'.$data['id']; ?>"><?php echo get_phrase('print'); ?></a> 
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php /*
      $payment_details = array(
        "nama_bank" => get_frontend_settings('bank_name'),
        "no_rekening" => get_frontend_settings('account_number'),
        "atas_nama" => get_frontend_settings('account_name'),
        "total" => get_frontend_settings('total')
      )
    ?>
    <section id='pembayaran' class="mb-4">
      <div class="container">
        <div class="col algin-items-center">
          <div class="container-md shadow-sm bg-light rounded px-4 py-4" style="">
            <h2 class="text-center mb-4"><?php echo get_phrase('pembayaran'); ?></h2>
            <p class="text-center mb-4"><?php echo get_phrase('silahkan_upload'); ?></p>
            <?php echo form_open_multipart('home/registration_pay') ?>
            <input hidden value=<?php echo $data['kode_registrasi'] ?> type="text" name="kodeRegistrasi">
            <div class="form-group row">
              <label for="namaBank" class="col-sm-3"><?php echo get_phrase('nama_bank'); ?></label>
              <input value="<?php echo $payment_details['nama_bank'] ?>" type="text" class="form-control col-sm-8" name="namaBank" id='namaBank' readonly>
            </div>
            <div class="form-group row">
              <label for="noRek" class="col-sm-3"><?php echo get_phrase('nomor_rekening'); ?></label>
              <input value="<?php echo $payment_details['no_rekening'] ?>" type="text" class="form-control col-sm-8" name="noRek" id='noRek' readonly>
            </div>
            <div class="form-group row">
              <label for="atasNama" class="col-sm-3"><?php echo get_phrase('atas_nama'); ?></label>
              <input value="<?php echo $payment_details['atas_nama'] ?>" type="text" class="form-control col-sm-8" name="atasNama" id='atasNama' readonly>
            </div>
            <div class="form-group row">
              <label for="total" class="col-sm-3"><?php echo get_phrase('total'); ?></label>
              <input value="<?php echo $payment_details['total'] ?>" type="text" class="form-control col-sm-8" name="total" id='total' readonly>
            </div>
            <div class="form-group row">
              <label for="buktiBayar" class="col-sm-3"><?php echo get_phrase('bukti_bayar'); ?></label>
              <input type="file" name="buktiBayar" id="buktiBayar" class="form-control col-sm-3">
            </div>
            <button class="btn btn-primary w-100 mt-4"><?php echo get_phrase('bayar'); ?></button>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
    </section>
    <?php */ ?>
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

