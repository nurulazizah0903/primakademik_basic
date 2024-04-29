<!--title-->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="page-title">
                        <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('student_extracurricular'); ?>
                    </h4>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card ">
                <div class="row mt-3">
                    <div class="col-md-3 mb-1"></div>
                    <div class="col-md-4 mb-1">
                        <select name="organizations_id" id="organizations_id" class="form-control select2" data-toggle="select2" required>
                            <option value=""><?php echo get_phrase('select_organizations'); ?></option>
                            <?php
                            $organizations = $this->db->get_where('organizations', array('school_id' => school_id()))->result_array();
                            foreach($organizations as $organization){
                                ?>
                                <option value="<?php echo $organization['id']; ?>"><?php echo $organization['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-block btn-secondary" onclick="filter_student()" ><?php echo get_phrase('filter'); ?></button>
                    </div>
                </div>
                <div class="card-body student_content">
                    <div class="empty_box">
                        <img class="mb-3" width="150px" src="<?php echo base_url('assets/backend/images/empty_box.png'); ?>" />
                        <br>
                        <span class=""><?php echo get_phrase('no_data_found'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
$('document').ready(function(){

});

function classWiseSection(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id').html(response);
        }
    });
}

function filter_student(){
    var organizations_id = $('#organizations_id').val();
    $.ajax({
        type : 'post',
        url: '<?php echo route('extracurricular_participants/filter/') ?>',
        data: {organizations_id : organizations_id},
        success: function(response){
            $('.student_content').html(response);
            initDataTable('basic-datatable');
        }
    });
}

var showAllStudentsextracurricular = function () {
        $.ajax({
            url: '<?php echo route('extracurricular_participants/list/') ?>',
            success: function(response){
                $('.student_content').html(response);
                initDataTable('basic-datatable');
            }
        });
}
</script>
