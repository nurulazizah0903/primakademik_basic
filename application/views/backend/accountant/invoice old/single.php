<form method="POST" class="d-block ajaxForm" action="<?php echo route('invoice/single'); ?>" id="form1">
  <div class="form-row">

    <div class="form-group col-md-4">
      <label for="class_id_on_create"><?php echo get_phrase('class'); ?></label>
      <select name="class_id_on_create" id="class_id_on_create" class="form-control select2" data-toggle="select2"  required onchange="classWiseSectionOnCreate(this.value)">
        <option value=""><?php echo get_phrase('select_a_class'); ?></option>
        <?php $classes = $this->crud_model->get_classes()->result_array(); ?>
        <?php foreach($classes as $class): ?>
          <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="section_id_on_create"><?php echo get_phrase('section'); ?></label>
      <select class="form-control select2" data-toggle = "select2" id="section_id_on_create" name="section_id_on_create" required onchange="classWiseStudentOnCreate(this.value)">
          <option value=""><?php echo get_phrase('select_a_section'); ?></option>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="student_id_on_create"><?php echo get_phrase('student'); ?></label>
      <select class="form-control select2" data-toggle = "select2" id="student_id_on_create" name="student_id_on_create" requied>
        <option value=""><?php echo get_phrase('select_a_student'); ?></option>
      </select>
    </div>

    <?PHP /*  
    <div class="form-group col-md-12">
      <label for="student_id_on_create"><?php echo get_phrase('select_student'); ?></label>
      <div id = "student_content">
        <select name="student_id" id="student_id_on_create" class="form-control select2" data-toggle="select2" required >
          <option value=""><?php echo get_phrase('select_a_student'); ?></option>
        </select>
      </div>
    </div>
    
    <div class="form-group col-md-12">
      <label for="title"><?php echo get_phrase('invoice_title'); ?></label>
      <input type="text" class="form-control" id="title" name = "title" required>
    </div>
    */ ?>

    <div class="form-group col-md-8">
      <label><?php echo get_phrase('invoice_types'); ?></label> 
      <select name="payment_type" id="payment_type" class="form-control select2" data-toggle = "select2"  required onchange="show(this.value)">
        <option value=""><?php echo get_phrase('invoice_types'); ?></option>
        <?php $payment_types = $this->db->get_where('payment_types', array('session' => active_session()))->result_array(); ?>
            <?php foreach($payment_types as $payment_type): ?>
                <option value="<?php echo $payment_type['id']; ?>"><?php echo $payment_type['name']; ?></option>
            <?php endforeach; ?>
      </select> 
    </div> 

    <div class="form-group col-md-4">
      <label for="total_amount2"><?php echo get_phrase('nominal').' ('.currency_code_and_symbol('code').')'; ?></label>
      <input type="text" id="total_amount2" name="total_amount2" class="form-control" style="font-weight: bold;"  readonly onkeyup="jumlahkan()"/>
    </div> 
    <div class="form-group col-md-4">
      <label for="tax"><?php echo get_phrase('Pajak').' (%)'; ?></label>
      <input type="text" id="tax" name="tax" class="form-control" style="font-weight: bold;" value="0" onkeyup="jumlahkan()" required/>
    </div>
    <div class="form-group col-md-4">
      <label for="tax2"><?php echo get_phrase('Biaya lain-lain').' ('.currency_code_and_symbol('code').')'; ?></label>
      <input type="text" id="tax2" name="tax2" class="form-control" style="font-weight: bold;" value="0" onkeyup="jumlahkan()" required/>
    </div>
    <div class="form-group col-md-4">
      <label for="total_amount"><?php echo get_phrase('total_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
      <input type="text" id="total_amount" name="total_amount" class="form-control" style="font-weight: bold; background-color: #d1e6d6;" /> 
    </div>
    
    <div class="form-group col-md-12">
    <label><?php echo get_phrase('Jenis Tagihan'); ?></label> 
    <select id="kategori" name="kategori" class="form-control select2" data-toggle="select2" required onchange="tampilkan(this.value)">
            <option value=''><?php echo get_phrase('Jenis Tagihan'); ?></option>
            <?php $aa = $this->db->get('recurring')->result_array(); ?>
            <?php foreach($aa as $a): ?>
                <option value="<?php echo $a['no']; ?>"><?php echo $a['name']; ?></option>
            <?php endforeach; ?>
    </select>
    </div>

    <div class="form-group col-md-7"> 
      <span><b>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Tanggal Cetak Tagihan   
      </b></span>  
      <hr>
    </div>
    <div class="form-group col-md-5"></div>  
    
    <div class="form-group col-md-2">
      <label for="day">Tanggal</label>
      <input type="number" id="day" name="day" class="form-control" style="font-weight: bold;" required/>
    </div>
    <div class="form-group col-md-3">
      <label><?php echo get_phrase('month'); ?></label> 
      <select name="label" id="label" class="form-control select2" data-toggle ="select2"  required  onchange="tampilkan2(this.value)">
        <option value="0"><?php echo get_phrase('select_a_month'); ?></option>
      </select> 
    </div> 
    <div class="form-group col-md-2">
      <label><?php echo get_phrase('year'); ?></label> 
      <select name="year" id="year" class="form-control select2" data-toggle="select2" required>
          <option value=""><?php echo get_phrase('select_a_year'); ?></option>
          <?php for($year = date('Y')-1; $year <= date('Y')+2; $year++){ ?>
            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
          <?php } ?>
      </select>
    </div>

    <div class="form-group col-md-3" id="a1" style="display:none;">
      <label>Sampai Bulan :</label> 
      <select id="tampil" name="tampil" class="form-control select2" data-toggle = "select2">
        <option value=''><?php echo get_phrase('select_a_month'); ?></option>
      </select>
    </div>
    <div class="form-group col-md-2" id="a2" style="display:none;">
    <label><?php echo get_phrase('year'); ?></label> 
      <select name="year2" id="year2" class="form-control select2" data-toggle="select2" >
        <option value=""><?php echo get_phrase('select_a_year'); ?></option>
            <?php for($year = date('Y')-1; $year <= date('Y')+2; $year++){ ?>
              <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
            <?php } ?> 
      </select>
    </div>

    
    
    <div class="form-group col-md-12">
      <label for="note"><?php echo get_phrase('note'); ?></label>      
      <textarea class="form-control" id="note" name="note" rows="3"></textarea>
    </div>

    <?PHP /*  
    <div class="form-group col-md-12">
      <label for="paid_amount"><?php echo get_phrase('paid_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
      <input type="number" class="form-control" id="paid_amount" name = "paid_amount" required>
    </div>
     

    <div class="form-group col-md-12">
      <label for="status"><?php echo get_phrase('select_a_status_payment'); ?></label>
      <select name="status" id="status" class="form-control select2" data-toggle="select2" required >
        <option value=""><?php echo get_phrase('select_a_status'); ?></option>
        <option value="paid"><?php echo get_phrase('paid'); ?></option> 
        <option value="not_yet_paid_off"><?php echo get_phrase('not_yet_paid_off'); ?></option> 
        <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
      </select>
    </div>
    */ ?>
  </div>
  <div class="form-group  col-md-12">
    <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('create_invoice'); ?></button>
  </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, showAllInvoices);
});

