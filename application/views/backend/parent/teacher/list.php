<?php
$school_id = school_id();
$check_data = $this->db->get_where('teachers', array('school_id' => $school_id));
if($check_data->num_rows() > 0):?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('department'); ?></th>
            <th><?php echo get_phrase('designation'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $teachers = $this->db->get_where('teachers', array('school_id' => $school_id))->result_array();
        foreach($teachers as $teacher){
            ?>
            <tr>
                <td>
                    <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/teacher/profile/'.$teacher['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $this->user_model->get_user_details($teacher['user_id'], 'name'); ?></a>
                </td>
                <td><?php echo $this->db->get_where('departments', array('id' => $teacher['department_id']))->row('name'); ?></td>
                <td><?php echo $teacher['designation']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
