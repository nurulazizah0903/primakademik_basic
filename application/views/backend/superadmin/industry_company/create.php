<?php $school_id = school_id(); ?>
<div class="row">
    <div class="col-12">
        <div class="card pt-0">
            <h4 class="text-center mx-0 py-2 mt-0 mb-3 px-0 text-white bg-primary"><?php echo get_phrase('create_industry_company'); ?></h4>
            <form method="POST" class="d-block ajaxForm" action="<?php echo route('industry_company/add'); ?>">
            <input type="hidden" name="school_id" value="<?php echo school_id(); ?>">
            <div class="col-md-12">
                <div class="form-group row mb-3">
                    <label for="company_name"><?php echo get_phrase('company_name'); ?></label>
                    <input type="text" class="form-control" id="company_name" name = "company_name" required>
                    <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_company_name'); ?></small>
                </div>

                <div class="form-group row mb-3">
                    <label for="phone_number"><?php echo get_phrase('phone_number'); ?></label>
                    <input type="text" class="form-control" id="phone_number" name = "phone_number" required>
                    <small id="name_help" class="form-text text-muted"><?php echo get_phrase('provide_phone_number'); ?></small>
                </div>

                <div class="form-group row mb-3">
                    <label for="phone"><?php echo get_phrase('address'); ?></label>
                    <textarea class="form-control" id="address" name = "address" rows="5" required></textarea>
                    <small id="" class="form-text text-muted"><?php echo get_phrase('provide_company_address'); ?></small>
                </div>

                <div class="form-group  col-md-12">
                    <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('add_industry_company'); ?></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<script>

    $(".ajaxForm").submit(function(e) {
        var form = $(this);
        ajaxSubmit2(e, form, showAllIndustry);
        location.reload();
    });

</script>