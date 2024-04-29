<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/

class Exam extends CI_Controller {

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
		$this->load->model('addons/Exam_model', 'exam_model');

		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");

		/*SET DEFAULT TIMEZONE*/
		timezone();
	}

//-----------------TEACHER------------------//
	public function index($param1 = "", $param2 = "", $param3 = ""){
		$this->student_exam($param1, $param2, $param3);
	}
	public function student_exam($param1 = "", $param2 = "", $param3 = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		if($param1 == 'create'){
			$response = $this->exam_model->create_exam();
			echo $response;
		}elseif($param1 == 'delete'){
			$response = $this->exam_model->delete_exam($param2);
			echo $response;
		}elseif($param1 == 'update'){
			$response = $this->exam_model->update_exam($param2);
			echo $response;
		}elseif ($param1 == 'list'){
			$page_data['exam_type'] = $param2;
			$this->load->view('backend/teacher/exam_student/list', $page_data);
		}else{
			$page_data['exam_type'] = $param1;
			$page_data['folder_name'] = 'exam_student';
			$page_data['page_title'] = 'exam_students';
			$this->load->view('backend/index', $page_data);
		}
	}
	public function filter_student_exam($param1 = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		$page_data['selected_class_id'] = $this->input->post('class_id');
		$page_data['selected_section_id'] = $this->input->post('section_id');
		$page_data['selected_room_id'] = $this->input->post('room_id');
		$page_data['selected_subject_id'] = $this->input->post('subject_id');
		$page_data['exam_type'] = $param1;
		$this->load->view('backend/teacher/exam_student/list', $page_data);
	}

	public function publish($id = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		$response_json = $this->exam_model->exam_publish($id);
		$response = json_decode($response_json);
		if($response->status){
			echo $response_json;
		}else{
			echo $response_json;
			// $this->session->set_flashdata('error_message', get_phrase('exam_published_failed'));
			// redirect(site_url('addons/exam/student_exam/pending'), 'refresh');
		}
	}

	public function pending($id = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		$response = $this->exam_model->exam_pending($id);
		$response = json_decode($response);
		if($response->status){
			$this->session->set_flashdata('flash_message', $response->notification);
			redirect(site_url('addons/exam/student_exam/published'), 'refresh');
		}else{
			$this->session->set_flashdata('error_message', get_phrase('exam_status_updated_is_not_successfully'));
			redirect(site_url('addons/exam/student_exam/published'), 'refresh');
		}
	}

	public function questions($param1 = "", $param2 = "", $param3 = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		if($param1 == 'create'){
			$response = $this->exam_model->create_question($param2);
			echo $response;
		}

		if($param1 == 'add_question'){
			$response = $this->exam_model->add_question($param2);
			echo $response;
			$this->session->set_flashdata('flash_message', get_phrase('question_added_successfully'));
			redirect(site_url('addons/exam/questions/'.$param2), 'refresh');
		}

		if($param1 == 'add_question_bank'){
			$response = $this->exam_model->add_question_bank($param2);
			echo $response;
		}

		if($param1 == 'take_question'){
			$response = $this->exam_model->take_question($param2,$param3);
			$questions = $this->db->get_where('exam_questions', array('id' => $param3))->row_array();
			echo $response;
			$this->session->set_flashdata('flash_message', get_phrase('question_updated_successfully'));
			redirect(site_url('addons/exam/questions/'.$questions['exam_id']), 'refresh');
		}

		if($param1 == 'excel_question'){
			$response = $this->exam_model->excel_question($param2);
			echo $response;
		}	
		
		if($param1 == 'numbering'){
			$question_id = $this->input->post('allData');
			$i = 1;
			
			foreach($question_id as $key => $value){
			$data['num']    = $i;
			$this->db->where('id', $value);
			$this->db->update('exam_questions', $data);

			$history_data['ket'] = 'Update data exam question '.$value.'';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$i++;
			}
			$response = array(
				'status' => true,
				'notification' => get_phrase('updated_successfully')
			);
			echo $response;
		}

		if($param1 == 'update'){
			$response = $this->exam_model->update_question($param2);
			echo $response;
		}

		if($param1 == 'delete'){
			$response = $this->exam_model->delete_question($param2);
			echo $response;
		}

		if ($param1 == 'list') {
			$page_data['exam_details'] = $this->exam_model->get_exam($param2)->row_array();
			$this->load->view('backend/teacher/exam_student/question_list', $page_data);
		}
		if(empty($param2)){
			$page_data['folder_name'] = 'exam_student';
			$page_data['page_title'] = 'exam_question';
			$page_data['page_name'] = 'questions';
			$page_data['exam_details'] = $this->exam_model->get_exam($param1)->row_array();
			$this->load->view('backend/index', $page_data);
		}
	}
	public function students($param1 = "", $param2 = "", $param3 = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		if($param1 == 'update'){
			$response = $this->exam_model->update_question($param2);
			echo $response;
		}

		if ($param1 == 'list') {
			$page_data['exam_details'] = $this->exam_model->get_exam($param2)->row_array();
			$this->load->view('backend/teacher/exam_student/student_list', $page_data);
		}else{
			$page_data['class_id'] = $param2;
			$page_data['section_id'] = $param3;
			$page_data['folder_name'] = 'exam_student';
			$page_data['page_title'] = 'exam_result';
			$page_data['page_name'] = 'students';
			$page_data['exam_details'] = $this->exam_model->get_exam($param1)->row_array();
			$this->load->view('backend/index', $page_data);
		}
	}

	public function answer_and_mark($exam_id = "", $student_id = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		$page_data['folder_name'] = 'exam_student';
		$page_data['page_title'] = 'answer_and_mark';
		$page_data['page_name'] = 'student_answer_and_mark';
		$page_data['student_id'] = $student_id;

		$page_data['exam_details'] = $this->exam_model->get_exam($exam_id)->row_array();
		$page_data['questions'] = $this->exam_model->get_questions_by_exam($exam_id);
		$this->load->view('backend/index', $page_data);
	}

	public function save_obtained_mark($answer_id = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
		echo $this->exam_model->save_obtained_mark($answer_id);
	}

	public function submit_mark($exam_id = "", $student_id = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

			$this->exam_model->submit_mark($exam_id, $student_id);
			$this->session->set_flashdata('flash_message', get_phrase('mark_submitted_successfully'));
			redirect(site_url('addons/exam/answer_and_mark/'.$exam_id.'/'.$student_id), 'refresh');
	}

	public function update_remark($exam_id = "", $student_id = ""){
		if($this->session->userdata('teacher_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
		$query = $this->db->get_where('exam_remarks', array('exam_id' => $exam_id, 'student_id' => $student_id));
		$data['remark'] = $this->input->post('remark');
		$data['exam_id'] = $exam_id;
		$data['student_id'] = $student_id;
		if($query->num_rows() > 0){
			$this->db->where('exam_id', $exam_id);
			$this->db->where('student_id', $student_id);
			$this->db->update('exam_remarks', $data);

			$history_data['ket'] = 'Update data exam remarks '.$exam_id.'';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}else{
			$this->db->insert('exam_remarks', $data);
			
			$history_data['ket'] = 'Mengisi data exam remarks';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}
		$this->session->set_flashdata('success_message', get_phrase('remark_updated_successfully'));
		redirect(site_url('addons/exam/answer_and_mark/'.$exam_id.'/'.$student_id), 'refresh');

	}
//-----------------TEACHER END------------------//




//-----------------STUDENT------------------//
	public function my_active_exam($param1 = "", $param2 = "", $param3 = ""){
		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		if ($param1 == 'list') {
			$this->load->view('backend/teacher/exam_student/list');
		}

		if(empty($param1)){
			//student enrolment data
			$user_id = $this->session->userdata('user_id');
			$student_id = $this->db->get_where('students', array('user_id' => $user_id))->row('id');
			$this->db->where('student_id', $student_id);
			$enrolment = $this->db->get('enrols')->row_array();

			$page_data['exams'] = $this->exam_model->get_student_exam($enrolment['class_id'], $enrolment['section_id'], 'active');
			$page_data['selected_subject'] = 'all';
			$page_data['selected_teacher'] = 'all';
			$page_data['class_id'] = $enrolment['class_id'];
			$page_data['deadline_status'] = 'active';
			$page_data['folder_name'] = 'exam_student';
			$page_data['page_title'] = 'my_exam';
			$this->load->view('backend/index', $page_data);
			// $this->load->view('backend/student/exam_student/index', $page_data);
		}
	}

	public function filter_my_active_exam(){
		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		$subject_id = $this->input->post('subject_id');
		$teacher_id = $this->input->post('teacher_id');

		$user_id = $this->session->userdata('user_id');
		$student_id = $this->db->get_where('students', array('user_id' => $user_id))->row('id');
		
		$this->db->where('student_id', $student_id);
		$enrolment = $this->db->get('enrols')->row_array();

		if($subject_id == 'all' && $teacher_id == 'all'){
			$page_data['exams'] = $this->exam_model->get_student_exam($enrolment['class_id'], $enrolment['section_id'], 'active');
		}else{
			$page_data['exams'] = $this->exam_model->get_student_exam_by_filter($enrolment['class_id'], $enrolment['section_id'], 'active');
		}
		$page_data['selected_subject'] = $subject_id;
		$page_data['selected_teacher'] = $teacher_id;
		$page_data['class_id'] = $enrolment['class_id'];
		$page_data['deadline_status'] = 'active';
		$this->load->view('backend/student/exam_student/list', $page_data);
	}

	public function my_expired_exam($param1 = "", $param2 = "", $param3 = ""){
		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		if ($param1 == 'list') {
			$this->load->view('backend/teacher/exam_student/list');
		}

		if(empty($param1)){
			//student enrolment data
			$user_id = $this->session->userdata('user_id');
			$student_id = $this->db->get_where('students', array('user_id' => $user_id))->row('id');
			$this->db->where('student_id', $student_id);
			$enrolment = $this->db->get('enrols')->row_array();

			$page_data['exams'] = $this->exam_model->get_student_exam($enrolment['class_id'], $enrolment['section_id'], 'expired');
			$page_data['selected_subject'] = 'all';
			$page_data['selected_teacher'] = 'all';
			$page_data['class_id'] = $enrolment['class_id'];
			$page_data['deadline_status'] = 'expired';
			$page_data['folder_name'] = 'exam_student';
			$page_data['page_title'] = 'my_exam';
			$this->load->view('backend/index', $page_data);
			// $this->load->view('backend/student/exam_student/index', $page_data);
		}
	}

	public function filter_my_expired_exam(){
		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		$subject_id = $this->input->post('subject_id');
		$teacher_id = $this->input->post('teacher_id');

		$user_id = $this->session->userdata('user_id');
		$student_id = $this->db->get_where('students', array('user_id' => $user_id))->row('id');

		$this->db->where('student_id', $student_id);
		$enrolment = $this->db->get('enrols')->row_array();

		if($subject_id == 'all' && $teacher_id == 'all'){
			$page_data['exams'] = $this->exam_model->get_student_exam($enrolment['class_id'], $enrolment['section_id'], 'expired');
		}else{
			$page_data['exams'] = $this->exam_model->get_student_exam_by_filter($enrolment['class_id'], $enrolment['section_id'], 'expired');
		}
		$page_data['selected_subject'] = $subject_id;
		$page_data['selected_teacher'] = $teacher_id;
		$page_data['class_id'] = $enrolment['class_id'];
		$page_data['deadline_status'] = 'expired';
		$this->load->view('backend/student/exam_student/list', $page_data);
	}


	public function exam_questions($param1 = "", $param2 = ""){
		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		$student_id = $this->session->userdata('user_id');
		$query = $this->db->get_where('exam_remarks', array('exam_id' => $param1, 'student_id' => $student_id));
		if($query->num_rows() == 0){
			$data['exam_id'] = $param1;
			$data['student_id'] = $student_id;
			$data['start_exam'] = strtotime(date('H:i:s'));
			$this->db->insert('exam_remarks', $data);
			
			$history_data['ket'] = 'Mengisi data exam remarks';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}
		
		$page_data['exam_details'] = $this->exam_model->get_exam($param1)->row_array();
		$page_data['questions'] = $this->exam_model->get_questions_by_exam($param1);
		$page_data['folder_name'] = 'exam_student';
		$page_data['page_name'] = 'questions';
		$page_data['page_title'] = 'questions';
		$this->load->view('backend/index', $page_data);
		// $this->load->view('backend/student/exam_student/questions', $page_data);
	}

	public function save_answers($question_id = "", $exam_id = ""){
		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		$response = $this->exam_model->save_answers($question_id, $exam_id);
		echo $response;
	}

	public function submit_exam($exam_id = ""){
		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
		$deadline = $this->exam_model->get_exam($exam_id)->row('deadline');
		if($deadline >= strtotime(date('m/d/Y'))){
			$this->exam_model->submit_exam($exam_id);
			$this->session->set_flashdata('flash_message', get_phrase('your_exam_submitted_successfully'));
		}else{
			$this->session->set_flashdata('error_message', get_phrase('your_exam_submitted_deadline_is_over'));
		}
		redirect(site_url('addons/exam/my_active_exam'), 'refresh');
	}

	public function my_exam_result($exam_id = ""){
		if($this->session->userdata('student_login') != 1){
			redirect(site_url('login'), 'refresh');
		}

		$page_data['exam_details'] = $this->exam_model->get_exam($exam_id)->row_array();
		$page_data['questions'] = $this->exam_model->get_questions_by_exam($exam_id);
		$page_data['folder_name'] = 'exam_student';
		$page_data['page_name'] = 'exam_result';
		$page_data['page_title'] = 'exam_result';
		$this->load->view('backend/index', $page_data);
		// $this->load->view('backend/student/exam_student/exam_result', $page_data);
	}
//-----------------STUDENT END------------------//


}