<?php
$school_id = school_id();
$this->db->order_by('num', 'asc');
$this->db->where('assignment_id', $assignment_details['id']);
$questions = $this->db->get('assignment_questions')->result_array();
if (count($questions) > 0): ?>

    <table id="example" class="table table-striped dt-responsive" width="100%">
        <thead>
            <tr class="bg-dark text-muted">
                <th><?php echo get_phrase('nomor'); ?></th>
                <th><?php echo get_phrase('question_type'); ?></th>
                <th><?php echo get_phrase('question'); ?></th>
                <th><?php echo get_phrase('bobot'); ?></th>
                <th><?php echo get_phrase('action'); ?></th>
            </tr>
        </thead>
        <tbody class="row_position">
            <?php 
            $i = 1;
            foreach($questions as $question): ?>
                <tr id="<?php echo $question['id']?>">
                    <td><?= $question['num'] ?></td>
                    <td style="font-size:18px;"><span class="badge badge-info-lighten">
                        <?php
                        if ($question['question_type'] == "text") {
                            echo get_phrase('short_answer'); 
                        } elseif ($question['question_type'] == "file") {
                            echo get_phrase('stuffing'); 
                        } elseif ($question['question_type'] == "choices") {
                            echo get_phrase('multiple_choice'); 
                        } 
                        ?>  
                    </span></td>
                    <td>
                    <?php
                    if (empty($question['question'])) { ?>
                        <button type="button" class="btn btn-icon btn-info btn-sm" style="margin-right:5px;" onclick="showAjaxModal('<?php echo site_url('modal/popup/assignment/edit_question/'.$question['id'])?>', '<?php echo get_phrase('edit_assignment'); ?>');"> <i class="mdi mdi-circle-edit-outline"></i></button>
                        <button type="button" class="btn btn-icon btn-secondary btn-sm" style="margin-right:5px;" onclick="largeModal('<?php echo site_url('modal/popup/assignment/bank_soal/'.$question['id'])?>');"><?php echo get_phrase('take_from_question_bank'); ?></button>
                    <?php } else { ?>
                        <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/assignment/edit_question/'.$question['id'])?>', '<?php echo get_phrase('edit_assignment'); ?>');"><?php echo $question['question']; ?></a>
                    <?php } ?>
                    </td>
                    <td> <?=$question['mark'];?> </td>
                    <td>
                        <div class="dropdown text-center">
                            <button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/assignment/edit_question/'.$question['id'])?>', '<?php echo get_phrase('edit_assignment'); ?>');"><?php echo get_phrase('edit'); ?></a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo site_url('addons/assignment/questions/delete/'.$question['id']); ?>', showAssignmentQuestion)"><?php echo get_phrase('delete'); ?></a>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php 
            $i++;
            endforeach; ?>
        </tbody>
    </table><br><br>
<h4><font color="red">*</font><?php echo get_phrase('pastikan_bobot_telah_terisi'); ?></h4></font>
<h4><?php echo get_phrase('sebelum_publish_ujian'); ?></h4>
<?php else: ?>
    <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable( {
            "paging":   false,
            "info":     false
        } );
    } );

    $(".row_position").sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $(".row_position>tr").each(function() {
                selectedData.push($(this).attr("id"));
            });
            updateOrder(selectedData);
        }
    });

    function updateOrder(aData) {
        $.ajax({
            type : 'post',
            url: '<?php echo site_url('addons/assignment/questions/numbering/') ?>',
            data: {allData: aData},
            success: function() {
                location.reload();
                alert("Nomor Berhasil Diupdate");
            }
        });
    }
</script>