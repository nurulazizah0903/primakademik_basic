<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('export_data'); ?>
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<!-- end page title -->

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
        <div class="row mt-3">
            <div class="col-md-4"></div>
                <div class="col-md-3 mb-1">
                    <select name="data_choosen" id="data_choosen" class="form-control select2" data-toggle = "select2">
                        <option value=""><?php echo get_phrase('select_data'); ?></option>
                        <option value="pegawai"><?php echo get_phrase('employee'); ?></option>
                        <option value="siswa"><?php echo get_phrase('student'); ?></option>
                        <option value="jurusan"><?php echo get_phrase('class'); ?></option>
                        <option value="matapelajaran"><?php echo get_phrase('subject'); ?></option>
                        <option value="jadwalkelas"><?php echo get_phrase('class_routine'); ?></option>
                        <option value="tahun"><?php echo get_phrase('year'); ?></option>
                        <option value="buku"><?php echo get_phrase('book'); ?></option>
                        <option value="ektrakurikuler"><?php echo get_phrase('extracurricular'); ?></option>
                        <!-- <option value="departemen"><?php echo get_phrase('department'); ?></option>
                        <option value="pelanggaran"><?php echo get_phrase('mistakes'); ?></option>
                        <option value="lokasi"><?php echo get_phrase('location'); ?></option>
                        <option value="eskul"><?php echo get_phrase('organization'); ?></option>
                        <option value="jenistugas"><?php echo get_phrase('assignment_types'); ?></option>
                        <option value="jenisujian"><?php echo get_phrase('exam_types'); ?></option>
                        <option value="ruangkelas"><?php echo get_phrase('class_rooms'); ?></option> -->
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-secondary" onclick="filter_data()" ><?php echo get_phrase('filter'); ?></button>
                </div>
            </div>
            <div class="card-body">
                <div class = "export_data_content">
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script>
function filter_data(){
    var data_choosen = $('#data_choosen').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('export_data/filter/') ?>',
        data: {data_choosen : data_choosen},
        success: function(response){
            $('.export_data_content').html(response);
        }
    });
}

var showAllEmployee = function () {
    var url = '<?php echo route('export_data/list'); ?>';

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            $('.export_data_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}

$(document).ready(function() {
    $('.select2').select2();
});
</script>
