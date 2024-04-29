<?php
  $invoice_details = $this->crud_model->get_invoice_by_id($invoice_id);
  $student_details = $this->user_model->get_student_details_by_id('student', $invoice_details['student_id']);
 ?>

<!--title-->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
            	<i class="mdi mdi-grease-pencil title_icon"></i> <?php echo get_phrase('invoice'); ?>
        	</h4>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">

        <!-- Invoice Logo-->
        <div class="clearfix">
          <div class="float-left">
            <img src="<?php echo $this->settings_model->get_logo_dark(); ?>" alt="" height="50">
          </div>
        </div>
        <!-- Name School -->
        <div class="clearfix">
          <div class="float-left">
            <h4>SD Multi Internacionality</h4> 
            <address>
              Jl. Raya Wiguna Selatan No 36 Gununganyar, KOTA SURABAYA 60294<br> 
              <abbr title="Phone">Tlpn. : +62 812 3456 7890</abbr><br>
              Web : www.alinayahjambi.com<br>
            </address>
          </div>
        </div>
        
        <hr></hr>

        <!-- Invoice Detail-->
        <div class="row">
          <div class="col-sm-6">
            <div class="float-left mt-1">
              <h3>Invoice INV/2021/0000120/0005</h3>
              
              <address>
                <p class="font-13"><strong>Tgl Invoice     : </strong> &nbsp;&nbsp;&nbsp; <?php echo date('D, d-M-Y'); ?></p>
                <p class="font-13"><strong>Tgl jatuh Tempo : </strong> &nbsp;&nbsp;&nbsp; <?php echo date('D, d-M-Y'); ?></p>
                <p class="font-13"><strong><?php echo get_phrase('status'); ?> : </strong>
                <?php if (strtolower($invoice_details['status']) == 'paid'): ?>
                  <span class="badge badge-success"><?php echo get_phrase('paid'); ?></span></p>
                <?php else: ?>
                  <span class="badge badge-danger"><?php echo get_phrase('unpaid'); ?></span></p>
                <?php endif; ?>
              </address>
            </div>
          </div><!-- end col -->
          <div class="col-sm-4 offset-sm-2">
            <div class="mt-3 float-sm-right">
              <p class="font-13"><strong>Tahun Ajaran</strong> : &nbsp;&nbsp;&nbsp; 2021-2022</p>
              <p class="font-13"><strong>Nama</strong> : &nbsp;&nbsp;&nbsp; 2021-1843-9765</p>
              <p class="font-13"><strong>NIP </strong> : &nbsp;&nbsp;&nbsp; IMAM MALIK FAJAR</p>
              <p class="font-13"><strong>Kelas </strong> : &nbsp;&nbsp;&nbsp; XI - Otomotif</p>
               
            </div>
          </div><!-- end col -->
        </div>
        <!-- end row -->
        
        <!--div class="row mt-4">
          <div class="col-sm-4">
            <h6><?php echo get_phrase('billing_details'); ?></h6>
            <address>
              <?php echo $student_details['name']; ?><br>
              <?php echo $student_details['address'] == "" ? '('.get_phrase('address_not_found').')' : $student_details['address']; ?><br>
              <abbr title="Phone">P:</abbr> <?php echo $student_details['phone'] == "" ? '('.get_phrase('phone_number_not_found').')' : $student_details['phone']; ?><br>
            </address>
          </div>  
        </div-->
        <!-- end row -->

        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <table class="table mt-4">
                <thead>
                  <tr><th>#</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Satuan Harga</th>
                    <th class="text-right">Jumlah</th>
                  </tr></thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>
                        <b>pembayaran spp</b> <br/>
                        Bulan Oktober 2021
                      </td>
                      <td>1,000</td>
                      <td>500.000,00</td>
                      <td class="text-right">Rp 500.000</td>
                    </tr>
                  </tbody>
                </table>
              </div> <!-- end table-responsive-->
            </div> <!-- end col -->
          </div>
          <!-- end row -->

          <div class="row">
            <div class="col-sm-6"> 
            </div> <!-- end col -->
            <div class="col-sm-6">
              <div class="float-right mt-3 mt-sm-0">
                <hr></hr>
                <p><b>Total &nbsp;</b> <span class="float-right">Rp 500.000</span></p>
                <p><b>Dibayar pada 13/10/2021 &nbsp;</b> <span class="float-right">Rp 500.000</span></p>
                <hr></hr>
                <p><b>Belum Dibayar &nbsp;</b> <span class="float-right">Rp 0</span></p>
              </div>
              <div class="clearfix"></div>
            </div> <!-- end col -->
          </div>
          <!-- end row-->

          <div class="d-print-none mt-4">
            <div class="text-right">
              <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> <?php echo get_phrase('print'); ?></a>
            </div>
          </div>
          <!-- end buttons -->

        </div> <!-- end card-body-->
      </div> <!-- end card -->
    </div> <!-- end col-->
  </div>
