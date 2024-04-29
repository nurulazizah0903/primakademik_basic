<?php
$school_id = school_id();
if(isset($location_id) && $location_id != ''){
$this->db->where('location_id', $location_id);
}
$this->db->where('school_id', $school_id);
$means = $this->db->get('means')->result_array();
?>
<?php if (count($means) > 0): ?>
  <div class="table-responsive-sm">
    <table id="example" class="table table-striped dt-responsive" width="100%">
      <thead class="thead-dark">
        <tr>
          <th><?php echo get_phrase('name'); ?></th>
          <th><?php echo get_phrase('condition'); ?></th>
          <th><?php echo get_phrase('amount'); ?></th>
          <th><?php echo get_phrase('amount_issues'); ?></th>
          <th><?php echo get_phrase('description'); ?></th>
          <th><?php echo get_phrase('location'); ?></th>
          <th><?php echo get_phrase('option'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($means as $mean): 
          $location = $this->crud_model->get_locations_by_id($mean['location_id']);
          ?>
          <tr>
            <td> <?php echo $mean['name']; ?> </td>
            <td> <?php echo $mean['condition']; ?> </td>
            <td> <?php echo $mean['amount']; ?> </td>
            <td>
              <?php
                $number_of_issued_mean = $this->crud_model->get_number_of_issued_mean_by_id($mean['id']);
                echo $number_of_issued_mean;
                ?>
            </td>
            <td> <?php echo $mean['status']; ?> </td>
            <td> <?php echo $location['name']; ?> </td>
            <td>
              <div class="dropdown text-center">
      					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
      					<div class="dropdown-menu dropdown-menu-right">
      						<!-- item-->
      						<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/means/edit/'.$mean['id'])?>', '<?php echo get_phrase('update_infrastructure'); ?>');"><?php echo get_phrase('edit'); ?></a>
      						<!-- item-->
      						<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('means/delete/'.$mean['id']); ?>', showAllMeans )"><?php echo get_phrase('delete'); ?></a>
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
