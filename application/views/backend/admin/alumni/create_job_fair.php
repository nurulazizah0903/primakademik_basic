<?php
    $school_id = school_id();
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo site_url('addons/alumni/create_job_fair'); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <input type="hidden" name="school_id" value = "<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('alumni_name'); ?></label>
            <select class="form-control select2" name="alumni_id" id="alumni_id" required>
                <option value=""><?php echo get_phrase('select_alumni_name'); ?></option>>
                <?php $alumnis = $this->db->get_where('alumni', array('school_id' => $school_id))->result_array();
                    foreach($alumnis as $alumni){ ?>
                    <option value="<?php echo $alumni['id']; ?>"><?php echo $alumni['name']; ?></option>
                <?php } ?>
            </select>
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_alumni_name'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="profession"><?php echo get_phrase('profession'); ?></label>
            <select class="form-control select2" name="profession" id="profession" required>
                <option value="">Pilih Profesi</option>
                <option value="Kuliah">Kuliah</option>
                <option value="Bekerja">Bekerja</option>
                <option value="Tidak Bekerja">Tidak Bekerja</option>
            </select>
            <small id="profession_help" class="form-text text-muted"><?php echo get_phrase('provide_profession'); ?></small>
        </div>

        <div class="form-group col-md-12" id="company">
            <label for="company"><?php echo get_phrase('company'); ?></label>
            <input type="text" class="form-control" id="company" name = "company">
            <small id="company_help" class="form-text text-muted"><?php echo get_phrase('provide_company'); ?></small>
        </div>

        <div class="form-group col-md-12" id="university">
            <label for="university"><?php echo get_phrase('university'); ?></label>
            <input type="text" class="form-control" id="university" name = "university">
            <small id="university_help" class="form-text text-muted"><?php echo get_phrase('provide_university'); ?></small>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_job_fair'); ?></button>
        </div>
    </div>
</form>
<script>

$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit(e, form, showAllAlumni);
});    

$('div[id=university]').css({"display": "none"});
$('div[id=company]').css({"display": "none"});

$('#profession').change(function() {
	var value_selected = $('#profession :selected').val();
    if(value_selected == 'Kuliah'){
        $('div[id=university]').css({"display": "inline-block"});
		$('div[id=company]').css({"display": "none"});
    } else if(value_selected == 'Bekerja'){
        $('div[id=company]').css({"display": "inline-block"});
		$('div[id=university]').css({"display": "none"});
    } else {
        $('div[id=university]').css({"display": "none"});
        $('div[id=company]').css({"display": "none"});        
    }
});    

$(document).ready(function() {
    $('.select2').select2();
});

$(document).ready(function () {
    initSelect2(['#alumni_id']);
    initSelect2(['#profession']);
});

if($('div').hasClass('modal-dialog') == true){
    $('div').attr('tabindex', "");
}
</script>