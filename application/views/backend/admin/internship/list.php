<?php
    $school_id = school_id();
    $active_session = active_session();

    $this->db->select('industry_company.company_name AS company_name, internship.start_date, internship.end_date, internship.id AS id_internship');
    $this->db->where('internship.school_id', $school_id);
    $this->db->where('internship.session_id', $active_session);
    $this->db->join('industry_company', 'internship.company_id=industry_company.id');
    $data_list = $this->db->get('internship')->result_array();
    if (count($data_list) > 0):
?>

<div class="table-responsive-sm">
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
      <thead class="thead-dark">
        <tr>
            <th><?php echo get_phrase('company_name'); ?></th>
            <th><?php echo get_phrase('start_date_internship'); ?></th>
            <th><?php echo get_phrase('end_date_internship'); ?></th>
            <th><?php echo get_phrase('attendance'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
      </thead>
      <tbody>
            <?php
                foreach ($data_list as $data) {
            ?>
            
            <tr>
                <td>
                    <?= $data['company_name'] ?>
                </td>
                <td><?= date("d M Y", $data['start_date']) ?></td>
                <td><?= date("d M Y", $data['end_date']) ?></td>
                <td>
                    <a href="<?php echo route('internship/attendance/'.$data['id_internship']); ?>" class="btn btn-sm btn-icon btn-rounded btn-outline-info"><?= get_phrase('internship_attendance'); ?></a>
                </td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/internship/detail_list/'.$data['id_internship'])?>', '<?php echo get_phrase('details_student_internship').' '.$data['company_name'] ?>')"><?php echo get_phrase('detail_team'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/internship/edit/'.$data['id_internship'])?>', '<?php echo get_phrase('update_industry_company'); ?>');"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('internship/delete/'.$data['id_internship']); ?>', showAllInternship)"><?php echo get_phrase('delete'); ?></a>
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

<script type="text/javascript">
    
</script>