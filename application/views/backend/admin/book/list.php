<?php
$books = $this->crud_model->get_books()->result_array();
?>
<?php if (count($books) > 0): ?>
    <table id="example" class="table table-striped dt-responsive" width="100%">
      <thead class="thead-dark">
        <tr>
          <th><?php echo get_phrase('kode_buku'); ?></th>
          <th><?php echo get_phrase('book_name'); ?></th>
          <th><?php echo get_phrase('jenis_buku'); ?></th>
          <th><?php echo get_phrase('available_copies'); ?></th>
          <th></th>
          <th><?php echo get_phrase('option'); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($books as $book): 
          $book_types = $this->crud_model->get_book_types_by_id($book['book_type_id']);
          ?>
          <tr>
            <td> <?php echo $book['book_code']; ?> </td>
            <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/book/detail/'.$book['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $book['name']; ?><br></a> </td>
            <td> <?= ($book['book_type_id'] == '0') ? get_phrase('ebook')  : $book_types['name']; ?> </td>
            <td>
              <?php if ($book['book_type_id'] == '0') {
                echo get_phrase('ebook');
                } else { 
                $number_of_issued_book = $this->crud_model->get_number_of_issued_book_by_id($book['id']);
                echo $book['copies'] - $number_of_issued_book;
                }
                ?>
            </td>
            <td>
              <?php if ($book['book_type_id'] == '0') { ?>
                <a class="btn btn-icon btn-info btn-sm" style="margin-right:5px;" target="_blank" href="<?php echo route('book/ebook/'.$book['id']); ?>" data-original-title="<?php echo get_phrase('read_ebook'); ?>"> <i class="mdi mdi-eye"></i></a>
              <?php } else { } ?>
            </td>
            <td>
              <div class="dropdown text-center">
      					<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
      					<div class="dropdown-menu dropdown-menu-right">
      						<!-- item-->
      						<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/book/edit/'.$book['id'])?>', '<?php echo get_phrase('update_book'); ?>');"><?php echo get_phrase('edit'); ?></a>
      						<!-- item-->
      						<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('book/delete/'.$book['id']); ?>', showAllBooks )"><?php echo get_phrase('delete'); ?></a>
      					</div>
      				</div>
            </td>
          </tr>
        <?php endforeach; ?>
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
                    columns: [ 0 , 1 , 2 , 3 , 4 , 5 , 6 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>
