<?php $finances = $this->db->get_where('finances', array('id' => $param1))->result_array(); 
// var_dump($finances[0]['id']);
?>
<?php foreach($finances as $finance){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('finance/upload/'.$param1); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="finances_file"><?php echo get_phrase('upload_bukti'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="finances_file" name = "finances_file" required>
            </div>
        </div>

        <div class="form-group  col-md-12">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_finance'); ?></button>
        </div>
    </div>
</form>
<?php } ?>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var imgVal = $('#finances_file').val(); 
        if(imgVal=='') 
        { 
            alert("<?php echo get_phrase('please_select_in_all_fields !')?>"); 
            return false; 
        } 
    var form = $(this);
    ajaxSubmit2(e, form, filter_finances);
});

initCustomFileUploader();
</script>