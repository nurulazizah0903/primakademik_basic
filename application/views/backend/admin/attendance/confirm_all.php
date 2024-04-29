<?php 
$school_id = school_id(); 
?>
<form method="POST" class="d-block ajaxForm responsive_media_query" action="<?php echo route('attendance/confirm_all_student'); ?>" style="min-width: 300px; max-width: 400px;">
    <div class="form-group row">
        <div class="col-md-12">
            <label  for="class_id_on_taking_attendance"><?php echo get_phrase('class'); ?></label>
            <select name="class_id" id="class_id_on_taking_attendance" class="form-control select2" data-toggle="select2" onchange="classWiseSectionOnTakingAttendance(this.value)" required>
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12" id = "section_content_2">
            <label for="section_id_on_taking_attendance"><?php echo get_phrase('section'); ?></label>
            <select name="section_id" id="section_id_on_taking_attendance" class="form-control select2" data-toggle="select2" required onchange="sectionWiseClassroomsOnCreate(this.value)">
                <option value=""><?php echo get_phrase('select_section'); ?></option>
            </select>
        </div>
    </div>    

    <div class="form-group row">
        <div class="col-md-12">
            <label  for="room_id_on_taking_attendance"><?php echo get_phrase('class_rooms'); ?></label>
            <select name="room_id" id="room_id_on_taking_attendance" class="form-control select2" data-toggle="select2" required>
                <option value=""><?php echo get_phrase('select_class_room'); ?></option>
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
        ajaxSubmit2(e, form, getDailtyAttendance);
    });

    $('document').ready(function(){
        initSelect2(['#class_id_on_taking_attendance', '#room_id_on_taking_attendance', '#section_id_on_taking_attendance', '#year_on_taking_attendance', '#month_on_taking_attendance']);

    });
    
    function classWiseSectionOnTakingAttendance(classId) {
        $.ajax({
            url: "<?php echo route('section/list/'); ?>"+classId,
            success: function(response){
                $('#section_id_on_taking_attendance').html(response);
            }
        });
    }

    $(function(){
        $('.select2').select2();
    });

    if($('select').hasClass('select2') == true){
        $('div').attr('tabindex', "");
        $(function(){$(".select2").select2()});
    }

    function sectionWiseClassroomsOnCreate(sectionId) {
    $.ajax({
        url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
        success: function(response){
        $('#room_id_on_taking_attendance').html(response);
        }
    });
    }
</script>
