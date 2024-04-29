<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/

if (! function_exists('addon_status')) {
  function addon_status($unique_identifier = '') {
    $CI	=&	get_instance();
    $CI->load->database();
    $result = $CI->db->get_where('addons', array('unique_identifier' => $unique_identifier));
    if ($result->num_rows() > 0) {
      $result = $result->row_array();
      return $result['status'];
    }else{
      return 0;
    }

  }
}
// ------------------------------------------------------------------------
/* End of file addon_helper.php */
