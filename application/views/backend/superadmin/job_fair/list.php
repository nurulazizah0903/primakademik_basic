<?php
$school_id = school_id();
$job_fairs = $this->crud_model->get_job_fairs()->result_array();

if (count($job_fairs) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
    <thead>
        <tr style="background-color: #313a46; color: #ababab;">
            <th><?php echo get_phrase('job_fair_title'); ?></th>
			<th><?php echo get_phrase('photo'); ?></th>
			<th><?php echo get_phrase('description'); ?></th>
            <th><?php echo get_phrase('options'); ?></th>
        </tr>
    </thead>
    <tbody>
	<?php foreach($job_fairs as $job_fair):
	?>
	<tr>
	    <td><?php echo $job_fair['title']; ?></td>
		<td>
		<a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/job_fair/detail/'.$job_fair['photo'])?>')">
		<img class="w3-round" width="50" height="50" src="<?php echo $this->crud_model->get_job_fair_image($job_fair['photo']); ?>"></a></td>
		<td><?php echo $job_fair['description']; ?></td>	
		<td>
			<button type="button" class="btn btn-icon btn-danger btn-sm" style="margin-right:5px;" onclick="confirmModal('<?php echo route('job_fair/delete/'.$job_fair['id']); ?>', showAllJobfairs)" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('delete'); ?>"> <i class="mdi mdi-window-close"></i></button>
			<a href="javascript:void(0);" class="btn btn-icon btn-info btn-sm" onclick="showAjaxModal('<?php echo site_url('modal/popup/job_fair/edit/'.$job_fair['id'])?>', '<?php echo get_phrase('update'); ?>');"><i class="mdi mdi-pencil"></i></a>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
