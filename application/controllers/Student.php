<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/

class Student extends CI_Controller {
	public function __construct(){

		parent::__construct();

		$this->load->database();
		$this->load->library('session');

		/*LOADING ALL THE MODELS HERE*/
		$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Payment_model',  'payment_model');
		$this->load->model('Email_model',    'email_model');
		$this->load->model('Addon_model',    'addon_model');
		$this->load->model('Frontend_model', 'frontend_model');

		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");

		/*SET DEFAULT TIMEZONE*/
		timezone();

		// CHECK WHETHER student IS LOGGED IN
		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
	}

	// INDEX FUNCTION
	public function index(){
		redirect(site_url('student/dashboard'), 'refresh');
	}

	//DASHBOARD
	public function dashboard(){
		$page_data['page_title'] = 'Dashboard';
		$page_data['folder_name'] = 'dashboard';
		$this->load->view('backend/index', $page_data);
	}

	//START CLASS secion
	public function manage_class($param1 = '', $param2 = '', $param3 = ''){
		if($param1 == 'section'){
			$response = $this->crud_model->section_update($param2);
			echo $response;
		}

		// show data from database
		if ($param1 == 'list') {
			$this->load->view('backend/student/class/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'class';
			$page_data['page_title'] = 'class';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END CLASS section
	//	SECTION STARTED
	public function section($action = "", $id = "") {

		// PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
		if ($action == 'list') {
			$page_data['class_id'] = $id;
			$this->load->view('backend/student/section/list', $page_data);
		}
	}
	//	SECTION ENDED

	//	district STARTED
	public function district_dropdown($action = "", $province_id = "", $user_id = "") {

		// PROVIDE A LIST OF district ACCORDING TO province_id ID
		if ($action == 'dropdown') {
		  $page_data['province_id'] = $province_id;
		  $this->load->view('backend/student/district/dropdown', $page_data);
		}
	
		if ($action == 'edit') {
		  $page_data['user_id'] = $user_id;
		  $this->load->view('backend/student/district/dropdown_edit', $page_data);
		}
	  }
	  //	district ENDED
	
	  //	districts STARTED
	  public function districts_dropdown($action = "", $district_id = "") {
	
		// PROVIDE A LIST OF districts ACCORDING TO district_id ID
		if ($action == 'dropdown') {
		  $page_data['district_id'] = $district_id;
		  $this->load->view('backend/student/districts/dropdown', $page_data);
		}
	  }
	  //	districts ENDED
	
	  //	ward STARTED
	  public function ward_dropdown($action = "", $districts_id = "") {
	
		// PROVIDE A LIST OF ward ACCORDING TO districts_id ID
		if ($action == 'dropdown') {
		  $page_data['districts_id'] = $districts_id;
		  $this->load->view('backend/student/ward/dropdown', $page_data);
		}
	  }
	  //	ward ENDED
	
	  //	postcode STARTED
	  public function postcode_dropdown($action = "", $districts_id = "") {
	
		// PROVIDE A LIST OF district ACCORDING TO districts_id ID
		if ($action == 'dropdown') {
		  $page_data['districts_id'] = $districts_id;
		  $this->load->view('backend/student/postcode/dropdown', $page_data);
		}
	  }
	  //	postcode ENDED

	//FINANCE LIST MANAGER
	public function finance2($param1 = "", $param2 = "", $param3 = '') {
	
		// upload a file
		if ($param1 == 'upload') {
		  $response = $this->crud_model->update_payment($param2);
		  echo $response;
		}
		
		// showing the list of finance
		if ($param1 == 'list') {
		  $page_data['class_id'] = $param2;
		  $page_data['section_id'] = $param3;
		  $this->load->view('backend/student/finance/list', $page_data);
		}
	
		// showing the index file
		if(empty($param1)){
		  $page_data['folder_name'] = 'finance';
		  $page_data['page_title']  = 'finance';
		  $this->load->view('backend/index', $page_data);
		}
	  }

	//START SUBJECT section
	public function subject($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'list'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/student/subject/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'subject';
			$page_data['page_title'] = 'subject';
			$this->load->view('backend/index', $page_data);
		}
	}

	public function class_wise_subject($class_id) {

		// PROVIDE A LIST OF SUBJECT ACCORDING TO CLASS ID
		$page_data['class_id'] = $class_id;
		$this->load->view('backend/student/subject/dropdown', $page_data);
	}
	//END SUBJECT section


	//START SYLLABUS section
	public function syllabus($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'list'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/student/syllabus/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'syllabus';
			$page_data['page_title'] = 'syllabus';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END SYLLABUS section

	//START MATERIALS section
	public function materials($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

		if($param1 == 'list'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$page_data['subject_id'] = $param4;
			$this->load->view('backend/student/materials/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'materials';
			$page_data['page_title'] = 'materials';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END MATERIALS section

	//START TEACHER section
	public function teacher($param1 = '', $param2 = '', $param3 = ''){
		$page_data['folder_name'] = 'teacher';
		$page_data['page_title'] = 'techers';
		$this->load->view('backend/index', $page_data);
	}
	//END TEACHER section

	//START CLASS ROUTINE section
	public function routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

		if($param1 == 'filter'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/student/routine/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'routine';
			$page_data['page_title'] = 'routine';
			$this->load->view('backend/index', $page_data);
			// $this->load->view('backend/student/routine/index', $page_data);
		}
	}
	//END CLASS ROUTINE section

	//START CLASS SCHEDULE section
	public function schedule($param1 = '', $param2 = '', $param3 = '', $param4 = ''){
		if($param1 == 'filter'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/student/schedule/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'schedule';
			$page_data['page_title'] = 'schedule';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END CLASS SCHEDULE section

	//START CLASS SCORE section
	public function score($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

		if($param1 == 'filter'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/student/score/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'score';
			$page_data['page_title'] = 'score';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END CLASS SCORE section

	//START DAILY ATTENDANCE section
	public function attendance($param1 = '', $param2 = '', $param3 = ''){
		if($param1 == 'filter'){
			$date = '01 '.$this->input->post('month').' '.$this->input->post('year');
			$page_data['attendance_date'] = strtotime($date);
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['month'] = $this->input->post('month');
			$page_data['year'] = $this->input->post('year');
			$this->load->view('backend/student/attendance/list', $page_data);
		}

		if($param1 == 'confirm'){
			$response = $this->crud_model->confirm($param2);
			echo $response;
		}

		if($param1 == 'confirm_all'){
			$response = $this->crud_model->confirm_all($param2);
			echo $response;
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'attendance';
			$page_data['page_title'] = 'attendance';
			$this->load->view('backend/index', $page_data);
			// $this->load->view('backend/student/attendance/index', $page_data);
		}
	}
	//END DAILY ATTENDANCE section

	//START DAILY ATTENDANCE ROUTINE section
	public function attendance_routine($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){

		if($param1 == 'filter'){
		  $date = '01 '.$this->input->post('month').' '.$this->input->post('year');
		  $page_data['attendance_date'] = strtotime($date);
		  $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
		  $page_data['subject_id'] = $this->input->post('subject_id');
		  $page_data['month'] = $this->input->post('month');
		  $page_data['year'] = $this->input->post('year');
		  $this->load->view('backend/student/attendance_routine/list', $page_data);
		}
	
		if($param1 == 'confirm_routine'){
				$response = $this->crud_model->confirm_routine($param2);
				echo $response;
		}

		if($param1 == 'confirm_all'){
			$response = $this->crud_model->confirm_routine_student($param2);
			echo $response;
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'attendance_routine';
		  $page_data['page_title'] = 'attendance_routine';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END DAILY ATTENDANCE ROUTINE section

	//START EVENT CALENDAR section
	public function event_calendar($param1 = '', $param2 = ''){

		if($param1 == 'all_events'){
			echo $this->crud_model->all_events();
		}

		if ($param1 == 'list') {
			$this->load->view('backend/student/event_calendar/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'event_calendar';
			$page_data['page_title'] = 'event_calendar';
			$this->load->view('backend/index', $page_data);
			// $this->load->view('backend/student/event_calendar/index', $page_data);
		}
	}
	//END EVENT CALENDAR section

	//START achievements section
	public function achievements($param1 = '', $param2 = ''){	
		// Get the data from database
		if($param1 == 'list'){
		  $this->load->view('backend/student/achievements/list');
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'achievements';
		  $page_data['page_title'] = 'achievements';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	//END achievements section

	//START violations section
	public function violations($param1 = '', $param2 = ''){
		// Get the data from database
		if($param1 == 'list'){
		  $this->load->view('backend/student/violations/list');
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'violations';
		  $page_data['page_title'] = 'violations';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	//END violations section

	//routine_counseling LIST MANAGER
	public function routine_counseling($param1 = "", $param2 = "", $param3 = '', $param4 = '') {
		
		if($param1 == 'filter'){
		  $page_data['class_id'] = $param2;
		  $page_data['section_id'] = $param3;
		  $this->load->view('backend/student/routine_counseling/list', $page_data);
		}
	
		// showing the index file
		if(empty($param1)){
		  $page_data['folder_name'] = 'routine_counseling';
		  $page_data['page_title']  = 'routine_counseling';
		  // $page_data['date_from'] = strtotime(date('d-M-Y', strtotime(' -30 day')).' 00:00:00');
		  // $page_data['date_to']   = strtotime(date('d-M-Y').' 23:59:59');
		  $this->load->view('backend/index', $page_data);
		}
	  }
	//START ROUTINE_ORGANIZATION section

	//START ROUTINE_EXTRACULICULER section
	public function routine_extracurricular($param1 = '', $param2 = '', $param3 = '', $param4 = ''){
	
		if($param1 == 'filter'){
		  $page_data['organizations_id'] = $param2;
		  $this->load->view('backend/student/routine_extracurricular/list', $page_data);
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'routine_extracurricular';
		  $page_data['page_title'] = 'routine_extracurricular';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	//END ROUTINE_EXTRACULICULER section

	//START EXAM section
	public function exam($param1 = '', $param2 = ''){

		if ($param1 == 'list') {
			$this->load->view('backend/student/exam/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'exam';
			$page_data['page_title'] = 'exam';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END EXAM section

	//START organizations section
	public function organizations($param1 = '', $param2 = ''){
	
		// PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
		if ($param1 == 'list') {
		  $this->load->view('backend/student/organizations/list');
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'organizations';
		  $page_data['page_title'] = 'organizations';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END organizations section

	//START MARKS section
	public function mark($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'list'){
			$page_data['mark_type'] = $param2;
			$this->load->view('backend/student/mark/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'mark';
			$page_data['page_title'] = 'marks';
			$this->load->view('backend/index', $page_data);
			// $this->load->view('backend/student/mark/index', $page_data);
		}
	}
	//END MARKS sesction

	// GRADE SECTION STARTS
	public function grade($param1 = "", $param2 = "") {
		$page_data['folder_name'] = 'grade';
		$page_data['page_title'] = 'grades';
		$this->load->view('backend/index', $page_data);
	}
	// GRADE SECTION ENDS

	

	// BACKOFFICE SECTION

	//BOOK LIST MANAGER
	public function book($param1 = "", $param2 = "") {
		$page_data['folder_name'] = 'book';
		$page_data['page_title']  = 'books';
		$this->load->view('backend/index', $page_data);
	}

	// BOOK ISSUED BY THE STUDENT
	public function book_issue($param1 = "", $param2 = "", $param3 = "", $param4 = "") {
		if ($param1 == 'issue') {
			$page_data['page_name'] = 'index';
			$page_data['folder_name'] = 'book_issue';
			$page_data['page_title'] = 'book_issue';
			$this->load->view('backend/index', $page_data);
		}

		// showing the list of book
		if ($param1 == 'list') {
			$this->load->view('backend/student/book_issue/list');
		}
		
		// showing the index file
		if(empty($param1)){
			// $page_data['book_status_type'] = $param2;
			$page_data['folder_name'] = 'book_issue';
			$page_data['page_title']  = 'book_issue';
			$this->load->view('backend/index', $page_data);
		}
	}

	//MANAGE PROFILE STARTS
	public function profile($param1 = "", $param2 = "") {
		if ($param1 == 'update_profile') {
			$response = $this->user_model->update_profile();
			echo $response;
		}
		if ($param1 == 'update_password') {
			$response = $this->user_model->update_password();
			echo $response;
		}

		// showing the Smtp Settings file
		if(empty($param1)){
			$page_data['folder_name'] = 'profile';
			$page_data['page_title']  = 'manage_profile';
			$this->load->view('backend/index', $page_data);
			// $this->load->view('backend/student/profile/index', $page_data);
		}
	}
	//MANAGE PROFILE ENDS

	public function payment($invoice_id = ""){
		$page_data['page_title']  = 'payment_gateway';
		$page_data['invoice_details'] = $this->crud_model->get_invoice_by_id($invoice_id);
		$this->load->view('backend/payment_gateway/index', $page_data);
	}

	public function raport($param1 = "", $param2 = "", $param3 = ""){
		if($param1 == 'list'){
			$this->load->view('backend/student/raport/list');
		}
		
		if(empty($param1)){
			$page_data['folder_name'] = 'raport';
			$page_data['page_title'] = 'raport';
			$this->load->view('backend/index', $page_data);
			// $this->load->view('backend/student/raport/index', $page_data);
		}
	}
	
	// PAYPAL CHECKOUT
	public function paypal_checkout() {
		$invoice_id = $this->input->post('invoice_id');
		$invoice_details = $this->crud_model->get_invoice_by_id($invoice_id);

		$page_data['invoice_id']   = $invoice_id;
		$page_data['user_details']    = $this->user_model->get_student_details_by_id('student', $invoice_details['student_id']);
		$page_data['amount_to_pay']   = $invoice_details['total_amount'] - $invoice_details['paid_amount'];
		$page_data['folder_name'] = 'paypal';
		$page_data['page_title']  = 'paypal_checkout';
		$this->load->view('backend/payment_gateway/paypal_checkout', $page_data);
	}
	// STRIPE CHECKOUT
	public function stripe_checkout() {
		$invoice_id = $this->input->post('invoice_id');
		$invoice_details = $this->crud_model->get_invoice_by_id($invoice_id);

		$page_data['invoice_id']   = $invoice_id;
		$page_data['user_details']    = $this->user_model->get_student_details_by_id('student', $invoice_details['student_id']);
		$page_data['amount_to_pay']   = $invoice_details['total_amount'] - $invoice_details['paid_amount'];
		$page_data['folder_name'] = 'paypal';
		$page_data['page_title']  = 'paypal_checkout';
		$this->load->view('backend/payment_gateway/stripe_checkout', $page_data);
	}

	// THIS FUNCTION WILL BE CALLED AFTER A SUCCESSFULL PAYMENT
	public function payment_success($payment_method = "", $invoice_id = "", $amount_paid = "") {
		if ($payment_method == 'stripe') {
			$stripe = json_decode(get_payment_settings('stripe_settings'));
			$token_id = $this->input->post('stripeToken');
			$stripe_test_mode = $stripe[0]->stripe_mode;
            if ($stripe_test_mode == 'on') {
                $public_key = $stripe[0]->stripe_test_public_key;
                $secret_key = $stripe[0]->stripe_test_secret_key;
            } else {
                $public_key = $stripe[0]->stripe_live_public_key;
                $secret_key = $stripe[0]->stripe_live_secret_key;
            }
            $this->payment_model->stripe_payment($token_id, $invoice_id, $amount_paid, $secret_key);
		}

		$data['payment_method'] = $payment_method;
		$data['invoice_id'] = $invoice_id;
		$data['amount_paid'] = $amount_paid;
		$this->crud_model->payment_success($data);

		redirect(route('invoice'), 'refresh');
	}
	// ACCOUNT SECTION ENDS

  // -----------------------------------------------------#accounting-----------------------------------------------------------------//	
	//FINANCE LIST MANAGER
	public function finance($param1 = "", $param2 = "" ) {	
		// upload a file
		if ($param1 == 'upload') {
		  $response = $this->crud_model->update_payment($param2);
		  echo $response;
		}
		
		// showing the list of finance
		if ($param1 == 'list') {
		  $page_data['class_id'] = $param2; 
		  $date = explode('-', $this->input->get('date'));
			$page_data['date_from'] = strtotime($date[0].' 00:00:00');
			$page_data['date_to']   = strtotime($date[1].' 23:59:59');
			$page_data['selected_class'] = $this->input->get('selectedClass');
			$page_data['selected_class2'] = $this->input->get('selectedClass2'); 
		  $this->load->view('backend/student/finance/list', $page_data);
		}
	
		// showing the index file
		if(empty($param1)){
		  $page_data['folder_name'] = 'finance';
		  $page_data['page_title']  = 'finance';
		  $first_day_of_month = date("d")." ".date("M")." ".date("Y").' 00:00:00';
			$last_day_of_month  = date("d")." ".date("M")." ".date("Y").' 23:59:59';
			$page_data['date_from']   = strtotime($first_day_of_month);
			$page_data['date_to']     = strtotime($last_day_of_month);
			$page_data['selected_class'] = 'all';
			$page_data['selected_class2'] = 'all'; 
		  $this->load->view('backend/index', $page_data);
		} 
	  }
	
	  // ACCOUNT SECTION STARTS
	public function invoice($param1 = "", $param2 = "") {
		// showing the list of invoices
		if ($param1 == 'invoice') {
			$page_data['invoice_id'] = $param2;
			$page_data['folder_name'] = 'invoice';
			$page_data['page_name'] = 'invoice';
			$page_data['page_title']  = 'invoice';
			$invoices = $this->db->query('
				SELECT * FROM invoices 
				WHERE id = '.$param2.' and title IS NULL AND created_at <='. strtotime(date('M-d-Y')) .'
			')->result_array();
			$a = $this->db->query("SELECT count(invoices.id)+1 as total FROM invoices where title IS NOT NULL")->row();
			$a2 = $a->total;
			foreach($invoices as $invoice){   
				$nisn = $this->db->query('select nisn from students where id='. $invoice['student_id'] )->row_array(); 
				$data['title'] = 'INV/'.$nisn['nisn'].'/'.date('Y').'/'.date('m').'/'.$a2;          
				$this->db->where('id', $invoice['id']);
				$this->db->update('invoices', $data);          
				$a2++;       
			}
			$page_data['school'] = $this->db->query('
				SELECT settings.id, schools.name, schools.address, schools.phone
				FROM settings
				INNER JOIN schools ON settings.school_id = schools.id
			')->row_array(); 
			$this->load->view('backend/index', $page_data);
		} 

		// showing the index file
		if(empty($param1)){
			$page_data['folder_name'] = 'invoice';
			$page_data['page_title']  = 'invoice';
			$first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
      		$last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
      		$page_data['date_from']   = strtotime($first_day_of_month);
      		$page_data['date_to']     = strtotime($last_day_of_month);
			$this->load->view('backend/index', $page_data);
			// $this->load->view('backend/student/invoice/index', $page_data);			

		}
		
		// showing the list of invoices
		if ($param1 == 'list') { 
			$date = explode('-', $this->input->get('date'));
			$page_data['date_from'] = strtotime($date[0].' 00:00:00');
			$page_data['date_to']   = strtotime($date[1].' 23:59:59'); 
			$this->load->view('backend/student/invoice/list', $page_data);
		}

		// For add payment
		if ($param1 == 'payment') {
			$response = $this->crud_model->add_payment($param2);
			echo $response;
		  }
	}

	//START INTERNSHIP ATTENDACE section
	public function internship_attendance($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

		if($param1 == 'attendance_filter'){
			$internship_id = $this->input->post('internship_id');
			$student_id = $this->input->post('student_id');
			$internship = $this->db->get_where('internship', array('id' => $internship_id))->row_array();
			$page_data['internship_id'] = $internship_id;
			$page_data['student_id'] = $student_id;
			$page_data['company_id'] = $internship['company_id'];
			$page_data['month'] = $this->input->post('month');
			$page_data['start_date'] = $internship['start_date'];
			$page_data['end_date'] = $internship['end_date'];
	  
			$this->load->view('backend/student/internship_attendance/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'internship_attendance';
			$page_data['page_title'] = 'internship_attendance';
			$this->load->view('backend/index', $page_data);
		}
	}
  //END INTERNSHIP section	
	
	//MANAGE INTERNSHIP ATTENDACE STARTS
	public function update_internship_attendance($param1 = "", $param2 = "") {
		if ($param1 == 'create_attendance_internship') {
			$response = $this->user_model->update_internship_attendance();
			echo $response;
			redirect('student/dashboard');
		}
	}
	//MANAGE INTERNSHIP ATTENDACE ENDS

}
