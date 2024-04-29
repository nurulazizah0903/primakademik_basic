<?php
$event = $this->db->get_where('event_calendars', array('id' => $param1))->row_array();

?>

<h4><?php echo $event['title']; ?></h4>
<hr>
<h5>
<?php echo get_phrase('date'); ?> : <?php echo date('d M Y', strtotime($event['starting_date'])); ?> - <?php echo date('d M Y', strtotime($event['ending_date'])); ?><br><br>
<?php echo get_phrase('description'); ?> : <?php echo $event['description']; ?><br>
</h5>