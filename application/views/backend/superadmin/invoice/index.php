<!-- start page title -->
<div class="row ">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <h4 class="page-title">
          <i class="mdi mdi-file-document-box title_icon"></i> <?php echo get_phrase('student_bill'); ?>
          <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="largeModal('<?php echo site_url('modal/popup/invoice/single'); ?>', '<?php echo get_phrase('add_single_invoice'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_single_invoice'); ?></button>
          <button type="button" class="btn btn-outline-success btn-rounded alignToTitle" style="margin-right: 10px;" onclick="largeModal('<?php echo site_url('modal/popup/invoice/mass'); ?>', '<?php echo get_phrase('add_mass_invoice'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_mass_invoice'); ?></button>
        </h4>
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>
<!-- end page title -->
<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <div class="row mt-3 d-print-none"> 
          <div class="col-md-1 mb-1"></div>
          <div class="col-md-5 mb-1"> 
                <div id="reportrange" class="form-control text-center" data-toggle="date-picker-range" data-target-display="#selectedValue"  data-cancel-class="btn-light">
                  <i class="mdi mdi-calendar"></i>&nbsp;
                  <span id="selectedValue" style = "text-align: center;"> <?php echo date('F d, Y', $date_from).' - '.date('F d, Y', $date_to); ?> </span> <i class="mdi mdi-menu-down"></i>
                </div> 
          </div> 
          <div class="col-md-3 mb-1">
            <select name="payment_type_id" id="payment_type_id" class="form-control select2" data-toggle="select2">
                  <option value="all"><?php echo get_phrase('master_payment_type'); ?></option>
                  <?php
                  $payment_types = $this->crud_model->payment_type_view()->result_array();
                  foreach($payment_types as $payment_type){
                    ?>
                    <option value="<?php echo $payment_type['id']; ?>"><?php echo $payment_type['name']; ?></option>
                  <?php } ?>
            </select>
          </div>
          <div class="col-md-2 mb-1">
            <select name="status" id="status" class="form-control select2" data-toggle="select2">
                <option value="all"><?php echo get_phrase('all_status'); ?></option>
                <option value="paid"><?php echo get_phrase('paid'); ?></option> 
                <option value="not_yet_paid_off"><?php echo get_phrase('not_yet_paid_off'); ?></option> 
                <option value="unpaid"><?php echo get_phrase('unpaid'); ?></option>
            </select> 
          </div>
          <div class="col-md-1 mb-1"></div>
        </div>

        <div class="row mt-3 d-print-none">
          <div class="col-md-1 mb-1"></div>
          <div class="col-md-2 mb-1">
            <select name="class" id="class_id" class="form-control select2" data-toggle="select2" onchange="classWiseSection(this.value)" required>
              <option value="all"><?php echo get_phrase('select_a_class'); ?></option>
              <?php
              $classes = $this->db->get_where('classes', array('school_id' => school_id()))->result_array();
              foreach($classes as $class){
                ?>
                <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
              <?php } ?>
            </select>                
          </div>
          <div class="col-md-2 mb-1">
            <select name="section" id="section_id" class="form-control select2" data-toggle="select2" onchange="sectionWiseClassroomsOnCreate(this.value)" required >
              <option value="all"><?php echo get_phrase('select_section'); ?></option>
            </select>
          </div>
         <?PHP /*  
          <div class="col-md-2 mb-1">
            <select name="room_id" id="room_id" class="form-control select2" data-toggle="select2"  required >
              <option value=""><?php echo get_phrase('select_class_room'); ?></option>
            </select>
          </div>
          */ ?>
          <div class="col-md-4 mb-1">
            <select name="student_id" id="student_id" class="form-control select2" data-toggle="select2" required >
              <option value="all"><?php echo get_phrase('select_name'); ?></option>
            </select>
          </div>
          <div class="col-md-2">
            <button class="btn btn-block btn-secondary" onclick="showAllInvoices()" ><?php echo get_phrase('filter'); ?></button>
          </div>
          <div class="col-md-1 mb-1"></div>
        </div>
        <hr>
 
        <?PHP /*  
        <div class="row justify-content-md-center" style="margin-bottom: 10px;">
          <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-3 mb-lg-0">
            <button type="button" class="btn btn-icon btn-primary form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo get_phrase('export_report'); ?></button>
            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 37px, 0px);">
              <a class="dropdown-item" id="export-csv" href="javascript:0" onclick="getExportUrl('csv')">CSV</a>
              <a class="dropdown-item" id="export-pdf" href="javascript:0" onclick="getExportUrl('pdf')">PDF</a>
              <a class="dropdown-item" id="export-print" href="javascript:0" onclick="getExportUrl('print')">Print</a>
            </div>
          </div>
        </div>
        */?>

        <div class="table-responsive-sm">
          <div class="invoice_content">
            <?php include 'list.php'; ?>
          </div>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<script>

