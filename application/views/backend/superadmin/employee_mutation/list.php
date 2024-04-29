<?php
$school_id = school_id();
$employee_mutations = $this->user_model->get_employee_mutation()->result_array();
if (count($employee_mutations) > 0): ?>
<div class="table-responsive">
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('nip'); ?></th>
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('date_mutation'); ?></th>
            <th><?php echo get_phrase('caption_mutation'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($employee_mutations as $employee_mutation){
            ?>
            <tr>
                <td><?= $employee_mutation['nip']; ?></td>
                <td><?= $employee_mutation['name']; ?></td>
                <td><?= date('D, d/M/Y', $employee_mutation['date']);?></td>
                <td><?= $employee_mutation['caption'];?></td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/employee_mutation/edit/'.$admin['id']); ?>', '<?php echo get_phrase('update_admin'); ?>')"><?php echo get_phrase('edit'); ?></a> -->
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('employee_mutation/delete/'.$employee_mutation['id']); ?>', showAllEmployeeMutation )"><?php echo get_phrase('delete'); ?></a>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>