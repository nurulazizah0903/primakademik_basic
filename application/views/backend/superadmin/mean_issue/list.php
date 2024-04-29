<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><?php echo get_phrase('returned_mean_issue'); ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="parent-tab" data-toggle="tab" href="#parent_info" role="tab" aria-controls="parent_info" aria-selected="false"><?php echo get_phrase('pending_mean_issue'); ?></a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="guardian-tab" data-toggle="tab" href="#guardian_info" role="tab" aria-controls="guardian_info" aria-selected="false"><?php echo get_phrase('tenggat_waktu'); ?></a>
    </li>
</ul>
<?php 
$school_id = school_id();
$date = date('D, d/M/Y');
?>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab"><br>
            <?php 
            $this->db->where('status', 1);
            $this->db->where('school_id', $school_id);
            $mean_issues = $this->db->get('mean_issues')->result_array();
            if (count($mean_issues) > 0): ?>
            <div class="table-responsive">
                <table id="table_return" class="table table-striped dt-responsive" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th><?php echo get_phrase('mean_issue_name'); ?></th>
                            <th><?php echo get_phrase('issue_date'); ?></th>
                            <th><?php echo get_phrase('return_date'); ?></th>
                            <th><?php echo get_phrase('name'); ?></th>
                            <th><?php echo get_phrase('status'); ?></th>
                            <th><?php echo get_phrase('option'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mean_issues as $mean_issue):
                            $mean_details = $this->crud_model->get_means_by_id($mean_issue['mean_id']);
                            $users = $this->user_model->get_user_details($mean_issue['user_id']);
                            ?>
                            <tr>
                                <td><?php echo $mean_details['name']; ?></td>
                                <td>
                                    <?php echo date('d M Y', strtotime($mean_issue['issue_date'])); ?>
                                </td>
                                <td>
                                    <?php echo date('d M Y', strtotime($mean_issue['return_date'])); ?>
                                </td>
                                <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/mean_issue/detail/'.$mean_issue['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $users['name']; ?><br></a>
                                </td>
                                <td>
                                    <i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('returned'); ?>
                                </td>
                                <td>
                                <!-- <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-sm" style="margin-right:3px;" onclick="largeModal('<?php echo site_url('modal/popup/mean_issue/edit/'.$mean_issue['id'])?>', '<?php echo get_phrase('update_mean_issue_information'); ?>');" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></a> -->
                				<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('mean_issue/delete/'.$mean_issue['id']); ?>', showAllMeanIssues )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
                                    <!-- <div class="dropdown text-center">
                                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('mean_issue/delete/'.$mean_issue['id']); ?>', showAllMeanIssues )"><?php echo get_phrase('delete'); ?></a>
                                        </div>
                                    </div> -->
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
            $this->db->where('return_date >', date('m/d/Y'));
            $this->db->where('status', 0);
            $this->db->where('school_id', $school_id);
            $mean_issues = $this->db->get('mean_issues')->result_array();
            if (count($mean_issues) > 0): ?>
            <div class="table-responsive">
                <table id="table_pending" class="table table-striped dt-responsive" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th><?php echo get_phrase('mean_issue_name'); ?></th>
                            <th><?php echo get_phrase('issue_date'); ?></th>
                            <th><?php echo get_phrase('return_date'); ?></th>
                            <th><?php echo get_phrase('name'); ?></th>
                            <th><?php echo get_phrase('status'); ?></th>
                            <th><?php echo get_phrase('option'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mean_issues as $mean_issue):
                            $mean_details = $this->crud_model->get_means_by_id($mean_issue['mean_id']);
                            $users = $this->user_model->get_user_details($mean_issue['user_id']);
                            ?>
                            <tr>
                                <td><?php echo $mean_details['name']; ?></td>
                                <td>
                                    <?php echo date('d M Y', strtotime($mean_issue['issue_date'])); ?>
                                </td>
                                <td>
                                    <?php echo date('d M Y', strtotime($mean_issue['return_date'])); ?>
                                </td>
                                <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/mean_issue/detail/'.$mean_issue['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $users['name']; ?><br></a>
                                </td>
                                <td>
                                    <i class="mdi mdi-circle text-disable"></i> <?php echo get_phrase('pending'); ?>
                                </td>
                                <td>
                                <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-sm" style="margin-right:3px;" onclick="largeModal('<?php echo site_url('modal/popup/mean_issue/edit/'.$mean_issue['id'])?>', '<?php echo get_phrase('update_mean_issue_information'); ?>');" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></a>
                				<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('mean_issue/delete/'.$mean_issue['id']); ?>', showAllMeanIssues )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
                                <button type="button" class="btn btn-icon btn-success btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('mean_issue/return/'.$mean_issue['id']); ?>', showAllMeanIssues )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('mean_issue_already_return'); ?>"> <i class="mdi mdi-check"></i></button>
                                    <!-- <div class="dropdown text-center">
                                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/mean_issue/edit/'.$mean_issue['id'])?>', '<?php echo get_phrase('update_mean_issue_information'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                                <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('mean_issue/return/'.$mean_issue['id']); ?>', showAllMeanIssues )"><?php echo get_phrase('mean_issue_already_return'); ?></a>
                                                <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('mean_issue/delete/'.$mean_issue['id']); ?>', showAllMeanIssues )"><?php echo get_phrase('delete'); ?></a>
                                        </div>
                                    </div> -->
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
            $this->db->where('return_date <', date('m/d/Y'));
            $this->db->where('status', 0);
            $this->db->where('school_id', $school_id);
            $mean_issues = $this->db->get('mean_issues')->result_array();
            if (count($mean_issues) > 0): ?>
            <div class="table-responsive">
                <table id="table_due_date" class="table table-striped dt-responsive" width="100%">
                    <thead class="thead-dark">
                        <tr>
                            <th><?php echo get_phrase('mean_issue_name'); ?></th>
                            <th><?php echo get_phrase('issue_date'); ?></th>
                            <th><?php echo get_phrase('return_date'); ?></th>
                            <th><?php echo get_phrase('name'); ?></th>
                            <th><?php echo get_phrase('status'); ?></th>
                            <th><?php echo get_phrase('option'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mean_issues as $mean_issue):
                            $mean_details = $this->crud_model->get_means_by_id($mean_issue['mean_id']);
                            $users = $this->user_model->get_user_details($mean_issue['user_id']);
                            ?>
                            <tr>
                                <td><?php echo $mean_details['name']; ?></td>
                                <td>
                                    <?php echo date('d M Y', strtotime($mean_issue['issue_date'])); ?>
                                </td>
                                <td>
                                    <?php echo date('d M Y', strtotime($mean_issue['return_date'])); ?>
                                </td>
                                <td> <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/mean_issue/detail/'.$mean_issue['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"> <?php echo $users['name']; ?><br></a>
                                </td>
                                <td>
                                    <i class="mdi mdi-circle text-danger"></i> <?php echo get_phrase('due_date'); ?>
                                </td>
                                <td>
                                <a href="javascript:void(0);" class="btn btn-icon btn-secondary btn-sm" style="margin-right:3px;" onclick="largeModal('<?php echo site_url('modal/popup/mean_issue/edit/'.$mean_issue['id'])?>', '<?php echo get_phrase('update_mean_issue_information'); ?>');" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"> <i class="mdi mdi-pencil"></i></a>
                				<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('mean_issue/delete/'.$mean_issue['id']); ?>', showAllMeanIssues )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-delete"></i></button>
                                <button type="button" class="btn btn-icon btn-success btn-sm" style="margin-right:3px;" onclick="confirmModal('<?php echo route('mean_issue/return/'.$mean_issue['id']); ?>', showAllMeanIssues )" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('mean_issue_already_return'); ?>"> <i class="mdi mdi-check"></i></button>
                                    <!-- <div class="dropdown text-center">
                                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                                <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/mean_issue/edit/'.$mean_issue['id'])?>', '<?php echo get_phrase('update_mean_issue_information'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                                <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('mean_issue/return/'.$mean_issue['id']); ?>', showAllMeanIssues )"><?php echo get_phrase('mean_issue_already_return'); ?></a>
                                                <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('mean_issue/delete/'.$mean_issue['id']); ?>', showAllMeanIssues )"><?php echo get_phrase('delete'); ?></a>
                                        </div>
                                    </div> -->
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