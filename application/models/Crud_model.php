<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/
require APPPATH . 'third_party/phpoffice/vendor/autoload.php';
require APPPATH . 'third_party/PHPExcel/IOFactory.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Crud_model extends CI_Model
{

	protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();
	}


	//START CLASS section
	public function get_classes($id = "")
	{

		// $this->db->where('school_id', $this->school_id);

		if ($id > 0) {
			$this->db->where('id', $id);
		}
		return $this->db->get('classes');
	}

	public function class_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['school_id'] = $this->school_id;
		$this->db->insert('classes', $data);

		$history_data['ket'] = 'Mengisi data ppdb';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$insert_id = $this->db->insert_id();
		$section_data['name'] = ' ';
		$section_data['class_id'] = $insert_id;
		$section_data['school_id'] = $this->school_id;
		$this->db->insert('sections', $section_data);

		$history_data['ket'] = 'Mengisi data sections';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$db2 = $this->load->database('database_sips', TRUE);

		$class_data = $db2->get_where('class', array('class_name' => $data['name']))->row_array();

		if (empty($class_data)) {
			$data_db2['class_name'] = $this->input->post('name');
			$db2->insert('class', $data_db2);
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_added_successfully')
		);
		return json_encode($response);
	}

	public function class_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('classes', $data);

		$history_data['ket'] = 'Update data classes ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$db2 = $this->load->database('database_sips', TRUE);

		$class_data = $db2->get_where('class', array('class_name' => $data['name']))->row_array();

		if (empty($class_data)) {
			$data_db2['class_name'] = $this->input->post('name');
			$db2->where('class_name', $this->input->post('name'));
			$db2->update('class', $data_db2);
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_added_successfully')
		);
		return json_encode($response);
	}

	public function get_sections($id = "")
	{

		if ($id > 0) {
			$this->db->where('id', $id);
		}
		return $this->db->get('sections');
	}

	public function section_update($param1 = '')
	{
		$section_id = html_escape($this->input->post('section_id'));
		$section_name = html_escape($this->input->post('name'));
		$db2 = $this->load->database('database_sips', TRUE);

		foreach ($section_id as $key => $value) {
			if ($value == 0) {
				$data['class_id'] = $param1;
				$data['name'] = $section_name[$key];
				$this->db->insert('sections', $data);

				$history_data['ket'] = 'Mengisi data sections';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$majors_data = $db2->get_where('majors', array('majors_name' => $section_name[$key]))->row_array();

				if (empty($majors_data)) {
					$data_db2['majors_name'] = $section_name[$key];
					$data_db2['majors_short_name'] = $section_name[$key];
					$db2->insert('majors', $data_db2);
				}
			}
			if ($value != 0 && !strpos($value, 'delete')) {
				$data['name'] = $section_name[$key];
				$this->db->where('class_id', $param1);
				$this->db->where('id', $value);
				$this->db->update('sections', $data);

				$history_data['ket'] = 'Update data section ' . $value . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$data_db2['majors_name'] = $section_name[$key];
				$data_db2['majors_short_name'] = $section_name[$key];

				$db2->where('majors_name', $section_name[$key]);
				$db2->update('majors', $data_db2);
			}

			$section_value = null;
			if (strpos($value, 'delete')) {
				$section_value = str_replace('delete', '', $value);
			}
			if ($value == $section_value . 'delete') {
				$data['name'] = $section_name[$key];
				$this->db->where('class_id', $param1);
				$this->db->where('id', $section_value);
				$this->db->delete('sections');

				$history_data['ket'] = 'Delete data sections ' . $section_value . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$db2->where('section_name', $section_name[$key]);
				$db2->delete('majors');
			}
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('section_list_updated_successfully')
		);
		return json_encode($response);
	}

	public function class_delete($param1 = '')
	{
		$classes = $this->db->get_where('classes', array('id' => $param1))->row_array();

		$db2 = $this->load->database('database_sips', TRUE);

		// $class_data = $db2->get_where('class', array('class_name' => $classes['name']))->row_array();

		$db2->where('class_name', $classes['name']);
		$db2->delete('class');

		$this->db->where('id', $param1);
		$this->db->delete('classes');

		$history_data['ket'] = 'Delete data classes ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('class_id', $param1);
		$this->db->delete('sections');

		$history_data['ket'] = 'Delete data sections ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_deleted_successfully')
		);
		return json_encode($response);
	}

	// Get section details by class and section id
	public function get_section_details_by_id($type = "", $id = "")
	{
		$section_details = array();
		if ($type == 'class') {
			$section_details = $this->db->get_where('sections', array('class_id' => $id));
		} elseif ($type == 'section') {
			$section_details = $this->db->get_where('sections', array('id' => $id));
		}
		return $section_details;
	}

	//get Class details by id
	public function get_class_details_by_id($id)
	{
		$class_details = $this->db->get_where('classes', array('id' => $id));
		return $class_details;
	}
	//END CLASS section

	//START section
	public function section_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session_id'] = html_escape($this->input->post('session'));
		$this->db->insert('sections', $data);

		$history_data['ket'] = 'Mengisi data sections';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);

		return json_encode($response);
	}

	public function section_update_one($param1 = '')
	{
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('sections', $data);

		$history_data['ket'] = 'Update data sections ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);

		return json_encode($response);
	}

	public function section_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('sections');

		$history_data['ket'] = 'Delete data sections ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_section_by_id($section_id = '')
	{
		return $this->db->get_where('sections', array('id' => $section_id))->row_array();
	}

	//END section

	// Finance

	// public function get_finances() {
	// 	$checker = array(
	// 		'session' => $this->active_session,
	// 		'school_id' => $this->school_id
	// 	);
	// 	return $this->db->get_where('finances', $checker);
	// }

	public function get_finances()
	{
		$this->db->where('session', $this->active_session);
		$this->db->where('school_id', $this->school_id);
		return $this->db->get('finances');
	}

	// public function get_finances_by_student_id($student_id = "") {
	// 	$this->db->where('student_id', $student_id);
	// 	return $this->db->get('finances');
	// }

	public function get_finances_by_id($id = "")
	{
		return $this->db->get_where('finances', array('id' => $id))->row_array();
	}

	public function create_finances($param1 = '')
	{
		$data['student_id'] = $this->input->post('student_id');
		$student_data = $this->user_model->get_student_details_by_id("student", $data['student_id']);
		$data['payment_type_id']    = $this->input->post('payment_type_id');
		$data['total'] = $this->input->post('total');
		// $file_ext = pathinfo($_FILES['finances_file']['name'], PATHINFO_EXTENSION);
		// $data['file'] = md5(rand(10000000, 20000000)).'.'.$file_ext;
		// move_uploaded_file($_FILES['finances_file']['tmp_name'], 'uploads/finance/'.$data['file']);
		$data['file'] = $this->input->post('file');
		if (empty($data['file'])) {
			$data['file'] = '0';
		}
		$data['status'] = $this->input->post('status');
		if (empty($data['status'])) {
			$data['status'] = '0';
		}

		$data['class_id']   = $this->input->post('class_id');
		if (empty($data['class_id'])) {
			$data['class_id'] = $student_data['class_id'];
		}

		$data['section_id'] = $this->input->post('section_id');
		if (empty($data['section_id'])) {
			$data['section_id'] = $student_data['section_id'];
		}

		$data['date'] = $this->input->post('date');
		if (empty($data['date'])) {
			$data['date'] = date("d-M-Y");
		}

		$data['school_id'] = $this->input->post('school_id');
		if (empty($data['school_id'])) {
			$data['school_id'] = $student_data['school_id'];
		}

		$data['session_id']   = $this->input->post('session_id');
		if (empty($data['session_id'])) {
			$data['session_id'] = active_session();
		}

		$this->db->insert('finances', $data);

		$history_data['ket'] = 'Mengisi data finances';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_payment($param1 = '')
	{
		$file_ext = pathinfo($_FILES['finances_file']['name'], PATHINFO_EXTENSION);
		$data['file'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['finances_file']['tmp_name'], 'uploads/finance/' . $data['file']);

		$this->db->where('id', $param1);
		$this->db->update('finances', array('file' => $data['file']));

		$history_data['ket'] = 'Update data finances ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_finances($param1)
	{
		$finances_details = $this->get_finances_by_id($param1);
		$this->db->where('id', $param1);
		$this->db->delete('finances');

		$history_data['ket'] = 'Delete data finances ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$path = 'uploads/finance/' . $finances_details['file'];

		if (file_exists($path)) {
			unlink($path);
		}
		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	public function accept_finances($param1)
	{
		$finances_details = $this->get_finances_by_id($param1);
		$data['status']   = 1;

		$this->db->where('id', $param1);
		$this->db->update('finances', $data);

		$history_data['ket'] = 'Update data finances ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('accept_successfully')
		);
		return json_encode($response);
	}

	//START CLASS_ROOM section
	public function get_class_room($id = "")
	{

		$this->db->where('school_id', $this->school_id);

		if ($id > 0) {
			$this->db->where('id', $id);
		}
		return $this->db->get('class_rooms');
	}

	public function class_room_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['description'] = html_escape($this->input->post('description'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$this->db->insert('class_rooms', $data);

		$history_data['ket'] = 'Mengisi data class rooms';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('classroom_added_successfully')
		);
		return json_encode($response);
	}

	public function class_room_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['description'] = html_escape($this->input->post('description'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$this->db->where('id', $param1);
		$this->db->update('class_rooms', $data);

		$history_data['ket'] = 'Update data classrooms ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('classroom_updated_successfully')
		);
		return json_encode($response);
	}

	public function class_room_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('class_rooms');

		$history_data['ket'] = 'Delete data class_rooms ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('classroom_deleted_successfully')
		);
		return json_encode($response);
	}
	//END CLASS_ROOM section

	//START student_extracurricular section

	public function get_student_extracurricular_by_id($id = "")
	{
		return $this->db->get_where('student_extracurricular', array('student_id' => $id))->row_array();
	}

	public function student_extracurricular_create()
	{
		$student_id = html_escape($this->input->post('student_id'));

		$student_data = $this->db->get_where('students', array('user_id' => $student_id))->row_array();
		$enroll_data = $this->db->get_where('enrols', array('student_id' => $student_data['id']))->row_array();

		$organizations_id = $this->input->post('organizations_id');
		$organization = implode(",", $organizations_id);
		$data = array(
			'organizations_id' => $organization,
			'student_id' => $student_id,
			'class_id' => $enroll_data['class_id'],
			'section_id' => $enroll_data['section_id'],
			'room_id' => $enroll_data['room_id'],
			'school_id' => $this->school_id,
			'session' => $this->active_session
		);

		$duplication_status = $this->check_duplication('on_create', $data['student_id']);
		if ($duplication_status) {
			$this->db->insert('student_extracurricular', $data);

			$history_data['ket'] = 'Mengisi data student extracurricular';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function student_extracurricular_update($param1 = '', $param2 = '', $param3 = '', $param4 = '')
	{
		$student_extracurricular_details = $this->crud_model->get_student_extracurricular_by_id($param1);

		if (empty($student_extracurricular_details)) {
			$organizations_id = $this->input->post('organizations_id');
			$organization = implode(",", $organizations_id);
			$data = array(
				'organizations_id' => $organization,
				'student_id' => $param1,
				'class_id' => $param2,
				'section_id' => $param3,
				'class_id' => $param4,
				'school_id' => $this->school_id,
				'session' => $this->active_session
			);

			$this->db->insert('student_extracurricular', $data);

			$history_data['ket'] = 'Mengisi data studentextracurricular';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		} else {

			$organizations_id = $this->input->post('organizations_id');
			$organization = implode(",", $organizations_id);
			$data = array(
				'organizations_id' => $organization,
				'school_id' => $this->school_id,
				'session' => $this->active_session
			);
			$this->db->where('student_id', $param1);
			$this->db->update('student_extracurricular', $data);

			$history_data['ket'] = 'Update data student extracuricular ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function student_extracurricular_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('student_extracurricular');

		$history_data['ket'] = 'Delete data student_extracurricular ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}
	//END student_extracurricular section

	//START organizations section
	public function organizations_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$this->db->insert('organizations', $data);

		$history_data['ket'] = 'Mengisi data organizations';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('organizations_added_successfully')
		);
		return json_encode($response);
	}

	public function organizations_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('organizations', $data);

		$history_data['ket'] = 'Update data organizations ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('organizations_updated_successfully')
		);
		return json_encode($response);
	}

	public function organizations_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('organizations');

		$history_data['ket'] = 'Delete data organizations ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('organizations_deleted_successfully')
		);
		return json_encode($response);
	}
	//END organizations section

	//START SEMESTER section
	public function semester_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$this->db->insert('semester', $data);

		$history_data['ket'] = 'Mengisi data semester';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('semester_added_successfully')
		);
		return json_encode($response);
	}

	public function semester_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('semester', $data);

		$history_data['ket'] = 'Update data semester ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('semester_updated_successfully')
		);
		return json_encode($response);
	}

	public function semester_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('semester');

		$history_data['ket'] = 'Delete data semester ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('semester_deleted_successfully')
		);
		return json_encode($response);
	}
	//END SEMESTER section

	//START assignment_types section
	public function assignment_types_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['semester_id'] = html_escape($this->input->post('semester_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session_id']   = $this->active_session;
		$this->db->insert('assignment_types', $data);

		$history_data['ket'] = 'Mengisi data assignment types';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function assignment_types_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['semester_id'] = html_escape($this->input->post('semester_id'));
		$this->db->where('id', $param1);
		$this->db->update('assignment_types', $data);

		$history_data['ket'] = 'Update data assignment types ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function assignment_types_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('assignment_types');

		$history_data['ket'] = 'Delete data assignment_types ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}
	//END assignment_types section

	//START exam_types section
	public function exam_types_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['semester_id'] = html_escape($this->input->post('semester_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session_id']   = $this->active_session;
		$this->db->insert('exam_types', $data);

		$history_data['ket'] = 'Mengisi data exam types';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function exam_types_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['semester_id'] = html_escape($this->input->post('semester_id'));
		$this->db->where('id', $param1);
		$this->db->update('exam_types', $data);

		$history_data['ket'] = 'Update data exam types ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function exam_types_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('exam_types');

		$history_data['ket'] = 'Delete data exam_types ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}
	//END exam_types section

	// ward Manager
	public function get_ward()
	{
		return $this->db->get_where('ward');
	}

	public function get_ward_by_id($id = "")
	{
		return $this->db->get_where('ward', array('id' => $id))->row_array();
	}

	public function create_ward()
	{
		$data['name'] = $this->input->post('name');
		$data['districts_id'] = $this->input->post('districts_id');

		$this->db->insert('ward', $data);

		$history_data['ket'] = 'Mengisi data ward';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_ward($id = "")
	{
		$data['name']  = $this->input->post('name');
		$data['districts_id'] = $this->input->post('districts_id');

		$this->db->where('id', $id);
		$this->db->update('ward', $data);

		$history_data['ket'] = 'Update data ward ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_ward($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('ward');

		$history_data['ket'] = 'Delete data ward ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//end ward steatment

	// district Manager
	public function get_district()
	{
		return $this->db->get_where('district');
	}

	public function get_district_by_id($id = "")
	{
		return $this->db->get_where('district', array('id' => $id))->row_array();
	}

	public function create_district()
	{
		$data['name'] = $this->input->post('name');
		$data['province_id'] = $this->input->post('province_id');

		$this->db->insert('district', $data);

		$history_data['ket'] = 'Mengisi data district';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_district($id = "")
	{
		$data['name']  = $this->input->post('name');
		$data['province_id'] = $this->input->post('province_id');

		$this->db->where('id', $id);
		$this->db->update('district', $data);

		$history_data['ket'] = 'Update data district ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_district($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('district');

		$history_data['ket'] = 'Delete data district ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//end district steatment

	// districts Manager
	public function get_districts()
	{
		return $this->db->get_where('districts');
	}

	public function get_districts_by_id($id = "")
	{
		return $this->db->get_where('districts', array('id' => $id))->row_array();
	}

	public function create_districts()
	{
		$data['name'] = $this->input->post('name');
		$data['district_id'] = $this->input->post('district_id');

		$this->db->insert('districts', $data);

		$history_data['ket'] = 'Mengisi data districts';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_districts($id = "")
	{
		$data['name']  = $this->input->post('name');
		$data['district_id'] = $this->input->post('district_id');

		$this->db->where('id', $id);
		$this->db->update('district_id', $data);

		$history_data['ket'] = 'Update data district id ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_districts($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('districts');

		$history_data['ket'] = 'Delete data districts ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//end districts steatment

	// postcode Manager
	public function get_postcode()
	{
		return $this->db->get_where('postcode');
	}

	public function get_postcode_by_id($id = "")
	{
		return $this->db->get_where('postcode', array('postcode' => $id))->row_array();
	}

	public function create_postcode()
	{
		$data['postcode'] = $this->input->post('postcode');
		$data['districts_id'] = $this->input->post('districts_id');

		$this->db->insert('postcode', $data);

		$history_data['ket'] = 'Mengisi data postcode';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_postcode($id = "")
	{
		$data['postcode']  = $this->input->post('postcode');
		$data['districts_id'] = $this->input->post('districts_id');

		$this->db->where('postcode', $id);
		$this->db->update('postcode', $data);

		$history_data['ket'] = 'Update data postcode ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_postcode($id = "")
	{
		$this->db->where('postcode', $id);
		$this->db->delete('postcode');

		$history_data['ket'] = 'Delete data postcode ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//end postcode steatment

	// province Manager
	public function get_province()
	{
		return $this->db->get_where('province');
	}

	public function get_province_by_id($id = "")
	{
		return $this->db->get_where('province', array('id' => $id))->row_array();
	}

	public function create_province()
	{
		$data['name'] = $this->input->post('name');

		$this->db->insert('province', $data);

		$history_data['ket'] = 'Mengisi data province';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_province($id = "")
	{
		$data['name']  = $this->input->post('name');

		$this->db->where('id', $id);
		$this->db->update('province', $data);

		$history_data['ket'] = 'Update data provinces ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_province($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('province');

		$history_data['ket'] = 'Delete data province ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	public function get_all_session()
	{
		return $this->db->get('sessions');
	}
	//end province steatment

	//START MANAGE_SESSION section
	public function session_create()
	{
		$year_one = $this->input->post('year_one');
		$year_two = $this->input->post('year_two');
		$semester = $this->input->post('semester');

		$data['name'] = "" . $year_one . "/" . $year_two . " " . $semester . "";

		$sessions = $this->db->get_where('sessions', array('name' => $data['name']))->row_array();

		if (empty($sessions)) {
			$this->db->insert('sessions', $data);

			$history_data['ket'] = 'Mengisi data sessions';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$db2 = $this->load->database('database_sips', TRUE);

			$period_data = $db2->get_where('period', array('period_start' => $year_one, 'period_end' => $year_two))->row_array();

			if (empty($period_data)) {
				$data_db2['period_start'] = $year_one;
				$data_db2['period_end'] = $year_two;
				$data_db2['period_status'] = '0';
				$db2->insert('period', $data_db2);
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('session_has_been_created_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('gagal_data_ada_yang_sama')
			);
		}

		return json_encode($response);
	}

	public function session_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('session_title'));
		$this->db->where('id', $param1);
		$this->db->update('sessions', $data);

		$history_data['ket'] = 'Update data sessions ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function session_delete($param1 = '')
	{
		$sessions = $this->db->get_where('sessions', array('id' => $param1))->row_array();
		$session = explode("/", $sessions['name']);

		$db2 = $this->load->database('database_sips', TRUE);

		$period_data = $db2->get_where('period', array('period_start' => $session[0], 'period_end' => $session[1]))->row_array();
		$db2->where('period_id', $period_data['period_id']);
		$db2->delete('period');

		$this->db->where('id', $param1);
		$this->db->delete('sessions');

		$history_data['ket'] = 'Delete data sessions ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function active_session($param1 = '')
	{
		$previous_session_id = active_session();
		$this->db->where('id', $previous_session_id);
		$this->db->update('sessions', array('status' => 0));

		$history_data['ket'] = 'Update data sessions ' . $previous_session_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('id', $param1);
		$this->db->update('sessions', array('status' => 1));

		$history_data['ket'] = 'Update data sessions ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$sessions = $this->db->get_where('sessions', array('id' => $param1))->row_array();
		$session = explode("/", $sessions['name']);

		$year_two = explode(" ", $session[1]);

		$db2 = $this->load->database('database_sips', TRUE);

		$period_data = $db2->get_where('period', array('period_start' => $session[0], 'period_end' => $year_two[0]))->row_array();

		if (!empty($period_data)) {
			$off_status_data = $db2->get_where('period', array('period_status' => '1'))->row_array();
			$db2->where('period_id', $off_status_data['period_id']);
			$db2->update('period', array('period_status' => '0'));

			$db2->where('period_id', $period_data['period_id']);
			$db2->update('period', array('period_status' => '1'));
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('session_has_been_activated')
		);
		return json_encode($response);
	}
	//END MANAGE_SESSION section

	//START SUBJECT section
	public function subject_create()
	{
		$room_id = html_escape($this->input->post('class_id'));
		$class_rooms = $this->db->get_where('class_rooms', array('id' => $room_id))->row_array();
		$sections = $this->db->get_where('sections', array('id' => $class_rooms['section_id']))->row_array();

		$data['name'] = html_escape($this->input->post('name'));
		$data['class_id'] = $sections['class_id'];
		$data['section_id'] = $class_rooms['section_id'];
		$data['room_id'] = $room_id;
		$data['description'] = html_escape($this->input->post('description'));
		$data['teacher_id'] = html_escape($this->input->post('teacher_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = html_escape($this->input->post('session'));
		$this->db->insert('subjects', $data);

		$history_data['ket'] = 'Mengisi data subjects';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function subject_update($param1 = '')
	{
		$room_id = html_escape($this->input->post('class_id'));

		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['name'] = html_escape($this->input->post('name'));
		$data['room_id'] = $room_id;
		$data['teacher_id'] = html_escape($this->input->post('teacher_id'));
		$data['description'] = html_escape($this->input->post('description'));
		$this->db->where('id', $param1);
		$this->db->update('subjects', $data);

		$history_data['ket'] = 'Update data subject ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function subject_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('subjects');

		$history_data['ket'] = 'Delete data subjects ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('subject_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_subject_by_id($subject_id = '')
	{
		return $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
	}

	public function get_subjects($id = "")
	{

		$this->db->where('school_id', $this->school_id);

		if ($id > 0) {
			$this->db->where('id', $id);
		}
		return $this->db->get('subjects');
	}

	//END SUBJECT section

	//START knowledge_base section
	public function knowledge_base_create()
	{
		$subject_id = html_escape($this->input->post('subject_id'));
		$subject_data = $this->db->get_where('subjects', array('id' => $subject_id))->row_array();

		$data['name'] = html_escape($this->input->post('name'));
		$data['section_id'] = $subject_data['section_id'];
		$data['class_id'] = $subject_data['class_id'];
		$data['subject_id'] = $subject_id;
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session_id'] = $this->active_session;
		$this->db->insert('knowledge_base', $data);

		$history_data['ket'] = 'Mengisi data knowledge base';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('knowledge_base_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function knowledge_base_update($param1 = '')
	{
		$subject_id = html_escape($this->input->post('subject_id'));
		$subject_data = $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
		$data['section_id'] = $subject_data['section_id'];
		$data['class_id'] = $subject_data['class_id'];
		$data['subject_id'] = $subject_id;
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('knowledge_base', $data);

		$history_data['ket'] = 'Update data knowledge base ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('knowledge_base_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function knowledge_base_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('knowledge_base');

		$history_data['ket'] = 'Delete data knowledge_base ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('knowledge_base_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_knowledge_base_by_id($base_id = '')
	{
		return $this->db->get_where('knowledge_base', array('id' => $base_id))->row_array();
	}

	//END knowledge_base section

	//START QUESTION BANK section
	public function excel_question_bank()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;
		$teacher_id = $this->input->post('teacher_id');

		$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
		$classes = [];
		foreach ($classes_query as $class) {
			$classes[strtolower($class['name'])] = [
				'_id' => $class['id'],
			];
			$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
			foreach ($sections as $section) {
				$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
			}
		}

		$mapel_query = $this->db->get_where('subjects', array('school_id' => $school_id, 'session' => $session_id))->result_array();
		$subjects = [];
		foreach ($mapel_query as $mapel) {
			$subjects[$mapel['section_id']][strtolower($mapel['name'])] = $mapel['id'];
		}

		$base_query = $this->db->get_where('knowledge_base', array('school_id' => $school_id, 'session_id' => $session_id))->result_array();
		$bases = [];
		foreach ($base_query as $base) {
			$bases[$base['subject_id']][strtolower($base['name'])] = $base['id'];
		}

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadquestion.csv');

		if (($handle = fopen('uploads/csv_file/uploadquestion.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {

					$question_type = '';
					switch (trim($all_data[5])) {
						case 'pilihan':
							$question_type = 'choices';
							break;
						case 'pilihan ganda':
							$question_type = 'choices';
							break;
						case 'text':
							$question_type = 'text';
							break;
						case 'file':
							$question_type = 'file';
							break;
						default:
							$question_type = 'text';
							break;
					}

					$level = '';
					switch (trim($all_data[6])) {
						case 'sedang':
							$level = 'sedang';
							break;
						case 'sulit':
							$level = 'sulit';
							break;
						case 'mudah':
							$level = 'mudah';
							break;
						default:
							$level = 'sedang';
							break;
					}

					$kelas = strtolower(trim($all_data[0]));
					$bagian = strtolower(trim($all_data[1]));
					$mapel = strtolower(trim($all_data[2]));
					$base = strtolower(trim($all_data[3]));

					if (array_key_exists($kelas, $classes)) {
						$questiondata['class_id'] = $classes[$kelas]['_id'];
						if (array_key_exists($bagian, $classes[$kelas])) {
							$questiondata['section_id'] = $classes[$kelas][$bagian];
						}
					}

					if (array_key_exists('section_id', $questiondata)) {
						if (array_key_exists($questiondata['section_id'], $subjects)) {
							if (array_key_exists($mapel, $subjects[$questiondata['section_id']])) {
								$questiondata['subject_id'] = $subjects[$questiondata['section_id']][$mapel];
							}
						}
					}

					if (array_key_exists('subject_id', $questiondata)) {
						if (array_key_exists($questiondata['subject_id'], $bases)) {
							if (array_key_exists($base, $bases[$questiondata['subject_id']])) {
								$questiondata['base_id'] = $bases[$questiondata['subject_id']][$base];
							}
						}
					}

					$questiondata['teacher_id'] = $teacher_id;
					$questiondata['question'] = trim($all_data[4]);
					$questiondata['level'] = $level;
					$questiondata['choices'] = trim($all_data[7]);
					$questiondata['correct_choices'] = trim($all_data[8]);
					$questiondata['question_type'] = $question_type;
					$questiondata['session_id'] = $session_id;
					$questiondata['school_id'] = $school_id;

					$this->db->insert('question_bank', $questiondata);

					$history_data['ket'] = 'Mengisi data question bank';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('data sudah ada')
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function question_bank_create()
	{
		$choices_array = $this->input->post('choices_array');
		$choices = implode(";", $choices_array);
		$data['question'] = html_escape($this->input->post('question'));

		$subject_id = html_escape($this->input->post('subject_id'));
		$subject_data =  $this->db->get_where('subjects', array('id' => $subject_id))->row_array();

		$data = array(
			'choices' => $choices,
			'correct_choices' => $this->input->post('correct_choices'),
			'level' => htmlspecialchars($this->input->post('level')),
			'question_type' => htmlspecialchars($this->input->post('question_type')),
			'question' => htmlspecialchars($this->input->post('question')),
			'subject_id' => $subject_id,
			'class_id' => $subject_data['class_id'],
			'section_id' => $subject_data['section_id'],
			'teacher_id' => $subject_data['teacher_id'],
			'base_id' => htmlspecialchars($this->input->post('base_id')),
			'school_id' => html_escape($this->input->post('school_id')),
			'session_id' => $this->active_session
		);

		$this->db->insert('question_bank', $data);

		$history_data['ket'] = 'Mengisi data questin bank';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);

		return json_encode($response);
	}

	public function question_bank_update($param1 = '')
	{
		$choices_array = $this->input->post('choices_array');
		$choices = implode(";", $choices_array);

		$data = array(
			'choices' => $choices,
			'level' => $this->input->post('level'),
			'question_type' => htmlspecialchars($this->input->post('question_type')),
			'question' => htmlspecialchars($this->input->post('question')),
			'correct_choices' => $this->input->post('correct_choices')
		);

		$this->db->where('id', $param1);
		$this->db->update('question_bank', $data);

		$history_data['ket'] = 'Update data question bank ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);

		return json_encode($response);
	}

	public function question_bank_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('question_bank');

		$history_data['ket'] = 'Delete data question_bank ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('question_bankdeleted_successfully')
		);

		return json_encode($response);
	}

	public function get_question_bank_by_id($question_id = '')
	{
		return $this->db->get_where('question_bank', array('id' => $question_id))->row_array();
	}

	//END QUESTION BANK section

	//START DEPARTMENT section
	public function department_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$this->db->insert('departments', $data);

		$history_data['ket'] = 'Mengisi data department';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('department_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function department_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('departments', $data);

		$history_data['ket'] = 'Update data department ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('department_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function department_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('departments');

		$history_data['ket'] = 'Delete data departments ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('department_has_been_deleted_successfully')
		);

		return json_encode($response);
	}
	//END DEPARTMENT section

	//START EMLPOYEE_STATUS section
	public function reset_employee_employee()
	{
		$data['password'] = sha1('123456');
		$role_name = array('teacher', 'librarian', 'other_employee', 'accountant');
		$this->db->or_where_in('role', $role_name);
		$this->db->update('users', $data);

		$history_data['ket'] = 'Update data users ' . $role_name . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('reset_password_successfully')
		);
		return json_encode($response);
	}
	public function reset_employee_password_by_id($param1 = '')
	{
		$data['password'] = sha1('123456');
		$this->db->where('id', $param1);
		$this->db->update('users', $data);

		$history_data['ket'] = 'Update data users ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('reset_password_successfully')
		);
		return json_encode($response);
	}
	public function employee_status_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$this->db->insert('employee_status', $data);

		$history_data['ket'] = 'Mengisi data employye status';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);


		$response = array(
			'status' => true,
			'notification' => get_phrase('employee_status_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function employee_status_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$this->db->where('id', $param1);
		$this->db->update('employee_status', $data);

		$history_data['ket'] = 'Update data employee_status ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('employee_status_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function employee_status_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('employee_status');

		$history_data['ket'] = 'Delete data employee_status ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('employee_status_has_been_deleted_successfully')
		);

		return json_encode($response);
	}
	//END EMLPOYEE_STATUS section

	//START OPERATIONAL_HOUR section
	public function operational_hour_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['time_start'] = html_escape($this->input->post('time_start'));
		$data['time_finish'] = html_escape($this->input->post('time_finish'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$this->db->insert('operational_hour', $data);

		$history_data['ket'] = 'Mengisi data operational hour';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('operational_hour_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function operational_hour_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['time_start'] = html_escape($this->input->post('time_start'));
		$data['time_finish'] = html_escape($this->input->post('time_finish'));
		$this->db->where('id', $param1);
		$this->db->update('operational_hour', $data);

		$history_data['ket'] = 'Update data operationan hour ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('operational_hour_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function operational_hour_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('operational_hour');

		$history_data['ket'] = 'Delete data operational_hour ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('operational_hour_has_been_deleted_successfully')
		);

		return json_encode($response);
	}
	//END OPERATIONAL_HOUR section

	//START PAYMENT_PPDB section
	public function financial_delete()
	{
		$id = $this->input->post('id');

		$this->db->where('id', $id);
		$this->db->delete('payment_ppdb');

		$history_data['ket'] = 'Delete data payment_ppdb ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);

		return json_encode($response);
	}
	//END PAYMENT_PPDB section

	//START REGISTRATION_PATH section
	public function registration_path_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['total'] = html_escape($this->input->post('total'));
		$data['minimum_cicilan_pertama'] = html_escape($this->input->post('minimum_cicilan_pertama'));
		$this->db->insert('registration_path', $data);

		$history_data['ket'] = 'Mengisi data registration path';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('registration_path_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function registration_path_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['total'] = html_escape($this->input->post('total'));
		$data['minimum_cicilan_pertama'] = html_escape($this->input->post('minimum_cicilan_pertama'));
		$this->db->where('id', $param1);
		$this->db->update('registration_path', $data);

		$history_data['ket'] = 'Update data registtration path ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('registration_path_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function registration_path_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('registration_path');

		$history_data['ket'] = 'Delete data registration_path ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('registration_path_has_been_deleted_successfully')
		);

		return json_encode($response);
	}
	//END REGISTRATION_PATH section

	//START SYLLABUS section
	public function syllabus_create($param1 = '')
	{
		$data['title'] = html_escape($this->input->post('title'));
		$subject_id = html_escape($this->input->post('subject_id'));
		$subject_data = $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
		$section_data = $this->db->get_where('sections', array('id' => $subject_data['section_id']))->row_array();
		$room_data = $this->db->get_where('class_rooms', array('section_id' => $section_data['id']))->row_array();

		$data['class_id'] = $section_data['class_id'];
		$data['room_id'] = $room_data['id'];
		$data['section_id'] = $section_data['id'];
		$data['subject_id'] = $subject_id;
		$data['session_id'] = html_escape($this->input->post('session_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$file_ext = pathinfo($_FILES['syllabus_file']['name'], PATHINFO_EXTENSION);
		$data['file'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['syllabus_file']['tmp_name'], 'uploads/syllabus/' . $data['file']);
		$this->db->insert('syllabuses', $data);

		$history_data['ket'] = 'Mengisi data syllabuses';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('syllabus_added_successfully')
		);
		return json_encode($response);
	}
	public function syllabus_delete($param1)
	{
		$syllabus_details = $this->get_syllabus_by_id($param1);
		$this->db->where('id', $param1);
		$this->db->delete('syllabuses');

		$history_data['ket'] = 'Delete data syllabuses ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$path = 'uploads/syllabus/' . $syllabus_details['file'];
		if (file_exists($path)) {
			unlink($path);
		}
		$response = array(
			'status' => true,
			'notification' => get_phrase('syllabus_deleted_successfully')
		);
		return json_encode($response);
	}

	public function get_syllabus_by_id($syllabus_id = "")
	{
		return $this->db->get_where('syllabuses', array('id' => $syllabus_id))->row_array();
	}
	//END SYLLABUS section

	//START SYLLABUS section
	public function materials_create($param1 = '')
	{
		$data['title'] = html_escape($this->input->post('title'));
		$data['date'] = $this->input->post('date') . ' 00:00:1';
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['room_id'] = html_escape($this->input->post('room_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['session_id'] = html_escape($this->input->post('session_id'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$file_ext = pathinfo($_FILES['materials_file']['name'], PATHINFO_EXTENSION);
		$data['file'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['materials_file']['tmp_name'], 'uploads/materials/' . $data['file']);
		$this->db->insert('materials', $data);

		$history_data['ket'] = 'Mengisi data materials';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('materials_added_successfully')
		);
		return json_encode($response);
	}
	public function materials_delete($param1)
	{
		$materials_details = $this->get_materials_by_id($param1);
		$this->db->where('id', $param1);
		$this->db->delete('materials');

		$history_data['ket'] = 'Delete data materials ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$path = 'uploads/materials/' . $materials_details['file'];
		if (file_exists($path)) {
			unlink($path);
		}
		$response = array(
			'status' => true,
			'notification' => get_phrase('materials_deleted_successfully')
		);
		return json_encode($response);
	}

	public function get_materials_by_id($materials_id = "")
	{
		return $this->db->get_where('materials', array('id' => $materials_id))->row_array();
	}
	//END SYLLABUS section

	//START CLASS ROUTINE section
	public function routine_create()
	{
		$_hour_id = html_escape($this->input->post('hour_id'));
		$_subject_id = html_escape($this->input->post('subject_id'));

		for ($i = 0; $i < count($_hour_id); $i++) {
			$hour_id = $_hour_id[$i];
			$subject_id = $_subject_id[$i];

			$day = html_escape($this->input->post('day'));

			$subject_data = $this->db->get_where('subjects', array('id' => $subject_id))->row_array();
			$data['class_id'] = $subject_data['class_id'];
			$data['subject_id'] = $subject_id;
			$data['section_id'] = $subject_data['section_id'];
			$data['teacher_id'] = $subject_data['teacher_id'];
			$data['room_id'] = $subject_data['room_id'];
			$data['day'] = $day;
			$data['hour_id'] = $hour_id;
			$data['school_id'] = $this->school_id;
			$data['session_id'] = $this->active_session;
			$this->db->insert('routines', $data);

			$history_data['ket'] = 'Mengisi data routines';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}


		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function routine_add()
	{
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));

		$subject_data = $this->db->get_where('subjects', array('id' => $data['subject_id']))->row_array();

		$data['teacher_id'] = $subject_data['teacher_id'];
		$data['room_id'] = html_escape($this->input->post('room_id'));
		$data['day'] = html_escape($this->input->post('day'));
		$data['hour_id'] = html_escape($this->input->post('hour_id'));
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		$this->db->insert('routines', $data);

		$history_data['ket'] = 'Mengisi data routines';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_routine_added_successfully')
		);

		return $response;
	}

	public function routine_update($param1 = '')
	{
		$subject_id = html_escape($this->input->post('subject_id'));

		$subject_data = $this->db->get_where('subjects', array('id' => $subject_id))->row_array();

		$data['class_id'] = $subject_data['class_id'];
		$data['section_id'] = $subject_data['section_id'];
		$data['subject_id'] = $subject_id;
		$data['room_id'] = $subject_data['room_id'];
		$data['day'] = html_escape($this->input->post('day'));
		$data['hour_id'] = html_escape($this->input->post('hour_id'));
		$this->db->where('id', $param1);
		$this->db->update('routines', $data);

		$history_data['ket'] = 'Update data routines ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_routine_updated_successfully')
		);

		return json_encode($response);
	}

	public function routine_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('routines');

		$history_data['ket'] = 'Delete data routines ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('class_routine_deleted_successfully')
		);

		return json_encode($response);
	}
	//END CLASS ROUTINE section

	//START routine_extracurricular section
	public function routine_extracurricular_create()
	{
		$duplication_counter = 0;
		$organizations_id = html_escape($this->input->post('organizations_id'));
		$teacher_id = html_escape($this->input->post('teacher_id'));

		$day = html_escape($this->input->post('day'));
		$hour_id = html_escape($this->input->post('hour_id'));

		foreach ($day as $key => $value) :
			$data['organizations_id'] = $organizations_id;
			$data['teacher_id'] = $teacher_id;
			$data['day'] = $day[$key];
			$data['hour_id'] = $hour_id[$key];
			$data['school_id'] = $this->school_id;
			$data['session_id'] = $this->active_session;
			$this->db->insert('routine_extracurricular', $data);

			$history_data['ket'] = 'Mengisi data routine extracurricular';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$duplication_counter++;

		endforeach;

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);

		return json_encode($response);
	}

	public function routine_extracurricular_update($param1 = '')
	{
		$data['organizations_id'] = html_escape($this->input->post('organizations_id'));
		$data['teacher_id'] = html_escape($this->input->post('teacher_id'));
		$data['day'] = html_escape($this->input->post('day'));
		$data['hour_id'] = html_escape($this->input->post('hour_id'));
		$this->db->where('id', $param1);
		$this->db->update('routine_extracurricular', $data);

		$history_data['ket'] = 'Update data routine extracurricular ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);

		return json_encode($response);
	}

	public function routine_extracurricular_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('routine_extracurricular');

		$history_data['ket'] = 'Delete data routine_extracurricular ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);

		return json_encode($response);
	}
	//END CLASS ROUTINE section

	//START DAILY attendance_employee
	public function take_attendance_employee()
	{
		$employees = $this->input->post('user_id');
		$data['timestamp'] = strtotime($this->input->post('date'));
		$data['role'] = $this->input->post('role');
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;

		$check_data = $this->db->get_where('daily_attendance_employee', array('timestamp' => $data['timestamp'], 'role' => $data['role'], 'school_id' => $data['school_id']));
		if ($check_data->num_rows() > 0) {
			foreach ($employees as $key => $employee) :
				$data['status'] = $this->input->post('status-' . $employee);
				$data['user_id'] = $employee;
				$attendance_id = $this->input->post('attendance_id');
				$this->db->where('id', $attendance_id[$key]);
				$this->db->update('daily_attendance_employee', $data);

				$history_data['ket'] = 'Update data daily attendance employee ' . $attendance_id[$key] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			endforeach;
		} else {
			foreach ($employees as $employee) :
				$data['status'] = $this->input->post('status-' . $employee);
				$data['user_id'] = $employee;
				$this->db->insert('daily_attendance_employee', $data);

				$history_data['ket'] = 'Mengisi data absensi pegawai';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			endforeach;
		}

		$this->settings_model->last_updated_attendance_data();

		$response = array(
			'status' => true,
			'notification' => get_phrase('attendance_updated_successfully')
		);

		return json_encode($response);
	}

	public function get_todays_attendance_employee()
	{
		$checker = array(
			'timestamp' => strtotime(date('Y-m-d')),
			'school_id' => $this->school_id,
			'status'    => 1
		);
		$todays_attendance = $this->db->get_where('daily_attendance_employee', $checker);
		return $todays_attendance->num_rows();
	}
	//END DAILY attendance_employee

	//START DAILY ATTENDANCE Teacher
	public function take_attendance_teacher()
	{
		$teachers = $this->input->post('teacher_id');
		$data['timestamp'] = strtotime($this->input->post('date'));
		// $data['role'] = $this->input->post('role');
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		$check_data = $this->db->get_where('daily_attendance_teachers', array('timestamp' => $data['timestamp'], 'session_id' => $data['session_id'], 'school_id' => $data['school_id']));
		if ($check_data->num_rows() > 0) {
			foreach ($teachers as $key => $teacher) :
				$data['status'] = $this->input->post('status-' . $teacher);
				$data['teacher_id'] = $teacher;
				$attendance_id = $this->input->post('attendance_id');
				$this->db->where('id', $attendance_id[$key]);
				$this->db->update('daily_attendance_teachers', $data);

				$history_data['ket'] = 'Update data daily_attendance_teachers ' . $attendance_id[$key] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

			endforeach;
		} else {
			foreach ($teachers as $teacher) :
				$data['status'] = $this->input->post('status-' . $teacher);
				$data['teacher_id'] = $teacher;
				$this->db->insert('daily_attendance_teachers', $data);

				$history_data['ket'] = 'Mengisi data absensi guru';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			endforeach;
		}

		$this->settings_model->last_updated_attendance_data();

		$response = array(
			'status' => true,
			'notification' => get_phrase('attendance_updated_successfully')
		);

		return json_encode($response);
	}

	public function get_todays_attendance_teacher()
	{
		$checker = array(
			'timestamp' => strtotime(date('Y-m-d')),
			'school_id' => $this->school_id,
			'status'    => 1
		);
		$todays_attendance = $this->db->get_where('daily_attendance_teachers', $checker);
		return $todays_attendance->num_rows();
	}
	// //END DAILY ATTENDANCE Teacher

	// //START DAILY ATTENDANCE librarian
	public function take_attendance_librarian()
	{
		$librarians = $this->input->post('user_id');
		$data['timestamp'] = strtotime($this->input->post('date'));
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		$check_data = $this->db->get_where('daily_attendance_librarians', array('timestamp' => $data['timestamp'], 'session_id' => $data['session_id'], 'school_id' => $data['school_id']));
		if ($check_data->num_rows() > 0) {
			foreach ($librarians as $key => $librarian) :
				$data['status'] = $this->input->post('status-' . $librarian);
				$data['user_id'] = $librarian;
				$attendance_id = $this->input->post('attendance_id');
				$this->db->where('id', $attendance_id[$key]);
				$this->db->update('daily_attendance_librarians', $data);

				$history_data['ket'] = 'Update data daily_attendance_librarians ' . $attendance_id[$key] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

			endforeach;
		} else {
			foreach ($librarians as $librarian) :
				$data['status'] = $this->input->post('status-' . $librarian);
				$data['user_id'] = $librarian;
				$this->db->insert('daily_attendance_librarians', $data);

				$history_data['ket'] = 'Mengisi data absensi petugas perpus';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			endforeach;
		}

		$this->settings_model->last_updated_attendance_data();

		$response = array(
			'status' => true,
			'notification' => get_phrase('attendance_updated_successfully')
		);

		return json_encode($response);
	}

	public function get_todays_attendance_librarian()
	{
		$checker = array(
			'timestamp' => strtotime(date('Y-m-d')),
			'school_id' => $this->school_id,
			'status'    => 1
		);
		$todays_attendance = $this->db->get_where('daily_attendance_librarians', $checker);
		return $todays_attendance->num_rows();
	}
	// //END DAILY ATTENDANCE librarian

	// //START DAILY ATTENDANCE accountant
	public function take_attendance_accountant()
	{
		$accountants = $this->input->post('user_id');
		$data['timestamp'] = strtotime($this->input->post('date'));
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		$check_data = $this->db->get_where('daily_attendance_accountants', array('timestamp' => $data['timestamp'], 'session_id' => $data['session_id'], 'school_id' => $data['school_id']));
		if ($check_data->num_rows() > 0) {
			foreach ($accountants as $key => $accountant) :
				$data['status'] = $this->input->post('status-' . $accountant);
				$data['user_id'] = $accountant;
				$attendance_id = $this->input->post('attendance_id');
				$this->db->where('id', $attendance_id[$key]);
				$this->db->update('daily_attendance_accountants', $data);

				$history_data['ket'] = 'Update data daily_attendance_accountants ' . $attendance_id[$key] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

			endforeach;
		} else {
			foreach ($accountants as $accountant) :
				$data['status'] = $this->input->post('status-' . $accountant);
				$data['user_id'] = $accountant;
				$this->db->insert('daily_attendance_accountants', $data);

				$history_data['ket'] = 'Mengisi data absensi akuntan';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			endforeach;
		}

		$this->settings_model->last_updated_attendance_data();

		$response = array(
			'status' => true,
			'notification' => get_phrase('attendance_updated_successfully')
		);

		return json_encode($response);
	}

	public function get_todays_attendance_accountant()
	{
		$checker = array(
			'timestamp' => strtotime(date('Y-m-d')),
			'status'    => 1
		);
		$todays_attendance = $this->db->get_where('daily_attendance_librarians', $checker);
		return $todays_attendance->num_rows();
	}
	//END DAILY ATTENDANCE accountant

	//START DAILY ATTENDANCE section
	public function take_attendance()
	{
		$students = $this->input->post('student_id');
		$data['timestamp'] = strtotime($this->input->post('date'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		$check_data = $this->db->get_where('daily_attendances', array('timestamp' => $data['timestamp'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'session_id' => $data['session_id'], 'school_id' => $data['school_id']));
		if ($check_data->num_rows() > 0) {
			foreach ($students as $key => $student) :
				$data['status'] = $this->input->post('status-' . $student);
				$data['student_id'] = $student;
				$attendance_id = $this->input->post('attendance_id');
				$this->db->where('id', $attendance_id[$key]);
				$this->db->update('daily_attendances', $data);

				$history_data['ket'] = 'Update data daily_attendances ' . $attendance_id[$key] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

			endforeach;
		} else {
			foreach ($students as $student) :
				$data['status'] = $this->input->post('status-' . $student);
				$data['student_id'] = $student;
				$this->db->insert('daily_attendances', $data);

				$history_data['ket'] = 'Mengisi data absensi murid';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			endforeach;
		}

		$this->settings_model->last_updated_attendance_data();

		$response = array(
			'status' => true,
			'notification' => get_phrase('attendance_updated_successfully')
		);

		return json_encode($response);
	}

	public function confirm($param1 = '')
	{
		$data['confirm'] = html_escape($this->input->post('confirm'));
		$data['caption'] = html_escape($this->input->post('caption'));

		// if(empty($data['caption'])){
		// 	$data['caption'] = '0';
		// }

		$file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		if (!empty($file_ext)) {
			$data['file'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
			move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/attendances/' . $data['file']);
		} elseif (empty($file_ext)) {
			$data['file'] = '0';
		}

		$this->db->where('id', $param1);
		$this->db->update('daily_attendances', $data);

		$history_data['ket'] = 'Update data daily_attendances ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function confirm_all($param1 = '')
	{
		$data['confirm'] = html_escape($this->input->post('confirm'));
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$number_of_days = date('t', strtotime($month . ' ' . $year));
		for ($i = 1; $i <= $number_of_days; $i++) :
			$date = $i . ' ' . $month . ' ' . $year;
			$timestamp = strtotime($date);

			// var_dump($timestamp);
			// endfor; 
			// die;

			// $daily_attendances = $this->db->get_where('daily_attendances', array('student_id' => $param1, 'timestamp' => $timestamp))->result_array();
			// if ($daily_attendances > 0) {
			$this->db->where('timestamp', $timestamp);
			$this->db->where('student_id', $param1);
			$this->db->update('daily_attendances', $data);

			$history_data['ket'] = 'Update data daily_attendances ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		// } else {
		// 	echo "cant";
		// }
		endfor;

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function confirm_routine_student($param1 = '')
	{
		$subject_id = html_escape($this->input->post('subject_id'));
		$data['confirm'] = html_escape($this->input->post('confirm'));
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$number_of_days = date('t', strtotime($month . ' ' . $year));
		for ($i = 1; $i <= $number_of_days; $i++) :
			$date = $i . ' ' . $month . ' ' . $year;
			$timestamp = strtotime($date);

			$this->db->where('subject_id', $subject_id);
			$this->db->where('timestamp', $timestamp);
			$this->db->where('student_id', $param1);
			$this->db->update('daily_attendance_routines', $data);

			$history_data['ket'] = 'Update data daily_attendance_routines ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

		endfor;

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function confirm_all_student()
	{
		$permission_id = $this->input->post('permission_id');
		if (empty($permission_id)) {
			$class_id = $this->input->post('class_id');
			$section_id = $this->input->post('section_id');
		} else {
			$teacher_permissions = $this->db->get_where('teacher_permissions', array('id' => $permission_id))->row_array();

			$class_id = $teacher_permissions['class_id'];
			$section_id = $teacher_permissions['section_id'];
		}

		$data['confirm'] = html_escape($this->input->post('confirm'));
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$number_of_days = date('t', strtotime($month . ' ' . $year));
		for ($i = 1; $i <= $number_of_days; $i++) :
			$date = $i . ' ' . $month . ' ' . $year;
			$timestamp = strtotime($date);

			$this->db->where('class_id', $class_id);
			$this->db->where('section_id', $section_id);
			$this->db->where('timestamp', $timestamp);
			$this->db->update('daily_attendances', $data);

			$history_data['ket'] = 'Update data daily_attendances ' . $class_id . ',' . $section_id . ',' . $timestamp . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

		endfor;

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function confirm_all_employee()
	{
		$role = $this->input->post('role');
		$data['confirm'] = html_escape($this->input->post('confirm'));
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$number_of_days = date('t', strtotime($month . ' ' . $year));
		for ($i = 1; $i <= $number_of_days; $i++) :
			$date = $i . ' ' . $month . ' ' . $year;
			$timestamp = strtotime($date);

			$this->db->where('role', $role);
			$this->db->where('timestamp', $timestamp);
			$this->db->update('daily_attendance_employee', $data);

			$history_data['ket'] = 'Update data daily_attendance_employee ' . $role . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

		endfor;

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function confirm_all_routine()
	{
		$subject_id = $this->input->post('subject_id');
		$class_id = $this->input->post('class_id');
		$section_id = $this->input->post('section_id');

		if (empty($class_id) && empty($section_id)) {
			$subjects = $this->db->get_where('subjects', array('id' => $subject_id))->row_array();

			$class_id = $subjects['class_id'];
			$section_id = $subjects['section_id'];
		} else {
		}

		$data['confirm'] = html_escape($this->input->post('confirm'));
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$number_of_days = date('t', strtotime($month . ' ' . $year));
		for ($i = 1; $i <= $number_of_days; $i++) :
			$date = $i . ' ' . $month . ' ' . $year;
			$timestamp = strtotime($date);

			$this->db->where('subject_id', $subject_id);
			$this->db->where('class_id', $class_id);
			$this->db->where('section_id', $section_id);
			$this->db->where('timestamp', $timestamp);
			$this->db->update('daily_attendance_routines', $data);

			$history_data['ket'] = 'Update data daily_attendance_routines ' . $class_id . ',' . $section_id . ',' . $subject_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

		endfor;

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function confirm_routine($param1 = '')
	{
		$data['confirm'] = html_escape($this->input->post('confirm'));
		$data['caption'] = html_escape($this->input->post('caption'));

		// if(empty($data['caption'])){
		// 	$data['caption'] = '0';
		// }

		$file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		if (!empty($file_ext)) {
			$data['file'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
			move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/attendances/' . $data['file']);
		} elseif (empty($file_ext)) {
			$data['file'] = '0';
		}

		$this->db->where('id', $param1);
		$this->db->update('daily_attendance_routines', $data);

		$history_data['ket'] = 'Update data daily_attendance_routines ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function confirm_employee($param1 = '')
	{
		$data['confirm'] = html_escape($this->input->post('confirm'));
		$data['caption'] = html_escape($this->input->post('caption'));

		$data['caption'] = $this->input->post('caption');
		if (empty($data['caption'])) {
			$data['caption'] = '0';
		}

		$file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		if (!empty($file_ext)) {
			$data['file'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
			move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/attendances/' . $data['file']);
		} elseif (empty($file_ext)) {
			$data['file'] = '0';
		}

		$this->db->where('id', $param1);
		$this->db->update('daily_attendance_employee', $data);

		$history_data['ket'] = 'Update data daily_attendance_employee ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function get_todays_attendance()
	{
		$checker = array(
			'timestamp' => strtotime(date('d-M-Y')),
			'status'    => 1
		);
		$todays_attendance = $this->db->get_where('daily_attendances', $checker);
		return $todays_attendance->num_rows();
	}
	//END DAILY ATTENDANCE section

	//START DAILY ATTENDANCE ROUTINE section
	public function take_attendance_routine()
	{
		$students = $this->input->post('student_id');
		$data['timestamp'] = strtotime($this->input->post('date'));
		$data['class_id'] = html_escape($this->input->post('class_id'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$data['subject_id'] = html_escape($this->input->post('subject_id'));
		$data['school_id'] = $this->school_id;
		$data['session_id'] = $this->active_session;
		$check_data = $this->db->get_where('daily_attendance_routines', array('timestamp' => $data['timestamp'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'subject_id' => $data['subject_id'], 'session_id' => $data['session_id'], 'school_id' => $data['school_id']));
		if ($check_data->num_rows() > 0) {
			foreach ($students as $key => $student) :
				$data['status'] = $this->input->post('status-' . $student);
				$data['student_id'] = $student;
				$attendance_id = $this->input->post('attendance_id');
				$this->db->where('id', $attendance_id[$key]);
				$this->db->update('daily_attendance_routines', $data);

				$history_data['ket'] = 'Update data daily_attendance_routines ' . $attendance_id[$key] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

			endforeach;
		} else {
			foreach ($students as $student) :
				$data['status'] = $this->input->post('status-' . $student);
				$data['student_id'] = $student;
				$this->db->insert('daily_attendance_routines', $data);

				$history_data['ket'] = 'Mengisi data absensi mata pelajaran';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			endforeach;
		}

		$this->settings_model->last_updated_attendance_data();

		$response = array(
			'status' => true,
			'notification' => get_phrase('attendance_updated_successfully')
		);

		return json_encode($response);
	}

	public function get_todays_attendance_routine()
	{
		$checker = array(
			'timestamp' => strtotime(date('Y-m-d')),
			'school_id' => $this->school_id,
			'status'    => 1
		);
		$todays_attendance = $this->db->get_where('daily_attendance_routines', $checker);
		return $todays_attendance->num_rows();
	}
	//END DAILY ATTENDANCE ROUTINE section

	//START awards section
	public function awards_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['point'] = html_escape($this->input->post('point'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = $this->active_session;
		$this->db->insert('awards', $data);

		$history_data['ket'] = 'Mengisi data award';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function awards_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['point'] = html_escape($this->input->post('point'));
		$this->db->where('id', $param1);
		$this->db->update('awards', $data);

		$history_data['ket'] = 'Update data awards ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function awards_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('awards');

		$history_data['ket'] = 'Delete data awards ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}
	//END awards section

	//START achievements section

	public function get_achievements_by_student_id($student_id = "")
	{
		$this->db->where('student_id', $student_id);
		return $this->db->get('achievements');
	}

	public function get_achievements_point__by_student_id($student_id = "")
	{
		$this->db->select_sum('point');
		$this->db->where('student_id', $student_id);
		return $this->db->get('achievements')->result_array();
	}


	public function get_achievements_top_student()
	{
		$school_id = school_id();
		return $this->db->query('SELECT student_id,SUM(point) as jumlah FROM achievements WHERE school_id = ' . $school_id . ' GROUP BY student_id ORDER BY jumlah DESC limit 3');
	}

	public function get_achievements_by_id($id = "")
	{
		return $this->db->get_where('achievements', array('id' => $id))->row_array();
	}

	public function achievements_create()
	{
		$point = $this->db->get_where('awards', array('id' => $this->input->post('award_id')))->row_array();

		$data['date'] = strtotime($this->input->post('date'));
		$data['student_id'] = html_escape($this->input->post('student_id'));
		$data['award_id'] = html_escape($this->input->post('award_id'));
		$data['description'] = html_escape($this->input->post('description'));
		$data['point'] = $point['point'];
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = $this->active_session;
		$this->db->insert('achievements', $data);

		$history_data['ket'] = 'Mengisi data penghargaan';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function achievements_update($param1 = '')
	{
		$point = $this->db->get_where('awards', array('id' => $this->input->post('award_id')))->row_array();

		$data['date'] = strtotime($this->input->post('date'));
		$data['student_id'] = html_escape($this->input->post('student_id'));
		$data['award_id'] = html_escape($this->input->post('award_id'));
		$data['description'] = html_escape($this->input->post('description'));
		$data['point'] = $point['point'];
		$this->db->where('id', $param1);
		$this->db->update('achievements', $data);

		$history_data['ket'] = 'Update data achievements ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function achievements_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('achievements');

		$history_data['ket'] = 'Delete data achievements ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}
	//END achievements section

	//START mistakes section
	public function get_mistakes_by_id($id = "")
	{
		return $this->db->get_where('mistakes', array('id' => $id))->row_array();
	}

	public function mistakes_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['point'] = html_escape($this->input->post('point'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = $this->active_session;
		$this->db->insert('mistakes', $data);

		$history_data['ket'] = 'Mengisi data kesalahan';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function mistakes_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['point'] = html_escape($this->input->post('point'));
		$this->db->where('id', $param1);
		$this->db->update('mistakes', $data);

		$history_data['ket'] = 'Update data mistakes ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function mistakes_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('mistakes');

		$history_data['ket'] = 'Delete data mistakes ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}
	//END mistakes section

	//START violations section

	public function get_violations_by_student_id($student_id = "")
	{
		$this->db->where('student_id', $student_id);
		return $this->db->get('violations');
	}

	public function get_violations_point__by_student_id($student_id = "")
	{
		$this->db->select_sum('point');
		$this->db->where('student_id', $student_id);
		return $this->db->get('violations')->result_array();
	}

	public function get_violations_top_student()
	{
		$school_id = school_id();
		return $this->db->query('SELECT student_id,SUM(point) as jumlah FROM violations WHERE school_id = ' . $school_id . ' GROUP BY student_id ORDER BY jumlah DESC limit 3');
	}

	public function get_violations_by_id($id = "")
	{
		return $this->db->get_where('violations', array('id' => $id))->row_array();
	}

	public function violations_create()
	{

		$point = $this->db->get_where('mistakes', array('id' => $this->input->post('mistake_id')))->row_array();

		$data['date'] = strtotime($this->input->post('date'));
		$data['student_id'] = html_escape($this->input->post('student_id'));
		$data['mistake_id'] = html_escape($this->input->post('mistake_id'));
		$data['description'] = html_escape($this->input->post('description'));
		$data['point'] = $point['point'];
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = $this->active_session;
		$this->db->insert('violations', $data);

		$history_data['ket'] = 'Mengisi data violations';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function violations_update($param1 = '')
	{
		$point = $this->db->get_where('mistakes', array('id' => $this->input->post('mistake_id')))->row_array();

		$data['date'] = strtotime($this->input->post('date'));
		$data['student_id'] = html_escape($this->input->post('student_id'));
		$data['mistake_id'] = html_escape($this->input->post('mistake_id'));
		$data['description'] = html_escape($this->input->post('description'));
		$data['point'] = $point['point'];
		$this->db->where('id', $param1);
		$this->db->update('violations', $data);

		$history_data['ket'] = 'Update data violations ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function violations_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('violations');

		$history_data['ket'] = 'Delete data violations ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}
	//END violations section

	// routine_counseling
	public function get_routine_counseling($date_from = "", $date_to = "")
	{
		$this->db->where('session_id', $this->active_session);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('date >=', $date_from);
		$this->db->where('date <=', $date_to);
		return $this->db->get('routine_counseling');
	}

	public function get_all_routine_counseling()
	{
		$this->db->where('session_id', $this->active_session);
		$this->db->where('school_id', $this->school_id);
		return $this->db->get('routine_counseling');
	}

	public function get_routine_counseling_issue_by_id($id = "")
	{
		return $this->db->get_where('routine_counseling', array('id' => $id))->row_array();
	}

	public function create_routine_counseling()
	{

		$student_id  = $this->input->post('student_id');

		$student_data = $this->user_model->get_student_details_by_id('student', $student_id);

		$data['class_id']   = $student_data['class_id'];
		$data['section_id'] = $student_data['section_id'];
		$data['room_id']   = $student_data['room_id'];
		$data['student_id'] = $student_id;
		$data['teacher_id'] = $this->input->post('teacher_id');
		$data['date'] = strtotime($this->input->post('date'));
		$data['routine_start'] = $this->input->post('routine_start');
		$data['status'] = 0;
		$data['school_id'] = $this->school_id;
		$data['session_id']   = $this->active_session;

		$this->db->insert('routine_counseling', $data);

		$history_data['ket'] = 'Mengisi data routine counseling';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_routine_counseling($id = "")
	{
		$student_id  = $this->input->post('student_id');

		$student_data = $this->user_model->get_student_details_by_id('student', $student_id);

		$data['class_id']   = $student_data['class_id'];
		$data['section_id'] = $student_data['section_id'];
		$data['room_id']   = $student_data['room_id'];
		$data['student_id'] = $student_id;
		$data['teacher_id'] = $this->input->post('teacher_id');
		$data['date'] = strtotime($this->input->post('date'));
		$data['routine_start'] = $this->input->post('routine_start');
		$data['school_id'] = $this->school_id;
		$data['session_id']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('routine_counseling', $data);

		$history_data['ket'] = 'Update data routine_counseling ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function status_routine_counseling($id = "")
	{
		$data['status']   = 1;

		$this->db->where('id', $id);
		$this->db->update('routine_counseling', $data);

		$history_data['ket'] = 'Update data routine_counseling ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('returned_successfully')
		);
		return json_encode($response);
	}

	public function delete_routine_counseling($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('routine_counseling');

		$history_data['ket'] = 'Delete data routine_counseling ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//routine_counseling end

	//raport start section
	public function get_raport_by_id($id = "")
	{
		return $this->db->get_where('raport', array('id' => $id))->row_array();
	}

	public function create_raport()
	{
		$extracurricular_mark = $this->input->post('extracurricular_mark');

		$mark = implode(",", $extracurricular_mark);
		$data = array(
			'extracurricular_mark' => $mark,
			'student_id' => html_escape($this->input->post('student_id')),
			'class_id' => html_escape($this->input->post('class_id')),
			'section_id' => html_escape($this->input->post('section_id')),
			'organizations_id' => $this->input->post('organizations_id'),
			'attendance_permission' => html_escape($this->input->post('attendance_permission')),
			'attendance_sick' => html_escape($this->input->post('attendance_sick')),
			'attendance_absent' => html_escape($this->input->post('attendance_absent')),
			'achievements_student' => html_escape($this->input->post('achievements_student')),
			'raport_caption' => html_escape($this->input->post('raport_caption')),
			'spiritual' => html_escape($this->input->post('spiritual')),
			'social' => html_escape($this->input->post('social')),
			'hearing' => html_escape($this->input->post('hearing')),
			'vision' => html_escape($this->input->post('vision')),
			'hand' => html_escape($this->input->post('hand')),
			'foot' => html_escape($this->input->post('foot')),
			'school_id' => $this->school_id,
			'session' => $this->active_session
		);

		$query = $this->db->get_where('raport', array('student_id' => $data['student_id'], 'class_id' => $data['class_id'], 'section_id' => $data['section_id'], 'session' => $data['session'], 'school_id' => $data['school_id']));

		if ($query->num_rows() > 0) {
			// $update_data['student_id'] = html_escape($this->input->post('student_id'));
			// $update_data['class_id'] = html_escape($this->input->post('class_id'));
			// $update_data['section_id'] = html_escape($this->input->post('section_id'));
			// $update_data['attendance_permission'] = html_escape($this->input->post('attendance_permission'));
			// $update_data['attendance_sick'] = html_escape($this->input->post('attendance_sick'));
			// $update_data['attendance_absent'] = html_escape($this->input->post('attendance_absent'));
			// $update_data['extracurricular_mark'] = html_escape($this->input->post('extracurricular_mark'));
			// $update_data['achievements_student'] = html_escape($this->input->post('achievements_student'));
			// $update_data['raport_caption'] = html_escape($this->input->post('raport_caption'));
			// $update_data['school_id'] = $this->school_id;
			// $update_data['session'] = $this->active_session;
			$extracurricular_mark = $this->input->post('extracurricular_mark');

			$mark = implode(",", $extracurricular_mark);
			$update_data = array(
				'extracurricular_mark' => $mark,
				'student_id' => html_escape($this->input->post('student_id')),
				'class_id' => html_escape($this->input->post('class_id')),
				'section_id' => html_escape($this->input->post('section_id')),
				'organizations_id' => $this->input->post('organizations_id'),
				'attendance_permission' => html_escape($this->input->post('attendance_permission')),
				'attendance_sick' => html_escape($this->input->post('attendance_sick')),
				'attendance_absent' => html_escape($this->input->post('attendance_absent')),
				'achievements_student' => html_escape($this->input->post('achievements_student')),
				'raport_caption' => html_escape($this->input->post('raport_caption')),
				'spiritual' => html_escape($this->input->post('spiritual')),
				'social' => html_escape($this->input->post('social')),
				'hearing' => html_escape($this->input->post('hearing')),
				'vision' => html_escape($this->input->post('vision')),
				'hand' => html_escape($this->input->post('hand')),
				'foot' => html_escape($this->input->post('foot')),
				'school_id' => $this->school_id,
				'session' => $this->active_session
			);

			$row = $query->row();
			$this->db->where('id', $row->id);
			$this->db->update('raport', $update_data);

			$history_data['ket'] = 'Update data routine_counseling ' . $row->id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		} else {
			$this->db->insert('raport', $data);

			$history_data['ket'] = 'Mengisi data raport';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);

		return json_encode($response);
	}
	//raport end section

	//START EVENT CALENDAR section
	public function event_calendar_create()
	{
		$selected_date = $this->input->post('selected_date');
		$array_date = explode(',', $selected_date);
		$arrLength = count($array_date);
		for ($i = 0; $i < $arrLength; $i++) {;
			$data['title'] = html_escape($this->input->post('title'));
			$data['starting_date'] = $array_date[$i] . ' 00:00:1';
			$data['ending_date'] = $array_date[$i] . ' 23:59:59';
			$data['description'] = html_escape($this->input->post('description'));
			$data['school_id'] = $this->school_id;
			$data['session'] = $this->active_session;
			$this->db->insert('event_calendars', $data);

			$history_data['ket'] = 'Mengisi data event calendars';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}
		// die;

		$response = array(
			'status' => true,
			'notification' => get_phrase('event_has_been_added_successfully')
		);

		return json_encode($response);
	}

	public function event_calendar_update($param1 = '')
	{
		$data['title'] = html_escape($this->input->post('title'));
		$starting_date = strtotime(date('d/m/Y')) + 1;
		$ending_date = strtotime(date('d/m/Y')) - 1;
		$data['starting_date'] = $this->input->post('starting_date') . ' 00:00:1';
		$data['ending_date'] = $this->input->post('ending_date') . ' 23:59:59';
		$data['description'] = html_escape($this->input->post('description'));
		$this->db->where('id', $param1);
		$this->db->update('event_calendars', $data);

		$history_data['ket'] = 'Update data event_calendars ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('event_has_been_updated_successfully')
		);

		return json_encode($response);
	}

	public function event_calendar_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('event_calendars');

		$history_data['ket'] = 'Delete data event_calendars ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('event_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function all_events()
	{

		$event_calendars = $this->db->get_where('event_calendars', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
		return json_encode($event_calendars);
	}

	public function get_current_month_events()
	{
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		$events = $this->db->get('event_calendars');
		return $events;
	}
	//END EVENT CALENDAR section

	//START ANNONCEMENT section
	public function get_announcements()
	{
		$tgl = strtotime(date('m/d/Y'));
		$this->db->where('school_id', $this->school_id);
		$this->db->where('' . $tgl . ' BETWEEN start_date AND finish_date');
		$announcements = $this->db->get('announcements')->result_array();
		return $announcements;
	}

	public function announcement_create()
	{
		$duplication_counter = 0;
		$section_id = $this->input->post('section_id');
		$name = html_escape($this->input->post('name'));
		$start_date = strtotime($this->input->post('date'));
		$finish_date = strtotime('+6 day', $start_date);

		foreach ($section_id as $key => $value) :
			$data['name'] = $name;
			$data['start_date'] = $start_date;
			$data['finish_date'] = $finish_date;
			$data['section_id'] = $section_id[$key];
			$data['school_id'] = $this->school_id;
			$this->db->insert('announcements', $data);

			$history_data['ket'] = 'Mengisi data announcements';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$duplication_counter++;

		endforeach;

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);

		return json_encode($response);
	}

	public function announcement_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('title'));
		$data['date'] = strtotime($this->input->post('date'));
		$data['section_id'] = html_escape($this->input->post('section_id'));
		$this->db->where('id', $param1);
		$this->db->update('announcements', $data);

		$history_data['ket'] = 'Update data announcements ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);

		return json_encode($response);
	}

	public function announcement_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('announcements');

		$history_data['ket'] = 'Delete data announcements ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);

		return json_encode($response);
	}
	//END ANNONCEMENT section

	// START OF NOTICEBOARD SECTION
	public function create_notice()
	{
		$data['notice_title']     = html_escape($this->input->post('notice_title'));
		$data['notice']           = html_escape($this->input->post('notice'));
		$data['show_on_website']  = $this->input->post('show_on_website');
		$data['date'] 						= $this->input->post('date') . ' 00:00:1';
		$data['school_id'] 				= $this->school_id;
		$data['session'] 					= $this->active_session;
		if ($_FILES['notice_photo']['name'] != '') {
			$data['image']  = random(15) . '.jpg';
			move_uploaded_file($_FILES['notice_photo']['tmp_name'], 'uploads/images/notice_images/' . $data['image']);
		} else {
			$data['image']  = 'placeholder.png';
		}
		$this->db->insert('noticeboard', $data);

		$history_data['ket'] = 'Mengisi data noticeboard';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('notice_has_been_created')
		);

		return json_encode($response);
	}

	public function update_notice($notice_id)
	{
		$data['notice_title']     = html_escape($this->input->post('notice_title'));
		$data['notice']           = html_escape($this->input->post('notice'));
		$data['show_on_website']  = $this->input->post('show_on_website');
		$data['date'] 						= $this->input->post('date') . ' 00:00:1';
		if ($_FILES['notice_photo']['name'] != '') {
			$data['image']  = random(15) . '.jpg';
			move_uploaded_file($_FILES['notice_photo']['tmp_name'], 'uploads/images/notice_images/' . $data['image']);
		}
		$this->db->where('id', $notice_id);
		$this->db->update('noticeboard', $data);

		$history_data['ket'] = 'Update data noticeboard ' . $notice_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('notice_has_been_updated')
		);

		return json_encode($response);
	}

	public function delete_notice($notice_id)
	{
		$this->db->where('id', $notice_id);
		$this->db->delete('noticeboard');

		$history_data['ket'] = 'Delete data noticeboard ' . $notice_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('notice_has_been_deleted')
		);

		return json_encode($response);
	}

	public function get_all_the_notices()
	{
		$notices = $this->db->get_where('noticeboard', array('school_id' => $this->school_id, 'session' => $this->active_session))->result_array();
		return json_encode($notices);
	}

	public function get_noticeboard_image($image)
	{
		if (file_exists('uploads/images/notice_images/' . $image))
			return base_url() . 'uploads/images/notice_images/' . $image;
		else
			return base_url() . 'uploads/images/notice_images/placeholder.png';
	}
	// END OF NOTICEBOARD SECTION

	//START EXAM section
	public function exam_create()
	{
		$data['name'] = html_escape($this->input->post('exam_name'));
		$data['starting_date'] = strtotime($this->input->post('starting_date'));
		$data['ending_date'] = strtotime($this->input->post('ending_date'));
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$data['semester_id'] = html_escape($this->input->post('semester_id'));
		$this->db->insert('exams', $data);

		$history_data['ket'] = 'Mengisi data exams';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('exam_created_successfully')
		);
		return json_encode($response);
	}

	public function exam_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('exam_name'));
		$data['starting_date'] = strtotime($this->input->post('starting_date'));
		$data['ending_date'] = strtotime($this->input->post('ending_date'));
		$data['semester_id'] = html_escape($this->input->post('semester_id'));
		$this->db->where('id', $param1);
		$this->db->update('exams', $data);

		$history_data['ket'] = 'Update data exams ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('exam_updated_successfully')
		);
		return json_encode($response);
	}

	public function exam_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('exams');

		$history_data['ket'] = 'Delete data exams ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('exam_deleted_successfully')
		);
		return json_encode($response);
	}

	public function get_exam_by_id($exam_id = "")
	{
		return $this->db->get_where('exams', array('id' => $exam_id))->row_array();
	}
	//END EXAM section

	//START MARKS section
	// public function upload_excel_mark(){
	// 	$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
	// 	$classes = [];
	// 	foreach ($classes_query as $class) {
	// 		$classes[strtolower($class['name'])] = [
	// 			'_id' => $class['id'],
	// 		];
	// 		$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
	// 		foreach ($sections as $section) {
	// 			$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
	// 		}
	// 	}

	// 	$mapel_query = $this->db->get_where('subjects', array('school_id' => $school_id, 'session' => $session_id))->result_array();
	// 	$subjects = [];
	// 	foreach ($mapel_query as $mapel) {
	// 		$subjects[$mapel['class_id']][strtolower($mapel['name'])] = $mapel['id'];
	// 	}

	// 	$exam_query = $this->db->get_where('exams', array('school_id' => $school_id, 'session' => $session_id))->result_array();
	// 	$exams = [];
	// 	foreach ($exam_query as $exam) {
	// 		$exams[$exam['id']][strtolower($exam['name'])] = $exam['id'];
	// 	}

	// 	$student_query = $this->db->query('SELECT u.email, t.id FROM users u, students t WHERE u.id = t.user_id')->result_array();
	// 	$students = [];
	// 	foreach ($student_query as $student) {
	// 		$students[strtolower($student['email'])] = $student['id'];
	// 	}

	// 	$school_id = $this->school_id;
	// 	$session_id = $this->active_session;

	// 	$file_name = $_FILES['csv_file']['name'];
	// 	move_uploaded_file($_FILES['csv_file']['tmp_name'],'uploads/csv_file/uploadmark.csv');

	// 	if (($handle = fopen('uploads/csv_file/uploadmark.csv', 'r')) !== FALSE) { // Check the resource is valid
	// 		$count = 0;
	// 		$duplication_counter = 0;
	// 		while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
	// 			if($count > 0){
	// 				$rukel = strtolower(trim($csv[0]));
	// 				$kelas = strtolower(trim($csv[1]));
	// 				$bagian = strtolower(trim($csv[2]));
	// 				$mapel = strtolower(trim($csv[3]));
	// 				$emailstudent = strtolower(trim($csv[4]));

	// 				if (array_key_exists($kelas, $classes)) {
	// 					$jadualdata['class_id'] = $classes[$kelas]['_id'];
	// 					if (array_key_exists($bagian, $classes[$kelas])) {
	// 						$jadualdata['section_id'] = $classes[$kelas][$bagian];
	// 					} else {
	// 						$response = array(
	// 							'status' => true,
	// 							'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari." ". $kelas = strtolower(trim($csv[1]))." ". $bagian = strtolower(trim($csv[2])) ." ". $mapel = strtolower(trim($csv[3]))
	// 						);
	// 						continue;
	// 					}
	// 				} else {
	// 					$response = array(
	// 						'status' => true,
	// 						'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari." ". $kelas = strtolower(trim($csv[1]))." ". $bagian = strtolower(trim($csv[2])) ." ". $mapel = strtolower(trim($csv[3]))
	// 					);
	// 					continue;
	// 				}

	// 				if (array_key_exists($emailstudent, $students)) {
	// 					$datanilai['student_id'] = $students[$emailstudent];
	// 				}
	// 				$datanilai['mark_obtained'] = html_escape($all_data[5]);
	// 				$datanilai['comment'] = html_escape($all_data[6]);
	// 				$datanilai['school_id'] = $school_id;
	// 				$datanilai['session'] = $session_id;

	// 				$duplication_status = $this->check_duplication('on_create', $datanilai['name']);
	// 				if($duplication_status){
	// 				$this->db->insert('books', $datanilai);
	// 				} else {
	// 					$duplication_counter++;
	// 				}
	// 			}
	// 			$count++;
	// 		}
	// 			fclose($handle);
	// 	}
	// 	if ($duplication_counter > 0) {
	// 		$response = array(
	// 			'status' => true,
	// 			'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $bukudata['name'] = html_escape($all_data[1])
	// 		);
	// 	}else{
	// 		$response = array(
	// 			'status' => true,
	// 			'notification' => get_phrase('books_added_successfully')
	// 		);
	// 	}

	// 	return json_encode($response);

	// }

	public function get_all_marks_archives($student_id = "", $semester_id = "", $session = "")
	{
		$checker = [
			'student_id' => $student_id,
			'semester_id' => $semester_id,
			'session' => $session,
			'school_id' => $this->school_id
		];
		if (!empty($session)) {
			$checker['session'] = $session;
		}
		if (!empty($semester_id)) {
			$checker['semester_id'] = $semester_id;
		}
		if (!empty($student_id)) {
			$checker['student_id'] = $student_id;
		}
		$this->db->where($checker);
		return $this->db->get('marks');
	}
	public function get_marks_archives($student_id = "", $session = "")
	{
		$checker = array(
			'student_id' => $student_id,
			'session' => $session,
			'school_id' => $this->school_id
		);
		$this->db->where($checker);
		return $this->db->get('marks');
	}
	//END MARKS section

	//START MARKS section
	public function get_all_marks($class_id = "", $section_id = "", $room_id = "", $subject_id = "", $student_id = "")
	{
		$checker = [
			'class_id' => $class_id,
			'section_id' => $section_id,
			'school_id' => $this->school_id,
			'session' => $this->active_session,
		];
		if (!empty($room_id)) {
			$checker['room_id'] = $room_id;
		}
		if (!empty($subject_id)) {
			$checker['subject_id'] = $subject_id;
		}
		if (!empty($student_id)) {
			$checker['student_id'] = $student_id;
		}
		$this->db->where($checker);
		return $this->db->get('marks');
	}
	public function get_marks($class_id = "", $section_id = "", $room_id = "", $subject_id = "")
	{
		$checker = array(
			'class_id' => $class_id,
			'section_id' => $section_id,
			'room_id' => $room_id,
			'subject_id' => $subject_id,
			'school_id' => $this->school_id,
			'session' => $this->active_session
		);
		$this->db->where($checker);
		return $this->db->get('marks');
	}
	public function mark_insert($class_id = "", $section_id = "", $room_id = "", $subject_id = "")
	{
		$student_enrolments = $this->user_model->student_enrolment($section_id)->result_array();
		foreach ($student_enrolments as $student_enrolment) {
			$checker = array(
				'student_id' => $student_enrolment['student_id'],
				'class_id' => $class_id,
				'section_id' => $section_id,
				'room_id' => $room_id,
				'subject_id' => $subject_id,
				'school_id' => $this->school_id,
				'session' => $this->active_session
			);
			$this->db->where($checker);
			$number_of_rows = $this->db->get('marks')->num_rows();
			if ($number_of_rows == 0) {
				$this->db->insert('marks', $checker);

				$history_data['ket'] = 'Mengisi data marks';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}
		}
	}

	public function mark_update()
	{

		$studentIds = $this->input->post('student_id');
		$class_id = $this->input->post('class_id');
		$section_id = $this->input->post('section_id');
		$room_id = $this->input->post('room_id');
		$subject_id = $this->input->post('subject_id');
		$mark_skills = $this->input->post('mark_skills');
		$mark_knowledge = $this->input->post('mark_knowledge');
		$school_id = $this->school_id;
		$session = $this->active_session;

		$index = 0;
		foreach ($studentIds as $studentId) {

			$query = $this->db->get_where('marks', array('student_id' => $studentId, 'class_id' => $class_id[$index], 'section_id' => $section_id[$index], 'room_id' => $room_id[$index], 'subject_id' => $subject_id[$index], 'session' => $session, 'school_id' => $school_id));
			if ($query->num_rows() > 0) {
				$update_data['mark_skills'] = $mark_skills[$index];
				if (empty($update_data['mark_skills'])) {
					$update_data['mark_skills'] = NULL;
				}
				$update_data['mark_knowledge'] = $mark_knowledge[$index];
				if (empty($update_data['mark_knowledge'])) {
					$update_data['mark_knowledge'] = NULL;
				}
				$row = $query->row();
				$this->db->where('id', $row->id);
				$this->db->update('marks', $update_data);

				$history_data['ket'] = 'Update data marks ' . $row->id . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			} else {
				$data = array(
					'student_id' => $studentId,
					'subject_id' => $subject_id[$index],
					'class_id' => $class_id[$index],
					'section_id' => $section_id[$index],
					'room_id' => $room_id[$index],
					'mark_skills' => $mark_skills[$index],
					'mark_knowledge' => $mark_knowledge[$index],
					'school_id' => $school_id,
					'session' => $session
				);
				if (empty($data['mark_skills'])) {
					$data['mark_skills'] = NULL;
				}
				if (empty($data['mark_knowledge'])) {
					$data['mark_knowledge'] = NULL;
				}
				$this->db->insert('marks', $data);

				$history_data['ket'] = 'Mengisi data marks';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}
			$response = array(
				'status' => true,
				'notification' => get_phrase('mark_hass_been_updated_successfully')
			);
			$index++;
		}

		return json_encode($response);
	}
	//END MARKS section

	// Grade creation
	public function grade_create()
	{
		$data['name'] = html_escape($this->input->post('grade'));
		$data['grade_point'] = $this->input->post('grade_point');
		$data['mark_from'] = $this->input->post('mark_from');
		$data['mark_upto'] = $this->input->post('mark_upto');
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$this->db->insert('grades', $data);

		$history_data['ket'] = 'Mengisi data grades';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('grade_added_successfully')
		);
		return json_encode($response);
	}

	public function grade_update($id = "")
	{
		$data['name'] = html_escape($this->input->post('grade'));
		$data['grade_point'] = $this->input->post('grade_point');
		$data['mark_from'] = $this->input->post('mark_from');
		$data['mark_upto'] = $this->input->post('mark_upto');
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('grades', $data);

		$history_data['ket'] = 'Update data grades ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('grade_updated_successfully')
		);
		return json_encode($response);
	}

	public function grade_delete($id = '')
	{
		$this->db->where('id', $id);
		$this->db->delete('grades');

		$history_data['ket'] = 'Delete data grades ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('grade_deleted_successfully')
		);
		return json_encode($response);
	}
	// Grade ends

	// Student Promotion section Starts
	public function get_student_list()
	{
		$session_from = $this->input->post('session_from');
		$session_to = $this->input->post('session_to');
		$class_id_from = $this->input->post('class_id_from');
		$class_id_to = $this->input->post('class_id_to');
		$checker = array(
			'class_id' => $class_id_from,
			'session' => $session_from,
			'school_id' => $this->school_id
		);
		return $this->db->get_where('enrols', $checker);
	}

	//promote student
	public function promote_student($promotion_data = "")
	{
		$promotion_data = explode('-', $promotion_data);
		$enroll_id = $promotion_data[0];
		$class_id = $promotion_data[1];
		$session_id = $promotion_data[2];
		$enroll = $this->db->get_where('enrols', array('id' => $enroll_id))->row_array();
		$enroll['class_id'] = $class_id;
		$enroll['session'] = $session_id;
		$first_section_details = $this->db->get_where('sections', array('class_id' => $class_id))->row_array();
		$enroll['section_id'] = $first_section_details['id'];
		$this->db->where('id', $enroll_id);
		$this->db->update('enrols', $enroll);

		$history_data['ket'] = 'Update data enrols ' . $enroll_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		return true;
	}
	// Student Promotion section Ends

	//Expense Category Starts
	public function get_expense_categories($id = "")
	{
		if ($id > 0) {
			$this->db->where('id', $id);
		}
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		return $this->db->get('expense_categories');
	}
	public function create_expense_category()
	{
		$data['name'] = $this->input->post('name');
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$this->db->insert('expense_categories', $data);

		$history_data['ket'] = 'Mengisi data expense categories';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_category_added_successfully')
		);
		return json_encode($response);
	}

	public function update_expense_category($id)
	{
		$data['name'] = $this->input->post('name');
		$this->db->where('id', $id);
		$this->db->update('expense_categories', $data);

		$history_data['ket'] = 'Update data expense_categories ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_category_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_expense_category($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('expense_categories');

		$history_data['ket'] = 'Delete data expense_categories ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_category_deleted_successfully')
		);
		return json_encode($response);
	}
	//Expense Category Ends

	//Expense Manager Starts
	public function get_expense_by_id($id = "")
	{
		return $this->db->get_where('expenses', array('id' => $id))->row_array();
	}

	public function get_expense($date_from = "", $date_to = "", $expense_category_id = "")
	{
		if ($expense_category_id > 0) {
			$this->db->where('expense_category_id', $expense_category_id);
		}
		$this->db->where('date >=', $date_from);
		$this->db->where('date <=', $date_to);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		$this->db->order_by('in_charge', 'ASC');
		return $this->db->get('expenses');
	}

	// creating
	public function create_expense()
	{
		$data['date'] = strtotime($this->input->post('date'));
		$data['amount'] = $this->input->post('amount');
		$data['expense_category_id'] = $this->input->post('expense_category_id');
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$data['created_at'] = strtotime(date('d-M-Y'));
		$this->db->insert('expenses', $data);

		$history_data['ket'] = 'Mengisi data expenses';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_added_successfully')
		);
		return json_encode($response);
	}

	// updating
	public function update_expense($id = "")
	{
		$data['date'] = strtotime($this->input->post('date'));
		$data['amount'] = $this->input->post('amount');
		$data['expense_category_id'] = $this->input->post('expense_category_id');
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$this->db->where('id', $id);
		$this->db->update('expenses', $data);

		$history_data['ket'] = 'Update data expenses ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_updated_successfully')
		);
		return json_encode($response);
	}

	// deleting
	public function delete_expense($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('expenses');

		$history_data['ket'] = 'Delete data expenses ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_deleted_successfully')
		);
		return json_encode($response);
	}
	// Expense Manager Ends

	// PROVIDE ENTRY AFTER PAYMENT SUCCESS
	public function payment_success($data = array())
	{
		$this->db->where('id', $data['invoice_id']);
		$invoice_details = $this->db->get('invoices')->row_array();
		$due_amount = $invoice_details['total_amount'] - $invoice_details['paid_amount'];
		if ($due_amount == $data['amount_paid']) {
			$updater = array(
				'status' => 'paid',
				'payment_method' => $data['payment_method'],
				'paid_amount' => $data['amount_paid'] + $invoice_details['paid_amount'],
				'updated_at'  => strtotime(date('d-M-Y'))
			);
			$this->db->where('id', $data['invoice_id']);
			$this->db->update('invoices', $updater);

			$history_data['ket'] = 'Update data invoices ' . $data['invoice_id'] . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}
	}

	// Back Office Section Starts
	public function get_session($id = "")
	{
		if ($id > 0) {
			$this->db->where('id', $id);
		}
		$sessions = $this->db->get('sessions');
		return $sessions;
	}

	// infrastructure Manager
	public function get_infrastructure()
	{
		$checker = array(
			// 'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		return $this->db->get_where('infrastructure', $checker);
	}

	public function get_infrastructure_by_id($id = "")
	{
		return $this->db->get_where('infrastructure', array('id' => $id))->row_array();
	}

	public function create_infrastructure()
	{
		$data['name']      = $this->input->post('name');
		$data['condition'] = $this->input->post('condition');
		$data['amount'] 	= $this->input->post('amount');
		$data['status'] = $this->input->post('status');
		$data['location_id'] = $this->input->post('location_id');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;
		$this->db->insert('infrastructure', $data);

		$history_data['ket'] = 'Mengisi data infrastructure';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('infrastructure_added_successfully')
		);
		return json_encode($response);
	}

	public function update_infrastructure($id = "")
	{
		$data['name']      = $this->input->post('name');
		$data['condition'] = $this->input->post('condition');
		$data['amount'] 	= $this->input->post('amount');
		$data['status'] = $this->input->post('status');
		$data['location_id'] = $this->input->post('location_id');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('infrastructure', $data);

		$history_data['ket'] = 'Update data infrastructure ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('infrastructure_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_infrastructure($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('infrastructure');

		$history_data['ket'] = 'Delete data infrastructure ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('infrastructure_deleted_successfully')
		);
		return json_encode($response);
	}

	//infrastructure end

	// infrastructure Issue
	public function get_infrastructure_issues($date_from = "", $date_to = "")
	{
		$this->db->where('session_id', $this->active_session);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('issue_date >=', $date_from);
		$this->db->where('issue_date <=', $date_to);
		return $this->db->get('infrastructure_issues');
	}

	public function get_infrastructure_issues_all()
	{
		$this->db->where('school_id', $this->school_id);
		return $this->db->get('infrastructure_issues');
	}

	public function get_infrastructure_issue_id($id = "")
	{
		return $this->db->get_where('infrastructure_issues', array('id' => $id))->row_array();
	}

	public function get_infrastructure_issue_by_id($id = "")
	{
		return $this->db->get_where('infrastructure_issues', array('infrastructure_id' => $id, 'status' => 0))->num_rows();
	}

	public function create_infrastructure_issue()
	{
		$data['infrastructure_id']    = $this->input->post('infrastructure_id');
		$data['user_id'] = $this->input->post('user_id');
		$data['date'] = $this->input->post('date');
		$data['issue_start'] = $this->input->post('issue_start');
		$data['return_start'] = $this->input->post('return_start');
		$data['school_id'] = $this->school_id;
		$data['status'] = 0;
		$data['session_id']   = $this->active_session;

		$this->db->insert('infrastructure_issues', $data);

		$history_data['ket'] = 'Mengisi data infrastructure issues';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_infrastructure_issue($id = "")
	{
		$data['infrastructure_id']    = $this->input->post('infrastructure_id');
		$data['user_id'] = $this->input->post('user_id');
		$data['date'] = $this->input->post('date');
		$data['issue_start'] = $this->input->post('issue_start');
		$data['return_start'] = $this->input->post('return_start');
		$data['school_id'] = $this->school_id;
		$data['session_id']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('infrastructure_issues', $data);

		$history_data['ket'] = 'Update data infrastructure_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function update_status_infrastructure_issue($id = "")
	{
		$data['status']    = 2;

		$this->db->where('id', $id);
		$this->db->update('infrastructure_issues', $data);

		$history_data['ket'] = 'Update data infrastructure_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('due_date_successfully')
		);
		return json_encode($response);
	}

	public function return_issued_infrastructure($id = "")
	{
		$data['status']   = 1;

		$this->db->where('id', $id);
		$this->db->update('infrastructure_issues', $data);

		$history_data['ket'] = 'Update data infrastructure_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('returned_successfully')
		);
		return json_encode($response);
	}

	public function get_number_of_issued_infrastructure_by_id($id)
	{
		return $this->db->get_where('infrastructure_issues', array('infrastructure_id' => $id, 'status' => 0))->num_rows();
	}

	public function delete_infrastructure_issue($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('infrastructure_issues');

		$history_data['ket'] = 'Delete data infrastructure_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//infrastructure_issues end

	// means Manager
	public function get_means()
	{
		$checker = array(
			// 'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		return $this->db->get_where('means', $checker);
	}

	public function get_means_by_id($id = "")
	{
		return $this->db->get_where('means', array('id' => $id))->row_array();
	}

	public function create_means()
	{
		$data['name']      = $this->input->post('name');
		$data['condition'] = $this->input->post('condition');
		$data['amount'] 	= $this->input->post('amount');
		$data['status'] = $this->input->post('status');
		$data['location_id'] = $this->input->post('location_id');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;
		$this->db->insert('means', $data);

		$history_data['ket'] = 'Mengisi data means';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_means($id = "")
	{
		$data['name']      = $this->input->post('name');
		$data['condition'] = $this->input->post('condition');
		$data['amount'] 	= $this->input->post('amount');
		$data['status'] = $this->input->post('status');
		$data['location_id'] = $this->input->post('location_id');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('means', $data);

		$history_data['ket'] = 'Update data means ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_means($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('means');

		$history_data['ket'] = 'Delete data means ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//means end

	// mean Issue
	public function get_mean_issues($date_from = "", $date_to = "")
	{
		$this->db->where('session_id', $this->active_session);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('issue_date >=', $date_from);
		$this->db->where('issue_date <=', $date_to);
		return $this->db->get('mean_issues');
	}

	public function get_mean_issues_all()
	{
		$this->db->where('school_id', $this->school_id);
		return $this->db->get('mean_issues');
	}

	public function get_mean_issue_id($id = "")
	{
		return $this->db->get_where('mean_issues', array('id' => $id))->row_array();
	}

	public function get_mean_issue_by_id($id = "")
	{
		return $this->db->get_where('mean_issues', array('mean_id' => $id, 'status' => 0))->num_rows();
	}

	public function create_mean_issue()
	{
		$data['mean_id']    = $this->input->post('mean_id');
		$data['user_id'] = $this->input->post('user_id');
		$data['issue_date'] = $this->input->post('issue_date');
		$data['return_date'] = $this->input->post('return_date');
		$data['status'] = 0;
		$data['school_id'] = $this->school_id;
		$data['session_id']   = $this->active_session;

		// print_r($data); die;

		$this->db->insert('mean_issues', $data);

		$history_data['ket'] = 'Mengisi data means issues';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);
		// $this->db->insert('users', [
		// 	'mean_id' => 2,
		// 	'user_id' => 10413,
		// 	'issue_date' => 1632330000,
		// 	'return_date' => 1632330000,
		// 	'school_id' => 11,
		// 	'session_id' => 2
		// ]);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_mean_issue($id = "")
	{
		$data['mean_id']    = $this->input->post('mean_id');
		$data['user_id'] = $this->input->post('user_id');
		$data['issue_date'] = $this->input->post('issue_date');
		$data['return_date'] = $this->input->post('return_date');
		$data['school_id'] = $this->school_id;
		$data['session_id']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('mean_issues', $data);

		$history_data['ket'] = 'Update data mean_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function update_status_mean_issue($id = "")
	{
		$data['status']    = 2;

		$this->db->where('id', $id);
		$this->db->update('mean_issues', $data);

		$history_data['ket'] = 'Update data mean_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('due_date_successfully')
		);
		return json_encode($response);
	}

	public function return_issued_mean($id = "")
	{
		$data['status']   = 1;

		$this->db->where('id', $id);
		$this->db->update('mean_issues', $data);

		$history_data['ket'] = 'Update data mean_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('returned_successfully')
		);
		return json_encode($response);
	}

	public function get_number_of_issued_mean_by_id($id)
	{
		return $this->db->get_where('mean_issues', array('mean_id' => $id, 'status' => 0))->num_rows();
	}

	public function delete_mean_issue($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('mean_issues');

		$history_data['ket'] = 'Delete data mean_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//mean_issues end

	// years Manager
	public function get_years()
	{
		return $this->db->get_where('years');
	}

	public function get_years_by_id($id = "")
	{
		return $this->db->get_where('years', array('id' => $id))->row_array();
	}

	public function create_years()
	{
		$data['name'] = $this->input->post('name');
		$data['school_id'] = school_id();

		$this->db->insert('years', $data);

		$history_data['ket'] = 'Mengisi data years';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_years($id = "")
	{
		$data['name']  = $this->input->post('name');

		$this->db->where('id', $id);
		$this->db->update('years', $data);

		$history_data['ket'] = 'Update data years ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_years($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('years');

		$history_data['ket'] = 'Delete data years ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	// book_types Manager
	public function get_book_types()
	{
		return $this->db->get_where('book_types');
	}

	public function get_book_types_school_id()
	{
		return $this->db->get_where('book_types', array('school_id' => school_id()));
	}

	public function get_book_types_by_id($id = "")
	{
		return $this->db->get_where('book_types', array('id' => $id))->row_array();
	}

	public function create_book_types()
	{
		$data['name'] = $this->input->post('name');
		$data['school_id'] = school_id();

		$this->db->insert('book_types', $data);

		$history_data['ket'] = 'Mengisi data book types';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_book_types($id = "")
	{
		$data['name']  = $this->input->post('name');

		$this->db->where('id', $id);
		$this->db->update('book_types', $data);

		$history_data['ket'] = 'Update data book_types ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_book_types($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('book_types');

		$history_data['ket'] = 'Delete data book_types ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	// START LOCATION Manager
	public function get_locations()
	{
		return $this->db->get_where('locations', array('school_id' => school_id()));
	}

	public function get_locations_by_id($id = "")
	{
		return $this->db->get_where('locations', array('id' => $id))->row_array();
	}

	public function create_locations()
	{
		$data['name'] = $this->input->post('name');
		$data['school_id'] = school_id();

		$this->db->insert('locations', $data);

		$history_data['ket'] = 'Mengisi data locations';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_locations($id = "")
	{
		$data['name']  = $this->input->post('name');

		$this->db->where('id', $id);
		$this->db->update('locations', $data);

		$history_data['ket'] = 'Update data locations ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_locations($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('locations');

		$history_data['ket'] = 'Delete data locations ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//END SECTION LOCATION

	// JOB FAIR Manager START
	public function get_job_fairs()
	{
		$checker = array(
			'school_id' => $this->school_id
		);
		return $this->db->get_where('job_fairs', $checker);
	}

	public function get_job_fairs_by_id($id = "")
	{
		return $this->db->get_where('job_fairs', array('id' => $id))->row_array();
	}

	// Get job_fairs Starts
	public function get_job_fair_image($photo)
	{
		if (file_exists('uploads/job_fair/' . $photo . ''))
			return base_url() . 'uploads/job_fair/' . $photo . '';
		else
			return base_url() . 'uploads/users/placeholder.jpg';
	}
	// Get job_fairs Ends

	public function create_job_fair()
	{
		$data['title']      = $this->input->post('title');
		$data['description'] = $this->input->post('description');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;
		$file_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
		$data['photo'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/job_fair/' . $data['photo']);
		$this->db->insert('job_fairs', $data);

		$history_data['ket'] = 'Mengisi data job fairs';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('job_fair_added_successfully')
		);

		return json_encode($response);
	}

	public function update_job_fair($id = "")
	{
		$data['title']      = $this->input->post('title');
		$data['description'] = $this->input->post('description');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$file_ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
		if (!empty($file_ext)) {
			$data['photo'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
			move_uploaded_file($_FILES['photo']['tmp_name'], 'uploads/job_fair/' . $data['photo']);
		} else {
		}

		$this->db->where('id', $id);
		$this->db->update('job_fairs', $data);

		$history_data['ket'] = 'Update data job_fairs ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('job_fair_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_job_fair($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('job_fairs');

		$history_data['ket'] = 'Delete data job_fairs ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('job_fair_deleted_successfully')
		);
		return json_encode($response);
	}
	// JOB FAIR Manager FINISH

	// Book Manager
	public function get_books()
	{
		$checker = array(
			'school_id' => $this->school_id
		);
		return $this->db->get_where('books', $checker);
	}

	public function get_book_by_id($id = "")
	{
		return $this->db->get_where('books', array('id' => $id))->row_array();
	}

	public function create_book()
	{
		$data['name']      = $this->input->post('name');
		$data['book_code'] = $this->input->post('book_code');
		$data['book_type_id'] 	= $this->input->post('book_type_id');
		$data['book_release'] = $this->input->post('book_release');
		$data['author']    = $this->input->post('author');
		$data['publisher']    = $this->input->post('publisher');
		$data['copies']    = $this->input->post('copies');
		$data['summary']    = $this->input->post('summary');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;
		$file_ext = pathinfo($_FILES['ebook']['name'], PATHINFO_EXTENSION);
		$data['ebook'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['ebook']['tmp_name'], 'uploads/ebook/' . $data['ebook']);
		$this->db->insert('books', $data);

		$history_data['ket'] = 'Mengisi data books';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('books_added_successfully')
		);

		return json_encode($response);
	}

	public function update_book($id = "")
	{
		$data['name']      = $this->input->post('name');
		$data['book_code'] = $this->input->post('book_code');
		$data['book_type_id'] = $this->input->post('book_type_id');
		$data['book_release'] = $this->input->post('book_release');
		$data['author']    = $this->input->post('author');
		$data['publisher']    = $this->input->post('publisher');
		$data['copies']    = $this->input->post('copies');
		$data['summary']    = $this->input->post('summary');
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('books', $data);

		$history_data['ket'] = 'Update data books ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('books_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_book($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('books');

		$history_data['ket'] = 'Delete data books ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('books_deleted_successfully')
		);
		return json_encode($response);
	}

	// Book Issue
	public function get_book_issue_favorit()
	{
		$school_id = school_id();
		return $this->db->query('SELECT book_id, COUNT(book_id) as jumlah FROM book_issues WHERE school_id = ' . $school_id . ' GROUP BY book_id ORDER BY jumlah DESC');
	}

	public function get_book_issues($date_from = "", $date_to = "")
	{
		$this->db->where('session', $this->active_session);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('issue_date >=', $date_from);
		$this->db->where('issue_date <=', $date_to);
		return $this->db->get('book_issues');
	}

	public function get_book_issues_by_user_id($user_id = "")
	{
		$this->db->where('user_id', $user_id);
		return $this->db->get('book_issues');
	}

	public function get_book_issue_by_id($id = "")
	{
		return $this->db->get_where('book_issues', array('id' => $id))->row_array();
	}

	public function create_book_issue()
	{
		$_book_id = html_escape($this->input->post('book_id'));

		// $data['book_id']    = $this->input->post('book_id');

		for ($i = 0; $i < count($_book_id); $i++) {
			$book_id = $_book_id[$i];

			$data['book_id'] = $book_id;
			$data['user_id'] = $this->input->post('user_id');
			$data['issue_date'] = strtotime($this->input->post('issue_date'));
			$data['return_date'] = $this->input->post('return_date') . ' 23:59:59';
			$data['school_id'] = $this->school_id;
			$data['session']   = $this->active_session;

			$this->db->insert('book_issues', $data);

			$history_data['ket'] = 'Mengisi data book issues';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_book_issue($id = "")
	{
		$data['book_id']    = $this->input->post('book_id');
		$data['user_id'] = $this->input->post('user_id');
		$data['issue_date'] = strtotime($this->input->post('issue_date'));
		$data['return_date'] = $this->input->post('return_date') . ' 23:59:59';
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('book_issues', $data);

		$history_data['ket'] = 'Update data book_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function update_status_book_issue($id = "")
	{
		$data['status']    = 2;

		$this->db->where('id', $id);
		$this->db->update('book_issues', $data);

		$history_data['ket'] = 'Update data book_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('due_date_successfully')
		);
		return json_encode($response);
	}

	public function return_issued_book($id = "")
	{
		$data['status']   = 1;

		$this->db->where('id', $id);
		$this->db->update('book_issues', $data);

		$history_data['ket'] = 'Update data book_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('returned_successfully')
		);
		return json_encode($response);
	}

	public function get_number_of_issued_book_by_id($id)
	{
		return $this->db->get_where('book_issues', array('book_id' => $id, 'status' => 0))->num_rows();
	}

	public function delete_book_issue($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('book_issues');

		$history_data['ket'] = 'Delete data book_issues ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	// Visit Data Library

	public function get_users($id = "")
	{

		$this->db->where('school_id', $this->school_id);

		if ($id > 0) {
			$this->db->where('id', $id);
		}
		return $this->db->get('users');
	}

	public function get_visit_data_by_id($id = "")
	{
		return $this->db->get_where('visit_data', array('id' => $id))->row_array();
	}

	public function create_visit_data()
	{
		$data['user_id'] = $this->input->post('user_id');
		$data['name'] = $this->input->post('name');
		$data['nik'] = $this->input->post('nik');
		$data['address'] = $this->input->post('address');
		$data['phone'] = $this->input->post('phone');

		if (empty($data['user_id'])) {
			$data['user_id'] = '0';
		}

		if (empty($data['name'])) {
			$data['name'] = '0';
		}

		if (empty($data['nik'])) {
			$data['nik'] = '0';
		}

		if (empty($data['address'])) {
			$data['address'] = '0';
		}

		if (empty($data['phone'])) {
			$data['phone'] = '0';
		}

		$data['date'] = strtotime($this->input->post('date'));
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->insert('visit_data', $data);

		$history_data['ket'] = 'Mengisi data visit data';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function update_visit_data($id = "")
	{
		$data['user_id'] = $this->input->post('user_id');
		$data['name'] = $this->input->post('name');
		$data['nik'] = $this->input->post('nik');
		$data['address'] = $this->input->post('address');
		$data['phone'] = $this->input->post('phone');

		if (empty($data['user_id'])) {
			$data['user_id'] = '0';
		}

		if (empty($data['name'])) {
			$data['name'] = '0';
		}

		if (empty($data['nik'])) {
			$data['nik'] = '0';
		}

		if (empty($data['address'])) {
			$data['address'] = '0';
		}

		if (empty($data['phone'])) {
			$data['phone'] = '0';
		}
		$data['date'] = strtotime($this->input->post('date'));
		$data['school_id'] = $this->school_id;
		$data['session']   = $this->active_session;

		$this->db->where('id', $id);
		$this->db->update('visit_data', $data);

		$history_data['ket'] = 'Update data visit_data ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_visit_data($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('visit_data');

		$history_data['ket'] = 'Delete data visit_data ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//SCHOOL DETAILS
	public function get_schools()
	{
		if (!addon_status('multi-school')) {
			$this->db->where('id', school_id());
		}
		$schools = $this->db->get('schools');
		return $schools;
	}
	public function get_school_details_by_id($school_id = "")
	{
		return $this->db->get_where('schools', array('id' => $school_id))->row_array();
	}
	// Back Office Section Ends

	// GET INSTALLED ADDONS
	public function get_addons($unique_identifier = "")
	{
		if ($unique_identifier != "") {
			$addons = $this->db->get_where('addons', array('unique_identifier' => $unique_identifier));
		} else {
			$addons = $this->db->get_where('addons');
		}
		return $addons;
	}

	// A function to convert excel to csv
	public function excel_to_csv($file_path = "", $rename_to = "")
	{
		//read file from path
		$inputFileType = PHPExcel_IOFactory::identify($file_path);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($file_path);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
		$index = 0;
		if ($objPHPExcel->getSheetCount() > 1) {
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$objPHPExcel->setActiveSheetIndex($index);
				$fileName = strtolower(str_replace(array("-", " "), "_", $worksheet->getTitle()));
				$outFile = str_replace(".", "", $fileName) . ".csv";
				$objWriter->setSheetIndex($index);
				$objWriter->save("assets/csv_file/" . $outFile);
				$index++;
			}
		} else {
			$outFile = $rename_to;
			$objWriter->setSheetIndex($index);
			$objWriter->save("assets/csv_file/" . $outFile);
		}

		return true;
	}

	public function check_recaptcha()
	{
		if (isset($_POST["g-recaptcha-response"])) {
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$data = array(
				'secret' => get_common_settings('recaptcha_secretkey'),
				'response' => $_POST["g-recaptcha-response"]
			);
			$query = http_build_query($data);
			$options = array(
				'http' => array(
					'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
						"Content-Length: " . strlen($query) . "\r\n" .
						"User-Agent:MyAgent/1.0\r\n",
					'method' => 'POST',
					'content' => $query
				)
			);
			$context  = stream_context_create($options);
			$verify = file_get_contents($url, false, $context);
			$captcha_success = json_decode($verify);
			if ($captcha_success->success == false) {
				return false;
			} else if ($captcha_success->success == true) {
				return true;
			}
		} else {
			return false;
		}
	}

	public function upload_excel_means()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;

		$locations_query = $this->db->get_where('locations')->result_array();
		$locations = [];
		foreach ($locations_query as $location) {
			$locations[strtolower($location['name'])] = [
				'_id' => $location['id'],
			];
		}

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadsarana.csv');

		if (($handle = fopen('uploads/csv_file/uploadsarana.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {
					$location_id = strtolower(trim($all_data[4]));

					$means_data['name'] = html_escape($all_data[0]);
					$means_data['condition'] = html_escape($all_data[1]);
					$means_data['amount'] = html_escape($all_data[2]);
					$means_data['status'] = html_escape($all_data[3]);
					$means_data['school_id'] = $school_id;
					$means_data['session'] = $session_id;

					if (isset($means_data['location_id']))
						unset($means_data['location_id']);
					if (array_key_exists($location_id, $locations)) {
						$means_data['location_id'] = $locations[$location_id]['_id'];
					}

					$duplication_status = $this->check_duplication('on_create', $means_data['name']);
					if ($duplication_status) {
						$this->db->insert('means', $means_data);

						$history_data['ket'] = 'Mengisi data means';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $means_data['name'] = html_escape($all_data[0])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_infrastructure()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;

		$locations_query = $this->db->get_where('locations')->result_array();
		$locations = [];
		foreach ($locations_query as $location) {
			$locations[strtolower($location['name'])] = [
				'_id' => $location['id'],
			];
		}

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadprasarana.csv');

		if (($handle = fopen('uploads/csv_file/uploadprasarana.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {
					$location_id = strtolower(trim($all_data[4]));

					$infrastructure_data['name'] = html_escape($all_data[0]);
					$infrastructure_data['condition'] = html_escape($all_data[1]);
					$infrastructure_data['amount'] = html_escape($all_data[2]);
					$infrastructure_data['status'] = html_escape($all_data[3]);
					$infrastructure_data['school_id'] = $school_id;
					$infrastructure_data['session'] = $session_id;

					if (isset($infrastructure_data['location_id']))
						unset($infrastructure_data['location_id']);
					if (array_key_exists($location_id, $locations)) {
						$infrastructure_data['location_id'] = $locations[$location_id]['_id'];
					}

					$duplication_status = $this->check_duplication('on_create', $infrastructure_data['name']);
					if ($duplication_status) {
						$this->db->insert('infrastructure', $infrastructure_data);

						$history_data['ket'] = 'Mengisi data infrastructure';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $infrastructure_data['name'] = html_escape($all_data[0])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_book()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;

		$book_types_query = $this->db->get_where('book_types')->result_array();
		$book_types = [];
		foreach ($book_types_query as $book_type) {
			$book_types[strtolower($book_type['name'])] = [
				'_id' => $book_type['id'],
			];
		}

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadbuku.csv');

		if (($handle = fopen('uploads/csv_file/uploadbuku.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {
					$book_type_id = strtolower(trim($all_data[2]));

					$bukudata['book_code'] = html_escape($all_data[0]);
					$bukudata['name'] = html_escape($all_data[1]);
					$bukudata['book_release'] = html_escape($all_data[3]);
					$bukudata['author'] = html_escape($all_data[4]);
					$bukudata['publisher'] = html_escape($all_data[5]);
					$bukudata['copies'] = html_escape($all_data[6]);
					$bukudata['summary'] = html_escape($all_data[7]);
					$bukudata['school_id'] = $school_id;
					$bukudata['session'] = $session_id;

					if (isset($bukudata['book_type_id']))
						unset($bukudata['book_type_id']);
					if (array_key_exists($book_type_id, $book_types)) {
						$bukudata['book_type_id'] = $book_types[$book_type_id]['_id'];
					}

					$duplication_status = $this->check_duplication('on_create', $bukudata['name']);
					if ($duplication_status) {
						$this->db->insert('books', $bukudata);

						$history_data['ket'] = 'Mengisi data books';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $bukudata['name'] = html_escape($all_data[1])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function import()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;
		$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
		$classes = [];
		foreach ($classes_query as $class) {
			$classes[strtolower($class['name'])] = [
				'_id' => $class['id'],
			];
			$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
			foreach ($sections as $section) {
				$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
			}
		}

		$class_room_query = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
		$class_rooms = [];
		foreach ($class_room_query as $class_room) {
			$class_rooms[strtolower($class_room['name'])] = [
				'_id' => $class_room['id'],
			];
		}

		$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

		if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
			$arr_file = explode('.', $_FILES['csv_file']['name']);
			$extension = end($arr_file);
			if ('csv' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
			} elseif ('xls' == $extension) {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
			} else {
				$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			}
			$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
			$sheetData = $spreadsheet->getActiveSheet()->toArray();

			for ($i = 1; $i < count($sheetData); $i++) {
				if (isset($parentid)) unset($parentid);
				if (!empty($sheetData[$i]['13'])) {

					$gender = '';
					switch (strtolower(trim($sheetData[$i]['17']))) {
						case 'laki-laki':
							$gender = 'Male';
							break;
						case 'male':
							$gender = 'Male';
							break;
						case 'perempuan':
							$gender = 'Female';
							break;
						case 'female':
							$gender = 'Female';
							break;
						default:
							$gender = 'Male';
							break;
					}

					$parentdata['name'] = html_escape(trim($sheetData[$i]['12']));
					$parentdata['gender'] = $gender;
					$parentdata['blood_group'] = html_escape(trim($sheetData[$i]['18']));
					$parentdata['email'] = html_escape(trim($sheetData[$i]['13']));
					$parentdata['password'] = sha1(trim($sheetData[$i]['14']));
					$parentdata['address'] = html_escape(trim($sheetData[$i]['15']));
					$parentdata['phone'] = html_escape(trim($sheetData[$i]['16']));
					$parentdata['role'] = 'parent';
					$parentdata['school_id'] = $school_id;
					$parentdata['watch_history'] = '[]';

					$parentuserrow = $this->db->get_where('users', array('email' => $parentdata['email']))->row();
					if (empty($parentuserrow)) {
						$this->db->insert('users', $parentdata);
						$parentuserid = $this->db->insert_id();

						$history_data['ket'] = 'Mengisi data users for parents';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);

						$parent_data['user_id'] = $parentuserid;
						$parent_data['school_id'] = $school_id;
						$this->db->insert('parents', $parent_data);
						$parentid = $this->db->insert_id();

						$history_data['ket'] = 'Mengisi data parents';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$parentrow = $this->db->get_where('parents', array('user_id' => $parentuserrow->id))->row();
						if (!empty($parentrow)) {
							$parentid = $parentrow->id;
						}

						$response = array(
							'status' => true,
							'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $parentdata['email'] = trim($sheetData[$i]['13'])
						);
					}
				}

				if (!empty($sheetData[$i]['3'])) {

					$gender_siswa = '';
					switch (strtolower(trim($sheetData[$i]['10']))) {
						case 'laki-laki':
							$gender_siswa = 'Male';
							break;
						case 'male':
							$gender_siswa = 'Male';
							break;
						case 'perempuan':
							$gender_siswa = 'Female';
							break;
						case 'female':
							$gender_siswa = 'Female';
							break;
						default:
							$gender_siswa = 'Male';
							break;
					}

					$userdata['name'] = html_escape(trim($sheetData[$i]['2']));
					$userdata['gender'] = $gender_siswa;
					$userdata['birthday'] = trim($sheetData[$i]['11']);
					$userdata['email'] = html_escape(trim($sheetData[$i]['3']));
					$userdata['password'] = sha1(trim($sheetData[$i]['4']));
					$userdata['address'] = html_escape(trim($sheetData[$i]['8']));
					$userdata['phone'] = html_escape(trim($sheetData[$i]['9']));
					$userdata['role'] = 'student';
					$userdata['school_id'] = $school_id;
					$userdata['watch_history'] = '[]';

					$not_duplicated = $this->check_duplication('on_create', $userdata['email']);
					
					$this->db->from('users');
					$this->db->where('role', 'student');
					$user_student = $this->db->count_all_results();
					if ($user_student > 500) {
						$response = array(
							'status' => true,
							'notification' => get_phrase('Data sudah mencapai Limit')
						);
					} elseif ($not_duplicated) {
						$this->db->insert('users', $userdata);
						$user_id = $this->db->insert_id();

						$history_data['ket'] = 'Mengisi data users';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);

						//INSERT PPDB SIPS START
						$db2 = $this->load->database('database_sips', TRUE);

						$kelas = strtolower(trim($sheetData[$i]['5']));
						$bagian = strtolower(trim($sheetData[$i]['6']));

						if (array_key_exists($kelas, $classes)) {
							$enroll_data['class_id'] = $classes[$kelas]['_id'];
							if (array_key_exists($bagian, $classes[$kelas])) {
								$enroll_data['section_id'] = $classes[$kelas][$bagian];
							}
						}

						$class_id = $classes[$kelas]['_id'];
						$section_id = $classes[$kelas][$bagian];

						$class_data = $this->db->get_where('classes', array('id' => $class_id))->row_array();
						$section_data = $this->db->get_where('sections', array('id' => $section_id))->row_array();

						$majorsquery = $db2->get_where('majors', array('majors_name' => $section_data['name']))->row_array();
						$classquery = $db2->get_where('class', array('class_name' => $class_data['name']))->row_array();

						$data_db2['class_class_id'] = $classquery['class_id'];
						$data_db2['majors_majors_id'] = $majorsquery['majors_id'];
						$data_db2['student_nisn'] = trim($sheetData[$i]['0']);
						$data_db2['student_nis'] = trim($sheetData[$i]['1']);
						$data_db2['student_input_date'] = date('Y-m-d H:i:s');
						$data_db2['student_last_update'] = date('Y-m-d H:i:s');
						$data_db2['student_name_of_mother'] = strtoupper(trim($sheetData[$i]['12']));
						$data_db2['student_name_of_father'] = strtoupper(trim($sheetData[$i]['12']));
						$data_db2['student_address'] = trim($sheetData[$i]['8']);
						$data_db2['student_born_date'] = date('Y-m-d', strtotime(trim($sheetData[$i]['11'])));
						if ($gender_siswa == 'Male') {
							$data_db2['student_gender'] = "Laki-laki";
						} else {
							$data_db2['student_gender'] = "Perempuan";
						};
						$data_db2['student_full_name'] = strtoupper(trim($sheetData[$i]['2']));
						$data_db2['student_password'] = sha1(date('dmy', strtotime(trim($sheetData[$i]['11']))));
						$data_db2['student_parent_phone'] = trim($sheetData[$i]['16']);
						$data_db2['student_phone'] = trim($sheetData[$i]['9']);
						$db2->insert('student', $data_db2);
						//INSERT PPDB SIPS FINISH

						$student_data['code'] = student_code();
						$student_data['user_id'] = $user_id;
						if (isset($parentid)) {
							$student_data['parent_id'] = $parentid;
						} else if (isset($student_data['parent_id'])) {
							unset($student_data['parent_id']);
						}
						$student_data['session'] = $session_id;
						$student_data['school_id'] = $school_id;
						$student_data['nisn'] = strtolower(trim($sheetData[$i]['0']));
						$student_data['nis'] = strtolower(trim($sheetData[$i]['1']));
						$this->db->insert('students', $student_data);
						$student_id = $this->db->insert_id();

						$history_data['ket'] = 'Mengisi data students';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);

						$enroll_data['student_id'] = $student_id;
						$enroll_data['session'] = $session_id;
						$enroll_data['school_id'] = $school_id;
						$kelas = strtolower(trim($sheetData[$i]['5']));
						$bagian = strtolower(trim($sheetData[$i]['6']));
						$ruang_kelas = strtolower(trim($sheetData[$i]['7']));

						if (isset($enroll_data['class_id']))
							unset($enroll_data['class_id']);
						if (isset($enroll_data['section_id']))
							unset($enroll_data['section_id']);
						if (isset($enroll_data['room_id']))
							unset($enroll_data['room_id']);

						if (array_key_exists($kelas, $classes)) {
							$enroll_data['class_id'] = $classes[$kelas]['_id'];
							if (array_key_exists($bagian, $classes[$kelas])) {
								$enroll_data['section_id'] = $classes[$kelas][$bagian];
							}
						}
						if (array_key_exists($ruang_kelas, $class_rooms)) {
							$enroll_data['room_id'] = $class_rooms[$ruang_kelas]['_id'];
						}

						$this->db->insert('enrols', $enroll_data);

						$history_data['ket'] = 'Mengisi data enrols';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						// $last_student = $this->db->query('SELECT * FROM users ORDER BY id DESC LIMIT 1')->result_array();
						$response = array(
							'status' => true,
							'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $userdata['email'] = html_escape(trim($sheetData[$i]['3']))
						);
					}
				}
			}

			if (empty($response)) {
				$response = array(
					'status' => true,
					'notification' => get_phrase('successfully_entered_all_data')
				);
			}

			return json_encode($response);
		}
	}

	public function upload_excel_student()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;
		$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
		$classes = [];
		foreach ($classes_query as $class) {
			$classes[strtolower($class['name'])] = [
				'_id' => $class['id'],
			];
			$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
			foreach ($sections as $section) {
				$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
			}
		}

		$class_room_query = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
		$class_rooms = [];
		foreach ($class_room_query as $class_room) {
			$class_rooms[strtolower($class_room['name'])] = [
				'_id' => $class_room['id'],
			];
		}

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadsiswa.csv');

		if (($handle = fopen('uploads/csv_file/uploadsiswa.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {
					if (isset($parentid)) unset($parentid);
					if (!empty($csv[13])) {

						$gender = '';
						switch (strtolower(trim($csv[17]))) {
							case 'laki-laki':
								$gender = 'Male';
								break;
							case 'male':
								$gender = 'Male';
								break;
							case 'perempuan':
								$gender = 'Female';
								break;
							case 'female':
								$gender = 'Female';
								break;
							default:
								$gender = 'Male';
								break;
						}

						$parentdata['name'] = html_escape(trim($csv[12]));
						$parentdata['gender'] = $gender;
						$parentdata['blood_group'] = html_escape(trim($csv[18]));
						$parentdata['email'] = html_escape(trim($csv[13]));
						$parentdata['password'] = sha1(trim($csv[14]));
						$parentdata['address'] = html_escape(trim($csv[15]));
						$parentdata['phone'] = html_escape(trim($csv[16]));
						$parentdata['role'] = 'parent';
						$parentdata['school_id'] = $school_id;
						$parentdata['watch_history'] = '[]';

						$parentuserrow = $this->db->get_where('users', array('email' => $parentdata['email']))->row();
						if (empty($parentuserrow)) {
							$this->db->insert('users', $parentdata);
							$parentuserid = $this->db->insert_id();

							$history_data['ket'] = 'Mengisi data users';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							$parent_data['user_id'] = $parentuserid;
							$parent_data['school_id'] = $school_id;
							$this->db->insert('parents', $parent_data);
							$parentid = $this->db->insert_id();

							$history_data['ket'] = 'Mengisi data parents';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$parentrow = $this->db->get_where('parents', array('user_id' => $parentuserrow->id))->row();
							if (!empty($parentrow)) {
								$parentid = $parentrow->id;
							}

							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $parentdata['email'] = trim($csv[13])
							);
							fclose($handle);
						}
					}

					if (!empty($csv[3])) {

						$gender_siswa = '';
						switch (strtolower(trim($csv[10]))) {
							case 'laki-laki':
								$gender_siswa = 'Male';
								break;
							case 'male':
								$gender_siswa = 'Male';
								break;
							case 'perempuan':
								$gender_siswa = 'Female';
								break;
							case 'female':
								$gender_siswa = 'Female';
								break;
							default:
								$gender_siswa = 'Male';
								break;
						}

						$userdata['name'] = html_escape(trim($csv[2]));
						$userdata['gender'] = $gender_siswa;
						$userdata['birthday'] = trim($csv[11]);
						$userdata['email'] = html_escape(trim($csv[3]));
						$userdata['password'] = sha1(trim($csv[4]));
						$userdata['address'] = html_escape(trim($csv[8]));
						$userdata['phone'] = html_escape(trim($csv[9]));
						$userdata['role'] = 'student';
						$userdata['school_id'] = $school_id;
						$userdata['watch_history'] = '[]';

						$not_duplicated = $this->check_duplication('on_create', $userdata['email']);
						$this->db->from('users');
						$this->db->where('role', 'student');
						$user_student = $this->db->count_all_results();
						if ($user_student > 500) {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Data sudah mencapai Limit')
							);
						} elseif ($not_duplicated) {
							$this->db->insert('users', $userdata);
							$user_id = $this->db->insert_id();

							$history_data['ket'] = 'Mengisi data users';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							//INSERT PPDB SIPS START
							$db2 = $this->load->database('database_sips', TRUE);

							$kelas = strtolower(trim($csv[5]));
							$bagian = strtolower(trim($csv[6]));

							if (array_key_exists($kelas, $classes)) {
								$enroll_data['class_id'] = $classes[$kelas]['_id'];
								if (array_key_exists($bagian, $classes[$kelas])) {
									$enroll_data['section_id'] = $classes[$kelas][$bagian];
								}
							}

							$class_id = $classes[$kelas]['_id'];
							$section_id = $classes[$kelas][$bagian];

							$class_data = $this->db->get_where('classes', array('id' => $class_id))->row_array();
							$section_data = $this->db->get_where('sections', array('id' => $section_id))->row_array();

							$majorsquery = $db2->get_where('majors', array('majors_name' => $section_data['name']))->row_array();
							$classquery = $db2->get_where('class', array('class_name' => $class_data['name']))->row_array();

							$data_db2['class_class_id'] = $classquery['class_id'];
							$data_db2['majors_majors_id'] = $majorsquery['majors_id'];
							$data_db2['student_nisn'] = trim($csv[0]);
							$data_db2['student_nis'] = trim($csv[1]);
							$data_db2['student_input_date'] = date('Y-m-d H:i:s');
							$data_db2['student_last_update'] = date('Y-m-d H:i:s');
							$data_db2['student_name_of_mother'] = strtoupper(trim($csv[12]));
							$data_db2['student_name_of_father'] = strtoupper(trim($csv[12]));
							$data_db2['student_address'] = trim($csv[8]);
							$data_db2['student_born_date'] = date('Y-m-d', strtotime(trim($csv[11])));
							if ($gender_siswa == 'Male') {
								$data_db2['student_gender'] = "Laki-laki";
							} else {
								$data_db2['student_gender'] = "Perempuan";
							};
							$data_db2['student_full_name'] = strtoupper(trim($csv[2]));
							$data_db2['student_password'] = sha1(date('dmy', strtotime(trim($csv[11]))));
							$data_db2['student_parent_phone'] = trim($csv[16]);
							$data_db2['student_phone'] = trim($csv[9]);
							$db2->insert('student', $data_db2);
							//INSERT PPDB SIPS FINISH

							$student_data['code'] = student_code();
							$student_data['user_id'] = $user_id;
							if (isset($parentid)) {
								$student_data['parent_id'] = $parentid;
							} else if (isset($student_data['parent_id'])) {
								unset($student_data['parent_id']);
							}
							$student_data['session'] = $session_id;
							$student_data['school_id'] = $school_id;
							$student_data['nisn'] = strtolower(trim($csv[0]));
							$student_data['nis'] = strtolower(trim($csv[1]));
							$this->db->insert('students', $student_data);
							$student_id = $this->db->insert_id();

							$history_data['ket'] = 'Mengisi data students';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							$enroll_data['student_id'] = $student_id;
							$enroll_data['session'] = $session_id;
							$enroll_data['school_id'] = $school_id;
							$kelas = strtolower(trim($csv[5]));
							$bagian = strtolower(trim($csv[6]));
							$ruang_kelas = strtolower(trim($csv[7]));

							if (isset($enroll_data['class_id']))
								unset($enroll_data['class_id']);
							if (isset($enroll_data['section_id']))
								unset($enroll_data['section_id']);
							if (isset($enroll_data['room_id']))
								unset($enroll_data['room_id']);

							if (array_key_exists($kelas, $classes)) {
								$enroll_data['class_id'] = $classes[$kelas]['_id'];
								if (array_key_exists($bagian, $classes[$kelas])) {
									$enroll_data['section_id'] = $classes[$kelas][$bagian];
								}
							}
							if (array_key_exists($ruang_kelas, $class_rooms)) {
								$enroll_data['room_id'] = $class_rooms[$ruang_kelas]['_id'];
							}

							$this->db->insert('enrols', $enroll_data);

							$history_data['ket'] = 'Mengisi data enrols';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							// $last_student = $this->db->query('SELECT * FROM users ORDER BY id DESC LIMIT 1')->result_array();
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $userdata['email'] = html_escape(trim($csv[3]))
							);
							fclose($handle);
						}
					}
				}
				$count++;
			}

			fclose($handle);
		}

		if (empty($response)) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('successfully_entered_all_data')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_knowledge_base()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;
		$teacher_id = $this->input->post('teacher_id');

		$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
		$classes = [];
		foreach ($classes_query as $class) {
			$classes[strtolower($class['name'])] = [
				'_id' => $class['id'],
			];
			$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
			foreach ($sections as $section) {
				$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
			}
		}

		$mapel_query = $this->db->get_where('subjects', array('school_id' => $school_id, 'teacher_id' => $teacher_id))->result_array();
		$subjects = [];
		foreach ($mapel_query as $mapel) {
			$subjects[$mapel['section_id']][strtolower($mapel['name'])] = $mapel['id'];
		}

		// $subjects_query = $this->db->get_where('subjects', array('teacher_id' => $teacher_id))->result_array();
		// 	$subjects_data = [];
		// 	foreach ($subjects_query as $subject) {
		// 		$subjects_data[strtolower($subject['name'])] = [
		// 			'_id' => $subject['id'],
		// 		];
		// 	}

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploaddasarkompetesi.csv');

		if (($handle = fopen('uploads/csv_file/uploaddasarkompetesi.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {
					$kelas = strtolower(trim($all_data[0]));
					$bagian = strtolower(trim($all_data[1]));
					$mapel = strtolower(trim($all_data[2]));

					if (array_key_exists($kelas, $classes)) {
						$base_data['class_id'] = $classes[$kelas]['_id'];
						if (array_key_exists($bagian, $classes[$kelas])) {
							$base_data['section_id'] = $classes[$kelas][$bagian];
						}
					}

					if (array_key_exists('section_id', $base_data)) {
						if (array_key_exists($base_data['section_id'], $subjects)) {
							if (array_key_exists($mapel, $subjects[$base_data['section_id']])) {
								$base_data['subject_id'] = $subjects[$base_data['section_id']][$mapel];
							}
						}
					}

					// if (isset($base_data['subject_id']))
					// 	unset($base_data['subject_id']);
					// if (array_key_exists($subject_id, $subjects_data)) {
					// 	$base_data['subject_id'] = $subjects_data[$subject_id]['_id'];
					// }

					// $subject_data = $this->db->get_where('subjects', array('id' => $base_data['subject_id']))->row_array();
					$base_data['name'] = html_escape($all_data[3]);
					$base_data['school_id'] = $school_id;
					$base_data['session_id'] = $session_id;

					$duplication_status = $this->check_duplication('on_create', $base_data['name']);
					if ($duplication_status) {
						$this->db->insert('knowledge_base', $base_data);

						$history_data['ket'] = 'Mengisi data knowledge base';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $base_data['name'] = html_escape($all_data[3])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_book_types()
	{
		$school_id = $this->school_id;

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadjenisbuku.csv');

		if (($handle = fopen('uploads/csv_file/uploadjenisbuku.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {

					$bukutipe['name'] = html_escape($all_data[0]);
					$bukutipe['school_id'] = $school_id;

					$duplication_status = $this->check_duplication('on_create', $bukutipe['name']);
					if ($duplication_status) {
						$this->db->insert('book_types', $bukutipe);

						$history_data['ket'] = 'Mengisi data book types';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $bukutipe['name'] = html_escape($all_data[0])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_organization()
	{
		$school_id = $this->school_id;

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadeskul.csv');

		if (($handle = fopen('uploads/csv_file/uploadeskul.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {

					$eskul['name'] = html_escape($all_data[0]);
					$eskul['school_id'] = $school_id;

					$duplication_status = $this->check_duplication('on_create', $eskul['name']);
					if ($duplication_status) {
						$this->db->insert('organizations', $eskul);

						$history_data['ket'] = 'Mengisi data organizations';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $eskul['name'] = html_escape($all_data[0])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_mistakes()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadpelanggaran.csv');

		if (($handle = fopen('uploads/csv_file/uploadpelanggaran.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {

					$mistakedata['name'] = html_escape($all_data[0]);
					$mistakedata['point'] = html_escape($all_data[1]);
					$mistakedata['school_id'] = $school_id;
					$mistakedata['session'] = $session_id;

					$duplication_status = $this->check_duplication('on_create', $mistakedata['name']);
					if ($duplication_status) {
						$this->db->insert('mistakes', $mistakedata);

						$history_data['ket'] = 'Mengisi data mistakes';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $mistakedata['name'] = html_escape($all_data[0])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_awards()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadpenghargaan.csv');

		if (($handle = fopen('uploads/csv_file/uploadpenghargaan.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {

					$awarddata['name'] = html_escape($all_data[0]);
					$awarddata['point'] = html_escape($all_data[1]);
					$awarddata['school_id'] = $school_id;
					$awarddata['session'] = $session_id;

					$duplication_status = $this->check_duplication('on_create', $awarddata['name']);
					if ($duplication_status) {
						$this->db->insert('awards', $awarddata);

						$history_data['ket'] = 'Mengisi data awards';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $awarddata['name'] = html_escape($all_data[0])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_exam_types()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadjenisujian.csv');

		if (($handle = fopen('uploads/csv_file/uploadjenisujian.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {

					$exam_types_data['name'] = html_escape($all_data[0]);
					$exam_types_data['school_id'] = $school_id;
					$exam_types_data['session_id'] = $session_id;

					$duplication_status = $this->check_duplication('on_create', $exam_types_data['name']);
					if ($duplication_status) {
						$this->db->insert('exam_types', $exam_types_data);

						$history_data['ket'] = 'Mengisi data exam types';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $exam_types_data['name'] = html_escape($all_data[0])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_assignment_types()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadjenistugas.csv');

		if (($handle = fopen('uploads/csv_file/uploadjenistugas.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {

					$assignment_types_data['name'] = html_escape($all_data[0]);
					$assignment_types_data['school_id'] = $school_id;
					$assignment_types_data['session_id'] = $session_id;

					$duplication_status = $this->check_duplication('on_create', $assignment_types_data['name']);
					if ($duplication_status) {
						$this->db->insert('assignment_types', $assignment_types_data);

						$history_data['ket'] = 'Mengisi data assignment_types';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $assignment_types_data['name'] = html_escape($all_data[0])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel_years()
	{
		$school_id = $this->school_id;

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadtahun.csv');

		if (($handle = fopen('uploads/csv_file/uploadtahun.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {

					$year_data['name'] = html_escape($all_data[0]);
					$year_data['school_id'] = $school_id;

					$duplication_status = $this->check_duplication('on_create', $year_data['name']);
					if ($duplication_status) {
						$this->db->insert('years', $year_data);

						$history_data['ket'] = 'Mengisi data year';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					} else {
						$duplication_counter++;
					}
				}
				$count++;
			}
			fclose($handle);
		}
		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $year_data['name'] = html_escape($all_data[0])
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('added_successfully')
			);
		}

		return json_encode($response);
	}

	public function upload_excel()
	{
		$mode = $_POST['mode'];
		$school_id = $this->school_id;
		$session_id = $this->active_session;
		$message = "";

		if ($mode == 'kelas_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadkelas.csv');

			if (($handle = fopen('uploads/csv_file/uploadkelas.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				$classdata = [];
				$classid = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$name = trim($csv[0]);
						if (!array_key_exists('name', $classdata) || $classdata['name'] != $name) {
							$classdata['name'] = html_escape($name);
							$classdata['school_id'] = $school_id;

							// if class exists
							$classrow = $this->db->get_where('classes', array('name' => $classdata['name'], 'school_id' => $classdata['school_id']))->row();

							// if class not exists
							if (empty($classrow)) {
								$this->db->insert('classes', $classdata);
								$classid = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data classes';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);
							} else {
								$classid = $classrow->id;
							}
						}

						$sectiondata['name'] = html_escape(trim($csv[1]));
						$sectiondata['school_id'] = $school_id;
						$sectiondata['class_id'] = $classid;
						$sectionrow = $this->db->get_where('sections', array('name' => $sectiondata['name'], 'class_id' => $sectiondata['class_id']))->row();
						if (empty($sectionrow)) {
							$this->db->insert('sections', $sectiondata);
							// $sectionid = $this->db->insert_id();

							$history_data['ket'] = 'Mengisi data sections';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							// $classroomdata['name'] = html_escape(trim($csv[2]));
							// $classroomdata['section_id'] = $sectionid;
							// $classroomdata['school_id'] = $school_id;
							// $classroomdata['description'] = html_escape(trim($csv[3]));
							// $this->db->insert('class_rooms', $classroomdata);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $classdata['name'] = html_escape($name) . $sectiondata['name'] = html_escape(trim($csv[1]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'kelas') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				$count = 0;
				$classdata = [];
				$classid = 0;

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0'])) {
						$name = trim($sheetData[$i]['0']);
						if (!array_key_exists('name', $classdata) || $classdata['name'] != $name) {
							$classdata['name'] = html_escape($name);
							$classdata['school_id'] = $school_id;

							// if class exists
							$classrow = $this->db->get_where('classes', array('name' => $classdata['name'], 'school_id' => $classdata['school_id']))->row();

							// if class not exists
							if (empty($classrow)) {
								$this->db->insert('classes', $classdata);
								$classid = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data classes';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);
							} else {
								$classid = $classrow->id;
							}
						}

						$sectiondata['name'] = html_escape(trim($sheetData[$i]['1']));
						$sectiondata['school_id'] = $school_id;
						$sectiondata['class_id'] = $classid;
						$sectionrow = $this->db->get_where('sections', array('name' => $sectiondata['name'], 'class_id' => $sectiondata['class_id']))->row();
						if (empty($sectionrow)) {
							$this->db->insert('sections', $sectiondata);

							$history_data['ket'] = 'Mengisi data sections';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $classdata['name'] = html_escape($name) . $sectiondata['name'] = html_escape(trim($sheetData[$i]['1']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'ruangkelas_csv') {
			$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
			$classes = [];
			foreach ($classes_query as $class) {
				$classes[strtolower($class['name'])] = [
					'_id' => $class['id'],
				];
				$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
				foreach ($sections as $section) {
					$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
				}
			}
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadruangkelas.csv');

			if (($handle = fopen('uploads/csv_file/uploadruangkelas.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$kelas = strtolower(trim($csv[0]));
						$bagian = strtolower(trim($csv[1]));

						if (array_key_exists($kelas, $classes)) {
							if (array_key_exists($bagian, $classes[$kelas])) {
								$ruangdata['section_id'] = $classes[$kelas][$bagian];
							}
						}

						$ruangdata['name'] = html_escape(trim($csv[2]));
						$ruangdata['description'] = html_escape(trim($csv[3]));
						$ruangdata['school_id'] = $school_id;

						$ruangrow = $this->db->get_where('class_rooms', array('name' => $ruangdata['name'], 'school_id' => $ruangdata['school_id']))->row();
						if (empty($ruangrow)) {
							$this->db->insert('class_rooms', $ruangdata);

							$history_data['ket'] = 'Mengisi data class rooms';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							// $last_class_rooms = $this->db->query('SELECT * FROM class_rooms ORDER BY id DESC LIMIT 1')->result_array();
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $ruangdata['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'ruangkelas') {
			$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
			$classes = [];
			foreach ($classes_query as $class) {
				$classes[strtolower($class['name'])] = [
					'_id' => $class['id'],
				];
				$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
				foreach ($sections as $section) {
					$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
				}
			}
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0']) && !empty($sheetData[$i]['1'])) {
						$kelas = strtolower(trim($sheetData[$i]['0']));
						$bagian = strtolower(trim($sheetData[$i]['1']));

						if (array_key_exists($kelas, $classes)) {
							if (array_key_exists($bagian, $classes[$kelas])) {
								$ruangdata['section_id'] = $classes[$kelas][$bagian];
							}
						}

						$ruangdata['name'] = html_escape(trim($sheetData[$i]['2']));
						$ruangdata['description'] = html_escape(trim($sheetData[$i]['3']));
						$ruangdata['school_id'] = $school_id;

						$ruangrow = $this->db->get_where('class_rooms', array('name' => $ruangdata['name'], 'school_id' => $ruangdata['school_id']))->row();
						if (empty($ruangrow)) {
							$this->db->insert('class_rooms', $ruangdata);

							$history_data['ket'] = 'Mengisi data class rooms';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $ruangdata['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'siswa_csv') {
			$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
			$classes = [];
			foreach ($classes_query as $class) {
				$classes[strtolower($class['name'])] = [
					'_id' => $class['id'],
				];
				$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
				foreach ($sections as $section) {
					$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
				}
			}

			$class_room_query = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
			$class_rooms = [];
			foreach ($class_room_query as $class_room) {
				$class_rooms[strtolower($class_room['name'])] = [
					'_id' => $class_room['id'],
				];
			}

			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadsiswa.csv');

			if (($handle = fopen('uploads/csv_file/uploadsiswa.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0) {
						if (isset($parentid)) unset($parentid);
						if (!empty($csv[13])) {

							$gender = '';
							switch (strtolower(trim($csv[17]))) {
								case 'laki-laki':
									$gender = 'Male';
									break;
								case 'male':
									$gender = 'Male';
									break;
								case 'perempuan':
									$gender = 'Female';
									break;
								case 'female':
									$gender = 'Female';
									break;
								default:
									$gender = 'Male';
									break;
							}

							$parentdata['name'] = html_escape(trim($csv[12]));
							$parentdata['gender'] = $gender;
							$parentdata['blood_group'] = html_escape(trim($csv[18]));
							$parentdata['email'] = html_escape(trim($csv[13]));
							$parentdata['password'] = sha1(trim($csv[14]));
							$parentdata['address'] = html_escape(trim($csv[15]));
							$parentdata['phone'] = html_escape(trim($csv[16]));
							$parentdata['role'] = 'parent';
							$parentdata['school_id'] = $school_id;
							$parentdata['watch_history'] = '[]';

							$parentuserrow = $this->db->get_where('users', array('email' => $parentdata['email']))->row();
							if (empty($parentuserrow)) {
								$this->db->insert('users', $parentdata);
								$parentuserid = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data users';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);

								$parent_data['user_id'] = $parentuserid;
								$parent_data['school_id'] = $school_id;
								$this->db->insert('parents', $parent_data);
								$parentid = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data parents';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);
							} else {
								$parentrow = $this->db->get_where('parents', array('user_id' => $parentuserrow->id))->row();
								if (!empty($parentrow)) {
									$parentid = $parentrow->id;
								}
								// $last_parent = $this->db->query('SELECT * FROM users ORDER BY id DESC LIMIT 1')->result_array();
								$response = array(
									'status' => true,
									'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $parentdata['email'] = html_escape(trim($csv[13]))
								);
								fclose($handle);
							}
						}

						if (!empty($csv[3])) {

							$gender_siswa = '';
							switch (strtolower(trim($csv[10]))) {
								case 'laki-laki':
									$gender_siswa = 'Male';
									break;
								case 'male':
									$gender_siswa = 'Male';
									break;
								case 'perempuan':
									$gender_siswa = 'Female';
									break;
								case 'female':
									$gender_siswa = 'Female';
									break;
								default:
									$gender_siswa = 'Male';
									break;
							}

							$userdata['name'] = html_escape(trim($csv[2]));
							$userdata['gender'] = $gender_siswa;
							$userdata['blood_group'] = html_escape(trim($csv[11]));
							$userdata['email'] = html_escape(trim($csv[3]));
							$userdata['password'] = sha1(trim($csv[4]));
							$userdata['address'] = html_escape(trim($csv[8]));
							$userdata['phone'] = html_escape(trim($csv[9]));
							$userdata['role'] = 'student';
							$userdata['school_id'] = $school_id;
							$userdata['watch_history'] = '[]';

							$not_duplicated = $this->check_duplication('on_create', $userdata['email']);
							$this->db->from('users');
							$this->db->where('role', 'student');
							$user_student = $this->db->count_all_results();
							if ($user_student > 500) {
								$response = array(
									'status' => true,
									'notification' => get_phrase('Data sudah mencapai Limit')
								);
							} elseif ($not_duplicated) {
								$this->db->insert('users', $userdata);
								$user_id = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data users';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);

								$student_data['code'] = student_code();
								$student_data['user_id'] = $user_id;
								if (isset($parentid)) {
									$student_data['parent_id'] = $parentid;
								} else if (isset($student_data['parent_id'])) {
									unset($student_data['parent_id']);
								}
								$student_data['session'] = $session_id;
								$student_data['school_id'] = $school_id;
								$student_data['nisn'] = strtolower(trim($csv[0]));
								$student_data['nis'] = strtolower(trim($csv[1]));
								$this->db->insert('students', $student_data);
								$student_id = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data students';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);

								$enroll_data['student_id'] = $student_id;
								$enroll_data['session'] = $session_id;
								$enroll_data['school_id'] = $school_id;
								$kelas = strtolower(trim($csv[5]));
								$bagian = strtolower(trim($csv[6]));
								$ruang_kelas = strtolower(trim($csv[7]));

								if (isset($enroll_data['class_id']))
									unset($enroll_data['class_id']);
								if (isset($enroll_data['section_id']))
									unset($enroll_data['section_id']);
								if (isset($enroll_data['room_id']))
									unset($enroll_data['room_id']);

								if (array_key_exists($kelas, $classes)) {
									$enroll_data['class_id'] = $classes[$kelas]['_id'];
									if (array_key_exists($bagian, $classes[$kelas])) {
										$enroll_data['section_id'] = $classes[$kelas][$bagian];
									}
								}
								if (array_key_exists($ruang_kelas, $class_rooms)) {
									$enroll_data['room_id'] = $class_rooms[$ruang_kelas]['_id'];
								}

								$this->db->insert('enrols', $enroll_data);

								$history_data['ket'] = 'Mengisi data enrols';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);
							} else {
								// $last_student = $this->db->query('SELECT * FROM users ORDER BY id DESC LIMIT 1')->result_array();
								$response = array(
									'status' => true,
									'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $userdata['email'] = html_escape(trim($csv[3]))
								);
								fclose($handle);
							}
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'siswa') {
			$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
			$classes = [];
			foreach ($classes_query as $class) {
				$classes[strtolower($class['name'])] = [
					'_id' => $class['id'],
				];
				$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
				foreach ($sections as $section) {
					$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
				}
			}

			$class_room_query = $this->db->get_where('class_rooms', array('school_id' => school_id()))->result_array();
			$class_rooms = [];
			foreach ($class_room_query as $class_room) {
				$class_rooms[strtolower($class_room['name'])] = [
					'_id' => $class_room['id'],
				];
			}

			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['2']) && !empty($sheetData[$i]['3'])) {
						if (isset($parentid)) unset($parentid);
						if (!empty($sheetData[$i]['13'])) {

							$gender = '';
							switch (strtolower(trim($sheetData[$i]['17']))) {
								case 'laki-laki':
									$gender = 'Male';
									break;
								case 'male':
									$gender = 'Male';
									break;
								case 'perempuan':
									$gender = 'Female';
									break;
								case 'female':
									$gender = 'Female';
									break;
								default:
									$gender = 'Male';
									break;
							}

							$parentdata['name'] = html_escape(trim($sheetData[$i]['12']));
							$parentdata['gender'] = $gender;
							$parentdata['blood_group'] = html_escape(trim($sheetData[$i]['18']));
							$parentdata['email'] = html_escape(trim($sheetData[$i]['13']));
							$parentdata['password'] = sha1(trim($sheetData[$i]['14']));
							$parentdata['address'] = html_escape(trim($sheetData[$i]['15']));
							$parentdata['phone'] = html_escape(trim($sheetData[$i]['16']));
							$parentdata['role'] = 'parent';
							$parentdata['school_id'] = $school_id;
							$parentdata['watch_history'] = '[]';

							$parentuserrow = $this->db->get_where('users', array('email' => $parentdata['email']))->row();
							if (empty($parentuserrow)) {
								$this->db->insert('users', $parentdata);
								$parentuserid = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data users';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);

								$parent_data['user_id'] = $parentuserid;
								$parent_data['school_id'] = $school_id;
								$this->db->insert('parents', $parent_data);
								$parentid = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data parents';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);
							} else {
								$parentrow = $this->db->get_where('parents', array('user_id' => $parentuserrow->id))->row();
								if (!empty($parentrow)) {
									$parentid = $parentrow->id;
								}

								$response = array(
									'status' => true,
									'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $parentdata['email'] = html_escape(trim($sheetData[$i]['13']))
								);
								break;
							}
						}

						if (!empty($sheetData[$i]['3'])) {

							$gender_siswa = '';
							switch (strtolower(trim($sheetData[$i]['10']))) {
								case 'laki-laki':
									$gender_siswa = 'Male';
									break;
								case 'male':
									$gender_siswa = 'Male';
									break;
								case 'perempuan':
									$gender_siswa = 'Female';
									break;
								case 'female':
									$gender_siswa = 'Female';
									break;
								default:
									$gender_siswa = 'Male';
									break;
							}

							$userdata['name'] = html_escape(trim($sheetData[$i]['2']));
							$userdata['gender'] = $gender_siswa;
							$userdata['blood_group'] = html_escape(trim($sheetData[$i]['11']));
							$userdata['email'] = html_escape(trim($sheetData[$i]['3']));
							$userdata['password'] = sha1(trim($sheetData[$i]['4']));
							$userdata['address'] = html_escape(trim($sheetData[$i]['8']));
							$userdata['phone'] = html_escape(trim($sheetData[$i]['9']));
							$userdata['role'] = 'student';
							$userdata['school_id'] = $school_id;
							$userdata['watch_history'] = '[]';

							$not_duplicated = $this->check_duplication('on_create', $userdata['email']);
							$this->db->from('users');
							$this->db->where('role', 'student');
							$user_student = $this->db->count_all_results();
							if ($user_student > 500) {
								$response = array(
									'status' => true,
									'notification' => get_phrase('Data sudah mencapai Limit')
								);
							} elseif ($not_duplicated) {
								$this->db->insert('users', $userdata);
								$user_id = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data users';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);

								$student_data['code'] = student_code();
								$student_data['user_id'] = $user_id;
								if (isset($parentid)) {
									$student_data['parent_id'] = $parentid;
								} else if (isset($student_data['parent_id'])) {
									unset($student_data['parent_id']);
								}
								$student_data['session'] = $session_id;
								$student_data['school_id'] = $school_id;
								$student_data['nisn'] = strtolower(trim($sheetData[$i]['0']));
								$student_data['nis'] = strtolower(trim($sheetData[$i]['1']));
								$this->db->insert('students', $student_data);
								$student_id = $this->db->insert_id();

								$history_data['ket'] = 'Mengisi data students';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);

								$enroll_data['student_id'] = $student_id;
								$enroll_data['session'] = $session_id;
								$enroll_data['school_id'] = $school_id;
								$kelas = strtolower(trim($sheetData[$i]['5']));
								$bagian = strtolower(trim($sheetData[$i]['6']));
								$ruang_kelas = strtolower(trim($sheetData[$i]['7']));

								if (isset($enroll_data['class_id']))
									unset($enroll_data['class_id']);
								if (isset($enroll_data['section_id']))
									unset($enroll_data['section_id']);
								if (isset($enroll_data['room_id']))
									unset($enroll_data['room_id']);

								if (array_key_exists($kelas, $classes)) {
									$enroll_data['class_id'] = $classes[$kelas]['_id'];
									if (array_key_exists($bagian, $classes[$kelas])) {
										$enroll_data['section_id'] = $classes[$kelas][$bagian];
									}
								}
								if (array_key_exists($ruang_kelas, $class_rooms)) {
									$enroll_data['room_id'] = $class_rooms[$ruang_kelas]['_id'];
								}

								$this->db->insert('enrols', $enroll_data);

								$history_data['ket'] = 'Mengisi data enrols';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);
							} else {
								$response = array(
									'status' => true,
									'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $userdata['email'] = html_escape(trim($sheetData[$i]['3']))
								);
								break;
							}
						}
					}
				}
			}
		} else if ($mode == 'eskul_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadeskul.csv');

			if (($handle = fopen('uploads/csv_file/uploadeskul.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$eskul['name'] = html_escape(trim($csv[0]));
						$eskul['school_id'] = $school_id;

						$departemenrow = $this->db->get_where('organizations', array('name' => $eskul['name'], 'school_id' => $eskul['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('organizations', $eskul);

							$history_data['ket'] = 'Mengisi data organizations';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $eskul['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'eskul') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0'])) {
						$eskul['name'] = html_escape(trim($sheetData[$i]['0']));
						$eskul['school_id'] = $school_id;

						$departemenrow = $this->db->get_where('organizations', array('name' => $eskul['name'], 'school_id' => $eskul['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('organizations', $eskul);

							$history_data['ket'] = 'Mengisi data organizations';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $eskul['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'pelanggaran_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadpelanggaran.csv');

			if (($handle = fopen('uploads/csv_file/uploadpelanggaran.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$mistakedata['name'] = html_escape(trim($csv[0]));
						$mistakedata['point'] = html_escape(trim($csv[1]));
						$mistakedata['school_id'] = $school_id;
						$mistakedata['session'] = $session_id;

						$departemenrow = $this->db->get_where('mistakes', array('name' => $mistakedata['name'], 'school_id' => $mistakedata['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('mistakes', $mistakedata);

							$history_data['ket'] = 'Mengisi data mistakes';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $mistakedata['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'pelanggaran') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['2']) && !empty($sheetData[$i]['3'])) {
						$mistakedata['name'] = html_escape(trim($sheetData[$i]['0']));
						$mistakedata['point'] = html_escape(trim($sheetData[$i]['1']));
						$mistakedata['school_id'] = $school_id;
						$mistakedata['session'] = $session_id;

						$departemenrow = $this->db->get_where('mistakes', array('name' => $mistakedata['name'], 'school_id' => $mistakedata['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('mistakes', $mistakedata);

							$history_data['ket'] = 'Mengisi data mistakes';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $mistakedata['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'penghargaan_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadpenghargaan.csv');

			if (($handle = fopen('uploads/csv_file/uploadpenghargaan.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$awarddata['name'] = html_escape(trim($csv[0]));
						$awarddata['point'] = html_escape(trim($csv[1]));
						$awarddata['school_id'] = $school_id;
						$awarddata['session'] = $session_id;

						$departemenrow = $this->db->get_where('awards', array('name' => $awarddata['name'], 'school_id' => $awarddata['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('awards', $awarddata);

							$history_data['ket'] = 'Mengisi data awards';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $awarddata['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'penghargaan') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0']) && !empty($sheetData[$i]['1'])) {
						$awarddata['name'] = html_escape(trim($sheetData[$i]['0']));
						$awarddata['point'] = html_escape(trim($sheetData[$i]['1']));
						$awarddata['school_id'] = $school_id;
						$awarddata['session'] = $session_id;

						$departemenrow = $this->db->get_where('awards', array('name' => $awarddata['name'], 'school_id' => $awarddata['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('awards', $awarddata);

							$history_data['ket'] = 'Mengisi data awards';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $awarddata['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'lokasi_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadlokasi.csv');

			if (($handle = fopen('uploads/csv_file/uploadlokasi.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$location_data['name'] = html_escape(trim($csv[0]));
						$location_data['school_id'] = $school_id;

						$locationrow = $this->db->get_where('locations', array('name' => $location_data['name'], 'school_id' => $location_data['school_id']))->row();
						if (empty($locationrow)) {
							$this->db->insert('locations', $location_data);

							$history_data['ket'] = 'Mengisi data locations';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $location_data['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'lokasi') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0'])) {
						$location_data['name'] = html_escape(trim($sheetData[$i][0]));
						$location_data['school_id'] = $school_id;

						$locationrow = $this->db->get_where('locations', array('name' => $location_data['name'], 'school_id' => $location_data['school_id']))->row();
						if (empty($locationrow)) {
							$this->db->insert('locations', $location_data);

							$history_data['ket'] = 'Mengisi data locations';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $location_data['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'jam_operasional_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadjam_operasional.csv');

			if (($handle = fopen('uploads/csv_file/uploadjam_operasional.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$operational_data['name'] = html_escape(trim($csv[0]));
						$operational_data['time_start'] = html_escape(trim($csv[1]));
						$operational_data['time_finish'] = html_escape(trim($csv[2]));
						$operational_data['school_id'] = $school_id;

						$operational_row = $this->db->get_where('operational_hour', array('name' => $operational_data['name'], 'school_id' => $operational_data['school_id']))->row();
						if (empty($operational_row)) {
							$this->db->insert('operational_hour', $operational_data);

							$history_data['ket'] = 'Mengisi data operational hour';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $operational_data['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'jam_operasional') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0']) && !empty($sheetData[$i]['1'])) {
						$operational_data['name'] = html_escape(trim($sheetData[$i]['0']));
						$operational_data['time_start'] = html_escape(trim($sheetData[$i]['1']));
						$operational_data['time_finish'] = html_escape(trim($sheetData[$i]['2']));
						$operational_data['school_id'] = $school_id;

						$operational_row = $this->db->get_where('operational_hour', array('name' => $operational_data['name'], 'school_id' => $operational_data['school_id']))->row();
						if (empty($operational_row)) {
							$this->db->insert('operational_hour', $operational_data);

							$history_data['ket'] = 'Mengisi data operational hour';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $operational_data['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'jenisbuku_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadjenisbuku.csv');

			if (($handle = fopen('uploads/csv_file/uploadjenisbuku.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$bukutipe['name'] = html_escape(trim($csv[0]));
						$bukutipe['school_id'] = $school_id;

						$departemenrow = $this->db->get_where('book_types', array('name' => $bukutipe['name'], 'school_id' => $bukutipe['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('book_types', $bukutipe);

							$history_data['ket'] = 'Mengisi data book types';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $bukutipe['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'jenisbuku') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0'])) {
						$bukutipe['name'] = html_escape(trim($sheetData[$i][0]));
						$bukutipe['school_id'] = $school_id;

						$departemenrow = $this->db->get_where('book_types', array('name' => $bukutipe['name'], 'school_id' => $bukutipe['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('book_types', $bukutipe);

							$history_data['ket'] = 'Mengisi data book types';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $bukutipe['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'tahun_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadtahun.csv');

			if (($handle = fopen('uploads/csv_file/uploadtahun.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$year_data['name'] = html_escape(trim($csv[0]));
						$year_data['school_id'] = $school_id;

						$departemenrow = $this->db->get_where('years', array('name' => $year_data['name'], 'school_id' => $year_data['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('years', $year_data);

							$history_data['ket'] = 'Mengisi data years';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $year_data['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'tahun') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0'])) {
						$year_data['name'] = html_escape(trim($sheetData[$i][0]));
						$year_data['school_id'] = $school_id;

						$departemenrow = $this->db->get_where('years', array('name' => $year_data['name'], 'school_id' => $year_data['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('years', $year_data);

							$history_data['ket'] = 'Mengisi data years';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $year_data['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'jenistugas_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadjenistugas.csv');

			if (($handle = fopen('uploads/csv_file/uploadjenistugas.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$assignment_types_data['name'] = html_escape(trim($csv[0]));
						$assignment_types_data['school_id'] = $school_id;
						$assignment_types_data['session_id'] = $session_id;

						$departemenrow = $this->db->get_where('assignment_types', array('name' => $assignment_types_data['name'], 'school_id' => $assignment_types_data['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('assignment_types', $assignment_types_data);

							$history_data['ket'] = 'Mengisi data assigment types';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $assignment_types_data['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'jenistugas') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0'])) {
						$assignment_types_data['name'] = html_escape(trim($sheetData[$i][0]));
						$assignment_types_data['school_id'] = $school_id;
						$assignment_types_data['session_id'] = $session_id;

						$departemenrow = $this->db->get_where('assignment_types', array('name' => $assignment_types_data['name'], 'school_id' => $assignment_types_data['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('assignment_types', $assignment_types_data);

							$history_data['ket'] = 'Mengisi data assignment types';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $assignment_types_data['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'jenisujian_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadjenisujian.csv');

			if (($handle = fopen('uploads/csv_file/uploadjenisujian.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$exam_types_data['name'] = html_escape(trim($csv[0]));
						$exam_types_data['school_id'] = $school_id;
						$exam_types_data['session_id'] = $session_id;

						$departemenrow = $this->db->get_where('exam_types', array('name' => $exam_types_data['name'], 'school_id' => $exam_types_data['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('exam_types', $exam_types_data);

							$history_data['ket'] = 'Mengisi data exam types';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $exam_types_data['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'jenisujian') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0'])) {
						$exam_types_data['name'] = html_escape(trim($sheetData[$i]['0']));
						$exam_types_data['school_id'] = $school_id;
						$exam_types_data['session_id'] = $session_id;

						$departemenrow = $this->db->get_where('exam_types', array('name' => $exam_types_data['name'], 'school_id' => $exam_types_data['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('exam_types', $exam_types_data);

							$history_data['ket'] = 'Mengisi data exam types';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $exam_types_data['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'departemen_csv') {
			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploaddepartemen.csv');

			if (($handle = fopen('uploads/csv_file/uploaddepartemen.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0])) {
						$departemendata['name'] = html_escape(trim($csv[0]));
						$departemendata['school_id'] = $school_id;

						$departemenrow = $this->db->get_where('departments', array('name' => $departemendata['name'], 'school_id' => $departemendata['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('departments', $departemendata);

							$history_data['ket'] = 'Mengisi data departments';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							// $last_departments = $this->db->query('SELECT * FROM departments ORDER BY id DESC LIMIT 1')->result_array();
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $departemendata['name'] = html_escape(trim($csv[0]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'departemen') {
			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0'])) {
						$departemendata['name'] = html_escape(trim($sheetData[$i]['0']));
						$departemendata['school_id'] = $school_id;

						$departemenrow = $this->db->get_where('departments', array('name' => $departemendata['name'], 'school_id' => $departemendata['school_id']))->row();
						if (empty($departemenrow)) {
							$this->db->insert('departments', $departemendata);

							$history_data['ket'] = 'Mengisi data departments';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $departemendata['name'] = html_escape(trim($sheetData[$i]['0']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'matapelajaran_csv') {
			$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
			$classes = [];
			foreach ($classes_query as $class) {
				$classes[strtolower($class['name'])] = [
					'_id' => $class['id'],
				];
				$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
				foreach ($sections as $section) {
					$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
				}
			}

			$ruangkelas_query = $this->db->get_where('class_rooms', array('school_id' => $school_id))->result_array();
			$classrooms = [];
			foreach ($ruangkelas_query as $rukel) {
				$classrooms[strtolower($rukel['name'])] = $rukel['id'];
			}

			$teacher_query = $this->db->query('SELECT u.email, t.id FROM users u, teachers t WHERE u.id = t.user_id')->result_array();
			$teachers = [];
			foreach ($teacher_query as $teacher) {
				$teachers[strtolower($teacher['email'])] = $teacher['id'];
			}

			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadmatapelajaran.csv');

			if (($handle = fopen('uploads/csv_file/uploadmatapelajaran.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0) {
						$kelas = strtolower(trim($csv[0]));
						$bagian = strtolower(trim($csv[1]));
						$emailguru = strtolower(trim($csv[4]));
						$rukel = strtolower(trim($csv[2]));

						$mapeldata['name'] = html_escape(trim($csv[3]));

						if (isset($mapeldata['class_id']))
							unset($mapeldata['class_id']);
						if (isset($mapeldata['section_id']))
							unset($mapeldata['section_id']);
						if (array_key_exists($kelas, $classes)) {
							$mapeldata['class_id'] = $classes[$kelas]['_id'];
						}
						if (array_key_exists($bagian, $classes[$kelas])) {
							$mapeldata['section_id'] = $classes[$kelas][$bagian];
						}

						if (array_key_exists($emailguru, $teachers)) {
							$mapeldata['teacher_id'] = $teachers[$emailguru];
						}

						if (array_key_exists($rukel, $classrooms)) {
							$mapeldata['room_id'] = $classrooms[$rukel];
						}

						$mapeldata['school_id'] = $school_id;
						$mapeldata['session'] = $session_id;
						$mapeldata['description'] = html_escape(trim($csv[5]));

						// $mapelrow = $this->db->get_where('subjects', array('name' => $mapeldata['name'], 'class_id' => $mapeldata['class_id'], 'section_id' => $mapeldata['section_id'], 'session' => $mapeldata['session']))->row();
						// if(empty($mapelrow)) {
						$this->db->insert('subjects', $mapeldata);

						$history_data['ket'] = 'Mengisi data subjects';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
						// } else {
						// 	// $last_subjects = $this->db->query('SELECT * FROM subjects ORDER BY id DESC LIMIT 1')->result_array();
						// 	$response = array(
						// 		'status' => true,
						// 		'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = '). $kelas = strtolower(trim($csv[0])) ." ". $bagian = strtolower(trim($csv[1])) . $mapeldata['name'] = html_escape(trim($csv[2]))
						// 	);
						// 	fclose($handle);			
						// }
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'matapelajaran') {
			$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
			$classes = [];
			foreach ($classes_query as $class) {
				$classes[strtolower($class['name'])] = [
					'_id' => $class['id'],
				];
				$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
				foreach ($sections as $section) {
					$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
				}
			}

			$ruangkelas_query = $this->db->get_where('class_rooms', array('school_id' => $school_id))->result_array();
			$classrooms = [];
			foreach ($ruangkelas_query as $rukel) {
				$classrooms[strtolower($rukel['name'])] = $rukel['id'];
			}

			$teacher_query = $this->db->query('SELECT u.email, t.id FROM users u, teachers t WHERE u.id = t.user_id')->result_array();
			$teachers = [];
			foreach ($teacher_query as $teacher) {
				$teachers[strtolower($teacher['email'])] = $teacher['id'];
			}

			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();
				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0']) && !empty($sheetData[$i]['4'])) {

						$kelas = strtolower(trim($sheetData[$i]['0']));
						$bagian = strtolower(trim($sheetData[$i]['1']));
						$emailguru = strtolower(trim($sheetData[$i]['4']));
						$rukel = strtolower(trim($sheetData[$i]['2']));

						$mapeldata['name'] = html_escape(trim($sheetData[$i]['3']));

						if (isset($mapeldata['class_id']))
							unset($mapeldata['class_id']);
						if (isset($mapeldata['section_id']))
							unset($mapeldata['section_id']);
						if (array_key_exists($kelas, $classes)) {
							$mapeldata['class_id'] = $classes[$kelas]['_id'];
						}
						if (array_key_exists($bagian, $classes[$kelas])) {
							$mapeldata['section_id'] = $classes[$kelas][$bagian];
						}

						if (array_key_exists($emailguru, $teachers)) {
							$mapeldata['teacher_id'] = $teachers[$emailguru];
						}

						if (array_key_exists($rukel, $classrooms)) {
							$mapeldata['room_id'] = $classrooms[$rukel];
						}

						$mapeldata['school_id'] = $school_id;
						$mapeldata['session'] = $session_id;
						$mapeldata['description'] = html_escape(trim($sheetData[$i]['5']));

						$this->db->insert('subjects', $mapeldata);

						$history_data['ket'] = 'Mengisi data subjects';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					}
				}
			}
		} else if ($mode == 'guru_old') {
			$departmentquery = $this->db->get_where('departments', array('school_id' => $school_id))->result_array();
			$departments = [];
			foreach ($departmentquery as $department) {
				$departments[strtolower($department['name'])] = [
					'_id' => $department['id'],
				];
			}

			$employee_statusquery = $this->db->get_where('employee_status', array('school_id' => $school_id))->result_array();
			$employee_statusies = [];
			foreach ($employee_statusquery as $employee_status) {
				$employee_statusies[strtolower($employee_status['name'])] = [
					'_id' => $employee_status['id'],
				];
			}

			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadguru.csv');

			if (($handle = fopen('uploads/csv_file/uploadguru.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[2]) && !empty($csv[3])) {
						$role = '';
						switch (strtolower(trim($csv[5]))) {
							case 'Guru':
								$role = 'teacher';
								break;
							case 'Pegawai Lainnya':
								$role = 'other_employee';
								break;
							case 'Pegawai Keuangan':
								$role = 'accountant';
								break;
							case 'Pendidik':
								$role = 'teacher';
								break;
							case 'pendidik':
								$role = 'teacher';
								break;
							case 'Tenaga Kependidikan Lainnya':
								$role = 'other_employee';
								break;
							case 'Tenaga Kependidikan Perpustakaan':
								$role = 'librarian';
								break;
							case 'Tenaga Kependidikan Keuangan':
								$role = 'accountant';
								break;
							case 'tenaga kependidikan lainnya':
								$role = 'other_employee';
								break;
							case 'tenaga kependidikan perpustakaan':
								$role = 'librarian';
								break;
							case 'tenaga kependidikan keuangan':
								$role = 'accountant';
								break;
							case 'Pegawai Perpus':
								$role = 'librarian';
							case 'guru':
								$role = 'teacher';
								break;
							case 'pegawai lainnya':
								$role = 'other_employee';
								break;
							case 'pegawai keuangan':
								$role = 'accountant';
								break;
							case 'pegawai perpus':
								$role = 'librarian';
							default:
								$role = 'other_employee';
								break;
						}

						switch (strtolower(trim($csv[9]))) {
							case 'sertifikasi':
								$certificate = 'yes';
								break;
							case 'non_sertifikasi':
								$certificate = 'no';
								break;
							case 'non sertifikasi':
								$certificate = 'no';
								break;
							case 'non-sertifikasi':
								$certificate = 'no';
								break;
							default:
								$certificate = '';
								break;
						}

						$dep = strtolower(trim($csv[4]));
						$employee_status = strtolower(trim($csv[6]));

						$data['nip'] = preg_replace("/[^0-9]/", "", trim($csv[0]));
						$data['name'] = trim($csv[1]);
						$data['remember_token'] = preg_replace("/[^0-9]/", "", trim($csv[8]));
						$data['certificate'] = $certificate;
						$data['email'] = html_escape(trim($csv[2]));
						$data['password'] = sha1(trim($csv[3]));
						$data['role'] = $role;
						$data['school_id'] = $school_id;
						$data['watch_history'] = '[]';

						if (array_key_exists($dep, $departments)) {
							$data['department_id'] = $departments[$dep]['_id'];
						} else if (isset($data['department_id'])) {
							unset($data['department_id']);
						}

						if (array_key_exists($employee_status, $employee_statusies)) {
							$data['employee_status_id'] = $employee_statusies[$employee_status]['_id'];
						} else if (isset($data['employee_status_id'])) {
							unset($data['employee_status_id']);
						}

						// check email duplication
						$duplication_status = $this->check_duplication('on_create', $data['email']);
						if ($duplication_status) {
							$this->db->insert('users', $data);
							$teacher_id = $this->db->insert_id();

							$history_data['ket'] = 'Mengisi data users';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							$job['user_id'] = $teacher_id;
							$job['role'] = $data['role'];
							$job['start_date'] = trim($csv[7]);
							$job['finish_date'] = 0;
							$job['department_id'] = $data['department_id'];
							$job['status'] = 1;
							$job['school_id'] = $this->school_id;
							$job['session_id'] =  $this->active_session;
							$this->db->insert('job_management', $job);

							$history_data['ket'] = 'Mengisi data job management';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							if ($data['role'] == 'teacher') {
								$teacher_table_data['user_id'] = $teacher_id;
								if (array_key_exists($dep, $departments)) {
									$teacher_table_data['department_id'] = $departments[$dep]['_id'];
								} else if (isset($teacher_table_data['department_id'])) {
									unset($teacher_table_data['department_id']);
								}
								// $social_links = array(
								// 	'facebook' => trim($csv[8]),
								// 	'twitter' => trim($csv[9]),
								// 	'linkedin' => trim($csv[10])
								// );
								// $teacher_table_data['social_links'] = json_encode($social_links);
								$teacher_table_data['school_id'] = $school_id;
								$teacher_table_data['show_on_website'] = 0;
								$this->db->insert('teachers', $teacher_table_data);

								$history_data['ket'] = 'Mengisi data teachers';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);
							} else {
								# code...
							}
						} else {
							// $last_teachers = $this->db->query('SELECT * FROM users ORDER BY id DESC LIMIT 1')->result_array();
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $data['email'] = html_escape(trim($csv[1]))
							);
							fclose($handle);
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'guru') {
			$departmentquery = $this->db->get_where('departments', array('school_id' => $school_id))->result_array();
			$departments = [];
			foreach ($departmentquery as $department) {
				$departments[strtolower($department['name'])] = [
					'_id' => $department['id'],
				];
			}

			$employee_statusquery = $this->db->get_where('employee_status', array('school_id' => $school_id))->result_array();
			$employee_statusies = [];
			foreach ($employee_statusquery as $employee_status) {
				$employee_statusies[strtolower($employee_status['name'])] = [
					'_id' => $employee_status['id'],
				];
			}

			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['2']) && !empty($sheetData[$i]['3'])) {

						$role = '';
						switch (strtolower(trim($sheetData[$i]['5']))) {
							case 'Guru':
								$role = 'teacher';
								break;
							case 'Pegawai Lainnya':
								$role = 'other_employee';
								break;
							case 'Pegawai Keuangan':
								$role = 'accountant';
								break;
							case 'Pendidik':
								$role = 'teacher';
								break;
							case 'pendidik':
								$role = 'teacher';
								break;
							case 'Tenaga Kependidikan Lainnya':
								$role = 'other_employee';
								break;
							case 'Tenaga Kependidikan Perpustakaan':
								$role = 'librarian';
								break;
							case 'Tenaga Kependidikan Keuangan':
								$role = 'accountant';
								break;
							case 'tenaga kependidikan lainnya':
								$role = 'other_employee';
								break;
							case 'tenaga kependidikan perpustakaan':
								$role = 'librarian';
								break;
							case 'tenaga kependidikan keuangan':
								$role = 'accountant';
								break;
							case 'Pegawai Perpus':
								$role = 'librarian';
							case 'guru':
								$role = 'teacher';
								break;
							case 'pegawai lainnya':
								$role = 'other_employee';
								break;
							case 'pegawai keuangan':
								$role = 'accountant';
								break;
							case 'pegawai perpus':
								$role = 'librarian';
								break;
							default:
								$role = 'other_employee';
								break;
						}

						$certificate = '';
						switch (strtolower(trim($sheetData[$i]['9']))) {
							case 'sertifikasi':
								$certificate = 'yes';
								break;
							case 'non_sertifikasi':
								$certificate = 'no';
								break;
							case 'non sertifikasi':
								$certificate = 'no';
								break;
							case 'non-sertifikasi':
								$certificate = 'no';
								break;
							default:
								$certificate = '';
								break;
						}

						$ptk_type = '';
						switch (strtolower(trim($sheetData[$i]['10']))) {
							case 'Kepala Sekolah':
								$ptk_type = '1';
								break;
							case 'Wakil Kepala Sekolah':
								$ptk_type = '2';
								break;
							case 'Kepala TU':
								$ptk_type = '3';
								break;
							case 'kepala sekolah':
								$ptk_type = '1';
								break;
							case 'wakil kepala sekolah':
								$ptk_type = '2';
								break;
							case 'kepala tu':
								$ptk_type = '3';
								break;
							default:
								$ptk_type = '';
								break;
						}

						$last_study = '';
						switch (strtolower(trim($sheetData[$i]['12']))) {
							case 'SMA':
								$last_study = '1';
								break;
							case 'S1':
								$last_study = '2';
								break;
							case 'S2':
								$last_study = '3';
								break;
							case 'sma':
								$last_study = '1';
								break;
							case 's1':
								$last_study = '2';
								break;
							case 's2':
								$last_study = '3';
								break;
							default:
								$last_study = '';
								break;
						}

						if (empty($role)) {
							$role = 'other_employee';
						}

						$dep = strtolower(trim($sheetData[$i]['4']));
						$employee_status = strtolower(trim($sheetData[$i]['6']));

						$data['nip'] = preg_replace("/[^0-9]/", "", trim($sheetData[$i]['0']));
						$data['name'] = trim($sheetData[$i]['1']);
						$data['remember_token'] = preg_replace("/[^0-9]/", "", trim($sheetData[$i]['8']));
						$data['certificate'] = $certificate;
						$data['email'] = html_escape(trim($sheetData[$i]['2']));
						$data['password'] = sha1(trim($sheetData[$i]['3']));
						$data['role'] = $role;
						$data['school_id'] = $school_id;
						$data['watch_history'] = '[]';

						if (array_key_exists($dep, $departments)) {
							$data['department_id'] = $departments[$dep]['_id'];
						} else if (isset($data['department_id'])) {
							unset($data['department_id']);
						}

						if (array_key_exists($employee_status, $employee_statusies)) {
							$data['employee_status_id'] = $employee_statusies[$employee_status]['_id'];
						} else if (isset($data['employee_status_id'])) {
							unset($data['employee_status_id']);
						}

						// check email duplication
						$duplication_status = $this->check_duplication('on_create', $data['email']);
						if ($duplication_status) {
							$this->db->insert('users', $data);
							$teacher_id = $this->db->insert_id();

							$history_data['ket'] = 'Mengisi data users';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							$job['user_id'] = $teacher_id;
							$job['role'] = $data['role'];
							$job['start_date'] = trim($sheetData[$i]['7']);
							$job['finish_date'] = 0;
							$job['department_id'] = $data['department_id'];
							$job['status'] = 1;
							$job['school_id'] = $this->school_id;
							$job['session_id'] =  $this->active_session;
							$job['term_work'] = trim($sheetData[$i]['11']);
							$job['ptk_type'] = $ptk_type;
							$job['last_study'] = $last_study;
							$this->db->insert('job_management', $job);

							$history_data['ket'] = 'Mengisi data job management';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							if ($data['role'] == 'teacher') {
								$teacher_table_data['user_id'] = $teacher_id;
								if (array_key_exists($dep, $departments)) {
									$teacher_table_data['department_id'] = $departments[$dep]['_id'];
								} else if (isset($teacher_table_data['department_id'])) {
									unset($teacher_table_data['department_id']);
								}
								$teacher_table_data['school_id'] = $school_id;
								$teacher_table_data['show_on_website'] = 0;
								$this->db->insert('teachers', $teacher_table_data);

								$history_data['ket'] = 'Mengisi data teachers';
								$history_data['id_user'] = $this->session->set_userdata('user_id');
								$this->db->insert('history', $history_data);
							}
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $data['email'] = html_escape(trim($sheetData[$i]['1']))
							);
							break;
						}
					}
				}
			}
		} else if ($mode == 'eskul_siswa_old') {
			$student_query = $this->db->query('SELECT u.email, t.id FROM users u, students t WHERE u.id = t.user_id')->result_array();
			$students = [];
			foreach ($student_query as $student) {
				$students[strtolower($student['email'])] = $student['id'];
			}

			$organizations_query = $this->db->get_where('organizations', array('school_id' => $school_id))->result_array();
			$organizations = [];
			foreach ($organizations_query as $organization) {
				$organizations[strtolower($organization['name'])] = [
					'_id' => $organization['id'],
				];
			}

			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadgeskulsiswa.csv');

			if (($handle = fopen('uploads/csv_file/uploadgeskulsiswa.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0]) && !empty($csv[1])) {
						$siswa = strtolower(trim($csv[0]));
						$eskul = strtolower(trim($csv[1]));

						if (array_key_exists($siswa, $students)) {
							$eskul_siswa_data['student_id'] = $students[$siswa];
						}

						if (array_key_exists($eskul, $organizations)) {
							$eskul_siswa_data['organizations_id'] = $organizations[$eskul]['_id'];
						} else if (isset($eskul_siswa_data['organizations_id'])) {
							unset($eskul_siswa_data['organizations_id']);
						}

						$student_data = $this->db->get_where('enrols', array('student_id' => $eskul_siswa_data['student_id'], 'school_id' => $school_id, 'session' => $session_id))->row_array();

						$eskul_siswa_data['class_id'] = $student_data['class_id'];
						$eskul_siswa_data['section_id'] = $student_data['section_id'];
						$eskul_siswa_data['room_id'] = $student_data['room_id'];
						$eskul_siswa_data['school_id'] = $school_id;
						$eskul_siswa_data['session'] = $session_id;

						print_r($eskul_siswa_data);
						die;
						$this->db->insert('student_extracurricular', $eskul_siswa_data);

						$history_data['ket'] = 'Mengisi data students extracurricular';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'eskul_siswa') {
			$student_query = $this->db->query('SELECT u.email, t.id FROM users u, students t WHERE u.id = t.user_id')->result_array();
			$students = [];
			foreach ($student_query as $student) {
				$students[strtolower($student['email'])] = $student['id'];
			}

			$organizations_query = $this->db->get_where('organizations', array('school_id' => $school_id))->result_array();
			$organizations = [];
			foreach ($organizations_query as $organization) {
				$organizations[strtolower($organization['name'])] = [
					'_id' => $organization['id'],
				];
			}

			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();


				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0']) && !empty($sheetData[$i]['1'])) {
						$siswa = strtolower(trim($sheetData[$i]['0']));
						$eskul = strtolower(trim($sheetData[$i]['1']));

						if (array_key_exists($siswa, $students)) {
							$eskul_siswa_data['student_id'] = $students[$siswa];
						}

						if (array_key_exists($eskul, $organizations)) {
							$eskul_siswa_data['organizations_id'] = $organizations[$eskul]['_id'];
						} else if (isset($eskul_siswa_data['organizations_id'])) {
							unset($eskul_siswa_data['organizations_id']);
						}

						$student_data = $this->db->get_where('enrols', array('student_id' => $eskul_siswa_data['student_id'], 'school_id' => $school_id, 'session' => $session_id))->row_array();

						$eskul_siswa_data['class_id'] = $student_data['class_id'];
						$eskul_siswa_data['section_id'] = $student_data['section_id'];
						$eskul_siswa_data['room_id'] = $student_data['room_id'];
						$eskul_siswa_data['school_id'] = $school_id;
						$eskul_siswa_data['session'] = $session_id;

						$this->db->insert('student_extracurricular', $eskul_siswa_data);

						$history_data['ket'] = 'Mengisi data stuent extracurricular';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					}
				}
			}
		} else if ($mode == 'jadualkelas_old') {
			$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
			$classes = [];
			foreach ($classes_query as $class) {
				$classes[strtolower($class['name'])] = [
					'_id' => $class['id'],
				];
				$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
				foreach ($sections as $section) {
					$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
				}
			}

			$mapel_query = $this->db->get_where('subjects', array('school_id' => $school_id, 'session' => $session_id))->result_array();
			$subjects = [];
			foreach ($mapel_query as $mapel) {
				$subjects[$mapel['class_id']][strtolower($mapel['name'])] = $mapel['id'];
			}

			$jam_query = $this->db->get_where('operational_hour', array('school_id' => $school_id))->result_array();
			$operational_hour = [];
			foreach ($jam_query as $jam) {
				$operational_hour[$jam['name']] = $jam['id'];
			}

			$teacher_query = $this->db->query('SELECT u.email, t.id FROM users u, teachers t WHERE u.id = t.user_id')->result_array();
			$teachers = [];
			foreach ($teacher_query as $teacher) {
				$teachers[strtolower($teacher['email'])] = $teacher['id'];
			}

			$ruangkelas_query = $this->db->get_where('class_rooms', array('school_id' => $school_id))->result_array();
			$classrooms = [];
			foreach ($ruangkelas_query as $rukel) {
				$classrooms[strtolower($rukel['name'])] = $rukel['id'];
			}

			$file_name = $_FILES['csv_file']['name'];
			move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/uploadjadual.csv');

			if (($handle = fopen('uploads/csv_file/uploadjadual.csv', 'r')) !== FALSE) { // Check the resource is valid
				$count = 0;
				while (($csv = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
					if ($count > 0 && !empty($csv[0]) && !empty($csv[4])) {
						$hari = '';
						switch (strtolower(trim($csv[0]))) {
							case 'senin':
								$hari = 'Monday';
								break;
							case 'selasa':
								$hari = 'Tuesday';
								break;
							case 'rabu':
								$hari = 'Wednesday';
								break;
							case 'kamis':
								$hari = 'Thursday';
								break;
							case 'jumat':
								$hari = 'Friday';
								break;
							case 'sabtu':
								$hari = 'Saturday';
								break;
							case 'monday':
								$hari = 'Monday';
								break;
							case 'tuesday':
								$hari = 'Tuesday';
								break;
							case 'wednesday':
								$hari = 'Wednesday';
								break;
							case 'thursday':
								$hari = 'Thursday';
								break;
							case 'friday':
								$hari = 'Friday';
								break;
							case 'saturday':
								$hari = 'Saturday';
								break;
							default:
								$hari = 'Sunday';
								break;
						}

						$kelas = strtolower(trim($csv[1]));
						$bagian = strtolower(trim($csv[2]));
						$mapel = strtolower(trim($csv[4]));
						$rukel = strtolower(trim($csv[3]));
						$jamop = strtolower(trim($csv[5]));
						// $emailguru = strtolower(trim($csv[6]));

						$jadualdata['day'] = $hari;
						if (array_key_exists($kelas, $classes)) {
							$jadualdata['class_id'] = $classes[$kelas]['_id'];
							if (array_key_exists($bagian, $classes[$kelas])) {
								$jadualdata['section_id'] = $classes[$kelas][$bagian];
							} else {
								$response = array(
									'status' => true,
									'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($csv[1])) . " " . $bagian = strtolower(trim($csv[2])) . " " . $mapel = strtolower(trim($csv[4]))
								);
								continue;
							}
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($csv[1])) . " " . $bagian = strtolower(trim($csv[2])) . " " . $mapel = strtolower(trim($csv[4]))
							);
							continue;
						}

						if (array_key_exists('class_id', $jadualdata)) {
							if (array_key_exists($jadualdata['class_id'], $subjects)) {
								if (array_key_exists($mapel, $subjects[$jadualdata['class_id']])) {
									$jadualdata['subject_id'] = $subjects[$jadualdata['class_id']][$mapel];
								} else {
									$response = array(
										'status' => true,
										'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($csv[1])) . " " . $bagian = strtolower(trim($csv[2])) . " " . $mapel = strtolower(trim($csv[4]))
									);
									continue;
								}
							} else {
								$response = array(
									'status' => true,
									'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($csv[1])) . " " . $bagian = strtolower(trim($csv[2])) . " " . $mapel = strtolower(trim($csv[4]))
								);
								continue;
							}
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($csv[1])) . " " . $bagian = strtolower(trim($csv[2])) . " " . $mapel = strtolower(trim($csv[4]))
							);
							continue;
						}

						// if (array_key_exists($emailguru, $teachers)) {
						// 	$jadualdata['teacher_id'] = $teachers[$emailguru];
						// }
						if (array_key_exists($jamop, $operational_hour)) {
							$jadualdata['hour_id'] = $operational_hour[$jamop];
						}

						if (array_key_exists($rukel, $classrooms)) {
							$jadualdata['room_id'] = $classrooms[$rukel];
						}
						$jadualdata['school_id'] = $school_id;
						$jadualdata['session_id'] = $session_id;

						$checker = array(
							'section_id' => $jadualdata['section_id'],
							'subject_id' => $jadualdata['subject_id'],
							'hour_id' => $jadualdata['hour_id'],
							'day' => $jadualdata['day'],
							'session_id' => $jadualdata['session_id'],
						);


						$subjects_teacher = $this->db->get_where('subjects', array('id' => $jadualdata['subject_id']))->row_array();
						$jadualdata['teacher_id'] = $subjects_teacher['teacher_id'];

						$jadualrow = $this->db->get_where('routines', $checker)->row();
						if (empty($jadualrow)) {
							$this->db->insert('routines', $jadualdata);

							$history_data['ket'] = 'Mengisi data routines';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							// $last_routines = $this->db->query('SELECT * FROM routines ORDER BY id DESC LIMIT 1')->result_array();
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($csv[1])) . " " . $bagian = strtolower(trim($csv[2])) . " " . $mapel = strtolower(trim($csv[4]))
							);
							fclose($handle);
							continue;
						}
					}
					$count++;
				}
			}
			fclose($handle);
		} else if ($mode == 'jadualkelas') {
			$classes_query = $this->db->get_where('classes', array('school_id' => $school_id))->result_array();
			$classes = [];
			foreach ($classes_query as $class) {
				$classes[strtolower($class['name'])] = [
					'_id' => $class['id'],
				];
				$sections = $this->db->get_where('sections', array('class_id' => $class['id']))->result_array();
				foreach ($sections as $section) {
					$classes[strtolower($class['name'])][strtolower($section['name'])] = $section['id'];
				}
			}

			$mapel_query = $this->db->get_where('subjects', array('school_id' => $school_id, 'session' => $session_id))->result_array();
			$subjects = [];
			foreach ($mapel_query as $mapel) {
				$subjects[$mapel['class_id']][strtolower($mapel['name'])] = $mapel['id'];
			}

			$jam_query = $this->db->get_where('operational_hour', array('school_id' => $school_id))->result_array();
			$operational_hour = [];
			foreach ($jam_query as $jam) {
				$operational_hour[$jam['name']] = $jam['id'];
			}

			$teacher_query = $this->db->query('SELECT u.email, t.id FROM users u, teachers t WHERE u.id = t.user_id')->result_array();
			$teachers = [];
			foreach ($teacher_query as $teacher) {
				$teachers[strtolower($teacher['email'])] = $teacher['id'];
			}

			$ruangkelas_query = $this->db->get_where('class_rooms', array('school_id' => $school_id))->result_array();
			$classrooms = [];
			foreach ($ruangkelas_query as $rukel) {
				$classrooms[strtolower($rukel['name'])] = $rukel['id'];
			}

			$file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

			if (isset($_FILES['csv_file']['name']) && in_array($_FILES['csv_file']['type'], $file_mimes)) {
				$arr_file = explode('.', $_FILES['csv_file']['name']);
				$extension = end($arr_file);
				if ('csv' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
				} elseif ('xls' == $extension) {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
				} else {
					$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
				}
				$spreadsheet = $reader->load($_FILES['csv_file']['tmp_name']);
				$sheetData = $spreadsheet->getActiveSheet()->toArray();

				for ($i = 1; $i < count($sheetData); $i++) {
					if (!empty($sheetData[$i]['0']) && !empty($sheetData[$i]['4'])) {
						$hari = '';
						switch (strtolower(trim($sheetData[$i]['0']))) {
							case 'senin':
								$hari = 'Monday';
								break;
							case 'selasa':
								$hari = 'Tuesday';
								break;
							case 'rabu':
								$hari = 'Wednesday';
								break;
							case 'kamis':
								$hari = 'Thursday';
								break;
							case 'jumat':
								$hari = 'Friday';
								break;
							case 'sabtu':
								$hari = 'Saturday';
								break;
							case 'monday':
								$hari = 'Monday';
								break;
							case 'tuesday':
								$hari = 'Tuesday';
								break;
							case 'wednesday':
								$hari = 'Wednesday';
								break;
							case 'thursday':
								$hari = 'Thursday';
								break;
							case 'friday':
								$hari = 'Friday';
								break;
							case 'saturday':
								$hari = 'Saturday';
								break;
							default:
								$hari = 'Sunday';
								break;
						}

						$kelas = strtolower(trim($sheetData[$i]['1']));
						$bagian = strtolower(trim($sheetData[$i]['2']));
						$mapel = strtolower(trim($sheetData[$i]['4']));
						$rukel = strtolower(trim($sheetData[$i]['3']));
						$jamop = strtolower(trim($sheetData[$i]['5']));

						$jadualdata['day'] = $hari;
						if (array_key_exists($kelas, $classes)) {
							$jadualdata['class_id'] = $classes[$kelas]['_id'];
							if (array_key_exists($bagian, $classes[$kelas])) {
								$jadualdata['section_id'] = $classes[$kelas][$bagian];
							} else {
								$response = array(
									'status' => true,
									'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($sheetData[$i]['1'])) . " " . $bagian = strtolower(trim($sheetData[$i]['2'])) . " " . $mapel = strtolower(trim($sheetData[$i]['4']))
								);
								continue;
							}
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($sheetData[$i]['1'])) . " " . $bagian = strtolower(trim($sheetData[$i]['2'])) . " " . $mapel = strtolower(trim($sheetData[$i]['4']))
							);
							continue;
						}

						if (array_key_exists('class_id', $jadualdata)) {
							if (array_key_exists($jadualdata['class_id'], $subjects)) {
								if (array_key_exists($mapel, $subjects[$jadualdata['class_id']])) {
									$jadualdata['subject_id'] = $subjects[$jadualdata['class_id']][$mapel];
								} else {
									$response = array(
										'status' => true,
										'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($sheetData[$i]['1'])) . " " . $bagian = strtolower(trim($sheetData[$i][2])) . " " . $mapel = strtolower(trim($sheetData[$i]['4']))
									);
									continue;
								}
							} else {
								$response = array(
									'status' => true,
									'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($sheetData[$i]['1'])) . " " . $bagian = strtolower(trim($sheetData[$i][2])) . " " . $mapel = strtolower(trim($sheetData[$i]['4']))
								);
								continue;
							}
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($sheetData[$i]['1'])) . " " . $bagian = strtolower(trim($sheetData[$i][2])) . " " . $mapel = strtolower(trim($sheetData[$i]['4']))
							);
							continue;
						}

						if (array_key_exists($jamop, $operational_hour)) {
							$jadualdata['hour_id'] = $operational_hour[$jamop];
						}

						if (array_key_exists($rukel, $classrooms)) {
							$jadualdata['room_id'] = $classrooms[$rukel];
						}
						$jadualdata['school_id'] = $school_id;
						$jadualdata['session_id'] = $session_id;

						$checker = array(
							'section_id' => $jadualdata['section_id'],
							'subject_id' => $jadualdata['subject_id'],
							'hour_id' => $jadualdata['hour_id'],
							'day' => $jadualdata['day'],
							'session_id' => $jadualdata['session_id'],
						);


						$subjects_teacher = $this->db->get_where('subjects', array('id' => $jadualdata['subject_id']))->row_array();
						$jadualdata['teacher_id'] = $subjects_teacher['teacher_id'];

						$jadualrow = $this->db->get_where('routines', $checker)->row();
						if (empty($jadualrow)) {
							$this->db->insert('routines', $jadualdata);

							$history_data['ket'] = 'Mengisi data routines';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $jadualdata['day'] = $hari . " " . $kelas = strtolower(trim($sheetData[$i]['1'])) . " " . $bagian = strtolower(trim($sheetData[$i]['2'])) . " " . $mapel = strtolower(trim($sheetData[$i]['4']))
							);
							continue;
						}
					}
				}
			}
		}

		if (empty($response)) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('successfully_entered_all_data')
			);
		}

		return json_encode($response);
	}

	// Check user duplication
	public function check_duplication($action = "", $email = "", $user_id = "")
	{
		$duplicate_email_check = $this->db->get_where('users', array('email' => $email));

		if ($action == 'on_create') {
			if ($duplicate_email_check->num_rows() > 0) {
				return false;
			} else {
				return true;
			}
		} elseif ($action == 'on_update') {
			if ($duplicate_email_check->num_rows() > 0) {
				if ($duplicate_email_check->row()->id == $user_id) {
					return true;
				} else {
					return false;
				}
			} else {
				return true;
			}
		}
	}

	// job management Manager
	public function get_job_managementNew()
	{
		$checker = array(
			'school_id' => $this->school_id
		);
		return $this->db->group_by('role')->where('school_id',	 $this->school_id)->select('role')->get('job_management');
	}

	public function get_job_management()
	{
		$checker = array(
			'school_id' => $this->school_id
		);
		return $this->db->get_where('job_management', $checker);
	}

	public function get_job_management_by_group($role)
	{
		$checker = array(
			'school_id' => $this->school_id,
			'role' => $role
		);
		return $this->db->get_where('job_management', $checker);
	}

	/* ---------------------------------------#Model_Accounting-------------------------------- */
	/* ---------------------------------------#payment_type----------------------------------- */
	public function get_payment_type_id_details_by_id($id)
	{
		$payment_type_details = $this->db->get_where('payment_types', array('id' => $id));
		return $payment_type_details;
	}

	public function payment_type_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['price'] = html_escape($this->input->post('price'));
		$data['units'] = html_escape($this->input->post('units'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['session'] = html_escape($this->input->post('session'));
		$data['note'] = html_escape($this->input->post('note'));
		$this->db->insert('payment_types', $data);

		$history_data['ket'] = 'Mengisi data payment types';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('payment_type_added_successfully')
		);
		return json_encode($response);
	}

	public function payment_type_create_mass()
	{
		$payment_types = $this->db->get_where('payment_types', array('session' => $this->input->post('session_from')))->result_array();
		foreach ($payment_types as $payment_type) {
			$data['name'] = $payment_type['name'];
			$data['price'] = $payment_type['price'];
			$data['units'] = $payment_type['units'];
			$data['school_id'] = $payment_type['school_id'];
			$data['session'] = $this->input->post('session_to');
			$data['note'] = $payment_type['note'];
			$this->db->insert('payment_types', $data);

			$history_data['ket'] = 'Mengisi data payment types';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}

		if (sizeof($payment_types) > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('payment_type_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('Tidak Ada Data yang Tersimpan')
			);
		}
		return json_encode($response);
	}

	public function payment_type_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['price'] = html_escape($this->input->post('price'));
		$data['session'] = html_escape($this->input->post('session'));
		$data['units'] = html_escape($this->input->post('units'));
		$data['note'] = html_escape($this->input->post('note'));
		$this->db->where('id', $param1);
		$this->db->update('payment_types', $data);

		$history_data['ket'] = 'Update data payment_types ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('payment_type_updated_successfully')
		);
		return json_encode($response);
	}

	public function payment_type_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('payment_types');

		$history_data['ket'] = 'Delete data payment_types ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('payment_type_deleted_successfully')
		);
		return json_encode($response);
	}

	public function payment_type_view()
	{
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		return $this->db->get('payment_types');
	}
	/* ---------------------------------------#payment_type----------------------------------- */

	/* ---------------------------------------#account----------------------------------- */
	public function get_account_id_details_by_id($id)
	{
		$account_details = $this->db->get_where('accounts', array('id' => $id));
		return $account_details;
	}

	public function account_create()
	{
		$data['name'] = $this->input->post('name');
		$data['code'] = $this->input->post('code');
		$data['type'] = $this->input->post('type');
		$data['school_id'] = $this->input->post('school_id');
		$data['created_at'] = strtotime(date('d-M-Y'));
		$this->db->insert('accounts', $data);

		$history_data['ket'] = 'Mengisi data accounts';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('account_added_successfully')
		);
		return json_encode($response);
	}

	public function account_update($param1 = '')
	{
		$data['name'] = $this->input->post('name');
		$data['code'] = $this->input->post('code');
		$data['type'] = $this->input->post('type');
		$data['updated_at'] = strtotime(date('d-M-Y'));
		$this->db->where('id', $param1);
		$this->db->update('accounts', $data);

		$history_data['ket'] = 'Update data accounts ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('account_updated_successfully')
		);
		return json_encode($response);
	}

	public function account_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('accounts');

		$history_data['ket'] = 'Delete data accounts ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('account_deleted_successfully')
		);
		return json_encode($response);
	}
	/* ---------------------------------------#account----------------------------------- */

	/* ---------------------------------------#invoice----------------------------------- */
	public function get_invoice_by_id($id = "")
	{
		return $this->db->get_where('invoices', array('id' => $id))->row_array();
	}

	public function get_invoice_by_date_range($date_from = "", $date_to = "", $selected_class = "", $selected_section = "", $selected_class2 = "", $selected_status = "", $student_id = "")
	{
		$this->db->order_by('created_at', 'DESC');
		$this->db->order_by('title', 'DESC');
		if ($selected_class != "all") {
			$this->db->where('class_id', $selected_class);
		}
		if ($selected_section != "all") {
			$this->db->where('section_id', $selected_section);
		}
		if ($selected_class2 != "all") {
			$this->db->where('payment_type_id', $selected_class2);
		}
		if ($selected_status != "all") {
			$this->db->where('status', $selected_status);
		}
		if ($student_id != "all") {
			$this->db->where('student_id', $student_id);
		}
		$this->db->where('created_at >=', $date_from);
		$this->db->where('created_at <=', $date_to);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		$invoices = $this->db->get('invoices')->result_array();
		return $invoices;
	}

	public function get_invoice_by_student_id($date_from = "", $date_to = "", $student_id = "")
	{
		$this->db->order_by('created_at', 'desc');
		$this->db->where('created_at <=', strtotime(date('Y-m-d h:i:s')));
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		$this->db->where('student_id', $student_id);
		return $this->db->get('invoices');
	}

	public function get_invoice_by_student_id_dashboard2($student_id = "")
	{
		$this->db->order_by('created_at', 'desc');
		$this->db->where('created_at <=', strtotime(date('Y-m-d h:i:s')));
		$this->db->where('status', 'unpaid');
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		$this->db->where('student_id', $student_id);
		return $this->db->get('invoices');
	}

	public function get_invoice_by_student_id_dashboard($student_id = "", $parent_id = "")
	{
		$query = $this->db->query("
			SELECT students.id, a.total_tagihan, a.status FROM students
			left join(
				SELECT
				invoices.student_id, invoices.status,	Sum(invoices.total_amount) as total_tagihan
				FROM
				invoices
				WHERE
				invoices.student_id = {$student_id} AND invoices.status = 'unpaid' AND	invoices.title IS NOT NULL
				GROUP BY
				invoices.student_id, invoices.status,	invoices.school_id,	invoices.session
			)
			as a on a.student_id = students.id
			WHERE
			students.parent_id = {$parent_id}
		");
		return $query;
	}

	public function get_invoice_by_student_id2($student_id = "")
	{
		$this->db->order_by('created_at', 'ASC');
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		$this->db->where('student_id', $student_id);
		$this->db->where('title !=', 'NULL');
		$this->db->where('status', 'paid');
		return $this->db->get('invoices');
	}

	public function get_journal_by_student_id($student_id = "")
	{
		// $this->db->order_by('created_at', 'ASC');
		// $this->db->order_by('id', 'ASC');
		// $this->db->where('school_id', $this->school_id);
		// $this->db->where('session', $this->active_session);
		// $this->db->where('student_id', $student_id); 
		// return $this->db->get('journal');
		$class_details = $this->db->query(" 
		SELECT * FROM  journal
        WHERE 
		school_id = {$this->school_id} AND 
		session_id = {$this->active_session} AND 
		student_id = {$student_id}
        order by created_at asc, id asc 
		");
		return $class_details;
	}

	// This function will be triggered if parent logs in
	public function get_invoice_by_parent_id()
	{
		$parent_user_id = $this->session->userdata('user_id');
		$parent_data = $this->db->get_where('parents', array('user_id' => $parent_user_id))->row_array();
		$student_list = $this->user_model->get_student_list_of_logged_in_parent();
		$student_ids = array();
		foreach ($student_list as $student) {
			if (!in_array($student['student_id'], $student_ids)) {
				array_push($student_ids, $student['student_id']);
			}
		}

		if (count($student_ids) > 0) {
			$this->db->where_in('student_id', $student_ids);
			$this->db->where('school_id', $this->school_id);
			$this->db->where('session', $this->active_session);
			return $this->db->get('invoices')->result_array();
		} else {
			return array();
		}
	}

	public function get_invoices($student_id)
	{
		$this->db->query(" 
		SELECT a.id, a.title, a.total_amount, a.payment_type_id, a.status, a.status_payment, paid_amount, b.name
		FROM
		invoices as a
		INNER JOIN payment_types as b ON a.payment_type_id = b.id
		WHERE a.student_id = $student_id and a.status_payment != 1
		");
		return $class_details;
	}

	public function create_single_invoice()
	{
		$nisn = $this->db->query('select nisn from students where id=' . $this->input->post('student_id_on_create'))->row_array();
		$data['title'] = $this->input->post('title');
		$data['total_amount'] = $this->input->post('total_amount');
		$data['tax'] = $this->input->post('tax');
		$data['tax2'] = $this->input->post('tax2');
		$data['total_amount2'] = $this->input->post('total_amount2');
		$data['class_id'] = $this->input->post('class_id_on_create');
		$data['section_id'] = $this->input->post('section_id_on_create');
		$data['student_id'] = $this->input->post('student_id_on_create');
		$data['status'] = 'unpaid';
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$data['payment_type_id'] = $this->input->post('payment_type');
		$data['note'] = $this->input->post('note');

		if ($this->input->post('kategori') == 0) {
			$date = $this->input->post('day') . ' ' . $this->input->post('label') . ' ' . $this->input->post('year');
			$data['created_at'] = strtotime($date);
			if (strtotime($date) <= strtotime(date('M-d-Y'))) {
				$a = $this->db->query("SELECT count(invoices.id)+1 as total FROM invoices where title IS NOT NULL")->row();
				if ($a->total == 0) {
					$a2 = '1';
				} else {
					$a2 = $a->total;
				}
				$title = 'INV/' . $nisn['nisn'] . '/' . $this->input->post('year') . '/' . date('m', strtotime($this->input->post('label'))) . '/' . $a2;
				$data['title'] = $title;

				$this->db->insert('invoices', $data);
				$last_id = $this->db->insert_id();

				$history_data['ket'] = 'Mengisi data invoices';
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
					journal_type_temp.school_id = ' . $this->school_id . ' and 
					journal_type_temp.journal_type_id = 1
				')->result_array();
				foreach ($accounts as $account) {
					$data2['school_id']  = $this->school_id;
					$data2['session_id'] = $this->active_session;
					$data2['created_at'] = strtotime($date);
					$data2['account_id'] = $account['account_id'];
					$data2['student_id'] = $this->input->post('student_id_on_create');
					$data2['finance_id'] = 0;
					$data2['invoice_id'] = $last_id;
					if ($account['type'] == 'debit') {
						$data2['label']		= $title;
						$data2['debit']		= $this->input->post('total_amount');
						$data2['credit']	= 0;
					} else {
						$data2['label']		= "Tagihan: " . $title;
						$data2['debit']		= 0;
						$data2['credit']	= $this->input->post('total_amount');
					}
					$this->db->insert('journal', $data2);

					$history_data['ket'] = 'Mengisi data journal';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				}
			} else {
				$data['title'] = NULL;
				$this->db->insert('invoices', $data);

				$history_data['ket'] = 'Mengisi data invoices';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}
			// $this->db->insert('invoices', $data);
		} else {
			$data2['student_id'] = $this->input->post('student_id_on_create');
			$data2['recurring_id'] = $this->input->post('kategori');
			$this->db->insert('recurring_temp', $data2);
			$last_id = $this->db->insert_id();

			$history_data['ket'] = 'Mengisi data recurring_temp';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$start = strtotime($this->input->post('day') . '-' . $this->input->post('label') . '-' . $this->input->post('year'));
			$end = strtotime($this->input->post('day') . '-' . $this->input->post('tampil') . '-' . $this->input->post('year2'));
			$currentdate = $start;
			while ($currentdate <= $end) {
				if ($currentdate <= strtotime(date('M-d-Y'))) {
					$a = $this->db->query("SELECT count(invoices.id)+1 as total FROM invoices where title IS NOT NULL")->row();
					if ($a->total == 0) {
						$a2 = '1';
					} else {
						$a2 = $a->total;
					}
					$title 			= 'INV/' . $nisn['nisn'] . '/' . date('Y', $currentdate) . '/' . date('m', $currentdate) . '/' . $a2;
					$data['title'] 	= $title;
					$data['created_at'] = $currentdate;
					$data['recurring_id'] = $last_id;
					$this->db->insert('invoices', $data);
					$last_id2 = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data invoices';
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
						journal_type_temp.school_id = ' . $this->school_id . ' and 
						journal_type_temp.journal_type_id = 1
					')->result_array();
					foreach ($accounts as $account) {
						$data3['school_id']  = $this->school_id;
						$data3['session_id'] = $this->active_session;
						$data3['created_at'] = $currentdate;
						$data3['account_id'] = $account['account_id'];
						$data3['student_id'] = $this->input->post('student_id_on_create');
						$data3['finance_id'] = 0;
						$data3['invoice_id'] = $last_id2;
						if ($account['type'] == 'debit') {
							$data3['label']		= $title;
							$data3['debit']		= $this->input->post('total_amount');
							$data3['credit']	= 0;
						} else {
							$data3['label']		= "Tagihan: " . $title;
							$data3['debit']		= 0;
							$data3['credit']	= $this->input->post('total_amount');
						}
						$this->db->insert('journal', $data3);

						$history_data['ket'] = 'Mengisi data journal';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					}
				} else {
					$data['title'] = NULL;
					$data['created_at'] = $currentdate;
					$data['recurring_id'] = $last_id;
					$this->db->insert('invoices', $data);

					$history_data['ket'] = 'Mengisi data invoices';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				}
				// $data['created_at'] = $currentdate;  
				// $data['recurring_id'] = $last_id; 
				// $this->db->insert('invoices', $data);

				$currentdate = strtotime('+' . $this->input->post('kategori') . ' month', $currentdate);
			}
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('invoice_added_successfully')
		);
		return json_encode($response);
	}

	public function create_mass_invoice()
	{
		$data['total_amount'] = $this->input->post('total_amount');
		$data['tax'] = $this->input->post('tax');
		$data['tax2'] = $this->input->post('tax2');
		$data['tax'] = $this->input->post('tax');
		$data['total_amount2'] = $this->input->post('total_amount2');
		$data['status'] = 'unpaid';
		$data['title'] = $this->input->post('title');
		$data['class_id'] = $this->input->post('class_id_on_create');
		$data['section_id'] = $this->input->post('section_id_on_create');
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$data['created_at'] = strtotime($this->input->post('day') . ' ' . $this->input->post('label') . ' ' . $this->input->post('year'));

		$data['payment_type_id'] = $this->input->post('payment_type');
		$data['note'] = $this->input->post('note');

		$enrolments = $this->user_model->get_student_details_by_id('section', $this->input->post('section_id_on_create'));
		foreach ($enrolments as $enrolment) {
			$data['student_id'] = $enrolment['student_id'];
			if ($this->input->post('kategori') == 0) {
				$date = $this->input->post('day') . ' ' . $this->input->post('label') . ' ' . $this->input->post('year');
				$data['created_at'] = strtotime($date);
				if (strtotime($date) <= strtotime(date('M-d-Y'))) {
					$a = $this->db->query("SELECT count(invoices.id)+1 as total FROM invoices where title IS NOT NULL")->row();
					if ($a->total == 0) {
						$a2 = '1';
					} else {
						$a2 = $a->total;
					}
					$title = 'INV/' . $enrolment['nisn'] . '/' . $this->input->post('year') . '/' . date('m', strtotime($this->input->post('label'))) . '/' . $a2;
					$data['title'] = $title;
					$this->db->insert('invoices', $data);
					$last_id = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data invoices';
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
						journal_type_temp.school_id = ' . $this->school_id . ' and 
						journal_type_temp.journal_type_id = 1
					')->result_array();
					foreach ($accounts as $account) {
						$data2['school_id']  = $this->school_id;
						$data2['session_id'] = $this->active_session;
						$data2['created_at'] = strtotime($date);
						$data2['account_id'] = $account['account_id'];
						$data2['student_id'] = $enrolment['student_id'];
						$data2['finance_id'] = 0;
						$data2['invoice_id'] = $last_id;
						if ($account['type'] == 'debit') {
							$data2['label']		= $title;
							$data2['debit']		= $this->input->post('total_amount');
							$data2['credit']	= 0;
						} else {
							$data2['label']		= "Tagihan: " . $title;
							$data2['debit']		= 0;
							$data2['credit']	= $this->input->post('total_amount');
						}
						$this->db->insert('journal', $data2);

						$history_data['ket'] = 'Mengisi data journal';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					}
				} else {
					$data['title'] = NULL;
					$this->db->insert('invoices', $data);

					$history_data['ket'] = 'Mengisi data invoices';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				}
				// $this->db->insert('invoices', $data);
			} else {
				$data2['student_id'] = $enrolment['student_id'];
				$data2['recurring_id'] = $this->input->post('kategori');
				$this->db->insert('recurring_temp', $data2);
				$last_id = $this->db->insert_id();

				$start = strtotime($this->input->post('day') . '-' . $this->input->post('label') . '-' . $this->input->post('year'));
				$end = strtotime($this->input->post('day') . '-' . $this->input->post('tampil') . '-' . $this->input->post('year2'));
				$currentdate = $start;
				while ($currentdate <= $end) {
					if ($currentdate <= strtotime(date('M-d-Y'))) {
						$a = $this->db->query("SELECT count(invoices.id)+1 as total FROM invoices where title IS NOT NULL")->row();
						if ($a->total == 0) {
							$a2 = '1';
						} else {
							$a2 = $a->total;
						}
						$title = 'INV/' . $enrolment['nisn'] . '/' . date('Y', $currentdate) . '/' . date('m', $currentdate) . '/' . $a2;
						$data['title'] = $title;
						$data['created_at'] = $currentdate;
						$data['recurring_id'] = $last_id;
						$this->db->insert('invoices', $data);
						$last_id2 = $this->db->insert_id();

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
							journal_type_temp.school_id = ' . $this->school_id . ' and 
							journal_type_temp.journal_type_id = 1
						')->result_array();
						foreach ($accounts as $account) {
							$data3['school_id']  = $this->school_id;
							$data3['session_id'] = $this->active_session;
							$data3['created_at'] = $currentdate;
							$data3['account_id'] = $account['account_id'];
							$data3['student_id'] = $enrolment['student_id'];
							$data3['finance_id'] = 0;
							$data3['invoice_id'] = $last_id2;
							if ($account['type'] == 'debit') {
								$data3['label']		= $title;
								$data3['debit']		= $this->input->post('total_amount');
								$data3['credit']	= 0;
							} else {
								$data3['label']		= "Tagihan: " . $title;
								$data3['debit']		= 0;
								$data3['credit']	= $this->input->post('total_amount');
							}
							$this->db->insert('journal', $data3);
						}
					} else {
						$data['title'] = NULL;
						$data['created_at'] = $currentdate;
						$data['recurring_id'] = $last_id;
						$this->db->insert('invoices', $data);
					}
					// $data['created_at'] = $currentdate;  
					// $data['recurring_id'] = $last_id; 
					// $this->db->insert('invoices', $data);

					$currentdate = strtotime('+' . $this->input->post('kategori') . ' month', $currentdate);
				}
			}
		}

		if (sizeof($enrolments) > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('invoice_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('no_student_found')
			);
		}
		return json_encode($response);
	}

	public function update_invoice($id = "")
	{
		/*GET THE PREVIOUS INVOICE DETAILS FOR GETTING THE PAID AMOUNT*/
		$previous_invoice_data = $this->db->get_where('invoices', array('id' => $id))->row_array();

		$data['note'] = $this->input->post('note');
		$data['total_amount'] = $this->input->post('total_amount');
		$data['tax'] = $this->input->post('tax');
		$data['tax2'] = $this->input->post('tax2');

		if ($this->input->post('recurring') == 1) {
			$invoices_id = $this->db->query('select id, created_at from invoices where id between ' . $id . ' and ' . $this->input->post('tampil'))->result_array();
			foreach ($invoices_id as $invoice_id) {
				$data['created_at'] = strtotime($this->input->post('day') . " " . date('M', $invoice_id['created_at']) . " " . date('Y', $invoice_id['created_at']));

				$this->db->where('id', $invoice_id['id']);
				$this->db->update('invoices', $data);

				$history_data['ket'] = 'Update data invoices ' . $invoice_id['id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}
		} else {
			$this->db->where('id', $id);
			$this->db->update('invoices', $data);
		};

		// $invoices_id = $this->db->query('select id, created_at from invoices where id between '.$id.' and '.$this->input->post('tampil'))->result_array();
		// foreach ($invoices_id as $invoice_id) {
		// $data['created_at'] = strtotime($this->input->post('day')." ".date('M',$invoice_id['created_at'])." ".date('Y',$invoice_id['created_at']));

		// $this->db->where('id', $invoice_id['id']);
		// $this->db->update('invoices', $data);				
		// } 	

		// $data['status'] = $this->input->post('status'); 
		// if ($data['paid_amount'] > $data['total_amount']) {
		// $response = array(
		// 'status' => false,
		// 'notification' => get_phrase('paid_amount_can_not_get_bigger_than_total_amount')
		// );
		// return json_encode($response);
		// }
		// if ($data['status'] == 'paid' && $data['total_amount'] != $data['paid_amount']) {
		// $response = array(
		// 'status' => false,
		// 'notification' => get_phrase('paid_amount_is_not_equal_to_total_amount')
		// );
		// return json_encode($response);
		// }

		// if ($data['total_amount'] == $data['paid_amount']) {
		// $data['status'] = 'paid';
		// }

		/*KEEPING TRACK OF PAYMENT DATE*/
		// if ($this->input->post('paid_amount') != $previous_invoice_data && $this->input->post('paid_amount') > 0) {
		// $data['updated_at'] = strtotime(date('d-M-Y'));
		// }elseif ($this->input->post('paid_amount') == 0 || $this->input->post('paid_amount') == "") {
		// $data['updated_at'] = 0;
		// } 
		$response = array(
			'status' => true,
			'notification' => get_phrase('invoice_updated_successfully')
		);
		return json_encode($response);
	}

	public function delete_invoice($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('invoices');

		$history_data['ket'] = 'Delete data invoices ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('invoice_deleted_successfully')
		);
		return json_encode($response);
	}

	public function add_payment($id = "")
	{
		if ($this->input->post('paid_amount') < 0 &&  empty($_FILES['finances_file'])) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_can_not_get_bigger_than_total_amount')
			);
			return json_encode($response);
		}
		/* --------------------------------- */
		$previous_invoice_data = $this->db->get_where('invoices', array('id' => $id))->row_array();
		$check_finance_data = $this->get_finances_total_by_id($id);

		$paid_amount = $this->input->post('paid_amount') + $this->input->post('a');
		$total_finance_data = $check_finance_data['total'] + $this->input->post('paid_amount') + $this->input->post('a');
		$savings = $total_finance_data - $previous_invoice_data['total_amount'];

		// if($this->input->post('saving_id') != NULL){
		// 	$paid_amount = $this->input->post('paid_amount'); 
		// 	$total_finance_data = $check_finance_data['total'] + $this->input->post('paid_amount'); 
		// 	$savings = $total_finance_data - $previous_invoice_data['total_amount']; 
		// }
		// else{
		// 	$paid_amount = $this->input->post('paid_amount') + $this->input->post('saving_total'); 
		// 	$total_finance_data = $check_finance_data['total'] + $this->input->post('paid_amount') + $this->input->post('saving_total');
		// 	$savings = $total_finance_data - $previous_invoice_data['total_amount']; 
		// } 

		$data['invoices_id'] 	= $previous_invoice_data['id'];
		$data['student_id'] 	= $previous_invoice_data['student_id'];
		$data['class_id'] 		= $previous_invoice_data['class_id'];
		$data['section_id'] 	= $previous_invoice_data['section_id'];
		$data['school_id'] 		= $previous_invoice_data['school_id'];
		$data['session_id'] 	= $previous_invoice_data['session'];
		$data['payment_type_id'] = $previous_invoice_data['payment_type_id'];

		$data['status'] = 1;
		$data['date'] 	= strtotime(date('d-M-Y'));
		$data['total'] 	= $paid_amount;
		$data['created_at'] = strtotime(date('d-M-Y'));

		// if( $this->input->post('paid_amount') >= $this->input->post('total_amount1') ){
		if ($this->input->post('total_amount1') == "0" && $this->input->post('paid_amount') >= $this->input->post('total_amount1')) {
			$total_amount1 = $this->input->post('total_amount22');
		} elseif ($this->input->post('total_amount1') == "0" || $this->input->post('paid_amount') > $this->input->post('total_amount1')) {
			$total_amount1 = $this->input->post('total_amount1');
		} else {
			$total_amount1 = $paid_amount; //$paid_amount = $this->input->post('paid_amount') + $this->input->post('a')
		}
		$data['total_amount1'] 	= $total_amount1;

		$file_ext = pathinfo($_FILES['finances_file']['name'], PATHINFO_EXTENSION);
		$data['file'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['finances_file']['tmp_name'], 'uploads/finance/' . $data['file']);

		/* ---------------------------------g dipakai */
		/* elseif($this->input->post('paid_amount')  < $previous_invoice_data['total_amount']){
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_can_not_get_lower_than_total_amount')
			);
			return json_encode($response);
		} */
		/* ---------------------------------g dipakai */

		/* if ($this->input->post('paid_amount')  > $previous_invoice_data['total_amount']) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_can_not_get_bigger_than_total_amount')
			);
			return json_encode($response);
		}
		if ($previous_invoice_data['total_amount'] == $this->input->post('paid_amount') ) {
			$data2['status'] = 'paid';
		}elseif($this->input->post('paid_amount')  < $previous_invoice_data['total_amount']){
			$data2['status'] = 'not_yet_paid_off';
		}  
		if ($total_finance_data  > $previous_invoice_data['total_amount']) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('paid_amount_can_not_get_bigger_than_total_amount')
			);
			return json_encode($response);
		}
		*/
		/* --------------------------------- */
		if ($previous_invoice_data['total_amount'] == $total_finance_data || $total_finance_data > $previous_invoice_data['total_amount']) {
			$data2['status'] = 'paid';
		} elseif ($total_finance_data  < $previous_invoice_data['total_amount']) {
			$data2['status'] = 'not_yet_paid_off';
		}
		$data2['paid_amount'] 	= $total_finance_data;
		$data2['updated_at'] 	= strtotime(date('d-M-Y'));
		$this->db->where('id', $id);
		$this->db->update('invoices', $data2);
		/* --------------------------------- */
		$this->db->insert('finances', $data);
		$insert_id = $this->db->insert_id();
		/* --------------------------------- */
		$data4['finances_to_id'] 	= $insert_id;
		$data4['updated_at'] 		= strtotime(date('d-M-Y'));
		$data4['status'] 			= 1;
		$this->db->where('id', $this->input->post('saving_id'));
		$this->db->update('savings', $data4);
		/* --------------------------------- */
		if (!empty($this->input->post('a'))) {
			$accounts = $this->db->query('
			SELECT accounts.id as account_id, accounts.code as account_code, accounts.name as account_name 
			FROM accounts 
			WHERE accounts.school_id = ' . $this->school_id . ' and accounts.id = 56
			')->result_array();
			foreach ($accounts as $account) {
				$data_j1['school_id']  	= $this->school_id;
				$data_j1['session_id']  = $this->active_session;
				$data_j1['created_at'] 	= strtotime(date('d-M-Y'));
				$data_j1['account_id'] 	= $account['account_id'];
				$data_j1['student_id'] 	= $previous_invoice_data['student_id'];
				// $data_j1['finance_id'] 	= $insert_id;
				// $data_j1['invoice_id'] 	= $previous_invoice_data['id']; 	
				$data_j1['finance_id'] 	= 0;
				$data_j1['invoice_id'] 	= 0;
				$data_j1['label']		= "Untuk Pembayaran: " . $previous_invoice_data['title'];
				$data_j1['debit']		= $this->input->post('a');
				$data_j1['credit']		= 0;
				$this->db->insert('journal', $data_j1);
			}
		}
		/* --------------------------------- */
		$accounts2 = $this->db->query('
		SELECT journal_type_temp.id, journal_type_temp.type,
			accounts.id as account_id,
			accounts.code as account_code,
			accounts.name as account_name						
		FROM journal_type_temp
			INNER JOIN accounts ON journal_type_temp.account_id = accounts.id
		WHERE
			journal_type_temp.school_id = ' . $this->school_id . ' and 
			journal_type_temp.journal_type_id = 3 
		')->result_array();
		foreach ($accounts2 as $account2) {
			$data_j2['school_id']  	= $this->school_id;
			$data_j2['session_id']  = $this->active_session;
			$data_j2['created_at'] 	= strtotime(date('d-M-Y'));
			$data_j2['account_id'] 	= $account2['account_id'];
			$data_j2['student_id'] 	= $previous_invoice_data['student_id'];
			$data_j2['finance_id'] 	= $insert_id;
			$data_j2['invoice_id'] 	= $previous_invoice_data['id'];
			if ($account2['type'] == 'debit') {
				$data_j2['label']	= "Pembayaran: " . $previous_invoice_data['title'];
				// $data_j2['debit']	= $paid_amount;
				$data_j2['debit']	= $this->input->post('paid_amount');
				$data_j2['credit']	= 0;
			} else {
				$data_j2['label']	= "Pembayaran: " . $previous_invoice_data['title'];
				$data_j2['debit']	= 0;
				$data_j2['credit']	= $total_amount1;
			}
			$this->db->insert('journal', $data_j2);
		}
		/* --------------------------------- */
		if ($savings > '0') {
			$data3['total'] 			= $savings;
			$data3['student_id'] 		= $previous_invoice_data['student_id'];
			$data3['school_id'] 		= $previous_invoice_data['school_id'];
			$data3['invoices_id'] 		= $previous_invoice_data['id'];
			$data3['finances_from_id'] 	= $insert_id;
			$data3['created_at']    	= strtotime(date('d-M-Y'));
			$this->db->insert('savings', $data3);
			/* --------------------------------- */
			$accounts3 = $this->db->query('
			SELECT accounts.id as account_id, accounts.code as account_code, accounts.name as account_name 
			FROM accounts 
			WHERE accounts.school_id = ' . $this->school_id . ' and accounts.id = 56
			')->result_array();
			foreach ($accounts3 as $account3) {
				$data_j3['school_id']  = $this->school_id;
				$data_j3['session_id'] = $this->active_session;
				$data_j3['created_at'] = strtotime(date('d-M-Y'));
				$data_j3['account_id'] = $account3['account_id'];
				$data_j3['student_id'] = $previous_invoice_data['student_id'];
				// $data_j3['finance_id'] = $insert_id;
				// $data_j3['invoice_id'] = $previous_invoice_data['id'];	
				$data_j3['finance_id'] = 0;
				$data_j3['invoice_id'] = 0;
				$data_j3['label']	   = "Sisa Pembayaran: " . $previous_invoice_data['title'];
				$data_j3['debit']	   = 0;
				$data_j3['credit']	   = $savings;
				$this->db->insert('journal', $data_j3);
			}
			/* --------------------------------- */
		}
		/* --------------------------------- */
		$response = array(
			'status' => true,
			'notification' => get_phrase('invoice_updated_successfully')
		);
		return json_encode($response);
	}

	public function get_invoices_recurring_by_id($id)
	{
		return $this->db->query("
		SELECT DISTINCT
			recurring.name,
			recurring.no,
			Min(invoices.created_at) as min,
			Max(invoices.created_at) as max
		FROM
			recurring_temp
		INNER JOIN invoices ON recurring_temp.id = invoices.recurring_id
		INNER JOIN recurring ON recurring_temp.recurring_id = recurring.no
		WHERE
			invoices.recurring_id = " . $id . " AND invoices.status != 'paid'
		GROUP BY
			recurring.name, recurring.no
		")->row_array();
	}

	public function get_invoices_recurring_by_date($student_id, $recurring_id, $date)
	{
		return $this->db->query("
		SELECT * FROM invoices 
		WHERE invoices.student_id = " . $student_id . " AND invoices.student_id = " . $student_id . " AND created_at = " . $date . "
		order by invoices.id
		")->row_array();
	}

	public function get_use_savings($student_id)
	{
		// return $this->db->query("
		// SELECT * FROM savings
		// WHERE
		// savings.student_id = ".$student_id." AND
		// savings.finances_to_id IS NULL	
		// ")->row_array();
		return $this->db->query("
		SELECT * FROM savings
		WHERE
		savings.student_id = " . $student_id . " AND
		savings.status = 0
		")->row_array();
	}
	/* ---------------------------------------#invoice----------------------------------- */

	/* ---------------------------------------#finance----------------------------------- */
	public function get_finances_total_by_id($id)
	{
		return $this->db->query('select COALESCE(SUM(total),0) as total from finances where invoices_id = ' . $id)->row_array();
	}

	public function get_finances_by_date_range($date_from = "", $date_to = "", $selected_class = "", $selected_section = "", $selected_class2 = "",  $student_id = "")
	{
		$this->db->order_by('id', 'DESC');
		if ($selected_class != "all") {
			$this->db->where('class_id', $selected_class);
		}
		if ($selected_section != "all") {
			$this->db->where('section_id', $selected_section);
		}
		if ($selected_class2 != "all") {
			$this->db->where('payment_type_id', $selected_class2);
		}
		if ($student_id != "all") {
			$this->db->where('student_id', $student_id);
		}
		$this->db->where('created_at >=', $date_from);
		$this->db->where('created_at <=', $date_to);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session_id', $this->active_session);
		$this->db->where('registrations_id', null);
		return $this->db->get('finances');
	}
	/* ---------------------------------------#finance----------------------------------- */

	/* ---------------------------------------#journal_in----------------------------------- */
	public function get_finances_by_date_range2($date_from = "", $date_to = "", $selected_class = "", $selected_section = "", $selected_class2 = "")
	{
		$query = $this->db->query("
		SELECT
		finances.id,finances.student_id,finances.payment_type_id,finances.total,finances.class_id,finances.section_id,finances.status,finances.school_id,finances.session_id,finances.file,finances.invoices_id,finances.created_at,finances.registrations_name,finances.registrations_nisn,finances.registrations_kode,finances.registrations_id
		FROM
		finances
		left JOIN 
		(select id, status from invoices)
		as a ON finances.invoices_id = a.id
		where
		finances.created_at between " . $date_from . " and " . $date_to . "
		and finances.school_id = " . $this->school_id . " and finances.session_id = " . $this->active_session . "		
		");

		return $query;
	}
	/* ---------------------------------------#journal_in----------------------------------- */

	/* ---------------------------------------#expense----------------------------------- */
	public function get_expense_by_id2($id = "")
	{
		return $this->db->get_where('expenses', array('id' => $id))->row_array();
	}

	public function get_expense2($date_from = "", $date_to = "")
	{
		$this->db->where('date >=', $date_from);
		$this->db->where('date <=', $date_to);
		$this->db->where('school_id', $this->school_id);
		$this->db->where('session', $this->active_session);
		return $this->db->get('expenses');
	}

	// creating
	public function create_expense2()
	{
		$a = $this->db->query("SELECT count(expenses.id)+1 as total FROM expenses")->row();
		if ($a->total == 0) {
			$a2 = '1';
		} else {
			$a2 = $a->total;
		}
		$data['in_charge'] 	= $this->input->post('in_charge');
		$data['description'] 	= $this->input->post('description');
		$data['label'] 		= "CUS.INV/" . date('Y') . "/" . $a2;
		$data['date'] 		= strtotime($this->input->post('date'));
		$data['amount'] 	= $this->input->post('amount');
		$data['school_id'] 	= $this->school_id;
		$data['session'] 	= $this->active_session;
		$data['created_at'] = strtotime(date('d-M-Y'));
		$this->db->insert('expenses', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_added_successfully')
		);
		return json_encode($response);
	}

	// updating
	public function update_expense2($id = "")
	{
		$data['in_charge'] 		= $this->input->post('in_charge');
		$data['description'] 	= $this->input->post('description');
		$data['date'] = strtotime($this->input->post('date'));
		$data['amount'] = $this->input->post('amount');
		$data['school_id'] = $this->school_id;
		$data['session'] = $this->active_session;
		$this->db->where('id', $id);
		$this->db->update('expenses', $data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_updated_successfully')
		);
		return json_encode($response);
	}

	// deleting
	public function delete_expense2($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('expenses');

		$history_data['ket'] = 'Delete data expenses ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('expense_deleted_successfully')
		);
		return json_encode($response);
	}
	/* ---------------------------------------#expense----------------------------------- */

	//--------------------------------------------tambahan--------------------------------//
	public function get_class2_details_by_id($id)
	{
		$class_details = $this->db->query("
			SELECT
			classes.id AS classid,
			classes.name AS classname,
			sections.id AS sectionid,
			sections.name AS sectionname,
			schools.id AS schoolid,
			schools.name AS schoolname,
			a.studentid,
			a.nameuser,
			a.studentcode,
			a.nisn,
			a.userid,
			a.email,
			a.password
			FROM
			enrols
			INNER JOIN classes ON enrols.class_id = classes.id
			INNER JOIN sections ON enrols.section_id = sections.id
			INNER JOIN schools ON enrols.school_id = schools.id
			INNER JOIN (
			SELECT
			users.id as userid,
			students.id as studentid,
			students.code as studentcode,
			users.name as nameuser,
			students.school_id,
			students.nisn,
			users.email,
			users.password,
			sessions.name
			FROM
			students
			INNER JOIN users ON students.user_id = users.id
			INNER JOIN sessions ON students.session = sessions.id
			) AS a ON enrols.student_id = a.studentid
			where
			a.studentid = $id
			ORDER BY
			classname ASC, sectionname ASC, a.nameuser ASC

		");
		return $class_details;
	}

	//START CLASS section
	public function get_classes2()
	{
		$class_details = $this->db->query("
		SELECT classes.id AS classid,	sections.id AS sectionid,	classes.name AS classname, sections.name AS sectionname 
		FROM classes 
		INNER JOIN sections ON classes.id = sections.class_id 
		ORDER BY classname ASC, sectionname ASC
		");
		return $class_details;
	}

	//START account yg dipakai
	public function get_account()
	{
		$account_details = $this->db->query("
		SELECT accounts.id, accounts.code, accounts.name 
		FROM accounts
		WHERE accounts.school_id = 22 AND accounts.id IN (1, 4, 13, 56, 93)
		ORDER BY accounts.id
		");
		return $account_details;
	}

	public function check_va($va)
	{
		return $this->db->get_where('students', array('va' => $va))->row_array();
	}

	public function create_finance_va($data)
	{
		$student = $this->check_va($data['va']);

		$invoice_data = $this->db->query("
			SELECT invoices.*, COALESCE(SUM(finances.total),0) as total_bayar
			FROM invoices
			left join finances on finances.invoices_id = invoices.id
			WHERE 
				invoices.student_id 	= {$student['id']} AND
				invoices.school_id 		= {$student['school_id']} AND
				invoices.session 		= '{$student['session']}' AND					
				invoices.status != 'paid' AND
				invoices.title IS NOT NULL
			GROUP BY invoices.id
			order by invoices.created_at asc, invoices.id asc
		")->result_array();

		$tabungan = 0;
		// $saving = $this->db->query(" SELECT id, total FROM savings WHERE student_id = {$student['id']} AND status = '0' ")->row_array();	
		$saving = $this->get_use_savings($student['id']);
		if (count($saving) > 0 && count($invoice_data) > 0) {
			$tabungan 				= $saving['total'];
			$data2['status'] 		= 1;
			$data2['updated_at'] 	= strtotime(date('d-M-Y'));
			$this->db->where('id', $saving['id']);
			$this->db->update('savings', $data2);

			// echo "tabungan : ".$tabungan."<br>"; // query saving kredit
		}
		$pembayaran = $data['nominal'] + $tabungan; // TOTAL BAYAR + TABUNGAN

		try {
			$this->db->insert('finances_va', $data);
			$insert_id = $this->db->insert_id();

			if (count($invoice_data) > 0) {
				$sisa = 0;
				$kurang = 0;
				$break = false;
				$simpanan = 0;
				foreach ($invoice_data as $key => $row) {
					// echo "nomor inv ke-: ".($key+1)."<br>";
					// echo "invoice id: ".$row['id']."<br>";
					// echo "jumlah total va: ".currency( number_format($pembayaran,0,",","."))."<br>";
					// echo "tagihan: " . currency( number_format($row['total_amount'],0,",","."))."<br>";
					// echo "sisa dari tagihan sebelum: ".currency( number_format($row['total_bayar'],0,",","."));
					// echo "<br>";

					$jumlahtagihan = $row['total_amount'] - $row['total_bayar'];

					$data = [];
					if ($jumlahtagihan > 0 && $pembayaran >= $jumlahtagihan) {
						$sisa = $pembayaran - $jumlahtagihan;
						$simpanan = $pembayaran = $sisa;
						// echo "bayar: ".currency( number_format($row['total_amount'],0,",","."));
						// echo "<br>";
						$data['invoices_id'] 	= $row['id'];
						$data['student_id'] 	= $row['student_id'];
						$data['class_id'] 		= $row['class_id'];
						$data['section_id'] 	= $row['section_id'];
						$data['school_id'] 		= $row['school_id'];
						$data['session_id'] 	= $row['session'];
						$data['payment_type_id'] = $row['payment_type_id'];
						$data['status'] 		= 1;
						$data['date'] 			= strtotime(date('d-M-Y'));
						$data['total'] 			= $jumlahtagihan;
						$data['created_at'] 	= strtotime(date('d-M-Y'));
						$data['finances_va_id'] = $insert_id;

						$data2['status'] 		= 'paid';
						$data2['paid_amount'] 	= $row['total_amount'];
						$data2['updated_at'] 	= strtotime(date('d-M-Y'));

						if ($sisa < 1) {
							$break = true;
						}
					} else {
						$kurang = $jumlahtagihan - $pembayaran;
						$simpanan = 0;

						// echo "bayar: ".currency( number_format($pembayaran,0,",","."));
						// echo "<br><br>";
						$data['invoices_id'] 	= $row['id'];
						$data['student_id'] 	= $row['student_id'];
						$data['class_id'] 		= $row['class_id'];
						$data['section_id'] 	= $row['section_id'];
						$data['school_id'] 		= $row['school_id'];
						$data['session_id'] 	= $row['session'];
						$data['payment_type_id'] = $row['payment_type_id'];
						$data['status'] 		= 1;
						$data['date'] 			= strtotime(date('d-M-Y'));
						$data['total'] 			= $pembayaran;
						$data['created_at'] 	= strtotime(date('d-M-Y'));
						$data['finances_va_id'] = $insert_id;

						$data2['status'] 		= 'not_yet_paid_off';
						$data2['paid_amount'] 	= $row['total_bayar'] + $pembayaran;
						$data2['updated_at'] 	= strtotime(date('d-M-Y'));

						$break = true;
					}
					// echo "<br>=======</br>";
					// print_r($sisa); die;

					$this->db->insert('finances', $data);
					$this->db->where('id', $row['id']);
					$this->db->update('invoices', $data2);
					if ($break !== false) {
						break;
					}
				}

				if ($simpanan > 0) { //jika sudak tidak ada/lunas semua tagihan tapi memeiliki sisa uang pemabyaran
					// echo "tabungan: ".currency( number_format($simpanan,0,",","."))."<br>";
					$data3['total'] 			= $simpanan;
					$data3['student_id'] 		= $invoice_data[0]['student_id'];
					$data3['school_id'] 		= $invoice_data[0]['school_id'];
					$data3['created_at']    	= strtotime(date('d-M-Y'));
					$data3['status'] 			= 0;
					$this->db->insert('savings', $data3);
				}
			} else {
				if (count($saving) > 0) //jika tidak ada tagihan tapi memeiliki uang titipan
				{
					$data3['total'] = $saving['total'] + $pembayaran;
					$this->db->where('id', $saving['id']);
					$this->db->update('savings', $data3);
				} else //jika tidak ada tagihan dan tidak memeiliki uang titipan
				{
					// echo "tabungan: ".currency( number_format($pembayaran,0,",","."))."<br>"; 
					$data3['total'] 			= $pembayaran;
					$data3['student_id'] 		= $student['id'];
					$data3['school_id'] 		= $student['school_id'];
					$data3['created_at']    	= strtotime(date('d-M-Y'));
					$data3['status'] 			= 0;
					$this->db->insert('savings', $data3);
				}
			}
		} catch (\Throwable $th) {
			return false;
		}

		return true;
	}

	// START INDUSTRY COMPANY
	public function create_industry_company()
	{
		$data['company_name'] = $this->input->post('company_name');
		$data['phone_number'] = $this->input->post('phone_number');
		$data['address'] = $this->input->post('address');
		$data['school_id'] = $this->input->post('school_id');

		$this->db->insert('industry_company', $data);

		$history_data['ket'] = 'Mengisi data industry company';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function industry_company_update($param1 = '')
	{
		$data['company_name'] = $this->input->post('company_name');
		$data['phone_number'] = $this->input->post('phone_number');
		$data['address'] = $this->input->post('address');

		$this->db->where('id', $param1);
		$this->db->update('industry_company', $data);

		$history_data['ket'] = 'Update data industry_company ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('industry_company_update_successfully')
		);
		return json_encode($response);
	}

	public function industry_company_delete($param1 = '')
	{

		$this->db->where('id', $param1);
		$this->db->delete('industry_company');

		$history_data['ket'] = 'Delete data industry_company ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);


		$response = array(
			'status' => true,
			'notification' => get_phrase('industry_company_delete_successfully')
		);
		return json_encode($response);
	}
	// END INDUSTRY COMPANY


	// START INTERNSHIP
	public function create_internship()
	{
		$company_id = $this->input->post('company_id');
		$dates = $this->input->post('daterange');
		$explode = explode(" - ", $dates);
		$start_date = strtotime($explode[0]);
		$end_date = strtotime($explode[1]);

		$data_intern['company_id'] = $company_id;
		$data_intern['start_date'] = $start_date;
		$data_intern['end_date'] = $end_date;
		$data_intern['school_id'] = $this->input->post('school_id');
		$data_intern['session_id'] = $this->active_session;
		$data_intern['description'] = $this->input->post('description');
		$file_ext = pathinfo($_FILES['internship_file']['name'], PATHINFO_EXTENSION);
		$data_intern['file'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['internship_file']['tmp_name'], 'uploads/internship/' . $data_intern['file']);
		$this->db->insert('internship', $data_intern);

		$history_data['ket'] = 'Mengisi data intership';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);


		$_student_id = html_escape($this->input->post('student_id'));

		for ($i = 0; $i < count($_student_id); $i++) {
			$student_id = $_student_id[$i];

			$internship_id = $this->db->get_where('internship', array('company_id' => $company_id, 'start_date' => strtotime($explode[0]), 'end_date' => strtotime($explode[1])))->row('id');
			$data['internship_id'] = $internship_id;
			$data['student_id'] = $student_id;
			$data['school_id'] = $this->school_id;
			$this->db->insert('internship_student', $data);

			$history_data['ket'] = 'Mengisi data instership student';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function add_internship_student()
	{

		$_student_id = html_escape($this->input->post('student_internship'));
		$internship_id = $this->input->post('internship_id');

		for ($i = 1; $i < count($_student_id); $i++) {
			$student_id = $_student_id[$i];

			$data['internship_id'] = $internship_id;
			$data['student_id'] = $student_id;
			$data['school_id'] = $this->school_id;
			$this->db->insert('internship_student', $data);

			$history_data['ket'] = 'Mengisi data instership student';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function internship_update($param1 = '')
	{
		$company_id = $this->input->post('company_id');
		$dates = $this->input->post('daterange');
		$explode = explode(" - ", $dates);
		$start_date = strtotime($explode[0]);
		$end_date = strtotime($explode[1]);

		$file_ext = pathinfo($_FILES['internship_file']['name'], PATHINFO_EXTENSION);

		if ($file_ext == '') {
			$data_intern['company_id'] = $company_id;
			$data_intern['start_date'] = $start_date;
			$data_intern['end_date'] = $end_date;
			$data_intern['school_id'] = $this->input->post('school_id');
			$data_intern['description'] = $this->input->post('description');
			$this->db->where('id', $param1);
			$this->db->update('internship', $data_intern);

			$history_data['ket'] = 'Update data internship ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		} else {
			$data_intern['company_id'] = $company_id;
			$data_intern['start_date'] = $start_date;
			$data_intern['end_date'] = $end_date;
			$data_intern['school_id'] = $this->input->post('school_id');
			$data_intern['description'] = $this->input->post('description');
			$data_intern['file'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
			move_uploaded_file($_FILES['internship_file']['tmp_name'], 'uploads/internship/' . $data_intern['file']);
			$this->db->where('id', $param1);
			$this->db->update('internship', $data_intern);

			$history_data['ket'] = 'Update data internship ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}

		$response = array(
			'status' => true,
			'notification' => get_phrase('internship_update_successfully')
		);
		return json_encode($response);
	}

	public function internship_delete($param1 = '')
	{

		$this->db->where('id', $param1);
		$this->db->delete('internship');

		$history_data['ket'] = 'Delete data internship ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('internship_id', $param1);
		$this->db->delete('internship_student');

		$history_data['ket'] = 'Delete data internship_student ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('internship_delete_successfully')
		);
		return json_encode($response);
	}

	public function internship_student_delete($param1 = '')
	{

		$this->db->where('id', $param1);
		$this->db->delete('internship_student');

		$history_data['ket'] = 'Delete data internship_student ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		print_r($this->db->last_query());
		die;

		$response = array(
			'status' => true,
			'notification' => get_phrase('internship_student_delete_successfully')
		);
		return json_encode($response);
	}
	// END INTERNSHIP
	//--------------------------------------------tambahan--------------------------------//
}
