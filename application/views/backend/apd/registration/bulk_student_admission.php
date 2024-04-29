<?php $school_id = school_id(); ?>
<div class="bulk_student">
    <form method="POST" class="col-md-12 ajaxForm" action="<?php echo route('registration/ppdb_enroll_bulk_student'); ?>" id = "student_admission_form">
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
                <select name="section_id" id="section_id" class="form-control select2" data-toggle = "select2" required onchange="sectionWiseClassroomsOnCreate(this.value)">
                    <option value=""><?php echo get_phrase('select_section'); ?></option>
                </select>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
                <select name="room_id" id="room_id" class="form-control select2" data-toggle = "select2" required>
                    <option value=""><?php echo get_phrase('select_class_room'); ?></option>
                </select>
            </div>
        </div>
        <br>

        <div id = "first-row">
            <div class="row">
                <div class="col-xl-11 col-lg-11 col-md-12 col-sm-12 mb-3 mb-lg-0">
                    <div class="row justify-content-md-center">
                        <div class="form-group col-xl-3 col-lg-3 col-md-12 col-sm-12 mb-1 mb-lg-0">
                            <select name="id[]" class="form-control select2 kode_registrasi" onchange="grabPpdb(this.value, this)" required>
                                <option value=""><?php echo get_phrase('pilih_kode_registrasi'); ?></option>
                                <?php $ppdb = $this->db->where('status', 'Accepted')->or_where('status', 'Installment Accepted')->where('school_id', $school_id)->get('registrations')->result_array(); ?>
                                <?php foreach($ppdb as $item){ ?>
                                    <option value="<?php echo $item['id']; ?>"><?php echo $item['kode_registrasi']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-xl-3 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                            <input readonly type="text" name="nama_lengkap[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nama_lengkap'); ?>" required>
                        </div>
                        <div class="form-group col-xl-3 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                            <input readonly type="text" name="nik[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nik'); ?>" required>
                        </div>
                        <div class="form-group col-xl-3 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                            <input readonly type="text" name="nama_orang_tua[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nama_orang_tua'); ?>" required>
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
                        <select name="id[]" class="form-control select2 kode_registrasi" onchange="grabPpdb(this.value, this)" required>
                            <option value=""><?php echo get_phrase('pilih_kode_registrasi'); ?></option>
                            <?php $ppdb = $this->db->where('status', 'Accepted')->or_where('status', 'Installment Accepted')->where('school_id', $school_id)->get('registrations')->result_array(); ?>
                            <?php foreach($ppdb as $item){ ?>
                                <option value="<?php echo $item['id']; ?>"><?php echo $item['kode_registrasi']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-xl-3 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input readonly type="text" name="nama_lengkap[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nama_lengkap'); ?>" required>
                    </div>
                    <div class="form-group col-xl-3 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input readonly type="text" name="nik[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nik'); ?>" required>
                    </div>
                    <div class="form-group col-xl-3 col-lg-2 col-md-12 col-sm-12 mb-1 mb-lg-0">
                        <input readonly type="text" name="nama_orang_tua[]" class="form-control"  value="" placeholder="<?php echo get_phrase('nama_orang_tua'); ?>" required>
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

<script>
    function sectionWiseClassroomsOnCreate(sectionId) {
        $.ajax({
            url: "<?php echo route('class_room/dropdown/'); ?>"+sectionId,
            success: function(response){
            $('#room_id').html(response);
            }
        });
        }

    var blank_field = $('#blank-row').html();
    var row = 1;

    function grabPpdb(id, e) {
        // console.log($(e).parent().siblings().find('input[name="nama[]"]'));
        var inputNama = $(e).parent().siblings().find('input[name="nama_lengkap[]"]');
        var inputEmail = $(e).parent().siblings().find('input[name="nik[]"]');
        var inputNisn = $(e).parent().siblings().find('input[name="nama_orang_tua[]"]');

        $.ajax({
            url: "<?php echo route('registration/list/'); ?>"+id,
            success: function(response){

                var data = JSON.parse(response);
                console.log(data);
                
                inputNama.val(data.nama_lengkap);
                inputEmail.val(data.nik);
                inputNisn.val(data.nama_orang_tua);
            }
        });
    }

    function appendRow() {
        $('#first-row').append(blank_field);
        row++;

        $('.kode_registrasi').attr('id', 'kode_registrasi'+row);
        $('#kode_registrasi' + row, '.student-row').select2();
    }

    function removeRow(elem) {
        $(elem).closest('.student-row').remove();
        row--;
    }

    $(document).ready(function() {
        $('.select2').select2();
    });
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

</script>
