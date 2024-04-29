<?php $invoice_details = $this->crud_model->get_invoice_by_id($param1); ?>
<?php $invoices_recurring = $this->crud_model->get_invoices_recurring_by_id($invoice_details['recurring_id']); ?>
<form method="POST" class="d-block ajaxForm" action="<?php echo route('invoice/update/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="class_id_on_create"><?php echo get_phrase('class'); ?></label>
            <select name="class_id_on_create" id="class_id_on_create" class="form-control select2" data-toggle="select2"  required  disabled >
                <option value=""><?php echo get_phrase('select_a_class'); ?></option>
                <?php $classes = $this->crud_model->get_classes()->result_array(); ?>
                <?php foreach($classes as $class): ?>
                    <option value="<?php echo $class['id']; ?>" <?php if ($class['id'] == $invoice_details['class_id']): ?> selected <?php endif; ?>><?php echo $class['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group col-md-4">
            <label for="section_id_on_create"><?php echo get_phrase('section'); ?></label>
            <select name="section_id_on_create" id="section_id_on_create" class="form-control select2" data-toggle="select2"  required  disabled >
                <option value=""><?php echo get_phrase('select_a_section'); ?></option>
                <?php $sections = $this->crud_model->get_section_details_by_id('class', $invoice_details['class_id'])->result_array(); ?>
                <?php foreach($sections as $section): ?>
                    <option value="<?php echo $section['id']; ?>" <?php if ($section['id'] == $invoice_details['section_id']): ?> selected <?php endif; ?>><?php echo $section['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="student_id_on_create"><?php echo get_phrase('select_student'); ?></label>
            <div id = "student_content">
                <select name="student_id_on_create" id="student_id_on_create" class="form-control select2" data-toggle="select2" required disabled >
                    <option value=""><?php echo get_phrase('select_a_student'); ?></option>
                    <?php $enrolments = $this->user_model->get_student_details_by_id('class', $invoice_details['class_id']);
                    foreach ($enrolments as $enrolment): ?>
                        <option value="<?php echo $enrolment['student_id']; ?>" <?php if ($invoice_details['student_id'] == $enrolment['student_id']): ?>selected<?php endif; ?>><?php echo $enrolment['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group col-md-12"> 
            <label for="invoice_title"><?php echo get_phrase('invoice_no'); ?></label>
            <input type="text" class="form-control" id="invoice_title" name = "invoice_title" value="<?php echo $invoice_details['title']; ?>" required disabled >
        </div>

        <div class="form-group col-md-8">
            <?PHP $payment_types = $this->db->get_where('payment_types', array('id' => $invoice_details['payment_type_id']) )->row_array(); ?>
            <label for="payment_type_id"><?php echo get_phrase('master_payment_type'); ?></label>
            <input type="text" class="form-control" id="payment_type_id" name = "payment_type_id" value="<?php echo $payment_types['name']; ?>" required disabled >
        </div>

        <div class="form-group col-md-4">
            <label for="total_amount2"><?php echo get_phrase('total_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" class="form-control" id="total_amount2" name = "total_amount2" value="<?php echo $invoice_details['total_amount']; ?>" onkeyup="jumlahkan()" required disabled>
        </div>

        <div class="form-group col-md-4">
            <label for="tax"><?php echo get_phrase('Pajak').' (%)'; ?></label>
            <input type="text" id="tax" name="tax" class="form-control" style="font-weight: bold;" value="<?php echo $invoice_details['tax']; ?>" onkeyup="jumlahkan()" required/>
        </div>
        <div class="form-group col-md-4">
            <label for="tax2"><?php echo get_phrase('Biaya lain-lain').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" id="tax2" name="tax2" class="form-control" style="font-weight: bold;" value="<?php echo $invoice_details['tax2']; ?>" onkeyup="jumlahkan()" required/>
        </div>
        <div class="form-group col-md-4">
            <label for="total_amount"><?php echo get_phrase('Jumlah Total Setelah Diubah').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" id="total_amount" name="total_amount" class="form-control" value="<?php echo $invoice_details['total_amount']; ?>" style="font-weight: bold; background-color: #d1e6d6;" /> 
        </div>

        <?PHP if(isset($invoice_details['recurring_id']) && $invoice_details['created_at'] != $invoices_recurring['max'] && $invoices_recurring['max'] != $invoices_recurring['min']): ?>
        <div class="form-group col-md-12">
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="recurring"  name="recurring" value="1">
                <label class="form-check-label" for="recurring"> <?PHP echo get_phrase('Recurring'); ?>  </label>
            </div> 
        </div> 
        <?PHP endif; ?>
        <?PHP /*  
        <div class="form-group col-md-12 answer8">
            <label><?php echo get_phrase('Jenis Tagihan'); ?></label> 
            <select id="kategori" name="kategori" class="form-control select2" data-toggle="select2" required> 
                <option value="<?php echo $invoices_recurring['no']; ?>"><?php echo $invoices_recurring['name']; ?></option> 
            </select>
        </div>
        */ ?>
        <div class="form-group col-md-7 answer1"  style="display:none;"> 
            <span><b>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Tanggal Cetak Tagihan   
            </b></span>  
            <hr>
        </div>
        <div class="form-group col-md-5 answer2"  style="display:none;"></div>  

        <div class="form-group col-md-2 answer3"  style="display:none;">
            <label for="day">Tanggal</label>
            <input type="number" id="day" name="day" class="form-control" style="font-weight: bold;" value="<?php echo date('d',$invoices_recurring['min']); ?>" />
        </div>
        <div class="form-group col-md-3 answer4" style="display:none;">
            <label><?php echo get_phrase('month'); ?></label> 
            <select name="label" id="label" class="form-control select2" data-toggle ="select2">
                <option value="<?php date('F', $invoice_details['created_at']);?>"><?php echo date('F', $invoice_details['created_at']);?></option>    
                <?PHP  /* 
                $start = $invoice_details['created_at'];
                $end = $invoices_recurring['max']; 
                $currentdate = $start;
                while($currentdate <= $end)
                {
                        $cur_date = date('F', $currentdate); 
                ?> 
                        <option value="<?php echo $cur_date; ?>"><?php echo $cur_date; ?></option>
                <?PHP  
                        $currentdate = strtotime("+".$invoices_recurring['no']." month", $currentdate);
                }
                */ ?> 
            </select> 
        </div>
        <div class="form-group col-md-2 answer5" style="display:none;">
            <label><?php echo get_phrase('year'); ?></label> 
            <select name="year" id="year" class="form-control select2" data-toggle="select2" > 
                <option value="<?php date('Y', $invoice_details['created_at']);?>"><?php echo date('Y', $invoice_details['created_at']);?></option> 
            </select>
        </div>

        <div class="form-group col-md-3 answer6" style="display:none;">
            <label>Sampai Bulan :</label> 
                <select id="tampil" name="tampil" class="form-control select2" data-toggle = "select2"> 
                    <?PHP   
                    $start = $invoice_details['created_at'];
                    $end = $invoices_recurring['max'];   
                    $start2 = strtotime("+".$invoices_recurring['no']." month",$start);
                    $currentdate = $start2;     
                    while($currentdate <= $end)
                    {
                            $cur_date = date('F', $currentdate);                              
                            $cur_date2 = $this->crud_model->get_invoices_recurring_by_date($invoice_details['student_id'],$invoice_details['recurring_id'],$currentdate);  
                    ?> 
                            <option value="<?php echo $cur_date2['id']; ?>"  <?php if ($currentdate == $invoices_recurring['max']): ?> selected <?php endif; ?> ><?php echo $cur_date; ?></option>
                    <?PHP  
                            $currentdate = strtotime("+".$invoices_recurring['no']." month", $currentdate);
                    }
                    ?> 
            </select>
        </div>
        <div class="form-group col-md-2 answer7" style="display:none;">
        <label><?php echo get_phrase('year'); ?></label> 
            <select name="year2" id="year2" class="form-control select2" data-toggle="select2" > 
                <?php /*  <option value="<?php date('Y', $invoices_recurring['max']);?>"><?php echo date('Y', $invoices_recurring['max']);?></option>   */?>
                <?php for($year = date('Y', $invoice_details['created_at']); $year <= date('Y')+1; $year++){ ?>
                    <option value="<?php echo $year; ?>"  <?php if ($year == date('Y', $invoices_recurring['max'])) :?> selected <?php endif; ?> ><?php echo $year; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group col-md-12">
            <label for="note"><?php echo get_phrase('note'); ?></label>      
            <textarea class="form-control" id="note" name="note" rows="3"  ><?php echo $invoice_details['note']; ?></textarea>
        </div>

        <?PHP /*  
        <div class="form-group col-md-12">
            <label for="paid_amount"><?php echo get_phrase('paid_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" class="form-control" id="paid_amount" name = "paid_amount" value="<?php echo $invoice_details['paid_amount']; ?>" required>
        </div>        
        <div class="form-group col-md-12">
            <label for="status"><?php echo get_phrase('status'); ?></label>
            <select name="status" id="status" class="form-control select2" data-toggle="select2" required >
                <option value=""><?php echo get_phrase('select_a_status'); ?></option>
                <option value="paid" <?php if ($invoice_details['status'] == 'paid'): ?> selected <?php endif; ?>><?php echo get_phrase('paid'); ?></option>
                <option value="not_yet_paid_off" <?php if ($invoice_details['status'] == 'not_yet_paid_off'): ?> selected <?php endif; ?>><?php echo get_phrase('not_yet_paid_off'); ?></option>
                <option value="unpaid" <?php if ($invoice_details['status'] == 'unpaid'): ?> selected <?php endif; ?>><?php echo get_phrase('unpaid'); ?></option>
            </select>
        </div>
        */ ?> 
    </div>
    <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_invoice'); ?></button>
    </div>
</form>

<script>
$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
    var form = $(this);
    ajaxSubmit2(e, form, showAllInvoices);
});

$(document).ready(function () {
    initSelect2(['#class_id_on_create', '#sction_id_on_create', '#student_id_on_create', '#status', '#label',  '#kategori', '#tampil', '#year', '#year2']);
});

$(function() {
  $("#recurring").on("click",function() { 
    $(".answer1").toggle(this.checked);
    $(".answer2").toggle(this.checked);
    $(".answer3").toggle(this.checked);
    $(".answer4").toggle(this.checked);
    $(".answer5").toggle(this.checked);
    $(".answer6").toggle(this.checked);
    $(".answer7").toggle(this.checked);
  });
});

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
