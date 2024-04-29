<?php
$school_id = school_id();
$active_session = active_session();
if(isset($class_id) && $class_id != ''){
  $this->db->where('class_id', $class_id);
}
$this->db->where('school_id', $school_id);
$this->db->where('session_id', $active_session);
$sections = $this->db->get('sections')->result_array();

if (count($sections) > 0): 
?>
  <table id="example" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
      <tr style="background-color: #313a46; color: #ababab;">
        <th><?php echo get_phrase('name'); ?></th>
        <th><?php echo get_phrase('options'); ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($sections as $section){ ?>
        <tr>
          <td><?php echo $section['name']; ?></td>
          <td>

            <div class="dropdown text-center">
    					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
    					<div class="dropdown-menu dropdown-menu-right">
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/section/edit/'.$section['id'])?>', '<?php echo get_phrase('update_section'); ?>');"><?php echo get_phrase('edit'); ?></a>
    						<!-- item-->
    						<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('section/delete/'.$section['id']); ?>', showAllSections)"><?php echo get_phrase('delete'); ?></a>
    					</div>
    				</div>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
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
                    columns: [ 0 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>