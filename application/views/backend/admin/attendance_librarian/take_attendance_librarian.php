<?php $school_id = school_id(); ?>
<form method="POST" class="d-block ajaxForm responsive_media_query" action="<?php echo route('attendance_librarian/take_attendance_librarian'); ?>" style="min-width: 300px; max-width: 400px;">
    <div class="form-group row">
        <div class="col-md-12">
            <label for="date_on_taking_attendance"><?php echo get_phrase('date'); ?></label>
            <input type="text" class="form-control date" id="date_on_taking_attendance" data-toggle="date-picker" data-single-date-picker="true" name = "date" value="" required>
        </div>
    </div>

    <div class="row" id = "student_content" style="margin-left: 2px;">
    </div>

    <div class='row'>
        <div class="form-group col-md-12" id="showStudentDiv">
            <a class="btn btn-block btn-secondary" onclick="getStudentList()" style="color: #fff;" disabled><?php echo get_phrase('show_teacher_list'); ?></a>
        </div>
    </div>
    <div class="form-group col-md-12 mt-4" id = "updateAttendanceDiv" style="display: none;">
        <button class="btn w-100 btn-primary" type="submit"><?php echo get_phrase('update_attendance'); ?></button>
    </div>
</form>

<script>
    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, getDailtyAttendanceLibrarian);
    });

    $('document').ready(function(){
        // initSelect2(['#class_id_on_taking_attendance', '#section_id_on_taking_attendance']);

        $('#date_on_taking_attendance').change(function(){
            $('#showStudentDiv').show();
            $('#updateAttendanceDiv').hide();
            $('#student_content').hide();
        });
        // $('#class_id_on_taking_attendance').change(function(){
        //     $('#showStudentDiv').show();
        //     $('#updateAttendanceDiv').hide();
        //     $('#student_content').hide();
        // });
        // $('#section_id_on_taking_attendance').change(function(){
        //     $('#showStudentDiv').show();
        //     $('#updateAttendanceDiv').hide();
        //     $('#student_content').hide();
        // });
    });

    $('#date_on_taking_attendance').daterangepicker();

    // function classWiseSectionOnTakingAttendance(classId) {
    //     $.ajax({
    //         url: "<?php echo route('section/list/'); ?>"+classId,
    //         success: function(response){
    //             $('#section_id_on_taking_attendance').html(response);
    //         }
    //     });
    // }

    function getStudentList() {
        var date = $('#date_on_taking_attendance').val();

        if(date != ''){
            $.ajax({
                type : 'POST',
                url : '<?php echo route('attendance_librarian/librarian/'); ?>',
                data: {date : date},
                success : function(response) {
                    $('#student_content').show();
                    $('#student_content').html(response);
                    $('#showStudentDiv').hide();
                    $('#updateAttendanceDiv').show();
                }
            });
        }else{
            toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
        }
    }
</script>
