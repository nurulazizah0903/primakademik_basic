<?php $book_favorits = $this->crud_model->get_book_issue_favorit(array('school_id' => school_id()))->result_array(); 
?>
<?php if (count($book_favorits) > 0): ?>
    <div class="table-responsive">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('kode_buku'); ?></th>
                <th><?php echo get_phrase('book_name'); ?></th>
                <th><?php echo get_phrase('publisher'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($book_favorits as $book_favorit):
                $book_details = $this->crud_model->get_book_by_id($book_favorit['book_id']);
                ?>
                <tr>
                    <td><?php echo $book_details['book_code']; ?></td>
                    <td><?php echo $book_details['name']; ?></td>
                    <td><?php echo $book_details['publisher']; ?></td>
                    <td>
                        <?php
                        $number_of_issued_book = $this->crud_model->get_number_of_issued_book_by_id($book_details['id']);
                        $total = $book_details['copies'] - $number_of_issued_book;

                        if ($total >= 1) { ?>
                            <i class="mdi mdi-circle text-success" title="Tersedia"></i> <?= get_phrase('tersedia'); ?> - <?= $total ?>
                        <?php
                        }else{ ?>
                            <i class="mdi mdi-circle text-danger" title="Tidak Tersedia"></i> <?= get_phrase('tidak_tersedia'); ?>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<script type="text/javascript">
initDataTable('basic-datatable');
</script>