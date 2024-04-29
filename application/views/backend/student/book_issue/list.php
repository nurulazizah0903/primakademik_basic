<?php
$student_details = $this->db->get_where('students', array('user_id' => $this->session->userdata('user_id')))->row_array();
$book_issues = $this->crud_model->get_book_issues_by_user_id($student_details['user_id'])->result_array(); 
?>

<?php if (count($book_issues) > 0): ?>
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('book_name'); ?></th>
                <th><?php echo get_phrase('issue_date'); ?></th>
                <th><?php echo get_phrase('return_date'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($book_issues as $book_issue):
                $book_details = $this->crud_model->get_book_by_id($book_issue['book_id']);
                ?>
                <tr>
                <td><a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/book/detail/'.$book_issue['book_id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $book_details['name']; ?></a></td>
                    <td>
                        <?php echo date('D, d/M/Y', $book_issue['issue_date']); ?>
                    </td>
                    <td>
                        <?php echo date('D, d/M/Y', strtotime($book_issue['return_date'])); ?>
                    </td>
                    <td>
                        <?php if ($book_issue['return_date'] <= date('m/d/Y')){ ?>
                            <i class="mdi mdi-circle text-danger"></i> <?php echo get_phrase('terlambat'); ?>
                        <?php }else if($book_issue['status'] == 0){ ?>
                            <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('terpinjam'); ?>
                        <?php }else{ ?>
                            <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('returned'); ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
