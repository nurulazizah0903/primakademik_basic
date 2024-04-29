  
<?php
if(isset($student_id)):
    $student_data = $this->user_model->get_student_details_by_id('student', $student_id);
    // var_dump($student_data); 
    // if (isset($class_id) && isset($section_id)):
    // $invoices  = $this->db->get_where('invoices', array('student_id' => $student_data['student_id'], 'session' => active_session()))->result_array();
    $invoices = $this->crud_model->get_invoice_by_student_id($date_from, $date_to, $student_data['student_id'])->result_array();
    // var_dump($invoices); die;
    // die;
    if(count($invoices) > 0):?>
<?php if (!empty($student_data['va'])) { ?>
<div class="alert alert-warning mt-3" role="alert">  
    No. Virtual Account 
    <strong><?php echo $student_data['name']; ?> : <?php echo $student_data['va']; ?></strong>
</div>
<?php } ?>
<div class="row">
	<div class="col-xl-12">
		<div class="card">
			<div class="card-body">
            <div class="table-responsive">   
                <!-- <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%"> -->
                <!-- <table border="1" class="table table-bordered table-centered mb-0" width="100%">   -->
                <table id="example" class="table table-striped dt-responsive" width="100%">  
                    <thead>
                        <tr style="background-color: #313a46; color: #ababab;">
                        <th><?php echo get_phrase('student'); ?></th>
                        <th><?php echo get_phrase('invoice_types'); ?></th>
                        <th><?php echo get_phrase('invoice_no'); ?></th>
                        <th><?php echo get_phrase('total_amount'); ?></th>			
                        <th><?php echo get_phrase('status'); ?></th>			
                        <th><?php echo get_phrase('option'); ?></th>	
                        <th><?php echo get_phrase('Rincian Pembayaran'); ?></th>
                        <th><?php echo get_phrase('note'); ?></th>
                        </tr>
                    </thead>
                    <tbody class="row_position">
                        <?php
                        $invoices = $this->crud_model->get_invoice_by_student_id($date_from, $date_to, $student_data['student_id'])->result_array();
                        foreach ($invoices as $invoice):
                            $student_details = $this->user_model->get_student_details_by_id('student', $invoice['student_id']);
                            $class_details = $this->crud_model->get_class2_details_by_id($invoice['student_id'])->row_array();   
                            $payment_type = $this->crud_model->get_payment_type_id_details_by_id($invoice['payment_type_id'])->row_array();  
                            $finances = $this->db->get_where('finances', array('invoices_id' => $invoice['id']))->result_array(); 
                            $savings = $this->db->get_where('savings', array('invoices_id' => $invoice['id']))->row_array();
                        ?> 
                        <tr>
                            <td>
                                <?php echo $student_details['name']; ?> <br>
                                <small> <strong><?php echo get_phrase('class'); ?> :</strong> <?php echo $class_details['sectionname'].' - '.$class_details['classname']; ?></small>
                            </td>
                            <td> 
                                <?php echo $payment_type['name']; ?> </br>
                                <small> <strong> <?php echo $invoice['label']; ?> </strong>   </small>
                            </td>
                            <td> 
                                <?php echo $invoice['title']; ?> </br>
                                <small> <strong> <?php echo get_phrase('created_at'); ?> : </strong> <?php echo date('M/d/Y', $invoice['created_at']); ?> </small>
                            </td>
                            <td> <?php echo currency( number_format($invoice['total_amount'],0,",",".")); ?>  </td>
                            
                            <td>
                                <?php if (strtolower($invoice['status']) == 'unpaid'): ?>
                                    <span class="badge badge-danger"><?php echo get_phrase('unpaid'); ?></span>
                                <?php elseif (strtolower($invoice['status']) == 'not_yet_paid_off'): ?>
                                    <span class="badge badge-primary"><?php echo get_phrase('not_yet_paid_off'); ?></span>
                                <?php else: ?>
                                    <span class="badge badge-success"><?php echo get_phrase('paid'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                              &nbsp;
                              <?PHP if(strtolower($invoice['status']) != 'paid'){?>
                                <button  type="button" class="btn btn-primary btn-sm" onclick="largeModal('<?php echo site_url('modal/popup/invoice/create_payment/'.$invoice['id']); ?>', '<?php echo get_phrase('add_finance'); ?>');"><?php echo get_phrase('payment'); ?></button>                                
                              <?PHP }  ?>
                              <?PHP /* } else{ ?>
                                <button  type="button" class="btn btn-primary btn-sm" onclick="javascript:window.open('<?php echo route('invoice/invoice/'.$invoice['id']); ?>', '_blank');"><i class="mdi mdi-printer-settings"></i></button> 
                                <?php } */ ?>
                              &nbsp;    
                                <?php /*                               
                                <div class="dropdown text-center">
                                <?PHP if(strtolower($invoice['status']) != 'paid'){?>
                                    <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true"><i class="mdi mdi-dots-vertical"></i></button> 
                                    <div class="dropdown-menu dropdown-menu-animated "> 
                                        <a href="<?php echo route('invoice/invoice/'.$invoice['id']); ?>" class="dropdown-item" target="_blank"><?php echo get_phrase('print_invoice'); ?></a>                         
                                            
                                        <div class="dropdown-divider"></div>
                                        <!-- item-->	
                                        <a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/invoice/create_payment/'.$invoice['id']); ?>', '<?php echo get_phrase('add_finance'); ?>');"><?php echo get_phrase('payment'); ?></a>
                                    </div>
                                <?PHP }  ?>    
                                </div>
                                
                                <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#full-width-modal">Full width Modal</button>
                                <button  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#full-width-modal"><?php echo get_phrase('payment'); ?></button>
                                 */ ?>
                            </td>                             
                            <td>
                                <?php if( isset($invoice['paid_amount']) ){ ?>  
                                    <strong> <?php echo get_phrase('date'); ?> : </strong> <br>
                                    <?PHP $no = 1; foreach ($finances as $finance): ?>
                                        <?php
                                            echo $no.". ".date('M/d/Y', $finance['created_at']).", Sejumlah : ". currency( number_format($finance['total'],0,",",".")); 
                                        ?>  
                                        <br> 
                                    <?php $no++; endforeach; ?>
                                    <?php if(isset($savings)){ ?>
                                    <strong> <?php echo get_phrase('Uang Titipan'); ?> : </strong> <br> 
                                    <?PHP  echo "Uang Titipan sejumlah : ". currency( number_format($savings['total'],0,",",".")); ?>                                
                                    <?PHP  }/*  
                                    <?php if ($invoice['updated_at'] > 0): ?>
                                        <?php echo date('M/d/Y', $invoice['updated_at']); ?>
                                    <?php else: ?>
                                        <?php echo get_phrase('not_found'); ?>
                                    <?php endif; ?>
                                    */ ?> 
                                <?php } ?>
                            </td>
                            <td> <?php echo $invoice['note']; ?> </td>
                            
                        </tr>
                        <?php endforeach; ?> 
                    </tbody>
                </table>  
			</div>
			</div>
		</div>
	</div>
</div>
<!-- <script type="text/javascript">
    initDataTable('basic-datatable');
</script> -->
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            "paging":   false,
            "info":     false
        } );
    } );

    $(".row_position").sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $(".row_position>tr").each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    }); 
</script>