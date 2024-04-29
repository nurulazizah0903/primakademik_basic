<?php
    $school_id = school_id();

    $this->db->where('school_id', $school_id);
    $data_list = $this->db->get('industry_company')->result_array();
    // print_r($data_list); die;
    if (count($data_list) > 0):
?>

<div class="table-responsive-sm">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
      <thead class="thead-dark">
        <tr>
            <th><?php echo get_phrase('company_name'); ?></th>
            <th><?php echo get_phrase('phone_number'); ?></th>
            <th><?php echo get_phrase('address'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
      </thead>
      <tbody>
            <?php
                foreach ($data_list as $data) {
            ?>
            <tr>
                <td><?= $data['company_name'] ?></td>
                <td><?= $data['phone_number'] ?></td>
                <td><?= $data['address'] ?></td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/industry_company/edit/'.$data['id'])?>', '<?php echo get_phrase('update_industry_company'); ?>');"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('industry_company/delete/'.$data['id']); ?>', showAllIndustry)"><?php echo get_phrase('delete'); ?></a>
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

<script>
</script>