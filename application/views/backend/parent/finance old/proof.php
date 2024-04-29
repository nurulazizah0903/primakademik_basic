<?php 
$finances = $this->db->get_where('finances', array('id' => $param1))->result_array(); 
// echo $this->user_model->get_finance_image($param1); 
// echo $finances[0]['file'];
?><br/>
<img class="img-fluid" width="auto" height="auto" src="<?php echo base_url().'uploads/finance/'.$finances[0]['file'];?>">