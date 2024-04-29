  
<?php $student_data = $this->user_model->get_logged_in_student_details(); //var_dump( $student_data);?>
<div class="alert alert-warning mt-3" role="alert">
  No. Virtual Account <strong><?php echo $student_data['name']; ?> : <?php echo $student_data['va']; ?></strong>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">  
                <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
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

                        <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="fullWidthModalLabel">Modal Heading</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" class="d-block ajaxForm" action="<?php echo route('invoice/payment/'.$param1); ?>">
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="class_id_on_create"><?php echo get_phrase('class'); ?></label>
                                                <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2"  required onchange="classWiseStudentOnCreate(this.value)" disabled >
                                                    <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                                                    <?php $classes = $this->crud_model->get_classes()->result_array(); ?>
                                                    <?php foreach($classes as $class): ?>
                                                        <option value="<?php echo $class['id']; ?>" <?php if ($class['id'] == $invoice_details['class_id']): ?> selected <?php endif; ?>><?php echo $class['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="section_id_on_create"><?php echo get_phrase('section'); ?></label>
                                                <select name="section_id_on_create" id="section_id_on_create" class="form-control select2" data-toggle="select2"  required  disabled >
                                                    <option value=""><?php echo get_phrase('select_a_section'); ?></option>
                                                    <?php $sections = $this->crud_model->get_section_details_by_id('class', $invoice_details['class_id'])->result_array(); ?>
                                                    <?php foreach($sections as $section): ?>
                                                        <option value="<?php echo $section['id']; ?>" <?php if ($section['id'] == $invoice_details['section_id']): ?> selected <?php endif; ?>><?php echo $section['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="student_id_on_create"><?php echo get_phrase('select_student'); ?></label>
                                                <div id = "student_content">
                                                    <select name="student_id" id="student_id_on_create" class="form-control select2" data-toggle="select2" required disabled >
                                                        <option value=""><?php echo get_phrase('select_a_student'); ?></option>
                                                        <?php $enrolments = $this->user_model->get_student_details_by_id('class', $invoice_details['class_id']);
                                                        foreach ($enrolments as $enrolment): ?>
                                                            <option value="<?php echo $enrolment['student_id']; ?>" <?php if ($invoice_details['student_id'] == $enrolment['student_id']): ?>selected<?php endif; ?>><?php echo $enrolment['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group col-md-6"> 
                                                <label for="invoice_id"><?php echo get_phrase('invoice'); ?></label>
                                                <input type="text" class="form-control" id="invoice_id" name = "invoice_id" value="<?php echo $invoice_details['title']; ?>" required disabled >
                                            </div> 
                                            
                                            <div class="form-group col-md-6">
                                                <?PHP $payment_types = $this->db->get_where('payment_types', array('id' => $invoice_details['payment_type_id']) )->row_array(); ?>
                                                <label for="payment_type_id"><?php echo get_phrase('master_payment_type'); ?></label>
                                                <input type="text" class="form-control" id="payment_type_id" name = "payment_type_id" value="<?php echo $payment_types['name']; ?>" required disabled >
                                            </div>

                                            <div class="form-group col-md-12">
                                                <label for="note"><?php echo get_phrase('note'); ?></label>      
                                                <textarea class="form-control" id="note" name="note" rows="3" disabled ><?php echo $invoice_details['note']; ?></textarea>
                                            </div>          

                                            <?PHP if(isset($savings)) {?> 
                                            <div class="form-group col-md-6">
                                                <label for="total_amount"><?php echo get_phrase('Nominal Tagihan').' ('.currency_code_and_symbol('code').')'; ?></label>
                                                <?PHP $total_amount22 = $invoice_details['total_amount'] - $invoice_details['paid_amount']?>
                                                <input type="text" class="form-control" id="total_amount" name = "total_amount" value="<?php echo $total_amount22; ?>" style="font-weight: bold; background-color: #d1e6d6;" required disabled>
                                            </div>  

                                            <?PHP /* <div class="form-group col-md-12">
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" class="form-check-input" id="savings_use"  name="savings_use" value="1">
                                                    <label class="form-check-label" for="savings_use"> Memiliki Uang Titipan, Apakah di gunakan?  </label>
                                                </div> 
                                            </div>   */ ?> 

                                            <div class="form-group col-md-6">
                                                <label for="a_total"><?php echo get_phrase('Uang Titipan').' ('.currency_code_and_symbol('code').')'; ?></label>
                                                <input type="text" class="form-control" id="saving_total" name="saving_total" value="<?PHP echo $savings['total']; ?>" required disabled>
                                                <input type="hidden" class="form-control" id="a" name="a" value="<?PHP echo $savings['total']; ?>" >
                                                <input type="hidden" class="form-control" id="saving_id" name="saving_id" value="<?PHP echo $savings['id']; ?>" >
                                            </div>
                                            
                                            <?PHP 
                                                if($total_amount22 > $savings['total'])
                                                {
                                                    $total_amount3 = $total_amount22 - $savings['total'];
                                            ?> 
                                            <div class="form-group col-md-12">
                                                <label for="total_amount"><?php echo get_phrase('total_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
                                                <input type="text" class="form-control" id="total_amount1" name = "total_amount1" value="<?php echo $total_amount3; ?>" style="font-weight: bold; background-color: #d1e6d6;" required disabled>
                                            </div> 

                                            <div class="form-group col-md-4">
                                                <label for="paid_amount"><?php echo get_phrase('paid_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
                                                <input type="text" class="form-control" autocomplete="off" id="paid_amount" name = "paid_amount" value="<?php echo $total_amount3; ?>" required>
                                            </div>

                                            <div class="form-group col-md-8">
                                                <label for="finances_file"><?php echo get_phrase('upload_bukti'); ?></label>
                                                <div class="custom-file-upload">
                                                    <input type="file" class="form-control" id="finances_file" name = "finances_file" required>
                                                </div>
                                            </div>  
                                            <?PHP
                                                }
                                                else
                                                {
                                                    $total_amount3 = 0;
                                            ?>
                                            <div class="form-group col-md-12">
                                                <label for="total_amount"><?php echo get_phrase('total_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
                                                <input type="text" class="form-control" id="total_amount1" name = "total_amount1" value="<?php echo $total_amount3; ?>" style="font-weight: bold; background-color: #d1e6d6;" required disabled>
                                            </div> 

                                            <div class="form-group col-md-12">
                                                <label for="paid_amount"><?php echo get_phrase('paid_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
                                                <input type="text" class="form-control" autocomplete="off" id="paid_amount" name = "paid_amount" value="<?php echo $total_amount3; ?>"  required>
                                            </div>  
                                            <?PHP
                                                } 
                                            ?> 

                                            <?PHP } else {?>
                                            <div class="form-group col-md-12">
                                                <label for="total_amount"><?php echo get_phrase('total_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
                                                <?PHP $total_amount22 = $invoice_details['total_amount'] - $invoice_details['paid_amount']?>
                                                <input type="text" class="form-control" id="total_amount" name = "total_amount" value="<?php echo $total_amount22; ?>" style="font-weight: bold; background-color: #d1e6d6;" required disabled>
                                            </div>    

                                            <div class="form-group col-md-4">
                                                <label for="paid_amount"><?php echo get_phrase('paid_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
                                                <input type="text" class="form-control" autocomplete="off" id="paid_amount" name = "paid_amount" value="<?php echo $total_amount22; ?>" required>
                                            </div>

                                            <div class="form-group col-md-8">
                                                <label for="finances_file"><?php echo get_phrase('upload_bukti'); ?></label>
                                                <div class="custom-file-upload">
                                                    <input type="file" class="form-control" id="finances_file" name = "finances_file" required>
                                                </div>
                                            </div>  
                                            <?PHP } ?>     
                                        </div>
                                        <div class="form-group  col-md-12">
                                            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_finance'); ?></button>
                                        </div>
                                    </form>
                                    </div> 
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->

                    </tbody>
                </table>  
			</div>
		</div>
	</div>
</div>
