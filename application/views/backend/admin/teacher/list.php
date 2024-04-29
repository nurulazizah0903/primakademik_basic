<?php
$school_id = school_id();
$check_data = $this->db->get_where('teachers', array('school_id' => $school_id));
if($check_data->num_rows() > 0):?>
<div class="table-responsive">
<table id="example" class="table table-striped dt-responsive nowrap" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('name'); ?></th>
            <th><?php echo get_phrase('mengajar_mapel'); ?></th>
            <th><?php echo get_phrase('address'); ?></th>
            <th><?php echo get_phrase('phone'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $teachers = $this->db->get_where('teachers', array('school_id' => $school_id))->result_array();
        foreach($teachers as $teacher){
            ?>
            <tr>
                <td>
                <small> <strong><?php echo get_phrase('nip'); ?> : <?php echo $this->user_model->get_user_details($teacher['user_id'], 'nip'); ?></strong> </small><br>
                    <a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/teacher/profile/'.$teacher['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $this->user_model->get_user_details($teacher['user_id'], 'name'); ?></a>
                </td>
                <td>    
                    <ul>
                    <?php $subjects = $this->db->get_where('subjects', array('teacher_id' => $teacher['id']))->result_array();
                    foreach($subjects as $subject){ ?>
                    <li><?= $subject['name']; ?></li>
                    <?php } ?>
                    </ul>
                </td>
                <td><?php echo $this->user_model->get_user_details($teacher['user_id'], 'address'); ?></td>
                <td><?php echo $this->user_model->get_user_details($teacher['user_id'], 'phone'); ?></td>
                <td>
                    <div class="dropdown text-center">
                        <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="rightModal('<?php echo site_url('modal/popup/teacher/permission_overview/'.$teacher['id'].'/'.$teacher['user_id']); ?>', '<?php echo get_phrase('assigned_permissions'); ?>')"><?php echo get_phrase('permissions'); ?></a>
                            <!-- item-->
                            <a href="<?php echo route('teacher/edit/'.$teacher['user_id']); ?>" class="dropdown-item"><?php echo get_phrase('edit'); ?></a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('teacher/delete/'.$teacher['user_id']); ?>', showAllTeachers )"><?php echo get_phrase('delete'); ?></a>
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
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                exportOptions : {
                    columns: [ 0 , 2 , 3 , 4 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>