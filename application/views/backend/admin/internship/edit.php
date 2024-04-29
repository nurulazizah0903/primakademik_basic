<?php 
    $school_id = school_id();
    $this->db->where('school_id', $school_id);
    $this->db->where('id', $param1);
    $data_internship = $this->db->get('internship')->result_array();
    foreach($data_internship AS $data){
?>
    <form method="POST" class="d-block ajaxForm" action="<?php echo route('internship/update/'.$param1); ?>">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="col-md-12">
            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label" for="select_company"><?php echo get_phrase('select_company'); ?></label>
                <div class="col-md-9">
                    <select class="form-control select2" name="company_id" id="company_id" required>
                        <option value=""><?php echo get_phrase('select_company'); ?></option>>
                        <?php $companies = $this->db->get_where('industry_company', array('school_id' => $school_id))->result_array();
                            foreach($companies as $company){ ?>
                            <option value="<?php echo $company['id']; ?>" <?php if($data['company_id'] == $company['id']) echo 'selected'; ?>><?php echo $company['company_name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label" for="select_dates"><?php echo get_phrase('select_dates'); ?></label>
                <div class="col-md-9">
                    <?php
                        $start_date = date('m/d/Y', $data['start_date']);
                        $end_date = date('m/d/Y', $data['end_date']);
                    ?>
                    <input class="form-control input-daterange-datepicker" type="text" name="daterange" value="<?= $start_date; ?> - <?= $end_date; ?>">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label" for="select_dates"><?php echo get_phrase('keterangan'); ?></label>
                <div class="col-md-9">
                    <textarea class="form-control" id="example-textarea" rows="5" name = "description" placeholder="keterangan"><?= $data['description']; ?></textarea>                    
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-md-3 col-form-label" for="select_dates"><?php echo get_phrase('upload_file'); ?></label>
                <div class="col-md-9">
                    <?php if(!empty($data['file'])){    ?>
                        <div class="row">
                            <div class="col-md-2">
                                <a href="<?= base_url();?>uploads/internship/<?= $data['file']?>" target="_blank" class="btn btn-info"><?php echo get_phrase('see'); ?></a>
                            </div>
                            <div class="col-md-10">
                                <input type="file" id="file" class="form-control" name="internship_file">
                            </div>
                        </div>
                    <?php } else { ?>
                            <input type="file" id="file" class="form-control" name="internship_file">
                    <?php } ?>            
                </div>
            </div>

            <div class="form-group  col-md-12">
                <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_internship'); ?></button>
            </div>
        </div>
    </form>
<?php } ?>

<script>

    initCustomFileUploader();

    var blank_field = $('#blank-row').html();
    var row = 1;
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit2(e, form, showAllInternship);
        location.reload();
    });
    
    function appendRow() {
        $('#first-row').append(blank_field);
        row++;
        $('.student').attr('id', 'student_id'+row);

        $('#student_id' + row, '.student-row').select2();
        $('#student_id').select2();
    }
    
    function removeRow(elem) {
        $(elem).closest('.student-row').remove();
        row--;
    }
    
    $(document).ready(function() {
        $('.select2').select2();
    });

    $(document).ready(function () {
        initSelect2(['#student_id']);
    });

    $(".input-daterange-datepicker").daterangepicker({
        parentEl: ".modal-dialog .modal-body"            
    })

    if($('div').hasClass('modal-dialog') == true){
        $('div').attr('tabindex', "");
        // $(function(){$(".select2").select2()});
    }
</script>