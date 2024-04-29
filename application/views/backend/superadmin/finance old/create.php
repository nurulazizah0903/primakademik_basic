<form method="POST" class="d-block ajaxForm" action="<?php echo route('finance2/create'); ?>" enctype="multipart/form-data">
    <div class="form-row">
        <?php $school_id = school_id(); ?>
        
        <div class="form-group col-md-12">
            <label for="class_id_on_create"><?php echo get_phrase('class'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="class_id_on_create" name="class_id" onchange="classWiseStudentOnCreate(this.value)" required>
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                <?php $classes = $this->db->get_where('classes', array('school_id' => $school_id))->result_array(); ?>
                <?php foreach($classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div> 
		<div class="form-group col-md-12">
            <label for="student_id_on_create"><?php echo get_phrase('student'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="student_id_on_create" name="student_id" requied>
                <option><?php echo get_phrase('select_a_student'); ?></option>
            </select>
        </div>
		
		<?PHP /*  
        <div class="form-group col-md-12">
            <label for="section_id_on_create"><?php echo get_phrase('section'); ?></label>
            <select class="form-control select2" data-toggle = "select2" id="section_id_on_create" name="section_id" required onchange="classWiseStudentOnCreate(this.value)">
                <option value=""><?php echo get_phrase('select_a_section'); ?></option>
            </select>
        </div>
		*/?>

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
		

        </div>
        <div class="form-group col-md-12 mt-2">
            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('simpan_pembayaran'); ?></button>
        </div>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    // var imgVal = $('#finances_file').val(); 
    //     if(imgVal=='') 
    //     { 
    //         alert("Bukti tidak ada, Kirim bukti terlebih dahulu"); 
    //         return false; 
    //     } 
    var form = $(this);
    ajaxSubmit(e, form, showAllFinances);
});

$('document').ready(function(){
    initSelect2(['#class_id_on_create', '#payment_type_id_on_create', '#section_id_on_create', '#student_id_on_create']);
});

// function classWiseSectionOnCreate(classId) {
    // $.ajax({
        // url: "<?php echo route('section/list/'); ?>"+classId,
        // success: function(response){
            // $('#section_id_on_create').html(response);
            // classWiseStudentOnCreate(sectionId);
        // }
    // });
// }
function classWiseStudentOnCreate(classId) {
  $.ajax({
    url: "<?php echo route('finance2/student/'); ?>"+classId,
    success: function(response){
      $('#student_id_on_create').html(response);
    }
  }); 
} 

function show(payment_type_id) {
  $.ajax({
    url: "<?php echo route('finance2/invoice/'); ?>"+payment_type_id,
    success: function(response){
      $('#payment_type_id_on_create').html(response);
    }
  }); 
} 

function show2(invoice_id){
	if(invoice_id==''){		 
		$('#total_amount').val("");   
	}	
	else{ 
        $.ajax({
          type: 'POST', // Metode pengiriman data menggunakan POST
          url: "<?php echo route('finance2/total/'); ?>"+invoice_id,
		  dataType : 'json',
          success: function(res) { // Jika berhasil
              $('#total').val(res.total_amount);  
            }
	});}
   // });
}

// function classWiseStudentOnCreate(sectionId) {
  // $.ajax({
    // url: "<?php echo route('finance/student/'); ?>"+sectionId,
    // success: function(response){
      // $('#student_id_on_create').html(response);
    // }
  // });
// }

  initCustomFileUploader();
</script>