<?php 
$school_id = school_id(); 
$teacher_id = $this->db->get_where('teachers', array('user_id' => $this->session->userdata('user_id')))->row()->id;
?>
<form method="POST" class="d-block ajaxForm responsive_media_query" action="<?php echo route('attendance_routine/confirm_all'); ?>" style="min-width: 300px; max-width: 400px;">
    <div class="form-group row">
        <div class="col-md-12">
            <label  for="class_id_on_taking_attendance"><?php echo get_phrase('subjects'); ?></label>
            <select name="subject" id="subject_id" class="form-control select2" data-toggle = "select2" required>
              <option value=""><?php echo get_phrase('select_subject'); ?></option>
              <?php
              $subjects = $this->db->get_where('subjects', array('school_id' => school_id(), 'teacher_id' => $teacher_id))->result_array();
              foreach($subjects as $subject){
                  $class_details = $this->crud_model->get_class_details_by_id($subject['class_id'])->row_array();
                  $section_details = $this->crud_model->get_section_details_by_id('section', $subject['section_id'])->row_array();
              ?>
                  <option value="<?php echo $subject['id']; ?>">(<?php echo $class_details['name']; ?> - <?php echo $section_details['name']; ?>)  <?php echo $subject['name']; ?></option>
              <?php } ?>
          </select>
        </div>
    </div>


    <div class="form-group row">
        <div class="col-md-12">
            <label  for="month_on_taking_attendance"><?php echo get_phrase('month'); ?></label>
            <select name="month" id="month_on_taking_attendance" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_a_month'); ?></option>
                <option value="Jan"<?php if(date('M') == 'Jan') echo 'selected'; ?>><?php echo get_phrase('january'); ?></option>
                <option value="Feb"<?php if(date('M') == 'Feb') echo 'selected'; ?>><?php echo get_phrase('february'); ?></option>
                <option value="Mar"<?php if(date('M') == 'Mar') echo 'selected'; ?>><?php echo get_phrase('march'); ?></option>
                <option value="Apr"<?php if(date('M') == 'Apr') echo 'selected'; ?>><?php echo get_phrase('april'); ?></option>
                <option value="May"<?php if(date('M') == 'May') echo 'selected'; ?>><?php echo get_phrase('may'); ?></option>
                <option value="Jun"<?php if(date('M') == 'Jun') echo 'selected'; ?>><?php echo get_phrase('june'); ?></option>
                <option value="Jul"<?php if(date('M') == 'Jul') echo 'selected'; ?>><?php echo get_phrase('july'); ?></option>
                <option value="Aug"<?php if(date('M') == 'Aug') echo 'selected'; ?>><?php echo get_phrase('august'); ?></option>
                <option value="Sep"<?php if(date('M') == 'Sep') echo 'selected'; ?>><?php echo get_phrase('september'); ?></option>
                <option value="Oct"<?php if(date('M') == 'Oct') echo 'selected'; ?>><?php echo get_phrase('october'); ?></option>
                <option value="Nov"<?php if(date('M') == 'Nov') echo 'selected'; ?>><?php echo get_phrase('november'); ?></option>
                <option value="Dec"<?php if(date('M') == 'Dec') echo 'selected'; ?>><?php echo get_phrase('december'); ?></option>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12" id = "section_content_2">
            <label for="year_on_taking_attendance"><?php echo get_phrase('year'); ?></label>
            <select name="year" id="year_on_taking_attendance" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_a_year'); ?></option>
                <?php for($year = 2015; $year <= date('Y'); $year++){ ?>
                    <option value="<?php echo $year; ?>"<?php if(date('Y') == $year) echo 'selected'; ?>><?php echo $year; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <br>
    <div class="form-group row">
        <div class="col-md-12">
            <input type="radio" id="konfirmasi" name="confirm" value="Konfirmasi" checked>
            <label><?= get_phrase('konfirmasi'); ?></label><br>

            <input type="radio" id="tidak_konfirmasi" name="confirm" value="Tidak Konfirmasi">
            <label><?= get_phrase('tidak_konfirmasi'); ?></label>
        </div>
    </div>

   
    <div class="form-group col-md-12 mt-4">
        <button class="btn w-100 btn-primary" type="submit"><?php echo get_phrase('save'); ?></button>
    </div>

</form>
<script>
    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit2(e, form, getDailtyAttendanceRoutine);
    });

    $('document').ready(function(){
        initSelect2(['#class_id_on_taking_attendance','#subject_id_on_taking_attendance', '#room_id_on_taking_attendance','#section_id_on_taking_attendance', '#year_on_taking_attendance', '#month_on_taking_attendance']);

    });

    $(function(){
        $('.select2').select2();
    });

    if($('select').hasClass('select2') == true){
        $('div').attr('tabindex', "");
        $(function(){$(".select2").select2()});
    }
</script>
