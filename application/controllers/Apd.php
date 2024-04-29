<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/

require APPPATH.'third_party/phpoffice/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Apd extends CI_Controller {
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

		// CHECK WHETHER Apd IS LOGGED IN
		if($this->session->userdata('apd_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
	}

	// INDEX FUNCTION
	public function index(){
		redirect(site_url('apd/dashboard'), 'refresh');
	}

	//DASHBOARD
	public function dashboard(){
		$page_data['page_title'] = 'Dashboard';
		$page_data['folder_name'] = 'dashboard';
		$this->load->view('backend/index', $page_data);
	}

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
      } elseif ($param2 == 'installment') {
        $page_data['aria_expand'] = 'installment';
        $page_data['working_page'] = $action;
        $page_data['folder_name'] = 'registration';
        $page_data['page_title'] = 'ppdb';
        $this->load->view('backend/index', $page_data);
      } elseif ($param2 == 'installment_accepted') {
        $page_data['aria_expand'] = 'installment_accepted';
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
        $page_data['aria_expand'] = 'processed';
        $page_data['working_page'] = $action;
        $page_data['folder_name'] = 'registration';
        $page_data['page_title'] = 'ppdb';
        $this->load->view('backend/index', $page_data);
      }
    }

    if ($action == 'student_create') {
      $page_data['registration_paths'] = $this->db->get_where('registration_path')->result_array();
      $page_data['folder_name'] = 'registration';
      $page_data['page_name'] = 'single_student_admission';
      $page_data['page_title']  = get_phrase('form_registration');
      $this->load->view('backend/index', $page_data);
    }

    if($action == 'create_single_student'){
      $data['nik'] = html_escape($this->input->post('nik'));
		if(strlen($data['nik']) == 16){
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
	
			if($bulan >= 7){
			  $tahun = date('y')+1;
			  $data['kode_registrasi'] = $tahun."05".$nomor_urut;
			}else{
			  $tahun = date('y');
			  $data['kode_registrasi'] = $tahun."05".$nomor_urut;
			}
	
			$data['kategori_spp'] = 'Umum';
			$data['nilai_ranking'] = 0;
			$data['school_id'] = school_id();
	
			$this->db->insert('registrations', $data);
			
      $history_data['ket'] = 'Mengisi data ppdb';
      $history_data['id_user'] = $this->session->set_userdata('user_id');
      $this->db->insert('history', $history_data);
	      
			$this->session->set_flashdata('flash_message', get_phrase('student_added_successfully'));
      redirect(site_url('apd/registration/student_create'));
		}else{
      $this->session->set_flashdata('ajax_error_message', get_phrase('Panjang NIK salah, Harap dilengkapi'));
      redirect(site_url('apd/registration/student_create'));
		}
      // $response = $this->user_model->create_ppdb_registration();
      // echo $response;
    }

    if ($action == 'print_ppdb') {
      $page_data['ppdb_data'] = $this->db->get_where('registrations', array('id' => $param2))->row_array();
      $page_data['folder_name'] = 'registration';
      $page_data['page_name'] = 'print_ppdb';
      $page_data['page_title']  = 'ppdb_registration_data';
      $this->load->view('backend/index', $page_data);
    }

    if ($action == 'print_ppdb_v2') {
      $page_data['ppdb_data'] = $this->db->get_where('registrations', array('id' => $param2))->row_array();
      $page_data['folder_name'] = 'registration';
      $page_data['page_name'] = 'print_ppdb_v2';
      $page_data['page_title']  = 'ppdb_registration_data';
      $this->load->view('backend/index', $page_data);
    }

    if ($action == 'print_finance') {
      $page_data['ppdb_data'] = $this->db->get_where('registrations', array('id' => $param2))->row_array();
      $page_data['folder_name'] = 'registration';
      $page_data['page_name'] = 'ppdb_finance';
      $page_data['page_title']  = 'ppdb_finance_data';
      $this->load->view('backend/index', $page_data);
    }

    // update db
    if ($action == 'update') {
      $data['kategori_spp'] = $this->input->post('kategori_spp');
      $data['jurusan'] = $this->input->post('jurusan');
      $data['kode_registrasi'] = $this->input->post('kode_registrasi');
      $data['nik'] = $this->input->post('nik');
      $data['nama_lengkap'] = $this->input->post('nama_lengkap');
      $data['jenis_kelamin'] = $this->input->post('jenis_kelamin');
      $data['tgl_lahir'] = $this->input->post('tgl_lahir');
      $data['nisn'] = $this->input->post('nisn');
      $data['sekolah_asal'] = $this->input->post('sekolah_asal');
      $data['nama_orang_tua'] = $this->input->post('nama_orang_tua');
      $data['pekerjaan_orang_tua'] = $this->input->post('pekerjaan_orang_tua');
      $data['alamat'] = $this->input->post('alamat');
      $data['telephone'] = $this->input->post('telephone');
      $data['info_sekolah'] = $this->input->post('info_sekolah');
      $data['jalur_pendaftaran'] = $this->input->post('jalur_pendaftaran');
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

      $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
    }

    if ($action == 'update_payment_ppdb') {
      $payment_data = $this->db->get_where('payment_ppdb', array('id' => $param2))->row_array();
      $data['kode_registrasi'] = $payment_data['kode_registrasi'];
      $data['total_awal'] = $payment_data['total'];
      $data['total_akhir'] = $this->input->post('total');
      $data['datetime'] = date('d-m-Y H:i:s');
      $data['ket'] = ''.$this->session->userdata('user_id').' User melakukan perubahan nominal pembayaran PPDB Tanggal dan waktu '.date('d-m-Y H:i:s').'';
      $data['id_payment'] = $param2;
      $data['id_user'] = $this->session->userdata('user_id');
      $this->db->insert('payment_history', $data);
			
      $history_data['ket'] = 'Mengisi data payments';
      $history_data['id_user'] = $this->session->set_userdata('user_id');
      $this->db->insert('history', $history_data);

      $data_update['datetime'] = date('d-m-Y H:i:s');
      $data_update['total'] = $this->input->post('total');
      $this->db->where('id', $param2);
      $this->db->update('payment_ppdb', $data_update);

      $history_data['ket'] = 'Update data payment_ppdb '.$param2.'';
      $history_data['id_user'] = $this->session->set_userdata('user_id');
      $this->db->insert('history', $history_data);

      $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
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
			
        $history_data['ket'] = 'Mengisi data payments ppdb';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);
      }

      $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
      redirect(base_url()."apd/registration/create/");
    }

    if ($action == 'update_status') {
      $response = $this->user_model->update_status();
      $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
      redirect(site_url('apd/registration/create/'.$param2), 'refresh');
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
      return $this->load->view('backend/apd/registration/student_list');
    }

    if($action == 'refresh_bulk_student_admission') {
      return $this->load->view('backend/apd/registration/bulk_student_admission');
    }

    if($action == 'list') {
      $tanggal_awal = $this->input->get('date_from');
      $tanggal_akhir = $this->input->get('date_to');
      $page_data['date_from'] = date('Y-m-d', strtotime($tanggal_awal.' 00:00:00'));
      $page_data['date_to']   = date('Y-m-d', strtotime($tanggal_akhir.' 23:59:59'));
      $date_1 = date('Y-m-d', strtotime($tanggal_awal.' 00:00:00'));
      $date_2   = date('Y-m-d', strtotime($tanggal_akhir.' 23:59:59'));
      $page_data['payment_data'] = $this->db->get_where('payment_ppdb', array('date >=' => $date_1, 'date <=' => $date_2))->result_array();
      $this->load->view('backend/apd/registration/list', $page_data);
    }

    if($action == 'ppdb_report') {
      $page_data['page_name'] = 'financial_report';
      $page_data['folder_name'] = 'registration';
      $page_data['count_ppdb'] = $this->db->count_all('payment_ppdb');
      $page_data['page_title']  = 'LAPORAN KEUANGAN PPDB';
      $this->load->view('backend/index', $page_data);
    }

    if($action == 'financial_report') {
      $date_1 = $this->input->post('date_from');
      $date_2 = $this->input->post('date_to');
      $payment_ppdb = $this->db->get_where('payment_ppdb', array('date >=' => $date_1, 'date <=' => $date_2))->result_array();
      $spreadsheet = new Spreadsheet;
      $spreadsheet->setActiveSheetIndex(0)->mergeCells('A1:G1');
      $spreadsheet->setActiveSheetIndex(0)
                  ->setCellValue('A2', 'KODE REGISTRASI')
                  ->setCellValue('A1', 'LAPORAN KEUANGAN PPDB')
                  ->setCellValue('B2', 'NAMA')
                  ->setCellValue('C2', 'STATUS')
                  ->setCellValue('D2', 'TAGIHAN')
                  ->setCellValue('E2', 'BAYAR KE')
                  ->setCellValue('F2', 'TANGGAL')
                  ->setCellValue('G2', 'Rp');

      $kolom = 3;
      $nomor = 1;
      foreach($payment_ppdb as $row) {
      $pengguna = $this->db->get_where('registrations', array('id' => $row['kode_registrasi']))->row_array();
      $jalur = $this->db->get_where('registration_path', array('id' => $pengguna['jalur_pendaftaran']))->row_array();
      if ($pengguna['status'] == 'Not Yet Paid') {
        $status = 'Belum Bayar';
      } elseif ($pengguna['status'] == 'Not Selection') {
        $status = 'Belum Lulus Seleksi';
      } elseif ($pengguna['status'] == 'Processed') {
        $status = 'Diproses';
      }elseif ($pengguna['status'] == 'Accepted') {
        $status = 'Diterima';
      }elseif ($pengguna['status'] == 'Not Accepted') {
        $status = 'Tidak Diterima';
      }elseif ($pengguna['status'] == 'Removed') {
        $status = 'Mengundurkan Diri';
      }elseif ($pengguna['status'] == 'Installment') {
        $status = 'Inden_Angsur';
      }
          $spreadsheet->setActiveSheetIndex(0)
                      ->setCellValue('A' . $kolom, $pengguna['kode_registrasi'])
                      ->setCellValue('B' . $kolom, $pengguna['nama_lengkap'])
                      ->setCellValue('C' . $kolom, $status)
                      ->setCellValue('D' . $kolom, $jalur['total']);
          $spreadsheet->setActiveSheetIndex(0)
                      ->setCellValue('E' . $kolom, $row['ket'].'('.date('d M Y', strtotime($row['date'])).')'.' : '.currency( number_format($row['total'],0,",",".")))
                      ->setCellValue('F' . $kolom, date('d M Y', strtotime($row['date'])))
                      ->setCellValue('G' . $kolom, $row['total']);
          $kolom++;
          $nomor++;
      }
      $writer = new Xlsx($spreadsheet);

      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="LAPORAN KEUANGAN PPDB - '.date('d-M-Y').'.xlsx"');
      header('Cache-Control: max-age=0');

      $writer->save('php://output');
      exit();
    }

    if($action == 'financial_delete'){
      $response = $this->crud_model->financial_delete();
			echo $response;
    }
  }
  //END REGISTRATION section 

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
}
