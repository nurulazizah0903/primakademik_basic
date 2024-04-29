<?php
$school_id = school_id(); 
$payment_types = $this->db->get_where('payment_types', array('school_id' => $school_id))->result_array(); 

if (count($payment_types) > 0): ?>
<table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
	<thead>
		<tr style="background-color: #313a46; color: #ababab;">
			<th><?php echo get_phrase('session_manager'); ?></th>
			<th><?php echo get_phrase('name'); ?></th>
			<th><?php echo get_phrase('unit_price'); ?></th>
			<th><?php echo get_phrase('options'); ?></th> 
		</tr>
	</thead>
	<tbody>
		<?php foreach($payment_types as $payment_type):?>
			<tr>
				<?PHP $session = $this->db->get_where('sessions', array('id' => $payment_type['session']))->row_array(); ?>
				<td><?php echo $session['name']; ?></td>
				<td><?php echo $payment_type['name']; ?></td>
				<td>Rp.<?php echo number_format($payment_type['price']); ?></td>
				<td>
					<div class="dropdown text-center">
						<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
						<div class="dropdown-menu dropdown-menu-right">
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="largeModal('<?php echo site_url('modal/popup/payment_type/edit/'.$payment_type['id'])?>', '<?php echo get_phrase('edit_invoice_types'); ?>');"><?php echo get_phrase('edit'); ?></a>
							<!-- item-->
							<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('payment_type/delete/'.$payment_type['id']); ?>', showAllPaymentType)"><?php echo get_phrase('delete'); ?></a>
						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php else: ?>
	<?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>


