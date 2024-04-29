<form method="POST" class="d-block ajaxForm" action="<?php echo route('finance/create'); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <?php $school_id = school_id(); ?>
        <?php 
        $student_lists = $this->user_model->get_student_list_of_logged_in_parent();
        //var_dump($student_lists);
        //die;
        ?>

        <div class="form-group col-md-12">
            <label for="student_id_on_create"><?php echo get_phrase('student'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="student_id_on_create" name="student_id" required>
						<option value=""><?php echo get_phrase('select_a_student'); ?></option>
						<?php foreach ($student_lists as $student_list): ?>
							<option value="<?php echo $student_list['id']; ?>"><?php echo $student_list['name']; ?></option>
						<?php endforeach; ?>
					</select>
        </div>

        <div class="form-group col-md-12">
            <label for="payment_type_id_on_create"><?php echo get_phrase('payment'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="payment_type_id_on_create" name="payment_type_id" required>
                <option value=""><?php echo get_phrase('select_a_payment'); ?></option>
                <?php $payment_types = $this->db->get_where('payment_types', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($payment_types as $payment_type): ?>
                    <option value="<?php echo $payment_type['id']; ?>"><?php echo $payment_type['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="total"><?php echo get_phrase('total'); ?></label>
            <input type="number" class="form-control" id="total" name = "total" required>
        </div>

        <div class="form-group col-md-12">
            <label for="finances_file"><?php echo get_phrase('upload_bukti'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="finances_file" name = "finances_file" required>
            </div>
        </div>
        </div>
        <div class="form-group col-md-12 mt-2">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('simpan_pembayaran'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var imgVal = $('#finances_file').val(); 
        if(imgVal=='') 
        { 
            alert("Bukti tidak ada, Kirim bukti terlebih dahulu"); 
            return false; 
        } 
    var form = $(this);
    ajaxSubmit(e, form, getFilteredClassFinance);
});

$('document').ready(function(){
    initSelect2(['#student_id_on_create',
                '#payment_type_id_on_create']);
});
</script>


<script type="text/javascript">
  initCustomFileUploader();
</script>