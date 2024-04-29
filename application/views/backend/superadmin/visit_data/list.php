<?php 
$school_id = school_id();
$visit_datas = $this->db->get_where('visit_data', array('school_id' => $school_id, 'session' => active_session()))->result_array();
?>
<?php if (count($visit_datas) > 0): ?>
    <div class="table-responsive">
    <table id="example" class="table table-striped dt-responsive nowrap" width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('user_name'); ?></th>
                <th><?php echo get_phrase('role'); ?></th>
                <th><?php echo get_phrase('date_visit'); ?></th>
                <th><?php echo get_phrase('phone'); ?></th>
                <th><?php echo get_phrase('address'); ?></th>
                <th><?php echo get_phrase('option'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($visit_datas as $visit_data):
                $users_details = $this->db->get_where('users', array('id' => $visit_data['user_id']))->row_array();	
                ?>
                <tr>
                    <td>
                        <?php 
                        if(!empty($visit_data['user_id'])){
                        echo $users_details['name']; 
                        }else{
                            echo $visit_data['name']; 
                        }
                        ?>
                    </td>
                    <td>
                        <?php 
                        if ($users_details['role'] == 'teacher') {
                            echo get_phrase('teacher');
                        }elseif ($users_details['role'] == 'student') {
                            echo get_phrase('student');
                        }elseif ($users_details['role'] == 'accountant') {
                            echo get_phrase('accountant');
                        }else{
                            echo get_phrase('tamu');
                        }
                        ?>
                    </td>
                    <td>
                        <?php echo date('D, d/M/Y', $visit_data['date']); ?>
                    </td>
                    <td>
                        <?php 
                        if(!empty($visit_data['user_id'])){
                        echo $users_details['phone']; 
                        }else{
                            echo $visit_data['phone']; 
                        }
                        ?>
                    </td>
                    <td>
                        <?php 
                        if(!empty($visit_data['user_id'])){
                        echo $users_details['address']; 
                        }else{
                            echo $visit_data['address']; 
                        }
                        ?>
                    </td>
                    <td>
                        <div class="dropdown text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/visit_data/edit/'.$visit_data['id'])?>', '<?php echo get_phrase('update_visit_data_information'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('visit_data/delete/'.$visit_data['id']); ?>', showAllVisitData )"><?php echo get_phrase('delete'); ?></a>
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
                    columns: [ 0 , 1 , 2 , 3 ]
                },
                text: 'Export to Excel <i class="far fa-file-excel"></i>',
                className: 'btn btn-info btn-md p-2',
            }
        ]
    } );
} );
</script>