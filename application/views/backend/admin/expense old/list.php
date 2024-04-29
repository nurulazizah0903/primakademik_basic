<?php
$expenses = array(); 
$expenses = $this->crud_model->get_expense2($date_from, $date_to)->result_array();
if (count($expenses) > 0): ?>
<div class="table-responsive-sm">
  <table id="basic-datatable" class="table table-striped dt-responsive " width="100%">
    <thead class="thead-dark">
      <tr>
        <th style="width: 20%"><?php echo get_phrase('date'); ?></th>
        <th style="width: 20%"><?php echo get_phrase('Penanggung Jawab'); ?></th>
        <th style="width: 30%"><?php echo get_phrase('expense'); ?></th>
        <th style="width: 20%"><?php echo get_phrase('amount'); ?></th>
        <th style="width: 20%"><?php echo get_phrase('Nota'); ?></th>
        <th style="width: 10%"><?php echo get_phrase('option'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($expenses as $expense): ?>
        <tr>
          <td style="width: 20%"> <?php echo date('M/d/Y', $expense['date']); ?> </td>
          <td style="width: 20%" ><?php echo $expense['in_charge']; ?> </td>
          <td style="width: 30%" ><?php echo $expense['description']; ?> </td>
          <td style="width: 20%"><?php echo currency( number_format($expense['amount'],0,",",".")); ?> </td>
          <td style="width: 20%"><?php echo $expense['label']; ?> </td>
          <td style="width: 10%">
            <div class="dropdown text-center">
    					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
    					<div class="dropdown-menu dropdown-menu-right">
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/expense/edit/'.$expense['id'])?>', '<?php echo get_phrase('update_expense'); ?>');"><?php echo get_phrase('edit'); ?></a>
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('expense/delete/'.$expense['id']); ?>', showAllExpenses )"><?php echo get_phrase('delete'); ?></a>
    					</div>
    				</div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
