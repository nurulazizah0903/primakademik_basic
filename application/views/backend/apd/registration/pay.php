<?php
$registrations = $this->db->get_where('registrations', array('id' => $param1))->result_array();
foreach ($registrations as $item)
$payment_ppdb = $this->db->get_where('payment_ppdb', array('kode_registrasi' => $item['id']))->result_array();
?>
  <form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('registration/pay/'.$param1); ?>" enctype="multipart/form-data">

  	<div class="form-group col-md-12">
		<div class="row">
			<div class="col-md-2 d-flex align-items-center">
				<label for="voucher"><?php echo get_phrase('total'); ?></label>
			</div>
			<div class="col-md-4">
				<?php
					$regis_path = $this->db->get_where('registration_path', array('id' => $item['jalur_pendaftaran']))->row_array();
					if($item['bayar_pertama'] == ""){
						echo '<input type="hidden" id="total" value="'.$regis_path['total'].'" class="form-control"><h4>'.currency( number_format($regis_path['total'],0,",",".")).'</h4>';
					} else if($item['bayar_pertama'] != "" OR $item['bayar_kedua'] != "" OR $item['bayar_ketiga'] != ""){
						$remove_format = str_replace("Rp. ","",$item['sisa']);
						$sisa = str_replace(".","",$remove_format);

						echo '<input type="hidden" id="total" value="'.$sisa.'" class="form-control"><h4>'.currency( number_format($sisa,0,",",".")).'</h4>';
					}
				?>
			</div>
			<div class="col-md-2 d-flex align-items-center">
				<label for="voucher"><?php echo get_phrase('voucher'); ?></label>
			</div>
			<?php if(empty($payment_ppdb)){ ?>
				<div class="col-md-4">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="400000" name="v_satu" id="flexCheckDefault">
						<label class="form-check-label" for="flexCheckDefault">
							<h5>400.000</h5>
						</label>
					</div>
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="300000" name="v_dua" id="flexCheckDefault">
						<label class="form-check-label" for="flexCheckDefault">
							<h5>300.000</h5>
						</label>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="form-group col-md-12">
		<table class="table table-bordered table-striped" width="100%">
			<thead>
				<tr>
					<th colspan="4">History Pembayaran PPDB</th>
				</tr>
				<tr>
					<th>Uraian</th>
					<th>Tanggal</th>
					<th>Total</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$registration_path = $this->db->get_where('registration_path', array('id' => $item['jalur_pendaftaran']))->row_array();
					$this->db->select_sum('total');
					$this->db->where('kode_registrasi', $item['id']);
					$total = $this->db->get('payment_ppdb')->row_array();
					$sisa = $registration_path['total'] - $total['total'];
					foreach($payment_ppdb as $data){
				?>
				<tr>
					<td><?= $data['ket'];?></td>
					<td><?php echo date('d M Y', strtotime($data['date'])); ?></td>
					<td><?= currency( number_format($data['total'],0,",","."))?></td>
					<td><a href="javascript:void(0);" class="btn btn-danger mdi mdi-pen" onclick="largeModal('<?php echo site_url('modal/popup/registration/edit_payment/'.$data['id']); ?>', '<?php echo get_phrase('update_payment'); ?>')" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?php echo get_phrase('edit'); ?>"></a></td>
				</tr>
				<?php } ?>
				<tr>
					<th colspan="2">Sisa Bayar</th>
					<th colspan="2" style="text-align: right;"><?= currency( number_format($sisa,0,",","."))?></th>
				</tr>
			</tbody>
		</table>
	</div>
	<div id = "first-row">
		<div class="row">
			<div class="col-lg-6">
				<center>
					<h4>Tambah Pembayaran</h4>
				</center>
			</div>
			<div class="col-lg-2">
				<button type="button" class="btn btn-icon btn-success" onclick="appendRow()"> <i class="mdi mdi-plus"></i> </button>
			</div>
		</div>
	</div>

	<div id = "blank-row" style="display: none;">
        <div class="row student-row">
			<div class="col-lg-4">
				<label for="ket"><?php echo get_phrase('uraian'); ?></label>
				<input type="text" required name="ket[]" id="ket" class="form-control">
			</div>
			<div class="col-lg-6">
				<label for="amount_ppdb"><?php echo get_phrase('amount_ppdb'); ?></label>
				<input type="number" required name="amount_ppdb[]" id="amount_ppdb" class="form-control">
			</div>
			<div class="col-lg-2">
				<button type="button" class="btn btn-icon btn-danger" onclick="removeRow(this)"> <i class="mdi mdi-window-close"></i> </button>
			</div>
		</div>
	</div>
<br>
	<div class="form-group col-md-12">
      	<label for="status"><?php echo get_phrase('select_status'); ?></label>
		<table border="0">
			<tr>
				<td class="text-center" width="50px">
					<input type="radio" name="status" value="Not Yet Paid"  <?= ($item['status'] == 'Not Yet Paid') ? 'checked' : '' ?> style="width: 2em; height: 2em;">
				</td>
				<td>
					<h5><?php echo get_phrase('belum_bayar'); ?></h5>
				</td>
			</tr>
			<tr>
				<td class="text-center" width="50px">
					<input type="radio" name="status" value="Installment"  <?= ($item['status'] == 'Installment') ? 'checked' : '' ?> style="width: 2em; height: 2em;">
				</td>
				<td>
					<h5><?php echo get_phrase('Installment'); ?></h5>
				</td>
			</tr>
			<tr>
				<td class="text-center">
					<input type="radio" name="status" value="Accepted" <?= ($item['status'] == 'Accepted') ? 'checked' : '' ?> style="width: 2em; height: 2em;"> 
				</td>
				<td>
					<h5><?php echo get_phrase('diterima'); ?></h5>
				</td>
			</tr>
		</table>
    </div>
  </div><br><br>
        <button class="btn btn-primary col-sm-12" onclientclick="window.open('https://stackoverflow.com/questions/8994285/how-do-i-use-target-blank-on-a-response-redirect')" type="submit"><?php echo get_phrase('update') ?></button>
  </form>

<script>
	var blank_field = $('#blank-row').html();
    var row = 1;

	function appendRow() {
        $('#first-row').append(blank_field);
        row++;

        $('.kode_registrasi').attr('id', 'kode_registrasi'+row);
        $('#kode_registrasi' + row, '.student-row').select2();
    }

    function removeRow(elem) {
        $(elem).closest('.student-row').remove();
        row--;
    }

$(".ajaxForm").validate({}); // Jquery form validation initialization
$(".ajaxForm").submit(function(e) {
  var form = $(this);
  ajaxSubmit2(e, form, showAllTeachers);
  location.reload();
});

  initCustomFileUploader();
</script>
