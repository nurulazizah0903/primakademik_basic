<?php
$school_id = school_id();
$date = date('m/d/Y');
$job_management = $this->crud_model->get_job_management()->result_array();
// print_r($job_management);

// die();
if (count($job_management) > 0): ?>
<table id="example" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('nip'); ?></th>
			<th><?php echo get_phrase('role'); ?></th>
			<th><?php echo get_phrase('deparment'); ?></th>
			<th><?php echo get_phrase('start_date'); ?></th>
			<th><?php echo get_phrase('finish_date'); ?></th>
			<th><?php echo get_phrase('status'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php	foreach($job_management as $job):
				$users = $this->user_model->get_user_details($job['user_id']);
				$department = $this->db->get_where('departments', array('id' => $job['department_id']))->row_array();
			?>
			<tr>
				<td>
					<?php echo $users['nip']; ?><br>
					<small> <strong><?php echo get_phrase('name'); ?> : <?php echo $users['name']; ?></strong> </small>
				</td>
				<td>
				<?php 
                        if ($job['role'] == 'teacher') {
                            echo get_phrase('teacher');
                        }elseif ($job['role'] == 'librarian') {
                            echo get_phrase('librarian');
                        }elseif ($job['role'] == 'accountant') {
                            echo get_phrase('accountant');
                        }elseif ($job['role'] == 'other_employee') {
                            echo get_phrase('other_employee');
                        }else{

                        }
                ?>
				</td>
				<td><?= $department['name'];?></td>
				<td><?php echo date('D, d/M/Y', strtotime($job['start_date'])); ?></td>
				<td><?php
					if ($job['finish_date'] == 0) {
						echo get_phrase('--');
					}else{
						echo date('D, d/M/Y', strtotime($job['finish_date'])); 
					}?>
				</td>
				<td>
				<?php if ($job['status'] == "1") { ?>
						<i class="mdi mdi-circle text-success"></i> <?php echo get_phrase('active'); ?>
					<?php
					}elseif ($job['status'] == "0") { ?>
						<i class="mdi mdi-circle text-disabled"></i> <?php echo get_phrase('inactive'); ?>
				<?php } ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>
<script>
$(document).ready(function() {
	$('#example').DataTable( {
        order: [[1, 'asc'], [2, 'asc']],
        rowGroup: {
            dataSrc: [1, 2]
        }
    } );
    // $('#example').DataTable( {
    //     dom: 'Bfrtip',
    //     buttons: [
    //         {
    //             extend: 'excelHtml5',
    //             exportOptions : {
    //                 columns: [ 0 , 1 ]
    //             },
    //             text: 'Export to Excel <i class="far fa-file-excel"></i>',
    //             className: 'btn btn-info btn-md p-2',
    //         }
    //     ]
    // } );
	// var groupColumn = 1;
    // var table = $('#example').DataTable({
	// 	dom: 'Bfrtip',
        // "columnDefs": [
        //     { "visible": false, "targets": groupColumn }
        // ],
		// order: [[1, 'asc']],
        // rowGroup: {
        //     dataSrc: [ 1 ]
        // },
        // columnDefs: [ {
        //     targets: [ 1 ],
        //     visible: false
        // } ],
		// buttons: [
        //     {
        //         extend: 'excelHtml5',
        //         exportOptions : {
        //             columns: [ 0 , 1 ]
        //         },
        //         text: 'Export to Excel <i class="far fa-file-excel"></i>',
        //         className: 'btn btn-info btn-md p-2',
        //     }
        // ],
        // "order": [[ groupColumn, 'asc' ]],
        // "displayLength": 10,
        // "drawCallback": function ( settings ) {
        //     var api = this.api();
        //     var rows = api.rows( {page:'current'} ).nodes();
        //     var last = null;
		// 	var rowCount = 0;
 
            // api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
				// console.log(group)
				// console.log(i)
				// console.log($(rows).eq(i))				
        //         if ( last !== group ) {
		// 			if (last === undefined) {
		// 				rowCount = 1;                        
        //             }
        //             $(rows).eq( i ).before(`
		// 				<tr class="group">
		// 					<td colspan="5"><b><h4>${group == "" ? 'Tidak Ada' : group}</h4></b></td>
		// 				</tr>
		// 			`);
 
        //             last = group;
		// 			// rowCount = 1;
        //         }
        //     } );
        // }
    // } );
} );
</script>
