<?php 
$invoice_details = $this->crud_model->get_invoice_by_id($param1); 
$savings = $this->crud_model->get_use_savings($invoice_details['student_id']); 
?> 
<form method="POST" class="d-block ajaxForm" action="<?php echo route('invoice/payment/'.$param1); ?>">
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="class_id_on_create"><?php echo get_phrase('class'); ?></label>
            <select name="class_id" id="class_id_on_create" class="form-control select2" data-toggle="select2"  required onchange="classWiseStudentOnCreate(this.value)" disabled >
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
                <select name="student_id" id="student_id_on_create" class="form-control select2" data-toggle="select2" required disabled >
                    <option value=""><?php echo get_phrase('select_a_student'); ?></option>
                    <?php $enrolments = $this->user_model->get_student_details_by_id('class', $invoice_details['class_id']);
                    foreach ($enrolments as $enrolment): ?>
                        <option value="<?php echo $enrolment['student_id']; ?>" <?php if ($invoice_details['student_id'] == $enrolment['student_id']): ?>selected<?php endif; ?>><?php echo $enrolment['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group col-md-6"> 
            <label for="invoice_id"><?php echo get_phrase('invoice'); ?></label>
            <input type="text" class="form-control" id="invoice_id" name = "invoice_id" value="<?php echo $invoice_details['title']; ?>" required disabled >
        </div> 
        
        <div class="form-group col-md-6">
            <?PHP $payment_types = $this->db->get_where('payment_types', array('id' => $invoice_details['payment_type_id']) )->row_array(); ?>
            <label for="payment_type_id"><?php echo get_phrase('master_payment_type'); ?></label>
            <input type="text" class="form-control" id="payment_type_id" name = "payment_type_id" value="<?php echo $payment_types['name']; ?>" required disabled >
        </div>

        <div class="form-group col-md-12">
            <label for="note"><?php echo get_phrase('note'); ?></label>      
            <textarea class="form-control" id="note" name="note" rows="3" disabled ><?php echo $invoice_details['note']; ?></textarea>
        </div>          

        <?PHP if(isset($savings)) {?> 
        <div class="form-group col-md-6">
            <label for="total_amount"><?php echo get_phrase('Nominal Tagihan').' ('.currency_code_and_symbol('code').')'; ?></label>
            <?PHP $total_amount22 = $invoice_details['total_amount'] - $invoice_details['paid_amount']?>
            <input type="text" class="form-control" id="total_amount" name = "total_amount" value="<?php echo $total_amount22; ?>" style="font-weight: bold; background-color: #d1e6d6;" required disabled>
        </div>  

        <?PHP /* <div class="form-group col-md-12">
            <div class="form-check form-check-inline">
                <input type="checkbox" class="form-check-input" id="savings_use"  name="savings_use" value="1">
                <label class="form-check-label" for="savings_use"> Memiliki Uang Titipan, Apakah di gunakan?  </label>
            </div> 
        </div>   */ ?> 

        <div class="form-group col-md-6">
            <label for="a_total"><?php echo get_phrase('Uang Titipan').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" class="form-control" id="saving_total" name="saving_total" value="<?PHP echo $savings['total']; ?>" required disabled>
            <input type="hidden" class="form-control" id="a" name="a" value="<?PHP echo $savings['total']; ?>" >
            <input type="hidden" class="form-control" id="saving_id" name="saving_id" value="<?PHP echo $savings['id']; ?>" >
        </div>
        
        <?PHP 
            if($total_amount22 > $savings['total'])
            {
                $total_amount3 = $total_amount22 - $savings['total'];
        ?> 
        <div class="form-group col-md-12">
            <label for="total_amount"><?php echo get_phrase('total_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" class="form-control" id="total_amount1" name = "total_amount1" value="<?php echo $total_amount3; ?>" style="font-weight: bold; background-color: #d1e6d6;" required disabled>
        </div> 

        <div class="form-group col-md-4">
            <label for="paid_amount"><?php echo get_phrase('paid_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" class="form-control" autocomplete="off" id="paid_amount" name = "paid_amount" value="<?php echo $total_amount3; ?>" required>
        </div>

        <div class="form-group col-md-8">
            <label for="finances_file"><?php echo get_phrase('upload_bukti'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="finances_file" name = "finances_file" required>
            </div>
        </div>  
        <?PHP
            }
            else
            {
                $total_amount3 = 0;
        ?>
        <div class="form-group col-md-12">
            <label for="total_amount"><?php echo get_phrase('total_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" class="form-control" id="total_amount1" name = "total_amount1" value="<?php echo $total_amount3; ?>" style="font-weight: bold; background-color: #d1e6d6;" required disabled>
        </div> 

        <div class="form-group col-md-12">
            <label for="paid_amount"><?php echo get_phrase('paid_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" class="form-control" autocomplete="off" id="paid_amount" name = "paid_amount" value="<?php echo $total_amount3; ?>"  required>
        </div>  
        <?PHP
            } 
        ?> 

        <?PHP } else {?>
        <div class="form-group col-md-12">
            <label for="total_amount"><?php echo get_phrase('total_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
            <?PHP $total_amount22 = $invoice_details['total_amount'] - $invoice_details['paid_amount']?>
            <input type="text" class="form-control" id="total_amount" name = "total_amount" value="<?php echo $total_amount22; ?>" style="font-weight: bold; background-color: #d1e6d6;" required disabled>
        </div>    

        <div class="form-group col-md-4">
            <label for="paid_amount"><?php echo get_phrase('paid_amount').' ('.currency_code_and_symbol('code').')'; ?></label>
            <input type="text" class="form-control" autocomplete="off" id="paid_amount" name = "paid_amount" value="<?php echo $total_amount22; ?>" required>
        </div>

        <div class="form-group col-md-8">
            <label for="finances_file"><?php echo get_phrase('upload_bukti'); ?></label>
            <div class="custom-file-upload">
                <input type="file" class="form-control" id="finances_file" name = "finances_file" required>
            </div>
        </div>  
        <?PHP } ?>         
    </div>
    <div class="form-group  col-md-12">
        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_finance'); ?></button>
    </div>
</form>

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
    ajaxSubmit2(e, form, filter_class_invoice););
});
initCustomFileUploader();

$(document).ready(function () {
    initSelect2(['#class_id_on_create', '#student_id_on_create', '#status']);
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
setInputFilter(document.getElementById("paid_amount"), function(value) {
return /^-?\d*$/.test(value); }); 
</script>
