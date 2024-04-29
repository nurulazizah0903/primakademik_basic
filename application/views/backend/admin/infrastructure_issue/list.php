<?php 
$school_id = school_id();
if(isset($infrastructure_id) && $infrastructure_id != ''){
$this->db->where('infrastructure_id', $infrastructure_id);
}
if(isset($date) && $date != ''){
$this->db->where('date', $date);
} 
$this->db->where('date <', date('m/d/Y'));
$this->db->where('school_id', $school_id);
$infrastructure_issues = $this->db->get('infrastructure_issues')->result_array();
?>
<?php if (count($infrastructure_issues) > 0): ?>
    <div class="table-responsive">
    <table id="example" class="table table-striped dt-responsive nowrap" width="100%">
        <thead class="thead-dark">
            <tr>
                <th><?php echo get_phrase('infrastructure_name'); ?></th>
                <th><?php echo get_phrase('date'); ?></th>
                <th><?php echo get_phrase('issue_start'); ?></th>
                <th><?php echo get_phrase('return_start'); ?></th>
                <th><?php echo get_phrase('name'); ?></th>
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
                        <div class="dropdown text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('infrastructure_issue/delete/'.$infrastructure_issue['id']); ?>', showAllInfrastructureIssuesBack )"><?php echo get_phrase('delete'); ?></a>
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
        "paging":   false,
        "info":     false
    } );
} );

$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllInfrastructureIssuesBack);
    });
</script>