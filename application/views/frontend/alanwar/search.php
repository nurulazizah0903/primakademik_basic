<div class="wrapper">

<div class="main-section" id="home">

    <header>
        <div class="container">
            <div class="header-content d-flex flex-wrap align-items-center">
                <div class="logo">
                    <a href="<?= base_url() ?>" title="">
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
                        <li><a href="<?php echo base_url(); ?>" title=""><i class="fas fa-arrow-left"></i></a></li>
                    </ul>
                </nav><!--nav end-->
            </div><!--navigation-bar end-->
        </div>
    </header><!--header end-->

    <div class="responsive-menu">
        <ul>
            <li><a href="<?php echo base_url(); ?>" title=""><i class="fas fa-arrow-left"></i></a></li>
        </ul>
    </div><!--responsive-menu end-->

    <section style="margin-bottom: 2em;">
        <div class="container">
            <div class="col align-items-center">
                <div class="container-md shadow-sm bg-light rounded px-4 py-4">
                  <h2 class="mb-3 text-center" style="font-size:28px; color: #2b2b2b;"><?php echo get_phrase('cari_hasil_registrasi') ?></h2>
                  <?php echo form_open('home/search_post_form'); ?>
                    <div class="form-group row">
                      <label for="kodeRegistrasi" class="col-sm-3"><?php echo get_phrase('kode_registrasi') ?></label>
                      <input 
                        type="text" 
                        class="form-control col-sm-8" 
                        name="kodeRegistrasi" 
                        id="kodeRegistrasi" 
                        placeholder=""
                        value="<?php echo trim($data['kode_registrasi']);?>"
                      >
                      <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Cari
                      </button>
                    </div>
                  <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </section><!--main-banner end-->
    <?php if($data) : ?>
    <section class="mb-4">
      <div class="container">
        <div class="col algin-items-center">
          <div class="container-md shadow-sm bg-light rounded px-4 py-4">
            <div class="card-body row">
              <table class="table table-striped dt-responsive nowrap" width="100%">
                <thead>
                  <tr style="background-color: #313a46; color: #ababab;">
                    <th><?php echo get_phrase('kode_registrasi'); ?></th>
                    <th><?php echo get_phrase('nama_siswa'); ?></th>
                    <th><?php echo get_phrase('nama_orang_tua'); ?></th>
                    <th><?php echo get_phrase('nisn'); ?></th>
                    <th><?php echo get_phrase('status'); ?></th>
                    <th><?php echo get_phrase('keterangan'); ?></th>
                    <th><?php echo get_phrase('cetak_data'); ?></th>
                    <th></th>
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
                      <?php echo $data['nisn']; ?>
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
                      }elseif ($data['status'] == 'Installment') {
                        echo get_phrase('installment');
                      }
                      ?>
                    </td>
                    <td>
                      <?php echo $data['ket']; ?>
                    </td>
                    <td>
                      <a target="_blank" class="btn btn-info" href="<?php echo base_url().'home/print_ppdb/'.$data['id']; ?>"><?php echo get_phrase('print'); ?></a></td>
                    <td>
                      <?php if ($data['status'] == 'Not Yet Paid') : ?>
                      <button class="btn btn-danger w-100" data-toggle="modal" data-target="#exampleModal">
                        <i class="fas fa-times-circle"></i>
                        <?php echo get_phrase('cancel'); ?>
                      </button>
                      <?php endif; ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    <?php endif; ?>

    <?php /* if($data['status'] == 'Not Yet Paid') : ?>
    <?php
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
          <div class="container-md shadow-sm bg-light rounded px-4 py-4">
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
    <?php endif; ?>

    <div class="container">
    <?php
    $this->db->or_where_in('status', 'Not Selection');
    $this->db->or_where_in('status', 'Processed');
    $this->db->or_where_in('status', 'Not Yet Paid');
    $registrations = $this->db->get('registrations')->result_array();
    if (count($registrations) > 0): ?>
    <table id="datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead>
            <tr style="background-color: #313a46; color: #ababab;">
                <th><?php echo get_phrase('kode_registrasi'); ?></th>
                <th><?php echo get_phrase('name'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
                <th><?php echo get_phrase('keterangan'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($registrations as $item){
                ?>
                <tr>
                    <td>
                        <?php echo $item['kode_registrasi']; ?>
                    </td>
                    <td>
                        <?php echo $item['nama_lengkap']; ?>
                    </td>
                    <td>
                    <?php 
                      if ($item['status'] == 'Not Yet Paid') {
                        echo get_phrase('belum_bayar');
                      } elseif ($item['status'] == 'Not Selection') {
                        echo get_phrase('belum_lulus_seleksi');
                      } elseif ($item['status'] == 'Processed') {
                        echo get_phrase('diproses');
                      }elseif ($item['status'] == 'Accepted') {
                        echo get_phrase('diterima');
                      }elseif ($item['status'] == 'Not Accepted') {
                        echo get_phrase('tidak_diterima');
                      }elseif ($item['status'] == 'Removed') {
                        echo get_phrase('dicabut');
                      }
                    ?>
                    </td>
                    <td>
                      <?php echo $item['ket']; ?>
                    </td>
                </tr>
              <?php } ?>
        </tbody>
    </table>
    <?php else: ?>
      <center>
      <?php include APPPATH.'views/backend/empty.php'; ?>
      </center>
    <?php endif; */?>
	</div>

