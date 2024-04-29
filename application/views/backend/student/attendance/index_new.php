<?php
  $school_title = get_settings('system_title');
  $theme        = get_frontend_settings('theme');
  $active_school_id = $this->frontend_model->get_active_school_id();
  $profile_data = $this->user_model->get_profile_data();
?>
<html lang="en">

<head>
    <!-- all the meta tags -->
    <?php include 'metas.php'; ?>
    <!-- all the css files -->
    <?php include 'includes_top.php'; ?>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/calender/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/style.css">
    <link rel="shortcut icon" href="<?php echo $this->settings_model->get_favicon(); ?>">
    <title><?php echo get_phrase($page_title); ?> | <?= get_frontend_settings('website_title'); ?></title>

</head>

<body class="bg-imgs-2 min-vh-100">

    <!-- Nav Layout -->
    <div class="container-fluid">
        <div class="row d-flex flex-lg-row flex-column-reverse">
            <div class="col">
                <div class="cards-profiles px-4 shadow-sm">
                    <img class="profile-user-size" draggable="false" src="<?php echo $this->user_model->get_user_image($this->session->userdata('user_id')); ?>" alt="">
                    <div class="d-block flex-wrap pt-2 px-lg-4 px-2 mx-2 mx-lg-0 text-wrap">
					<h1 class="font-size-sm-2 fs-xs-1 font-size-3 mb-0"><?php echo $profile_data['name']; ?></h1>
                        <h1 class="font-size-sm-2 fs-xs-2 font-size-5 mt-2"><?php echo $profile_data['email']; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col">
                <div
                    class="d-flex my-3 my-lg-1 ms-lg-0 ms-3 flex-row align-items-start justify-content-lg-center justify-content-start">
                    <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/checklistIcon.svg" class="mt-lg-2 logo-checks-resp" draggable="false" alt="">
                    <h1 class="ms-3 font-poppins font-size-sm-6 text-start">Event <br>Kalender</h1>
                </div>
            </div>
            <div class="col d-lg-flex align-items-center d-none">
                <div class="position-absolute right-0">
                    <img draggable="false" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/logo_tut.png" class="logo-tut-resp" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- End:Nav Layout -->
    
<?php $student_data = $this->user_model->get_logged_in_student_details(); ?>
<!--title-->
<div class="row d-print-none">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title"><i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('daily_attendance'); ?></h4>
        <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/attendance/confirm_all'); ?>', '<?php echo get_phrase('attendance_confirm'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('attendance_confirm'); ?></button>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row mt-3 d-print-none">
                <div class="col-md-1 mb-1"></div>
                <div class="col-md-4 mb-1">
                    <select name="month" id="month" class="form-control select2" data-toggle="select2" required>
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
                <div class="col-md-4 mb-1">
                    <select name="year" id="year" class="form-control select2" data-toggle="select2" required>
                        <option value=""><?php echo get_phrase('select_a_year'); ?></option>
                        <?php for($year = 2015; $year <= date('Y'); $year++){ ?>
                            <option value="<?php echo $year; ?>"<?php if(date('Y') == $year) echo 'selected'; ?>><?php echo $year; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_attendance()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="card-body attendance_content">
                <div class="empty_box">
                    <img class="mb-3" width="150px" src="<?php echo base_url('assets/backend/images/empty_box.png'); ?>" />
                    <br>
                    <span class=""><?php echo get_phrase('no_data_found'); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="container-fluid px-0 fixed-lg-bottom">
        <div class="position-relative d-flex align-items-center foo-height bg-gradie">
            <img class="mb-5 mt-n5" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/icon_footer.png" draggable="false" width="100" alt="">
            <a href = "javascript:history.back()" style="text-decoration:none;">
            <button class="btn bg-7 text-white position-absolute right-0 shadow-none">
                <!-- onclick="location.href='siswaMainPage.html'"> -->
					<?php echo get_phrase('back'); ?>
            </button></a>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/calender/js/script.js"></script>

    <!-- all the js files -->
    <?php include 'includes_bottom.php'; ?>
    <?php include 'notify.php'; ?>
    <?php include 'modal.php'; ?>
</body>

</html>

<script>
$('document').ready(function(){
    initSelect2(['#month', '#year', '#class_id', '#section_id']);
});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}

function filter_attendance(){
    var month = $('#month').val();
    var year = $('#year').val();
    var class_id = <?php echo $student_data['class_id']; ?>;
    var section_id = <?php echo $student_data['section_id']; ?>;
    if(class_id != "" && section_id != "" && month != "" && year != ""){
        getDailtyAttendance();
    }else{
        toastr.error('<?php echo get_phrase('please_select_in_all_fields !'); ?>');
    }
}

var getDailtyAttendance = function () {
    var month = $('#month').val();
    var year = $('#year').val();
    var class_id = <?php echo $student_data['class_id']; ?>;
    var section_id = <?php echo $student_data['section_id']; ?>;
    if(class_id != "" && section_id != "" && month != "" && year != ""){
        $.ajax({
            type: 'POST',
            url: '<?php echo route('attendance/filter') ?>',
            data: {month : month, year : year, class_id : class_id, section_id : section_id},
            success: function(response){
                $('.attendance_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
}
</script>