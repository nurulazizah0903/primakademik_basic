<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/
require APPPATH . 'third_party/phpoffice/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class User_model extends CI_Model
{

	protected $school_id;
	protected $active_session;

	public function __construct()
	{
		parent::__construct();
		$this->school_id = school_id();
		$this->active_session = active_session();
	}

	// GET SUPERADMIN DETAILS
	public function get_superadmin()
	{
		$this->db->where('role', 'superadmin');
		return $this->db->get('users')->row_array();
	}
	// GET USER DETAILS
	public function get_user_details($user_id = '', $column_name = '')
	{
		if ($column_name != '') {
			return $this->db->get_where('users', array('id' => $user_id))->row($column_name);
		} else {
			return $this->db->get_where('users', array('id' => $user_id))->row_array();
		}
	}

	// ADMIN CRUD SECTION STARTS
	public function create_admin()
	{
		$id = $this->input->post('user_id');

		$admin_data = $this->get_user_details($id);

		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['name'] = $admin_data['name'];
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = $admin_data['phone'];
		$data['gender'] = $admin_data['gender'];
		$data['blood_group'] = $admin_data['blood_group'];
		$data['address'] = $admin_data['address'];
		$data['role'] = 'admin';
		$data['watch_history'] = '[]';

		// $postdata = [
		// 		'email' => $data('email'),
		// 		'password' => $data('password'),
		// ];
		// $createOdoo = $this->input->post(config_item('odoo_url').'/web/regis',($postdata));

		// $postdata = [
		// 	'params' => [
		// 		'email' => $data['email'],
		// 		'password' => $data['password'],
		// 	],
		// ];
		// $createOdoo = $this->http->post(config_item('odoo_url').'/web/regis', json_encode($postdata));

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if ($duplication_status) {
			$this->db->insert('users', $data);

			$history_data['ket'] = 'Mengisi data users';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('admin_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function update_admin($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['school_id'] = html_escape($this->input->post('school_id'));
		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if ($duplication_status) {
			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('admin_has_been_updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function delete_admin($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('admin_has_been_deleted_successfully')
		);
		return json_encode($response);
	}
	// ADMIN CRUD SECTION ENDS

	// employee_mutation Manager
	public function get_employee_mutation()
	{
		$checker = array(
			'school_id' => $this->school_id
		);
		return $this->db->get_where('employee_mutations', $checker);
	}

	public function get_employee_mutation_by_id($id = "")
	{
		return $this->db->get_where('employee_mutations', array('id' => $id))->row_array();
	}

	public function create_employee_mutation()
	{
		$user_id = $this->input->post('user_id');

		$data_user = $this->db->get_where('users', array('id' => $user_id))->row_array();

		$data['date'] = strtotime($this->input->post('date'));
		$data['name']    = $data_user['name'];
		$data['phone']    = $data_user['phone'];
		$data['address']    = $data_user['address'];
		$data['nip']    = $data_user['nip'];
		$data['caption']    = $this->input->post('caption');
		$data['school_id'] = $this->school_id;
		$this->db->insert('employee_mutations', $data);

		$history_data['ket'] = 'Mengisi data emplyee mutations';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('user_id', $user_id);
		$this->db->delete('teachers');

		$history_data['ket'] = 'Delete data teachers ' . $user_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('id', $user_id);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $user_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('added_successfully')
		);
		return json_encode($response);
	}

	public function delete_employee_mutation($id = "")
	{
		$this->db->where('id', $id);
		$this->db->delete('employee_mutations');

		$history_data['ket'] = 'Delete data employee_mutations ' . $id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//start job_management section
	// public function get_employee() {
	// 	$role = 'teacher, librarian, accountant';
	// 	$checker = array(
	// 		// 'role' => 'teacher',
	// 		// 'role' => 'librarian',
	// 		'role' => 'accountant&teacher'
	// 	);
	// 	return $this->db->get_where('users', $checker);
	// }

	public function create_job_management()
	{

		$user_id = $this->input->post('user_id');
		$role_new = $this->input->post('role_new');

		$duplication_status = $this->db->get_where('users', array('id' => $user_id))->row_array();
		if ($duplication_status) {
			$data['finish_date'] = $this->input->post('start_date');
			$data['status'] = 0;
			$this->db->limit(1);
			$this->db->order_by('id', 'DESC');
			$this->db->where('user_id', $user_id);
			$this->db->update('job_management', $data);

			$history_data['ket'] = 'Update data job_management ' . $user_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$job_data['status'] = 0;
			$this->db->where('user_id', $user_id);
			$this->db->update('job_management', $job_data);

			$history_data['ket'] = 'Update data job_management ' . $user_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('job_management_added_successfully')
			);
		}

		$job['user_id'] = $user_id;
		$job['role'] = $this->input->post('role_new');
		$job['start_date'] = $this->input->post('start_date');
		$job['finish_date'] = 0;
		$job['department_id'] = $this->input->post('department');
		$job['status'] = 1;
		$job['school_id'] = $this->school_id;
		$job['session_id'] =  $this->active_session;
		$this->db->insert('job_management', $job);

		$history_data['ket'] = 'Mengisi data job management';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$user_data['role'] = $this->input->post('role_new');
		$user_data['department_id'] = $this->input->post('department');
		$this->db->where('id', $user_id);
		$this->db->update('users', $user_data);

		$history_data['ket'] = 'Update data users ' . $user_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		if ($role_new == "teacher") {
			$teacher_data['user_id'] = $user_id;
			$teacher_data['show_on_website'] = $this->input->post('show_on_website');
			if (empty($teacher_data['show_on_website'])) {
				$teacher_data['show_on_website'] = '0';
			}
			$teacher_data['school_id'] = $this->school_id;

			$check_data = $this->db->get_where('teachers', array('user_id' => $teacher_data['user_id']));
			if ($check_data->num_rows() > 0) {
				$update_teacher_data['department_id'] = $this->input->post('department');
				$row = $check_data->row();
				$this->db->where('id', $row->id);
				$this->db->update('teachers', $update_teacher_data);

				$history_data['ket'] = 'Update data teachers ' . $row->id . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			} else {
				$this->db->insert('teachers', $teacher_data);

				$history_data['ket'] = 'Mengisi data teacher';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}
		}

		return json_encode($response);
	}

	//end job_management section

	//start employee section 
	public function create_single_employee()
	{
		$data['school_id'] = $this->school_id;
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['nip'] = html_escape($this->input->post('nip'));
		$data['nik'] = html_escape($this->input->post('nik'));
		$data['npwp'] = html_escape($this->input->post('npwp'));
		$data['remember_token'] = html_escape($this->input->post('norek'));
		$data['role'] = html_escape($this->input->post('role'));
		$data['status'] = html_escape($this->input->post('status'));
		$data['employee_status_id'] = html_escape($this->input->post('employee_status_id'));
		$data['religion'] = html_escape($this->input->post('religion'));
		$data['certificate'] = html_escape($this->input->post('certificate'));
		// $data['birthday_place'] = html_escape($this->input->post('birthday_place'));
		$data['birthday'] = html_escape($this->input->post('birthday'));
		$data['province_id'] = html_escape($this->input->post('province_id'));
		$data['district_id'] = html_escape($this->input->post('district_id'));
		$data['districts_id'] = html_escape($this->input->post('districts_id'));
		$data['ward_id'] = html_escape($this->input->post('ward_id'));
		$data['post_code'] = html_escape($this->input->post('postcode_id'));
		$data['watch_history'] = '[]';
		$data['department_id'] = html_escape($this->input->post('department_id'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if ($duplication_status) {
			// print_r($data);
			$this->db->insert('users', $data);
			$insert_id = $this->db->insert_id();

			$history_data['ket'] = 'Mengisi data users';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$job['user_id'] = $insert_id;
			$job['role'] = $data['role'];
			$job['start_date'] = $this->input->post('start_date');
			$job['finish_date'] = 0;
			$job['department_id'] = $this->input->post('department_id');
			$job['ptk_type'] = $this->input->post('ptk_type');
			$job['last_study'] = $this->input->post('last_study');
			$job['term_work'] = $this->input->post('term_work');
			$job['status'] = 1;
			$job['school_id'] = $this->school_id;
			$job['session_id'] =  $this->active_session;
			$this->db->insert('job_management', $job);

			$history_data['ket'] = 'Mengisi data job management';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			if ($data['role'] == "teacher") {
				$teacher_data['user_id'] = $insert_id;
				$teacher_data['show_on_website'] = $this->input->post('show_on_website');
				if (empty($teacher_data['show_on_website'])) {
					$teacher_data['show_on_website'] = '0';
				}
				$teacher_data['school_id'] = $this->school_id;

				$check_data = $this->db->get_where('teachers', array('user_id' => $teacher_data['user_id']));
				if ($check_data->num_rows() > 0) {
					$update_teacher_data['department_id'] = $this->input->post('department_id');
					$row = $check_data->row();
					$this->db->where('id', $row->id);
					$this->db->update('teachers', $update_teacher_data);

					$history_data['ket'] = 'Update data teachers ' . $row->id . '';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				} else {
					$this->db->insert('teachers', $teacher_data);

					$history_data['ket'] = 'Mengisi data teachers';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				}
			}

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/' . $insert_id . '.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('employee_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
		redirect(site_url('backend/superadmin/employee/list'), 'refresh');
	}

	public function update_employee($employee_id = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['role'] = html_escape($this->input->post('role'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['nip'] = html_escape($this->input->post('nip'));
		$data['nik'] = html_escape($this->input->post('nik'));
		$data['npwp'] = html_escape($this->input->post('npwp'));
		$data['remember_token'] = html_escape($this->input->post('norek'));
		$data['status'] = html_escape($this->input->post('status'));
		$data['religion'] = html_escape($this->input->post('religion'));
		$data['certificate'] = html_escape($this->input->post('certificate'));
		$data['birthday'] = html_escape($this->input->post('birthday'));
		$data['province_id'] = html_escape($this->input->post('province_id'));
		$data['district_id'] = html_escape($this->input->post('district_id'));
		$data['districts_id'] = html_escape($this->input->post('districts_id'));
		$data['ward_id'] = html_escape($this->input->post('ward_id'));
		$data['post_code'] = html_escape($this->input->post('postcode_id'));
		$data['department_id'] = html_escape($this->input->post('department'));
		$data['employee_status_id'] = html_escape($this->input->post('employee_status_id'));
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $employee_id);
		if ($duplication_status) {
			$this->db->where('id', $employee_id);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $employee_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$job_management_data['role'] = $data['role'];
			$job_management_data['start_date'] = $this->input->post('start_date');
			$job_management_data['ptk_type'] = $this->input->post('ptk_type');
			$job_management_data['last_study'] = $this->input->post('last_study');
			$job_management_data['term_work'] = $this->input->post('term_work');
			$this->db->where('user_id', $employee_id);
			$this->db->update('job_management', $job_management_data);

			$history_data['ket'] = 'Update data job_management ' . $employee_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			if ($data['role'] == "teacher") {
				$teacher_data['user_id'] = $employee_id;
				$teacher_data['show_on_website'] = $this->input->post('show_on_website');
				if (empty($teacher_data['show_on_website'])) {
					$teacher_data['show_on_website'] = '0';
				}
				$teacher_data['school_id'] = $this->school_id;

				$check_data = $this->db->get_where('teachers', array('user_id' => $teacher_data['user_id']));
				if ($check_data->num_rows() > 0) {
					$update_teacher_data['department_id'] = $this->input->post('department_id');
					$row = $check_data->row();
					$this->db->where('id', $row->id);
					$this->db->update('teachers', $update_teacher_data);

					$history_data['ket'] = 'Update data teachers ' . $row->id . '';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				} else {
					$this->db->insert('teachers', $teacher_data);

					$history_data['ket'] = 'Mengisi data teachers';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				}
			}

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/' . $employee_id . '.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function get_employees()
	{
		$school_id = school_id();
		// $where = "school_id = '".$school_id."' AND role='teacher' OR role='librarian' OR role='accountant'";
		// return $this->db->get_where('users', $where);

		$role_name = array('teacher', 'librarian', 'other_employee', 'accountant', '0');
		$this->db->or_where_in('role', $role_name);
		$this->db->where('school_id', $school_id);
		return $this->db->get('users');
	}

	public function delete_employee($param1 = '')
	{
		// $teacher = $this->db->get_where('teachers', array('user_id' => $param1))->row_array();
		$check_row = $this->db->get_where('teachers', array('user_id' => $param1));
		if ($check_row->num_rows() > 0) {
			$this->db->where('user_id', $param1);
			$this->db->delete('teachers');

			$history_data['ket'] = 'Delete data teachers ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$this->db->where('teacher_id', $check_row['id']);
			$this->db->delete('teacher_permissions');

			$history_data['ket'] = 'Delete data teacher_permissions ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}

		$this->db->where('id', $param1);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);
		return json_encode($response);
	}

	//end employee section

	//START TEACHER section
	public function create_teacher()
	{
		$data['school_id'] = html_escape($this->input->post('school_id'));
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['role'] = 'teacher';
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if ($duplication_status) {
			$this->db->insert('users', $data);

			$history_data['ket'] = 'Mengisi data users for teacher';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$teacher_id = $this->db->insert_id();
			$teacher_table_data['user_id'] = $teacher_id;
			$teacher_table_data['about'] = html_escape($this->input->post('about'));
			$social_links = array(
				'facebook' => $this->input->post('facebook_link'),
				'twitter' => $this->input->post('twitter_link'),
				'linkedin' => $this->input->post('linkedin_link')
			);
			$teacher_table_data['social_links'] = json_encode($social_links);
			$teacher_table_data['department_id'] = html_escape($this->input->post('department'));
			$teacher_table_data['designation'] = html_escape($this->input->post('designation'));
			$teacher_table_data['school_id'] = html_escape($this->input->post('school_id'));
			$teacher_table_data['show_on_website'] = $this->input->post('show_on_website');
			$this->db->insert('teachers', $teacher_table_data);

			$history_data['ket'] = 'Mengisi data teachers';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/' . $teacher_id . '.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('teacher_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function update_employee_teacher($teacher_id = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['nip'] = html_escape($this->input->post('nip'));
		$data['nik'] = html_escape($this->input->post('nik'));
		$data['npwp'] = html_escape($this->input->post('npwp'));
		if (empty($data['npwp'])) {
			$data['npwp'] = '0';
		}
		// $data['role'] = html_escape($this->input->post('role'));
		$data['status'] = html_escape($this->input->post('status'));
		$data['religion'] = html_escape($this->input->post('religion'));
		// $data['birthday_place'] = html_escape($this->input->post('birthday_place'));
		$data['birthday'] = html_escape($this->input->post('birthday'));
		$data['province_id'] = html_escape($this->input->post('province_id'));
		$data['district_id'] = html_escape($this->input->post('district_id'));
		$data['districts_id'] = html_escape($this->input->post('districts_id'));
		$data['ward_id'] = html_escape($this->input->post('ward_id'));
		$data['post_code'] = html_escape($this->input->post('postcode_id'));
		$data['department_id'] = html_escape($this->input->post('department'));
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $teacher_id);
		if ($duplication_status) {
			$this->db->where('id', $teacher_id);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $teacher_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$teacher_table_data['department_id'] = html_escape($this->input->post('department'));
			$this->db->where('user_id', $teacher_id);
			$this->db->update('teachers', $teacher_table_data);

			$history_data['ket'] = 'Update data teachers ' . $teacher_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/' . $teacher_id . '.jpg');
			}

			// $response = array(
			// 	'status' => true,
			// 	'notification' => get_phrase('teacher_has_been_updated_successfully')
			// );


		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function update_teacher($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if ($duplication_status) {
			$this->db->where('id', $param1);
			$this->db->where('school_id', $this->input->post('school_id'));
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$teacher_table_data['department_id'] = html_escape($this->input->post('department'));
			$teacher_table_data['designation'] = html_escape($this->input->post('designation'));
			$teacher_table_data['about'] = html_escape($this->input->post('about'));
			$social_links = array(
				'facebook' => $this->input->post('facebook_link'),
				'twitter' => $this->input->post('twitter_link'),
				'linkedin' => $this->input->post('linkedin_link')
			);
			$teacher_table_data['social_links'] = json_encode($social_links);
			$teacher_table_data['show_on_website'] = $this->input->post('show_on_website');
			$this->db->where('school_id', $this->input->post('school_id'));
			$this->db->where('user_id', $param1);
			$this->db->update('teachers', $teacher_table_data);

			$history_data['ket'] = 'Update data teachers ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/' . $param1 . '.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('teacher_has_been_updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function delete_teacher($param1 = '', $param2)
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('user_id', $param1);
		$this->db->delete('teachers');

		$history_data['ket'] = 'Delete data teachers ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('teacher_id', $param2);
		$this->db->delete('teacher_permissions');

		$history_data['ket'] = 'Delete data teacher_permissions ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('teacher_has_been_deleted_successfully')
		);
		return json_encode($response);
	}

	public function get_teachers()
	{
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'teacher'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_teacher_by_id($teacher_id = "")
	{
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $teacher_id
		);
		$result = $this->db->get_where('teachers', $checker)->row_array();
		return $this->db->get_where('users', array('id' => $result['user_id']));
	}
	//END TEACHER section


	//START TEACHER PERMISSION section
	public function teacher_permission()
	{
		$school_id = school_id();

		$class_id = html_escape($this->input->post('class_id'));
		$section_id = html_escape($this->input->post('section_id'));
		$teacher_id = html_escape($this->input->post('teacher_id'));
		$column_name = html_escape($this->input->post('column_name'));
		$value = html_escape($this->input->post('value'));

		$check_row = $this->db->get_where('teacher_permissions', array('class_id' => $class_id, 'section_id' => $section_id, 'teacher_id' => $teacher_id));
		if ($check_row->num_rows() > 0) {
			$data[$column_name] = $value;
			$this->db->where('class_id', $class_id);
			$this->db->where('section_id', $section_id);
			$this->db->where('teacher_id', $teacher_id);
			$this->db->update('teacher_permissions', $data);

			$history_data['ket'] = 'Update data teacher_permissions ' . $teacher_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		} else {
			$data['class_id'] = $class_id;
			$data['section_id'] = $section_id;
			$data['teacher_id'] = $teacher_id;
			$data['school_id'] = $school_id;
			$data[$column_name] = 1;
			$this->db->insert('teacher_permissions', $data);

			$history_data['ket'] = 'Mengisi data teachers permission';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);
		}
	}
	//END TEACHER PERMISSION section

	//START PARENT section
	public function parent_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['school_id'] = $this->school_id;
		$data['role'] = 'parent';
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if ($duplication_status) {

			$this->db->insert('users', $data);

			$parent_data['user_id'] = $this->db->insert_id();
			$parent_data['school_id'] = $this->school_id;
			$this->db->insert('parents', $parent_data);

			$history_data['ket'] = 'Mengisi data parents';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('parent_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function parent_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['nik'] = html_escape($this->input->post('nik'));
		$data['birthday'] = html_escape($this->input->post('birthday'));
		$data['religion'] = html_escape($this->input->post('religion'));
		$data['province_id'] = html_escape($this->input->post('province_id'));
		$data['district_id'] = html_escape($this->input->post('district_id'));
		$data['districts_id'] = html_escape($this->input->post('districts_id'));
		$data['ward_id'] = html_escape($this->input->post('ward_id'));
		$data['post_code'] = html_escape($this->input->post('postcode_id'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if ($duplication_status) {

			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			if ($_FILES['parent_image']['name'] != "") {
				move_uploaded_file($_FILES['parent_image']['tmp_name'], 'uploads/users/' . $param1 . '.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('parent_updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function parent_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('user_id', $param1);
		$this->db->delete('parents');

		$history_data['ket'] = 'Delete data parents ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('parent_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_parents()
	{
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'parent'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_parent_by_id($parent_id = "")
	{
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $parent_id
		);
		$result = $this->db->get_where('parents', $checker)->row_array();
		return $this->db->get_where('users', array('id' => $result['user_id']));
	}
	//END PARENT section

	//START GUARDIAN section
	public function guardian_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['school_id'] = $this->school_id;
		$data['role'] = 'guardian';
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if ($duplication_status) {

			$this->db->insert('users', $data);

			$parent_data['user_id'] = $this->db->insert_id();
			$parent_data['school_id'] = $this->school_id;
			$this->db->insert('guardians', $parent_data);

			$history_data['ket'] = 'Mengisi data guardian';
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

	public function guardian_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['nik'] = html_escape($this->input->post('nik'));
		$data['birthday'] = html_escape($this->input->post('birthday'));
		$data['religion'] = html_escape($this->input->post('religion'));
		$data['province_id'] = html_escape($this->input->post('province_id'));
		$data['district_id'] = html_escape($this->input->post('district_id'));
		$data['districts_id'] = html_escape($this->input->post('districts_id'));
		$data['ward_id'] = html_escape($this->input->post('ward_id'));
		$data['post_code'] = html_escape($this->input->post('postcode_id'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if ($duplication_status) {

			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			if ($_FILES['guardian_image']['name'] != "") {
				move_uploaded_file($_FILES['guardian_image']['tmp_name'], 'uploads/users/' . $param1 . '.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('parent_updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function guardian_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('user_id', $param1);
		$this->db->delete('guardians');

		$history_data['ket'] = 'Delete data guardians ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_guardians()
	{
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'guardian'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_guardian_by_id($guardian_id = "")
	{
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $guardian_id
		);
		$result = $this->db->get_where('guardians', $checker)->row_array();
		return $this->db->get_where('users', array('id' => $result['user_id']));
	}
	//END GUARDIAN section


	//START ACCOUNTANT section
	public function accountant_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['school_id'] = $this->school_id;
		$data['role'] = 'accountant';
		$data['watch_history'] = '[]';

		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if ($duplication_status) {
			$this->db->insert('users', $data);

			$history_data['ket'] = 'Mengisi data user';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('accountant_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function update_employee_accountant($accountant_id = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['nip'] = html_escape($this->input->post('nip'));
		$data['nik'] = html_escape($this->input->post('nik'));
		$data['npwp'] = html_escape($this->input->post('npwp'));
		if (empty($data['npwp'])) {
			$data['npwp'] = '0';
		}
		// $data['role'] = html_escape($this->input->post('role'));
		$data['status'] = html_escape($this->input->post('status'));
		$data['religion'] = html_escape($this->input->post('religion'));
		// $data['birthday_place'] = html_escape($this->input->post('birthday_place'));
		$data['birthday'] = html_escape($this->input->post('birthday'));
		$data['province_id'] = html_escape($this->input->post('province_id'));
		$data['district_id'] = html_escape($this->input->post('district_id'));
		$data['districts_id'] = html_escape($this->input->post('districts_id'));
		$data['ward_id'] = html_escape($this->input->post('ward_id'));
		$data['post_code'] = html_escape($this->input->post('postcode_id'));
		$data['department_id'] = html_escape($this->input->post('department'));
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $accountant_id);
		if ($duplication_status) {
			$this->db->where('id', $accountant_id);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $accountant_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			// $employee = $this->db->get_where('users', array('id' => $accountant_id))->row_array();

			// if ($employee['role'] == "teacher") {
			// 	$teacher_data['user_id'] = $accountant_id;
			// 	$teacher_data['show_on_website'] = $this->input->post('show_on_website');
			// 	if(empty($teacher_data['show_on_website'])){
			// 		$teacher_data['show_on_website'] = '0';
			// 	}
			// 	$teacher_data['school_id'] = $this->school_id;
			// 	$this->db->insert('teachers', $teacher_data);
			// }else{

			// }

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/' . $accountant_id . '.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function accountant_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));

		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if ($duplication_status) {
			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('accountant_has_been_updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function accountant_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('accountant_has_been_deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_accountants()
	{
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'accountant'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_accountant_by_id($accountant_id = "")
	{
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $accountant_id
		);
		return $this->db->get_where('users', $checker);
	}
	//END ACCOUNTANT section

	//START OTHER EMPLOYEE section
	public function update_employee_other_employee($other_employee_id = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['nip'] = html_escape($this->input->post('nip'));
		$data['nik'] = html_escape($this->input->post('nik'));
		$data['npwp'] = html_escape($this->input->post('npwp'));
		if (empty($data['npwp'])) {
			$data['npwp'] = '0';
		}
		$data['status'] = html_escape($this->input->post('status'));
		$data['religion'] = html_escape($this->input->post('religion'));
		$data['birthday'] = html_escape($this->input->post('birthday'));
		$data['province_id'] = html_escape($this->input->post('province_id'));
		$data['district_id'] = html_escape($this->input->post('district_id'));
		$data['districts_id'] = html_escape($this->input->post('districts_id'));
		$data['ward_id'] = html_escape($this->input->post('ward_id'));
		$data['post_code'] = html_escape($this->input->post('postcode_id'));
		$data['department_id'] = html_escape($this->input->post('department'));
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $other_employee_id);
		if ($duplication_status) {
			$this->db->where('id', $other_employee_id);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $other_employee_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/' . $other_employee_id . '.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function other_employee_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));

		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if ($duplication_status) {
			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function other_employee_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('deleted_successfully')
		);

		return json_encode($response);
	}

	public function get_other_employees()
	{
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'other_employee'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_other_employee_by_id($other_employee_id = "")
	{
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $other_employee_id
		);
		return $this->db->get_where('users', $checker);
	}
	//END OTHER EMPLOYEE section

	//START LIBRARIAN section
	public function librarian_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['password'] = sha1($this->input->post('password'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['school_id'] = $this->school_id;
		$data['role'] = 'librarian';
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if ($duplication_status) {
			$this->db->insert('users', $data);

			$history_data['ket'] = 'Mengisi data users';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('librarian_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function update_employee_librarian($librarian_id = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['nip'] = html_escape($this->input->post('nip'));
		$data['nik'] = html_escape($this->input->post('nik'));
		$data['npwp'] = html_escape($this->input->post('npwp'));
		if (empty($data['npwp'])) {
			$data['npwp'] = '0';
		}
		// $data['role'] = html_escape($this->input->post('role'));
		$data['status'] = html_escape($this->input->post('status'));
		$data['religion'] = html_escape($this->input->post('religion'));
		// $data['birthday_place'] = html_escape($this->input->post('birthday_place'));
		$data['birthday'] = html_escape($this->input->post('birthday'));
		$data['province_id'] = html_escape($this->input->post('province_id'));
		$data['district_id'] = html_escape($this->input->post('district_id'));
		$data['districts_id'] = html_escape($this->input->post('districts_id'));
		$data['ward_id'] = html_escape($this->input->post('ward_id'));
		$data['post_code'] = html_escape($this->input->post('postcode_id'));
		$data['department_id'] = html_escape($this->input->post('department'));
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $librarian_id);
		if ($duplication_status) {
			$this->db->where('id', $librarian_id);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $librarian_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			// $employee = $this->db->get_where('users', array('id' => $librarian_id))->row_array();

			// if ($employee['role'] == "teacher") {
			// 	$teacher_data['user_id'] = $librarian_id;
			// 	$teacher_data['show_on_website'] = $this->input->post('show_on_website');
			// 	if(empty($teacher_data['show_on_website'])){
			// 		$teacher_data['show_on_website'] = '0';
			// 	}
			// 	$teacher_data['school_id'] = $this->school_id;
			// 	$this->db->insert('teachers', $teacher_data);
			// }else{

			// }

			if ($_FILES['image_file']['name'] != "") {
				move_uploaded_file($_FILES['image_file']['tmp_name'], 'uploads/users/' . $librarian_id . '.jpg');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function librarian_update($param1 = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['email'] = html_escape($this->input->post('email'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$data['gender'] = html_escape($this->input->post('gender'));
		$data['blood_group'] = html_escape($this->input->post('blood_group'));
		$data['address'] = html_escape($this->input->post('address'));

		// check email duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $param1);
		if ($duplication_status) {
			$this->db->where('id', $param1);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $param1 . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('librarian_updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function librarian_delete($param1 = '')
	{
		$this->db->where('id', $param1);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $param1 . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('librarian_deleted_successfully')
		);
		return json_encode($response);
	}


	public function get_librarians()
	{
		$checker = array(
			'school_id' => $this->school_id,
			'role' => 'librarian'
		);
		return $this->db->get_where('users', $checker);
	}

	public function get_librarian_by_id($librarian_id = "")
	{
		$checker = array(
			'school_id' => $this->school_id,
			'id' => $librarian_id
		);
		return $this->db->get_where('users', $checker);
	}
	//END LIBRARIAN section


	//START STUDENT AND ADMISSION section
	public function ppdb_users_create($id = '', $nis = '')
	{
		$ppdb_id = html_escape($this->input->post('registrasi_id'));

		if ($id != '') {
			$ppdb_id = $id;
		}

		$query = $this->db->get_where('registrations', array('id' => $ppdb_id))->result_array();

		foreach ($query as $ppdb) {
			$user_data['name'] = $ppdb['nama_lengkap'];
			// $user_data['email'] = "2022".substr($ppdb['kode_registrasi'],8);
			$user_data['email'] = $nis;

			// password siswa menggunakan NISN yang di daftarkan
			// TODO: ASSIGN PASSWORD FOR USER STUDENT
			$user_data['password'] = sha1(date('dmy', strtotime($ppdb['tgl_lahir'])));

			$user_data['province_id'] = $ppdb['province_id_student'];
			$user_data['districts_id'] = $ppdb['districts_id_student'];
			$user_data['district_id'] = $ppdb['district_id_student'];
			$user_data['ward_id'] = $ppdb['ward_id_student'];
			$user_data['post_code'] = $ppdb['postcode_student'];
			$user_data['birthday_place'] = $ppdb['birthday_place_student'];

			$user_data['nik'] = $ppdb['nik'];
			$user_data['birthday'] = $ppdb['tgl_lahir'];
			$user_data['gender'] = $ppdb['jenis_kelamin'];
			$user_data['blood_group'] = $ppdb['golongan_darah'];
			$user_data['address'] = $ppdb['alamat'];
			$user_data['phone'] = $ppdb['telephone'];
			$user_data['role'] = 'student';
			$user_data['school_id'] = $this->school_id;
			$user_data['watch_history'] = '[]';

			// check email duplication
			// SHOULD BE IN FRONTEND 
			// PLEASE CHECK Home.php / registration_post_form()
			// print_r($user_data);
			$this->db->from('users');
			$this->db->where('role', 'student');
			$user_student = $this->db->count_all_results();
			if ($user_student > 500) {
				$response = array(
					'status' => true,
					'notification' => get_phrase('Data sudah mencapai Limit')
				);
			} else {
				$this->db->insert('users', $user_data);
				$user_student_id = $this->db->insert_id();

				$history_data['ket'] = 'Mengisi data user';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				//INSERT PPDB SIPS
				$db2 = $this->load->database('database_sips', TRUE);

				$class_id = html_escape($this->input->post('class_id'));
				$section_id = html_escape($this->input->post('section_id'));

				$class_data = $this->db->get_where('classes', array('id' => $class_id))->row_array();
				$section_data = $this->db->get_where('sections', array('id' => $section_id))->row_array();

				$majorsquery = $db2->get_where('majors', array('majors_name' => $section_data['name']))->row_array();
				$classquery = $db2->get_where('class', array('class_name' => $class_data['name']))->row_array();

				$data_db2['class_class_id'] = $classquery['class_id'];
				$data_db2['majors_majors_id'] = $majorsquery['majors_id'];
				$data_db2['student_nisn'] = $ppdb['nisn'];
				// $data_db2['student_nis'] = "2022".substr($ppdb['kode_registrasi'],8);
				$data_db2['student_nis'] = $nis;
				$data_db2['student_input_date'] = date('Y-m-d H:i:s');
				$data_db2['student_last_update'] = date('Y-m-d H:i:s');
				$data_db2['student_name_of_mother'] = $ppdb['nama_orang_tua'];
				$data_db2['student_name_of_father'] = "Ayah";
				$data_db2['student_address'] = $ppdb['alamat'];
				$data_db2['student_born_date'] = date('Y-m-d', strtotime($ppdb['tgl_lahir']));
				$data_db2['student_born_place'] = $ppdb['tempat_lahir'];
				if ($ppdb['jenis_kelamin'] == "laki-laki") {
					$data_db2['student_gender'] = "L";
				} else {
					$data_db2['student_gender'] = "P";
				};
				$data_db2['student_full_name'] = strtoupper($ppdb['nama_lengkap']);
				$data_db2['student_password'] = sha1(date('dmy', strtotime($ppdb['tgl_lahir'])));
				$data_db2['student_parent_phone'] = $ppdb['telephone'];
				$db2->insert('student', $data_db2);
				// $sips_student_id = $db2->insert_id();

				// $registration_data = $this->db->get_where('registration_path', array('id' => $ppdb['jalur_pendaftaran']))->row_array();

				// $data_bebas_db2['payment_payment_id'] = $ppdb['kode_registrasi'];
				// $data_bebas_db2['bebas_input_date'] = date('Y-m-d H:i:s');
				// $data_bebas_db2['bebas_last_update'] = date('Y-m-d H:i:s');
				// $data_bebas_db2['bebas_bill'] = $registration_data['total'];
				// $data_bebas_db2['bebas_desc'] = "PPDB SIAKAD";
				// $data_bebas_db2['student_student_id'] = $sips_student_id;
				// $db2->insert('bebas', $data_bebas_db2);

				// exit();
				// reset
				$user_data = [];

				// CREATE USER PARENT
				$user_data['name'] = $ppdb['nama_orang_tua'];
				$user_data['email'] = $ppdb['email_orang_tua'];

				// password ortu hardocded NISN yang di daftarkan
				// TODO: ASSIGN PASSWORD FOR USER PARENT
				$user_data['password'] = sha1($ppdb['nisn']);

				$user_data['province_id'] = $ppdb['province_id_parent'];
				$user_data['districts_id'] = $ppdb['districts_id_parent'];
				$user_data['district_id'] = $ppdb['district_id_parent'];
				$user_data['ward_id'] = $ppdb['ward_id_parent'];
				$user_data['post_code'] = $ppdb['postcode_parent'];
				$user_data['nik'] = $ppdb['nik_parent'];
				$user_data['gender'] = $ppdb['gender_parent'];
				$user_data['blood_group'] = $ppdb['blood_group_parent'];
				$user_data['address'] = $ppdb['alamat_orang_tua'];
				$user_data['phone'] = $ppdb['phone_parent'];
				$user_data['religion'] = $ppdb['religion_parent'];

				$user_data['birthday'] = $ppdb['tgl_lahir_orang_tua'];
				$user_data['address'] = $ppdb['alamat_orang_tua'];
				$user_data['role'] = 'parent';
				$user_data['school_id'] = $this->school_id;
				$user_data['watch_history'] = '[]';

				// check email duplication
				// SHOULD BE IN FRONTEND 
				// PLEASE CHECK Home.php / registration_post_form()
				$this->db->insert('users', $user_data);
				$user_parent_id = $this->db->insert_id();

				$history_data['ket'] = 'Mengisi data users';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				// reset
				$user_data = [];

				// exit();

				$user_parent_data['user_id'] = $user_parent_id;
				$user_parent_data['school_id'] = $this->school_id;

				// CREATE PARENTS
				$this->db->insert('parents', $user_parent_data);
				$user_parent_id = $this->db->insert_id();

				$history_data['ket'] = 'Mengisi data parent';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				// CREATE USER PARENT
				$user_data['name'] = $ppdb['nama_wali'];
				$user_data['email'] = $ppdb['email_wali'];

				// password ortu hardocded NISN yang di daftarkan
				// TODO: ASSIGN PASSWORD FOR USER PARENT
				$user_data['password'] = $ppdb['password_guardian'];

				$user_data['province_id'] = $ppdb['province_id_guardian'];
				$user_data['districts_id'] = $ppdb['districts_id_guardian'];
				$user_data['district_id'] = $ppdb['district_id_guardian'];
				$user_data['ward_id'] = $ppdb['ward_id_guardian'];
				$user_data['post_code'] = $ppdb['postcode_guardian'];
				$user_data['nik'] = $ppdb['nik_guardian'];
				$user_data['gender'] = $ppdb['gender_guardian'];
				$user_data['blood_group'] = $ppdb['blood_group_guardian'];
				$user_data['address'] = $ppdb['alamat_wali'];
				$user_data['phone'] = $ppdb['phone_guardian'];
				$user_data['religion'] = $ppdb['religion_guardian'];

				$user_data['birthday'] = $ppdb['tgl_lahir_wali'];
				$user_data['address'] = $ppdb['alamat_wali'];
				$user_data['role'] = 'guardian';
				$user_data['school_id'] = $this->school_id;
				$user_data['watch_history'] = '[]';

				// check email duplication
				// SHOULD BE IN FRONTEND 
				// PLEASE CHECK Home.php / registration_post_form()
				$this->db->insert('users', $user_data);
				$user_guardian_id = $this->db->insert_id();

				$history_data['ket'] = 'Mengisi data user fot guardian';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				// reset
				$user_data = [];

				// exit();

				$user_guardian_data['user_id'] = $user_guardian_id;
				$user_guardian_data['school_id'] = $this->school_id;

				// CREATE PARENTS
				$this->db->insert('guardians', $user_guardian_data);
				$user_guardian_id = $this->db->insert_id();

				$history_data['ket'] = 'Mengisi data guardian';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				// assign parent id to student
				// CREATE STUDENTS
				$user_student_data['code'] = student_code();
				$user_student_data['user_id'] = $user_student_id;
				$user_student_data['parent_id'] = $user_parent_id;
				$user_student_data['skhun'] = $ppdb['skhun'];
				$user_student_data['nisn'] = $ppdb['nisn'];
				// $user_student_data['NIS'] = "2022".substr($ppdb['kode_registrasi'],8);
				$user_student_data['NIS'] = $nis;
				$user_student_data['ijazah'] = $ppdb['ijazah'];
				$user_student_data['rapor_semester'] = $ppdb['rapor_semester'];
				$user_student_data['sertifikat_lainnya'] = $ppdb['sertifikat_lainnya'];
				$user_student_data['dokumen_lainnya'] = $ppdb['dokumen_lainnya'];
				$user_student_data['weight'] = $ppdb['berat_badan'];
				$user_student_data['height'] = $ppdb['tinggi_badan'];
				$user_student_data['mileage'] = $ppdb['jarak_tempat_tinggal'];
				$user_student_data['traveling_time'] = $ppdb['waktu_tempuh'];
				$user_student_data['child_of'] = $ppdb['anak_ke'];
				$user_student_data['number_of_siblings'] = $ppdb['jumlah_saudara'];
				$user_student_data['session'] = $this->active_session;
				$user_student_data['school_id'] = $this->school_id;
				$this->db->insert('students', $user_student_data);
				$insert_id_student = $this->db->insert_id();

				$history_data['ket'] = 'Mengisi data students';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				// ENROLL STUDENT TO CLASS
				$enroll_data['student_id'] = $insert_id_student;
				$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
				$enroll_data['section_id'] = html_escape($this->input->post('section_id'));
				$enroll_data['room_id'] = html_escape($this->input->post('room_id'));
				$enroll_data['session'] = $this->active_session;
				$enroll_data['school_id'] = $this->school_id;
				$this->db->insert('enrols', $enroll_data);

				$history_data['ket'] = 'Mengisi data enrols';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				// END

				// UPDATE PPDB STATUS
				$this->db->where('id', $ppdb_id);
				$this->db->update('registrations', array('status' => 'ENROLL'));

				$history_data['ket'] = 'Update data registrations ' . $ppdb_id . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$response = array(
					'status' => true,
					'notification' => get_phrase('student_added_successfully')
				);
			}
			return $response;
		}
	}

	public function ppdb_users_create_bulk()
	{
		$_id = html_escape($this->input->post('id'));
		$_nis = html_escape($this->input->post('nis'));

		for ($i = 0; $i < count($_id); $i++) {
			$id = $_id[$i];
			$nis = $_nis[$i];
			$response[$i] = $this->ppdb_users_create($id, $nis);
		}

		return $response;
	}

	public function student_allocation_bulk()
	{
		$_id = html_escape($this->input->post('id'));

		for ($i = 0; $i < count($_id); $i++) {
			$id = $_id[$i];
			$response[$i] = $this->student_allocation($id);
		}

		return $response;
	}

	public function student_allocation($id = '')
	{
		$ppdb_id = html_escape($this->input->post('registrasi_id'));

		if ($id != '') {
			$ppdb_id = $id;
		}

		$query = $this->db->get_where('registrations', array('id' => $ppdb_id))->result_array();

		foreach ($query as $ppdb) {

			if (!empty($ppdb['parent_id'])) {
				$user_data['name'] = $ppdb['nama_lengkap'];
				$user_data['email'] = $ppdb['email_siswa'];

				// password siswa menggunakan NISN yang di daftarkan
				// TODO: ASSIGN PASSWORD FOR USER STUDENT
				$user_data['password'] = $ppdb['password_student'];

				$user_data['province_id'] = $ppdb['province_id_student'];
				$user_data['districts_id'] = $ppdb['districts_id_student'];
				$user_data['district_id'] = $ppdb['district_id_student'];
				$user_data['ward_id'] = $ppdb['ward_id_student'];
				$user_data['post_code'] = $ppdb['postcode_student'];
				$user_data['birthday_place'] = $ppdb['birthday_place_student'];
				$user_data['nik'] = $ppdb['nik'];
				$user_data['birthday'] = $ppdb['tgl_lahir'];
				$user_data['gender'] = $ppdb['jenis_kelamin'];
				$user_data['blood_group'] = $ppdb['golongan_darah'];
				$user_data['address'] = $ppdb['alamat'];
				$user_data['religion'] = $ppdb['agama'];
				$user_data['phone'] = $ppdb['telephone'];
				$user_data['role'] = 'student';
				$user_data['school_id'] = $this->school_id;
				$user_data['watch_history'] = '[]';
				$this->db->from('users');
				$this->db->where('role', 'student');
				$user_student = $this->db->count_all_results();
				if ($user_student > 500) {
					$response = array(
						'status' => true,
						'notification' => get_phrase('Data sudah mencapai Limit')
					);
				} else {
					$this->db->insert('users', $user_data);
					$user_student_id = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data user for student';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					$student = $this->db->get_where('students', array('parent_id' => $ppdb['parent_id']))->row_array();
					// assign parent id to student
					// CREATE STUDENTS
					$user_student_data['code'] = student_code();
					$user_student_data['user_id'] = $user_student_id;
					$user_student_data['guardian_id'] = $student['guardian_id'];
					$user_student_data['parent_id'] = $ppdb['parent_id'];
					$user_student_data['skhun'] = $ppdb['skhun'];
					$user_student_data['nisn'] = $ppdb['nisn'];
					$user_student_data['ijazah'] = $ppdb['ijazah'];
					$user_student_data['rapor_semester'] = $ppdb['rapor_semester'];
					$user_student_data['sertifikat_lainnya'] = $ppdb['sertifikat_lainnya'];
					$user_student_data['dokumen_lainnya'] = $ppdb['dokumen_lainnya'];
					$user_student_data['weight'] = $ppdb['berat_badan'];
					$user_student_data['height'] = $ppdb['tinggi_badan'];
					$user_student_data['mileage'] = $ppdb['jarak_tempat_tinggal'];
					$user_student_data['traveling_time'] = $ppdb['waktu_tempuh'];
					$user_student_data['child_of'] = $ppdb['anak_ke'];
					$user_student_data['number_of_siblings'] = $ppdb['jumlah_saudara'];
					$user_student_data['session'] = $this->active_session;
					$user_student_data['school_id'] = $this->school_id;
					$this->db->insert('students', $user_student_data);
					$insert_id_student = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data student';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					// ENROLL STUDENT TO CLASS
					$enroll_data['student_id'] = $insert_id_student;
					$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
					$enroll_data['section_id'] = html_escape($this->input->post('section_id'));
					$enroll_data['room_id'] = html_escape($this->input->post('room_id'));
					$enroll_data['session'] = $this->active_session;
					$enroll_data['school_id'] = $this->school_id;
					$this->db->insert('enrols', $enroll_data);

					$history_data['ket'] = 'Mengisi data enrols';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
					// END

					// UPDATE PPDB STATUS
					$this->db->where('id', $ppdb_id);
					$this->db->update('registrations', array('status' => 'ENROLL'));

					$history_data['ket'] = 'Update data registrations ' . $ppdb_id . '';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					$response = array(
						'status' => true,
						'notification' => get_phrase('student_added_successfully')
					);
				}
			} else {

				$user_data['name'] = $ppdb['nama_lengkap'];
				$user_data['email'] = $ppdb['email_siswa'];

				// password siswa menggunakan NISN yang di daftarkan
				// TODO: ASSIGN PASSWORD FOR USER STUDENT
				$user_data['password'] = $ppdb['password_student'];

				$user_data['province_id'] = $ppdb['province_id_student'];
				$user_data['districts_id'] = $ppdb['districts_id_student'];
				$user_data['district_id'] = $ppdb['district_id_student'];
				$user_data['ward_id'] = $ppdb['ward_id_student'];
				$user_data['post_code'] = $ppdb['postcode_student'];
				$user_data['birthday_place'] = $ppdb['birthday_place_student'];
				$user_data['nik'] = $ppdb['nik'];
				$user_data['birthday'] = $ppdb['tgl_lahir'];
				$user_data['gender'] = $ppdb['jenis_kelamin'];
				$user_data['blood_group'] = $ppdb['golongan_darah'];
				$user_data['address'] = $ppdb['alamat'];
				$user_data['religion'] = $ppdb['agama'];
				$user_data['phone'] = $ppdb['telephone'];
				$user_data['role'] = 'student';
				$user_data['school_id'] = $this->school_id;
				$user_data['watch_history'] = '[]';

				// check email duplication
				// SHOULD BE IN FRONTEND 
				// PLEASE CHECK Home.php / registration_post_form()
				// print_r($user_data);

				$this->db->from('users');
				$this->db->where('role', 'student');
				$user_student = $this->db->count_all_results();
				if ($user_student > 500) {
					$response = array(
						'status' => true,
						'notification' => get_phrase('Data sudah mencapai Limit')
					);
				} else {
					$this->db->insert('users', $user_data);
					$user_student_id = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data users';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
					// exit();
					// reset
					$user_data = [];

					// CREATE USER PARENT
					$user_data['name'] = $ppdb['nama_orang_tua'];
					$user_data['email'] = $ppdb['email_orang_tua'];

					// password ortu hardocded NISN yang di daftarkan
					// TODO: ASSIGN PASSWORD FOR USER PARENT
					$user_data['password'] = $ppdb['password_parent'];

					$user_data['province_id'] = $ppdb['province_id_parent'];
					$user_data['districts_id'] = $ppdb['districts_id_parent'];
					$user_data['district_id'] = $ppdb['district_id_parent'];
					$user_data['ward_id'] = $ppdb['ward_id_parent'];
					$user_data['post_code'] = $ppdb['postcode_parent'];
					$user_data['nik'] = $ppdb['nik_parent'];
					$user_data['gender'] = $ppdb['gender_parent'];
					$user_data['blood_group'] = $ppdb['blood_group_parent'];
					$user_data['address'] = $ppdb['alamat_orang_tua'];
					$user_data['phone'] = $ppdb['phone_parent'];
					$user_data['religion'] = $ppdb['religion_parent'];
					$user_data['birthday'] = $ppdb['tgl_lahir_orang_tua'];
					$user_data['address'] = $ppdb['alamat_orang_tua'];
					$user_data['role'] = 'parent';
					$user_data['school_id'] = $this->school_id;
					$user_data['watch_history'] = '[]';

					// check email duplication
					// SHOULD BE IN FRONTEND 
					// PLEASE CHECK Home.php / registration_post_form()
					$this->db->insert('users', $user_data);
					$user_parent_id = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data users';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					// reset
					$user_data = [];

					// exit();

					$user_parent_data['user_id'] = $user_parent_id;
					$user_parent_data['school_id'] = $this->school_id;

					// CREATE PARENTS
					$this->db->insert('parents', $user_parent_data);
					$user_parent_id = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data parents';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					$user_data = [];

					// CREATE USER PARENT
					$user_data['name'] = $ppdb['nama_wali'];
					$user_data['email'] = $ppdb['email_wali'];

					// password ortu hardocded NISN yang di daftarkan
					// TODO: ASSIGN PASSWORD FOR USER PARENT
					$user_data['password'] = $ppdb['password_guardian'];

					$user_data['province_id'] = $ppdb['province_id_guardian'];
					$user_data['districts_id'] = $ppdb['districts_id_guardian'];
					$user_data['district_id'] = $ppdb['district_id_guardian'];
					$user_data['ward_id'] = $ppdb['ward_id_guardian'];
					$user_data['post_code'] = $ppdb['postcode_guardian'];
					$user_data['nik'] = $ppdb['nik_guardian'];
					$user_data['gender'] = $ppdb['gender_guardian'];
					$user_data['blood_group'] = $ppdb['blood_group_guardian'];
					$user_data['address'] = $ppdb['alamat_wali'];
					$user_data['phone'] = $ppdb['phone_guardian'];
					$user_data['religion'] = $ppdb['religion_guardian'];
					$user_data['birthday'] = $ppdb['tgl_lahir_wali'];
					$user_data['address'] = $ppdb['alamat_wali'];
					$user_data['role'] = 'guardian';
					$user_data['school_id'] = $this->school_id;
					$user_data['watch_history'] = '[]';

					// check email duplication
					// SHOULD BE IN FRONTEND 
					// PLEASE CHECK Home.php / registration_post_form()
					$this->db->insert('users', $user_data);
					$user_guardian_id = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data users';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					// reset
					$user_data = [];

					// exit();

					$user_guardian_data['user_id'] = $user_guardian_id;
					$user_guardian_data['school_id'] = $this->school_id;

					// CREATE PARENTS
					$this->db->insert('guardians', $user_guardian_data);
					$user_guardian_id = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data guardians';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					// assign parent id to student
					// CREATE STUDENTS
					$user_student_data['code'] = student_code();
					$user_student_data['user_id'] = $user_student_id;
					$user_student_data['guardian_id'] = $user_guardian_id;
					$user_student_data['parent_id'] = $user_parent_id;
					$user_student_data['skhun'] = $ppdb['skhun'];
					$user_student_data['nisn'] = $ppdb['nisn'];
					$user_student_data['ijazah'] = $ppdb['ijazah'];
					$user_student_data['rapor_semester'] = $ppdb['rapor_semester'];
					$user_student_data['sertifikat_lainnya'] = $ppdb['sertifikat_lainnya'];
					$user_student_data['dokumen_lainnya'] = $ppdb['dokumen_lainnya'];
					$user_student_data['weight'] = $ppdb['berat_badan'];
					$user_student_data['height'] = $ppdb['tinggi_badan'];
					$user_student_data['mileage'] = $ppdb['jarak_tempat_tinggal'];
					$user_student_data['traveling_time'] = $ppdb['waktu_tempuh'];
					$user_student_data['child_of'] = $ppdb['anak_ke'];
					$user_student_data['number_of_siblings'] = $ppdb['jumlah_saudara'];
					$user_student_data['session'] = $this->active_session;
					$user_student_data['school_id'] = $this->school_id;
					$this->db->insert('students', $user_student_data);
					$insert_id_student = $this->db->insert_id();

					$history_data['ket'] = 'Mengisi data student';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					// ENROLL STUDENT TO CLASS
					$enroll_data['student_id'] = $insert_id_student;
					$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
					$enroll_data['section_id'] = html_escape($this->input->post('section_id'));
					$enroll_data['room_id'] = html_escape($this->input->post('room_id'));
					$enroll_data['session'] = $this->active_session;
					$enroll_data['school_id'] = $this->school_id;
					$this->db->insert('enrols', $enroll_data);

					$history_data['ket'] = 'Mengisi data enrols';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					// END

					// UPDATE PPDB STATUS
					$this->db->where('id', $ppdb_id);
					$this->db->update('registrations', array('status' => 'ENROLL'));

					$history_data['ket'] = 'Update data registrations ' . $ppdb_id . '';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);

					$response = array(
						'status' => true,
						'notification' => get_phrase('student_added_successfully')
					);
				}
			}
		}
		return $response;
	}

	public function create_single_parent()
	{
		$data['name'] = html_escape($this->input->post('parent_name'));
		$data['email'] = html_escape($this->input->post('parent_email'));
		$data['password'] = sha1($this->input->post('parent_password'));
		$data['phone'] = html_escape($this->input->post('parent_phone'));
		$data['gender'] = html_escape($this->input->post('parent_gender'));
		$data['blood_group'] = html_escape($this->input->post('parent_blood_group'));
		$data['address'] = html_escape($this->input->post('parent_address'));
		$data['school_id'] = $this->school_id;
		$data['role'] = 'parent';
		$data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $data['email']);
		if ($duplication_status) {

			$this->db->insert('users', $data);
			$parent_data['user_id'] = $this->db->insert_id();

			$history_data['ket'] = 'Mengisi data user for parent';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$parent_data['school_id'] = $this->school_id;
			$this->db->insert('parents', $parent_data);

			$history_data['ket'] = 'Mengisi data parents';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('parent_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function create_ppdb_registration()
	{
		$data['nik'] = html_escape($this->input->post('nik'));
		if (strlen($data['nik']) == 16) {
			$data['nama_lengkap'] = html_escape($this->input->post('nama'));
			$data['jenis_kelamin'] = html_escape($this->input->post('student_gender'));
			$data['tempat_lahir'] = html_escape($this->input->post('birthday_place'));
			$data['tgl_lahir'] = html_escape($this->input->post('student_birthday'));
			$data['nisn'] = html_escape($this->input->post('nisn'));
			$data['sekolah_asal'] = html_escape($this->input->post('sekolah_asal'));
			$data['jurusan'] = html_escape($this->input->post('jurusan'));
			$data['nama_orang_tua'] = html_escape($this->input->post('nama_orang_tua'));
			$data['pekerjaan_orang_tua'] = html_escape($this->input->post('pekerjaan_orang_tua'));
			$data['alamat'] = html_escape($this->input->post('alamat'));
			$data['telephone'] = html_escape($this->input->post('telephone'));
			$data['info_sekolah'] = html_escape($this->input->post('info_sekolah'));
			$data['jalur_pendaftaran'] = html_escape($this->input->post('jalur_pendaftaran'));
			$data['status'] = html_escape($this->input->post('status'));
			$data['ket'] = 'Calon Peserta Didik Menyetujui Persyaratan PPDB';

			// TODO: generate kode registrasi
			$data['tgl_daftar'] = date('m/d/Y');
			$bulan = date('m');

			$school_id = school_id();
			$this->db->select("kode_registrasi, tgl_daftar");
			$this->db->where("school_id", $school_id);
			$this->db->order_by("id", "DESC");
			$this->db->limit(1);
			$kode_sebelumnya = $this->db->get('registrations')->row_array();
			$kode_urut_terakhir = substr($kode_sebelumnya['kode_registrasi'], -4);
			$tahun_sebelumnya = date('Y', strtotime($kode_sebelumnya['tgl_daftar']));
			$nomor_urut = "0000";

			$tahun = date('Y');
			if ($tahun_sebelumnya == $tahun) {
				$nomor_urut = sprintf('%04d', (int)$kode_urut_terakhir + 1);
			} else {
				$nomor_urut = sprintf('%04d', 1);
			}

			if ($bulan >= 7) {
				$tahun = date('y') + 1;
				$data['kode_registrasi'] = $tahun . "05" . $nomor_urut;
			} else {
				$tahun = date('y');
				$data['kode_registrasi'] = $tahun . "05" . $nomor_urut;
			}

			$data['kategori_spp'] = 'Umum';
			$data['nilai_ranking'] = 0;
			$data['school_id'] = school_id();

			$this->db->insert('registrations', $data);

			$history_data['ket'] = 'Mengisi data registrations';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$response = array(
				'status' => true,
				'notification' => get_phrase('student_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('Panjang NIK salah, Harap dilengkapi')
			);
			$this->session->set_flashdata('flash_message', get_phrase('Panjang NIK salah, Harap dilengkapi'));
		}

		return json_encode($response);
	}

	public function just_student()
	{
		$user_data['name'] = html_escape($this->input->post('name'));
		$user_data['email'] = html_escape($this->input->post('email'));
		$user_data['password'] = sha1(html_escape($this->input->post('password')));
		$user_data['birthday_place'] = html_escape($this->input->post('birthday_place'));
		$user_data['birthday'] = $this->input->post('birthday');
		$user_data['gender'] = html_escape($this->input->post('gender'));
		$user_data['blood_group'] = html_escape($this->input->post('blood_group'));
		$user_data['address'] = html_escape($this->input->post('address'));
		$user_data['province_id'] = html_escape($this->input->post('student_province_id'));
		$user_data['district_id'] = html_escape($this->input->post('student_district_id'));
		$user_data['districts_id'] = html_escape($this->input->post('student_districts_id'));
		$user_data['ward_id'] = html_escape($this->input->post('student_ward_id'));
		$user_data['post_code'] = html_escape($this->input->post('student_postcode_id'));
		$user_data['religion'] = html_escape($this->input->post('religion'));
		$user_data['nik'] = html_escape($this->input->post('nik'));
		$user_data['phone'] = html_escape($this->input->post('phone'));
		$user_data['role'] = 'student';
		$user_data['school_id'] = $this->school_id;
		$user_data['watch_history'] = '[]';

		// check email duplication
		$duplication_status = $this->check_duplication('on_create', $user_data['email']);

		$this->db->from('users');
		$this->db->where('role', 'student');
		$user_student = $this->db->count_all_results();
		if ($user_student > 500) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('Data sudah mencapai Limit')
			);
		} elseif ($duplication_status) {
			$this->db->insert('users', $user_data);
			$user_id = $this->db->insert_id();

			$history_data['ket'] = 'Insert data user for student';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$student_data['code'] = student_code();
			$student_data['user_id'] = $user_id;
			$student_data['nisn'] = html_escape($this->input->post('nisn'));
			$student_data['weight'] = html_escape($this->input->post('weight'));
			$student_data['height'] = html_escape($this->input->post('height'));
			$student_data['mileage'] = html_escape($this->input->post('mileage'));
			$student_data['traveling_time'] = html_escape($this->input->post('traveling_time'));
			$student_data['child_of'] = html_escape($this->input->post('child_of'));
			$student_data['number_of_siblings'] = html_escape($this->input->post('number_of_siblings'));
			$student_data['nomor_ijazah'] = html_escape($this->input->post('nomor_ijazah'));
			$student_data['nomor_skhun'] = html_escape($this->input->post('nomor_skhun'));
			$student_data['school_before'] = html_escape($this->input->post('school_before'));
			$student_data['nomor_un'] = html_escape($this->input->post('nomor_un'));
			$student_data['nomor_kip'] = html_escape($this->input->post('nomor_kip'));
			if (empty($student_data['nomor_kip'])) {
				$student_data['nomor_kip'] = '0';
			}

			$file_ext = pathinfo($_FILES['skhun']['name'], PATHINFO_EXTENSION);
			$student_data['skhun'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
			move_uploaded_file($_FILES['skhun']['tmp_name'], 'uploads/registrations/' . $student_data['skhun']);

			$file_ext = pathinfo($_FILES['ijazah']['name'], PATHINFO_EXTENSION);
			$student_data['ijazah'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
			move_uploaded_file($_FILES['ijazah']['tmp_name'], 'uploads/registrations/' . $student_data['ijazah']);

			$file_ext = pathinfo($_FILES['rapor_semester']['name'], PATHINFO_EXTENSION);
			$student_data['rapor_semester'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
			move_uploaded_file($_FILES['rapor_semester']['tmp_name'], 'uploads/registrations/' . $student_data['rapor_semester']);


			// $sertifikat_lainnya = $this->input->post('sertifikat_lainnya');
			$file_ext = pathinfo($_FILES['sertifikat_lainnya']['name'], PATHINFO_EXTENSION);
			// if(empty($sertifikat_lainnya)){
			// 	$student_data['sertifikat_lainnya'] = '0';
			// }else{
			if (!empty($file_ext)) {
				$student_data['sertifikat_lainnya'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
				move_uploaded_file($_FILES['sertifikat_lainnya']['tmp_name'], 'uploads/registrations/' . $student_data['sertifikat_lainnya']);
			} elseif (empty($file_ext)) {
				$student_data['sertifikat_lainnya'] = '0';
			}

			// $dokumen_lainnya = $this->input->post('dokumen_lainnya');
			$file_ext = pathinfo($_FILES['dokumen_lainnya']['name'], PATHINFO_EXTENSION);
			// if(empty($dokumen_lainnya)){
			// 	$student_data['dokumen_lainnya'] = '0';
			// }else{
			if (!empty($file_ext)) {
				$student_data['dokumen_lainnya'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
				move_uploaded_file($_FILES['dokumen_lainnya']['tmp_name'], 'uploads/registrations/' . $student_data['dokumen_lainnya']);
			} elseif (empty($file_ext)) {
				$student_data['dokumen_lainnya'] = '0';
			}

			$student_data['parent_id'] = html_escape($this->input->post('parent_id'));
			$student_data['guardian_id'] = html_escape($this->input->post('guardian_id'));
			$student_data['session'] = $this->active_session;
			$student_data['school_id'] = $this->school_id;
			$this->db->insert('students', $student_data);
			$student_id = $this->db->insert_id();

			$history_data['ket'] = 'Insert data student';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$enroll_data['student_id'] = $student_id;
			$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
			$enroll_data['section_id'] = html_escape($this->input->post('section_id'));
			$enroll_data['session'] = $this->active_session;
			$enroll_data['school_id'] = $this->school_id;
			$this->db->insert('enrols', $enroll_data);

			$history_data['ket'] = 'Insert data enrols';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			move_uploaded_file($_FILES['student_image']['tmp_name'], 'uploads/users/' . $user_id);

			$response = array(
				'status' => true,
				'notification' => get_phrase('student_added_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function single_student_create()
	{
		$check = html_escape($this->input->post('check'));

		if ($check == 'yes') {
			$user_data['name'] = html_escape($this->input->post('student_name'));
			$user_data['email'] = html_escape($this->input->post('student_email'));
			$user_data['password'] = sha1(html_escape($this->input->post('student_password')));
			$user_data['birthday_place'] = html_escape($this->input->post('birthday_place'));
			$user_data['birthday'] = $this->input->post('student_birthday');
			$user_data['gender'] = html_escape($this->input->post('student_gender'));
			$user_data['blood_group'] = html_escape($this->input->post('student_blood_group'));
			$user_data['address'] = html_escape($this->input->post('student_address'));
			$user_data['province_id'] = html_escape($this->input->post('student_province_id'));
			$user_data['district_id'] = html_escape($this->input->post('student_district_id'));
			$user_data['districts_id'] = html_escape($this->input->post('student_districts_id'));
			$user_data['ward_id'] = html_escape($this->input->post('student_ward_id'));
			$user_data['post_code'] = html_escape($this->input->post('student_postcode_id'));
			$user_data['religion'] = html_escape($this->input->post('student_religion'));
			$user_data['nik'] = html_escape($this->input->post('student_nik'));
			$user_data['phone'] = html_escape($this->input->post('student_phone'));
			$user_data['school_id'] = school_id();
			$user_data['role'] = 'student';
			$user_data['watch_history'] = '[]';

			// check email duplication
			$duplication_status = $this->check_duplication('on_create', $user_data['email']);

			$this->db->from('users');
			$this->db->where('role', 'student');
			$user_student = $this->db->count_all_results();
			if ($user_student > 500) {
				$this->session->set_flashdata('ajax_error_message', get_phrase('Data sudah mencapai Limit'));
				redirect(site_url('superadmin/student'));
			} elseif ($duplication_status) {

				$this->db->insert('users', $user_data);
				$user_id = $this->db->insert_id();

				$history_data['ket'] = 'Insert data users for student';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$student_data['code'] = student_code();
				$student_data['nisn'] = html_escape($this->input->post('nisn'));
				$student_data['NIS'] = html_escape($this->input->post('nis'));
				$student_data['weight'] = html_escape($this->input->post('weight'));
				$student_data['height'] = html_escape($this->input->post('height'));
				$student_data['mileage'] = html_escape($this->input->post('mileage'));
				$student_data['traveling_time'] = html_escape($this->input->post('traveling_time'));
				$student_data['child_of'] = html_escape($this->input->post('child_of'));
				$student_data['number_of_siblings'] = html_escape($this->input->post('number_of_siblings'));
				$student_data['nomor_ijazah'] = html_escape($this->input->post('nomor_ijazah'));
				$student_data['nomor_skhun'] = html_escape($this->input->post('nomor_skhun'));
				$student_data['school_before'] = html_escape($this->input->post('school_before'));
				$student_data['nomor_un'] = html_escape($this->input->post('nomor_un'));
				$student_data['parent_id'] = html_escape($this->input->post('parent_id'));
				$student_data['school_id'] = school_id();
				$student_data['session'] = active_session();
				$student_data['user_id'] = $user_id;

				$file_ext = pathinfo($_FILES['skhun']['name'], PATHINFO_EXTENSION);
				$student_data['skhun'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
				move_uploaded_file($_FILES['skhun']['tmp_name'], 'uploads/registrations/' . $student_data['skhun']);

				$file_ext = pathinfo($_FILES['ijazah']['name'], PATHINFO_EXTENSION);
				$student_data['ijazah'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
				move_uploaded_file($_FILES['ijazah']['tmp_name'], 'uploads/registrations/' . $student_data['ijazah']);

				$file_ext = pathinfo($_FILES['rapor_semester']['name'], PATHINFO_EXTENSION);
				$student_data['rapor_semester'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
				move_uploaded_file($_FILES['rapor_semester']['tmp_name'], 'uploads/registrations/' . $student_data['rapor_semester']);

				$file_ext = pathinfo($_FILES['sertifikat_lainnya']['name'], PATHINFO_EXTENSION);
				if (!empty($file_ext)) {
					$student_data['sertifikat_lainnya'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
					move_uploaded_file($_FILES['sertifikat_lainnya']['tmp_name'], 'uploads/registrations/' . $student_data['sertifikat_lainnya']);
				} elseif (empty($file_ext)) {
					$student_data['sertifikat_lainnya'] = '0';
				}

				$file_ext = pathinfo($_FILES['dokumen_lainnya']['name'], PATHINFO_EXTENSION);
				if (!empty($file_ext)) {
					$student_data['dokumen_lainnya'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
					move_uploaded_file($_FILES['dokumen_lainnya']['tmp_name'], 'uploads/registrations/' . $student_data['dokumen_lainnya']);
				} elseif (empty($file_ext)) {
					$student_data['dokumen_lainnya'] = '0';
				}

				$this->db->insert('students', $student_data);
				$student_id = $this->db->insert_id();

				$history_data['ket'] = 'Insert data students';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$enroll_data['student_id'] = $student_id;
				$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
				$enroll_data['section_id'] = html_escape($this->input->post('section_id'));
				$enroll_data['room_id'] = html_escape($this->input->post('room_id'));
				$enroll_data['school_id'] = school_id();
				$enroll_data['session'] = active_session();
				$this->db->insert('enrols', $enroll_data);

				$history_data['ket'] = 'Insert data enrols';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$db2 = $this->load->database('database_sips', TRUE);

				$students = $db2->get_where('student', array('student_nis' => $this->input->post('nis'), 'student_full_name' => strtoupper($this->input->post('student_name'))))->row_array();
				if (empty($students)) {
					$class_id = html_escape($this->input->post('class_id'));
					$section_id = html_escape($this->input->post('section_id'));

					$class_data = $this->db->get_where('classes', array('id' => $class_id))->row_array();
					$section_data = $this->db->get_where('sections', array('id' => $section_id))->row_array();
					$user_parent_id = $this->db->get_where('parents', array('id' => $this->input->post('parent_id')))->row_array();
					$parent_data = $this->db->get_where('users', array('id' => $user_parent_id['user_id']))->row_array();

					$majorsquery = $db2->get_where('majors', array('majors_name' => $section_data['name']))->row_array();
					$classquery = $db2->get_where('class', array('class_name' => $class_data['name']))->row_array();

					$data_db2['class_class_id'] = $classquery['class_id'];
					$data_db2['majors_majors_id'] = $majorsquery['majors_id'];
					$data_db2['student_nisn'] = $this->input->post('nisn');
					$data_db2['student_nis'] = $this->input->post('nis');
					$data_db2['student_input_date'] = date('Y-m-d H:i:s');
					$data_db2['student_last_update'] = date('Y-m-d H:i:s');
					$data_db2['student_name_of_mother'] = $parent_data['name'];
					$data_db2['student_name_of_father'] = $parent_data['name'];
					$data_db2['student_address'] = $this->input->post('student_address');
					$data_db2['student_born_date'] = date('Y-m-d', strtotime($this->input->post('student_birthday')));
					$data_db2['student_born_place'] = $this->input->post('birthday_place');
					if ($this->input->post('student_gender') == "Male") {
						$data_db2['student_gender'] = "Laki-Laki";
					} else {
						$data_db2['student_gender'] = "Perempuan";
					};
					$data_db2['student_full_name'] = strtoupper($this->input->post('student_name'));
					$data_db2['student_password'] = sha1(date('dmy', strtotime($this->input->post('student_birthday'))));
					$data_db2['student_parent_phone'] = $this->input->post('student_phone');
					$db2->insert('student', $data_db2);
				} else {
				}

				$this->session->set_flashdata('flash_message', get_phrase('student_added_successfully'));
				redirect(site_url('superadmin/student'));
			} else {

				$this->session->set_flashdata('ajax_error_message', get_phrase('sorry_this_email_has_been_taken'));
				redirect(site_url('superadmin/student'));
			}
		} else {
			$parent_data['name'] = html_escape($this->input->post('parent_name'));
			$parent_data['email'] = html_escape($this->input->post('parent_email'));
			$parent_data['password'] = sha1($this->input->post('parent_password'));
			$parent_data['phone'] = html_escape($this->input->post('parent_phone'));
			$parent_data['gender'] = html_escape($this->input->post('parent_gender'));
			$parent_data['blood_group'] = html_escape($this->input->post('parent_blood_group'));
			$parent_data['address'] = html_escape($this->input->post('parent_address'));
			$parent_data['province_id'] = html_escape($this->input->post('parent_province_id'));
			$parent_data['district_id'] = html_escape($this->input->post('parent_district_id'));
			$parent_data['districts_id'] = html_escape($this->input->post('parent_districts_id'));
			$parent_data['ward_id'] = html_escape($this->input->post('parent_ward_id'));
			$parent_data['post_code'] = html_escape($this->input->post('parent_postcode_id'));
			$parent_data['religion'] = html_escape($this->input->post('parent_religion'));
			$parent_data['nik'] = html_escape($this->input->post('parent_nik'));
			$parent_data['role'] = 'parent';
			$parent_data['school_id'] = school_id();
			$parent_data['watch_history'] = '[]';

			// check email duplication
			$duplication_status = $this->check_duplication('on_create', $parent_data['email']);
			if ($duplication_status) {

				$this->db->insert('users', $parent_data);
				$parent['user_id'] = $this->db->insert_id();

				$history_data['ket'] = 'Insert data users for parent';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$parent['school_id'] = school_id();
				$this->db->insert('parents', $parent);
				$user_parent_id = $this->db->insert_id();

				$history_data['ket'] = 'Insert data parents';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			} else {
				$response = array(
					'status' => false,
					'notification' => get_phrase('orang_tua_:_sorry_this_email_has_been_taken')
				);
			}

			if (empty($guardian_data['nama_wali'])) {
				$guardian_data['nama_wali'] = '0';
			}
			$guardian_data['email_wali'] = html_escape($this->input->post('guardian_email'));
			if (empty($guardian_data['email_wali'])) {
				$guardian_data['email_wali'] = '0';
			}
			$guardian_data['password_guardian'] = sha1($this->input->post('guardian_password'));
			if (empty($guardian_data['password_guardian'])) {
				$guardian_data['password_guardian'] = '0';
			}
			$guardian_data['phone_guardian'] = html_escape($this->input->post('guardian_phone'));
			if (empty($guardian_data['phone_guardian'])) {
				$guardian_data['phone_guardian'] = '0';
			}
			$guardian_data['gender_guardian'] = html_escape($this->input->post('guardian_gender'));
			if (empty($guardian_data['gender_guardian'])) {
				$guardian_data['gender_guardian'] = '0';
			}
			$guardian_data['blood_group_guardian'] = html_escape($this->input->post('guardian_blood_group'));
			if (empty($guardian_data['blood_group_guardian'])) {
				$guardian_data['blood_group_guardian'] = '0';
			}
			$guardian_data['alamat_wali'] = html_escape($this->input->post('guardian_address'));
			if (empty($guardian_data['alamat_wali'])) {
				$guardian_data['alamat_wali'] = '0';
			}
			$guardian_data['province_id_guardian'] = html_escape($this->input->post('guardian_province_id'));
			if (empty($guardian_data['province_id_guardian'])) {
				$guardian_data['province_id_guardian'] = '0';
			}
			$guardian_data['district_id_guardian'] = html_escape($this->input->post('guardian_district_id'));
			if (empty($guardian_data['district_id_guardian'])) {
				$guardian_data['district_id_guardian'] = '0';
			}
			$guardian_data['districts_id_guardian'] = html_escape($this->input->post('guardian_districts_id'));
			if (empty($guardian_data['districts_id_guardian'])) {
				$guardian_data['districts_id_guardian'] = '0';
			}
			$guardian_data['ward_id_guardian'] = html_escape($this->input->post('guardian_ward_id'));
			if (empty($guardian_data['ward_id_guardian'])) {
				$guardian_data['ward_id_guardian'] = '0';
			}
			$guardian_data['postcode_guardian'] = html_escape($this->input->post('guardian_postcode_id'));
			if (empty($guardian_data['postcode_guardian'])) {
				$guardian_data['postcode_guardian'] = '0';
			}
			$guardian_data['religion_guardian'] = html_escape($this->input->post('guardian_religion'));
			if (empty($guardian_data['religion_guardian'])) {
				$guardian_data['religion_guardian'] = '0';
			}
			$guardian_data['nik_guardian'] = html_escape($this->input->post('guardian_nik'));
			if (empty($guardian_data['nik_guardian'])) {
				$guardian_data['nik_guardian'] = '0';
			}
			$guardian_data['role'] = 'guardian';
			$guardian_data['watch_history'] = '[]';

			// check email duplication
			$duplication_status = $this->check_duplication('on_create', $guardian_data['email']);
			if ($duplication_status) {

				$this->db->insert('users', $guardian_data);
				$guardian['user_id'] = $this->db->insert_id();

				$history_data['ket'] = 'Insert data users for guardia';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$guardian['school_id'] = school_id();
				$this->db->insert('guardians', $guardian);
				$user_guardian_id = $this->db->insert_id();

				$history_data['ket'] = 'Insert data guardian';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			} else {
				$response = array(
					'status' => false,
					'notification' => get_phrase('wali_:_sorry_this_email_has_been_taken')
				);
			}

			$student_user_data['name'] = html_escape($this->input->post('student_name'));
			$student_user_data['email'] = html_escape($this->input->post('student_email'));
			$student_user_data['password'] = sha1(html_escape($this->input->post('student_password')));
			$student_user_data['birthday_place'] = html_escape($this->input->post('birthday_place'));
			$student_user_data['birthday'] = $this->input->post('student_birthday');
			$student_user_data['gender'] = html_escape($this->input->post('student_gender'));
			$student_user_data['blood_group'] = html_escape($this->input->post('student_blood_group'));
			$student_user_data['address'] = html_escape($this->input->post('student_address'));
			$student_user_data['province_id'] = html_escape($this->input->post('student_province_id'));
			$student_user_data['district_id'] = html_escape($this->input->post('student_district_id'));
			$student_user_data['districts_id'] = html_escape($this->input->post('student_districts_id'));
			$student_user_data['ward_id'] = html_escape($this->input->post('student_ward_id'));
			$student_user_data['post_code'] = html_escape($this->input->post('student_postcode_id'));
			$student_user_data['religion'] = html_escape($this->input->post('student_religion'));
			$student_user_data['nik'] = html_escape($this->input->post('student_nik'));
			$student_user_data['phone'] = html_escape($this->input->post('student_phone'));
			$student_user_data['school_id'] = school_id();
			$student_user_data['role'] = 'student';
			$student_user_data['watch_history'] = '[]';

			// check email duplication
			$duplication_status = $this->check_duplication('on_create', $student_user_data['email']);
			$this->db->from('users');
			$this->db->where('role', 'student');
			$user_student = $this->db->count_all_results();
			if ($user_student > 500) {
				$this->session->set_flashdata('ajax_error_message', get_phrase('Data sudah mencapai Limit'));
				redirect(site_url('superadmin/student'));
			} elseif ($duplication_status) {

				$this->db->insert('users', $student_user_data);
				$user_id = $this->db->insert_id();

				$history_data['ket'] = 'Insert data user for student';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$student_data['code'] = student_code();
				$student_data['nisn'] = html_escape($this->input->post('nisn'));
				$student_data['NIS'] = html_escape($this->input->post('nis'));
				$student_data['weight'] = html_escape($this->input->post('weight'));
				$student_data['height'] = html_escape($this->input->post('height'));
				$student_data['mileage'] = html_escape($this->input->post('mileage'));
				$student_data['traveling_time'] = html_escape($this->input->post('traveling_time'));
				$student_data['child_of'] = html_escape($this->input->post('child_of'));
				$student_data['number_of_siblings'] = html_escape($this->input->post('number_of_siblings'));
				$student_data['nomor_ijazah'] = html_escape($this->input->post('nomor_ijazah'));
				$student_data['nomor_skhun'] = html_escape($this->input->post('nomor_skhun'));
				$student_data['school_before'] = html_escape($this->input->post('school_before'));
				$student_data['nomor_un'] = html_escape($this->input->post('nomor_un'));
				$student_data['parent_id'] = $user_parent_id;
				$student_data['guardian_id'] = $user_guardian_id;
				$student_data['school_id'] = school_id();
				$student_data['session'] = active_session();
				$student_data['user_id'] = $user_id;

				$file_ext = pathinfo($_FILES['skhun']['name'], PATHINFO_EXTENSION);
				$student_data['skhun'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
				move_uploaded_file($_FILES['skhun']['tmp_name'], 'uploads/registrations/' . $student_data['skhun']);

				$file_ext = pathinfo($_FILES['ijazah']['name'], PATHINFO_EXTENSION);
				$student_data['ijazah'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
				move_uploaded_file($_FILES['ijazah']['tmp_name'], 'uploads/registrations/' . $student_data['ijazah']);

				$file_ext = pathinfo($_FILES['rapor_semester']['name'], PATHINFO_EXTENSION);
				$student_data['rapor_semester'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
				move_uploaded_file($_FILES['rapor_semester']['tmp_name'], 'uploads/registrations/' . $student_data['rapor_semester']);

				$file_ext = pathinfo($_FILES['sertifikat_lainnya']['name'], PATHINFO_EXTENSION);
				if (!empty($file_ext)) {
					$student_data['sertifikat_lainnya'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
					move_uploaded_file($_FILES['sertifikat_lainnya']['tmp_name'], 'uploads/registrations/' . $student_data['sertifikat_lainnya']);
				} elseif (empty($file_ext)) {
					$student_data['sertifikat_lainnya'] = '0';
				}

				$file_ext = pathinfo($_FILES['dokumen_lainnya']['name'], PATHINFO_EXTENSION);
				if (!empty($file_ext)) {
					$student_data['dokumen_lainnya'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
					move_uploaded_file($_FILES['dokumen_lainnya']['tmp_name'], 'uploads/registrations/' . $student_data['dokumen_lainnya']);
				} elseif (empty($file_ext)) {
					$student_data['dokumen_lainnya'] = '0';
				}

				$this->db->insert('students', $student_data);
				$student_id = $this->db->insert_id();

				$history_data['ket'] = 'Insert data student';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$enroll_data['student_id'] = $student_id;
				$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
				$enroll_data['section_id'] = html_escape($this->input->post('section_id'));
				$enroll_data['room_id'] = html_escape($this->input->post('room_id'));
				$enroll_data['school_id'] = school_id();
				$enroll_data['session'] = active_session();
				$this->db->insert('enrols', $enroll_data);

				$history_data['ket'] = 'Insert data enrols';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$db2 = $this->load->database('database_sips', TRUE);

				$class_id = html_escape($this->input->post('class_id'));
				$section_id = html_escape($this->input->post('section_id'));

				$class_data = $this->db->get_where('classes', array('id' => $class_id))->row_array();
				$section_data = $this->db->get_where('sections', array('id' => $section_id))->row_array();

				$majorsquery = $db2->get_where('majors', array('majors_name' => $section_data['name']))->row_array();
				$classquery = $db2->get_where('class', array('class_name' => $class_data['name']))->row_array();

				$data_db2['class_class_id'] = $classquery['class_id'];
				$data_db2['majors_majors_id'] = $majorsquery['majors_id'];
				$data_db2['student_nisn'] = $this->input->post('nisn');
				$data_db2['student_nis'] = $this->input->post('nis');
				$data_db2['student_input_date'] = date('Y-m-d H:i:s');
				$data_db2['student_last_update'] = date('Y-m-d H:i:s');
				$data_db2['student_name_of_mother'] = strtoupper($this->input->post('parent_name'));
				$data_db2['student_name_of_father'] = strtoupper($this->input->post('parent_name'));
				$data_db2['student_address'] = $this->input->post('student_address');
				$data_db2['student_born_date'] = date('Y-m-d', strtotime($this->input->post('student_birthday')));
				$data_db2['student_born_place'] = $this->input->post('birthday_place');
				if ($this->input->post('student_gender') == "Male") {
					$data_db2['student_gender'] = "Laki-Laki";
				} else {
					$data_db2['student_gender'] = "Perempuan";
				};
				$data_db2['student_full_name'] = strtoupper($this->input->post('student_name'));
				$data_db2['student_password'] = sha1(date('dmy', strtotime($this->input->post('student_birthday'))));
				$data_db2['student_parent_phone'] = $this->input->post('student_phone');
				$db2->insert('student', $data_db2);

				$this->session->set_flashdata('flash_message', get_phrase('student_added_successfully'));
				redirect(site_url('superadmin/student'));
			} else {

				$this->session->set_flashdata('ajax_error_message', get_phrase('sorry_this_email_has_been_taken'));
				redirect(site_url('superadmin/student'));
			}
		}
		return json_encode($response);
	}

	public function bulk_student_create()
	{
		$duplication_counter = 0;
		$class_id = html_escape($this->input->post('class_id'));
		$section_id = html_escape($this->input->post('section_id'));
		$room_id = html_escape($this->input->post('room_id'));

		$parents_name = html_escape($this->input->post('parent_name'));
		$parents_email = html_escape($this->input->post('parent_email'));
		$parents_password = html_escape($this->input->post('parent_password'));
		$parents_gender = html_escape($this->input->post('parent_gender'));

		$data_parents = [];

		foreach ($parents_name as $key => $value) :
			// check email duplication
			$duplication_status = $this->check_duplication('on_create', $parents_email[$key]);
			if ($duplication_status) {
				$user_data['name'] = $parents_name[$key];
				$user_data['email'] = $parents_email[$key];
				$user_data['password'] = sha1($parents_password[$key]);
				$user_data['gender'] = $parents_gender[$key];
				$user_data['role'] = 'parent';
				$user_data['school_id'] = $this->school_id;
				$user_data['watch_history'] = '[]';
				$this->db->insert('users', $user_data);
				$user_id = $this->db->insert_id();

				$history_data['ket'] = 'Insert data user for parent';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$parent_data['user_id'] = $user_id;
				$parent_data['school_id'] = $this->school_id;
				$this->db->insert('parents', $parent_data);
				$data_parents[$key] = $this->db->insert_id();

				$history_data['ket'] = 'Insert data parent';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			} else {
				$duplication_counter++;
			}
		endforeach;

		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('some_of_the_emails_have_been_taken')
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('students_added_successfully')
			);
		}

		// $user_data = [];
		$students_name = html_escape($this->input->post('student_name'));
		$students_email = html_escape($this->input->post('student_email'));
		$students_password = html_escape($this->input->post('student_password'));
		$students_gender = html_escape($this->input->post('student_gender'));

		foreach ($students_name as $key => $value) :
			// check email duplication
			$duplication_status = $this->check_duplication('on_create', $students_email[$key]);
			$this->db->from('users');
			$this->db->where('role', 'student');
			$user_student = $this->db->count_all_results();
			if ($user_student > 500) {
				$response = array(
					'status' => true,
					'notification' => get_phrase('Data sudah mencapai Limit')
				);
			} elseif ($duplication_status) {
				$user_data['name'] = $students_name[$key];
				$user_data['email'] = $students_email[$key];
				$user_data['password'] = sha1($students_password[$key]);
				$user_data['gender'] = $students_gender[$key];
				$user_data['role'] = 'student';
				$user_data['school_id'] = $this->school_id;
				$user_data['watch_history'] = '[]';
				$this->db->insert('users', $user_data);
				$user_id = $this->db->insert_id();

				$history_data['ket'] = 'Insert data user for student';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$student_data['code'] = student_code();
				$student_data['user_id'] = $user_id;
				$student_data['parent_id'] = $data_parents[$key];
				// $student_data['parent_id'] = $this->get_user('email', $parents_email[$key])->id;
				$student_data['session'] = $this->active_session;
				$student_data['school_id'] = $this->school_id;
				$this->db->insert('students', $student_data);
				$student_id = $this->db->insert_id();

				$history_data['ket'] = 'Insert data user for student';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$enroll_data['student_id'] = $student_id;
				$enroll_data['class_id'] = $class_id;
				$enroll_data['section_id'] = $section_id;
				$enroll_data['room_id'] = $room_id;
				$enroll_data['session'] = $this->active_session;
				$enroll_data['school_id'] = $this->school_id;
				$this->db->insert('enrols', $enroll_data);

				$history_data['ket'] = 'Insert data enrols';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			} else {
				$duplication_counter++;
			}
		endforeach;

		if ($duplication_counter > 0) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('some_of_the_emails_have_been_taken')
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('students_added_successfully')
			);
		}

		return json_encode($response);
	}

	public function excel_create()
	{
		$class_id = html_escape($this->input->post('class_id'));
		$section_id = html_escape($this->input->post('section_id'));
		$school_id = $this->school_id;
		$session_id = $this->active_session;
		$role = 'student';

		$file_name = $_FILES['csv_file']['name'];
		move_uploaded_file($_FILES['csv_file']['tmp_name'], 'uploads/csv_file/student.generate.csv');

		if (($handle = fopen('uploads/csv_file/student.generate.csv', 'r')) !== FALSE) { // Check the resource is valid
			$count = 0;
			$duplication_counter = 0;
			while (($all_data = fgetcsv($handle, 1000, ",")) !== FALSE) { // Check opening the file is OK!
				if ($count > 0) {
					$user_data['name'] = html_escape($all_data[0]);
					$user_data['email'] = html_escape($all_data[1]);
					$user_data['password'] = sha1($all_data[2]);
					$user_data['phone'] = html_escape($all_data[3]);
					$user_data['gender'] = html_escape($all_data[5]);
					$user_data['role'] = $role;
					$user_data['school_id'] = $school_id;
					$user_data['watch_history'] = '[]';

					// check email duplication
					$duplication_status = $this->check_duplication('on_create', $user_data['email']);
					if ($duplication_status) {
						$this->db->insert('users', $user_data);
						$user_id = $this->db->insert_id();

						$history_data['ket'] = 'Insert data user for student';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);

						$student_data['code'] = student_code();
						$student_data['user_id'] = $user_id;
						$student_data['parent_id'] = html_escape($all_data[4]);
						$student_data['session'] = $session_id;
						$student_data['school_id'] = $school_id;
						$this->db->insert('students', $student_data);
						$student_id = $this->db->insert_id();

						$history_data['ket'] = 'Insert data parent';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);

						$enroll_data['student_id'] = $student_id;
						$enroll_data['class_id'] = $class_id;
						$enroll_data['section_id'] = $section_id;
						$enroll_data['session'] = $session_id;
						$enroll_data['school_id'] = $school_id;
						$this->db->insert('enrols', $enroll_data);

						$history_data['ket'] = 'Insert data enrols';
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
				'notification' => get_phrase('some_of_the_emails_have_been_taken')
			);
		} else {
			$response = array(
				'status' => true,
				'notification' => get_phrase('students_added_successfully')
			);
		}

		return json_encode($response);
	}

	public function excel_create_studentsonschool()
	{
		$school_id = $this->school_id;
		$session_id = $this->active_session;
		$role_student = 'student';
		$role_parent = 'parent';

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
					if (!empty($csv[10])) {

						$gender = '';
						switch (strtolower(trim($csv[16]))) {
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

						$parentdata['name'] = html_escape(trim($csv[11]));
						$parentdata['gender'] = $gender;
						$parentdata['blood_group'] = html_escape(trim($csv[17]));
						$parentdata['email'] = html_escape(trim($csv[12]));
						$parentdata['password'] = sha1(trim($csv[13]));
						$parentdata['address'] = html_escape(trim($csv[14]));
						$parentdata['phone'] = html_escape(trim($csv[15]));
						$parentdata['role'] = 'parent';
						$parentdata['school_id'] = $school_id;
						$parentdata['watch_history'] = '[]';

						$parentuserrow = $this->db->get_where('users', array('email' => $parentdata['email']))->row();
						if (empty($parentuserrow)) {
							$this->db->insert('users', $parentdata);
							$parentuserid = $this->db->insert_id();

							$history_data['ket'] = 'Insert data users for parent';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							$parent_data['user_id'] = $parentuserid;
							$parent_data['school_id'] = $school_id;
							$this->db->insert('parents', $parent_data);
							$parentid = $this->db->insert_id();

							$history_data['ket'] = 'Insert data parent';
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
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $parentdata['email'] = html_escape(trim($csv[8]))
							);
							fclose($handle);
						}
					}

					if (!empty($csv[0]) && !empty($csv[1])) {

						$gender_siswa = '';
						switch (strtolower(trim($csv[9]))) {
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

						$userdata['name'] = html_escape(trim($csv[1]));
						$userdata['gender'] = $gender_siswa;
						$userdata['blood_group'] = html_escape(trim($csv[10]));
						$userdata['email'] = html_escape(trim($csv[2]));
						$userdata['password'] = sha1(trim($csv[3]));
						$userdata['address'] = html_escape(trim($csv[7]));
						$userdata['phone'] = html_escape(trim($csv[8]));
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

							$history_data['ket'] = 'Insert data users for student';
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
							$this->db->insert('students', $student_data);
							$student_id = $this->db->insert_id();

							$history_data['ket'] = 'Insert data students';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);

							$enroll_data['student_id'] = $student_id;
							$enroll_data['session'] = $session_id;
							$enroll_data['school_id'] = $school_id;
							$kelas = strtolower(trim($csv[4]));
							$bagian = strtolower(trim($csv[5]));
							$ruang_kelas = strtolower(trim($csv[6]));

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

							$history_data['ket'] = 'Insert data enrols';
							$history_data['id_user'] = $this->session->set_userdata('user_id');
							$this->db->insert('history', $history_data);
						} else {
							// $last_student = $this->db->query('SELECT * FROM users ORDER BY id DESC LIMIT 1')->result_array();
							$response = array(
								'status' => true,
								'notification' => get_phrase('Part_of_the_data_is_not_processed_because_the_data_is_the_same_in_the = ') . $userdata['email'] = html_escape(trim($csv[1]))
							);
							fclose($handle);
						}
					}
				}
				$count++;
			}
		}
		fclose($handle);

		if (empty($response)) {
			$response = array(
				'status' => true,
				'notification' => get_phrase('successfully_entered_all_data')
			);
		}

		return json_encode($response);
	}

	public function student_update($student_id = '', $user_id = '')
	{
		$student_data['parent_id'] = $this->input->post('parent_id');
		$student_data['guardian_id'] = $this->input->post('guardian_id');
		$student_data['weight'] = $this->input->post('weight');
		$student_data['height'] = $this->input->post('height');
		$student_data['mileage'] = $this->input->post('mileage');
		$student_data['traveling_time'] = $this->input->post('traveling_time');
		$student_data['child_of'] = $this->input->post('child_of');
		$student_data['number_of_siblings'] = $this->input->post('number_of_siblings');
		$student_data['nisn'] = $this->input->post('nisn');
		$student_data['NIS'] = $this->input->post('nis');
		$student_data['nomor_ijazah'] = $this->input->post('nomor_ijazah');
		$student_data['nomor_skhun'] = $this->input->post('nomor_skhun');
		$student_data['school_before'] = $this->input->post('school_before');
		$student_data['nomor_un'] = $this->input->post('nomor_un');
		$student_data['nomor_kip'] = $this->input->post('nomor_kip');
		$student_data['va'] = $this->input->post('va');
		if (empty($student_data['nomor_kip'])) {
			$data['nomor_kip'] = '0';
		}

		$file_ext = pathinfo($_FILES['skhun']['name'], PATHINFO_EXTENSION);
		$student_data['skhun'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['skhun']['tmp_name'], 'uploads/registrations/' . $student_data['skhun']);

		$file_ext = pathinfo($_FILES['ijazah']['name'], PATHINFO_EXTENSION);
		$student_data['ijazah'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['ijazah']['tmp_name'], 'uploads/registrations/' . $student_data['ijazah']);

		$file_ext = pathinfo($_FILES['rapor_semester']['name'], PATHINFO_EXTENSION);
		$student_data['rapor_semester'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['rapor_semester']['tmp_name'], 'uploads/registrations/' . $student_data['rapor_semester']);

		$file_ext = pathinfo($_FILES['sertifikat_lainnya']['name'], PATHINFO_EXTENSION);
		$student_data['sertifikat_lainnya'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['sertifikat_lainnya']['tmp_name'], 'uploads/registrations/' . $student_data['sertifikat_lainnya']);

		$file_ext = pathinfo($_FILES['dokumen_lainnya']['name'], PATHINFO_EXTENSION);
		$student_data['dokumen_lainnya'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['dokumen_lainnya']['tmp_name'], 'uploads/registrations/' . $student_data['dokumen_lainnya']);

		$enroll_data['class_id'] = html_escape($this->input->post('class_id'));
		$enroll_data['section_id'] = html_escape($this->input->post('section_id'));
		$enroll_data['room_id'] = html_escape($this->input->post('room_id'));

		$classId = $this->input->post('class_id');
		$sectionId = $this->input->post('section_id');

		$user_data['name'] = $this->input->post('name');
		$user_data['email'] = $this->input->post('email');
		$user_data['birthday_place'] = $this->input->post('birthday_place');
		$user_data['birthday'] = $this->input->post('birthday');
		$user_data['gender'] = html_escape($this->input->post('gender'));
		$user_data['blood_group'] = html_escape($this->input->post('blood_group'));
		$user_data['address'] = $this->input->post('address');
		$user_data['province_id'] = html_escape($this->input->post('student_province_id'));
		$user_data['district_id'] = html_escape($this->input->post('student_district_id'));
		$user_data['districts_id'] = html_escape($this->input->post('student_districts_id'));
		$user_data['ward_id'] = html_escape($this->input->post('student_ward_id'));
		$user_data['nik'] = $this->input->post('nik');
		$user_data['religion'] = html_escape($this->input->post('religion'));
		$user_data['post_code'] = html_escape($this->input->post('student_postcode_id'));
		$user_data['phone'] = $this->input->post('phone');
		// Check Duplication
		$duplication_status = $this->check_duplication('on_update', $user_data['email'], $user_id);
		if ($duplication_status) {
			$this->db->where('id', $student_id);
			$this->db->update('students', $student_data);

			$history_data['ket'] = 'Update data students ' . $student_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$this->db->where('student_id', $student_id);
			$this->db->update('enrols', $enroll_data);

			$history_data['ket'] = 'Update data enrols student_id' . $student_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$this->db->where('id', $user_id);
			$this->db->update('users', $user_data);

			$history_data['ket'] = 'Update data users ' . $user_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$history_data['ket'] = 'Update data users ' . $user_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			$db2 = $this->load->database('database_sips', TRUE);
			$class_data = $this->db->get_where('classes', array('id' => $classId))->row_array();
			$section_data = $this->db->get_where('sections', array('id' => $sectionId))->row_array();
			$userData = $this->db->get_where('students', array('id' => $student_id))->row_array();
			$majorsquery = $db2->get_where('majors', array('majors_name' => $section_data['name']))->row_array();
			$classquery = $db2->get_where('class', array('class_name' => $class_data['name']))->row_array();

			$data_db2['student_nis'] = $this->input->post('nis');
			$data_db2['student_last_update'] = date('Y-m-d H:i:s');
			$data_db2['student_address'] = $this->input->post('address');
			$data_db2['student_nisn'] = $this->input->post('nisn');
			$data_db2['class_class_id'] = $classquery['class_id'];
			$data_db2['majors_majors_id'] = $majorsquery['majors_id'];
			$data_db2['student_full_name'] = strtoupper($this->input->post('name'));
			if (!empty($this->input->post('birthday'))) {
				$data_db2['student_born_date'] = $this->input->post('birthday');
			} else {
			}

			$db2->where('student_nis', $userData['NIS']);
			$db2->update('student', $data_db2);

			move_uploaded_file($_FILES['student_image']['tmp_name'], 'uploads/users/' . $user_id . '.jpg');

			// $response = array(
			// 	'status' => true,
			// 	'notification' => get_phrase('student_updated_successfully')
			// );
			$this->session->set_flashdata('flash_message', get_phrase('student_updated_successfully'));
			redirect(site_url('superadmin/student'));
		} else {
			// $response = array(
			// 	'status' => false,
			// 	'notification' => get_phrase('sorry_this_email_has_been_taken')
			// );
			$this->session->set_flashdata('ajax_error_message', get_phrase('gagal_update_data_karena_email_sama'));
			redirect(site_url('superadmin/student'));
		}

		// return json_encode($response);
		// return $this->load->view('backend/superadmin/student/list');
	}

	public function student_enrolment($section_id = "")
	{
		return $this->db->get_where('enrols', array('section_id' => $section_id, 'school_id' => $this->school_id, 'session' => $this->active_session));
	}


	// This function will help to fetch student data by section, class or student id
	public function get_student_details_by_id($type = "", $id = "")
	{
		$enrol_data = array();
		if ($type == "section") {
			$checker = array(
				'section_id' => $id,
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->result_array();
			foreach ($enrol_data as $key => $enrol) {
				$student_details = $this->db->get_where('students', array('id' => $enrol['student_id']))->row_array();
				$enrol_data[$key]['code'] = $student_details['code'];
				$enrol_data[$key]['user_id'] = $student_details['user_id'];
				$enrol_data[$key]['parent_id'] = $student_details['parent_id'];
				$enrol_data[$key]['nisn'] = $student_details['nisn'];
				$enrol_data[$key]['NIS'] = $student_details['NIS'];
				$enrol_data[$key]['weight'] = $student_details['weight'];
				$enrol_data[$key]['height'] = $student_details['height'];
				$enrol_data[$key]['mileage'] = $student_details['mileage'];
				$enrol_data[$key]['traveling_time'] = $student_details['traveling_time'];
				$enrol_data[$key]['child_of'] = $student_details['child_of'];
				$enrol_data[$key]['number_of_siblings'] = $student_details['number_of_siblings'];
				$enrol_data[$key]['nomor_ijazah'] = $student_details['nomor_ijazah'];
				$enrol_data[$key]['nomor_skhun'] = $student_details['nomor_skhun'];
				$enrol_data[$key]['school_before'] = $student_details['school_before'];
				$enrol_data[$key]['nomor_un'] = $student_details['nomor_un'];
				$enrol_data[$key]['skhun'] = $student_details['skhun'];
				$enrol_data[$key]['ijazah'] = $student_details['ijazah'];
				$enrol_data[$key]['rapor_semester'] = $student_details['rapor_semester'];
				$enrol_data[$key]['sertifikat_lainnya'] = $student_details['sertifikat_lainnya'];
				$enrol_data[$key]['dokumen_lainnya'] = $student_details['dokumen_lainnya'];
				$enrol_data[$key]['guardian_id'] = $student_details['guardian_id'];
				$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
				$enrol_data[$key]['name'] = $user_details['name'];
				$enrol_data[$key]['email'] = $user_details['email'];
				$enrol_data[$key]['role'] = $user_details['role'];
				$enrol_data[$key]['address'] = $user_details['address'];
				$enrol_data[$key]['province_id'] = $user_details['province_id'];
				$enrol_data[$key]['district_id'] = $user_details['district_id'];
				$enrol_data[$key]['districts_id'] = $user_details['districts_id'];
				$enrol_data[$key]['ward_id'] = $user_details['ward_id'];
				$enrol_data[$key]['post_code'] = $user_details['post_code'];
				$enrol_data[$key]['nik'] = $user_details['nik'];
				$enrol_data[$key]['religion'] = $user_details['religion'];
				$enrol_data[$key]['phone'] = $user_details['phone'];
				$enrol_data[$key]['birthday_place'] = $user_details['birthday_place'];
				$enrol_data[$key]['birthday'] = $user_details['birthday'];
				$enrol_data[$key]['gender'] = $user_details['gender'];
				$enrol_data[$key]['blood_group'] = $user_details['blood_group'];

				$class_details = $this->crud_model->get_class_details_by_id($enrol['class_id'])->row_array();
				$section_details = $this->crud_model->get_section_details_by_id('section', $enrol['section_id'])->row_array();

				$enrol_data[$key]['class_name'] = $class_details['name'];
				$enrol_data[$key]['section_name'] = $section_details['name'];
			}
		} elseif ($type == "class") {
			$checker = array(
				'class_id' => $id,
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->result_array();
			foreach ($enrol_data as $key => $enrol) {
				$student_details = $this->db->get_where('students', array('id' => $enrol['student_id']))->row_array();
				$enrol_data[$key]['code'] = $student_details['code'];
				$enrol_data[$key]['user_id'] = $student_details['user_id'];
				$enrol_data[$key]['parent_id'] = $student_details['parent_id'];
				$enrol_data[$key]['nisn'] = $student_details['nisn'];
				$enrol_data[$key]['NIS'] = $student_details['NIS'];
				$enrol_data[$key]['weight'] = $student_details['weight'];
				$enrol_data[$key]['height'] = $student_details['height'];
				$enrol_data[$key]['mileage'] = $student_details['mileage'];
				$enrol_data[$key]['traveling_time'] = $student_details['traveling_time'];
				$enrol_data[$key]['child_of'] = $student_details['child_of'];
				$enrol_data[$key]['number_of_siblings'] = $student_details['number_of_siblings'];
				$enrol_data[$key]['nomor_ijazah'] = $student_details['nomor_ijazah'];
				$enrol_data[$key]['nomor_skhun'] = $student_details['nomor_skhun'];
				$enrol_data[$key]['school_before'] = $student_details['school_before'];
				$enrol_data[$key]['nomor_un'] = $student_details['nomor_un'];
				$enrol_data[$key]['skhun'] = $student_details['skhun'];
				$enrol_data[$key]['ijazah'] = $student_details['ijazah'];
				$enrol_data[$key]['rapor_semester'] = $student_details['rapor_semester'];
				$enrol_data[$key]['sertifikat_lainnya'] = $student_details['sertifikat_lainnya'];
				$enrol_data[$key]['dokumen_lainnya'] = $student_details['dokumen_lainnya'];
				$enrol_data[$key]['guardian_id'] = $student_details['guardian_id'];
				$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
				$enrol_data[$key]['name'] = $user_details['name'];
				$enrol_data[$key]['email'] = $user_details['email'];
				$enrol_data[$key]['role'] = $user_details['role'];
				$enrol_data[$key]['address'] = $user_details['address'];
				$enrol_data[$key]['province_id'] = $user_details['province_id'];
				$enrol_data[$key]['district_id'] = $user_details['district_id'];
				$enrol_data[$key]['districts_id'] = $user_details['districts_id'];
				$enrol_data[$key]['ward_id'] = $user_details['ward_id'];
				$enrol_data[$key]['post_code'] = $user_details['post_code'];
				$enrol_data[$key]['nik'] = $user_details['nik'];
				$enrol_data[$key]['religion'] = $user_details['religion'];
				$enrol_data[$key]['phone'] = $user_details['phone'];
				$enrol_data[$key]['birthday_place'] = $user_details['birthday_place'];
				$enrol_data[$key]['birthday'] = $user_details['birthday'];
				$enrol_data[$key]['gender'] = $user_details['gender'];
				$enrol_data[$key]['blood_group'] = $user_details['blood_group'];

				$class_details = $this->crud_model->get_class_details_by_id($enrol['class_id'])->row_array();
				$section_details = $this->crud_model->get_section_details_by_id('section', $enrol['section_id'])->row_array();

				$enrol_data[$key]['class_name'] = $class_details['name'];
				$enrol_data[$key]['section_name'] = $section_details['name'];
			}
		} elseif ($type == "room") {
			$checker = array(
				'room_id' => $id,
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->row_array();
			$student_details = $this->db->get_where('students', array('id' => $enrol_data['student_id']))->row_array();
			$enrol_data['student_id'] = $student_details['id'];
			$enrol_data['code'] = $student_details['code'];
			$enrol_data['code'] = $student_details['code'];
			$enrol_data['user_id'] = $student_details['user_id'];
			$enrol_data['parent_id'] = $student_details['parent_id'];
			$enrol_data['nisn'] = $student_details['nisn'];
			$enrol_data['NIS'] = $student_details['NIS'];
			$enrol_data['weight'] = $student_details['weight'];
			$enrol_data['height'] = $student_details['height'];
			$enrol_data['mileage'] = $student_details['mileage'];
			$enrol_data['traveling_time'] = $student_details['traveling_time'];
			$enrol_data['child_of'] = $student_details['child_of'];
			$enrol_data['number_of_siblings'] = $student_details['number_of_siblings'];
			$enrol_data['nomor_ijazah'] = $student_details['nomor_ijazah'];
			$enrol_data['nomor_skhun'] = $student_details['nomor_skhun'];
			$enrol_data['school_before'] = $student_details['school_before'];
			$enrol_data['nomor_un'] = $student_details['nomor_un'];
			$enrol_data['skhun'] = $student_details['skhun'];
			$enrol_data['ijazah'] = $student_details['ijazah'];
			$enrol_data['rapor_semester'] = $student_details['rapor_semester'];
			$enrol_data['sertifikat_lainnya'] = $student_details['sertifikat_lainnya'];
			$enrol_data['dokumen_lainnya'] = $student_details['dokumen_lainnya'];
			$enrol_data['guardian_id'] = $student_details['guardian_id'];
			$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
			$enrol_data['name'] = $user_details['name'];
			$enrol_data['email'] = $user_details['email'];
			$enrol_data['role'] = $user_details['role'];
			$enrol_data['address'] = $user_details['address'];
			$enrol_data['nik'] = $user_details['nik'];
			$enrol_data['religion'] = $user_details['religion'];
			$enrol_data['province_id'] = $user_details['province_id'];
			$enrol_data['district_id'] = $user_details['district_id'];
			$enrol_data['districts_id'] = $user_details['districts_id'];
			$enrol_data['ward_id'] = $user_details['ward_id'];
			$enrol_data['post_code'] = $user_details['post_code'];
			$enrol_data['birthday_place'] = $user_details['birthday_place'];
			$enrol_data['phone'] = $user_details['phone'];
			$enrol_data['birthday'] = $user_details['birthday'];
			$enrol_data['gender'] = $user_details['gender'];
			$enrol_data['blood_group'] = $user_details['blood_group'];

			$class_details = $this->crud_model->get_class_details_by_id($enrol_data['class_id'])->row_array();
			$section_details = $this->crud_model->get_section_details_by_id('section', $enrol_data['section_id'])->row_array();
			$room_details = $this->db->get_where('class_rooms', $enrol_data['room_id'])->row_array();

			$enrol_data['class_name'] = $class_details['name'];
			$enrol_data['section_name'] = $section_details['name'];
			$enrol_data['room_name'] = $room_details['name'];
		} elseif ($type == "student") {
			$checker = array(
				'student_id' => $id,
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->row_array();
			$student_details = $this->db->get_where('students', array('id' => $enrol_data['student_id']))->row_array();
			$enrol_data['code'] = $student_details['code'];
			$enrol_data['user_id'] = $student_details['user_id'];
			$enrol_data['parent_id'] = $student_details['parent_id'];
			$enrol_data['nisn'] = $student_details['nisn'];
			$enrol_data['NIS'] = $student_details['NIS'];
			$enrol_data['weight'] = $student_details['weight'];
			$enrol_data['height'] = $student_details['height'];
			$enrol_data['mileage'] = $student_details['mileage'];
			$enrol_data['traveling_time'] = $student_details['traveling_time'];
			$enrol_data['child_of'] = $student_details['child_of'];
			$enrol_data['number_of_siblings'] = $student_details['number_of_siblings'];
			$enrol_data['nomor_ijazah'] = $student_details['nomor_ijazah'];
			$enrol_data['nomor_skhun'] = $student_details['nomor_skhun'];
			$enrol_data['school_before'] = $student_details['school_before'];
			$enrol_data['nomor_un'] = $student_details['nomor_un'];
			$enrol_data['skhun'] = $student_details['skhun'];
			$enrol_data['ijazah'] = $student_details['ijazah'];
			$enrol_data['rapor_semester'] = $student_details['rapor_semester'];
			$enrol_data['sertifikat_lainnya'] = $student_details['sertifikat_lainnya'];
			$enrol_data['dokumen_lainnya'] = $student_details['dokumen_lainnya'];
			$enrol_data['guardian_id'] = $student_details['guardian_id'];
			$enrol_data['va'] = $student_details['va'];
			$user_details = $this->db->get_where('users', array('id' => $student_details['user_id']))->row_array();
			$enrol_data['name'] = $user_details['name'];
			$enrol_data['email'] = $user_details['email'];
			$enrol_data['role'] = $user_details['role'];
			$enrol_data['address'] = $user_details['address'];
			$enrol_data['nik'] = $user_details['nik'];
			$enrol_data['religion'] = $user_details['religion'];
			$enrol_data['province_id'] = $user_details['province_id'];
			$enrol_data['district_id'] = $user_details['district_id'];
			$enrol_data['districts_id'] = $user_details['districts_id'];
			$enrol_data['ward_id'] = $user_details['ward_id'];
			$enrol_data['post_code'] = $user_details['post_code'];
			$enrol_data['birthday_place'] = $user_details['birthday_place'];
			$enrol_data['phone'] = $user_details['phone'];
			$enrol_data['birthday'] = $user_details['birthday'];
			$enrol_data['gender'] = $user_details['gender'];
			$enrol_data['blood_group'] = $user_details['blood_group'];

			$class_details = $this->crud_model->get_class_details_by_id($enrol_data['class_id'])->row_array();
			$section_details = $this->crud_model->get_section_details_by_id('section', $enrol_data['section_id'])->row_array();
			$room_details = $this->db->get_where('class_rooms', $enrol_data['room_id'])->row_array();

			$enrol_data['class_name'] = $class_details['name'];
			$enrol_data['section_name'] = $section_details['name'];
			$enrol_data['room_name'] = $room_details['name'];
		}
		return $enrol_data;
	}

	public function delete_one_student($parent_user_id, $student_parent_id, $student_id, $student_user_id)
	{
		$this->db->where('id', $student_id);
		$this->db->delete('students');

		$history_data['ket'] = 'Delete data students ' . $student_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('id', $student_parent_id);
		$this->db->delete('parents');

		$history_data['ket'] = 'Delete data parents ' . $student_parent_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		// $this->db->where('id', $student_parent_id);
		// $this->db->delete('parents');

		$this->db->where('student_id', $student_id);
		$this->db->delete('enrols');

		$history_data['ket'] = 'Delete data enrols ' . $student_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('id', $student_user_id);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $student_user_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$this->db->where('id', $parent_user_id);
		$this->db->delete('users');

		$history_data['ket'] = 'Delete data users ' . $parent_user_id . '';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		// $this->db->where('id', $parent_user_id);
		// $this->db->delete('users');

		$path = 'uploads/users/' . $student_user_id . '.jpg';
		if (file_exists($path)) {
			unlink($path);
		}

		$path = 'uploads/users/' . $parent_user_id . '.jpg';
		if (file_exists($path)) {
			unlink($path);
		}
		// $path = 'uploads/users/'.$parent_user_id.'.jpg';
		// if(file_exists($path)){
		// 	unlink($path);
		// }

		$response = array(
			'status' => true,
			'notification' => get_phrase('student_deleted_successfully')
		);
		return json_encode($response);
	}

	public function delete_student()
	{
		$enrolIds = $this->input->post('enrol_ids');

		if (empty($enrolIds)) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('please_select_students')
			);
			return json_encode($response);
		}

		if ($this->input->post('action') == 'delete_student') {
			foreach ($enrolIds as $enrolId) {
				$enrolData = $this->db->get_where('enrols', array('id' => $enrolId))->row_array();
				$studentData = $this->db->get_where('students', array('id' => $enrolData['student_id']))->row_array();
				$userData = $this->db->get_where('users', array('id' => $studentData['user_id']))->row_array();
				$parentData = $this->db->get_where('parents', array('id' => $studentData['parent_id']))->row_array();
				$student = 'student';
				$parent = 'parent';

				// Soft delete from enrols and student
				$this->db->where('id', $enrolId);
				$this->db->delete('enrols');

				$history_data['ket'] = 'Delete data enrols ' . $enrolId . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$this->db->where('id', $studentData['id']);
				$this->db->delete('students');

				$history_data['ket'] = 'Delete data students ' . $studentData['id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$this->db->where('student_id', $studentData['id']);
				$this->db->delete('marks');

				$history_data['ket'] = 'Delete data marks ' . $studentData['id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$this->db->where('student_id', $studentData['id']);
				$this->db->delete('daily_attendances');

				$history_data['ket'] = 'Delete data daily_attendances ' . $studentData['id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$this->db->where('id', $studentData['parent_id']);
				$this->db->delete('parents');

				$history_data['ket'] = 'Delete data parents ' . $studentData['parent_id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$this->db->where('id', $userData['id']);
				$this->db->where('role', $student);
				$this->db->delete('users');

				$history_data['ket'] = 'Delete data users ' . $userData['id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$this->db->where('id', $parentData['user_id']);
				$this->db->where('role', $parent);
				$this->db->delete('users');

				$history_data['ket'] = 'Delete data users ' . $parentData['user_id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('student_delete_successfully')
			);
		} else {
			echo get_phrase('not_found');
		}

		return json_encode($response);
	}

	public function update_status()
	{
		$enrolIds = $this->input->post('enrol_ids');
		$status = $this->input->post('status');
		$school_id	= school_id();
		$session_id	= active_session();

		if (empty($enrolIds)) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('please_select_students')
			);
			return json_encode($response);
		}

		if ($this->input->post('action') == 'delete_student') {
			foreach ($enrolIds as $enrolId) {
				if ($status == 'Removed') {
					$this->db->where('id', $enrolId);
					$this->db->delete('registrations');

					$history_data['ket'] = 'Delete data registrations ' . $enrolId . '';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				} else {
					$data['status']   = $status;

					$this->db->where('id', $enrolId);
					$this->db->update('registrations', $data);

					$history_data['ket'] = 'Update data registrations ' . $enrolId . '';
					$history_data['id_user'] = $this->session->set_userdata('user_id');
					$this->db->insert('history', $history_data);
				}
			}

			if ($status == "Accepted") {
				foreach ($enrolIds as $enrolId) {
					$check_data = $this->db->get_where('finances', array('registrations_id' => $enrolId));
					if ($check_data->num_rows() > 0) {
					} else {
						$registration_data = $this->db->get_where('registrations', array('id' => $enrolId))->row_array();

						$finances['registrations_kode'] = $registration_data['kode_registrasi'];
						$finances['registrations_name'] = $registration_data['nama_lengkap'];
						$finances['registrations_nisn'] = $registration_data['nisn'];
						$finances['registrations_id'] = $registration_data['id'];
						$finances['file'] = $registration_data['bukti_bayar'];
						$finances['school_id']	= $school_id;
						$finances['session_id']	= $session_id;
						$finances['date']		= strtotime(date('d-M-Y'));
						$finances['created_at']	= strtotime(date('d-M-Y'));
						$finances['status']		= 1;
						$this->db->insert('finances', $finances);

						$history_data['ket'] = 'Insert data finances';
						$history_data['id_user'] = $this->session->set_userdata('user_id');
						$this->db->insert('history', $history_data);
					}
				}
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('updated_successfully')
			);
		} else {
			echo get_phrase('not_found');
		}

		return json_encode($response);
	}

	public function move_students()
	{
		$enrolIds = $this->input->post('enrol_ids');

		if (empty($enrolIds)) {
			$response = array(
				'status' => false,
				'notification' => get_phrase('please_select_students')
			);
			return json_encode($response);
		}

		if ($this->input->post('action') == 'submit_alumni') {
			$classId = $this->input->post('class_id');
			$sectionId = $this->input->post('section_id');
			$roomId = $this->input->post('room_id');
			$sessionId = $this->input->post('session_id');

			if (empty($classId)) {
				$response = array(
					'status' => false,
					'notification' => get_phrase('please_select_the_fields')
				);
				return json_encode($response);
			}

			if (empty($sectionId)) {
				$response = array(
					'status' => false,
					'notification' => get_phrase('please_select_the_fields')
				);
				return json_encode($response);
			}

			if (empty($sessionId)) {
				$response = array(
					'status' => false,
					'notification' => get_phrase('please_select_the_fields')
				);
				return json_encode($response);
			}

			foreach ($enrolIds as $enrolId) {
				$enrolData = $this->db->get_where('enrols', array('id' => $enrolId))->row_array();
				$studentData = $this->db->get_where('students', array('id' => $enrolData['student_id']))->row_array();
				$userData = $this->db->get_where('users', array('id' => $studentData['user_id']))->row_array();

				$data['name'] = html_escape($userData['name']);
				$data['email'] = html_escape($userData['email']);
				$data['phone'] = html_escape($userData['phone']);
				$data['student_code'] = html_escape($studentData['code']);
				$data['session1'] = $sessionId;
				$data['session2'] = html_escape($studentData['session']);
				$data['class_id'] = $classId;
				$data['student_id'] = html_escape($enrolData['student_id']);
				$data['school_id'] = html_escape($studentData['school_id']);
				$data['created_at'] = strtotime(date('d-m-Y'));

				$data['file'] = $this->input->post('file');
				if (empty($data['file'])) {
					$data['file'] = '0';
				}

				$this->db->insert('alumni', $data);

				$history_data['ket'] = 'Insert data alumni';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				// Soft delete from enrols and student
				$this->db->set(array('class_id' => $classId, 'section_id' => $sectionId, 'room_id' => $roomId, 'session' => null));
				$this->db->where('id', $enrolId);
				$this->db->update('enrols');

				$history_data['ket'] = 'Update data enrols ' . $enrolId . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				//UPDATE PPDB SIPS
				$db2 = $this->load->database('database_sips', TRUE);

				$class_data = $this->db->get_where('classes', array('id' => $classId))->row_array();
				$section_data = $this->db->get_where('sections', array('id' => $sectionId))->row_array();

				$majorsquery = $db2->get_where('majors', array('majors_name' => $section_data['name']))->row_array();
				$classquery = $db2->get_where('class', array('class_name' => $class_data['name']))->row_array();

				$datadb2['class_class_id']   = $classquery['class_id'];
				$datadb2['majors_majors_id']   = $majorsquery['majors_id'];
				$datadb2['student_status']   = 0;
				// $db2->set('student_status', $null);
				// $db2->set(array('student_status'=> '0'));
				// $db2->where('student_full_name', strtoupper($userData['name']));
				$db2->where('student_nis', $studentData['NIS']);
				$db2->update('student', $datadb2);

				$data_students['session']   = NULL;
				// $this->db->set('session', $null);
				// $this->db->set(array('session'=> null));
				$this->db->where('id', $studentData['id']);
				$this->db->update('students', $data_students);

				$history_data['ket'] = 'Update data students ' . $studentData['id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$data_marks['session']   = NULL;
				// $this->db->set('session', $null);
				// $this->db->set(array('session'=> null));
				$this->db->where('student_id', $studentData['id']);
				$this->db->update('marks', $data_marks);

				$history_data['ket'] = 'Update data marks ' . $studentData['id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('alumni_added_successfully')
			);
		} else {
			$classId = $this->input->post('class_id');
			$sectionId = $this->input->post('section_id');
			$roomId = $this->input->post('room_id');
			$sessionId = $this->input->post('session_id');

			if (empty($classId)) {
				$response = array(
					'status' => false,
					'notification' => get_phrase('please_select_the_fields')
				);
				return json_encode($response);
			}

			if (empty($sectionId)) {
				$response = array(
					'status' => false,
					'notification' => get_phrase('please_select_the_fields')
				);
				return json_encode($response);
			}

			if (empty($sessionId)) {
				$response = array(
					'status' => false,
					'notification' => get_phrase('please_select_the_fields')
				);
				return json_encode($response);
			}

			if (empty($roomId)) {
				$response = array(
					'status' => false,
					'notification' => get_phrase('please_select_the_fields')
				);
				return json_encode($response);
			}

			$db2 = $this->load->database('database_sips', TRUE);

			$this->db->set(array('class_id' => $classId, 'section_id' => $sectionId, 'room_id' => $roomId, 'session' => $sessionId));
			$this->db->where_in('id', $enrolIds);
			$this->db->update('enrols');

			$history_data['ket'] = 'Update data enrols ' . $enrolIds . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			foreach ($enrolIds as $enrolId) {
				$enrolData = $this->db->get_where('enrols', array('id' => $enrolId))->row_array();
				$studentData = $this->db->get_where('students', array('id' => $enrolData['student_id']))->row_array();
				$userData = $this->db->get_where('users', array('id' => $studentData['user_id']))->row_array();

				$this->db->set('session', $sessionId);
				$this->db->where('id', $enrolData['student_id']);
				$this->db->update('students');

				$history_data['ket'] = 'Update data students ' . $enrolData['student_id'] . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$class_data = $this->db->get_where('classes', array('id' => $classId))->row_array();
				$section_data = $this->db->get_where('sections', array('id' => $sectionId))->row_array();

				$majorsquery = $db2->get_where('majors', array('majors_name' => $section_data['name']))->row_array();
				$classquery = $db2->get_where('class', array('class_name' => $class_data['name']))->row_array();

				$db2->set('class_class_id', $classquery['class_id']);
				$db2->set('majors_majors_id', $majorsquery['majors_id']);
				// $db2->where('student_full_name', strtoupper($userData['name']));
				$db2->where('student_nis', $studentData['NIS']);
				$db2->update('student');
			}

			$response = array(
				'status' => true,
				'notification' => get_phrase('student_moved_successfully')
			);
		}

		return json_encode($response);
	}
	//END STUDENT AND ADMISSION section


	//STUDENT OF EACH SESSION
	public function get_session_wise_student()
	{
		$checker = array(
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		return $this->db->get_where('enrols', $checker);
	}

	// Get User Image Starts
	public function get_user_image($user_id)
	{
		if (file_exists('uploads/users/' . $user_id . '.jpg'))
			return base_url() . 'uploads/users/' . $user_id . '.jpg';
		else
			return base_url() . 'uploads/users/placeholder.jpg';
	}
	// Get User Image Ends

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

	// Check job_management duplication
	public function check_job_duplication($user_id = "")
	{
		$duplicate_id_check = $this->db->get_where('job_management', array('user_id' => $user_id));

		if ($action == 'on_update') {
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
	//GET LOGGED IN USER DATA
	public function get_profile_data()
	{
		return $this->db->get_where('users', array('id' => $this->session->userdata('user_id')))->row_array();
	}

	public function update_profile()
	{
		$response = array();
		$user_id = $this->session->userdata('user_id');
		$data['name'] = $this->input->post('name');
		$data['email'] = $this->input->post('email');
		$data['phone'] = $this->input->post('phone');
		$data['address'] = $this->input->post('address');
		$data['nip'] = $this->input->post('nip');
		$data['npwp'] = $this->input->post('npwp');
		$data['status'] = $this->input->post('status');
		$data['nik'] = $this->input->post('nik');
		$data['gender'] = $this->input->post('gender');
		$data['religion'] = $this->input->post('religion');
		$data['birthday'] = $this->input->post('birthday');
		$data['province_id'] = $this->input->post('province_id');
		$data['district_id'] = $this->input->post('district_id');
		$data['districts_id'] = $this->input->post('districts_id');
		$data['ward_id'] = $this->input->post('ward_id');
		$data['post_code'] = $this->input->post('postcode_id');
		$data['blood_group'] = $this->input->post('blood_group');

		// Check Duplication
		$duplication_status = $this->check_duplication('on_update', $data['email'], $user_id);
		if ($duplication_status) {
			$this->db->where('id', $user_id);
			$this->db->update('users', $data);

			$history_data['ket'] = 'Update data users ' . $user_id . '';
			$history_data['id_user'] = $this->session->set_userdata('user_id');
			$this->db->insert('history', $history_data);

			move_uploaded_file($_FILES['profile_image']['tmp_name'], 'uploads/users/' . $user_id . '.jpg');

			$response = array(
				'status' => true,
				'notification' => get_phrase('profile_updated_successfully')
			);
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('sorry_this_email_has_been_taken')
			);
		}

		return json_encode($response);
	}

	public function update_password()
	{
		$user_id = $this->session->userdata('user_id');
		if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
			$user_details = $this->get_user_details($user_id);
			$current_password = $this->input->post('current_password');
			$new_password = $this->input->post('new_password');
			$confirm_password = $this->input->post('confirm_password');
			if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
				$data['password'] = sha1($new_password);
				$this->db->where('id', $user_id);
				$this->db->update('users', $data);

				$history_data['ket'] = 'Update data users ' . $user_id . '';
				$history_data['id_user'] = $this->session->set_userdata('user_id');
				$this->db->insert('history', $history_data);

				$response = array(
					'status' => true,
					'notification' => get_phrase('password_updated_successfully')
				);
			} else {

				$response = array(
					'status' => false,
					'notification' => get_phrase('mismatch_password')
				);
			}
		} else {
			$response = array(
				'status' => false,
				'notification' => get_phrase('password_can_not_be_empty')
			);
		}
		return json_encode($response);
	}

	//GET LOGGED IN USERS CLASS ID AND SECTION ID (FOR STUDENT LOGGED IN VIEW)
	public function get_logged_in_student_details()
	{
		$user_id = $this->session->userdata('user_id');
		$student_data = $this->db->get_where('students', array('user_id' => $user_id))->row_array();
		$student_details = $this->get_student_details_by_id('student', $student_data['id']);
		return $student_details;
	}

	// GET STUDENT LIST BY PARENT
	public function get_student_list_of_logged_in_parent()
	{
		$parent_id = $this->session->userdata('user_id');
		$parent_data = $this->db->get_where('parents', array('user_id' => $parent_id))->row_array();
		$checker = array(
			'parent_id' => $parent_data['id'],
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		$students = $this->db->get_where('students', $checker)->result_array();
		foreach ($students as $key => $student) {
			$checker = array(
				'student_id' => $student['id'],
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->row_array();

			$user_details = $this->db->get_where('users', array('id' => $student['user_id']))->row_array();
			$students[$key]['student_id'] = $student['id'];
			$students[$key]['name'] = $user_details['name'];
			$students[$key]['email'] = $user_details['email'];
			$students[$key]['role'] = $user_details['role'];
			$students[$key]['address'] = $user_details['address'];
			$students[$key]['phone'] = $user_details['phone'];
			$students[$key]['birthday'] = $user_details['birthday'];
			$students[$key]['gender'] = $user_details['gender'];
			$students[$key]['blood_group'] = $user_details['blood_group'];
			$students[$key]['class_id'] = $enrol_data['class_id'];
			$students[$key]['section_id'] = $enrol_data['section_id'];
			$students[$key]['parent_id'] = $parent_data['id'];

			$class_details = $this->crud_model->get_class_details_by_id($enrol_data['class_id'])->row_array();
			$section_details = $this->crud_model->get_section_details_by_id('section', $enrol_data['section_id'])->row_array();

			$students[$key]['class_name'] = $class_details['name'];
			$students[$key]['section_name'] = $section_details['name'];
		}
		return $students;
	}

	// In Array for associative array
	function is_in_array($associative_array = array(), $look_up_key = "", $look_up_value = "")
	{
		foreach ($associative_array as $associative) {
			$keys = array_keys($associative);
			for ($i = 0; $i < count($keys); $i++) {
				if ($keys[$i] == $look_up_key) {
					if ($associative[$look_up_key] == $look_up_value) {
						return true;
					}
				}
			}
		}
		return false;
	}

	function get_all_teachers($user_id = "")
	{
		if ($user_id > 0) {
			$this->db->where('id', $user_id);
		}

		$this->db->where('school_id', $this->school_id);
		$this->db->where("(role='superadmin' OR role='admin' OR role='teacher')");
		return $this->db->get_where('users');
	}

	public function get_students()
	{
		$checker = array(
			'school_id' => $this->school_id,
			// 'session' => $this->active_session,
			// 'role' => 'student'
		);
		return $this->db->get_where('students', $checker);
	}

	public function get_user_students()
	{
		return $this->db->get_where('users', array('role' => 'student', 'school_id' => school_id()));
	}

	function get_all_users($user_id = "")
	{
		if ($user_id > 0) {
			$this->db->where('id', $user_id);
		}

		$this->db->where('school_id', $this->school_id);
		return $this->db->get_where('users');
	}

	function is_homeroom($teacher_id, $section_id)
	{
		if (empty($teacher_id) || empty($section_id)) return false;
		$query = $this->db->get_where('teacher_permissions', array(
			'teacher_id' => $teacher_id,
			'section_id' => $section_id,
		))->row_array();

		if (empty($query)) return false;
		else return $query['homeroom'];
	}

	function get_logged_in_teacher_datas()
	{
		$user_id = $this->session->userdata('user_id');
		$teacher_data = $this->db->get_where('teachers', array('user_id' => $user_id))->row_array();
		return $teacher_data;
	}

	private function get_user($field, $value)
	{
		$field = $this->db->where($field, $value)->get('users')->row();

		if (!$field) {
			return false;
		}

		return $field;
	}

	// GET STUDENT LIST
	public function get_student_list()
	{
		$checker = array(
			'session' => $this->active_session,
			'school_id' => $this->school_id
		);
		$students = $this->db->get_where('students', $checker)->result_array();
		foreach ($students as $key => $student) {
			$checker = array(
				'student_id' => $student['id'],
				'session' => $this->active_session,
				'school_id' => $this->school_id
			);
			$enrol_data = $this->db->get_where('enrols', $checker)->row_array();

			$user_details = $this->db->get_where('users', array('id' => $student['user_id']))->row_array();
			$students[$key]['student_id'] = $student['id'];
			$students[$key]['name'] = $user_details['name'];
			$students[$key]['email'] = $user_details['email'];
			$students[$key]['role'] = $user_details['role'];
			$students[$key]['address'] = $user_details['address'];
			$students[$key]['phone'] = $user_details['phone'];
			$students[$key]['birthday'] = $user_details['birthday'];
			$students[$key]['gender'] = $user_details['gender'];
			$students[$key]['blood_group'] = $user_details['blood_group'];
			$students[$key]['class_id'] = $enrol_data['class_id'];
			$students[$key]['section_id'] = $enrol_data['section_id'];

			$class_details = $this->crud_model->get_class_details_by_id($enrol_data['class_id'])->row_array();
			$section_details = $this->crud_model->get_section_details_by_id('section', $enrol_data['section_id'])->row_array();

			$students[$key]['class_name'] = $class_details['name'];
			$students[$key]['section_name'] = $section_details['name'];
		}
		return $students;
	}

	public function update_internship_attendance()
	{
		$data['timestamp'] = strtotime($this->input->post('timestamp'));
		$data['internship_id'] = $this->input->post('internship_id');
		$data['student_id'] = $this->input->post('student_id');
		$data['status'] = $this->input->post('status');
		$data['session_id'] = $this->input->post('session_id');
		$data['school_id'] = $this->input->post('school_id');

		$file_ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$data['photo'] = md5(rand(10000000, 20000000)) . '.' . $file_ext;
		move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/internship_attendances/' . $data['file']);

		$this->db->insert('internship_attendances', $data);

		$history_data['ket'] = 'Insert data intern attendance';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('password_updated_successfully')
		);

		return json_encode($response);
	}
}
