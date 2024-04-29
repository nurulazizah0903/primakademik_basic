<form method="POST" class="d-block ajaxForm" action="<?php echo route('session_manager/create'); ?>">
    <div class="form-row">
        <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
        <div class="form-group col-md-12">
            <label for="name"><?php echo get_phrase('session_title'); ?></label>
            <select name="session_title" id="name" class="form-control select2" data-toggle = "select2" required>
                <option value=""><?php echo get_phrase('select_session'); ?></option>
                <?php $years = $this->db->get_where('years')->result_array(); ?>
                <?php foreach($years as $year){ ?>
                    <option value="<?=$year['name']; ?>/<?php echo $year['name']+1; ?> <?php echo get_phrase('ganjil'); ?>"><?=$year['name']; ?>/<?php echo $year['name']+1; ?> <?php echo get_phrase('ganjil'); ?></option>
                    <option value="<?=$year['name']; ?>/<?php echo $year['name']+1; ?> <?php echo get_phrase('genap'); ?>"><?=$year['name']; ?>/<?php echo $year['name']+1; ?> <?php echo get_phrase('genap'); ?></option>
                <?php } ?>
            </select> 
            <!-- <input type="text" class="form-control" id="name" name = "session_title" required> -->
            <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_session_title'); ?></small>
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
</script>
