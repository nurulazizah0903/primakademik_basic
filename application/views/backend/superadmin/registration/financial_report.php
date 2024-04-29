<div class="row">
  <div class="col-xl-12">
    <div class="card">
      <div class="card-body">
        <div class="row mt-3 d-print-none"> 
          <div class="col-md-1 mb-1"></div>
          <div class="col-md-3 mb-1">
          <input type="text" class="form-control date" id="date_from" data-toggle="date-picker" data-single-date-picker="true" name = "date_from" value="" required>
          </div>
          <div class="col-md-3 mb-1">
            <input type="text" value="<?php echo date('m/d/Y'); ?>" class="form-control" id="date_to" name = "date_to" data-provide = "datepicker" required>
              </div>
          <div class="col-md-2 mb-1"> 
            <button class="btn btn-block btn-secondary" onclick="showAllInvoices()" ><?php echo get_phrase('filter'); ?></button>
          </div>
          <div class="col-md-1 mb-1"></div>
        </div>
        <hr>

        <div class="table-responsive">
          <div class="invoice_content">
            <?php include 'list.php'; ?>
          </div>
        </div> <!-- end table-responsive-->
      </div> <!-- end card body-->
    </div> <!-- end card -->
  </div><!-- end col-->
</div>

<script>
	var showAllInvoices = function () {
	var url = '<?php echo route('registration/list'); ?>';
  var date_from = document.getElementById("date_from").value;
  var date_to = document.getElementById("date_to").value;
	$.ajax({
		url: url,
		data : {date_from : date_from, date_to : date_to},
		success : function(response) {
		$('.invoice_content').html(response);
		}
		});
	}
</script>