 
<?php $student_data = $this->user_model->get_logged_in_student_details(); //var_dump( $student_data);?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead class="thead-dark">
        <tr>              
            <th><?php echo get_phrase('student'); ?></th>
            <th><?php echo get_phrase('invoice_types'); ?></th>
            <th><?php echo get_phrase('total_amount'); ?></th>			
            <th><?php echo get_phrase('status'); ?></th>			
            <th><?php echo get_phrase('option'); ?></th>
            <th><?php echo get_phrase('invoice_no'); ?></th>	
            <th><?php echo get_phrase('Total Pembayaran'); ?></th>
            <th><?php echo get_phrase('note'); ?></th>
        </tr>
    </thead>
    <tbody>
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
                
                <td> <?php echo currency( number_format($invoice['total_amount'],0,",",".")); ?>  </td>
                
                <td>
                    <?php if (strtolower($invoice['status']) == 'unpaid'): ?>
                        <span class="badge badge-danger-lighten"><?php echo get_phrase('unpaid'); ?></span>
                    <?php elseif (strtolower($invoice['status']) == 'not_yet_paid_off'): ?>
                        <span class="badge badge-primary-lighten"><?php echo get_phrase('not_yet_paid_off'); ?></span>
                    <?php else: ?>
                        <span class="badge badge-success-lighten"><?php echo get_phrase('paid'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
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
                </td>
                <td> 
                    <?php echo $invoice['title']; ?> </br>
                    <small> <strong> <?php echo get_phrase('created_at'); ?> : </strong> <?php echo date('M/d/Y', $invoice['created_at']); ?> </small>
                </td> 
                <td>
                    <?php echo currency( number_format($invoice['paid_amount'],0,",",".")); ?> <br>
                    <small> 
                        <strong> <?php echo get_phrase('payment_date'); ?> : </strong> <br>
                        <?PHP $no = 1; foreach ($finances as $finance): ?>
                            <?php
                                echo $no.". ".date('M/d/Y', $finance['created_at']).", Sejumlah : ". currency( number_format($finance['total'],0,",",".")); 
                            ?>  
                            <br> 
                        <?php $no++; endforeach; ?>

                        <strong> <?php echo get_phrase('Uang Titipan'); ?> : </strong> <br> 
                        <?PHP  echo "Uang Titipan sejumlah : ". currency( number_format($savings['total'],0,",",".")); ?>                                
                        <?PHP /*  
                        <?php if ($invoice['updated_at'] > 0): ?>
                            <?php echo date('M/d/Y', $invoice['updated_at']); ?>
                        <?php else: ?>
                            <?php echo get_phrase('not_found'); ?>
                        <?php endif; ?>
                        */ ?>
                    </small>
                </td>
                <td> <?php echo $invoice['note']; ?> </td>
                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
