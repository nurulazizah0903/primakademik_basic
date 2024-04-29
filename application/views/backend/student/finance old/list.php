<?php
$school_id = school_id();
if (isset($class_id) ):
    $finances  = $this->db->get_where('finances', array('student_id' => $class_id, 'session_id' => active_session()))->result_array();
    // echo var_dump($class_id);
    // echo var_dump($section_id);
    // die;
    if(count($finances) > 0):?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead class="thead-dark">
        <tr>  
            <th><?php echo get_phrase('invoice_no'); ?></th>
            <th><?php echo get_phrase('payment'); ?></th>
            <th><?php echo get_phrase('total'); ?></th>
            <th><?php echo get_phrase('bukti'); ?></th>
            <th><?php echo get_phrase('student'); ?></th>
            <th><?php echo get_phrase('class'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($finances as $finance):
              $student_details = $this->user_model->get_student_details_by_id('student', $finance['student_id']);
              $class_details = $this->crud_model->get_class_details_by_id($finance['class_id'])->row_array();
            //   $section_details = $this->db->get_where('sections', array('id' => $finance['section_id']))->row_array();
              $payment_types = $this->crud_model->get_payment_type_id_details_by_id($finance['payment_type_id'])->row_array();
              $invoices = $this->db->get_where('invoices', array('id' => $finance['invoices_id']))->row_array();
        ?>
        <tr>
            <td>
                <?php echo $invoices['title']; ?>
                <br> 
                <small style="font-size: 10px; color: #9E9E9E;"><strong> <?php echo get_phrase('payment_date'); ?>: <?php echo date('M/d/Y', $finance['created_at']); ?></strong> </small>
            </td> 
            <td><?php echo $payment_types['name']; ?></td> 
            <td><?php echo currency( number_format($finance['total'],0,",",".")); ?></td>
            <td>
                <?php
                    if (!empty($finance['file'])){
                ?>
                <a href="javascript:void(0);" onclick="rightModal('<?php echo site_url('modal/popup/finance/proof/'.$finance['id'])?>', '<?php echo get_phrase('bukti_pembayaran');?>')" class="btn btn-info"><?php echo get_phrase('see'); ?></a>
                <a href="javascript:void(0);" class="btn btn-success" onclick="rightModal('<?php echo site_url('modal/popup/finance/edit/'.$finance['id'])?>', '<?php echo get_phrase('upload_bukti'); ?>');"><i class="fa fa-refresh"></i></a>
                <!-- <a href="javascript:void(0);" id="<?php echo $finance['id']?>"  data-toggle="modal" data-target="#exampleModal" class="btn btn-info"><?php echo get_phrase('see');?></a> -->
            <?php  
            }else{
            ?>
            Belum Upload Bukti
            <?php } ?>
            </td>
            <td>
                <?php echo $student_details['name']; ?>
                <br> 
                <small style="font-size: 10px; color: #9E9E9E;"><?php echo get_phrase('student_code'); ?>: <?php echo $student_details['code']; ?></small>
            </td>
            <td><?php echo $class_details['name']; ?></td> 
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
