<?php $school_id = school_id(); ?>
<div class="row">
    <div class="col-12">
        <div class="card pt-0">
            <h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('create_routine'); ?></h4>
            <form method="POST" class="d-block ajaxForm" action="<?php echo route('routine/add'); ?>">
            <div class="col-md-12">
                <div class="form-group row mb-3">
                    <label class="col-md-3 col-form-label" for="select_subject"><?php echo get_phrase('select_subject'); ?></label>
                    <div class="col-md-9">
                        <select class="form-control select2" name="day" id="day" required>
                            <option value=""><?php echo get_phrase('select_a_day'); ?></option>
                            <option value="Sunday"><?php echo get_phrase('sunday'); ?></option>
                            <option value="Monday"><?php echo get_phrase('monday'); ?></option>
                            <option value="Tuesday"><?php echo get_phrase('tuesday'); ?></option>
                            <option value="Wednesday"><?php echo get_phrase('wednesday'); ?></option>
                            <option value="Thursday"><?php echo get_phrase('thursday'); ?></option>
                            <option value="Friday"><?php echo get_phrase('friday'); ?></option>
                            <option value="Saturday"><?php echo get_phrase('saturday'); ?></option>
                        </select>
                    </div>
                </div>

                <div id = "first-row">
                    <div class="form-group row mb-3">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <select class="form-control select2" name="subject_id[]" id="subject_id" required>
                                <option value=""><?php echo get_phrase('select_subject'); ?></option>>
                                <?php $subjects = $this->db->get_where('subjects', array('school_id' => $school_id))->result_array();
                                    foreach($subjects as $subject){ ?>
                                    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?> - <?php echo $this->db->get_where('class_rooms', array('id' => $subject['room_id']))->row('name');?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control select2" name="hour_id[]" id="hour_id">
                                <option value=""><?php echo get_phrase('select_a_time'); ?></option>>
                                <?php $operational_hours = $this->db->get_where('operational_hour', array('school_id' => $school_id))->result_array(); ?>
                                <?php foreach($operational_hours as $operational_hour){ ?>
                                    <option value="<?php echo $operational_hour['id']; ?>"><?php echo $operational_hour['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-icon btn-success" onclick="appendRow()"> <i class="mdi mdi-plus"></i> </button>
                        </div>
                    </div>
                </div>

                <div class="form-group  col-md-12">
                    <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_class_routine'); ?></button>
                </div>
            </div>
            </form>
            
            <div id = "blank-row" style="display: none;">
                <div class="student-row">
                    <div class="form-group row mb-3">
                        <div class="col-md-1"></div>
                        <div class="col-md-4">
                            <select class="form-control select2 subject" name="subject_id[]" required>
                                <option value=""><?php echo get_phrase('select_subject'); ?></option>>
                                <?php $subjects = $this->db->get_where('subjects', array('school_id' => $school_id))->result_array();
                                    foreach($subjects as $subject){ ?>
                                    <option value="<?php echo $subject['id']; ?>"><?php echo $subject['name']; ?> - <?php echo $this->db->get_where('class_rooms', array('id' => $subject['room_id']))->row('name');?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-control select2 hour" name="hour_id[]">
                                <option value=""><?php echo get_phrase('select_a_time'); ?></option>>
                                <?php $operational_hours = $this->db->get_where('operational_hour', array('school_id' => $school_id))->result_array(); ?>
                                <?php foreach($operational_hours as $operational_hour){ ?>
                                    <option value="<?php echo $operational_hour['id']; ?>"><?php echo $operational_hour['name']; ?></option>
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
    var blank_field = $('#blank-row').html();
    var row = 1;
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit2(e, form, getFilteredClassRoutine);
        location.reload();
    });
    
    function appendRow() {
        $('#first-row').append(blank_field);
        row++;
        $('.subject').attr('id', 'subject_id'+row);
        $('.hour').attr('id', 'hour_id'+row);

        $('#subject_id' + row, '.student-row').select2();
        $('#hour_id' + row, '.student-row').select2();
    }
    
    function removeRow(elem) {
        $(elem).closest('.student-row').remove();
        row--;
    }
    
    $(document).ready(function() {
        $('.select2').select2();
    });

    $(document).ready(function () {
        initSelect2(['#subject_id']);
        initSelect2(['#hour_id']);
    });

    if($('select').hasClass('select2') == true){
        $('div').attr('tabindex', "");
        // $(function(){$(".select2").select2()});
    }
</script>