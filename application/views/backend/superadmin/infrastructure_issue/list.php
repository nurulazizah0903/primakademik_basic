<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('infrastructure_loan_history'); ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="parent-tab" data-toggle="tab" href="#parent_info" role="tab" aria-controls="parent_info" aria-selected="false"><?php echo get_phrase('infrastructure_that_is_being_borrowed'); ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="guardian-tab" data-toggle="tab" href="#guardian_info" role="tab" aria-controls="guardian_info" aria-selected="false"><?php echo get_phrase('future_infrastructure_loan'); ?></a>
    </li>
</ul>
<?php 
$school_id = school_id();
$date = date('D, d/M/Y');
?>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab"><br>
            <?php 
            $this->db->where('date <', date('m/d/Y'));
            $this->db->where('school_id', $school_id);
            $infrastructure_issues = $this->db->get('infrastructure_issues')->result_array();
            if (count($infrastructure_issues) > 0): ?>
            <div class="table-responsive">
                <table id="table_return" class="table table-striped dt-responsive" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th><?php echo get_phrase('infrastructure_issue_name'); ?></th>
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
                                    <?php echo date('d M Y', strtotime($infrastructure_issue['date'])); ?>
                                </td>
                                <td><?php echo $infrastructure_issue['issue_start']; ?></td>
                                <td><?php echo $infrastructure_issue['return_start']; ?></td>
                                <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/infrastructure_issue/detail/'.$infrastructure_issue['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $users['name']; ?><br></a>
                                </td>
                                <td>
                                    <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('returned'); ?>
                                </td>
                                <td>
                				<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('infrastructure_issue/delete/'.$infrastructure_issue['id']); ?>', showAllInfrastructureIssues )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <?php include APPPATH.'views/backend/empty.php'; ?>
            <?php endif; ?>
        </div>

        <div class="tab-pane fade show" id="parent_info" role="tabpanel" aria-labelledby="parent-tab"><br>
        <?php 
            $this->db->where('date =', date('m/d/Y'));
            $this->db->where('school_id', $school_id);
            $infrastructure_issues = $this->db->get('infrastructure_issues')->result_array();
            if (count($infrastructure_issues) > 0): ?>
            <div class="table-responsive">
                <table id="table_pending" class="table table-striped dt-responsive" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th><?php echo get_phrase('infrastructure_issue_name'); ?></th>
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
                                    <?php echo date('d M Y', strtotime($infrastructure_issue['date'])); ?>
                                </td>
                                <td><?php echo $infrastructure_issue['issue_start']; ?></td>
                                <td><?php echo $infrastructure_issue['return_start']; ?></td>
                                <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/infrastructure_issue/detail/'.$infrastructure_issue['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $users['name']; ?><br></a>
                                </td>
                                <td>
                                    <i class="mdi mdi-circle text-disable"></i> <?php echo get_phrase('pending'); ?>
                                </td>
                                <td>
                                <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-sm" style="margin-right:3px;" onclick="largeModal('<?php echo site_url('modal/popup/infrastructure_issue/edit/'.$infrastructure_issue['id'])?>', '<?php echo get_phrase('update_infrastructure_issue_information'); ?>');" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></a>
                				<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('infrastructure_issue/delete/'.$infrastructure_issue['id']); ?>', showAllInfrastructureIssues )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <?php include APPPATH.'views/backend/empty.php'; ?>
            <?php endif; ?>
        </div>

        <div class="tab-pane fade show" id="guardian_info" role="tabpanel" aria-labelledby="guardian-tab"><br>
        <?php 
            $this->db->where('date >', date('m/d/Y'));
            $this->db->where('school_id', $school_id);
            $infrastructure_issues = $this->db->get('infrastructure_issues')->result_array();
            if (count($infrastructure_issues) > 0): ?>
            <div class="table-responsive">
                <table id="table_due_date" class="table table-striped dt-responsive" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th><?php echo get_phrase('infrastructure_issue_name'); ?></th>
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
                                    <?php echo date('d M Y', strtotime($infrastructure_issue['date'])); ?>
                                </td>
                                <td><?php echo $infrastructure_issue['issue_start']; ?></td>
                                <td><?php echo $infrastructure_issue['return_start']; ?></td>
                                <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/infrastructure_issue/detail/'.$infrastructure_issue['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $users['name']; ?><br></a>
                                </td>
                                <td>
                                    <i class="mdi mdi-circle text-info"></i> <?php echo get_phrase('coming'); ?>
                                </td>
                                <td>
                                <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-sm" style="margin-right:3px;" onclick="largeModal('<?php echo site_url('modal/popup/infrastructure_issue/edit/'.$infrastructure_issue['id'])?>', '<?php echo get_phrase('update_infrastructure_issue_information'); ?>');" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></a>
                				<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('infrastructure_issue/delete/'.$infrastructure_issue['id']); ?>', showAllInfrastructureIssues )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <?php include APPPATH.'views/backend/empty.php'; ?>
            <?php endif; ?>
        </div>
    </div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#table_return').DataTable( {
            "info":     false
        } );
    } );

    $(document).ready(function() {
        $('#table_pending').DataTable( {
            "info":     false
        } );
    } );

    $(document).ready(function() {
        $('#table_due_date').DataTable( {
            "info":     false
        } );
    } );
</script>