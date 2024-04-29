<?php 
$journal_in =  $this->crud_model->get_finances_by_date_range2($date_from, $date_to, $selected_class, $selected_section, $selected_class2 )->result_array();
// var_dump($journal_in);
// die;
if (count($journal_in) > 0): ?>
<div class="table-responsive-sm">
  <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead class="thead-dark">
      <tr>
        <th><?php echo get_phrase('invoice_types'); ?></th>
        <th><?php echo get_phrase('invoice_no'); ?></th>
        <th><?php echo get_phrase('amount'); ?></th> 
        <th><?php echo get_phrase('name'); ?></th> 
        <th><?php echo get_phrase('class'); ?></th>
      </tr>
      
    </thead>
    <tbody>
      <?php foreach ($journal_in as $finance): 
        $student_details = $this->user_model->get_student_details_by_id('student', $finance['student_id']);
        $class_details = $this->crud_model->get_class_details_by_id($finance['class_id'])->row_array();          
        $section_details = $this->db->get_where('sections', array('id' => $finance['section_id']))->row_array();       
        $payment_types = $this->crud_model->get_payment_type_id_details_by_id($finance['payment_type_id'])->row_array();
        $invoices = $this->db->get_where('invoices', array('id' => $finance['invoices_id']))->row_array();   
        $uangppdb = $this->db->get('frontend_settings')->row_array();
      ?>
        <tr>
        <?PHP if(isset($finance['invoices_id'])) : ?> 
          <td><?php echo $payment_types['name']; ?> </td>
          <td>
            <?php echo $invoices['title']; ?> 
            <br> 
            <small style="font-size: 10px; color: #9E9E9E;"><strong> <?php echo get_phrase('payment_date'); ?>: <?php echo date('M/d/Y', $finance['created_at']); ?></strong> </small>
          </td>
          <td><?php echo currency( number_format($finance['total'],0,",",".")); ?>   </td> 
          <td>
                <?php echo $student_details['name']; ?>
                <br> 
                <small style="font-size: 10px; color: #9E9E9E;">
                  <strong><?php echo get_phrase('NISN'); ?>: <?php echo $student_details['code']; ?></strong></small>
          </td> 
          <td><?php echo $class_details['name']. " - ".$section_details['name']; ?> </td>  
        <?PHP else: ?> 
          <td><?php echo get_phrase('Pembayaran_PPDB'); ?></td>
          <td>
            <?php echo $finance['registrations_kode']; ?> 
            <br> 
            <small style="font-size: 10px; color: #9E9E9E;"><strong> <?php echo get_phrase('payment_date'); ?>: <?php echo date('M/d/Y', $finance['created_at']); ?></strong> </small>
          </td>
          <td><?php echo currency( number_format($uangppdb['total'],0,",",".")); ?>   </td> 
          <td>
                <?php echo $finance['registrations_name']; ?>
                <br> 
                <small style="font-size: 10px; color: #9E9E9E;">
                  <strong><?php echo get_phrase('NISN'); ?>: <?php echo $finance['registrations_nisn']; ?></strong></small>
          </td> 
          <td></td>  
        <?PHP endif; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
