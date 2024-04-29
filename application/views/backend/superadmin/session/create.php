<?php

if (isset($period)) {

	$inputStartValue = $period['year_one'];
	$inputEndValue = $period['year_two'];
} else {
	$inputStartValue = set_value('year_one');
	$inputEndValue = set_value('year_two');
}
?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('session_manager/create'); ?>">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('session_title'); ?></label>
            <input type="text" name="year_one" class="form-control years" onchange="getYear(this.value)" placeholder="Tahun Awal">
            <br>
            <input type="text" class="form-control" readonly="" name="year_two" id="YearEnd" value="<?php echo $inputEndValue ?>" placeholder="Tahun Akhir">
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_session_title'); ?></small>
        </div>
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('semester'); ?></label>
            <select name="semester" id="name" class="form-control select2" data-toggle = "select2" required>
                <option value="Genap" selected><?php echo get_phrase('genap'); ?></option>
                <option value="Ganjil"><?php echo get_phrase('ganjil'); ?></option>
            </select> 
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_session'); ?></button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        initSelect2(['#name']);
    })

    $(function(){
        $('.select2').select2();
    });

    if($('select').hasClass('select2') == true){
        $('div').attr('tabindex', "");
        $(function(){$(".select2").select2()});
    }

    $(".ajaxForm").validate({}); // Jquery form validation initialization
    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit(e, form, showAllSessions);
    });

    function getYear(value) {
    var yearsend = parseInt(value) + 1;
    $("#YearEnd").val(yearsend);
    }

    $('.years').datepicker({
         minViewMode: 2,
         format: 'yyyy'
       });
</script>