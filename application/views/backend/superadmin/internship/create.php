<?php $school_id = school_id(); ?>

<!-- Daterangepicker -->
<link href="<?php echo base_url(); ?>assets/backend/css/vendor/daterangepicker.css" rel="stylesheet" type="text/css" />

<div class="row">
    <div class="col-12">
        <div class="card pt-0">
            <h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('create_routine'); ?></h4>
            <form method="POST" class="d-block ajaxForm" action="<?php echo route('internship/add'); ?>">
            <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
            <div class="col-md-12">
                <div class="form-group row mb-3">
                    <label class="col-md-3 col-form-label" for="select_company"><?php echo get_phrase('select_company'); ?></label>
                    <div class="col-md-9">
                        <select class="form-control select2" name="company_id" id="company_id" required>
                            <option value=""><?php echo get_phrase('select_company'); ?></option>>
                            <?php $companies = $this->db->get_where('industry_company', array('school_id' => $school_id))->result_array();
                                foreach($companies as $company){ ?>
                                <option value="<?php echo $company['id']; ?>"><?php echo $company['company_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-md-3 col-form-label" for="select_dates"><?php echo get_phrase('select_dates'); ?></label>
                    <div class="col-md-9">
                    <input class="form-control input-daterange-datepicker" type="text" name="daterange">
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-3 col-form-label" for="select_dates"><?php echo get_phrase('keterangan'); ?></label>
                    <div class="col-md-9">
                        <textarea class="form-control" id="example-textarea" rows="5" name = "description" placeholder="keterangan"></textarea>                    
                    </div>
                </div>

                <div class="form-group row mb-3">
                    <label class="col-md-3 col-form-label" for="select_dates"><?php echo get_phrase('upload_file'); ?></label>
                    <div class="col-md-9">
                        <input type="file" id="file" class="form-control" name="internship_file">                    
                    </div>
                </div>

                <div class="alert alert-secondary" role="alert" style="text-align:center;">
                    <?php echo get_phrase('details_student_internship'); ?>
                </div>

                <div id ="first-row">
                    <div class="form-group row mb-3">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <select class="form-control select2" name="student_id[]" id="student_id">
                                <option value=""><?php echo get_phrase('select_student'); ?></option>>
                                <?php $students = $this->db->get_where('students', array('school_id' => $school_id))->result_array(); ?>
                                <?php foreach($students as $student){ ?>
                                    <option value="<?php echo $student['id']; ?>"><?php echo $this->db->get_where('users', array('id' => $student['user_id']))->row('name'); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-icon btn-success" onclick="appendRow()"> <i class="mdi mdi-plus"></i> </button>
                        </div>
                    </div>
                </div>


                <div class="form-group  col-md-12">
                    <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_internship'); ?></button>
                </div>
            </div>
            </form>
            
            <div id ="blank-row" style="display: none;">
                <div class="student-row">
                    <div class="form-group row mb-3">
                        <div class="col-md-1"></div>
                        <div class="col-md-6">
                            <select class="form-control select2 student" name="student_id[]" id="student_id">
                                <option value=""><?php echo get_phrase('select_student'); ?></option>>
                                <?php $students = $this->db->get_where('students', array('school_id' => $school_id))->result_array(); ?>
                                <?php foreach($students as $student){ ?>
                                    <option value="<?php echo $student['id']; ?>"><?php echo $this->db->get_where('users', array('id' => $student['user_id']))->row('name'); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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