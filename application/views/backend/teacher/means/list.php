<?php
$means = $this->crud_model->get_means()->result_array();
?>
<?php if (count($means) > 0): ?>
  <div class="table-responsive-sm">
    <table id="example" class="table table-striped dt-responsive nowrap" width="100%">
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
        <?php foreach ($means as $mean): ?>
          <tr>
            <td> <?php echo $mean['name']; ?> </td>
            <td> <?php echo $mean['condition']; ?> </td>
            <td> <?php echo $mean['amount']; ?> </td>
            <td>
              <?php
                $number_of_issued_mean = $this->crud_model->get_number_of_issued_mean_by_id($mean['id']);
                $total = $mean['amount'] - $number_of_issued_mean;
                echo $total;
                ?>
            </td>
            <td> <?php echo $mean['status']; ?> </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions : {
                    columns: [ 0 , 1 , 2 , 3 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>
