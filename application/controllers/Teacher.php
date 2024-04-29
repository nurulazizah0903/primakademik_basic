<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/
require APPPATH.'third_party/phpoffice/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Teacher extends CI_Controller {

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
		
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
	}
	//dashboard
	public function index(){
		redirect(route('dashboard'), 'refresh');
	}

	public function dashboard($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){
		if($param1 == 'edit'){
			$page_data['student_id'] = $param2;
			$page_data['working_page'] = 'edit';
			$page_data['page_title'] = 'Dashboard';
			$page_data['folder_name'] = 'dashboard';
			$page_data['page_title'] = 'update_student_information';
			$this->load->view('backend/index', $page_data);
		}

		if($param1 == 'filter'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/teacher/student/list', $page_data);
		}

		if(empty($param1)){
			$page_data['working_page'] = 'filter';
			$page_data['page_title'] = 'Dashboard';
			$page_data['folder_name'] = 'dashboard';
			$this->load->view('backend/index', $page_data);
		}
		
		// $page_data['page_title'] = 'Dashboard';
		// $page_data['folder_name'] = 'dashboard';
		// $this->load->view('backend/index', $page_data);
	}

	//START STUDENT ADN ADMISSION section
	public function student($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){

		if($param1 == 'create'){
			//form view
			if($param2 == 'bulk'){
				$page_data['aria_expand'] = 'bulk';
				$page_data['working_page'] = 'create';
				$page_data['folder_name'] = 'student';
				$page_data['page_title'] = 'add_student';
				$this->load->view('backend/index', $page_data);
			}elseif($param2 == 'excel'){
				$page_data['aria_expand'] = 'excel';
				$page_data['working_page'] = 'create';
				$page_data['folder_name'] = 'student';
				$page_data['page_title'] = 'add_student';
				$this->load->view('backend/index', $page_data);
			}else{
				$page_data['aria_expand'] = 'single';
				$page_data['working_page'] = 'create';
				$page_data['folder_name'] = 'student';
				$page_data['page_title'] = 'add_student';
				$this->load->view('backend/index', $page_data);
			}
		}

		// form view
		if($param1 == 'edit'){
			$page_data['student_id'] = $param2;
			$page_data['working_page'] = 'edit';
			$page_data['folder_name'] = 'student';
			$page_data['page_title'] = 'update_student_information';
			$this->load->view('backend/index', $page_data);
		}

		//updated to database
		if($param1 == 'updated'){
			$response = $this->user_model->student_update($param2, $param3);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->user_model->delete_student($param2, $param3);
			echo $response;
		}

		if($param1 == 'filter'){
			$page_data['keyword'] = $this->input->post('keyword');
			
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['room_id'] = $this->input->post('room_id');
			$this->load->view('backend/teacher/student/list', $page_data);
		}
	
		if($param1 == 'list'){
		$this->load->view('backend/teacher/student/list');
		}

		if(empty($param1)){
			$page_data['working_page'] = 'filter';
			$page_data['folder_name'] = 'student';
			$page_data['page_title'] = 'student_list';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END STUDENT ADN ADMISSION section

	//START student_extracurricular secion
	public function student_extracurricular($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){

		if($param1 == 'create'){
		  $response = $this->crud_model->student_extracurricular_create();
		  echo $response;
		}
	
		if($param1 == 'update'){
		  $response = $this->crud_model->student_extracurricular_update($param2,$param3,$param4,$param5);
		  echo $response;
		}
	
		if ($param1 == 'student') {
		  $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
		  $this->load->view('backend/teacher/student/dropdown', $page_data);
		}
	
		// show data from database
		if ($param1 == 'filter') {
		  $page_data['class_id'] = $this->input->post('class_id');
			  $page_data['section_id'] = $this->input->post('section_id');
		  $page_data['room_id'] = $this->input->post('room_id');
		  $this->load->view('backend/teacher/student_extracurricular/list', $page_data);
		}
	
		if ($param1 == 'list') {
		  $this->load->view('backend/teacher/student_extracurricular/list');
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'student_extracurricular';
		  $page_data['page_title'] = 'student_extracurricular';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END student_extracurricular section

	//START CLASS_ROOM section
	public function class_room($param1 = '', $param2 = '', $param3 = ''){

		// PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
		if ($param1 == 'list') {
		  $this->load->view('backend/teacher/class_room/list');
		}
	
		if ($param1 == 'dropdown') {
		  $page_data['section_id'] = $param2;
		  $page_data['exclude'] = $param3;
		  $this->load->view('backend/teacher/class_room/dropdown', $page_data);
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'class_room';
		  $page_data['page_title'] = 'class_room';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END CLASS_ROOM section

	//START TEACHER section
	public function teacher($param1 = '', $param2 = '', $param3 = ''){


		if($param1 == 'create'){
			$response = $this->user_model->create_teacher();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->user_model->update_teacher($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$teacher_id = $this->db->get_where('teachers', array('user_id' => $param2))->row('id');
			$response = $this->user_model->delete_teacher($param2, $teacher_id);
			echo $response;
		}

		if ($param1 == 'list') {
			$this->load->view('backend/teacher/teacher/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'teacher';
			$page_data['page_title'] = 'techers';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END TEACHER section

	//START CLASS secion
	public function manage_class($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->class_create();
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->class_delete($param2);
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->class_update($param2);
			echo $response;
		}

		if($param1 == 'section'){
			$response = $this->crud_model->section_update($param2);
			echo $response;
		}

		// show data from database
		if ($param1 == 'list') {
			$this->load->view('backend/teacher/class/list');
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
			$this->load->view('backend/teacher/section/list', $page_data);
		}
	}
	//	SECTION ENDED

	//	district STARTED
	public function district_dropdown($action = "", $province_id = "", $user_id = "") {

		// PROVIDE A LIST OF district ACCORDING TO province_id ID
		if ($action == 'dropdown') {
		  $page_data['province_id'] = $province_id;
		  $this->load->view('backend/teacher/district/dropdown', $page_data);
		}
	
		if ($action == 'edit') {
		  $page_data['user_id'] = $user_id;
		  $this->load->view('backend/teacher/district/dropdown_edit', $page_data);
		}
	  }
	  //	district ENDED
	
	  //	districts STARTED
	  public function districts_dropdown($action = "", $district_id = "") {
	
		// PROVIDE A LIST OF districts ACCORDING TO district_id ID
		if ($action == 'dropdown') {
		  $page_data['district_id'] = $district_id;
		  $this->load->view('backend/teacher/districts/dropdown', $page_data);
		}
	  }
	  //	districts ENDED
	
	  //	ward STARTED
	  public function ward_dropdown($action = "", $districts_id = "") {
	
		// PROVIDE A LIST OF ward ACCORDING TO districts_id ID
		if ($action == 'dropdown') {
		  $page_data['districts_id'] = $districts_id;
		  $this->load->view('backend/teacher/ward/dropdown', $page_data);
		}
	  }
	  //	ward ENDED
	
	  //	postcode STARTED
	  public function postcode_dropdown($action = "", $districts_id = "") {
	
		// PROVIDE A LIST OF district ACCORDING TO districts_id ID
		if ($action == 'dropdown') {
		  $page_data['districts_id'] = $districts_id;
		  $this->load->view('backend/teacher/postcode/dropdown', $page_data);
		}
	  }
	  //	postcode ENDED

	//START SUBJECT section
	public function subject($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->subject_create();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->subject_update($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->subject_delete($param2);
			echo $response;
		}

		if($param1 == 'list'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$this->load->view('backend/teacher/subject/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'subject';
			$page_data['page_title'] = 'subject';
			$this->load->view('backend/index', $page_data);
		}
	}

	public function class_wise_subject($section_id) {

		// PROVIDE A LIST OF SUBJECT ACCORDING TO CLASS ID
		$page_data['section_id'] = $section_id;
		$this->load->view('backend/teacher/subject/dropdown', $page_data);
	}
	//END SUBJECT section

	//START KNOWLEDGE BASE section
	public function knowledge_base($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'create'){
		  $response = $this->crud_model->knowledge_base_create();
		  echo $response;
		}

		if($param1 == 'excel_base'){
			$response = $this->crud_model->upload_excel_knowledge_base();
			echo $response;
		}
	
		if($param1 == 'update'){
		  $response = $this->crud_model->knowledge_base_update($param2);
		  echo $response;
		}
	
		if($param1 == 'delete'){
		  $response = $this->crud_model->knowledge_base_delete($param2);
		  echo $response;
		}
	
		if($param1 == 'list'){
		  $page_data['subject_id'] = $param2;
		  $this->load->view('backend/teacher/knowledge_base/list', $page_data);
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'knowledge_base';
		  $page_data['page_title'] = 'knowledge_base';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	
	  public function subject_wise_base($action = "", $subject_id = "") {
	
		// PROVIDE A LIST OF KNOWLEDGE_BASE ACCORDING TO CLASS ID
		if ($action == 'list') {
			$page_data['subject_id'] = $subject_id;
			$this->load->view('backend/teacher/knowledge_base/dropdown', $page_data);
		}
	  }
	  //END KNOWLEDGE_BASE section

	//START SYLLABUS section
	public function syllabus($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->syllabus_create();
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->syllabus_delete($param2);
			echo $response;
		}

		if($param1 == 'list'){
			$this->load->view('backend/teacher/syllabus/list');
		  }
	  
		if($param1 == 'filter'){
		$page_data['subject_id'] = $this->input->post('subject_id');
		$this->load->view('backend/teacher/syllabus/list', $page_data);
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

		if($param1 == 'create'){
			$response = $this->crud_model->materials_create();
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->materials_delete($param2);
			echo $response;
		}

		if($param1 == 'list'){
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$page_data['subject_id'] = $param4;
			$this->load->view('backend/teacher/materials/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'materials';
			$page_data['page_title'] = 'materials';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END MATERIALS section

	//START QUESTION BANK section
	public function question_bank($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->question_bank_create();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->question_bank_update($param2);
			echo $response;
		}

		if($param1 == 'excel_question'){
			$response = $this->crud_model->excel_question_bank();
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->question_bank_delete($param2);
			echo $response;
		}

		if($param1 == 'list'){
			$this->load->view('backend/teacher/question_bank/list');
		}

		if($param1 == 'filter'){
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['subject_id'] = $this->input->post('subject_id');
			$page_data['base_id'] = $this->input->post('base_id');
			$this->load->view('backend/teacher/question_bank/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'question_bank';
			$page_data['page_title'] = 'question_bank';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END QUESTION BANK section

	//START CLASS ROUTINE section
	public function routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->routine_create();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->routine_update($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->routine_delete($param2);
			echo $response;
		}

		if($param1 == 'filter'){
		$page_data['class_id'] = $this->input->post('class_id');
		$page_data['section_id'] = $this->input->post('section_id');
		$page_data['room_id'] = $this->input->post('room_id');
		$this->load->view('backend/teacher/routine/list', $page_data);
		}
	
		if($param1 == 'list'){
		$this->load->view('backend/teacher/routine/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'routine';
			$page_data['page_title'] = 'routine';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END CLASS ROUTINE section

	//START CLASS SCHEDULE section
	public function schedule($param1 = '', $param2 = ''){
		if($param1 == 'filter'){
			$page_data['teacher_id'] = $param2;
			$this->load->view('backend/teacher/schedule/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'schedule';
			$page_data['page_title'] = 'schedule';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END CLASS SCHEDULE section

	//START DAILY ATTENDANCE section
	public function attendance($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'take_attendance'){
			$response = $this->crud_model->take_attendance();
			echo $response;
		}

		if($param1 == 'filter'){
			$date = '01 '.$this->input->post('month').' '.$this->input->post('year');
			$page_data['attendance_date'] = strtotime($date);
			$permission_id = $this->input->post('permission_id');
			$teacher_permissions = $this->db->get_where('teacher_permissions', array('id' => $permission_id))->row_array();
			$page_data['class_id'] = $teacher_permissions['class_id'];
			$page_data['section_id'] = $teacher_permissions['section_id'];
			$page_data['month'] = $this->input->post('month');
			$page_data['year'] = $this->input->post('year');
			$this->load->view('backend/teacher/attendance/list', $page_data);
		}

		if($param1 == 'confirm'){
			$response = $this->crud_model->confirm($param2);
			echo $response;
		}

    	if($param1 == 'confirm_all_student'){
			$response = $this->crud_model->confirm_all_student();
			echo $response;
		}

		if($param1 == 'student'){
			$page_data['attendance_date'] = strtotime($this->input->post('date'));
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['room_id'] = $this->input->post('room_id');
			$this->load->view('backend/teacher/attendance/student', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'attendance';
			$page_data['page_title'] = 'attendance';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END DAILY ATTENDANCE section

	//START DAILY ATTENDANCE ROUTINE section
	public function attendance_routine($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){

		if($param1 == 'take_attendance_routine'){
		  $response = $this->crud_model->take_attendance_routine();
		  echo $response;
		}
	
		if($param1 == 'filter'){
		  $date = '01 '.$this->input->post('month').' '.$this->input->post('year');
		  $page_data['attendance_date'] = strtotime($date);
		  $subejct_id = $this->input->post('subject_id');
		  $subject = $this->db->get_where('subjects', array('id' => $subejct_id))->row_array();

		  $page_data['class_id'] = $subject['class_id'];
		  $page_data['section_id'] = $subject['section_id'];
		  $page_data['subject_id'] = $subejct_id;
		  $page_data['month'] = $this->input->post('month');
		  $page_data['year'] = $this->input->post('year');
		  $this->load->view('backend/teacher/attendance_routine/list', $page_data);
		}

		if($param1 == 'confirm_routine'){
			$response = $this->crud_model->confirm_routine($param2);
			echo $response;
		}

    	if($param1 == 'confirm_all'){
			$response = $this->crud_model->confirm_all_routine();
			echo $response;
		}
	
		if($param1 == 'student'){
		  $page_data['attendance_date'] = strtotime($this->input->post('date'));
		  $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
		  $page_data['subject_id'] = $this->input->post('subject_id');
		  $page_data['room_id'] = $this->input->post('room_id');
		  $this->load->view('backend/teacher/attendance_routine/student', $page_data);
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'attendance_routine';
		  $page_data['page_title'] = 'attendance_routine';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END DAILY ATTENDANCE ROUTINE section

	//START DAILY ATTENDANCE employee
	public function attendance_employee($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){
	
		if($param1 == 'filter'){
		  $page_data['role'] = $this->input->post('role');
		  $page_data['month'] = $this->input->post('month');
		  $page_data['year'] = $this->input->post('year');
		  $page_data['attendance_date'] = '01 '.$this->input->post('month').' '.$this->input->post('year');
		  $this->load->view('backend/teacher/attendance_employee/list', $page_data);
		}
	
		if($param1 == 'confirm_employee'){
				$response = $this->crud_model->confirm_employee($param2);
				echo $response;
			}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'attendance_employee';
		  $page_data['page_title'] = 'attendance_employee';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END DAILY ATTENDANCE employee

	//START EVENT CALENDAR section
	public function event_calendar($param1 = '', $param2 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->event_calendar_create();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->event_calendar_update($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->event_calendar_delete($param2);
			echo $response;
		}

		if($param1 == 'all_events'){
			echo $this->crud_model->all_events();
		}

		if ($param1 == 'list') {
			$this->load->view('backend/teacher/event_calendar/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'event_calendar';
			$page_data['page_title'] = 'event_calendar';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END EVENT CALENDAR section


	//START EXAM section
	public function exam($param1 = '', $param2 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->exam_create();
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->crud_model->exam_update($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->exam_delete($param2);
			echo $response;
		}

		if ($param1 == 'list') {
			$this->load->view('backend/teacher/exam/list');
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'exam';
			$page_data['page_title'] = 'exam';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END EXAM section

	//START EXAM MARK section
	public function exam_mark($param1 = '', $param2 = '', $param3 = ''){

		if($param1 == 'list'){
		  $page_data['subject_id'] = $this->input->post('subject_id');
		  $page_data['exam_type_id'] = $this->input->post('exam_type_id');
		  $this->load->view('backend/teacher/exam_mark/list', $page_data);
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'exam_mark';
		  $page_data['page_title'] = 'exam_mark';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END EXAM MARK section
	
	  //START ASSIGNMENT MARK section
	  public function assignment_mark($param1 = '', $param2 = '', $param3 = ''){
	
		if($param1 == 'list'){
		  $page_data['subject_id'] = $this->input->post('subject_id');
		  $page_data['assignment_type_id'] = $this->input->post('assignment_type_id');
		  $this->load->view('backend/teacher/assignment_mark/list', $page_data);
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'assignment_mark';
		  $page_data['page_title'] = 'assignment_mark';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END ASSIGNMENT MARK section

	//START MARKS section
	public function mark($param1 = '', $param2 = ''){

		if($param1 == 'list'){
			$page_data['subject_id'] = $this->input->post('subject');
			$subject_id = $page_data['subject_id'];
			$subject_data = $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
			$section_data = $this->db->get_where('sections', array('id' => $subject_data['section_id']))->row_array();   

			$page_data['class_id'] = $section_data['class_id'];
			$page_data['section_id'] = $subject_data['section_id'];
			$page_data['room_id'] = $this->db->get_where('class_rooms', array('section_id' => $section_data['id']))->row('id');
			$this->crud_model->mark_insert($page_data['class_id'], $page_data['section_id'], $page_data['room_id'], $page_data['subject_id']);
			$this->load->view('backend/teacher/mark/list', $page_data);
		}

		if($param1 == 'mark_update'){
			$response = $this->crud_model->mark_update();
			echo $response;
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'mark';
			$page_data['page_title'] = 'marks';
			$this->load->view('backend/index', $page_data);
		}
	}

	// GET THE GRADE ACCORDING TO MARK
	public function get_grade($acquired_mark) {
		echo get_grade($acquired_mark);
	}
	//END MARKS sesction

	//START organizations section
	public function organizations($param1 = '', $param2 = ''){
	
		// PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
		if ($param1 == 'list') {
		  $this->load->view('backend/teacher/organizations/list');
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'organizations';
		  $page_data['page_title'] = 'organizations';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END organizations section

	//START MARKS ARCHIVES section
	public function marks_archives($param1 = '', $param2 = ''){

	if($param1 == 'list'){
		$page_data['class_id'] = $this->input->post('class_id');
		$page_data['section_id'] = $this->input->post('section_id');
		$page_data['semester_id'] = $this->input->post('semester_id');
		$page_data['student_id'] = $this->input->post('student_id');
		$page_data['session'] = $this->input->post('session');
		$this->load->view('backend/teacher/marks_archives/list', $page_data);
	}

	if ($param1 == 'student') {
		$page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
		$this->load->view('backend/teacher/student/dropdown', $page_data);
	}

	if(empty($param1)){
		$page_data['folder_name'] = 'marks_archives';
		$page_data['page_title'] = 'marks_archives';
		$this->load->view('backend/index', $page_data);
	}
	}
  //END MARKS ARCHIVES section

	// BACKOFFICE SECTION

	// ACCOUNTING SECTION STARTS
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
		  $this->load->view('backend/teacher/student/dropdown', $page_data);
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
		  $this->load->view('backend/teacher/invoice/list', $page_data);
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

	//BOOK LIST MANAGER
	public function book($param1 = "", $param2 = "") {
		// adding book
		if ($param1 == 'create') {
			$response = $this->crud_model->create_book();
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
			$this->load->view('backend/teacher/book/list');
		}

		// showing the index file
		if(empty($param1)){
			$page_data['folder_name'] = 'book';
			$page_data['page_title']  = 'books';
			$this->load->view('backend/index', $page_data);
		}
	}

	//BOOK ISSUE LIST MANAGER
	public function book_issue($param1 = "", $param2 = "") {
		if ($param1 == 'issue') {
			$page_data['page_name'] = 'index';
			$page_data['folder_name'] = 'book_issue';
			$page_data['page_title'] = 'book_issue';
			$this->load->view('backend/index', $page_data);
		}
		// showing the list of book
		if ($param1 == 'list') {
		  $this->load->view('backend/teacher/book_issue/list');
		}
		// showing the index file
		if(empty($param1)){
		  $page_data['folder_name'] = 'book_issue';
		  $page_data['page_title']  = 'book_issue';
		  $this->load->view('backend/index', $page_data);
		}

		// $page_data['folder_name'] = 'book_issue';
		// $page_data['page_title']  = 'issued_book';
		// $this->load->view('backend/index', $page_data);
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
		}
	}
	//MANAGE PROFILE ENDS

	//VISIT DATA LIST MANAGER
	public function infrastructure($param1 = "", $param2 = "") {

		// showing the list of infrastructure
		if ($param1 == 'list') {
		  $this->load->view('backend/superadmin/infrastructure/list');
		}
	
		// showing the index file
		if(empty($param1)){
		  $page_data['folder_name'] = 'infrastructure';
		  $page_data['page_title']  = 'infrastructure';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	
	  //infrastructure ISSUE LIST MANAGER
	  public function infrastructure_issue($param1 = "", $param2 = "") {
		
		// showing the list of infrastructure_issue
		if ($param1 == 'list') {
		  $this->load->view('backend/teacher/infrastructure_issue/list');
		}
	
		// showing the index file
		if(empty($param1)){
		  $page_data['folder_name'] = 'infrastructure_issue';
		  $page_data['page_title']  = 'infrastructure_issue';
		  $this->load->view('backend/index', $page_data);
		}
	  }

	  //means LIST MANAGER
  public function means($param1 = "", $param2 = "") {
    // showing the list of means
    if ($param1 == 'list') {
      $this->load->view('backend/teacher/means/list');
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'means';
      $page_data['page_title']  = 'means';
      $this->load->view('backend/index', $page_data);
    }
  }

  //START achievements section
  public function achievements($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->achievements_create();
      echo $response;
      // $this->session->set_flashdata('flash_message', get_phrase('added_successfully'));
      // redirect('backend/superadmin/achievements/list');
    }

    if($param1 == 'update'){
      $response = $this->crud_model->achievements_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->achievements_delete($param2);
      echo $response;
    }

    // Get the data from database
    if($param1 == 'list'){
      $this->load->view('backend/teacher/achievements/list');
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
	// adding routine_counseling
    if ($param1 == 'create_routine') {
		$response = $this->crud_model->create_routine_counseling();
		echo $response;
		// $this->session->set_flashdata('success_message', get_phrase('create_successfully'));
			// redirect(site_url($this->load->view('backend/superadmin/violations/list')), 'refresh');
	}

    if($param1 == 'create'){
      $response = $this->crud_model->violations_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->violations_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->violations_delete($param2);
      echo $response;
    }

    // Get the data from database
    if($param1 == 'list'){
      $this->load->view('backend/teacher/violations/list');
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
   
    if ($param1 == 'create') {
		$response = $this->crud_model->create_routine_counseling();
		echo $response;
		// $this->session->set_flashdata('success_message', get_phrase('create_successfully'));
			// redirect(site_url($this->load->view('backend/superadmin/routine_counseling/list')), 'refresh');
	  }
  
	  // update routine_counseling
	  if ($param1 == 'update') {
		$response = $this->crud_model->update_routine_counseling($param2);
		echo $response;
	  }
  
	  // Returning a routine_counseling
	  if ($param1 == 'status') {
		$response = $this->crud_model->status_routine_counseling($param2);
		echo $response;
	  }
  
	  // deleting routine_counseling
	  if ($param1 == 'delete') {
		$response = $this->crud_model->delete_routine_counseling($param2);
		echo $response;
	  }
  
	  // showing the list of routine_counseling
	  if ($param1 == 'list') {
		$this->load->view('backend/teacher/routine_counseling/list');
	  }
  
	if($param1 == 'filter'){
	$page_data['class_id'] = $this->input->post('class_id');
		$page_data['section_id'] = $this->input->post('section_id');
	$this->load->view('backend/teacher/routine_counseling/list', $page_data);
	}

	// Returning a routine_counseling
    if ($param1 == 'status') {
		$response = $this->crud_model->status_routine_counseling($param2);
		echo $response;
	  }

	// showing the index file
    if(empty($param1)){
		$page_data['folder_name'] = 'routine_counseling';
		$page_data['page_title']  = 'routine_counseling';
		$this->load->view('backend/index', $page_data);
	  }
  }

  //MEAN ISSUE LIST MANAGER
  public function mean_issue($param1 = "", $param2 = "") {
    // showing the list of mean
    if ($param1 == 'list') {
      $this->load->view('backend/teacher/mean_issue/list');
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'mean_issue';
      $page_data['page_title']  = 'mean_issue';
      $this->load->view('backend/index', $page_data);
    }
  }

	//Raport section
	public function raport($param1 = '', $param2 = '', $param3 = ''){
		// if($param1 == 'filter'){
		// 	$page_data['student_id'] = $param2;
		// 	$this->load->view('backend/superadmin/raport/list', $page_data);
		// }

		// adding raport
		if($param1 == 'create'){
		$page_data['student_id'] = $param2;
		$page_data['aria_expand'] = 'create_raport';
		$page_data['page_name'] = 'create_raport';
		$page_data['folder_name'] = 'raport';
		$page_data['page_title'] = 'create_raport';
		$this->load->view('backend/index', $page_data);
		}
		
		// adding infrastructure
		if ($param1 == 'create_raport') {
		$response = $this->crud_model->create_raport();
		echo $response;
		}

		// showing the list of print_raport
		if ($param1 == 'print_raport') {
		$page_data['raport_id'] = $param2;
		$page_data['folder_name'] = 'raport';
		$page_data['page_name'] = 'print_raport';
		$page_data['page_title']  = 'print_raport';
		$this->load->view('backend/index', $page_data);
		}

		if($param1 == 'filter'){
		$page_data['permission_id'] = $this->input->post('permission_id');
		$this->load->view('backend/teacher/raport/list', $page_data);
		}

		if($param1 == 'list'){
		$this->load->view('backend/teacher/raport/list');
		}

		if(empty($param1)){
			$page_data['student_id'] = $param2;
			$page_data['folder_name'] = 'raport';
			$page_data['page_title'] = 'raport';
			$this->load->view('backend/index', $page_data);
		}
	}

	//START EXPORT DATA section
	public function export_data($param1 = '', $param2 = '', $param3 = ''){

		$spreadsheet = new Spreadsheet;
		
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', 'Kelas');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('B1', 'Nama Siswa');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('C1', 'Waktu Mulai');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('D1', 'Waktu Selesai');
		$spreadsheet->setActiveSheetIndex(0)->setCellValue('E1', 'Total Nilai Bobot');

		$school_id = school_id();
		$this->db->select('id');
		$this->db->where('exam_id',$param1);
		$this->db->order_by('id',  'ASC');
		$this->db->from('exam_questions');
		$jumlah_soal = $this->db->get()->result_array();

		$char = range('E', 'Z');
		$i = 1;
		foreach ($jumlah_soal as $jml_soal) {
			$spreadsheet->setActiveSheetIndex(0)->setCellValue($char[$i].'1', 'Soal Nomor '.$i);
			$i++;
		}

		$data_siswa = $this->db->get_where('enrols', array('class_id' => $param2, 'section_id' => $param3, 'school_id' => $school_id, 'session' => active_session()))->result_array();

		$kolom = 2;
		$nomor = 1;
		foreach($data_siswa as $data) {

			$classes = $this->db->get_where('classes', array('id' => $data['class_id']))->row_array();
			$section = $this->db->get_where('sections', array('id' => $data['section_id']))->row_array();
			$student = $this->db->get_where('students', array('id' => $data['student_id']))->row_array();
			$user_details = $this->db->get_where('users', array('id' => $student['user_id']))->row_array();
			$exam_remark = $this->db->get_where('exam_remarks', array('exam_id' => $param1, 'student_id' => $student['user_id']))->row_array();

			$spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $kolom, $section['name'].' '.$classes['name']);
			$spreadsheet->setActiveSheetIndex(0)->setCellValue('B' . $kolom, $user_details['name']);

			if($exam_remark['start_exam'] == NULL OR $exam_remark['start_exam'] == FALSE) {
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, '-');
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, '-');
			} else {	
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('C' . $kolom, date('H:i:s A', $exam_remark['start_exam']));
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, date('H:i:s A', $exam_remark['finish_exam']));
			}

			if($exam_remark['total_mark'] == '' OR $exam_remark['total_mark'] == 0){
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, '0');
			} else {
				$spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $exam_remark['total_mark']);
			}
			
			$this->db->where('student_id', $student['user_id']);
			$this->db->where('exam_id', $param1);
			$this->db->order_by('question_id',  'ASC');
			$this->db->from('exam_answers');
			$jumlah_jawaban = $this->db->get()->result_array();	

			$char = range('E', 'Z');
			$i = 1;
			foreach ($jumlah_jawaban as $jawaban) {
				if($jawaban['answer'] == FALSE OR $jawaban['answer'] == ''){
					$spreadsheet->setActiveSheetIndex(0)->setCellValue($char[$i].$kolom, '-');
				} else {
					$spreadsheet->setActiveSheetIndex(0)->setCellValue($char[$i].$kolom, $jawaban['answer']);
				}
				$i++;
			}
			// $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $kolom, $user_details['name']);
			// $spreadsheet->setActiveSheetIndex(0)->setCellValue('E' . $kolom, $user_details['name']);

			$kolom++;
			$nomor++;

		}

		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Report Ujian.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}	

}
