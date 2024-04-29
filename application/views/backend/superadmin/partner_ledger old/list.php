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
      
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead class="thead-dark">
            <tr> 
                <th><?php echo get_phrase('student'); ?></th>
                <th><?php echo get_phrase('tanggal'); ?></th>
                <th><?php echo get_phrase('rekening'); ?></th>
                <th><?php echo get_phrase('label'); ?></th>
                <th><?php echo get_phrase('debit'); ?></th>
                <th><?php echo get_phrase('kredit'); ?></th> 
            </tr>
        </thead>
        <tbody>
            <?php
            // $invoices = $this->crud_model->get_invoice_by_parent_id();
            foreach ($invoices as $invoice): 
                $class_details = $this->crud_model->get_class2_details_by_id($invoice['student_id'])->row_array();   
                $payment_type = $this->crud_model->get_payment_type_id_details_by_id($invoice['payment_type_id'])->row_array(); 
                $account_details = $this->crud_model->account_details()->row_array(); 
            ?>
                <tr>
                    <td>
                        <?php echo $student_data['name']." - ".$student_data['nisn']; ?> <br>
                        <small> <strong><?php echo get_phrase('class'); ?> :</strong> <?php echo $class_details['sectionname'].' - '.$class_details['classname']; ?></small>
                    </td>
                    <td> <?php echo date('d-M-Y', $invoice['created_at']); ?></td>
                    <td> 11210011 Piutang Siswa </td>
                    <td> <?php echo $invoice['title']; ?> </td> 
                    <td> <?php echo currency( number_format($invoice['total_amount'],0,",",".")); ?>  </td>  
                    <td> 0 </td>  
                </tr>
                <tr>
                    <td>
                        <?php echo $student_data['name']." - ".$student_data['nisn']; ?> <br>
                        <small> <strong><?php echo get_phrase('class'); ?> :</strong> <?php echo $class_details['sectionname'].' - '.$class_details['classname']; ?></small>
                    </td>
                    <td> <?php echo date('d-M-Y', $invoice['created_at']); ?></td>
                    <td> 41000011 Pendapatan Sekolah </td> 
                    <td> <?php echo $payment_type['name']; ?> </td>
                    <td> 0 </td>  
                    <td> <?php echo currency( number_format($invoice['total_amount'],0,",",".")); ?>  </td>  
                </tr>
                <?php  
                $finances = $this->db->get_where('finances', array('invoices_id' => $invoice['id']))->result_array();                 
                foreach ($finances as $finance):
                    $savingsto = $this->db->get_where('savings', array('finances_to_id' => $finance['id']))->row_array();
                    if(isset($savingsto))
                    { 
                ?>
                <tr>
                    <td>
                        <?php echo $student_data['name']." - ".$student_data['nisn']; ?> <br>
                        <small> <strong><?php echo get_phrase('class'); ?> :</strong> <?php echo $class_details['sectionname'].' - '.$class_details['classname']; ?></small>
                    </td>
                    <td> <?php echo date('d-M-Y', $finance['created_at']); ?></td>
                    <td> 21100011 Uang Titipan </td>
                    <td> Pembayaran <?php echo $payment_type['name']; ?> </td> 
                    <td> <?php echo currency( number_format($savingsto['total'],0,",",".")); ?>  </td>  
                    <td> 0 </td>  
                </tr>
                <?php } ?>
                <tr>
                    <td>
                        <?php echo $student_data['name']." - ".$student_data['nisn']; ?> <br>
                        <small> <strong><?php echo get_phrase('class'); ?> :</strong> <?php echo $class_details['sectionname'].' - '.$class_details['classname']; ?></small>
                    </td>
                    <td> <?php echo date('d-M-Y', $finance['created_at']); ?></td>
                    <td> 11110001 Kas </td>
                    <td> <?php echo $invoice['title']; ?> </td> 
                    <td> 
                        <?php 
                        if($finance['total'] == 0 && isset($savingsto)){
                            echo currency( number_format($savingsto['total'],0,",",".")); 
                        }else{ 
                            echo currency( number_format($finance['total'],0,",",".")); 
                        } ?>  
                    </td>  
                    <td> 0 </td>  
                </tr>
                <tr>
                    <td>
                        <?php echo $student_data['name']." - ".$student_data['nisn']; ?> <br>
                        <small> <strong><?php echo get_phrase('class'); ?> :</strong> <?php echo $class_details['sectionname'].' - '.$class_details['classname']; ?></small>
                    </td>
                    <td> <?php echo date('d-M-Y', $invoice['created_at']); ?></td>
                    <td> 11210011 Piutang Siswa </td> 
                    <td> Pembayaran <?php echo $payment_type['name']; ?> </td>
                    <td> 0 </td>  
                    <td> 
                        <?php if($finance['total'] < $invoice['total_amount']){
                            echo currency( number_format($finance['total'],0,",","."));
                        } else{
                            echo currency( number_format($invoice['total_amount'],0,",","."));
                        }
                        ?>  
                    </td>  
                </tr>
                <?php  
                    $savingsfrom = $this->db->get_where('savings', array('finances_from_id' => $finance['id']))->row_array(); 
                    if(isset($savingsfrom))
                    { 
                ?>
                <tr>
                    <td>
                        <?php echo $student_data['name']." - ".$student_data['nisn']; ?> <br>
                        <small> <strong><?php echo get_phrase('class'); ?> :</strong> <?php echo $class_details['sectionname'].' - '.$class_details['classname']; ?></small>
                    </td>
                    <td> <?php echo date('d-M-Y', $finance['created_at']); ?></td>
                    <td> 21100011 Uang Titipan </td>
                    <td> </td> 
                    <td> 0 </td> 
                    <td> <?php echo currency( number_format($savingsfrom['total'],0,",",".")); ?>  </td>                       
                </tr>
                <?php } ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table> 
    <script type="text/javascript">
            initDataTable('basic-datatable');
        </script>
    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>