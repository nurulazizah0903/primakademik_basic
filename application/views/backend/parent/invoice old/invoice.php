<?php
  $invoice_details = $this->crud_model->get_invoice_by_id($invoice_id);
  $student_details = $this->user_model->get_student_details_by_id('student', $invoice_details['student_id']);
  $session_id = $this->db->get_where('sessions', array('id' => $invoice_details['session']))->row_array();
  $payment_type = $this->crud_model->get_payment_type_id_details_by_id($invoice_details['payment_type_id'])->row_array();  
  $savings = $this->db->get_where('savings', array('student_id' => $invoice_details['student_id']))->row_array();
?>

<!--title-->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">
            	<i class="mdi mdi-grease-pencil title_icon"></i> <?php echo get_phrase('Cetak Faktur'); ?>
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
            <h4><?php echo $school['name']; ?></h4> 
            <address>
              <?php echo $school['address']; ?><br> 
              <abbr title="Phone">Tlpn. : <?php echo $school['phone']; ?></abbr><br> 
            </address>
          </div>
        </div>
        
        <hr></hr>

        <!-- Invoice Detail-->
        <div class="row">
          <div class="col-sm-6">
            <div class="float-left mt-1">
              <h3><?php echo $invoice_details['title']; ?></h3>
              
              <address>
                <p class="font-13"><strong>Tgl faktur     : </strong> &nbsp;&nbsp;&nbsp; <?php echo date('M/d/Y', $invoice_details['created_at']); ?></p>
                <p></p>
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
              <p class="font-13"><strong>Tahun Ajaran</strong> : &nbsp;&nbsp;&nbsp; <?php echo $session_id['name']; ?></p>
              <p class="font-13"><strong>Nama</strong> : &nbsp;&nbsp;&nbsp; <?php echo $student_details['name']; ?> </p>
              <p class="font-13"><strong>NISN </strong> : &nbsp;&nbsp;&nbsp; <?php echo $student_details['nisn']; ?> </p>
              <p class="font-13"><strong>Kelas </strong> : &nbsp;&nbsp;&nbsp; <?php echo $student_details['class_name']." - ".$student_details['section_name']; ?> </p>
               
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
                  <tr>
                    <th>#</th>
                    <th>Deskripsi</th> 
                    <th class="text-right">Jumlah</th>
                  </tr></thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>
                        <b><?php echo $payment_type['name']." - ". date('M/Y', $invoice_details['created_at']); ?></b> <br/> 
                      </td> 
                      <td class="text-right"><?php echo currency( number_format($invoice_details['total_amount'])); ?></td>
                    </tr>
                    <?PHP if(isset($savings)) {?>                     
                    <tr>
                      <td>2</td>
                      <td>
                        <b><?php echo get_phrase('Uang Titipan'); ?></b> <br/> 
                      </td> 
                      <td class="text-right"><?php echo currency( number_format($savings['total'])); ?></td>
                    </tr>
                      <?PHP } ?>
                    
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
                <?PHP 
                if($invoice_details['total_amount'] > $savings['total'])
                {
                  $a = $invoice_details['total_amount'] - $savings['total']; 
                ?>
                <p><b>Total &nbsp;</b> <span class="float-right"><?php echo currency( number_format($a)); ?></span></p> 
                <?PHP } else {?>
                  <p><b>Total &nbsp;</b> <span class="float-right">0</span></p> 
                  <?PHP } ?>
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
