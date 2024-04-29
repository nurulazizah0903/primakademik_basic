<?php $finances = $this->db->get_where('invoices', array('id' => $param1))->result_array(); 
// var_dump($finances[0]['id']);
?>
<?php foreach($finances as $finance){ ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('finance2/upload/'.$param1); ?>" enctype="multipart/form-data">
    

    <div class="form-row">
        <div class=" form-group col-md-12">
            <div class="row">
                <div class="col-lg-6 ">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('Nama'); ?> </h5>
                    <input type="text" id="nomor_un" name="nomor_un" class="form-control" placeholder="<?php echo get_phrase('nomor_un'); ?>" style="color:Black; font-weight: bold;" value="INPUT" readonly> 
                </div> <!-- end col-->

                <div class="col-lg-6 ">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('kelas'); ?> </h5>
                    <input type="input" id="nisn" name="nisn" class="form-control" placeholder="nisn" style="color:Black; font-weight: bold;" value="INPUT" readonly> 
                </div> <!-- end col-->
            </div> <!-- end row --> 
        </div>

        <div class=" form-group col-md-12">
            <div class="row">
                <div class="col-lg-9">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('address'); ?> </h5>
                    <input type="text" id="nomor_un" name="nomor_un" class="form-control" placeholder="<?php echo get_phrase('nomor_un'); ?>" style="color:Black; font-weight: bold;" value="INPUT" readonly>
                </div> <!-- end col-->

                <div class="col-lg-3">
                    <h5 style="font-weight: bold;"> <?php echo get_phrase('postcode'); ?> </h5>
                    <input type="number" id="nisn" name="nisn" class="form-control" placeholder="nisn" style="color:Black; font-weight: bold;" value="30000" readonly> 
                </div> <!-- end col-->
            </div> <!-- end row --><br>
        </div>

        <div class=" form-group col-md-12">
            <div class="row">
                <div class="col-lg-3">
                    <label for="finances_file"><?php echo get_phrase('upload_bukti'); ?><font style="color:red;">*</font></label> </div> <!-- end col-->
                <div class="custom-file-upload col-lg-9">
                <input type="number" id="nisn" name="nisn" class="form-control" placeholder="nisn" required> 
                </div> <!-- end col-->
            </div> <!-- end row --><br>
        </div>

        <div class=" form-group col-md-12">
            <div class="row">
                <div class="col-lg-3">
                    <label for="finances_file"><?php echo get_phrase('upload_bukti'); ?><font style="color:red;">*</font></label> </div> <!-- end col-->
                <div class="custom-file-upload col-lg-9">
                    <input type="file" class="form-control" id="finances_file" name = "finances_file" required>
                </div> <!-- end col-->
            </div> <!-- end row --><br>
        </div>

        <!--div class="form-group col-md-12">
            <label for="finances_file"><?php echo get_phrase('upload_bukti'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="finances_file" name = "finances_file" required>
            </div>
        </div-->

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
    ajaxSubmit(e, form, showAllFinances);
});

initCustomFileUploader();
</script>