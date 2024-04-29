<?php
$school_id = school_id();
$raw = json_encode(["params" => []]);
$contents = stream_context_create(["http" => [
    "header"=>"Content-Type: application/json",
    "content"=>$raw
]]);

$results = file_get_contents(config_item('odoo_url')."/web/transaksi", false, $contents);
$data = json_decode($results, true);
?>
<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-database title_icon"></i> <?php echo get_phrase('finance'); ?>
                    <!-- <button type="button" class="btn btn-outline-primary btn-rounded alignToTitle" onclick="rightModal('<?php echo site_url('modal/popup/finance/create'); ?>', '<?php echo get_phrase('add_finance'); ?>')"> <i class="mdi mdi-plus"></i> <?php echo get_phrase('add_finance'); ?></button> -->
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
				<div class="mb-1 col-md-3"></div>
				<div class="mb-1 col-md-4">
					<select name="nama_siswa" id="nama_siswa" class="form-control select2" data-toggle="select2" required>
						<option value=""><?php echo get_phrase('select_a_student'); ?></option>
						<?php
						foreach($data['result'] as $finance){
							?>
							<option value="<?php echo $finance['nama_siswa']; ?>"><?php echo $finance['nama_siswa']; ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-2">
					<button class="btn btn-block btn-secondary" onclick="filter_finances()" ><?php echo get_phrase('filter'); ?></button>
				</div>
			</div>
            <div class="card-body">
             <div class = "finance_content">
                    <?php include 'list.php'; ?>
             </div>
            </div> 
        </div>
    </div>
</div>

<script>

$('document').ready(function(){
    initSelect2(['#nama_siswa']);
});

function filter_finances(){
    var nama_siswa = $('#nama_siswa').val();
    if(nama_siswa != ""){
        showAllFinances();
    }else{
        toastr.error('<?php echo get_phrase('please_select_a_class'); ?>');
    }
}

var showAllFinances = function () {
    var nama_siswa = $('#nama_siswa').val();
    if(nama_siswa != ""){
        $.ajax({
            url: '<?php echo route('finance_odoo/list/') ?>'+nama_siswa,
            success: function(response){
                $('.finance_content').html(response);
                initDataTable('basic-datatable');
            }
        });
    }
}
</script>