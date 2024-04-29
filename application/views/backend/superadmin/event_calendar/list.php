<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div id="calendar"></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
	<div class="col-md-12 d-print-none">
		<div class="alert alert-warning" role="alert">
			<i class="dripicons-information mr-2"></i> <?php echo get_phrase('this_events_will_get_appeared_at'); ?> <strong><?php echo get_phrase('user'); ?> ( <?php echo get_phrase('backend'); ?> ) <?php echo get_phrase('panel_events'); ?></strong>.
		</div>
	</div>
		<div class="card">
			<div class="card-body">
				<?php $school_id = school_id(); ?>
				<?php $query = $this->db->get_where('event_calendars', array('school_id' => $school_id, 'session' => active_session())); ?>
				<?php if($query->num_rows() > 0): ?>
					<table id="basic-datatable" class="table table-striped dt-responsive" width="100%">
						<thead>
							<tr style="background-color: #313a46; color: #ababab;">
								<th><?php echo get_phrase('event_title'); ?></th>
								<th><?php echo get_phrase('from'); ?></th>
								<th><?php echo get_phrase('to'); ?></th>
								<th><?php echo get_phrase('options'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$event_calendars = $this->db->get_where('event_calendars', array('school_id' => $school_id, 'session' => active_session()))->result_array();
							foreach($event_calendars as $event_calendar){
								?>
								<tr>
									<td><a href="javascript:void(0);" onclick="largeModal('<?php echo site_url('modal/popup/event_calendar/detail/'.$event_calendar['id'])?>', '<?php echo $this->db->get_where('schools', array('id' => $school_id))->row('name'); ?>')"><?php echo $event_calendar['title']; ?></a></td>
									<td><?php echo date('D, d M Y', strtotime($event_calendar['starting_date'])); ?></td>
									<td><?php echo date('D, d M Y', strtotime($event_calendar['ending_date'])); ?></td>
									<td>
										<div class="dropdown text-center">
											<button type="button" class="btn btn-sm btn-icon btn-rounded btn-outline-secondary dropdown-btn dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
											<div class="dropdown-menu dropdown-menu-right">
												<!-- item-->
												<a href="javascript:void(0);" class="dropdown-item" onclick="showAjaxModal('<?php echo site_url('modal/popup/event_calendar/edit/'.$event_calendar['id']); ?>', '<?php echo get_phrase('update_event'); ?>');"><?php echo get_phrase('edit'); ?></a>
												<!-- item-->
												<a href="javascript:void(0);" class="dropdown-item" onclick="confirmModal('<?php echo route('event_calendar/delete/'.$event_calendar['id']); ?>', showAllEvents)"><?php echo get_phrase('delete'); ?></a>
											</div>
										</div>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<div class="row d-print-none mt-3">
					<div class="col-12 text-right"><a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i><?php echo get_phrase('print'); ?></a></div>
				</div>
				<?php else: ?>
					<?php include APPPATH.'views/backend/empty.php'; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
