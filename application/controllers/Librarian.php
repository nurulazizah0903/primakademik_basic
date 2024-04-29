<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/

class Librarian extends CI_Controller {
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
		
		// CHECK WHETHER LIBRARIAN IS LOGGED IN
		if($this->session->userdata('librarian_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
	}

	// INDEX FUNCTION
	public function index(){
		redirect(site_url('librarian/dashboard'), 'refresh');
	}

	//DASHBOARD
	public function dashboard(){
		$page_data['page_title'] = 'Dashboard';
		$page_data['folder_name'] = 'dashboard';
		$this->load->view('backend/index', $page_data);
	}

	// BACKOFFICE MANAGEMENT STARTS
	//START book_types section
	public function book_types($param1 = '', $param2 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->create_book_types();
			echo $response;
		}

		if($param1 == 'edit'){
			$response = $this->crud_model->update_book_types($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->delete_book_types($param2);
			echo $response;
		}

		if ($param1 == 'list') {
			$this->load->view('backend/librarian/book_type/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'book_type';
			$page_data['page_title'] = 'book_type';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END book_types section

	//BOOK LIST MANAGER
	public function book($param1 = "", $param2 = "") {
		// adding book
		if ($param1 == 'create') {
			$response = $this->crud_model->create_book();
			echo $response;
		}

		// showing the list of print_raport
		if ($param1 == 'ebook') {
			$page_data['book_id'] = $param2;
			$page_data['folder_name'] = 'book';
			$page_data['page_name'] = 'ebook';
			$page_data['page_title']  = 'ebook';
			$this->load->view('backend/index', $page_data);
		  }

		if($param1 == 'upload_excel_book'){
			$response = $this->crud_model->upload_excel_book();
			echo $response;
		  }

		// update book
		if ($param1 == 'update') {
			$response = $this->crud_model->update_book($param2);
			echo $response;
		}

		// deleting book
		if ($param1 == 'delete') {
			$response = $this->crud_model->delete_book($param2);
			echo $response;
		}
		// showing the list of book
		if ($param1 == 'list') {
			$this->load->view('backend/librarian/book/list');
		}

		// showing the index file
		if(empty($param1)){
			$page_data['folder_name'] = 'book';
			$page_data['page_title']  = 'books';
			$this->load->view('backend/index', $page_data);
		}
	}

	//BOOK ISSUE LIST MANAGER
	public function book_issue($param1 = "", $param2 = "", $param3 = "", $param4 = "") {
		// adding book
		if ($param1 == 'add') {
		  $response = $this->crud_model->create_book_issue();
		  echo $response;
		//   $response = json_decode($response);
		//   $this->session->set_flashdata('flash_message', $response->notification);
		//   redirect(site_url('superadmin/book_issue/issue'), 'refresh');
		}
	
		// // adding book_issue
		// if($param1 == 'create'){
		//   $page_data['aria_expand'] = 'create_book_issue';
		//   $page_data['page_name'] = 'create';
		//   $page_data['folder_name'] = 'book_issue';
		//   $page_data['page_title'] = 'create_book_issue';
		//   $this->load->view('backend/index', $page_data);
		// }
	
		// if ($param1 == 'create') {
		//   $response = $this->crud_model->create_book_issue();
		//   echo $response;
		// }
	
		// update book
		if ($param1 == 'update') {
		  $response = $this->crud_model->update_book_issue($param2);
		  echo $response;
		}
	
		// update book
		if ($param1 == 'due_date') {
		  $response = $this->crud_model->update_status_book_issue($param2);
		  echo $response;
		}
	
		if ($param1 == 'return') {
		  $response = $this->crud_model->return_issued_book($param2);
		  echo $response;
		}
	
		// // Returning a book
		// if ($param1 == 'return') {
		//   $response = $this->crud_model->return_issued_book($param2);
		//     // echo $response;
		//   $response = json_decode($response);
		//   $this->session->set_flashdata('flash_message', $response->notification);
		//   redirect(route('book_issue'), 'refresh');
		// }
	
		if ($param1 == 'role') {
		  $page_data['role'] = $param2;
		  $this->load->view('backend/librarian/book_issue/role', $page_data);
		}
	
		if ($param1 == 'student') {
		  $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
		  $this->load->view('backend/librarian/student/dropdown', $page_data);
		}
	
		// deleting book
		if ($param1 == 'delete') {
		  $response = $this->crud_model->delete_book_issue($param2);
		  echo $response;
		}
		// showing the list of book
		if ($param1 == 'list') {
		  $date = explode('-', $this->input->get('date'));
		  $page_data['date_from'] = strtotime($date[0].' 00:00:00');
		  $page_data['date_to']   = strtotime($date[1].' 23:59:59');
		  $this->load->view('backend/librarian/book_issue/list', $page_data);
			}
	
		if ($param1 == 'favorit') {
		  $page_data['page_name'] = 'favorit';
		  $page_data['folder_name'] = 'book_issue';
		  $page_data['page_title'] = 'favorit_book_list';
		  $this->load->view('backend/index', $page_data);
		}
	
		if ($param1 == 'deadline') {
		  $page_data['page_name'] = 'deadline';
		  $page_data['folder_name'] = 'book_issue';
		  $page_data['page_title'] = 'tenggat_waktu';
		  $this->load->view('backend/index', $page_data);
		}
	
		if ($param1 == 'issue') {
		  $page_data['page_name'] = 'issue';
		  $page_data['folder_name'] = 'book_issue';
		  $page_data['page_title'] = 'book_issue';
		  $this->load->view('backend/index', $page_data);
		}
	
		// showing the index file
		if(empty($param1)){
		  // $page_data['book_status_type'] = $param2;
		  $page_data['folder_name'] = 'book_issue';
		  $page_data['page_title']  = 'book_issue';
		  $page_data['date_from'] = strtotime(date('d-M-Y', strtotime(' -30 day')).' 00:00:00');
		  $page_data['date_to']   = strtotime(date('d-M-Y').' 23:59:59');
		  $this->load->view('backend/index', $page_data);
		}
	  }
	// BACKOFFICE MANAGEMENT ENDS

	//VISIT DATA LIST MANAGER
	public function visit_data($param1 = "", $param2 = "") {
		// adding visit_data
		if ($param1 == 'create') {
		  $response = $this->crud_model->create_visit_data();
		  echo $response;
		}
	
		// update visit_data
		if ($param1 == 'update') {
		  $response = $this->crud_model->update_visit_data($param2);
		  echo $response;
		}
	
		// deleting visit_data
		if ($param1 == 'delete') {
		  $response = $this->crud_model->delete_visit_data($param2);
		  echo $response;
		}
		// showing the list of visit_data
		if ($param1 == 'list') {
		  $this->load->view('backend/librarian/visit_data/list');
		}
	
		// showing the index file
		if(empty($param1)){
		  $page_data['folder_name'] = 'visit_data';
		  $page_data['page_title']  = 'visit_data';
		  $this->load->view('backend/index', $page_data);
		}
	  }

	//START STUDENT ADN ADMISSION section
	public function student($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = '', $param6 = '', $param7 = ''){
	
		if ($param1 == 'dropdown') {
			$page_data['enrolments'] = $this->user_model->get_student_details_by_id('class', $param2);
			$this->load->view('backend/librarian/student/dropdown', $page_data);
		}
		
		//updated to database
		if($param1 == 'id_card'){
		  $page_data['student_id'] = $param2;
		  $page_data['folder_nameq'] = 'student';
		  $page_data['page_title'] = 'identity_card';
		  $page_data['page_name'] = 'id_card';
		  $this->load->view('backend/index', $page_data);
		}
	
		if($param1 == 'delete'){
		  $response = $this->user_model->delete_one_student($param2, $param3, $param4, $param5);
		  echo $response;
		}
	
		if($param1 == 'filter'){
		  $page_data['keyword'] = $this->input->post('keyword');
		  
		  $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
		  $page_data['room_id'] = $this->input->post('room_id');
		  $this->load->view('backend/superadmin/student/list', $page_data);
		}
	
		if($param1 == 'list'){
		  $this->load->view('backend/superadmin/student/list');
		}
	
		if(empty($param1)){
		  $page_data['working_page'] = 'filter';
		  $page_data['folder_name'] = 'student';
		  $page_data['page_title'] = 'student_list';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	
	  // public function filter_student_list($param1 = ""){
		// 	$page_data['class_id'] = $this->input->post('class_id');
		// 	$page_data['section_id'] = $this->input->post('section_id');
		// 	$this->load->view('backend/superadmin/student/list', $page_data);
		// }
	  //END STUDENT ADN ADMISSION section

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
		}
	}
	//MANAGE PROFILE ENDS

	//	district STARTED
	public function district_dropdown($action = "", $province_id = "", $user_id = "") {

		// PROVIDE A LIST OF district ACCORDING TO province_id ID
		if ($action == 'dropdown') {
		  $page_data['province_id'] = $province_id;
		  $this->load->view('backend/librarian/district/dropdown', $page_data);
		}
	
		if ($action == 'edit') {
		  $page_data['user_id'] = $user_id;
		  $this->load->view('backend/librarian/district/dropdown_edit', $page_data);
		}
	  }
	  //	district ENDED
	
	  //	districts STARTED
	  public function districts_dropdown($action = "", $district_id = "") {
	
		// PROVIDE A LIST OF districts ACCORDING TO district_id ID
		if ($action == 'dropdown') {
		  $page_data['district_id'] = $district_id;
		  $this->load->view('backend/librarian/districts/dropdown', $page_data);
		}
	  }
	  //	districts ENDED
	
	  //	ward STARTED
	  public function ward_dropdown($action = "", $districts_id = "") {
	
		// PROVIDE A LIST OF ward ACCORDING TO districts_id ID
		if ($action == 'dropdown') {
		  $page_data['districts_id'] = $districts_id;
		  $this->load->view('backend/librarian/ward/dropdown', $page_data);
		}
	  }
	  //	ward ENDED
	
	  //	postcode STARTED
	  public function postcode_dropdown($action = "", $districts_id = "") {
	
		// PROVIDE A LIST OF district ACCORDING TO districts_id ID
		if ($action == 'dropdown') {
		  $page_data['districts_id'] = $districts_id;
		  $this->load->view('backend/librarian/postcode/dropdown', $page_data);
		}
	  }
	  //	postcode ENDED

	public function invoice($param1 = "", $param2 = "") {
		// For creating new invoice
		if ($param1 == 'single') {
		  $response = $this->crud_model->create_single_invoice();
		  echo $response;
		}
	
		// For creating new mass invoice
		if ($param1 == 'mass') {
		  $response = $this->crud_model->create_mass_invoice();
		  echo $response;
		}
	
		// For editing invoice
		if ($param1 == 'update') {
		  $response = $this->crud_model->update_invoice($param2);
		  echo $response;
		}
	
		// For deleting invoice
		if ($param1 == 'delete') {
		  $response = $this->crud_model->delete_invoice($param2);
		  echo $response;
		}
	
		// Get the list of student. Here param2 defines classId
		if ($param1 == 'student') {
		  $page_data['enrolments'] = $this->user_model->get_student_details_by_id('class', $param2);
		  $this->load->view('backend/librarian/student/dropdown', $page_data);
		}
	
		// showing the list of invoices
		if ($param1 == 'invoice') {
		  $page_data['invoice_id'] = $param2;
		  $page_data['folder_name'] = 'invoice';
		  $page_data['page_name'] = 'invoice';
		  $page_data['page_title']  = 'invoice';
		  $this->load->view('backend/index', $page_data);
		}
	
		// showing the list of invoices
		if ($param1 == 'list') {
		  $date = explode('-', $this->input->get('date'));
		  $page_data['date_from'] = strtotime($date[0].' 00:00:00');
		  $page_data['date_to']   = strtotime($date[1].' 23:59:59');
		  $page_data['selected_class'] = $this->input->get('selectedClass');
		  $page_data['selected_status'] = $this->input->get('selectedStatus');
		  $this->load->view('backend/librarian/invoice/list', $page_data);
		}
		// showing the index file
		if(empty($param1)){
		  $page_data['folder_name'] = 'invoice';
		  $page_data['page_title']  = 'invoice';
		  $first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
		  $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
		  $page_data['date_from']   = strtotime($first_day_of_month);
		  $page_data['date_to']     = strtotime($last_day_of_month);
		  $page_data['selected_class'] = 'all';
		  $page_data['selected_status'] = 'all';
		  $this->load->view('backend/index', $page_data);
		}
	  }
}