function classWiseSection(classId) {
  if(classId=="all")
  { 
		$('#section_id').html("<option value='all'><?php echo get_phrase('select_section'); ?> </option>");   
		$('#student_id').html("<option value='all'><?php echo get_phrase('select_name'); ?> </option>");   
  }
  else{
    $('#section_id').html("<option value='all'><?php echo get_phrase('select_section'); ?> </option>");   
		$('#student_id').html("<option value='all'><?php echo get_phrase('select_name'); ?> </option>"); 
    $.ajax({
      url: "<?php echo route('section/list_finance/'); ?>"+classId,
      success: function(response){
        $('#section_id').html(response);
      }
    });
  }  
}
function sectionWiseClassroomsOnCreate(sectionId) { 
  if(sectionId=="all")
  {     
		$('#student_id').html("<option value='all'><?php echo get_phrase('select_name'); ?> </option>");   
  }
  else{
    $('#student_id').html("<option value='all'><?php echo get_phrase('select_name'); ?> </option>");  
    $.ajax({
      url: "<?php echo route('invoice/student_finance/'); ?>"+sectionId,
      success: function(response){
        $('#student_id').html(response);
      }
    });
  } 
}  

var showAllInvoices = function () {
  var url = '<?php echo route('invoice/list'); ?>';
  var dateRange = $('#selectedValue').text();
  var selectedClass = $('#class_id').val();  
  var selectedsection = $('#section_id').val();
  var selectedClass2 = $('#payment_type_id').val();
  var selectedStatus = $('#status').val();   
  var student_id = $('#student_id').val();
  // if(selectedClass != "" && selectedsection!= "" && student_id!= ""){
  //     $.ajax({
  //       url: url,
  //       data : {date : dateRange, selectedClass : selectedClass, selectedsection : selectedsection, selectedClass2 : selectedClass2, selectedStatus : selectedStatus,  student_id : student_id},
  //       success : function(response) {
  //         $('.invoice_content').html(response);
  //         initDataTable("basic-datatable");
  //       }
  //     });
  // }else{
  //     toastr.error('<?php echo get_phrase('please_select_a_class_and_section'); ?>');
  // } 
  $.ajax({
        url: url,
        data : {date : dateRange, selectedClass : selectedClass, selectedsection : selectedsection, selectedClass2 : selectedClass2, selectedStatus : selectedStatus,  student_id : student_id},
        success : function(response) {
          $('.invoice_content').html(response);
          initDataTable("basic-datatable");
        }
      });
}


function getExportUrl(type) {
  var url = '<?php echo route('export/url'); ?>';
  var dateRange = $('#selectedValue').text();
  var selectedClass = $('#class_id').val(); 
  var selectedStatus = $('#status').val();
  $.ajax({
    type : 'post',
    url: url,
    data : {type : type, dateRange : dateRange, selectedClass : selectedClass, selectedStatus : selectedStatus},
    success : function(response) {
      if (type == 'csv') {
        window.open(response, '_self');
      }else{
        window.open(response, '_blank');
      }
    }
  });
}
 
</script>
