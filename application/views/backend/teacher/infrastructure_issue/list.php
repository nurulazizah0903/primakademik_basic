<?php 
$school_id = school_id();
// $infrastructure_issues = $this->crud_model->get_infrastructure_issues($date_from, $date_to)->result_array(); 
$infrastructure_issues = $this->crud_model->get_infrastructure_issues_all()->result_array(); 
// $date = date('D, d/M/Y');
?>
<?php if (count($infrastructure_issues) > 0): ?>
    <div class="table-responsive">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('infrastructure_name'); ?></th>
                <th><?php echo get_phrase('date'); ?></th>
                <th><?php echo get_phrase('issue_start'); ?></th>
                <th><?php echo get_phrase('return_start'); ?></th>
                <th><?php echo get_phrase('name'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
                <th><?php echo get_phrase('option'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($infrastructure_issues as $infrastructure_issue):
                $infrastructure_details = $this->crud_model->get_infrastructure_by_id($infrastructure_issue['infrastructure_id']);
                $users = $this->user_model->get_user_details($infrastructure_issue['user_id']);
                ?>
                <tr>
                    <td><?php echo $infrastructure_details['name']; ?></td>
                    <td>
                        <?php echo date('D, d/M/Y', strtotime($infrastructure_issue['date'])); ?>
                    </td>
                    <td>
                        <?php echo $infrastructure_issue['issue_start']; ?>
                    </td>
                    <td>
                        <?php echo $infrastructure_issue['return_start']; ?>
                    </td>
                    <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/infrastructure_issue/detail/'.$infrastructure_issue['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $users['name']; ?><br></a>
                    </td>
                    <td>
                        <?php if ($infrastructure_issue['status'] == 1): ?>
                            <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('returned'); ?>
                        <?php elseif ($infrastructure_issue['status'] == 2): ?>
                            <i class="mdi mdi-circle text-danger"></i> <?php echo get_phrase('due_date'); ?>
                        <?php else: ?>
                            <i class="mdi mdi-circle text-disable"></i> <?php echo get_phrase('pending'); ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="dropdown text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <?php if ($infrastructure_issue['status'] == 0): ?>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/infrastructure_issue/edit/'.$infrastructure_issue['id'])?>', '<?php echo get_phrase('update_infrastructure_issue_information'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('infrastructure_issue/return/'.$infrastructure_issue['id']); ?>', showAllInfrastructureIssues )"><?php echo get_phrase('infrastructure_already_return'); ?></a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('infrastructure_issue/due_date/'.$infrastructure_issue['id']); ?>', showAllInfrastructureIssues )"><?php echo get_phrase('mean_due_date'); ?></a>
                                <?php elseif($infrastructure_issue['status'] == 2): ?>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/infrastructure_issue/edit/'.$infrastructure_issue['id'])?>', '<?php echo get_phrase('update_infrastructure_issue_information'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('infrastructure_issue/return/'.$infrastructure_issue['id']); ?>', showAllInfrastructureIssues )"><?php echo get_phrase('infrastructure_already_return'); ?></a>
                                    <?php endif; ?>
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('infrastructure_issue/delete/'.$infrastructure_issue['id']); ?>', showAllInfrastructureIssues )"><?php echo get_phrase('delete'); ?></a>
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
                    columns: [ 0 , 1 , 2 , 3 , 4 , 5 , 6 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>