</div><!--main-section end-->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo get_phrase('verifikasi_nama_orang_tua') ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <input type="text" name="namaOrangTua" id="namaOrangTua" class="form-control" placeholder="">
          <small>Contoh: JOHN DOE</small>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="cancelRegistration()"><?php echo get_phrase('verifikasi') ?></button>
      </div>
    </div>
  </div>
</div>


</div>

<script type="text/javascript">
initDataTable('datatable');

</script>

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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>

  function cancelRegistration() {

    // check nama orang tua
    // e.preventDefault();  // stops the jump when an anchor clicked.
    var namaOrangTua = $('#namaOrangTua').val();
    var kodeRegistrasi = $('#kodeRegistrasi').val(); // anchors do have text not values.
    console.log(namaOrangTua);
    console.log(kodeRegistrasi);
    $.ajax({
      url: `<?php echo base_url(); ?>home/registration_cancel/check/${namaOrangTua}/${kodeRegistrasi}` ,
      data: {
        'nama_orang_tua': namaOrangTua,
        'kode_registrasi': kodeRegistrasi,
      }, // change this to send js object
      type: "post",
      success: function(data){
        console.log(data);
        if (data.length > 0) {
          swal({
          icon: 'warning',
          title: 'Warning',
          text: 'Batalkan Registrasi?',
          dangerMode: true,
            buttons: true,
            buttons: {
              cancel: {
                text: "Cancel",
                value: 0,
                visible: true,
                className: "",
                closeModal: true,
              },
              confirm: {
                text: "OK",
                value: 1,
                visible: true,
                className: "",
                closeModal: true
              }
            },
          })
            .then((value) => {
              if (value == 1) {
                <?php 
                  echo '
                    window.location = "'. base_url() .'home/registration_cancel/'. $data['kode_registrasi'] .'";
                  ';  
                ?>
              }
            })
        } else {
          swal("Verifikasi Gagal", "Nama Orang Tua salah", "error");
        }
        
      }
    });

   
  }

  <?php 
    if ($payment_success) {
      echo '
        swal("'.get_phrase('payment_success').'", "Registrasi anda sedang di proses", "success");
      ';
    }

    if ($registration_cancel) {
      echo '
        swal("'.get_phrase('registration_cancel').'", "Registrasi anda telah berhasil di cabut", "success");
      ';
    }
  ?>

</script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.datatable-init.js"></script>