<?php
if(isset($student_id)):
    $student_data = $this->user_model->get_student_details_by_id('student', $student_id);
    // var_dump($student_data); die; 
    $journals = $this->crud_model->get_journal_by_student_id($student_data['student_id'])->result_array();
    // print_r($journals); die;

    if(count($journals) > 0):?> 
    <div class="row">
	<div class="col-md-12"> 
    <div class="table-responsive"> 
    <table id="example" class="table table-sm table-centered dt-responsive" width="100%"> 
        <thead class="thead-dark">
            <tr>                 
                <th><?php echo get_phrase('date'); ?></th>
                <th><?php echo get_phrase('student'); ?></th>
                <th><?php echo get_phrase('rekening'); ?></th>
                <th><?php echo get_phrase('label'); ?></th>
                <th><?php echo get_phrase('debit'); ?></th>
                <th><?php echo get_phrase('kredit'); ?></th> 
            </tr>
        </thead>
        <tbody>
            <?php 
            $jumlah_debit=0; $jumlah_credit=0;
            foreach ($journals as $journal): 
                $class_details = $this->crud_model->get_class2_details_by_id($journal['student_id'])->row_array();    
                $account_details = $this->crud_model->get_account_id_details_by_id($journal['account_id'])->row_array(); 
                $jumlah_debit  = $jumlah_debit + $journal['debit'];
				$jumlah_credit = $jumlah_credit + $journal['credit'];
            ?>
            <!------------ journal ------------>
                <tr>
                    <td> <?php echo date('Y/M/d', $journal['created_at']); ?></td>
                    <td>
                        <?php echo $student_data['name']; ?> <br>
                        <small> <strong><?php echo get_phrase('nisn'); ?> :</strong> <?php echo $student_data['nisn']; ?> </small> <br>
                        <small> <strong><?php echo get_phrase('section'); ?> :</strong> <?php echo $class_details['sectionname'].' - '.$class_details['classname']; ?></small>
                    </td> 
                    <td> <?php echo $account_details['code']." - ".$account_details['name']; ?> </td>
                    <td> <?php echo $journal['label']; ?> </td> 
                    <td> <?php echo currency( number_format($journal['debit'],0,",",".")); ?>  </td>  
                    <td> <?php echo currency( number_format($journal['credit'],0,",",".")); ?>  </td> 
                </tr> 
            <!------------ journal ------------>
            <?php endforeach; ?>
        </tbody>
        <tfooter class="thead-dark">
            <tr>                 
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th><?php echo currency( number_format($jumlah_debit,0,",","."));?></th>
                <th><?php echo currency( number_format($jumlah_credit,0,",","."));?></th> 
            </tr>
        </tfooter>
    </table>  
    </div>
    </div>
    </div> 
    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
    <?php else: ?>
        <?php include APPPATH.'views/backend/empty.php'; ?>
    <?php endif; ?>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            "scrollX":  true,
            "paging":   false,
            "info":     false,
            "sort":     false
        } );
    } ); 
</script>