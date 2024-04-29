<?php
$infrastructures = $this->crud_model->get_infrastructure()->result_array();
?>
<?php if (count($infrastructures) > 0): ?>
  <div class="table-responsive-sm">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
      <thead class="thead-dark">
        <tr>
          <th><?php echo get_phrase('name'); ?></th>
          <th><?php echo get_phrase('condition'); ?></th>
          <th><?php echo get_phrase('amount'); ?></th>
          <th><?php echo get_phrase('amount_available'); ?></th>
          <th><?php echo get_phrase('status'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($infrastructures as $infrastructure): ?>
          <tr>
            <td> <?php echo $infrastructure['name']; ?> </td>
            <td> <?php echo $infrastructure['condition']; ?> </td>
            <td> <?php echo $infrastructure['amount']; ?> </td>
            <td>
              <?php
                $number_of_issued_infrastructure = $this->crud_model->get_number_of_issued_infrastructure_by_id($infrastructure['id']);
                $total = $infrastructure['amount'] - $number_of_issued_infrastructure;
                echo $total;
                ?>
            </td>
            <td> <?php echo $infrastructure['status']; ?> </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
