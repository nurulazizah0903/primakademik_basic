<!-- start page title -->

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('history_student_payment'); ?>                   
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div> 
<!-- end page title -->

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="mt-3 row"> 
				<div class="mb-1 col-md-1"></div>
				<div class="mb-1 col-md-6">
                     <div id="reportrange" class="form-control text-center" data-toggle="date-picker-range" data-target-display="#selectedValue"  data-cancel-class="btn-light">
                        <i class="mdi mdi-calendar"></i>&nbsp;
                        <span id="selectedValue" style = "text-align: center;"> <?php echo date('F d, Y', $date_from).' - '.date('F d, Y', $date_to); ?> </span> <i class="mdi mdi-menu-down"></i>
                    </div>
				</div>     
                <div class="mb-1 col-md-4">
                    <select name="payment_type_id" id="payment_type_id" class="form-control select2" data-toggle="select2">
                        <option value="all"><?php echo get_phrase('master_payment_type'); ?></option>
                         <?php
                            $payment_types = $this->db->get_where('payment_types', array('session' => active_session()))->result_array();
                            foreach($payment_types as $payment_type){
                        ?>
                            <option value="<?php echo $payment_type['id']; ?>"><?php echo $payment_type['name']; ?></option>
                        <?php } ?>
                    </select>
				</div>
				<div class="col-md-1">  </div>
			</div>

            <div class="mt-3 row"> 
				<div class="mb-1 col-md-1"></div>
				<div class="mb-1 col-md-2">
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
				<div class="mb-1 col-md-2">
                    <select name="section" id="section_id" class="form-control select2" data-toggle="select2" onchange="sectionWiseClassroomsOnCreate(this.value)" required >
                      <option value="all"><?php echo get_phrase('select_section'); ?></option>
                     </select>
				</div>   
                <div class="mb-1 col-md-4">
                    <select name="student_id" id="student_id" class="form-control select2" data-toggle="select2"  required >
                         <option value="all"><?php echo get_phrase('select_name'); ?></option>
                     </select>
				</div>
				<div class="col-md-2"> 
                    <button type="button" class="btn btn-icon btn-secondary form-control" onclick="filter_finances()"><i class="dripicons-search "></i></button>
				</div>
                <div class="mb-1 col-md-1"></div>
			</div>

            <div class="card-body">
                <div class = "finance_content">
                    <?php include 'list.php'; ?>
             </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script>
var filter_finances = function () {
  var url = '<?php echo route('finance/list'); ?>';
  var dateRange = $('#selectedValue').text();
  var selectedClass = $('#class_id').val();
  var selectedsection = $('#section_id').val();
  var selectedClass2 = $('#payment_type_id').val();  
  var student_id = $('#student_id').val();
  $.ajax({
    type : 'GET',
    url: url,
    data : {date : dateRange, selectedClass : selectedClass, selectedsection : selectedsection, selectedClass2 : selectedClass2, student_id : student_id},
    success : function(response) {
      $('.finance_content').html(response);
      initDataTable("basic-datatable");
    }
  });
} 

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
      url: "<?php echo route('finance/student_finance/'); ?>"+sectionId,
      success: function(response){
        $('#student_id').html(response);
      }
    });
  } 
} 

</script>