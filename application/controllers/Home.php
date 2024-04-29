<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/

include '../helpers/camelcase_to_pascal.php';

class Home extends CI_Controller {
	protected $theme;
	protected $active_school_id;

	public function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->library('session');
		// load CI Upload Library
		$this->load->library('upload');

		/*LOADING ALL THE MODELS HERE*/
		$this->load->model('Crud_model',     'crud_model');
		$this->load->model('User_model',     'user_model');
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Payment_model',  'payment_model');
		$this->load->model('Email_model',    'email_model');
		$this->load->model('Addon_model',    'addon_model');
		$this->load->model('Frontend_model', 'frontend_model');

		if (addon_status('alumni')) {
			$this->load->model('addons/Alumni_model','alumni_model');
		}
		/*cache control*/
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");

		/*SET DEFAULT TIMEZONE*/
		timezone();

		$this->theme = get_frontend_settings('theme');
		$this->active_school_id = $this->frontend_model->get_active_school_id();

		// load custom helper
		$this->load->helper('custom_helper');
	}

	// INDEX FUNCTION
	// default function
	public function index() {
		$page_data['page_name']  = 'home';
		$page_data['page_title'] = get_phrase('home');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//REGISTRATION PAGE
	function registration($param1 = "", $param2 = "") {
		$page_data['page_name']  = $param1 === 'success' ? 'registration_success' : 'registration';
		$page_data['page_title'] = get_phrase('registration');
		$page_data['data'] = $this->db->get_where('registrations', array('kode_registrasi' => $param2))->row_array();

		if (!empty($_POST)) {
			$this->registration_post_form();
		} else {
			$this->load->view('frontend/alanwar/index', $page_data);	
		}
	}

	function simple_registration($param1 = "", $param2 = "") {
		if($param1 == 'error'){
			$page_data['page_name'] = 'simple_registration';
			$page_data['page_title'] = get_phrase('registration');	
			$page_data['error']['Pendaftaran Gagal ! Karena Tidak Menyetujui kententuan - ketentuan PPDB'] = $this->upload->display_errors();
			return $this->load->view('frontend/alanwar/index', $page_data);
		}else{
			$page_data['page_name']  = $param1 === 'success' ? 'simple_registration_success' : 'simple_registration';
			$page_data['page_title'] = get_phrase('registration');
			$page_data['data'] = $this->db->get_where('registrations', array('kode_registrasi' => $param2))->row_array();

			if (!empty($_POST)) {
				$this->simple_registration_post_form();
			} else {
				$this->load->view('frontend/alanwar/index', $page_data);	
			}
		}
	}

	// function submit registration form to db
	function simple_registration_post_form() {
		$page_data['page_name'] = 'simple_registration';
		$page_data['page_title'] = get_phrase('registration');	

		// add POSt to data[]
		foreach ($_POST as $key => $val) {
			if ($_POST[$key] !== '') {
				$name = camelcase_to_pascal($key);
				$data[$name] = html_escape($this->input->post($key));
			}
		}

		if (strlen($data['nik']) == 16) {
			$page_data['data'] = $data;
		} else {
			$page_data['error']['Panjang NIK salah, Harap dilengkapi'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);
		}

		if ($data['nama_lengkap'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['jenis_kelamin'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['tempat_lahir'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['tgl_lahir'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['alamat'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['pekerjaan_orang_tua'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['nama_orang_tua'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['telephone'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['info_sekolah'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['jalur_pendaftaran'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['sekolah_asal'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['nisn'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);

		}else if($data['jurusan'] == NULL) {
			$page_data['error']['Lengkapi data yang kosong !'] = $this->upload->display_errors();
			$page_data['data'] = $data;
			return $this->load->view('frontend/alanwar/index', $page_data);
					
		} else {
			$page_data['data'] = $data;
		}

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

		if($bulan >= 7){
		  $tahun = date('y')+1;
		  $data['kode_registrasi'] = $tahun."05".$nomor_urut;
		}else{
		  $tahun = date('y');
		  $data['kode_registrasi'] = $tahun."05".$nomor_urut;
		}
		
		$data['status'] = 'Not Yet Paid';
		$data['kategori_spp'] = 'Umum';
		$data['nilai_ranking'] = 0;
		$data['school_id'] = school_id();

		$this->db->insert('registrations', $data);
		$registration_id = $this->db->insert_id();
			
		$history_data['ket'] = 'Mengisi data ppdb';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$registration_data = $this->db->get_where('registrations', array('id' => $registration_id))->row_array();
		
		$page_data['data'] = $data;
		$page_data['success'] = TRUE;
		return $this->load->view('frontend/alanwar/index', $page_data);
  	}

  	function edit_simple_registration($param1 = "", $param2 = "") {
		$page_data['page_name']  = $param1 === 'success' ? 'simple_edit_success' : 'edit_ppdb';
		$page_data['page_title'] = get_phrase('registration');
		$page_data['data'] = $this->db->get_where('registrations', array('kode_registrasi' => $param2))->row_array();

		if (!empty($_POST)) {
			$this->edit_simple_registration_post_form();
		} else {
			$this->load->view('frontend/alanwar/index', $page_data);	
		}
	}

	function edit_ppdb($param1 = ""){
		foreach ($_POST as $key => $val) {
			if ($_POST[$key] !== '') {
				$name = camelcase_to_pascal($key);
				$data_update[$name] = html_escape($this->input->post($key));
			}
		}

		if (strlen($this->input->post('nik')) == 16) {
		} else {
			$page_data['error']['Panjang NIK salah, Harap dilengkapi'] = $this->upload->display_errors();
			
			return $this->load->view('frontend/alanwar/index', $page_data);
		}

		if (!empty($this->input->post('ket'))) {
		} else {
			$page_data['error']['Syarat Dan Ketentuan belum di setujui !'] = $this->upload->display_errors();
			return $this->load->view('frontend/alanwar/index', $page_data);
		}
		
		$this->db->where('id', $param1);
		$this->db->update('registrations', $data_update);

		$history_data['ket'] = 'Update data registrations '.$param1.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);
		
		$page_data['page_name'] = 'edit_simple_registration';
		$page_data['page_title'] = get_phrase('registration');
		$registration_data = $this->db->get_where('registrations', array('id' => $param1))->row_array();
		$page_data['data'] = $registration_data;
		$page_data['success'] = TRUE;
		return $this->load->view('frontend/alanwar/index', $page_data);
	}

	// function submit registration form to db
	function edit_simple_registration_post_form($param1 = "") {
		$page_data['page_name'] = 'edit_simple_registration';
		$page_data['page_title'] = get_phrase('registration');
		$registration_data = $this->db->get_where('registrations', array('id' => $param1))->row_array();
		
		$page_data['data'] = $registration_data;
		return $this->load->view('frontend/alanwar/index', $page_data);
	}

	// function submit registration form to db
  function registration_post_form() {
		$page_data['page_name'] = 'registration';
		$page_data['page_title'] = get_phrase('registration');	

		// add POSt to data[]
		foreach ($_POST as $key => $val) {
			if ($_POST[$key] !== '') {
				$name = camelcase_to_pascal($key);
				$data[$name] = html_escape($this->input->post($key));
			}
		}

		// cek email student
		$field_email_check = [
			'emailSiswa',
			'emailOrangTua'
		];

		foreach ($field_email_check as $field) {
			$field_name = camelcase_to_pascal($field);
			$email = html_escape($this->input->post($field));

			$query = $this->db->get_where('users', array('email' => $email));
			if ($query->num_rows() >= 1) {
				$page_data['error'][$field_name.'_exist'] = get_phrase($field_name.'_already_exist');
				$page_data['data'] = $data;
				return $this->load->view('frontend/alanwar/index', $page_data);
			}

			$query = $this->db->get_where('registrations', array($field_name => $email));
			if ($query->num_rows() >= 1) {
				$page_data['error'][$field_name.'_exist'] = get_phrase($field_name.'_already_exist');
				$page_data['data'] = $data;
				return $this->load->view('frontend/alanwar/index', $page_data);
			}
		}

		// TODO: upload file
		$wali = [
			'namaWali',
			'emailWali',
			'tglLahirWali',
			'pendidikanWali',
			'keadaanWali',
			'pekerjaanWali',
			'penghasilanWali',
			'alamatWali'
		];

		// foreach ($wali as $file) {
		// 	$field_name = camelcase_to_pascal($file);

			if(empty($wali)){
				$page_data['data'] = 0;
			} else {
				$file_data = $this->upload->data();
				$page_data['data'] = $data;
			}
		// }
		$nilai = [
			'sekolahAsal',
			'alamatSekolahAsal',
			'noPesertaUjian',
			'noSeriIjazah',
			'tahunKelulusan',
			'nilaiBhsIndo',
			'nilaiBhsInggris',
			'nilaiMatematika',
			'nilaiIpa'
		];

		// foreach ($wali as $file) {
		// 	$field_name = camelcase_to_pascal($file);

			if(empty($nilai)){
				$page_data['data'] = 0;
			} else {
				$file_data = $this->upload->data();
				$page_data['data'] = $data;
			}

		// TODO: upload file
		$field_upload_file = [
			// 'skhun',
			// 'fotoSiswa',
			// 'ijazah',
			// 'raporSemester',
			'sertifikatLainnya',
			'dokumenLainnya'
		];

		foreach ($field_upload_file as $file) {
			$field_name = camelcase_to_pascal($file);

			if (!$this->upload->do_upload($file)) {
				// $page_data['error']['upload_'.$field_name] = $this->upload->display_errors();
				$page_data['data'] = 0;
				// return $this->load->view('frontend/'.$this->theme.'/index', $page_data);
			} else {
				$file_data = $this->upload->data();
				$data[$field_name] = $file_data['file_name'];
			}
		}

		// TODO: upload file
		$field_upload_files = [
			'skhun',
			'fotoSiswa',
			'ijazah',
			'raporSemester'
			// 'sertifikatLainnya',
			// 'dokumenLainnya'
		];

		foreach ($field_upload_files as $file) {
			$field_name = camelcase_to_pascal($file);

			if (!$this->upload->do_upload($file)) {
				$page_data['error']['upload_'.$field_name] = $this->upload->display_errors();
				$page_data['data'] = $data;
				return $this->load->view('frontend/alanwar/index', $page_data);
			} else {
				$file_data = $this->upload->data();
				$data[$field_name] = $file_data['file_name'];
			}
		}

		// TODO: generate kode registrasi
		$school_id = school_id();
		$this->db->select("kode_registrasi, tgl_daftar");
		$this->db->where("school_id", $school_id);
		$this->db->order_by("id", "DESC");
		$this->db->limit(1);
		$kode_sebelumnya = $this->db->get('registrations')->row_array();
		$kode_urut_terakhir = substr($kode_sebelumnya['kode_registrasi'], -4);
		$tahun_sebelumnya = date('Y', strtotime($kode_sebelumnya['tgl_daftar']));
		$nomor_urut = "0000";

		if ($tahun_sebelumnya == date('Y')) {
			$nomor_urut = sprintf('%04d', (int)$kode_urut_terakhir + 1);
		} else {
			$nomor_urut = sprintf('%04d', 1);
		}
		
		$data['kode_registrasi'] = "2305".$nomor_urut;
		$data['status'] = 'Not Selection';
		$data['nilai_ranking'] = 0;

		// echo "<pre>".print_r($data, true)."</pre>";
		// echo count($data);

		$this->db->insert('registrations', $data);
			
		$history_data['ket'] = 'Mengisi data ppdb';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$page_data['data'] = $data;
		$page_data['success'] = TRUE;
		return $this->load->view('frontend/alanwar/index', $page_data);
    // exit;
  }

  	//JOB FAIR PAGE
	function job_fair($param1 = "") {
		$page_data['page_name']  = 'job_fair';
		$page_data['page_title'] = get_phrase('job_fair');
		$page_data['job_fairs'] = $this->db->get_where('job_fairs')->result_array();

		$this->load->view('frontend/alanwar/index', $page_data);
	}

	//SEARCH PAGE
	function search($param1 = "") {
		$page_data['page_name']  = 'search';
		$page_data['page_title'] = get_phrase('search');
		$page_data['data'] = $this->db->get_where('registrations', array('kode_registrasi' => $param1))->row_array();

		$this->load->view('frontend/alanwar/index', $page_data);
	}

	function search_post_form() {
		$page_data['page_name']  = 'search';
		$page_data['page_title'] = get_phrase('search');
		$page_data['data'] = $this->db->get_where('registrations', array('kode_registrasi' => html_escape($this->input->post('kodeRegistrasi'))))->row_array();
		
		$this->load->view('frontend/alanwar/index', $page_data);
	}

	function registration_pay() {
		$page_data['page_name'] = 'search';
		$page_data['page_title'] = get_phrase('search');

		$data['kode_registrasi'] = html_escape($this->input->post('kodeRegistrasi'));

		if (!$this->upload->do_upload('buktiBayar')) {
			$page_data['error']['upload_bukti_bayar'] = $this->upload->display_errors();
			return $this->load->view('frontend/alanwar/index', $page_data);
		} else {
			$file_data = $this->upload->data();
			$data['bukti_bayar'] = $file_data['file_name'];
			$data['status'] = 'Processed';
		}

		// update
		$this->db->where('kode_registrasi', $data['kode_registrasi']);
		$this->db->update('registrations', $data);

		$history_data['ket'] = 'Update data registrations '.$data['kode_registrasi'].'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$page_data['data'] = $this->db->get_where('registrations', array('kode_registrasi' => html_escape($this->input->post('kodeRegistrasi'))))->row_array();
		$page_data['payment_success'] = get_phrase('payment_success');
		$this->load->view('frontend/alanwar/index', $page_data);
	}

	function print_ppdb($param1 = "") {
		$page_data['page_name']  = 'print_ppdb';
		$page_data['page_title'] = get_phrase('print_registration_data');
		$page_data['ppdb_data'] = $this->db->get_where('registrations', array('id' => $param1))->row_array();
		$this->load->view('frontend/alanwar/print_ppdb', $page_data);
	}

	function print_ppdb_v2($param1 = "") {
		$page_data['page_name']  = 'print_ppdb_v2';
		$page_data['page_title'] = get_phrase('print_registration_data');
		$page_data['ppdb_data'] = $this->db->get_where('registrations', array('id' => $param1))->row_array();
		$this->load->view('frontend/alanwar/print_ppdb_v2', $page_data);
	}

	function registration_cancel($param1 = '', $param2 = '', $param3 = '') {

		if ($param1 == 'check') {
			// check nama orang tua
			$result = $this->db
				->where('nama_orang_tua', $param2)
				->where('kode_registrasi', $param3)
				->get('registrations')
				->result();

				// print("<pre>".print_r($result,true)."</pre>");
			
			if (count($result[0]) == 1) {
				$data['results'] = $result[0];
				echo json_encode($data["results"]);
			}
			return;
		}

		$data['status'] = 'DICABUT';

		$this->db->where('kode_registrasi', $param1);
		$this->db->update('registrations', $data);

		$history_data['ket'] = 'Update data registrations '.$param1.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$page_data['page_name'] = 'search';
		$page_data['page_title'] = get_phrase('search');
		$page_data['registration_cancel'] = get_phrase('registration_cancel');
		$this->load->view('frontend/alanwar/index', $page_data);
	}

	//ABOUT PAGE
	function about() {
		$page_data['page_name']  = 'about';
		$page_data['page_title'] = get_phrase('about_us');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//New_flash PAGE
	function news_flash1() {
		$page_data['page_title'] = get_phrase('news_flash');
		$this->load->view('frontend/'.$this->theme.'/news_flash1', $page_data);
	}

	function news_flash2() {
		$page_data['page_title'] = get_phrase('news_flash');
		$this->load->view('frontend/'.$this->theme.'/news_flash2', $page_data);
	}

	function news_flash3() {
		$page_data['page_title'] = get_phrase('news_flash');
		$this->load->view('frontend/'.$this->theme.'/news_flash3', $page_data);
	}

	// TEACHERS PAGE
	function teachers() {
		$count_teachers = $this->db->get_where('users', array('role' => 'teacher', 'school_id' => $this->active_school_id))->num_rows();
		$config = array();
		$config = manager($count_teachers, 9);
		$config['base_url']  = site_url('home/teachers/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'teacher';
		$page_data['page_title'] = get_phrase('teachers');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

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
		  $this->load->view('backend/superadmin/event_calendar/list');
		}
	
		if(empty($param1)){
		  $page_data['folder_name'] = 'event_calendar';
		  $page_data['page_title'] = 'event_calendar';
		  $this->load->view('backend/index', $page_data);
		}
	  }
	  //END EVENT CALENDAR section

	// EVENTS GETTING
	function events() {
		$count_events = $this->db->get_where('frontend_events', array('status' => 1, 'school_id' => $this->active_school_id))->num_rows();
		$config = array();
		$config = manager($count_events, 8);
		$config['base_url']  = site_url('home/events/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'event';
		$page_data['page_title'] = get_phrase('event_list');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	// SCHOOL WISE GALLERY
	function gallery() {
		$count_gallery = $this->db->get_where('frontend_gallery', array('show_on_website' => 1, 'school_id' => $this->active_school_id))->num_rows();
		$config = array();
		$config = manager($count_gallery, 6);
		$config['base_url']  = site_url('home/gallery/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'gallery';
		$page_data['page_title'] = get_phrase('gallery');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	// GALLERY DETAILS
	function gallery_view($gallery_id = '') {
		$count_images = $this->db->get_where('frontend_gallery_image', array(
			'frontend_gallery_id' => $gallery_id
		))->num_rows();
		$config = array();
		$config = manager($count_images, 9);
		$config['base_url']  = site_url('home/gallery_view/'.$gallery_id.'/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['gallery_id']  = $gallery_id;
		$page_data['page_name']  = 'gallery_view';
		$page_data['page_title'] = get_phrase('gallery');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE CONTACT PAGE
	function contact($param1 = '') {

		if ($param1 == 'send') {
			if(!$this->crud_model->check_recaptcha() && get_common_settings('recaptcha_status') == true){
				redirect(site_url('home/contact'), 'refresh');
			}
			$this->frontend_model->send_contact_message();
			redirect(site_url('home/contact'), 'refresh');
		}
		$page_data['page_name']  = 'contact';
		$page_data['page_title'] = get_phrase('contact_us');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE PRIVACY POLICY PAGE
	function privacy_policy() {
		$page_data['page_name']  = 'privacy_policy';
		$page_data['page_title'] = get_phrase('privacy_policy');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE TERMS AND CONDITION PAGE
	function terms_conditions() {
		$page_data['page_name']  = 'terms_conditions';
		$page_data['page_title'] = get_phrase('terms_and_conditions');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	//GET THE ALLUMNI EVENT PAGE IF THE ADDON IS ENABLED
	function alumni_event() {
		if (addon_status('alumni')) {
			$page_data['page_name']  = 'alumni_event';
			$page_data['page_title'] = get_phrase('alumni_event');
			$this->load->view('frontend/'.$this->theme.'/index', $page_data);
		}else{
			redirect(site_url(), 'refresh');
		}
	}

	//GET THE ALLUMNI GALLERY PAGE IF THE ADDON IS ENABLED
	function alumni_gallery() {
		if (addon_status('alumni')) {
			$page_data['page_name']  = 'alumni_gallery';
			$page_data['page_title'] = get_phrase('alumni_gallery');
			$this->load->view('frontend/'.$this->theme.'/index', $page_data);
		}else{
			redirect(site_url(), 'refresh');
		}
	}

	//GET THE ALLUMNI GALLERY DETAILS
	function alumni_gallery_view($gallery_id = '') {
		if (addon_status('alumni')) {
			$count_images = $this->db->get_where('alumni_gallery_photos', array(
				'gallery_id' => $gallery_id
			))->num_rows();
			$config = array();
			$config = manager($count_images, 9);
			$config['base_url']  = site_url('home/alumni_gallery_view/'.$gallery_id.'/');
			$this->pagination->initialize($config);

			$page_data['per_page']    = $config['per_page'];
			$page_data['gallery_id']  = $gallery_id;
			$page_data['page_name']  = 'alumni_gallery_view';
			$page_data['page_title'] = get_phrase('alumni_gallery');
			$this->load->view('frontend/'.$this->theme.'/index', $page_data);
		}else{
			redirect(site_url(), 'refresh');
		}
	}

	// NOTICEBOARD
	function noticeboard() {
		$count_notice = $this->db->get_where('noticeboard', array('show_on_website' => 1, 'school_id' => $this->active_school_id, 'session' => active_session()))->num_rows();
		$config = array();
		$config = manager($count_notice, 9);
		$config['base_url']  = site_url('home/noticeboard/');
		$this->pagination->initialize($config);

		$page_data['per_page']    = $config['per_page'];
		$page_data['page_name']  = 'noticeboard';
		$page_data['page_title'] = get_phrase('noticeboard');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

	function notice_details($notice_id = '') {
		$page_data['notice_id'] = $notice_id;
		$page_data['page_name']  = 'notice_details';
		$page_data['page_title'] = get_phrase('notice_details');
		$this->load->view('frontend/'.$this->theme.'/index', $page_data);
	}

























	// ACTIVE SCHOOL ID FOR FRONTEND
	function active_school_id_for_frontend($active_school_id) {
		if (addon_status('multi-school')) {
			$this->session->set_userdata('active_school_id', $active_school_id);
		}else{
			$active_school_id = get_settings('school_id');
			$this->session->set_userdata('active_school_id', $active_school_id);
		}
	}
}
