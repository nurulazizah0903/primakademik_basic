<?php 
$school_id = school_id();
$this->db->where('return_date >=', date('m/d/Y'));
$this->db->where('status', 0);
$this->db->where('school_id', $school_id);
$book_issues = $this->db->get('book_issues')->result_array();

if (count($book_issues) > 0): ?>
<div class="table-responsive">
    <table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('book_name'); ?></th>
                <th><?php echo get_phrase('issue_date'); ?></th>
                <th><?php echo get_phrase('return_date'); ?></th>
                <th><?php echo get_phrase('name'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
                <th><?php echo get_phrase('day_issues'); ?></th>
                <th><?php echo get_phrase('option'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($book_issues as $book_issue):
                $book_details = $this->crud_model->get_book_by_id($book_issue['book_id']);
                $users = $this->user_model->get_user_details($book_issue['user_id']);
                $student_details = $this->user_model->get_student_details_by_id('student', $book_issue['student_id']);
                $class_details = $this->crud_model->get_class_details_by_id($book_issue['class_id'])->row_array();
                $section_details = $this->db->get_where('sections', array('id' => $book_issue['section_id']))->row_array();
                ?>
                <tr>
                <td><a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/book/detail/'.$book_issue['book_id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $book_details['name']; ?></a></td>
                    <td>
                        <?php echo date('d M Y', $book_issue['issue_date']); ?>
                    </td>
                    <td>
                        <?php echo date('d M Y', strtotime($book_issue['return_date'])); ?>
                    </td>
                    <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/book_issue/detail/'.$book_issue['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $users['name']; ?><br></a>
                    </td>
                    <td>
                        <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('terpinjam'); ?>
                    </td>
                    <td>
                        <?php 
                            $date1 =  date("d M Y", $book_issue['issue_date']);
                            $date2 =  date("d M Y", strtotime($book_issue['return_date']));
                            $date3 = date_create("$date1");
                            $date4 = date_create("$date2");
                            $date5 = date_create("$date");
                            $diff1 = date_diff($date4, $date3);
                            $diff2 = date_diff($date3, $date5);
                        ?>
                        <?= $diff1->format('%a');?> <?php echo get_phrase('day'); ?><br>
                    </td>
                    <td>
                        <div class="dropdown text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/book_issue/edit/'.$book_issue['id'])?>', '<?php echo get_phrase('update_book_issue_information'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <!-- item-->
                                    <a href="<?php echo route('book_issue/return/'.$book_issue['id']); ?>" class="dropdown-item"><?php echo get_phrase('book_already_return'); ?></a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('book_issue/delete/'.$book_issue['id']); ?>', showAllBookIssues )"><?php echo get_phrase('delete'); ?></a>
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
    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllBookIssues);
    });
</script>