$(document).ready(function () {
  initSelect2(['#class_id_on_create', '#section_id_on_create', '#student_id_on_create', '#status',  '#label',  '#kategori', '#tampil', '#year', '#year2', '#payment_type', '#total_amount']);
});

function classWiseSectionOnCreate(classId) {
    $.ajax({
        url: "<?php echo route('section/list/'); ?>"+classId,
        success: function(response){
            $('#section_id_on_create').html(response); 
        }
    });
}

function classWiseStudentOnCreate(sectionId) {
  $.ajax({
    url: "<?php echo route('invoice/student/'); ?>"+sectionId,
    success: function(response){
      $('#student_id_on_create').html(response);
    }
  });
}
 
function show(payment_type_id){
	if(payment_type_id==''){		 
		$('#total_amount2').val("");   
		$('#total_amount').val("");   
	}	
	else{ 
        $.ajax({
          type: 'POST', // Metode pengiriman data menggunakan POST
          url: "<?php echo route('invoice/detail_payment_type/'); ?>"+payment_type_id,
		      dataType : 'json',
          success: function(res) { // Jika berhasil
              $('#total_amount2').val(res.price);  
              $('#total_amount').val(res.price);  
            }
	});}
   // });
}
 
function tampilkan(a){   
  if(a==''){ 
    document.getElementById('a1').style.display = "none";		 
    document.getElementById('a2').style.display = "none";		 
		$('#label').html("<option value='0'><?php echo get_phrase('select_a_month'); ?> </option>");   
		$('#tampil').html("<option value='0'><?php echo get_phrase('select_a_month'); ?> </option>");      
	}
  else{
    if(a != '0'){
      document.getElementById('a1').style.display = "block";
      document.getElementById('a2').style.display = "block";
      $('#tampil').html("<option value='0'><?php echo get_phrase('select_a_month'); ?> </option>");      
      $.ajax({         
        url : "<?php echo route('invoice/month/'); ?>", 
        success: function(res) {
          $('#label').html(res); 
        }
      });	
    }
    else{
      document.getElementById('a1').style.display = "none";		 
      document.getElementById('a2').style.display = "none";	
      $('#tampil').html("<option value='0'><?php echo get_phrase('select_a_month'); ?> </option>");      
      $.ajax({         
        url : "<?php echo route('invoice/month/'); ?>", 
        success: function(res) {
          $('#label').html(res); 
        }
      });	
    }
    
  }
}


// $(function() {
//     $('#row_dim').hide(); 
//     $('#type').change(function(){
//         if($('#type').val() == 'parcel') {
//             $('#row_dim').show(); 
//         } else {
//             $('#row_dim').hide(); 
//         } 
//     });
// });

function tampilkan2(a){ 
  if(a=='0'){		      
		$('#tampil').html("<option value='0'><?php echo get_phrase('select_a_month'); ?> </option>");     
	}
  else{     
    var kategori = $('#kategori').val();
    $.ajax({         
      url : "<?php echo route('invoice/recurring/'); ?>"+a,
      data : {kategori : kategori},
      success: function(res) {
        $('#tampil').html(res); 
      }
    });	
  }
}

function setInputFilter(textbox, inputFilter) {
        ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
            textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
            });
        });
    }
	setInputFilter(document.getElementById("total_amount2"), function(value) {
    return /^-?\d*$/.test(value); });
	setInputFilter(document.getElementById("tax"), function(value) {
    return /^-?\d*$/.test(value); });
	setInputFilter(document.getElementById("tax2"), function(value) {
    return /^-?\d*$/.test(value); });
    setInputFilter(document.getElementById("total_amount"), function(value) {
    return /^-?\d*$/.test(value); });
	
	function jumlahkan(){ 
		var total_amount2  = $("#total_amount2").val();
		var tax  = $("#tax").val();
		var tax2 = $("#tax2").val();
		
		var total_amount = parseInt(total_amount2) + parseInt(tax2) + (parseInt(total_amount2)*parseInt(tax))/100;
		$("#total_amount").val(total_amount); 
	}
</script>
