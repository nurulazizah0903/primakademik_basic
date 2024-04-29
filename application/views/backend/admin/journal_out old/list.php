<?php
$journal_out= array(); 
$journal_out= $this->crud_model->get_expense2($date_from, $date_to)->result_array();
if (count($journal_out) > 0): ?>
<div class="table-responsive-sm">
  <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead class="thead-dark">
      <tr>        
        <th><?php echo get_phrase('expense'); ?></th>
        <th><?php echo get_phrase('Nota'); ?></th> 
        <th><?php echo get_phrase('amount'); ?></th>
        <th><?php echo get_phrase('name'); ?></th> 
      </tr>
    </thead>
    
    <tbody>
      <?php foreach ($journal_out as $expense): ?>
        <tr> 
          <td><?php echo $expense['description']; ?> </td>  
          <td>
            <?php echo $expense['label']; ?> 
            <br> 
            <small style="font-size: 10px; color: #9E9E9E;"><strong> <?php echo get_phrase('payment_date'); ?>: <?php echo date('M/d/Y', $expense['date']); ?></strong> </small>
          </td> 
          <td><?php echo currency( number_format($expense['amount'],0,",",".")); ?> </td>
          <td><?php echo $expense['in_charge']; ?> </td> 
          <?PHP /*  $session = $this->db->get_where('sessions', array('id' => $expense['session']))->row_array(); 
				  <td><?php echo $session['name']; ?></td>  
          */ ?>  
          
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
