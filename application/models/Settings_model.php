<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/

class Settings_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
  }

  //START MENU SETTINGS section
	public function menu_settings(){
		$menu_id = html_escape($this->input->post('menu_id'));
		$column_name = html_escape($this->input->post('column_name'));
		$value = html_escape($this->input->post('value'));

		$check_row = $this->db->get_where('menus', array('id' => $menu_id));
		if($check_row->num_rows() > 0){
			$data[$column_name] = $value;
			$this->db->where('id', $menu_id);
			$this->db->update('menus', $data);
		}else{
			$data['id'] = $menu_id;
			$data[$column_name] = 1;
			$this->db->insert('menus', $data);
			
      $history_data['ket'] = 'Mengisi data menus';
      $history_data['id_user'] = $this->session->set_userdata('user_id');
      $this->db->insert('history', $history_data);
		}

    $response = array(
      'status' => true,
      'notification' => get_phrase('menu_settings_updated_successfully')
    );

    return json_encode($response);
	}
	//END MENU SETTINGS section

  public function update_apk() {
    $file_ext = pathinfo($_FILES['apk']['name'], PATHINFO_EXTENSION);
		$data['apk'] = 'EDNA.'.$file_ext;
		move_uploaded_file($_FILES['apk']['tmp_name'], 'uploads/'.$data['apk']);
    $this->db->where('id', 1);
    $this->db->update('settings', $data);
    $response = array(
      'status' => true,
      'notification' => get_phrase('system_settings_updated_successfully')
    );
    return json_encode($response);

  }
  public function update_system_settings() {
    $data['system_name'] = $this->input->post('system_name');
    $data['system_email'] = $this->input->post('system_email');
    $data['system_title'] = $this->input->post('system_title');
    $data['phone'] = $this->input->post('phone');
    $data['study_time'] = $this->input->post('study_time');
    $data['purchase_code'] = $this->input->post('purchase_code');
    $data['address'] = $this->input->post('address');
    $data['complete_address'] = $this->input->post('complete_address');
    $data['fax'] = $this->input->post('fax');
    $data['footer_text'] = $this->input->post('footer_text');
    $data['footer_link'] = $this->input->post('footer_link');
    $data['timezone'] = $this->input->post('timezone');
    $data['youtube_api_key'] = $this->input->post('youtube_api_key');
    $data['vimeo_api_key'] = $this->input->post('vimeo_api_key');
    $this->db->where('id', 1);
    $this->db->update('settings', $data);
    $response = array(
      'status' => true,
      'notification' => get_phrase('system_settings_updated_successfully')
    );
    return json_encode($response);
  }

  public function last_updated_attendance_data() {
    $data['date_of_last_updated_attendance'] = strtotime(date('d-m-Y H:i:s'));
    $this->db->where('id', 1);
    $this->db->update('settings', $data);
  }

  public function update_system_logo() {
    if ($_FILES['dark_logo']['name'] != "") {
      move_uploaded_file($_FILES['dark_logo']['tmp_name'], 'uploads/system/logo/logo-dark.png');
    }
    if ($_FILES['light_logo']['name'] != "") {
      move_uploaded_file($_FILES['light_logo']['tmp_name'], 'uploads/system/logo/logo-light.png');
    }
    if ($_FILES['small_logo']['name'] != "") {
      move_uploaded_file($_FILES['small_logo']['tmp_name'], 'uploads/system/logo/logo-light-sm.png');
    }
    if ($_FILES['favicon']['name'] != "") {
      move_uploaded_file($_FILES['favicon']['tmp_name'], 'uploads/system/logo/favicon.png');
    }

    $response = array(
      'status' => true,
      'notification' => get_phrase('logo_updated_successfully')
    );
    return json_encode($response);
  }
  
  public function update_cover_photo() {
    move_uploaded_file($_FILES['cover_photo']['tmp_name'], 'assets/backend/images/bg-auth.jpg');

    $response = array(
      'status' => true,
      'notification' => get_phrase('logo_updated_successfully')
    );
    return json_encode($response);
  }

  // SCHOOL SETTINGS
  public function get_current_school_data() {
    return $this->db->get_where('schools', array('id' => school_id()))->row_array();
  }

  public function update_current_school_settings() {
    $data['name'] = $this->input->post('school_name');
    $data['npsn'] = $this->input->post('npsn');
    $data['nss'] = $this->input->post('nss');
    $data['longitudinal'] = $this->input->post('longitudinal');
    $data['phone'] = $this->input->post('phone');
    $data['address'] = $this->input->post('address');
    $this->db->where('id', school_id());
    $this->db->update('schools', $data);
    $response = array(
      'status' => true,
      'notification' => get_phrase('school_settings_updated_successfully')
    );
    return json_encode($response);
  }

  public function delete_school_data($param1 = '') {
    $admin = 'admin';
			
    $history_data['ket'] = 'Delete data sekolah '.$param1.'';
    $history_data['id_user'] = $this->session->set_userdata('user_id');
    $this->db->insert('history', $history_data);

  $this->db->where('school_id', $param1);
		$this->db->delete('alumni');

  $this->db->where('school_id', $param1);
		$this->db->delete('alumni_events');

  $this->db->where('school_id', $param1);
		$this->db->delete('alumni_gallery');

  $this->db->where('school_id', $param1);
		$this->db->delete('alumni_gallery_photos');

  $this->db->where('school_id', $param1);
		$this->db->delete('assignment_questions');

	$this->db->where('school_id', $param1);
	  $this->db->delete('assignment_remarks');

  $this->db->where('school_id', $param1);
		$this->db->delete('assignments');

  $this->db->where('school_id', $param1);
		$this->db->delete('book_issues');

  $this->db->where('school_id', $param1);
		$this->db->delete('books');

  $this->db->where('school_id', $param1);
		$this->db->delete('class_rooms');

  $this->db->where('school_id', $param1);
		$this->db->delete('classes');

  $this->db->where('school_id', $param1);
		$this->db->delete('course');

  $this->db->where('school_id', $param1);
		$this->db->delete('course_section');

  $this->db->where('school_id', $param1);
		$this->db->delete('daily_attendances');

  $this->db->where('school_id', $param1);
		$this->db->delete('departments');

  $this->db->where('school_id', $param1);
		$this->db->delete('enrols');

  $this->db->where('school_id', $param1);
		$this->db->delete('event_calendars');

  $this->db->where('school_id', $param1);
		$this->db->delete('exams');

	$this->db->where('school_id', $param1);
		$this->db->delete('expense_categories');
	
	$this->db->where('school_id', $param1);
		$this->db->delete('expenses');
		
	$this->db->where('school_id', $param1);
		$this->db->delete('finances');

	$this->db->where('school_id', $param1);
		$this->db->delete('grades');

	$this->db->where('school_id', $param1);
		$this->db->delete('invoices');

	$this->db->where('school_id', $param1);
		$this->db->delete('lesson');

	$this->db->where('school_id', $param1);
		$this->db->delete('marks');

	$this->db->where('school_id', $param1);
		$this->db->delete('noticeboard');

	$this->db->where('school_id', $param1);
		$this->db->delete('parents');

	$this->db->where('school_id', $param1);
		$this->db->delete('payment_types');

	$this->db->where('school_id', $param1);
		$this->db->delete('question');

	$this->db->where('school_id', $param1);
		$this->db->delete('routines');

	$this->db->where('school_id', $param1);
		$this->db->delete('sections');

	$this->db->where('school_id', $param1);
		$this->db->delete('students');

	$this->db->where('school_id', $param1);
		$this->db->delete('subjects');

	$this->db->where('school_id', $param1);
		$this->db->delete('syllabuses');

	$this->db->where('school_id', $param1);
		$this->db->delete('teachers');

  $this->db->where('school_id', $param1);
		$this->db->delete('exam_remarks');

  $this->db->where('school_id', $param1);
		$this->db->delete('assignment_remarks');

  $this->db->where('school_id', $param1);
		$this->db->delete('operational_hour');

  $this->db->where('school_id', $param1);
		$this->db->delete('industry_company');

  $this->db->where('school_id', $param1);
		$this->db->delete('internship');

  $this->db->where('school_id', $param1);
		$this->db->delete('internship_attendances');

  $this->db->where('school_id', $param1);
		$this->db->delete('internship_student');

	$this->db->where('school_id', $param1);
  $this->db->where_not_in('role', $admin);
		$this->db->delete('users');
    
    $response = array(
      'status' => true,
      'notification' => get_phrase('school_data_has_been_deleted_successfully')
    );
    return json_encode($response);
  }

  public function delete_classes($param1 = '') {

    $history_data['ket'] = 'Delete data kelas '.$param1.'';
    $history_data['id_user'] = $this->session->set_userdata('user_id');
    $this->db->insert('history', $history_data);

  $class_id = $this->db->get_where('classes', array('school_id' => $param1))->row_array();
  $section_id = $this->db->get_where('sections', array('class_id' => $class_id['id']))->row_array();

  $this->db->where('section_id', $section_id['id']);
  $this->db->delete('class_rooms');

  $this->db->where('school_id', $param1);
	$this->db->delete('class_rooms');

  $this->db->where('class_id', $class_id['id']);
  $this->db->delete('sections');

  $this->db->where('school_id', $param1);
	$this->db->delete('classes');
    
    $response = array(
      'status' => true,
      'notification' => get_phrase('classes_data_has_been_deleted_successfully')
    );
    return json_encode($response);
  }

  public function delete_class_rooms($param1 = '') {

    $history_data['ket'] = 'Delete data class rooms '.$param1.'';
    $history_data['id_user'] = $this->session->set_userdata('user_id');
    $this->db->insert('history', $history_data);

  $this->db->where('school_id', $param1);
    $this->db->delete('class_rooms');
    
    $response = array(
      'status' => true,
      'notification' => get_phrase('class_rooms_data_has_been_deleted_successfully')
    );
    return json_encode($response);
  }

  public function delete_students($param1 = '') {

    $history_data['ket'] = 'Delete data siswa '.$param1.'';
    $history_data['id_user'] = $this->session->set_userdata('user_id');
    $this->db->insert('history', $history_data);
  $teacher = 'teacher';
  $admin = 'admin';

  $this->db->where('school_id', $param1);
    $this->db->delete('students');
  
  $this->db->where('school_id', $param1);
		$this->db->delete('enrols');

  $this->db->where('school_id', $param1);
		$this->db->delete('marks');
    
  $this->db->where('school_id', $param1);
		$this->db->delete('daily_attendances');

  $this->db->where('school_id', $param1);
    $this->db->delete('parents');

  $this->db->where('school_id', $param1);
    $this->db->where_not_in('role', $teacher);
    $this->db->where_not_in('role', $admin);
    $this->db->delete('users');
    
    $response = array(
      'status' => true,
      'notification' => get_phrase('students_data_has_been_deleted_successfully')
    );
    return json_encode($response);
  }

  public function delete_departments($param1 = '') {

    $history_data['ket'] = 'Delete data department/posisi '.$param1.'';
    $history_data['id_user'] = $this->session->set_userdata('user_id');
    $this->db->insert('history', $history_data);

  $this->db->where('school_id', $param1);
    $this->db->delete('departments');
    
    $response = array(
      'status' => true,
      'notification' => get_phrase('departments_data_has_been_deleted_successfully')
    );
    return json_encode($response);
  }

  public function delete_subjects($param1 = '') {

    $history_data['ket'] = 'Delete data mapel '.$param1.'';
    $history_data['id_user'] = $this->session->set_userdata('user_id');
    $this->db->insert('history', $history_data);

  $this->db->where('school_id', $param1);
    $this->db->delete('subjects');
    
    $response = array(
      'status' => true,
      'notification' => get_phrase('subjects_data_has_been_deleted_successfully')
    );
    return json_encode($response);
  }

  public function delete_teachers($param1 = '') {

    $history_data['ket'] = 'Delete data guru '.$param1.'';
    $history_data['id_user'] = $this->session->set_userdata('user_id');
    $this->db->insert('history', $history_data);

    $this->db->where('school_id', $param1);
    $this->db->delete('teachers');

    $this->db->where('school_id', $param1);
    $this->db->delete('job_management');

    $this->db->where('school_id', $param1);
    $this->db->where('role', 'other_employee');
    $this->db->delete('users');

    $this->db->where('school_id', $param1);
    $this->db->where('role', 'teacher');
    $this->db->delete('users');

    $this->db->where('school_id', $param1);
    $this->db->where('role', 'accountant');
    $this->db->delete('users');

    $this->db->where('school_id', $param1);
    $this->db->where('role', 'librarian');
    $this->db->delete('users');
    
    $response = array(
      'status' => true,
      'notification' => get_phrase('teachers_data_has_been_deleted_successfully')
    );
    return json_encode($response);
  }

  public function delete_routines($param1 = '') {

    $history_data['ket'] = 'Delete data jadwal mapel '.$param1.'';
    $history_data['id_user'] = $this->session->set_userdata('user_id');
    $this->db->insert('history', $history_data);

    $this->db->where('school_id', $param1);
      $this->db->delete('routines');
      
      $response = array(
        'status' => true,
        'notification' => get_phrase('routines_data_has_been_deleted_successfully')
      );
      return json_encode($response);
    }

  // PAYMENT SETTINGS
  public function update_system_currency_settings() {
    $data['system_currency'] = $this->input->post('system_currency');
    $data['currency_position'] = $this->input->post('currency_position');
    $this->db->where('id', 1);
    $this->db->update('settings', $data);

    $response = array(
      'status' => true,
      'notification' => get_phrase('system_settings_updated_successfully')
    );
    return json_encode($response);
  }

  public function update_paypal_settings() {
    $paypal_info = array();

    $paypal['paypal_active'] = $this->input->post('paypal_active');
    $paypal['paypal_mode'] = $this->input->post('paypal_mode');
    $paypal['paypal_client_id_sandbox'] = $this->input->post('paypal_client_id_sandbox');
    $paypal['paypal_client_id_production'] = $this->input->post('paypal_client_id_production');
    $paypal['paypal_currency'] = $this->input->post('paypal_currency');
    
    array_push($paypal_info, $paypal);

    $data['value']    =   json_encode($paypal_info);
    $this->db->where('key', 'paypal_settings');
    $this->db->update('payment_settings', $data);

    $response = array(
      'status' => true,
      'notification' => get_phrase('paypal_settings_updated_successfully')
    );
    return json_encode($response);
  }

  public function update_stripe_settings() {
    $stripe_info = array();

    $stripe['stripe_active'] = $this->input->post('stripe_active');
    $stripe['stripe_mode'] = $this->input->post('stripe_mode');
    $stripe['stripe_test_secret_key'] = $this->input->post('stripe_test_secret_key');
    $stripe['stripe_test_public_key'] = $this->input->post('stripe_test_public_key');
    $stripe['stripe_live_secret_key'] = $this->input->post('stripe_live_secret_key');
    $stripe['stripe_live_public_key'] = $this->input->post('stripe_live_public_key');
    $stripe['stripe_currency'] = $this->input->post('stripe_currency');

    array_push($stripe_info, $stripe);

    $data['value']    =   json_encode($stripe_info);
    $this->db->where('key', 'stripe_settings');
    $this->db->update('payment_settings', $data);

    $response = array(
      'status' => true,
      'notification' => get_phrase('paypal_settings_updated_successfully')
    );
    return json_encode($response);
  }

  // UPDATE SMTP CREDENTIALS
  public function update_smtp_settings() {
    if ($this->input->post('mail_sender') == 'php_mailer') {
      if (empty($this->input->post('smtp_secure')) || empty($this->input->post('smtp_set_from')) || empty($this->input->post('smtp_show_error'))) {
        $response = array(
          'status' => false,
          'notification' => get_phrase('please_fill_all_the_fields')
        );
        return json_encode($response);
      }
    }

    $data['mail_sender'] = $this->input->post('mail_sender');
    $data['smtp_protocol'] = $this->input->post('smtp_protocol');
    $data['smtp_host'] = $this->input->post('smtp_host');
    $data['smtp_username'] = $this->input->post('smtp_username');
    $data['smtp_password'] = $this->input->post('smtp_password');
    $data['smtp_port'] = $this->input->post('smtp_port');

    $data['smtp_secure'] = strtolower($this->input->post('smtp_secure'));
    $data['smtp_set_from'] = $this->input->post('smtp_set_from');
    $data['smtp_show_error'] = $this->input->post('smtp_show_error');

    if ($this->db->get('smtp_settings')->num_rows() > 0) {
      $this->db->where('id', 1);
      $this->db->update('smtp_settings', $data);
    }else{
      $this->db->insert('smtp_settings', $data);
    }

    $response = array(
      'status' => true,
      'notification' => get_phrase('smtp_settings_updated_successfully')
    );
    return json_encode($response);
  }

  // This function is responsible for retreving all the files and folder
  function get_list_of_directories_and_files($dir = APPPATH, &$results = array()) {
    $files = scandir($dir);
    foreach($files as $key => $value){
      $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
      if(!is_dir($path)) {
        $results[] = $path;
      } else if($value != "." && $value != "..") {
        $this->get_list_of_directories_and_files($path, $results);
        $results[] = $path;
      }
    }
    return $results;
  }

  // This function is responsible for retreving all the language file from language folder
  function get_list_of_language_files($dir = APPPATH.'/language', &$results = array()) {
    $files = scandir($dir);
    foreach($files as $key => $value){
      $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
      if(!is_dir($path)) {
        $results[] = $path;
      } else if($value != "." && $value != "..") {
        $this->get_list_of_directories_and_files($path, $results);
        $results[] = $path;
      }
    }
    return $results;
  }

  // LANGUAGE SETTINGS
  public function get_all_languages() {
    $language_files = array();
    $all_files = $this->get_list_of_language_files();
    foreach ($all_files as $file) {
      $info = pathinfo($file);
      if( isset($info['extension']) && strtolower($info['extension']) == 'json') {
        $file_name = explode('.json', $info['basename']);
        array_push($language_files, $file_name[0]);
      }
    }
    return $language_files;
  }

  public function create_language() {
    saveDefaultJSONFile(trimmer($this->input->post('language')));
    $response = array(
      'status' => true,
      'notification' => get_phrase('language_added_successfully')
    );
    return json_encode($response);
  }

  public function update_language($param1 = "") {
    if (file_exists('application/language/'.$param1.'.json')) {
      unlink('application/language/'.$param1.'.json');
    }
    saveDefaultJSONFile(trimmer($this->input->post('language')));
    $response = array(
      'status' => true,
      'notification' => get_phrase('language_added_successfully')
    );
    return json_encode($response);
  }

  public function delete_language($param1 = "") {
    if (file_exists('application/language/'.$param1.'.json')) {
      unlink('application/language/'.$param1.'.json');
    }
    $response = array(
      'status' => true,
      'notification' => get_phrase('language_deleted_successfully')
    );
    return json_encode($response);
  }

  public function update_system_language($selected_language = "") {
    $data['language'] = $selected_language;

    $this->db->where('id', 1);
    $this->db->update('settings', $data);
  }

  function get_currencies() {
    return $this->db->get('currencies')->result_array();
  }

  function get_paypal_supported_currencies() {
    $this->db->where('paypal_supported', 1);
    return $this->db->get('currencies')->result_array();
  }

  function get_stripe_supported_currencies() {
    $this->db->where('stripe_supported', 1);
    return $this->db->get('currencies')->result_array();
  }

  // ABOUT APPLICATION INFORMATION
  function get_application_details() {
    $purchase_code = get_settings('purchase_code');
    $returnable_array = array(
      'purchase_code_status' => get_phrase('not_found'),
      'support_expiry_date'  => get_phrase('not_found'),
      'customer_name'        => get_phrase('not_found')
    );

    $personal_token = "gC0J1ZpY53kRpynNe4g2rWT5s4MW56Zg";
    $url = "https://api.envato.com/v3/market/author/sale?code=".$purchase_code;
    $curl = curl_init($url);

    //setting the header for the rest of the api
    $bearer   = 'bearer ' . $personal_token;
    $header   = array();
    $header[] = 'Content-length: 0';
    $header[] = 'Content-type: application/json; charset=utf-8';
    $header[] = 'Authorization: ' . $bearer;

    $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$purchase_code.'.json';
    $ch_verify = curl_init( $verify_url . '?code=' . $purchase_code );

    curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
    curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
    curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

    $cinit_verify_data = curl_exec( $ch_verify );
    curl_close( $ch_verify );

    $response = json_decode($cinit_verify_data, true);

    if (count($response['verify-purchase']) > 0) {

      //print_r($response);
      $item_name 				= $response['verify-purchase']['item_name'];
      $purchase_time 			= $response['verify-purchase']['created_at'];
      $customer 				= $response['verify-purchase']['buyer'];
      $licence_type 			= $response['verify-purchase']['licence'];
      $support_until			= $response['verify-purchase']['supported_until'];
      $customer 				= $response['verify-purchase']['buyer'];

      $purchase_date			= date("d M, Y", strtotime($purchase_time));

      $todays_timestamp 		= strtotime(date("d M, Y"));
      $support_expiry_timestamp = strtotime($support_until);

      $support_expiry_date	= date("d M, Y", $support_expiry_timestamp);

      if ($todays_timestamp > $support_expiry_timestamp)
      $support_status		= get_phrase('expired');
      else
      $support_status		= get_phrase('valid');

      $returnable_array = array(
        'purchase_code_status' => $support_status,
        'support_expiry_date'  => $support_expiry_date,
        'customer_name'        => $customer
      );
    }
    else {
      $returnable_array = array(
        'purchase_code_status' => 'invalid',
        'support_expiry_date'  => 'invalid',
        'customer_name'        => 'invalid'
      );
    }

    return $returnable_array;
  }

    // GET SYSTEM DATA
    // GET COVER IMAGE
    public function get_cover_photo() {
      return base_url('assets/backend/images/bg-auth.jpg');
    }

  // GET DARK LOGO
  public function get_logo_dark($type = "") {
    if ($type == 'small') {
      return base_url('uploads/system/logo/logo-dark-sm.png');
    }else{
      return base_url('uploads/system/logo/logo-dark.png');
    }

  }

  // GET LIGHT LOGO
  public function get_logo_light($type = "") {
    if ($type == 'small') {
      return base_url('uploads/system/logo/logo-light-sm.png');
    }else{
      return base_url('uploads/system/logo/logo-light.png');
    }
  }

  // GET FAVICON
  public function get_favicon() {
    return base_url('uploads/system/logo/favicon.png');
  }


}






