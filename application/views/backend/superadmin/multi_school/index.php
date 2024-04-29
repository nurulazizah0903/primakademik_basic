<!--title-->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
            <i class="mdi mdi-book-open-page-variant title_icon"></i> <?php echo get_phrase('manage_schools'); ?>
            <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="showAjaxModal('<?php echo site_url('modal/popup/multi_school/create'); ?>', '<?php echo get_phrase('create_school'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_school'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body school_content">
                <?php include 'list.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php /* <div class="card">
    <div class="card-body">
        <form method="POST" class="col-md-12 excelForm mb-3" action="<?php echo route('upload_excel'); ?>" id = "student_admission_form" enctype="multipart/form-data">
            <div class="row">
                <h5 class="mt-2 col-md-12">
                Upload data csv <?= !empty($activeSchool['name']) ? $activeSchool['name'] : '' ?> <span class="text-danger">(<?php echo get_phrase('harus_sesuai_urutan'); ?>)</span></label>
                </h5>
            </div>
            <div class="row">
                <div class="col-md-4" id = "section_content">
                    <select name="mode" id="mode" class="form-control select2" data-toggle = "select2" required >
                        <option value=""><?php echo get_phrase('select_data'); ?></option>
                        <option value="kelas">1. <?php echo get_phrase('class'); ?></option>
                        <option value="ruangkelas">2. <?php echo get_phrase('class_rooms'); ?></option>
                        <option value="siswa">3. <?php echo get_phrase('student'); ?></option>
                        <option value="departemen">4. <?php echo get_phrase('department'); ?></option>
                        <option value="guru">5. <?php echo get_phrase('teacher'); ?></option>
                        <option value="matapelajaran">6. <?php echo get_phrase('subject'); ?></option>
                        <option value="jadualkelas">7. <?php echo get_phrase('class_routine'); ?></option>
                    </select>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        <div class="custom-file-upload">
                            <input type="file" id="csv_file" class="form-control" name="csv_file" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <a href="<?php echo base_url('assets/csv_file/format_xlsx.zip'); ?>" class="btn btn-success col-md-4 col-sm-12 mb-4 mt-3" download><?php echo get_phrase('generate_csv_file'); ?><i class="mdi mdi-download"></i></a>
                <button type="submit" class="btn btn-secondary col-md-4 col-sm-12 mb-4 mt-3"><?php echo get_phrase('add_data'); ?></button>
            </div>
            <?php echo get_phrase('Setelah_klik_tombol'); ?>
        </form>
    </div>
</div> */ ?>
<script>
    var form;
    $(".excelForm").submit(function(e) {
    form = $(this);
        ajaxSubmit(e, form, refreshForm);
    });
    var refreshForm = function () {
        form.trigger("reset");
    }

    var showAllSchools = function () {
        var url = '<?php echo site_url('addons/multischool/list'); ?>';

        $.ajax({
            type : 'GET',
            url: url,
            success : function(response) {
                $('.school_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
    var redirectToDashboard = function () {
        var url = '<?php echo route('dashboard'); ?>';
        window.location.replace(url);
    }
</script>
