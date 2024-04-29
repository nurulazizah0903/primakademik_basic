<?php
$school_id = school_id();
$check_data = $this->db->get_where('registrations');
if($check_data->num_rows() > 0):?>
<div class="card-body">
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('kode_registrasi'); ?></th>
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('status'); ?></th>
            <th><?php echo get_phrase('nilai_ranking'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $registrations = $this->db->get_where('registrations', array('status' => 'Processed'))->result_array();
        foreach($registrations as $item){
            ?>
            <tr>
                <td>
                    <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/registration/profile/'.$item['id'])?>')">
                        <?php echo $item['kode_registrasi']; ?>
                    </a>
                </td>
                <td>
                    <?php echo $item['nama_lengkap']; ?>
                </td>
                <td>
                    <?php echo $item['status']; ?>
                </td>
                <td>
                    <?php echo $item['nilai_ranking']; ?>
                </td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/registration/edit/'.$item['id']); ?>', '<?php echo get_phrase('update_registration'); ?>')"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <!-- <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('teacher/delete/'.$teacher['user_id']); ?>', showAllTeachers )"><?php echo get_phrase('delete'); ?></a> -->
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
