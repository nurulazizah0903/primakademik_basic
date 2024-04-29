<?php $industry = $this->db->get_where('industry_company', array('id' => $param1))->result_array(); ?>
<?php foreach($industry as $data){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('industry_company/update/'.$param1); ?>">
    <div class="form-row">
        
        <div class="form-group col-md-12">
            <label for="company_name"><?php echo get_phrase('company_name'); ?></label>
            <input type="text" class="form-control" value="<?php echo $data['company_name']; ?>" id="company_name" name = "company_name" required>
        </div>

        <div class="form-group col-md-12">
            <label for="phone_number"><?php echo get_phrase('phone_number'); ?></label>
            <input type="text" class="form-control" value="<?php echo $data['phone_number']; ?>" id="phone_number" name = "phone_number" required>
        </div>

        <div class="form-group col-md-12">
            <label for="address"><?php echo get_phrase('address'); ?></label>
            <textarea class="form-control" id="address" name = "address" rows="5" required><?php echo $data['address']; ?></textarea>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_industry_company'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
  $(".ajaxForm").validate({}); // Jquery form validation initialization
  $(".ajaxForm").submit(function(e) {
      var form = $(this);
      ajaxSubmit(e, form, showAllIndustry);
  });
</script>