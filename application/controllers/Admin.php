<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Creativeitem
*  date      : November, 2019
*  Ekattor School Management System With Addons
*  http://codecanyon.net/user/Creativeitem
*  http://support.creativeitem.com 
*/
require APPPATH.'third_party/phpoffice/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin extends CI_Controller {
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

    /*LOAD EXTERNAL LIBRARIES*/
    $this->load->library('pdf');

    if($this->session->userdata('admin_login') != 1){
      redirect(site_url('login'), 'refresh');
    } 
  }
  //dashboard
  public function index(){
    redirect(route('dashboard'), 'refresh');
  }

  public function dashboard(){

    // $this->msg91_model->clickatell();
    $page_data['page_title'] = 'Dashboard';
    $page_data['folder_name'] = 'dashboard';
    $this->load->view('backend/index', $page_data);
  }

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
      $this->load->view('backend/admin/class/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'class';
      $page_data['page_title'] = 'class';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END CLASS section

  //	SECTION STARTED
  public function section($action = "", $id = "", $exclude = "") {

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($action == 'list') {
      $page_data['class_id'] = $id;
      $page_data['exclude'] = $exclude;
      $this->load->view('backend/admin/section/list', $page_data);
    }
	 if ($action == 'list_finance') {
      $page_data['class_id'] = $id;
      $page_data['exclude'] = $exclude;
      $this->load->view('backend/admin/section/dropdown_finance', $page_data);
    } 

  } 
  //	SECTION ENDED

  //	district STARTED
  public function district_dropdown($action = "", $province_id = "", $user_id = "") {

    // PROVIDE A LIST OF district ACCORDING TO province_id ID
    if ($action == 'dropdown') {
      $page_data['province_id'] = $province_id;
      $this->load->view('backend/admin/district/dropdown', $page_data);
    }

    if ($action == 'edit') {
      $page_data['user_id'] = $user_id;
      $this->load->view('backend/admin/district/dropdown_edit', $page_data);
    }
  }
  //	district ENDED

  //	districts STARTED
  public function districts_dropdown($action = "", $district_id = "") {

    // PROVIDE A LIST OF districts ACCORDING TO district_id ID
    if ($action == 'dropdown') {
      $page_data['district_id'] = $district_id;
      $this->load->view('backend/admin/districts/dropdown', $page_data);
    }
  }
  //	districts ENDED

  //	ward STARTED
  public function ward_dropdown($action = "", $districts_id = "") {

    // PROVIDE A LIST OF ward ACCORDING TO districts_id ID
    if ($action == 'dropdown') {
      $page_data['districts_id'] = $districts_id;
      $this->load->view('backend/admin/ward/dropdown', $page_data);
    }
  }
  //	ward ENDED

  //	postcode STARTED
  public function postcode_dropdown($action = "", $districts_id = "") {

    // PROVIDE A LIST OF district ACCORDING TO districts_id ID
    if ($action == 'dropdown') {
      $page_data['districts_id'] = $districts_id;
      $this->load->view('backend/admin/postcode/dropdown', $page_data);
    }
  }
  //	postcode ENDED

  //START CLASS_ROOM section
  public function class_room($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->class_room_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->class_room_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->class_room_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/class_room/list');
    }

    if ($param1 == 'dropdown') {
      $page_data['section_id'] = $param2;
      $page_data['exclude'] = $param3;
      $this->load->view('backend/admin/class_room/dropdown', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'class_room';
      $page_data['page_title'] = 'class_room';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END CLASS_ROOM section

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
      $this->load->view('backend/admin/student/dropdown', $page_data);
    }

    // show data from database
    if ($param1 == 'filter') {
      $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
      $page_data['room_id'] = $this->input->post('room_id');
      $this->load->view('backend/admin/student_extracurricular/list', $page_data);
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/student_extracurricular/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'student_extracurricular';
      $page_data['page_title'] = 'student_extracurricular';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END student_extracurricular section

  //START extracurricular_participants secion
  public function extracurricular_participants($param1 = '', $param2 = '', $param3 = ''){

    // show data from database
    if ($param1 == 'filter') {
      $page_data['organizations_id'] = $this->input->post('organizations_id');
      $this->load->view('backend/admin/extracurricular_participants/list', $page_data);
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/extracurricular_participants/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'extracurricular_participants';
      $page_data['page_title'] = 'extracurricular_participants';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END extracurricular_participants section

  //START organizations section
  public function organizations($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->organizations_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->organizations_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->organizations_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/organizations/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'organizations';
      $page_data['page_title'] = 'organizations';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END organizations section

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

    if($param1 == 'filter'){
      $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
      $page_data['room_id'] = $this->input->post('room_id');
      $page_data['session_id'] = $this->input->post('session_id');
      $this->load->view('backend/admin/subject/list', $page_data);
    }

    if($param1 == 'list'){
      $this->load->view('backend/admin/subject/list');
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
    $this->load->view('backend/admin/subject/dropdown', $page_data);
  }
  //END SUBJECT section

  //START KNOWLEDGE BASE section
  public function knowledge_base($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->knowledge_base_create();
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
      $this->load->view('backend/admin/knowledge_base/list', $page_data);
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
			$this->load->view('backend/admin/knowledge_base/dropdown', $page_data);
		}
	  }
  //END KNOWLEDGE_BASE section

  //START EMPLOYEE_STATUS section
  public function employee_status($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->employee_status_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->employee_status_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->employee_status_delete($param2);
      echo $response;
    }

    // Get the data from database
    if($param1 == 'list'){
      $this->load->view('backend/admin/employee_status/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'employee_status';
      $page_data['page_title'] = 'employee_status';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END EMPLOYEE_STATUS section

  //START DEPARTMENT section
  public function department($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->department_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->department_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->department_delete($param2);
      echo $response;
    }

    // Get the data from database
    if($param1 == 'list'){
      $this->load->view('backend/admin/department/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'department';
      $page_data['page_title'] = 'department';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END DEPARTMENT section

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
      $this->load->view('backend/admin/syllabus/list');
    }

    if($param1 == 'filter'){
      $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
      $page_data['room_id'] = $this->input->post('room_id');
      $this->load->view('backend/admin/syllabus/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'syllabus';
      $page_data['page_title'] = 'syllabus';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END SYLLABUS section

  //START MATERIALS section
	public function materials($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = ''){

		if($param1 == 'create'){
			$response = $this->crud_model->materials_create();
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->crud_model->materials_delete($param2);
			echo $response;
		}

		if($param1 == 'filter'){
      $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
      $page_data['room_id'] = $this->input->post('room_id');
		  $page_data['subject_id'] = $this->input->post('subject_id');
			$this->load->view('backend/admin/materials/list', $page_data);
		}

    if($param1 == 'list'){
			$this->load->view('backend/admin/materials/list');
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
			$this->load->view('backend/admin/question_bank/list');
		}

		if($param1 == 'filter'){
			$page_data['class_id'] = $this->input->post('class_id');
			$page_data['section_id'] = $this->input->post('section_id');
			$page_data['subject_id'] = $this->input->post('subject_id');
			$page_data['base_id'] = $this->input->post('base_id');
			$this->load->view('backend/admin/question_bank/list', $page_data);
		}

		if(empty($param1)){
			$page_data['folder_name'] = 'question_bank';
			$page_data['page_title'] = 'question_bank';
			$this->load->view('backend/index', $page_data);
		}
	}
	//END QUESTION BANK section

  // START ADMIN SECTION
  public function admin($param1 = "", $param2 = "", $param3 = "") {
    if($param1 == 'create'){
      $response = $this->user_model->create_admin();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->update_admin($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->delete_admin($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/admin/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'admin';
      $page_data['page_title'] = 'admins';
      $this->load->view('backend/index', $page_data);
    }
  }
  // END ADMIN SECTION   

  // START employee_mutation SECTION
  public function employee_mutation($param1 = "", $param2 = "", $param3 = "") {
    if($param1 == 'create'){
      $response = $this->user_model->create_employee_mutation();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->update_employee_mutation($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->delete_employee_mutation($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/employee_mutation/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'employee_mutation';
      $page_data['page_title'] = 'employee_mutation';
      $this->load->view('backend/index', $page_data);
    }
  }
  // END employee_mutation SECTION   

  //START TEACHER section
  public function teacher($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->create_teacher();
      echo $response;
    }

    // form view
    if($param1 == 'edit'){
      $page_data['teacher_id'] = $param2;
      $page_data['folder_name'] = 'teacher';
      $page_data['page_title'] = 'update_teacher_information';
      $page_data['page_name'] = 'update';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'update_employee'){
      $response = $this->user_model->update_employee_teacher($param2);
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
      $this->load->view('backend/admin/teacher/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'teacher';
      $page_data['page_title'] = 'techers';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END TEACHER section

  //START EXAM MARK section
  public function exam_mark($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'list'){
      $page_data['subject_id'] = $this->input->post('subject_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $page_data['exam_type_id'] = $this->input->post('exam_type_id');
      $this->load->view('backend/admin/exam_mark/list', $page_data);
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
      $page_data['section_id'] = $this->input->post('section_id');
      $page_data['assignment_type_id'] = $this->input->post('assignment_type_id');
      $this->load->view('backend/admin/assignment_mark/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'assignment_mark';
      $page_data['page_title'] = 'assignment_mark';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END ASSIGNMENT MARK section

  //START HOMEROOM section
  public function homeroom($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'list'){
      $this->load->view('backend/admin/homeroom/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'homeroom';
      $page_data['page_title'] = 'homeroom';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END HOMEROOM section

  //START TEACHER PERMISSION section
  public function permission($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'filter'){
      $page_data['class_id'] = $param2;
      $page_data['section_id'] = $param3;
      $this->load->view('backend/admin/permission/list', $page_data);
    }

    if($param1 == 'modify_permission'){
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $this->user_model->teacher_permission();
      $this->load->view('backend/admin/permission/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'permission';
      $page_data['page_title'] = 'teacher_permissions';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END TEACHER PERMISSION section

  //START PARENT section
  public function parent($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->parent_create();
      echo $response;
    }

    if($param1 == 'edit'){
      $page_data['parent_id'] = $param2;
      $page_data['folder_name'] = 'parent';
      $page_data['page_title'] = 'update_parent_information';
      $page_data['page_name'] = 'update';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'update'){
      $response = $this->user_model->parent_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->parent_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/admin/parent/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'parent';
      $page_data['page_title'] = 'parent';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END PARENT section

  //START GUARDIAN section
  public function guardian($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->guardian_create();
      echo $response;
    }

    if($param1 == 'edit'){
      $page_data['guardian_id'] = $param2;
      $page_data['folder_name'] = 'guardian';
      $page_data['page_title'] = 'update_guardian_information';
      $page_data['page_name'] = 'update';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'update'){
      $response = $this->user_model->guardian_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->guardian_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/admin/guardian/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'guardian';
      $page_data['page_title'] = 'guardian';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END GUARDIAN section

  //START ACCOUNTANT section
  public function accountant($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->accountant_create();
      echo $response;
    }

    if($param1 == 'edit'){
      $page_data['accountant_id'] = $param2;
      // $page_data['working_page'] = 'edit';
      $page_data['folder_name'] = 'accountant';
      $page_data['page_title'] = 'update_accountant_information';
      $page_data['page_name'] = 'update';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'update_employee'){
      $response = $this->user_model->update_employee_accountant($param2);
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->accountant_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->accountant_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/admin/accountant/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'accountant';
      $page_data['page_title'] = 'accountant';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END ACCOUNTANT section

  //START other_employee section
  public function other_employee($param1 = '', $param2 = ''){

    if($param1 == 'edit'){
      $page_data['other_employee_id'] = $param2;
      // $page_data['working_page'] = 'edit';
      $page_data['folder_name'] = 'other_employee';
      $page_data['page_title'] = 'update_other_employee_information';
      $page_data['page_name'] = 'update';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'update_employee'){
      $response = $this->user_model->update_employee_other_employee($param2);
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->other_employee_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->other_employee_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/admin/other_employee/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'other_employee';
      $page_data['page_title'] = 'other_employee';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END other_employee section

  //START LIBRARIAN section
  public function librarian($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->user_model->librarian_create();
      echo $response;
    }

    if($param1 == 'edit'){
      $page_data['librarian_id'] = $param2;
      // $page_data['working_page'] = 'edit';
      $page_data['folder_name'] = 'librarian';
      $page_data['page_title'] = 'update_librarian_information';
      $page_data['page_name'] = 'update';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'update_employee'){
      $response = $this->user_model->update_employee_librarian($param2);
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->user_model->librarian_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->user_model->librarian_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/admin/librarian/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'librarian';
      $page_data['page_title'] = 'librarian';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END LIBRARIAN section

  //START CLASS ROUTINE section
  public function routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    // if($param1 == 'create'){
    //   $response = $this->crud_model->routine_create();
    //   echo $response;
    // }

    // adding book
    if ($param1 == 'add') {
      $response = $this->crud_model->routine_create();
      // echo $response;
      $response = json_decode($response);
      $this->session->set_flashdata('flash_message', $response->notification);
      redirect(route('routine'), 'refresh');
    }

    // adding book_issue
    if($param1 == 'create'){
      $page_data['aria_expand'] = 'routine';
      $page_data['page_name'] = 'create';
      $page_data['folder_name'] = 'routine';
      $page_data['page_title'] = 'create_routine';
      $this->load->view('backend/index', $page_data);
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
      $this->load->view('backend/admin/routine/list', $page_data);
    }

    if($param1 == 'list'){
      $this->load->view('backend/admin/routine/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'routine';
      $page_data['page_title'] = 'routine';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END CLASS ROUTINE section

  //START ROUTINE_EXTRACULICULER section
  public function routine_extracurricular($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->routine_extracurricular_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->routine_extracurricular_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->routine_extracurricular_delete($param2);
      echo $response;
    }

    if($param1 == 'filter'){
      $page_data['organizations_id'] = $param2;
      $this->load->view('backend/admin/routine_extracurricular/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'routine_extracurricular';
      $page_data['page_title'] = 'routine_extracurricular';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END ROUTINE_EXTRACULICULER section

  //START STUDENT ATTENDANCE section
  public function attendance_report($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if($param1 == 'filter'){
      $date = explode('-', $this->input->post('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59');

      $date = '01 '.$this->input->post('month').' '.$this->input->post('year');
      $page_data['attendance_date'] = strtotime($date);
      $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
      $page_data['month'] = $this->input->post('month');
      $page_data['year'] = $this->input->post('year');
      $this->load->view('backend/admin/attendance_report/list', $page_data);
    }

    if($param1 == 'list'){
      $this->load->view('backend/admin/attendance_report/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'attendance_report';
      $page_data['page_title'] = 'attendance_report';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END STUDENT ATTENDANCE section

  //START DAILY ATTENDANCE section
  public function attendance($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if($param1 == 'take_attendance'){
      $response = $this->crud_model->take_attendance();
      echo $response;
    }

    if($param1 == 'filter'){
      $date = '01 '.$this->input->post('month').' '.$this->input->post('year');
      $page_data['attendance_date'] = strtotime($date);
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $page_data['month'] = $this->input->post('month');
      $page_data['year'] = $this->input->post('year');
      $this->load->view('backend/admin/attendance/list', $page_data);
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
      $this->load->view('backend/admin/attendance/student', $page_data);
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
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $page_data['subject_id'] = $this->input->post('subject_id');
      $page_data['month'] = $this->input->post('month');
      $page_data['year'] = $this->input->post('year');
      $this->load->view('backend/admin/attendance_routine/list', $page_data);
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
      $this->load->view('backend/admin/attendance_routine/student', $page_data);
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

    if($param1 == 'take_attendance_employee'){
      $response = $this->crud_model->take_attendance_employee();
      echo $response;
    }

    if($param1 == 'filter'){
      $page_data['role'] = $this->input->post('role');
      $page_data['month'] = $this->input->post('month');
      $page_data['year'] = $this->input->post('year');
      $page_data['attendance_date'] = '01 '.$this->input->post('month').' '.$this->input->post('year');
      $this->load->view('backend/admin/attendance_employee/list', $page_data);
    }

    if($param1 == 'confirm_employee'){
			$response = $this->crud_model->confirm_employee($param2);
			echo $response;
		}

    if($param1 == 'confirm_all'){
			$response = $this->crud_model->confirm_all_employee();
			echo $response;
		}

    if($param1 == 'employee'){
      $page_data['attendance_date'] = strtotime($this->input->post('date'));
      $page_data['role'] = $this->input->post('role');
      $this->load->view('backend/admin/attendance_employee/employee', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'attendance_employee';
      $page_data['page_title'] = 'attendance_employee';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END DAILY ATTENDANCE employee

  // //START DAILY ATTENDANCE teacher
  public function attendance_teacher($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'take_attendance_teacher'){
      $response = $this->crud_model->take_attendance_teacher();
      echo $response;
    }

    if($param1 == 'filter'){
      $date = '01 '.$this->input->post('month').' '.$this->input->post('year');
      $page_data['attendance_date'] = strtotime($date);
      $page_data['month'] = $this->input->post('month');
      $page_data['year'] = $this->input->post('year');
      $this->load->view('backend/admin/attendance_teacher/list', $page_data);
    }

    if($param1 == 'teacher'){
      $page_data['attendance_date'] = strtotime($this->input->post('date'));
      $this->load->view('backend/admin/attendance_teacher/teacher', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'attendance_teacher';
      $page_data['page_title'] = 'attendance_teacher';
      $this->load->view('backend/index', $page_data);
    }
  }
  // //END DAILY ATTENDANCE teacher

  // //START DAILY ATTENDANCE librarian
  public function attendance_librarian($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'take_attendance_librarian'){
      $response = $this->crud_model->take_attendance_librarian();
      echo $response;
    }

    if($param1 == 'filter'){
      $date = '01 '.$this->input->post('month').' '.$this->input->post('year');
      $page_data['attendance_date'] = strtotime($date);
      $page_data['month'] = $this->input->post('month');
      $page_data['year'] = $this->input->post('year');
      $this->load->view('backend/admin/attendance_librarian/list', $page_data);
    }

    if($param1 == 'librarian'){
      $page_data['attendance_date'] = strtotime($this->input->post('date'));
      $this->load->view('backend/admin/attendance_librarian/librarian', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'attendance_librarian';
      $page_data['page_title'] = 'attendance_librarian';
      $this->load->view('backend/index', $page_data);
    }
  }
  // //END DAILY ATTENDANCE librarian

  // //START DAILY ATTENDANCE accountant
  public function attendance_accountant($param1 = '', $param2 = '', $param3 = ''){

    if($param1 == 'take_attendance_accountant'){
      $response = $this->crud_model->take_attendance_accountant();
      echo $response;
    }

    if($param1 == 'filter'){
      $date = '01 '.$this->input->post('month').' '.$this->input->post('year');
      $page_data['attendance_date'] = strtotime($date);
      $page_data['month'] = $this->input->post('month');
      $page_data['year'] = $this->input->post('year');
      $this->load->view('backend/admin/attendance_accountant/list', $page_data);
    }

    if($param1 == 'accountant'){
      $page_data['attendance_date'] = strtotime($this->input->post('date'));
      $this->load->view('backend/admin/attendance_accountant/accountant', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'attendance_accountant';
      $page_data['page_title'] = 'attendance_accountant';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END DAILY ATTENDANCE accountant

  //START awards section
  public function awards($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->awards_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->awards_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->awards_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/awards/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'awards';
      $page_data['page_title'] = 'awards';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END awards section

  //START achievements section
  public function achievements($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->achievements_create();
      echo $response;
      // $this->session->set_flashdata('flash_message', get_phrase('added_successfully'));
      // redirect('backend/admin/achievements/list');
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
      $this->load->view('backend/admin/achievements/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'achievements';
      $page_data['page_title'] = 'achievements';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END achievements section

  //START mistakes section
  public function mistakes($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->mistakes_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->mistakes_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->mistakes_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/mistakes/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'mistakes';
      $page_data['page_title'] = 'mistakes';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END mistakes section

  //START violations section
  public function violations($param1 = '', $param2 = ''){

  // adding routine_counseling
  if ($param1 == 'create_routine') {
    $response = $this->crud_model->create_routine_counseling();
    echo $response;
    // $this->session->set_flashdata('success_message', get_phrase('create_successfully'));
    // redirect(site_url($this->load->view('backend/admin/violations/list')), 'refresh');
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
      $this->load->view('backend/admin/violations/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'violations';
      $page_data['page_title'] = 'violations';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END violations section

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
      $this->load->view('backend/admin/event_calendar/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'event_calendar';
      $page_data['page_title'] = 'event_calendar';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END EVENT CALENDAR section

  //START ANNONCEMENT section
  public function announcement($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->announcement_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->announcement_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->announcement_delete($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/announcement/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'announcement';
      $page_data['page_title'] = 'announcement';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END ANNONCEMENT section

  //START REGISTRATION section
  public function registration($action = '', $param2 = '', $param3 = '') {

    // SHOW LIST PAGE
    if ($action == 'create') {
      if ($param2 == 'admitted') {
        $page_data['aria_expand'] = 'admitted';
        $page_data['working_page'] = $action;
        $page_data['folder_name'] = 'registration';
        $page_data['page_title'] = 'ppdb';
        $this->load->view('backend/index', $page_data);
      } elseif ($param2 == 'selection') {
        $page_data['aria_expand'] = 'selection';
        $page_data['working_page'] = $action;
        $page_data['folder_name'] = 'registration';
        $page_data['page_title'] = 'ppdb';
        $this->load->view('backend/index', $page_data);
      } elseif ($param2 == 'processed') {
          $page_data['aria_expand'] = 'processed';
          $page_data['working_page'] = $action;
          $page_data['folder_name'] = 'registration';
          $page_data['page_title'] = 'ppdb';
          $this->load->view('backend/index', $page_data);
      } elseif ($param2 == 'bulk') {
        $page_data['aria_expand'] = 'bulk';
        $page_data['working_page'] = $action;
        $page_data['folder_name'] = 'registration';
        $page_data['page_title'] = 'ppdb';
        $this->load->view('backend/index', $page_data);
      } else {
        $page_data['aria_expand'] = 'registration';
        $page_data['working_page'] = $action;
        $page_data['folder_name'] = 'registration';
        $page_data['page_title'] = 'ppdb';
        $this->load->view('backend/index', $page_data);
      }
    }

    // update db
    if ($action == 'update') {
      // foreach ($_POST as $key => $val) {
      //   $data[$key] = html_escape($this->input->post($key));
      // }

      $data['status'] = $this->input->post('status');
      $data['ket'] = $this->input->post('ket');

      $this->db->where('id', $param2);
      $this->db->update('registrations', $data);

      $history_data['ket'] = 'Update data registrations '.$param2.'';
      $history_data['id_user'] = $this->session->set_userdata('user_id');
      $this->db->insert('history', $history_data);


      $finances['registrations_kode'] = $this->input->post('kode_registrasi');
      $finances['registrations_name'] = $this->input->post('nama_lengkap');
      $finances['registrations_nisn'] = $this->input->post('nisn');
      $finances['registrations_id'] = $this->input->post('id');
      $finances['file'] = $this->input->post('bukti_bayar');
      $finances['school_id']	= school_id();
      $finances['session_id']	= active_session(); 
      $finances['date']			= strtotime(date('d-M-Y'));  
      $finances['created_at']	= strtotime(date('d-M-Y'));
      $finances['status']		= 1;

      if ($data['status'] == "Accepted") {
        $check_data = $this->db->get_where('finances', array('registrations_id' => $finances['registrations_id']));
        if($check_data->num_rows() > 0){
          
        }else{
          $this->db->insert('finances', $finances);
			
          $history_data['ket'] = 'Mengisi data finances';
          $history_data['id_user'] = $this->session->set_userdata('user_id');
          $this->db->insert('history', $history_data);
        }
      }else{
        
      }

      // $this->session->set_flashdata('flash_message', $response->notification);
      $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
      // redirect(site_url('superadmin/registration/create/'.$param3), 'refresh');
      // redirect(base_url()."superadmin/registration/create");
      // $this->load->site_url('superadmin/registration/create/'.$param3);
      // route('registration');
      // redirect(site_url('superadmin/registration/create/'.$param3), 'refresh');
    }

    if ($action == 'pay') {
      $id = $param2;
      $status = $this->input->post('status');
      $_total = $this->input->post('amount_ppdb');
      $v_satu = $this->input->post('v_satu');
      $v_dua = $this->input->post('v_dua');
      $date = date("Y-m-d");
      $_ket = $this->input->post('ket');
      $kode_registrasi = $this->db->get_where('registrations', array('id' => $id))->row_array();
      $registration_path = $this->db->get_where('registration_path', array('id' => $kode_registrasi['jalur_pendaftaran']))->row_array();
      $file_ext = pathinfo($_FILES['bukti_bayar']['name'], PATHINFO_EXTENSION);

      if(!empty($file_ext)){
        $bukti_bayar = md5(rand(10000000, 20000000)).'.'.$file_ext;
        move_uploaded_file($_FILES['bukti_bayar']['tmp_name'], 'uploads/registrations/'.$bukti_bayar);
      }elseif (empty($file_ext)) {
        $bukti_bayar = null;
      }

      $data_update['status'] = $status;
      $this->db->where('id', $id);
      $this->db->update('registrations', $data_update);

      $history_data['ket'] = 'Update data registrations '.$id.'';
      $history_data['id_user'] = $this->session->set_userdata('user_id');
      $this->db->insert('history', $history_data);

      if (!empty($v_satu)) {
        $data_insert['kode_registrasi'] = $id;
        $data_insert['date'] = $date;
        $data_insert['ket'] = 'Voucher';
        $data_insert['total'] = '400000';
        $data_insert['voucher'] = $registration_path['total'] - '400000';
        $data_insert['datetime'] = date('d-m-Y H:i:s');
        $data_insert['description'] = ''.$this->session->userdata('user_id').' User melakukan Transaksi Tanggal dan waktu '.date('d-m-Y H:i:s').'';
        $data_insert['id_user'] = $this->session->userdata('user_id');
        $this->db->insert('payment_ppdb', $data_insert);
			
        $history_data['ket'] = 'Mengisi data payment ppdb';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
      }
      if(!empty($v_dua)){
        $data_insert['kode_registrasi'] = $id;
        $data_insert['date'] = $date;
        $data_insert['ket'] = 'Voucher';
        $data_insert['total'] = '300000';
        $data_insert['voucher'] = $registration_path['total'] - '300000';
        $data_insert['datetime'] = date('d-m-Y H:i:s');
        $data_insert['description'] = ''.$this->session->userdata('user_id').' User melakukan Transaksi Tanggal dan waktu '.date('d-m-Y H:i:s').'';
        $data_insert['id_user'] = $this->session->userdata('user_id');
        $this->db->insert('payment_ppdb', $data_insert);
			
        $history_data['ket'] = 'Mengisi data payments ppdb';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
      }
      
      for($i = 0; $i < count($_total)-1; $i++) {
        $total = $_total[$i];
        $ket = $_ket[$i];

        $data_insert['kode_registrasi'] = $id;
        $data_insert['date'] = $date;
        $data_insert['ket'] = $ket;
        $data_insert['total'] = $total;
        $data_insert['voucher'] = $registration_path['total'] - $total;
        $data_insert['file'] = $bukti_bayar;
        $data_insert['datetime'] = date('d-m-Y H:i:s');
        $data_insert['description'] = ''.$this->session->userdata('user_id').' User melakukan Transaksi Tanggal dan waktu '.date('d-m-Y H:i:s').'';
        $data_insert['id_user'] = $this->session->userdata('user_id');
        $this->db->insert('payment_ppdb', $data_insert);
			
        $history_data['ket'] = 'Mengisi data payment ppdb';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
      }

      $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
      redirect(base_url()."admin/registration/create/");
    }

    if ($action == 'update_status') {
      $response = $this->user_model->update_status();
      // echo $response;
      // $response = json_decode($response);
      // $this->session->set_flashdata('flash_message', $response->notification);
      $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
      redirect(site_url('admin/registration/create/'.$param2), 'refresh');
    } 

    if($action == 'ppdb_enroll_single_student') {
      $response = $this->user_model->ppdb_users_create();

      // FOR DEBUGGING
      // $response = array(
      //   'status' => true,
      //   'notifications' => 'Sukses',
      // );

      echo json_encode($response);
    }

    if($action == 'ppdb_enroll_bulk_student') {
      
      // FOR DEBUGGING
      $response = array(
        'status' => true,
        'notifications' => 'Sukses Enroll',
        'form' => $_POST,
        'data' => $this->user_model->ppdb_users_create_bulk(),
      );

      $added = count($response['data']);
      $response['notifications'] = 'Sukses enroll ' . $added . ' siswa';

      echo json_encode($response);
    }

    if($action == 'get_admitted_students_list') {
      return $this->load->view('backend/admin/registration/student_list');
    }

    if($action == 'refresh_bulk_student_admission') {
      return $this->load->view('backend/admin/registration/bulk_student_admission');
    }

    if($action == 'list') {
      $ppdb_id = $param2;
      $query = $this->db->get_where('registrations', array('id' => $ppdb_id))->result_array();
      echo json_encode($query[0]);
    }
  }
  //END REGISTRATION section 


  //START STUDENT ADN ADMISSION section
  public function student($param1 = '', $param2 = '', $param3 = '', $param4 = '', $param5 = '', $param6 = '', $param7 = ''){

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
      }elseif($param2 == 'just_student'){
        $page_data['aria_expand'] = 'just_student';
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

    //create to database
    if($param1 == 'create_single_student'){
      $response = $this->user_model->single_student_create();
      echo $response;
    }

    if ($param1 == 'detail_student') {   
      $parents = $this->db->get_where('parents', array('id' => $param2))->result_array();   
      foreach($parents as $parent){
        $user_parent = $this->db->get_where('users', array('id' => $parent['user_id']))->row_array();
        $parent_province = $this->db->get_where('province', array('id' => $user_parent['province_id']))->row_array();
        $parent_district = $this->db->get_where('district', array('id' => $user_parent['district_id']))->row_array();
        $parent_districts = $this->db->get_where('districts', array('id' => $user_parent['districts_id']))->row_array();
        $parent_ward = $this->db->get_where('ward', array('id' => $user_parent['ward_id']))->row_array();   
        $parent_postcode = $this->db->get_where('postcode', array('postcode' => $user_parent['post_code']))->row_array();
        $student = $this->db->get_where('students', array('parent_id' => $parent['id']))->row_array();   
        $guardian = $this->db->get_where('guardians', array('id' => $student['guardian_id']))->row_array();   
        $user_guardian = $this->db->get_where('users', array('id' => $guardian['user_id']))->row_array();   
        $guardian_province = $this->db->get_where('province', array('id' => $user_guardian['province_id']))->row_array();
        $guardian_district = $this->db->get_where('district', array('id' => $user_guardian['district_id']))->row_array();
        $guardian_districts = $this->db->get_where('districts', array('id' => $user_guardian['districts_id']))->row_array();
        $guardian_ward = $this->db->get_where('ward', array('id' => $user_guardian['ward_id']))->row_array();   
        $guardian_postcode = $this->db->get_where('postcode', array('postcode' => $user_guardian['post_code']))->row_array();
        
        if (empty($user_parent['nik'])) {
          $data1 = get_phrase('empty_data');
        } else {
          $data1 = $user_parent['nik']; 
        }

        if (empty($user_parent['gender'])) {
          $data2 = get_phrase('empty_data');
        } else {
          $data2 = $user_parent['gender']; 
        }

        if (empty($user_parent['religion'])) {
          $data3 = get_phrase('empty_data');
        } else {
          $data3 = $user_parent['religion']; 
        }

        if (empty($user_parent['name'])) {
          $data4 = get_phrase('empty_data');
        } else {
          $data4 = $user_parent['name']; 
        }

        if (empty($user_parent['email'])) {
          $data5 = get_phrase('empty_data');
        } else {
          $data5 = $user_parent['email']; 
        }

        if (empty($user_parent['password'])) {
          $data6 = get_phrase('empty_data');
        } else {
          $data6 = $user_parent['password']; 
        }

        if (empty($user_parent['phone'])) {
          $data7 = get_phrase('empty_data');
        } else {
          $data7 = $user_parent['phone']; 
        }

        if (empty($user_parent['blood_group'])) {
          $data8 = get_phrase('empty_data');
        } else {
          $data8 = $user_parent['blood_group']; 
        }

        if (empty($parent_province['name'])) {
          $data9 = get_phrase('empty_data');
        } else {
          $data9 = $parent_province['name']; 
        }

        if (empty($parent_district['name'])) {
          $data10 = get_phrase('empty_data');
        } else {
          $data10 = $parent_district['name']; 
        }

        if (empty($parent_districts['name'])) {
          $data11 = get_phrase('empty_data');
        } else {
          $data11 = $parent_districts['name']; 
        }

        if (empty($parent_ward['name'])) {
          $data12 = get_phrase('empty_data');
        } else {
          $data12 = $parent_ward['name']; 
        }

        if (empty($user_parent['address'])) {
          $data13 = get_phrase('empty_data');
        } else {
          $data13 = $user_parent['address']; 
        }

        if (empty($parent_postcode['postcode'])) {
          $data14 = get_phrase('empty_data');
        } else {
          $data14 = $parent_postcode['postcode']; 
        }

        if (empty($user_guardian['nik'])) {
          $data15 = get_phrase('empty_data');
        } else {
          $data15 = $user_guardian['nik']; 
        }

        if (empty($user_guardian['gender'])) {
          $data16 = get_phrase('empty_data');
        } else {
          $data16 = $user_guardian['gender']; 
        }

        if (empty($user_guardian['religion'])) {
          $data17 = get_phrase('empty_data');
        } else {
          $data17 = $user_guardian['religion']; 
        }

        if (empty($user_guardian['name'])) {
          $data18 = get_phrase('empty_data');
        } else {
          $data18 = $user_guardian['name']; 
        }

        if (empty($user_guardian['email'])) {
          $data19 = get_phrase('empty_data');
        } else {
          $data19 = $user_guardian['email']; 
        }

        if (empty($user_guardian['phone'])) {
          $data20 = get_phrase('empty_data');
        } else {
          $data20 = $user_guardian['phone']; 
        }

        if (empty($user_guardian['blood_group'])) {
          $data21 = get_phrase('empty_data');
        } else {
          $data21 = $user_guardian['blood_group']; 
        }

        if (empty($guardian_province['name'])) {
          $data22 = get_phrase('empty_data');
        } else {
          $data22 = $guardian_province['name']; 
        }

        if (empty($guardian_district['name'])) {
          $data23 = get_phrase('empty_data');
        } else {
          $data23 = $guardian_district['name']; 
        }

        if (empty($guardian_districts['name'])) {
          $data24 = get_phrase('empty_data');
        } else {
          $data24 = $guardian_districts['name']; 
        }

        if (empty($guardian_ward['name'])) {
          $data25 = get_phrase('empty_data');
        } else {
          $data25 = $guardian_ward['name']; 
        }

        if (empty($user_guardian['address'])) {
          $data26 = get_phrase('empty_data');
        } else {
          $data26 = $user_guardian['address']; 
        }

        if (empty($guardian_postcode['postcode'])) {
          $data27 = get_phrase('empty_data');
        } else {
          $data27 = $guardian_postcode['postcode']; 
        }
         
        // $data2 = $user_parent['gender']; 
        // $data3 = $user_parent['religion']; 
        // $data4 = $user_parent['name']; 
        // $data5 = $user_parent['email']; 
        // $data6 = $user_parent['password']; 
        // $data7 = $user_parent['phone']; 
        // $data8 = $user_parent['blood_group']; 

        // $data9 = $parent_province['name']; 
        // $data10 = $parent_district['name']; 
        // $data11 = $parent_districts['name']; 
        // $data12 = $parent_ward['name']; 

        // $data13 = $user_parent['address']; 
        // $data14 = $parent_postcode['postcode']; 

        // $data15 = $user_guardian['nik']; 
        // $data16 = $user_guardian['gender']; 
        // $data17 = $user_guardian['religion']; 
        // $data18 = $user_guardian['name']; 
        // $data19 = $user_guardian['email']; 
        // $data20 = $user_guardian['phone']; 
        // $data21 = $user_guardian['blood_group']; 
        // $data22 = $guardian_province['name']; 
        // $data23 = $guardian_district['name']; 
        // $data24 = $guardian_districts['name']; 
        // $data25 = $guardian_ward['name']; 
        // $data26 = $user_guardian['address']; 
        // $data27 = $guardian_postcode['postcode']; 
      }
      $dat = array (
        'parent_nik'=> $data1,
        'parent_gender'=> $data2,
        'parent_religion'=> $data3,
        'parent_name'=> $data4,
        'parent_email'=> $data5,
        'parent_password'=> $data6,
        'parent_phone'=> $data7,
        'parent_blood_group'=> $data8,
        'parent_province_id'=> $data9,
        'parent_district_id'=> $data10,
        'parent_districts_id'=> $data11,
        'parent_ward_id'=> $data12,
        'parent_address'=> $data13,
        'parent_postcode_id'=> $data14,
        'guardian_nik'=> $data15,
        'guardian_gender'=> $data16,
        'guardian_religion'=> $data17,
        'guardian_name'=> $data18,
        'guardian_email'=> $data19,
        'guardian_phone'=> $data20,
        'guardian_blood_group'=> $data21,
        'guardian_province_id'=> $data22,
        'guardian_district_id'=> $data23,
        'guardian_districts_id'=> $data24,
        'guardian_ward_id'=> $data25,
        'guardian_address'=> $data26,
        'guardian_postcode_id'=> $data27
      );
      echo json_encode($dat);  
    }

    if($param1 == 'just_student'){
      $response = $this->user_model->just_student();
      echo $response;
    }

    if($param1 == 'create_bulk_student'){
      $response = $this->user_model->bulk_student_create();
      echo $response;
    }

    if($param1 == 'create_excel'){
      $response = $this->user_model->excel_create();
      echo $response;
    }

    if($param1 == 'create_excel_studentsonschool'){
      $response = $this->user_model->excel_create_studentsonschool();
      echo $response;
    }

    if ($param1 == 'move') {
      $page_data['page_name'] = 'move';
      $page_data['folder_name'] = 'student';
      $page_data['page_title'] = 'move_student';
      $this->load->view('backend/index', $page_data);
    }

    if ($param1 == 'manage_student') {
      $page_data['page_name'] = 'manage_student';
      $page_data['folder_name'] = 'student';
      $page_data['page_title'] = 'manage_student';
      $this->load->view('backend/index', $page_data);
    }

    if ($param1 == 'manage_alocation_student') {
      $this->load->view('backend/admin/student/manage_student');
    }

    if ($param1 == 'student_allocation') {
      $response = array(
        'status' => true,
        'notifications' => 'Alokasi Siswa Berhasil',
        'form' => $_POST,
        'data' => $this->user_model->student_allocation_bulk(),
      );

      $added = count($response['data']);
      $response['notifications'] = 'Alokasi Siswa Berhasil ' . $added . ' siswa';
      echo json_encode($response);
      
    }

    if($param1 == 'list_move'){
      $this->load->view('backend/admin/student/list_move');
    }

    if($param1 == 'filter_move'){
      $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
      $page_data['room_id'] = $this->input->post('room_id');
      $this->load->view('backend/admin/student/list_move', $page_data);
    }

    if ($param1 == 'move_students') {
      $response = $this->user_model->move_students();
      echo $response;
    }

    if ($param1 == 'delete_student') {
      $response = $this->user_model->delete_student();
      echo $response;
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
      // print_r('asdf'); die;
      $response = $this->user_model->student_update($param2,$param3);
      echo $response;
      // if ($response) {
      //   redirect(base_url('superadmin/student'));
      // }
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
      $this->load->view('backend/admin/student/list', $page_data);
    }

    if($param1 == 'list'){
      $this->load->view('backend/admin/student/list');
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
	// 	$this->load->view('backend/admin/student/list', $page_data);
	// }
  //END STUDENT ADN ADMISSION section

  //START STUDENT INFORMATION section
  public function student_info($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if($param1 == 'student_info'){
      $page_data['student_id'] = $param2;
      $this->load->view('backend/admin/student_info/student_info', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'student_info';
      $page_data['page_title'] = 'student_info';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END STUDENT INFORMATION section

  //START EMPLOYEE INFORMATION section
  public function employee_info($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if($param1 == 'employee_info'){
      $page_data['user_id'] = $param2;
      $this->load->view('backend/admin/employee_info/employee_info', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'employee_info';
      $page_data['page_title'] = 'employee_info';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END EMPLOYEE INFORMATION section

  //START STUDENT ROUTINE section
  public function student_routine($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if($param1 == 'filter'){
      $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
      $page_data['room_id'] = $this->input->post('room_id');
      $this->load->view('backend/admin/student_routine/list', $page_data);
    }

    if($param1 == 'list'){
      $this->load->view('backend/admin/student_routine/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'student_routine';
      $page_data['page_title'] = 'student_routine';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END STUDENT ROUTINE section

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
      $this->load->view('backend/admin/exam/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'exam';
      $page_data['page_title'] = 'exam';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END EXAM section

  //START MARKS section
  public function mark($param1 = '', $param2 = ''){

    if($param1 == 'list'){
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $page_data['room_id'] = $this->input->post('room_id');
      $page_data['subject_id'] = $this->input->post('subject');
      $this->crud_model->mark_insert($page_data['class_id'], $page_data['section_id'], $page_data['room_id'], $page_data['subject_id']);
      $this->load->view('backend/admin/mark/list', $page_data);
    }

    if($param1 == 'upload_excel_mark'){
      $response = $this->crud_model->upload_excel_mark();
      echo $response;
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

  //START MARKS ARCHIVES section
  public function marks_archives($param1 = '', $param2 = ''){

    if($param1 == 'list'){
      $page_data['class_id'] = $this->input->post('class_id');
      $page_data['section_id'] = $this->input->post('section_id');
      $page_data['semester_id'] = $this->input->post('semester_id');
      $page_data['student_id'] = $this->input->post('student_id');
      $page_data['session'] = $this->input->post('session');
      $this->load->view('backend/admin/marks_archives/list', $page_data);
    }

    if ($param1 == 'student') {
      $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
      $this->load->view('backend/admin/student/dropdown', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'marks_archives';
      $page_data['page_title'] = 'marks_archives';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END MARKS ARCHIVES section

  // GRADE SECTION STARTS
  public function grade($param1 = "", $param2 = "") {

    // store data on database
    if($param1 == 'create'){
      $response = $this->crud_model->grade_create();
      echo $response;
    }

    // update data on database
    if($param1 == 'update'){
      $response = $this->crud_model->grade_update($param2);
      echo $response;
    }

    // delelte data from database
    if($param1 == 'delete'){
      $response = $this->crud_model->grade_delete($param2);
      echo $response;
    }

    // show data from database
    if ($param1 == 'list') {
      $this->load->view('backend/admin/grade/list');
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'grade';
      $page_data['page_title'] = 'grades';
      $this->load->view('backend/index', $page_data);
    }
  }
  // GRADE SECTION ENDS

  // STUDENT PROMOTION SECTION STARTS
  function promotion($param1 = "", $promotion_data = "") {

    // Promote students. Here promotion_data contains all the data of a student to promote
    if ($param1 == 'promote') {
      $response = $this->crud_model->promote_student($promotion_data);
      echo $response;
    }
    //showing the list of student to promote
    if ($param1 == 'list') {
      $page_data['session_from'] = $this->input->post('session_from');
      $page_data['session_to'] = $this->input->post('session_to');
      $page_data['class_id_from'] = $this->input->post('class_id_from');
      $page_data['class_id_to'] = $this->input->post('class_id_to');
      $page_data['class_from_details'] = $this->crud_model->get_classes($this->input->post('class_id_from'))->row_array();
      $page_data['class_to_details'] = $this->crud_model->get_classes($this->input->post('class_id_to'))->row_array();
      $page_data['session_from_details'] = $this->crud_model->get_session($this->input->post('session_from'))->row_array();
      $page_data['session_to_details'] = $this->crud_model->get_session($this->input->post('session_to'))->row_array();
      $page_data['enrolments'] = $this->crud_model->get_student_list()->result_array();
      $this->load->view('backend/admin/promotion/list', $page_data);
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'promotion';
      $page_data['page_title'] = 'student_promotion';
      $this->load->view('backend/index', $page_data);
    }
  }
  // STUDENT PROMOTION SECTION ENDS

  //FINANCE LIST MANAGER
  public function finance2($param1 = "", $param2 = "", $param3 = '') {
    // adding finance
    if ($param1 == 'create') {
      $response = $this->crud_model->create_finances();
      echo $response;
    }

    // deleting finance
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_finances($param2);
      echo $response;
    }

    if ($param1 == 'student') {
      $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
      $this->load->view('backend/admin/student/dropdown', $page_data);
    }

    // accept a finance
    if ($param1 == 'accept') {
      $response = $this->crud_model->accept_finances($param2);
      echo $response;
    }

    // showing the list of finance
    if ($param1 == 'list') {
      $page_data['class_id'] = $param2;
      $page_data['section_id'] = $param3;
      $this->load->view('backend/admin/finance/list', $page_data);
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'finance';
      $page_data['page_title']  = 'finance';
      $this->load->view('backend/index', $page_data);
    }
  }

  // Expense Category
  public function expense_category($param1 = "", $param2 = "") {
    if ($param1 == 'create') {
      $response = $this->crud_model->create_expense_category();
      echo $response;
    }

    if ($param1 == 'update') {
      $response = $this->crud_model->update_expense_category($param2);
      echo $response;
    }

    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_expense_category($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/expense_category/list');
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'expense_category';
      $page_data['page_title']  = 'expense_category';
      $this->load->view('backend/index', $page_data);
    }
  }

  //Expense Manager
  public function expense($param1 = "", $param2 = "") {

    // adding expense
    if ($param1 == 'create') {
      $response = $this->crud_model->create_expense();
      echo $response;
    }

    // update expense
    if ($param1 == 'update') {
      $response = $this->crud_model->update_expense($param2);
      echo $response;
    }

    // deleting expense
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_expense($param2);
      echo $response;
    }
    // showing the list of expense
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59');
      $page_data['expense_category_id'] = $this->input->get('expense_category_id');
      $this->load->view('backend/admin/expense/list', $page_data);
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'expense';
      $page_data['page_title']  = 'expense';
      $first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
      $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
      $page_data['date_from']   = strtotime($first_day_of_month);
      $page_data['date_to']     = strtotime($last_day_of_month);
      $this->load->view('backend/index', $page_data);
    }
  }
  // ACCOUNTING SECTION ENDS

  // BACKOFFICE SECTION

  //START SEMESTER section
  public function semester($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->semester_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->semester_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->semester_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/semester/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'semester';
      $page_data['page_title'] = 'semester';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END SEMESTER section

  //START exam_types section
  public function exam_types($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->exam_types_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->exam_types_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->exam_types_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/exam_types/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'exam_types';
      $page_data['page_title'] = 'exam_types';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END exam_types section

  //START assignment_types section
  public function assignment_types($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->assignment_types_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->assignment_types_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->assignment_types_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/assignment_types/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'assignment_types';
      $page_data['page_title'] = 'assignment_types';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END assignment_types section

  //START ward section
  public function ward($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->create_ward();
      echo $response;
    }

    if($param1 == 'edit'){
      $response = $this->crud_model->update_ward($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->delete_ward($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/ward/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'ward';
      $page_data['page_title'] = 'ward';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END ward section

  //START district section
  public function district($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->create_district();
      echo $response;
    }

    if($param1 == 'edit'){
      $response = $this->crud_model->update_district($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->delete_district($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/district/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'district';
      $page_data['page_title'] = 'district';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END district section

  //START districts section
  public function districts($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->create_districts();
      echo $response;
    }

    if($param1 == 'edit'){
      $response = $this->crud_model->update_districts($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->delete_districts($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/districts/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'districts';
      $page_data['page_title'] = 'districts';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END districts section

  //START postcode section
  public function postcode($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->create_postcode();
      echo $response;
    }

    if($param1 == 'edit'){
      $response = $this->crud_model->update_postcode($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->delete_postcode($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/postcode/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'postcode';
      $page_data['page_title'] = 'postcode';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END postcode section

  //START province section
  public function province($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->create_province();
      echo $response;
    }

    if($param1 == 'edit'){
      $response = $this->crud_model->update_province($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->delete_province($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/province/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'province';
      $page_data['page_title'] = 'province';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END province section

  //START years section
  public function years($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->create_years();
      echo $response;
    }

    if($param1 == 'edit'){
      $response = $this->crud_model->update_years($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->delete_years($param2);
      echo $response;
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/year/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'year';
      $page_data['page_title'] = 'year';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END years section

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
      $this->load->view('backend/admin/book_type/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'book_type';
      $page_data['page_title'] = 'book_type';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END book_types section

  //START SESSION_MANAGER section
  public function session_manager($param1 = '', $param2 = ''){
    $school_id = school_id();

    if($param1 == 'create'){
      $response = $this->crud_model->session_create();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->session_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->session_delete($param2);
      echo $response;
    }

    if($param1 == 'active_session'){
      $response = $this->crud_model->active_session($param2);
      echo $response;
    }

    if($param1 == 'reopen_session'){
      echo $this->db->get_where('sessions', array('school_id' => $school_id, 'status' => 1))->row('name');
    }

    if($param1 == 'reopen_list'){
      $this->load->view('backend/admin/session/table_body');
    }

    if ($param1 == 'list') {
      $this->load->view('backend/admin/session/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'session';
      $page_data['page_title'] = 'session_manager';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END SESSION_MANAGER section

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
      $this->load->view('backend/admin/book/list');
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
      // echo $response;
      $response = json_decode($response);
      $this->session->set_flashdata('flash_message', $response->notification);
      redirect(site_url('superadmin/book_issue/issue'), 'refresh');
    }

    // adding book_issue
    if($param1 == 'create'){
      $page_data['aria_expand'] = 'create_book_issue';
      $page_data['page_name'] = 'create';
      $page_data['folder_name'] = 'book_issue';
      $page_data['page_title'] = 'create_book_issue';
      $this->load->view('backend/index', $page_data);
    }

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

    // Returning a book
    if ($param1 == 'return') {
      $response = $this->crud_model->return_issued_book($param2);
        // echo $response;
      $response = json_decode($response);
      $this->session->set_flashdata('flash_message', $response->notification);
      redirect(route('book_issue'), 'refresh');
    }

    if ($param1 == 'role') {
      $page_data['role'] = $param2;
      $this->load->view('backend/admin/book_issue/role', $page_data);
    }

    if ($param1 == 'student') {
      $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
      $this->load->view('backend/admin/student/dropdown', $page_data);
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
      $this->load->view('backend/admin/book_issue/list', $page_data);
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

  //routine_counseling LIST MANAGER
  public function routine_counseling($param1 = "", $param2 = "", $param3 = '', $param4 = '') {
    // adding routine_counseling
    if ($param1 == 'create') {
      $response = $this->crud_model->create_routine_counseling();
      // echo $response;
      $this->session->set_flashdata('success_message', get_phrase('create_successfully'));
		  redirect(site_url($this->load->view('backend/admin/routine_counseling/list')), 'refresh');
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
      $this->load->view('backend/admin/routine_counseling/list');
    }

    if($param1 == 'filter'){
      $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
      $this->load->view('backend/admin/routine_counseling/list', $page_data);
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

    if ($param1 == 'role') {
      $page_data['role'] = $param2;
      $this->load->view('backend/admin/visit_data/role', $page_data);
    }

    // deleting visit_data
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_visit_data($param2);
      echo $response;
    }
    // showing the list of visit_data
    if ($param1 == 'list') {
      $this->load->view('backend/admin/visit_data/list');
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'visit_data';
      $page_data['page_title']  = 'visit_data';
      $this->load->view('backend/index', $page_data);
    }
  }

  // ADDON MANAGER
  public function addon_manager($param1 = "", $param2 = "") {
    if ($param1 == 'install') {
      $response = $this->addon_model->install_addon();
      echo $response;
    }

    // DEACTIVE ADDONS
    if ($param1 == 'deactive') {
      $response = $this->addon_model->deactivate_addon($param2);
      echo $response;
    }
    // ACTIVATE ADDONS
    if ($param1 == 'activate') {
      $response = $this->addon_model->activate_addon($param2);
      echo $response;
    }

    // DELETING ADDONS
    if ($param1 == 'delete') {
      $response = $this->addon_model->remove_addon($param2);
      echo $response;
    }
    // showing the list of book
    if ($param1 == 'list') {
      $this->load->view('backend/admin/addon/list');
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'addon';
      $page_data['page_title']  = 'addon_manager';
      $this->load->view('backend/index', $page_data);
    }
  }

  // NOTICEBOARD MANAGER
  public function noticeboard($param1 = "", $param2 = "", $param3 = "") {
    // adding notice
    if ($param1 == 'create') {
      $response = $this->crud_model->create_notice();
      echo $response;
    }

    // update notice
    if ($param1 == 'update') {
      $response = $this->crud_model->update_notice($param2);
      echo $response;
    }

    // deleting notice
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_notice($param2);
      echo $response;
    }
    // showing the list of notice
    if ($param1 == 'list') {
      $this->load->view('backend/admin/noticeboard/list');
    }

    // showing the all the notices
    if ($param1 == 'all_notices') {
      $response = $this->crud_model->get_all_the_notices();
      echo $response;
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'noticeboard';
      $page_data['page_title']  = 'noticeboard';
      $this->load->view('backend/index', $page_data);
    }
  }

  // SETTINGS MANAGER
  public function system_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_system_settings();
      echo $response;
    }

    if ($param1 == 'update_apk') {
      $response = $this->settings_model->update_apk();
      echo $response;
    }

    if ($param1 == 'logo_update') {
      $response = $this->settings_model->update_system_logo();
      echo $response;
    }
    // showing the System Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'system_settings';
      $page_data['settings_type'] = 'system_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

   // SETTINGS MANAGER
   public function menu_settings($param1 = "", $param2 = "") {
    if($param1 == 'modify_menu_settings'){
      $response = $this->settings_model->menu_settings();
      echo $response;
      // $this->user_model->teacher_permission();
      $this->load->view('backend/admin/settings/menu_settings');
    }

    // showing the System Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'menu_settings';
      $page_data['settings_type'] = 'menu_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

  // FRONTEND SETTINGS MANAGER
  public function website_settings($param1 = '', $param2 = '', $param3 = '') {
    if ($param1 == 'events') {
      $page_data['page_content']  = 'events';
    }
    if ($param1 == 'gallery') {
      $page_data['page_content']  = 'gallery';
    }
    if ($param1 == 'privacy_policy') {
      $page_data['page_content']  = 'privacy_policy';
    }
    if ($param1 == 'about_us') {
      $page_data['page_content']  = 'about_us';
    }
    if ($param1 == 'terms_and_conditions') {
      $page_data['page_content']  = 'terms_and_conditions';
    }
    if ($param1 == 'homepage_slider') {
      $page_data['page_content']  = 'homepage_slider';
    }
    if ($param1 == 'maps') {
      $page_data['page_content']  = 'maps';
    }
    if ($param1 == 'superiority') {
      $page_data['page_content']  = 'superiority';
    }
    if ($param1 == 'new_flash') {
      $page_data['page_content']  = 'new_flash';
    }
    if ($param1 == 'gallery_image') {
      $page_data['page_content']  = 'gallery_image';
      $page_data['gallery_id']  = $param2;
    }
    if ($param1 == 'other_settings') {
      $page_data['page_content']  = 'other_settings';
    }
    if(empty($param1) || $param1 == 'general_settings'){
      $page_data['page_content']  = 'general_settings';
    }

    $page_data['folder_name']   = 'website_settings';
    $page_data['page_title']    = 'website_settings';
    $page_data['settings_type'] = 'website_settings';
    $this->load->view('backend/index', $page_data);
  }

  public function maps() {
    $response = $this->frontend_model->maps_update();
    echo $response;
  }

  public function superiority() {
    $response = $this->frontend_model->superiority_update();
    echo $response;
  }

  public function new_flash() {
    $response = $this->frontend_model->new_flash_update();
    echo $response;
  }

  public function gallery() {
    $response = $this->frontend_model->gallery_update();
    echo $response;
  }

  public function website_update($param1 = "") {
    if ($param1 == 'general_settings') {
      $response = $this->frontend_model->update_frontend_general_settings();
    }
    echo $response;
  }

  public function other_settings_update($param1 = "") {
    $response = $this->frontend_model->other_settings_update();
    echo $response;
  }

  public function update_recaptcha_settings($param1 = "") {
    $response = $this->frontend_model->update_recaptcha_settings();
    echo $response;
  }

  public function events($param1 = "", $param2 = "") {
    // DEACTIVE ADDONS
    if ($param1 == 'create') {
      $response = $this->frontend_model->event_create();
      echo $response;
    }
    // ACTIVATE ADDONS
    if ($param1 == 'update') {
      $response = $this->frontend_model->event_update($param2);
      echo $response;
    }

    // DELETING ADDONS
    if ($param1 == 'delete') {
      $response = $this->frontend_model->event_delete($param2);
      echo $response;
    }
    // showing the list of book
    if ($param1 == 'list') {
      $this->load->view('backend/admin/website_settings/events');
    }

    // showing the System Settings file
    if(empty($param1)){
      redirect(route('website_settings/events'), 'refresh');
    }
  }

  //FRONTEND GALLERY
  public function frontend_gallery($param1 = "", $param2 = "", $param3 = "") {
    if ($param1 == 'create') {
      $response = $this->frontend_model->add_frontend_gallery();
      echo $response;
    }

    if ($param1 == 'update') {
      $response = $this->frontend_model->update_frontend_gallery($param2);
      echo $response;
    }

    if ($param1 == 'delete') {
      $response = $this->frontend_model->delete_frontend_gallery($param2);
      echo $response;
    }

    if ($param1 == 'gallery_list') {
      $this->load->view('backend/admin/website_settings/gallery');
    }

    // HERE STARTS THE GALLER IMAGES PART

    if ($param1 == 'gallery_photo_list') {
      $page_data['gallery_id'] = $param2;
      $this->load->view('backend/admin/website_settings/gallery_image', $page_data);
    }

    if ($param1 == 'gallery_photo_delete') {
      $response = $this->frontend_model->delete_gallery_photo($param2);
      echo $response;
    }

    if ($param1 == 'gallery_photo_upload') {
      $response = $this->frontend_model->upload_gallery_photo($param2);
      echo $response;
    }
  }

  //ABOUT US UPDATE
  public function about_us($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_about_us();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }

  //PRIVACY POLICY UPDATE
  public function privacy_policy($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_privacy_policy();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }

  //TERMS AND CONDITION UPDATE
  public function terms_and_conditions($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_terms_and_conditions();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }
  //TERMS AND CONDITION UPDATE
  public function homepage_slider($param1 = "") {
    if ($param1 == 'update') {
      $response = $this->frontend_model->update_homepage_slider();
      echo $response;
    }else{
      redirect(site_url(), 'refresh');
    }
  }

  // SETTINGS MANAGER
  public function school_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_current_school_settings();
      echo $response;
    }

    // deleting school all data
    if ($param1 == 'delete_all') {
      $response = $this->settings_model->delete_school_data($param2);
      echo $response;
    }

    if ($param1 == 'delete_classes') {
      $response = $this->settings_model->delete_classes($param2);
      echo $response;
    }

    if ($param1 == 'delete_class_rooms') {
      $response = $this->settings_model->delete_class_rooms($param2);
      echo $response;
    }

    if ($param1 == 'delete_students') {
      $response = $this->settings_model->delete_students($param2);
      echo $response;
    }

    if ($param1 == 'delete_departments') {
      $response = $this->settings_model->delete_departments($param2);
      echo $response;
    }

    if ($param1 == 'delete_subjects') {
      $response = $this->settings_model->delete_subjects($param2);
      echo $response;
    }

    if ($param1 == 'delete_teachers') {
      $response = $this->settings_model->delete_teachers($param2);
      echo $response;
    }

    if ($param1 == 'delete_routines') {
      $response = $this->settings_model->delete_routines($param2);
      echo $response;
    }

    // showing the System Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'school_settings';
      $page_data['settings_type'] = 'school_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

  // PAYMENT SETTINGS MANAGER
  public function payment_settings($param1 = "", $param2 = "") {
    if ($param1 == 'system') {
      $response = $this->settings_model->update_system_currency_settings();
      echo $response;
    }
    if ($param1 == 'paypal') {
      $response = $this->settings_model->update_paypal_settings();
      echo $response;
    }
    if ($param1 == 'stripe') {
      $response = $this->settings_model->update_stripe_settings();
      echo $response;
    }

    // showing the Payment Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'payment_settings';
      $page_data['settings_type'] = 'payment_settings';
      $this->load->view('backend/index', $page_data);
    }
  }

  // LANGUAGE SETTINGS
  public function language($param1 = "", $param2 = "") {
    // adding language
    if ($param1 == 'create') {
      $response = $this->settings_model->create_language();
      echo $response;
    }

    // update language
    if ($param1 == 'update') {
      $response = $this->settings_model->update_language($param2);
      echo $response;
    }

    // deleting language
    if ($param1 == 'delete') {
      $response = $this->settings_model->delete_language($param2);
      echo $response;
    }

    // showing the list of language
    if ($param1 == 'list') {
      $this->load->view('backend/admin/language/list');
    }

    // showing the list of language
    if ($param1 == 'active') {
      $this->settings_model->update_system_language($param2);
      redirect(route('language'), 'refresh');
    }

    // showing the list of language
    if ($param1 == 'update_phrase') {
      $current_editing_language = $this->input->post('currentEditingLanguage');
      $updatedValue = $this->input->post('updatedValue');
      $key = $this->input->post('key');
      saveJSONFile($current_editing_language, $key, $updatedValue);
      echo $current_editing_language.' '.$key.' '.$updatedValue;
    }

    // GET THE DROPDOWN OF LANGUAGES
    if($param1 == 'dropdown') {
      $this->load->view('backend/admin/language/dropdown');
    }
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'language';
      $page_data['page_title']  = 'languages';
      $this->load->view('backend/index', $page_data);
    }
  }
  // SMTP SETTINGS MANAGER
  public function smtp_settings($param1 = "", $param2 = "") {
    if ($param1 == 'update') {
      $response = $this->settings_model->update_smtp_settings();
      echo $response;
    }

    // showing the Smtp Settings file
    if(empty($param1)){
      $page_data['folder_name'] = 'settings';
      $page_data['page_title']  = 'smtp_settings';
      $page_data['settings_type'] = 'smtp_settings';
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
    }
  }
  //MANAGE PROFILE ENDS

  // ABOUT APPLICATION STARTS
  public function about() {

    $page_data['application_details'] = $this->settings_model->get_application_details();
    $page_data['folder_name'] = 'about';
    $page_data['page_title']  = 'about';
    $this->load->view('backend/index', $page_data);
  }
  // ABOUT APPLICATION ENDS

  public function upload_excel()
  {
    $response = $this->crud_model->upload_excel();
    echo $response;
  }

  //Raport section
	public function raport($param1 = '', $param2 = '', $param3 = ''){
		// if($param1 == 'filter'){
		// 	$page_data['student_id'] = $param2;
		// 	$this->load->view('backend/admin/raport/list', $page_data);
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
      $page_data['class_id'] = $this->input->post('class_id');
		  $page_data['section_id'] = $this->input->post('section_id');
      $page_data['room_id'] = $this->input->post('room_id');
      $this->load->view('backend/admin/raport/list', $page_data);
    }

    if($param1 == 'list'){
      $this->load->view('backend/admin/raport/list');
    }

    if(empty($param1)){
			$page_data['student_id'] = $param2;
			$page_data['folder_name'] = 'raport';
			$page_data['page_title'] = 'raport';
			$this->load->view('backend/index', $page_data);
		}
	}

  //finance_odoo LIST MANAGER
  public function finance_odoo($param1 = "", $param2 = "", $param3 = '') {
    // showing the list of finance_odoo
    if ($param1 == 'list') {
      $page_data['nama_siswa'] = $param2;
      $this->load->view('backend/admin/finance_odoo/list', $page_data);
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'finance_odoo';
      $page_data['page_title']  = 'finance_odoo';
      $this->load->view('backend/index', $page_data);
    }
  }

  //VISIT DATA LIST MANAGER
  public function infrastructure($param1 = "", $param2 = "") {

    // adding infrastructure
    if ($param1 == 'create') {
      $response = $this->crud_model->create_infrastructure();
      echo $response;
    }

    if($param1 == 'upload_excel_infrastructure'){
      $response = $this->crud_model->upload_excel_infrastructure();
      echo $response;
    }

    // update infrastructure
    if ($param1 == 'update') {
      $response = $this->crud_model->update_infrastructure($param2);
      echo $response;
    }

    // deleting infrastructure
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_infrastructure($param2);
      echo $response;
    }
    // showing the list of infrastructure
    if ($param1 == 'list') {
      $this->load->view('backend/admin/infrastructure/list');
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
    // adding infrastructure
    if ($param1 == 'add') {
      $response = $this->crud_model->create_infrastructure_issue();
      // echo $response;
      $response = json_decode($response);
      $this->session->set_flashdata('flash_message', $response->notification);
      redirect(site_url('superadmin/infrastructure_issue/issue'), 'refresh');
    }

    if($param1 == 'create'){
      $page_data['aria_expand'] = 'create_infrastructure_issue';
      $page_data['page_name'] = 'create';
      $page_data['folder_name'] = 'infrastructure_issue';
      $page_data['page_title'] = 'create_infrastructure_issue';
      $this->load->view('backend/index', $page_data);
    }

    // update infrastructure
    if ($param1 == 'update') {
      $response = $this->crud_model->update_infrastructure_issue($param2);
      echo $response;
    }

    // update infrastructure
    if ($param1 == 'due_date') {
      $response = $this->crud_model->update_status_infrastructure_issue($param2);
      echo $response;
    }

    // Returning a infrastructure
    if ($param1 == 'return') {
      $response = $this->crud_model->return_issued_infrastructure($param2);
        // echo $response;
      $response = json_decode($response);
      $this->session->set_flashdata('flash_message', $response->notification);
      redirect(route('infrastructure_issue'), 'refresh');
    }

    if ($param1 == 'role') {
      $page_data['role'] = $param2;
      $this->load->view('backend/admin/infrastructure_issue/role', $page_data);
    }

    // deleting infrastructure_issue
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_infrastructure_issue($param2);
      echo $response;
    }

    if($param1 == 'filter_list'){
      $page_data['infrastructure_id'] = $this->input->post('infrastructure_id');
		  $page_data['date'] = $this->input->post('date');
			$this->load->view('backend/admin/infrastructure_issue/list', $page_data);
		}

    // showing the list of infrastructure_issue
    if ($param1 == 'list') {
      $this->load->view('backend/admin/infrastructure_issue/list', $page_data);
    }

    if ($param1 == 'deadline') {
      $page_data['page_name'] = 'deadline';
      $page_data['folder_name'] = 'infrastructure_issue';
      $page_data['page_title'] = 'tenggat_waktu';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'filter_issue'){
      $page_data['infrastructure_id'] = $this->input->post('infrastructure_id');
		  $page_data['date'] = $this->input->post('date');
			$this->load->view('backend/admin/infrastructure_issue/list_issue', $page_data);
		}

    if ($param1 == 'issue') {
      $page_data['page_name'] = 'issue';
      $page_data['folder_name'] = 'infrastructure_issue';
      $page_data['page_title'] = 'infrastructure_issue';
      $this->load->view('backend/index', $page_data);
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

    // adding means
    if ($param1 == 'create') {
      $response = $this->crud_model->create_means();
      echo $response;
    }

    if($param1 == 'upload_excel_means'){
      $response = $this->crud_model->upload_excel_means();
      echo $response;
    }

    // update means
    if ($param1 == 'update') {
      $response = $this->crud_model->update_means($param2);
      echo $response;
    }

    // deleting means
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_means($param2);
      echo $response;
    }

    // showing the list of means
    if ($param1 == 'list') {
      $this->load->view('backend/admin/means/list');
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'means';
      $page_data['page_title']  = 'means';
      $this->load->view('backend/index', $page_data);
    }
  }

  //MEAN ISSUE LIST MANAGER
  public function mean_issue($param1 = "", $param2 = "", $param3 = "", $param4 = "") {
    // adding mean
    if ($param1 == 'add') {
      $response = $this->crud_model->create_mean_issue();
      // echo $response;
      $response = json_decode($response);
      $this->session->set_flashdata('flash_message', $response->notification);
      redirect(site_url('superadmin/mean_issue/issue'), 'refresh');
    }

    if($param1 == 'create'){
      $page_data['aria_expand'] = 'create_mean_issue';
      $page_data['page_name'] = 'create';
      $page_data['folder_name'] = 'mean_issue';
      $page_data['page_title'] = 'create_mean_issue';
      $this->load->view('backend/index', $page_data);
    }

    // update mean
    if ($param1 == 'update') {
      $response = $this->crud_model->update_mean_issue($param2);
      echo $response;
    }

    // update mean
    if ($param1 == 'due_date') {
      $response = $this->crud_model->update_status_mean_issue($param2);
      echo $response;
    }

    // Returning a mean
    if ($param1 == 'return') {
      $response = $this->crud_model->return_issued_mean($param2);
        // echo $response;
      $response = json_decode($response);
      $this->session->set_flashdata('flash_message', $response->notification);
      redirect(route('mean_issue'), 'refresh');
    }

    if ($param1 == 'role') {
      $page_data['role'] = $param2;
      $this->load->view('backend/admin/mean_issue/role', $page_data);
    }

    // deleting mean
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_mean_issue($param2);
      echo $response;
    }

    if($param1 == 'filter_list'){
      $page_data['mean_id'] = $this->input->post('mean_id');
		  $page_data['date'] = $this->input->post('date');
      $page_data['tgl'] = $this->input->post('tgl');
			$this->load->view('backend/admin/mean_issue/list', $page_data);
		}

    // showing the list of mean
    if ($param1 == 'list') {
      $this->load->view('backend/admin/mean_issue/list', $page_data);
    }

    if($param1 == 'filter_deadline'){
      $page_data['mean_id'] = $this->input->post('mean_id');
		  $page_data['date'] = $this->input->post('date');
      $page_data['tgl'] = $this->input->post('tgl');
			$this->load->view('backend/admin/mean_issue/list_deadline', $page_data);
		}

    if ($param1 == 'deadline') {
      $page_data['page_name'] = 'deadline';
      $page_data['folder_name'] = 'mean_issue';
      $page_data['page_title'] = 'tenggat_waktu';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'filter_issue'){
      $page_data['mean_id'] = $this->input->post('mean_id');
		  $page_data['date'] = $this->input->post('date');
      $page_data['tgl'] = $this->input->post('tgl');
			$this->load->view('backend/admin/mean_issue/list_issue', $page_data);
		}

    if ($param1 == 'issue') {
      $page_data['page_name'] = 'issue';
      $page_data['folder_name'] = 'mean_issue';
      $page_data['page_title'] = 'mean_issue';
      $this->load->view('backend/index', $page_data);
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'mean_issue';
      $page_data['page_title']  = 'mean_issue_back';
      $this->load->view('backend/index', $page_data);
    }
  }

  //employee LIST MANAGER
  public function employee($param1 = "", $param2 = "", $param3 = "") {

    // adding employee
    if($param1 == 'create'){
      $page_data['aria_expand'] = 'create_single_employee';
      $page_data['page_name'] = 'create_single_employee';
      $page_data['folder_name'] = 'employee';
      $page_data['page_title'] = 'add_employee';
      $this->load->view('backend/index', $page_data);
    }

    // update employee
    if ($param1 == 'create_single_employee') {
      $response = $this->user_model->create_single_employee();
      echo $response;
    }

    // deleting employee
    if ($param1 == 'delete') {
      $response = $this->user_model->delete_employee($param2);
      echo $response;
    }

    if($param1 == 'filter'){
      $page_data['role'] = $this->input->post('role');
      $this->load->view('backend/admin/employee/list', $page_data);
    }

    // showing the list of employee
    if ($param1 == 'list') {
      $this->load->view('backend/admin/employee/list');
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'employee';
      $page_data['page_title']  = 'employee';
      $this->load->view('backend/index', $page_data);
    }
  }

  //START JOB_MANAGEMENT section
  public function job_management($param1 = '', $param2 = ''){

    // update job_management
    if ($param1 == 'create_job_management') {
      $response = $this->user_model->create_job_management();
      echo $response;
    }

    if ($param1 == 'role') {
      $page_data['role'] = $param2;
      $this->load->view('backend/admin/job_management/role', $page_data);
    }

    if ($param1 == 'detail') {
      $page_data['user_id'] = $param2;
      $this->load->view('backend/admin/job_management/detail', $page_data);
    }

    if ($param1 == 'detail_role') {
      $page_data['user_id'] = $param2;
      $this->load->view('backend/admin/job_management/detail_role', $page_data);
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/job_management/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'job_management';
      $page_data['page_title'] = 'job_management';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END JOB_MANAGEMENT section

  // --------------------------------------------------------------------------------------------------------------------------//
  // -------------------------------------
  //START PAYMENT_TYPE section
  public function payment_type($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->payment_type_create();
      echo $response;
    }

    if($param1 == 'create_mass'){
      $response = $this->crud_model->payment_type_create_mass();
      echo $response;
    }

    if($param1 == 'update'){
      $response = $this->crud_model->payment_type_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->payment_type_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO PAYMENT_TYPE ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/payment_type/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'payment_type';
      $page_data['page_title'] = 'master_payment_type';
      $this->load->view('backend/index', $page_data);
    }
  }

   //START PAYMENT_TYPE section
   public function account($param1 = '', $param2 = ''){

    if($param1 == 'create'){
      $response = $this->crud_model->account_create();
      echo $response;
    } 

    if($param1 == 'update'){
      $response = $this->crud_model->account_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->account_delete($param2);
      echo $response;
    }

    // PROVIDE A LIST OF SECTION ACCORDING TO PAYMENT_TYPE ID
    if ($param1 == 'list') {
      $this->load->view('backend/admin/account/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'account';
      $page_data['page_title'] = 'account';
      $this->load->view('backend/index', $page_data);
    }
  }
  
  // ACCOUNTING SECTION STARTS
  public function invoice($param1 = "", $param2 = "") { 
    if($param1 == "coba"){
        $invoices = $this->db->query('
        SELECT * FROM invoices WHERE invoices.title IS NULL AND invoices.created_at <='. strtotime(date('M-d-Y')) .'
        order by id ASC')->result_array();
        $a = $this->db->query("SELECT count(invoices.id)+1 as total FROM invoices where title IS NOT NULL")->row();
        $a2 = $a->total;
        foreach($invoices as $invoice){   
          $nisn = $this->db->query('select nisn from students where id='. $invoice['student_id'] )->row_array(); 
          $title = 'INV/'.$nisn['nisn'].'/'.date('Y').'/'.date('m').'/'.$a2; 
          echo $invoice['id'] ."<br>";  
          echo $title ."<br>";  
          echo "<br>";  
          // $data['title'] = 'INV/'.$nisn['nisn'].'/'.date('Y').'/'.date('m').'/'.$a2;          
          // $this->db->where('id', $invoice['id']);
          // $this->db->update('invoices', $data);          
          $a2++;       
        } 
    }

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
      $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
      $this->load->view('backend/admin/student/dropdown', $page_data);
    } 
	
	// Get the list of student. Here param2 defines roomID
	if ($param1 == 'student_finance') {
      $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
      $this->load->view('backend/admin/student/dropdown_finance', $page_data);
    } 

    // Get the list of  
    if ($param1 == 'detail_payment_type') {   
      $payment_types = $this->db->get_where('payment_types', array('id' => $param2))->result();   
      foreach($payment_types as $payment_type){
        $data1 = $payment_type->price;  
      }
      $dat = array ('price'=> $data1);
      echo json_encode($dat);  
    } 

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
          $title         = 'INV/'.$nisn['nisn'].'/'.date('Y').'/'.date('m').'/'.$a2;
          $data['title'] = $title;
          $this->db->where('id', $invoice['id']);
          $this->db->update('invoices', $data);

          $history_data['ket'] = 'Update data invoices '.$invoice['id'].'';
          $history_data['id_user'] = $this->session->set_userdata('user_id');
          $this->db->insert('history', $history_data);
          
          $accounts = $this->db->query('
            SELECT
              journal_type_temp.id,
              accounts.id as account_id,
              accounts.code as account_code,
              accounts.name as account_name,
              journal_type_temp.type
            FROM
              journal_type_temp
            INNER JOIN accounts ON journal_type_temp.account_id = accounts.id
            WHERE
              journal_type_temp.school_id = '.school_id().' and 
              journal_type_temp.journal_type_id = 1
          ')->result_array();
          foreach( $accounts as $account){ 
            $data2['school_id']  = school_id();
            $data2['session_id'] = active_session();
            $data2['created_at'] = $invoice['created_at'];
            $data2['account_id'] = $account['account_id'];
            $data2['student_id'] = $invoice['student_id'];
            $data2['finance_id'] = 0;
            $data2['invoice_id'] = $invoice['id'];
            if($account['type'] == 'debit'){					
              $data2['label']		= $title;				
              $data2['debit']		= $invoice['total_amount'];
              $data2['credit']	= 0;
            }else{
              $data2['label']		= "Pembayaran: ".$payment_type['name'];				
              $data2['debit']		= 0;
              $data2['credit']	= $invoice['total_amount'];
            }
            $this->db->insert('journal', $data2);		
			
            $history_data['ket'] = 'Mengisi data journal';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);	
          }

          $a2++;       
      }
      $page_data['school'] = $this->db->query('
        SELECT settings.id, schools.name, schools.address, schools.phone
        FROM settings
        INNER JOIN schools ON settings.school_id = schools.id
      ')->row_array(); 
      $this->load->view('backend/index', $page_data);
    }

    // showing the list of invoices
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59');
      $page_data['selected_class'] = $this->input->get('selectedClass');
      $page_data['selected_section'] = $this->input->get('selectedsection');
      $page_data['selected_class2'] = $this->input->get('selectedClass2');
      $page_data['selected_status'] = $this->input->get('selectedStatus'); 
      $page_data['student_id'] = $this->input->get('student_id');
      $this->load->view('backend/admin/invoice/list', $page_data);
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
      $page_data['selected_section'] = 'all';
      $page_data['selected_class2'] = 'all';
      $page_data['selected_status'] = 'all'; 
      $page_data['student_id'] = 'all'; 
      
      $invoices = $this->db->query('
        SELECT * FROM invoices 
        WHERE title IS NULL AND created_at <='. strtotime(date('M-d-Y')) .'
        ')->result_array();   
      $a = $this->db->query("SELECT count(invoices.id)+1 as total FROM invoices where title IS NOT NULL")->row();
      $a2 = $a->total;
      foreach($invoices as $invoice){   
          $nisn = $this->db->query('select nisn from students where id='. $invoice['student_id'] )->row_array(); 
          $title          = 'INV/'.$nisn['nisn'].'/'.date('Y').'/'.date('m').'/'.$a2;          
          $data['title']  = $title;          
          $this->db->where('id', $invoice['id']);
          $this->db->update('invoices', $data);

          $history_data['ket'] = 'Update data invoices '.$invoice['id'].'';
          $history_data['id_user'] = $this->session->set_userdata('user_id');
          $this->db->insert('history', $history_data);

          $accounts = $this->db->query('
            SELECT
              journal_type_temp.id,
              accounts.id as account_id,
              accounts.code as account_code,
              accounts.name as account_name,
              journal_type_temp.type
            FROM
              journal_type_temp
            INNER JOIN accounts ON journal_type_temp.account_id = accounts.id
            WHERE
              journal_type_temp.school_id = '.school_id().' and 
              journal_type_temp.journal_type_id = 1
          ')->result_array();
          foreach( $accounts as $account){ 
            $data2['school_id']  = school_id();
            $data2['session_id'] = active_session();
            $data2['created_at'] = $invoice['created_at'];
            $data2['account_id'] = $account['account_id'];
            $data2['student_id'] = $invoice['student_id'];
            $data2['finance_id'] = 0;
            $data2['invoice_id'] = $invoice['id'];
            if($account['type'] == 'debit'){					
              $data2['label']		= $title;				
              $data2['debit']		= $invoice['total_amount'];
              $data2['credit']	= 0;
            }else{
              $data2['label']		= "Tagihan: ".$title;				
              $data2['debit']		= 0;
              $data2['credit']	= $invoice['total_amount'];
            }
            $this->db->insert('journal', $data2);	
			
            $history_data['ket'] = 'Mengisi data journal';
            $history_data['id_user'] = $this->session->set_userdata('user_id');
            $this->db->insert('history', $history_data);		
          }

          $a2++;       
      }

      $this->load->view('backend/index', $page_data);
    }

    // For add payment
    if ($param1 == 'payment') {
      $response = $this->crud_model->add_payment($param2);
      echo $response;
    }
	
	// For month-recurring
    if ($param1 == 'month') {  	
		$page_data['kategori'] = $this->input->get('kategori');
		$this->load->view('backend/admin/invoice/dropdown_month', $page_data);
    }
	
	// For recurring
    if ($param1 == 'recurring') {  			
		$page_data['kategori'] = $this->input->get('kategori');
		$page_data['label'] = $param2;  
		$this->load->view('backend/admin/invoice/dropdown_recurring', $page_data);
    }
  }

  //FINANCE LIST MANAGER
  public function finance($param1 = "", $param2 = "") {
    // upload a file
    if ($param1 == 'upload') {
      $response = $this->crud_model->update_payment($param2);
      echo $response;
    }   
    // Get the list of student. Here param2 defines classId
    if ($param1 == 'student') {
      $page_data['enrolments'] = $this->user_model->get_student_details_by_id('class', $param2);
      $this->load->view('backend/admin/student/dropdown', $page_data);
    } 
	
    if ($param1 == 'student_finance') {
        $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
        $this->load->view('backend/admin/student/dropdown_finance', $page_data);
    } 
    
    if ($param1 == 'invoice') { 
      $page_data['invoices'] = $this->crud_model->get_invoices($param2)->result();  		  
      $this->load->view('backend/admin/finance/dropdown', $page_data);
    }  

	  // Get the list of  
    if ($param1 == 'sectionlist') {   
      $sectionlist = $this->db->get_where('sections', array('id' => $param2))->result();   
      foreach($sectionlist as $list){
        $data1 = $list->class_id;  
      }
      $dat = array ('class_id'=> $data1 );
      echo json_encode($dat);  
    } 
 
    // showing the list of finance
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59');
      $page_data['selected_class'] = $this->input->get('selectedClass');
      $page_data['selected_section'] = $this->input->get('selectedsection');
      $page_data['selected_class2'] = $this->input->get('selectedClass2');   
      $page_data['student_id'] = $this->input->get('student_id');
      $this->load->view('backend/admin/finance/list', $page_data);
    }
    
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'finance';
      $page_data['page_title']  = 'finance';
      $first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
      $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
      $page_data['date_from']   = strtotime($first_day_of_month);
      $page_data['date_to']     = strtotime($last_day_of_month);
      $page_data['selected_class'] = 'all';
      $page_data['selected_section'] = 'all';
      $page_data['selected_class2'] = 'all';  
      $page_data['student_id'] = 'all';
      $this->load->view('backend/index', $page_data);
    }

    if ($param1 == 'finance_va') { 
      $page_data['folder_name'] = 'finance_va';
      $page_data['page_title']  = 'finance'; 
      $this->load->view('backend/index', $page_data); 
    }
  
    if ($param1 == 'finance_va_add') {
      $response = $this->crud_model->create_finance_va();
      echo $response;
    }
  }
  
  //Expense Manager
  public function expense2($param1 = "", $param2 = "") {

    // adding expense
    if ($param1 == 'create') {
      $response = $this->crud_model->create_expense2();
      echo $response;
    }

    // update expense
    if ($param1 == 'update') {
      $response = $this->crud_model->update_expense2($param2);
      echo $response;
    }

    // deleting expense
    if ($param1 == 'delete') {
      $response = $this->crud_model->delete_expense2($param2);
      echo $response;
    }
    // showing the list of expense
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59'); 
      $this->load->view('backend/admin/expense/list', $page_data);
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'expense';
      $page_data['page_title']  = 'expense';
      // $page_data['date_from']   = strtotime(date('d-M-Y', strtotime(' -30 day')).' 00:00:00');
      // $page_data['date_to']     = strtotime(date('d-M-Y').' 23:59:59');      
      $first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
      $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
      $page_data['date_from']   = strtotime($first_day_of_month);
      $page_data['date_to']     = strtotime($last_day_of_month);
      $this->load->view('backend/index', $page_data);
    }
  }

  //journal
  public function journal_in($param1 = "", $param2 = "") {
    // showing the list of expense
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59');       
 
      $page_data['selected_class'] = 'all';
      $page_data['selected_section'] = 'all';
      $page_data['selected_class2'] = 'all'; 
      $this->load->view('backend/admin/journal_in/list', $page_data);
    }
   
    
    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'journal_in';
      $page_data['page_title']  = 'journal in';
      $first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
      $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
      $page_data['date_from']   = strtotime($first_day_of_month);
      $page_data['date_to']     = strtotime($last_day_of_month);
      $page_data['selected_class'] = 'all';
      $page_data['selected_section'] = 'all';
      $page_data['selected_class2'] = 'all'; 
      $this->load->view('backend/index', $page_data);
    }
 
  }

  //journal
  public function journal_out($param1 = "", $param2 = "") {
    // showing the list of expense
    if ($param1 == 'list') {
      $date = explode('-', $this->input->get('date'));
      $page_data['date_from'] = strtotime($date[0].' 00:00:00');
      $page_data['date_to']   = strtotime($date[1].' 23:59:59'); 
      $this->load->view('backend/admin/journal_out/list', $page_data);
    }

    // showing the index file
    if(empty($param1)){
      $page_data['folder_name'] = 'journal_out';
      $page_data['page_title']  = 'journal out';
      $first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
      $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
      $page_data['date_from']   = strtotime($first_day_of_month);
      $page_data['date_to']     = strtotime($last_day_of_month);
      $page_data['selected_class'] = 'all';
      $page_data['selected_class2'] = 'all'; 
      $this->load->view('backend/index', $page_data);
    } 
  }

  //partner_ledger
  public function partner_ledger($param1 = "", $param2 = "") {
    // showing the list of invoices
		if ($param1 == 'list') {      
			$page_data['student_id'] = $param2;  
			$first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
      $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
      $page_data['date_from']   = strtotime($first_day_of_month);
      $page_data['date_to']     = strtotime($last_day_of_month);
			$this->load->view('backend/admin/partner_ledger/list', $page_data);
		}

    // showing the index file
		if(empty($param1)){
			$page_data['folder_name'] = 'partner_ledger';
			$page_data['page_title']  = 'partner_ledger';
			$first_day_of_month = "1 ".date("M")." ".date("Y").' 00:00:00';
      $last_day_of_month = date("t")." ".date("M")." ".date("Y").' 23:59:59';
      $page_data['date_from']   = strtotime($first_day_of_month);
      $page_data['date_to']     = strtotime($last_day_of_month);
			$this->load->view('backend/index', $page_data);
		}
  }
 

  //EXPORT STUDENT FEES
  public function export($param1 = "", $date_from = "", $date_to = "", $selected_class = "", $selected_status = "") {
    //RETURN EXPORT URL
    if ($param1 == 'url') {
      $type = $this->input->post('type');
      $date = explode('-', $this->input->post('dateRange'));
      $date_from = strtotime($date[0].' 00:00:00');
      $date_to   = strtotime($date[1].' 23:59:59');
      $selected_class = $this->input->post('selectedClass');
      $selected_status = $this->input->post('selectedStatus');
      echo route('export/'.$type.'/'.$date_from.'/'.$date_to.'/'.$selected_class.'/'.$selected_status);
    }
    // EXPORT AS PDF
    if($param1 == 'pdf' || $param1 == 'print') {
      $page_data['action']   = $param1;
      $page_data['date_from']   = $date_from;
      $page_data['date_to']     = $date_to;
      $page_data['selected_class'] = $selected_class;
      $page_data['selected_status'] = $selected_status;
      $html = $this->load->view('backend/admin/invoice/export',$page_data, true);

      $this->pdf->loadHtml($html);
      $this->pdf->set_paper("a4", "landscape" );
      $this->pdf->render();

      // FILE DOWNLOADING CODES
      if ($selected_status == 'all') {
        $paymentStatusForTitle = 'paid-and-unpaid';
      }else{
        $paymentStatusForTitle = $selected_status;
      }
      if ($selected_class == 'all') {
        $classNameForTitle = 'all_class';
      }else{
        $class_details = $this->crud_model->get_classes($selected_class)->row_array();
        $classNameForTitle = $class_details['name'];
      }
      $fileName = 'Student_fees-'.date('d-M-Y', $date_from).'-to-'.date('d-M-Y', $date_to).'-'.$classNameForTitle.'-'.$paymentStatusForTitle.'.pdf';

      if ($param1 == 'pdf') {
        $this->pdf->stream($fileName, array("Attachment" => 1));
      }else{
        $this->pdf->stream($fileName, array("Attachment" => 0));
      }
    }
    // EXPORT AS CSV
    if($param1 == 'csv'){
      $date_from   = $date_from;
      $date_to     = $date_to;
      $selected_class = $selected_class;
      $selected_status = $selected_status;

      $invoices = $this->crud_model->get_invoice_by_date_range($date_from, $date_to, $selected_class, $selected_status)->result_array();
      $csv_file = fopen("assets/csv_file/invoices.csv", "w");
      $header = array('Invoice-no', 'Student', 'Class', 'Invoice-Title', 'Total-Amount', 'Paid-Amount', 'Creation-Date', 'Payment-Date', 'Status');
      fputcsv($csv_file, $header);
      foreach ($invoices as $invoice) {
        $student_details = $this->user_model->get_student_details_by_id('student', $invoice['student_id']);
        $class_details = $this->crud_model->get_class_details_by_id($invoice['class_id'])->row_array();
        if ($invoice['updated_at'] > 0){
          $payment_date = date('d-M-Y', $invoice['updated_at']);
        }else{
          $payment_date = get_phrase('not_found');
        }
        $lines = array(sprintf('%08d', $invoice['id']), $student_details['name'], $class_details['name'], $invoice['title'], currency($invoice['total_amount']), currency($invoice['paid_amount']), date('d-M-Y', $invoice['created_at']), $payment_date, ucfirst($invoice['status']));
        fputcsv($csv_file, $lines);
      }

      // FILE DOWNLOADING CODES
      if ($selected_status == 'all') {
        $paymentStatusForTitle = 'paid-and-unpaid';
      }else{
        $paymentStatusForTitle = $selected_status;
      }
      if ($selected_class == 'all') {
        $classNameForTitle = 'all_class';
      }else{
        $class_details = $this->crud_model->get_classes($selected_class)->row_array();
        $classNameForTitle = $class_details['name'];
      }
      $fileName = 'Student_fees-'.date('d-M-Y', $date_from).'-to-'.date('d-M-Y', $date_to).'-'.$classNameForTitle.'-'.$paymentStatusForTitle.'.csv';
      $this->download_file('assets/csv_file/invoices.csv', $fileName);
    }
  }
 
  /*FUNCTION FOR DOWNLOADING A FILE*/
  function download_file($path, $name)
  {
    // make sure it's a file before doing anything!
    if(is_file($path))
    {
      // required for IE
      if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

      // get the file mime type using the file extension
      $this->load->helper('file');

      $mime = get_mime_by_extension($path);

      // Build the headers to push out the file properly.
      header('Pragma: public');     // required
      header('Expires: 0');         // no cache
      header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
      header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
      header('Cache-Control: private',false);
      header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
      header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
      header('Content-Transfer-Encoding: binary');
      header('Content-Length: '.filesize($path)); // provide file size
      header('Connection: close');
      readfile($path); // push it out
      exit();
    }
  }

  //START EXPORT DATA section
  public function export_data($param1 = '', $param2 = ''){

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

    if($param1 == 'filter'){
      $page_data['data_choosen'] = $this->input->post('data_choosen');
      $this->load->view('backend/admin/export_data/list', $page_data);
    }

    if($param1 == 'download_tahun'){
        //  $semua_pengguna = $this->export_model->getAll()->result();
        $school_id = school_id();
        $data_tahun = $this->db->get_where('years',['school_id'=>$school_id])->result_array();
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Nama Tahun');

        $kolom = 2;
        $nomor = 1;
        foreach($data_tahun as $data) {

              $spreadsheet->setActiveSheetIndex(0)
                          ->setCellValue('A' . $kolom, $data['name']);

              $kolom++;
              $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="Data Tahun.xlsx"');
          header('Cache-Control: max-age=0');

          $writer->save('php://output');
    }

    if($param1 == 'download_siswa'){
        //  $semua_pengguna = $this->export_model->getAll()->result();
        $school_id = school_id();
        $this->db->select('students.id AS student_id, students.nisn AS nisn, students.NIS AS nis, users.name AS nama, users.email, users.password, classes.name AS jurusan, sections.name AS kelas, class_rooms.name AS ruang_kelas, users.address AS alamat, users.phone AS telp, users.gender AS jenis_kelamin, users.blood_group AS golongan_darah');
        $this->db->where('students.school_id',$school_id);
        $this->db->from('students');
        $this->db->join('users','users.id=students.user_id');
        $this->db->join('enrols','enrols.student_id=students.id');
        $this->db->join('class_rooms','enrols.room_id=class_rooms.id');
        $this->db->join('classes','enrols.class_id=classes.id');
        $this->db->join('sections','enrols.section_id=sections.id');
        $data_siswa = $this->db->get()->result_array();
        
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'NISN')
                    ->setCellValue('B1', 'NIS')
                    ->setCellValue('C1', 'Nama')
                    ->setCellValue('D1', 'Email')
                    ->setCellValue('E1', 'Password')
                    ->setCellValue('F1', 'Jurusan')
                    ->setCellValue('G1', 'Kelas')
                    ->setCellValue('H1', 'Ruang Kelas')
                    ->setCellValue('I1', 'Alamat')
                    ->setCellValue('J1', 'Telp')
                    ->setCellValue('K1', 'Jenis Kelamin')
                    ->setCellValue('L1', 'Golongan Darah')
                    ->setCellValue('M1', 'Nama Orang Tua')
                    ->setCellValue('N1', 'Email Orang Tua')
                    ->setCellValue('O1', 'Password')
                    ->setCellValue('P1', 'Alamat')
                    ->setCellValue('Q1', 'Telp')
                    ->setCellValue('R1', 'Jenis Kelamin')
                    ->setCellValue('S1', 'Golongan Darah');

        $kolom = 2;
        $nomor = 1;
        foreach($data_siswa as $data) {

          $this->db->select('users.name AS nama_ortu, users.email AS email_ortu, users.password AS password_ortu, users.address AS alamat_ortu, users.phone AS telp_ortu, users.gender AS jenis_kelamin_ortu, users.blood_group AS golongan_darah_ortu');
          $this->db->where('students.id',$data['student_id']);
          $this->db->from('students');
          $this->db->join('parents','parents.id=students.parent_id');
          $this->db->join('users','users.id=parents.user_id');
          $data_ortu = $this->db->get()->row_array();
          // print_r($this->encrypt->decode($data['password']));die;
          
              $spreadsheet->setActiveSheetIndex(0)
                          ->setCellValue('A' . $kolom, $data['nisn'])
                          ->setCellValue('B' . $kolom, $data['nis'])
                          ->setCellValue('C' . $kolom, $data['nama'])
                          ->setCellValue('D' . $kolom, $data['email'])
                          ->setCellValue('E' . $kolom, $data['password'])
                          ->setCellValue('F' . $kolom, $data['jurusan'])
                          ->setCellValue('G' . $kolom, $data['kelas'])
                          ->setCellValue('H' . $kolom, $data['ruang_kelas'])
                          ->setCellValue('I' . $kolom, $data['alamat'])
                          ->setCellValue('J' . $kolom, $data['telp'])
                          ->setCellValue('K' . $kolom, $data['jenis_kelamin'])
                          ->setCellValue('L' . $kolom, $data['golongan_darah'])
                          ->setCellValue('M' . $kolom, $data_ortu['nama_ortu'])
                          ->setCellValue('N' . $kolom, $data_ortu['email_ortu'])
                          ->setCellValue('O' . $kolom, $data_ortu['password_ortu'])
                          ->setCellValue('P' . $kolom, $data_ortu['alamat_ortu'])
                          ->setCellValue('Q' . $kolom, $data_ortu['telp_ortu'])
                          ->setCellValue('R' . $kolom, $data_ortu['jenis_kelamin_ortu'])
                          ->setCellValue('S' . $kolom, $data_ortu['golongan_darah_ortu']);

              $kolom++;
              $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="Data Siswa.xlsx"');
          header('Cache-Control: max-age=0');

          $writer->save('php://output');
    }

    if($param1 == 'download_pegawai'){
        //  $semua_pengguna = $this->export_model->getAll()->result();
        $school_id = school_id();
        $role_name = array('teacher', 'librarian', 'other_employee', 'accountant', '0');
        $this->db->select('users.nip AS nip, users.name AS nama, users.email AS email, users.password AS password, departments.name AS nama_posisi, users.role AS jabatan, employee_status.name AS status_guru');
        $this->db->or_where_in('users.role', $role_name);	
        $this->db->where('users.school_id', $school_id);
        $this->db->from('users');
        $this->db->join('departments', 'users.department_id=departments.id','left');
        $this->db->join('employee_status', 'users.employee_status_id=employee_status.id','left');
        $data_pegawai = $this->db->get()->result_array();
        
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'NIP')
                    ->setCellValue('B1', 'Nama')
                    ->setCellValue('C1', 'Email')
                    ->setCellValue('D1', 'Password')
                    ->setCellValue('E1', 'Nama Posisi')
                    ->setCellValue('F1', 'Jabatan')
                    ->setCellValue('G1', 'Status Guru');

        $kolom = 2;
        $nomor = 1;
        foreach($data_pegawai as $data) {
          
              $spreadsheet->setActiveSheetIndex(0)
                          ->setCellValue('A' . $kolom, $data['nip'])
                          ->setCellValue('B' . $kolom, $data['nama'])
                          ->setCellValue('C' . $kolom, $data['email'])
                          ->setCellValue('D' . $kolom, $data['password'])
                          ->setCellValue('E' . $kolom, $data['nama_posisi'])
                          ->setCellValue('F' . $kolom, $data['jabatan'])
                          ->setCellValue('G' . $kolom, $data['status_guru']);

              $kolom++;
              $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="Data Pegawai.xlsx"');
          header('Cache-Control: max-age=0');

          $writer->save('php://output');
    }

    if($param1 == 'download_jurusan'){
        //  $semua_pengguna = $this->export_model->getAll()->result();
        $school_id = school_id();	
        $this->db->select('classes.name AS jurusan, sections.name AS kelas');
        $this->db->where('sections.school_id', $school_id);
        $this->db->from('sections');
        $this->db->join('classes', 'classes.id = sections.class_id');
        $this->db->order_by('kelas, jurusan ASC');
        $data_jurusan = $this->db->get()->result_array();
        // print_r($this->db->last_query()); die;
        
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Jurusan')
                    ->setCellValue('B1', 'Kelas');

        $kolom = 2;
        $nomor = 1;
        foreach($data_jurusan as $data) {
          
              $spreadsheet->setActiveSheetIndex(0)
                          ->setCellValue('A' . $kolom, $data['jurusan'])
                          ->setCellValue('B' . $kolom, $data['kelas']);

              $kolom++;
              $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="Data Jurusan.xlsx"');
          header('Cache-Control: max-age=0');

          $writer->save('php://output');
    }

    if($param1 == 'download_mapel'){
        //  $semua_pengguna = $this->export_model->getAll()->result();
        $school_id = school_id();	
        $this->db->select('classes.name AS jurusan, sections.name AS kelas, class_rooms.name AS ruang_kelas, subjects.name AS mapel, teachers.user_id AS id_user, subjects.description');
        $this->db->where('subjects.school_id', $school_id);
        $this->db->from('subjects');
        $this->db->join('sections', 'subjects.section_id = sections.id');
        $this->db->join('classes', 'subjects.class_id = classes.id');
        $this->db->join('teachers', 'subjects.teacher_id = teachers.id');
        $this->db->join('class_rooms', 'subjects.room_id = class_rooms.id');
        $data_mapel = $this->db->get()->result_array();
        // print_r($this->db->last_query()); die;
        
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Jurusan')
                    ->setCellValue('B1', 'Kelas')
                    ->setCellValue('C1', 'Ruang Kelas')
                    ->setCellValue('D1', 'Nama Mata Pelajaran')
                    ->setCellValue('E1', 'Pengajar')
                    ->setCellValue('F1', 'Deskripsi');

        $kolom = 2;
        $nomor = 1;
        foreach($data_mapel as $data) {

              $this->db->select('name AS pengajar');
              $this->db->from('users');
              $this->db->where('id', $data['id_user']);
              $data_pengajar = $this->db->get()->row_array();
              // print_r($this->db->last_query()); die;

              $spreadsheet->setActiveSheetIndex(0)
                          ->setCellValue('A' . $kolom, $data['jurusan'])
                          ->setCellValue('B' . $kolom, $data['kelas'])
                          ->setCellValue('C' . $kolom, $data['ruang_kelas'])
                          ->setCellValue('D' . $kolom, $data['mapel'])
                          ->setCellValue('E' . $kolom, $data_pengajar['pengajar'])
                          ->setCellValue('F' . $kolom, $data['description']);

              $kolom++;
              $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="Data Mata Pelajaran.xlsx"');
          header('Cache-Control: max-age=0');

          $writer->save('php://output');
    }

    if($param1 == 'download_jadwal'){
        //  $semua_pengguna = $this->export_model->getAll()->result();
        $school_id = school_id();	
        $this->db->select('routines.day, classes.name AS jurusan, sections.name AS kelas, class_rooms.name AS ruang_kelas, subjects.name, operational_hour.time_start, operational_hour.time_finish');
        $this->db->where('routines.school_id', $school_id);
        $this->db->from('routines');
        $this->db->join('classes', 'routines.class_id = classes.id');
        $this->db->join('sections', 'routines.section_id = sections.id');
        $this->db->join('class_rooms', 'routines.room_id = class_rooms.id');
        $this->db->join('subjects', 'routines.subject_id = subjects.id');
        $this->db->join('operational_hour', 'routines.hour_id = operational_hour.id');
        $data_jadwal = $this->db->get()->result_array();
        // print_r($this->db->last_query()); die;
        
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Hari')
                    ->setCellValue('B1', 'Jurusan')
                    ->setCellValue('C1', 'Kelas')
                    ->setCellValue('D1', 'Ruang Kelas')
                    ->setCellValue('E1', 'Mata Pelajaran')
                    ->setCellValue('F1', 'Jam Mulai')
                    ->setCellValue('G1', 'Jam Selesai');

        $kolom = 2;
        $nomor = 1;
        foreach($data_jadwal as $data) {

              $spreadsheet->setActiveSheetIndex(0)
                          ->setCellValue('A' . $kolom, get_phrase($data['day']))
                          ->setCellValue('B' . $kolom, $data['jurusan'])
                          ->setCellValue('C' . $kolom, $data['kelas'])
                          ->setCellValue('D' . $kolom, $data['ruang_kelas'])
                          ->setCellValue('E' . $kolom, $data['name'])
                          ->setCellValue('F' . $kolom, $data['time_start'])
                          ->setCellValue('G' . $kolom, $data['time_finish']);

              $kolom++;
              $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="Data Jadwal Pelajaran.xlsx"');
          header('Cache-Control: max-age=0');

          $writer->save('php://output');
    }

    if($param1 == 'download_buku'){
        //  $semua_pengguna = $this->export_model->getAll()->result();
        $school_id = school_id();	
        $this->db->select('books.book_code AS kode_buku, books.name AS nama_buku, book_types.name AS jenis_buku, books.book_release, books.author, books.publisher, books.copies, books.summary');
        $this->db->where('books.school_id', $school_id);
        $this->db->from('books');
        $this->db->join('book_types', 'books.book_type_id = book_types.id');
        $data_buku = $this->db->get()->result_array();
        // print_r($this->db->last_query()); die;
        
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Kode Buku')
                    ->setCellValue('B1', 'Nama Buku')
                    ->setCellValue('C1', 'Jenis Buku')
                    ->setCellValue('D1', 'Tanggal Rilis')
                    ->setCellValue('E1', 'Pengarang')
                    ->setCellValue('F1', 'Penerbit')
                    ->setCellValue('G1', 'Jumlah Salinan')
                    ->setCellValue('H1', 'Ringkasan');

        $kolom = 2;
        $nomor = 1;
        foreach($data_buku as $data) {

              $spreadsheet->setActiveSheetIndex(0)
                          ->setCellValue('A' . $kolom, $data['kode_buku'])
                          ->setCellValue('B' . $kolom, $data['nama_buku'])
                          ->setCellValue('C' . $kolom, $data['jenis_buku'])
                          ->setCellValue('D' . $kolom, $data['book_release'])
                          ->setCellValue('E' . $kolom, $data['author'])
                          ->setCellValue('F' . $kolom, $data['publisher'])
                          ->setCellValue('G' . $kolom, $data['copies'])
                          ->setCellValue('H' . $kolom, $data['summary']);

              $kolom++;
              $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="Data Buku.xlsx"');
          header('Cache-Control: max-age=0');

          $writer->save('php://output');
    }

    if($param1 == 'download_ekskul'){
        //  $semua_pengguna = $this->export_model->getAll()->result();
        $school_id = school_id();
        $this->db->select('*');
        $this->db->where('school_id', $school_id);
        $this->db->from('organizations');
        $data_buku = $this->db->get()->result_array();
        // print_r($this->db->last_query()); die;
        
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'Nama Ekstrakurikuler');

        $kolom = 2;
        $nomor = 1;
        foreach($data_buku as $data) {

              $spreadsheet->setActiveSheetIndex(0)
                          ->setCellValue('A' . $kolom, $data['name']);

              $kolom++;
              $nomor++;

        }

        $writer = new Xlsx($spreadsheet);

          header('Content-Type: application/vnd.ms-excel');
          header('Content-Disposition: attachment;filename="Data Ekstrakurikuler.xlsx"');
          header('Cache-Control: max-age=0');

          $writer->save('php://output');
    }

    // if ($param1 == 'list') {
    //   $this->load->view('backend/superadmin/event_calendar/list');
    // }

    if(empty($param1)){
      $page_data['folder_name'] = 'export_data';
      $page_data['page_title'] = 'export_data';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END EXPORT DATA section
  
  //START INDUSTRY COMPANY section
  public function industry_company($param1 = '', $param2 = ''){

    if ($param1 == 'add') {
      $response = $this->crud_model->create_industry_company();
      echo $response;
    }

    // adding book_issue
    if($param1 == 'create'){
      $page_data['aria_expand'] = 'industry_company';
      $page_data['page_name'] = 'create';
      $page_data['folder_name'] = 'industry_company';
      $page_data['page_title'] = 'create_industry_company';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'update'){
      $response = $this->crud_model->industry_company_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){
      $response = $this->crud_model->industry_company_delete($param2);
      echo $response;
    }

    if($param1 == 'list'){
      $this->load->view('backend/admin/industry_company/list');
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'industry_company';
      $page_data['page_title'] = 'industry_company';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END INDUSTRY COMPANY section 

  //START INTERNSHIP section
  public function internship($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if ($param1 == 'add') {
      $response = $this->crud_model->create_internship();
      echo $response;
    }

    if ($param1 == 'add_student') {
      $response = $this->crud_model->add_internship_student();
      echo $response;
    }

    // adding book_issue
    if($param1 == 'create'){
      $page_data['aria_expand'] = 'internship';
      $page_data['page_name'] = 'create';
      $page_data['folder_name'] = 'internship';
      $page_data['page_title'] = 'create_internship';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'update'){
      $response = $this->crud_model->internship_update($param2);
      echo $response;
    }

    if($param1 == 'delete'){

      $response = $this->crud_model->internship_delete($param2);
      echo $response;
    }

    if($param1 == 'delete_student'){
      $id = $this->input->post('id');

      $response = $this->crud_model->internship_student_delete($id);
      echo $response;
    }

    if($param1 == 'list'){
      $this->load->view('backend/admin/internship/list');
    }

    if($param1 == 'attendance'){
      $page_data['internship_id'] = $param2; 
      $page_data['folder_name'] = 'internship_attendance';
      $page_data['page_title'] = 'internship_attendance';
      $this->load->view('backend/index', $page_data);
    }

    if($param1 == 'attendance_filter'){

      $internship_id = $this->input->post('internship_id');
      $internship = $this->db->get_where('internship', array('id' => $internship_id))->row_array();
      $page_data['internship_id'] = $internship_id;
      $page_data['company_id'] = $internship['company_id'];
      $page_data['month'] = $this->input->post('month');
      $page_data['start_date'] = $internship['start_date'];
      $page_data['end_date'] = $internship['end_date'];

      $this->load->view('backend/admin/internship_attendance/list', $page_data);
    }

    if(empty($param1)){
      $page_data['folder_name'] = 'internship';
      $page_data['page_title'] = 'internship';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END INTERNSHIP section 

  //START INTERNSHIP ATTENDACE section
  public function internship_attendance($param1 = '', $param2 = '', $param3 = '', $param4 = ''){

    if(empty($param1)){
      $page_data['folder_name'] = 'internship_attendance';
      $page_data['page_title'] = 'internship_attendance';
      $this->load->view('backend/index', $page_data);
    }
  }
  //END INTERNSHIP section  
  
  // STUDENT CARD section
  public function student_card($student_id)
  {
    $page_data['student_id'] = $student_id;
    $page_data['folder_name'] = 'student_card';
    $page_data['page_title'] = 'student_card';
    $this->load->view('backend/index', $page_data);    
  }

  public function print_student_card($student_id)
  {
    $page_data['student_id'] = $student_id;
    $this->load->view('backend/admin/student_card/print', $page_data);    
  }

  // BARCODE section
  public function barcode_create($nis)
  {
    /*LOAD ZEND EXTERNAL LIBRARIES*/
    $this->load->library('Zend');

    $this->zend->load('Zend/Barcode');
		// Generate barcode
		Zend_Barcode::render('code128', 'image', array('text'=>$nis, 'drawText' => false), array());
  }
  
  // EMPLOYEE CARD section
  public function employee_card($employee_id)
  {
    $page_data['employee_id'] = $employee_id;
    $page_data['folder_name'] = 'employee_card';
    $page_data['page_title'] = 'employee_card';
    $this->load->view('backend/index', $page_data);    
  }

  public function print_employee_card($employee_id)
  {
    $page_data['employee_id'] = $employee_id;
    $this->load->view('backend/admin/employee_card/print', $page_data);    
  }

  // BARCODE section
  public function employee_barcode_create($nip)
  {
    /*LOAD ZEND EXTERNAL LIBRARIES*/
    $this->load->library('Zend');

    $this->zend->load('Zend/Barcode');
		// Generate barcode
		Zend_Barcode::render('code128', 'image', array('text'=>$nip, 'drawText' => false), array());
  }  
}
