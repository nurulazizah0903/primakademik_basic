<form method="POST" class="d-block ajaxForm" action="<?php echo route('finance/create'); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <?php $school_id = school_id(); 
        $student_data = $this->user_model->get_logged_in_student_details(); 
        // var_dump($student_data['name']);
        ?>

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
            <label class="col-md-3 col-form-label" for="total"><?php echo get_phrase('total'); ?></label>
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
    ajaxSubmit(e, form, showAllFinances);
});

$('document').ready(function(){
    initSelect2(['#class_id_on_create',
                '#payment_type_id_on_create',
                '#section_id_on_create',
                '#student_id_on_create']);
});

function classWiseSectionOnCreate(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_on_create').html(response);
            classWiseStudentOnCreate(classId);
        }
    });
}

function classWiseStudentOnCreate(classId) {
  $.ajax({
    url: "<?php echo route('invoice/student/'); ?>"+classId,
    success: function(response){
      $('#student_id_on_create').html(response);
    }
  });
}
</script>


<script type="text/javascript">
  initCustomFileUploader();
</script>