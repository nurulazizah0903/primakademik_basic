
<?php $school_id = school_id(); ?>
<div class="row d-print-none">  
<div class="col-12">
<div class="card ">
<div class="card-body">
<div class="bulk_student">
<h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('manage_student_allocation'); ?></h4>
<form method="POST" class="col-md-12 ajaxForm" action="<?php echo route('student/student_allocation'); ?>" id = "student_admission_form">
    <div class="row justify-content-md-center">
        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <select name="class_id" id="class_id" class="form-control select2" data-toggle = "select2" onchange="classWiseSection(this.value)" required>
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($classes as $class){ ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0" id = "section_content">
            <select name="section_id" id="section_id" class="form-control select2" data-toggle = "select2" required >
                <option value=""><?php echo get_phrase('select_section'); ?></option>
            </select>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <select name="room_id" id="room_id" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_class_room'); ?></option>
                <?php $class_rooms = $this->db->get_where('class_rooms', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($class_rooms as $class_room){ ?>
                    <option value="<?php echo $class_room['id']; ?>"><?php echo $class_room['name']; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <br>

    <div id = "first-row">
        <div class="row">
            <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <div class="row justify-content-md-center">
                    <div class="form-group col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <select name="id[]" class="form-control select2" data-toggle = "select2" onchange="grabPpdb(this.value, this)" required>
                            <option value=""><?php echo get_phrase('pilih_nisn'); ?></option>
                            <?php $ppdb = $this->db->get_where('registrations', array('status' => 'Accepted'))->result_array(); ?>
                            <?php foreach($ppdb as $item){ ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo $item['nisn']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input readonly type="text" name="nama_lengkap[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nama_lengkap'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input readonly type="text" name="nama_orang_tua[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nama_orang_tua'); ?>" required>
                    </div>
                    <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input readonly type="text" name="nik[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nik'); ?>" required>
                    </div>
                </div>
            </div>
            <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <div class="row justify-content-md-center">
                    <div class="form-group col">
                        <button type="button" class="btn btn-icon btn-success" onclick="appendRow()"> <i class="mdi mdi-plus"></i> </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4 mt-2"><?php echo get_phrase('add_students'); ?></button>
    </div>
</form>

<div id = "blank-row" style="display: none;">
    <div class="row student-row">
        <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <div class="row justify-content-md-center">
                <div class="form-group col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <select name="id[]" class="form-control select2" data-toggle = "select2" onchange="grabPpdb(this.value, this)" required>
                        <option value=""><?php echo get_phrase('pilih_kode_registrasi'); ?></option>
                        <?php $ppdb = $this->db->get_where('registrations', array('status' => 'Accepted'))->result_array(); ?>
                        <?php foreach($ppdb as $item){ ?>
                            <option value="<?php echo $item['id']; ?>"><?php echo $item['nisn']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <input readonly type="text" name="nama_lengkap[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nama_lengkap'); ?>" required>
                </div>
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <input readonly type="text" name="nama_orang_tua[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nama_orang_tua'); ?>" required>
                </div>
                <div class="form-group col-xl-2 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                    <input readonly type="text" name="nik[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nik'); ?>" required>
                </div>
            </div>
        </div>
        <div class="col-xl-1 col-lg-1 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <div class="row justify-content-md-center">
                <div class="form-group col">
                    <button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script>
var blank_field = $('#blank-row').html();
var row = 1;

function grabPpdb(id, e) {
    // console.log($(e).parent().siblings().find('input[name="nama[]"]'));
    var inputNama = $(e).parent().siblings().find('input[name="nama_lengkap[]"]');
    var inputEmail = $(e).parent().siblings().find('input[name="nama_orang_tua[]"]');
    var inputNisn = $(e).parent().siblings().find('input[name="nik[]"]');

    $.ajax({
        url: "<?php echo route('registration/list/'); ?>"+id,
        success: function(response){

            var data = JSON.parse(response);
            console.log(data);
            
            inputNama.val(data.nama_lengkap);
            inputEmail.val(data.nama_orang_tua);
            inputNisn.val(data.nik);
        }
    });
}

function appendRow() {
    $('#first-row').append(blank_field);
    row++;
}

function removeRow(elem) {
    $(elem).closest('.student-row').remove();
    row--;
}
</script>

<script>
var form;
$(".ajaxForm").submit(function(e) {
    e.preventDefault();

    form = $(this);
    var url = form.attr('action');

    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data) {
            console.log(JSON.parse(data));
            triggerAlert(data);
            refreshBulkForm();
        },
    });
});
function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}
function refreshBulkForm() {
  var url = '<?php echo route('student/manage_student'); ?>';

  $.ajax({
    type : 'GET',
    url: url,
    success : function(response) {
      $('.bulk_student').html(response);
    }
  });
}
var triggerAlert = function (res) {
  var obj = JSON.parse(res);
  if(obj.status) {
    swal({
      title: "Alokasi Berhasil!",
      text: obj.notifications,
      type: "success"
    });
  } else {
    swal({
      title: "Terjadi Kesalahan",
      text: obj.notifications,
      type: "error"
    });
  }
}
</script>
