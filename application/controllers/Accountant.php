<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/

require APPPATH.'third_party/phpoffice/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Accountant extends CI_Controller {
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

		// CHECK WHETHER Accountant IS LOGGED IN
		if($this->session->userdata('accountant_login') != 1){
			redirect(site_url('login'), 'refresh');
		}
	}

	// INDEX FUNCTION
	public function index(){
		redirect(site_url('accountant/dashboard'), 'refresh');
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
			
      $history_data['ket'] = 'Mengisi data regisrations';
      $history_data['id_user'] = $this->session->set_userdata('user_id');
      $this->db->insert('history', $history_data);
	      
			$this->session->set_flashdata('flash_message', get_phrase('student_added_successfully'));
      redirect(site_url('accountant/registration/student_create'));
		}else{
      $this->session->set_flashdata('ajax_error_message', get_phrase('Panjang NIK salah, Harap dilengkapi'));
      redirect(site_url('accountant/registration/student_create'));
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
			
        $history_data['ket'] = 'Mengisi data payments ppdb';
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
			
        $history_data['ket'] = 'Mengisi data paymentt_ppdb';
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
      }

      $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
      redirect(base_url()."accountant/registration/create/");
    }

    if ($action == 'update_status') {
      $response = $this->user_model->update_status();
      $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
      redirect(site_url('accountant/registration/create/'.$param2), 'refresh');
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
      return $this->load->view('backend/accountant/registration/student_list');
    }

    if($action == 'refresh_bulk_student_admission') {
      return $this->load->view('backend/accountant/registration/bulk_student_admission');
    }

    if($action == 'list') {
      $tanggal_awal = $this->input->get('date_from');
      $tanggal_akhir = $this->input->get('date_to');
      $page_data['date_from'] = date('Y-m-d', strtotime($tanggal_awal.' 00:00:00'));
      $page_data['date_to']   = date('Y-m-d', strtotime($tanggal_akhir.' 23:59:59'));
      $date_1 = date('Y-m-d', strtotime($tanggal_awal.' 00:00:00'));
      $date_2   = date('Y-m-d', strtotime($tanggal_akhir.' 23:59:59'));
      $page_data['payment_data'] = $this->db->get_where('payment_ppdb', array('date >=' => $date_1, 'date <=' => $date_2))->result_array();
      $this->load->view('backend/accountant/registration/list', $page_data);
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

  public function export_ppdb($param1 = ""){
       $semua_pengguna = $this->db->get_where('registrations', array('status' => urldecode($param1)))->result_array();
       $spreadsheet = new Spreadsheet;

       $spreadsheet->setActiveSheetIndex(0)
                   ->setCellValue('A1', 'No')
                   ->setCellValue('B1', 'Kode Registrasi')
                   ->setCellValue('C1', 'NIK')
                   ->setCellValue('D1', 'Nama Siswa')
                   ->setCellValue('E1', 'Jenis Kelamin')
                   ->setCellValue('F1', 'Tempat Lahir')
                   ->setCellValue('G1', 'Tanggal Lahir')
                   ->setCellValue('H1', 'NISN')
                   ->setCellValue('I1', 'Sekolah Asal')
                   ->setCellValue('J1', 'Jurusan Yang dipilih')
                   ->setCellValue('K1', 'Nama Orang Tua')
                   ->setCellValue('L1', 'Pekerjaan Orang Tua')
                   ->setCellValue('M1', 'Alamat')
                   ->setCellValue('N1', 'No Telepon')
                   ->setCellValue('O1', 'Info Sekolah Dari')
                   ->setCellValue('P1', 'Jalur Pendaftaran')
                   ->setCellValue('Q1', 'Kategori SPP');

       $kolom = 2;
       $nomor = 1;
       foreach($semua_pengguna as $pengguna) {
        $jalur = $this->db->get_where('registration_path', array('id' => $pengguna['jalur_pendaftaran']))->row_array();

            $spreadsheet->setActiveSheetIndex(0)
                        ->setCellValue('A' . $kolom, $nomor)
                        ->setCellValue('B' . $kolom, $pengguna['kode_registrasi'])
                        ->setCellValue('C' . $kolom, $pengguna['nik'])
                        ->setCellValue('D' . $kolom, $pengguna['nama_lengkap'])
                        ->setCellValue('E' . $kolom, $pengguna['jenis_kelamin'])
                        ->setCellValue('F' . $kolom, $pengguna['tempat_lahir'])
                        ->setCellValue('G' . $kolom, $pengguna['tgl_lahir'])
                        ->setCellValue('H' . $kolom, $pengguna['nisn'])
                        ->setCellValue('I' . $kolom, $pengguna['sekolah_asal'])
                        ->setCellValue('J' . $kolom, $pengguna['jurusan'])
                        ->setCellValue('K' . $kolom, $pengguna['nama_orang_tua'])
                        ->setCellValue('L' . $kolom, $pengguna['pekerjaan_orang_tua'])
                        ->setCellValue('M' . $kolom, $pengguna['alamat'])
                        ->setCellValue('N' . $kolom, $pengguna['telephone'])
                        ->setCellValue('O' . $kolom, $pengguna['info_sekolah'])
                        ->setCellValue('P' . $kolom, $jalur['name'])
                        ->setCellValue('Q' . $kolom, $pengguna['kategori_spp']);

            $kolom++;
            $nomor++;

       }

       $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="PPDB - '. get_phrase(urldecode($param1)).' - '.date('d-M-Y').'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
  }

  public function export_multimedia($param1 = ""){
    $semua_pengguna = $this->db->get_where('registrations', array('status' => urldecode($param1),'jurusan' => 'Multimedia'))->result_array();
    $spreadsheet = new Spreadsheet;

    $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'No')
                ->setCellValue('B1', 'Kode Registrasi')
                ->setCellValue('C1', 'NIK')
                ->setCellValue('D1', 'Nama Siswa')
                ->setCellValue('E1', 'Jenis Kelamin')
                ->setCellValue('F1', 'Tempat Lahir')
                ->setCellValue('G1', 'Tanggal Lahir')
                ->setCellValue('H1', 'NISN')
                ->setCellValue('I1', 'Sekolah Asal')
                ->setCellValue('J1', 'Jurusan Yang dipilih')
                ->setCellValue('K1', 'Nama Orang Tua')
                ->setCellValue('L1', 'Pekerjaan Orang Tua')
                ->setCellValue('M1', 'Alamat')
                ->setCellValue('N1', 'No Telepon')
                ->setCellValue('O1', 'Info Sekolah Dari')
                ->setCellValue('P1', 'Jalur Pendaftaran')
                ->setCellValue('Q1', 'Kategori SPP');

    $kolom = 2;
    $nomor = 1;
    foreach($semua_pengguna as $pengguna) {
     $jalur = $this->db->get_where('registration_path', array('id' => $pengguna['jalur_pendaftaran']))->row_array();

         $spreadsheet->setActiveSheetIndex(0)
                     ->setCellValue('A' . $kolom, $nomor)
                     ->setCellValue('B' . $kolom, $pengguna['kode_registrasi'])
                     ->setCellValue('C' . $kolom, $pengguna['nik'])
                     ->setCellValue('D' . $kolom, $pengguna['nama_lengkap'])
                     ->setCellValue('E' . $kolom, $pengguna['jenis_kelamin'])
                     ->setCellValue('F' . $kolom, $pengguna['tempat_lahir'])
                     ->setCellValue('G' . $kolom, $pengguna['tgl_lahir'])
                     ->setCellValue('H' . $kolom, $pengguna['nisn'])
                     ->setCellValue('I' . $kolom, $pengguna['sekolah_asal'])
                     ->setCellValue('J' . $kolom, $pengguna['jurusan'])
                     ->setCellValue('K' . $kolom, $pengguna['nama_orang_tua'])
                     ->setCellValue('L' . $kolom, $pengguna['pekerjaan_orang_tua'])
                     ->setCellValue('M' . $kolom, $pengguna['alamat'])
                     ->setCellValue('N' . $kolom, $pengguna['telephone'])
                     ->setCellValue('O' . $kolom, $pengguna['info_sekolah'])
                     ->setCellValue('P' . $kolom, $jalur['name'])
                     ->setCellValue('Q' . $kolom, $pengguna['kategori_spp']);

         $kolom++;
         $nomor++;

    }

    $writer = new Xlsx($spreadsheet);

     header('Content-Type: application/vnd.ms-excel');
     header('Content-Disposition: attachment;filename="PPDB Jurusan Multimedia- '. get_phrase(urldecode($param1)).' - '.date('d-M-Y').'.xlsx"');
     header('Cache-Control: max-age=0');

     $writer->save('php://output');
  }

  public function export_akuntansi($param1 = ""){
    $semua_pengguna = $this->db->get_where('registrations', array('status' => urldecode($param1),'jurusan' => 'Akuntansi'))->result_array();
    $spreadsheet = new Spreadsheet;

    $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'No')
                ->setCellValue('B1', 'Kode Registrasi')
                ->setCellValue('C1', 'NIK')
                ->setCellValue('D1', 'Nama Siswa')
                ->setCellValue('E1', 'Jenis Kelamin')
                ->setCellValue('F1', 'Tempat Lahir')
                ->setCellValue('G1', 'Tanggal Lahir')
                ->setCellValue('H1', 'NISN')
                ->setCellValue('I1', 'Sekolah Asal')
                ->setCellValue('J1', 'Jurusan Yang dipilih')
                ->setCellValue('K1', 'Nama Orang Tua')
                ->setCellValue('L1', 'Pekerjaan Orang Tua')
                ->setCellValue('M1', 'Alamat')
                ->setCellValue('N1', 'No Telepon')
                ->setCellValue('O1', 'Info Sekolah Dari')
                ->setCellValue('P1', 'Jalur Pendaftaran')
                ->setCellValue('Q1', 'Kategori SPP');

    $kolom = 2;
    $nomor = 1;
    foreach($semua_pengguna as $pengguna) {
     $jalur = $this->db->get_where('registration_path', array('id' => $pengguna['jalur_pendaftaran']))->row_array();

         $spreadsheet->setActiveSheetIndex(0)
                     ->setCellValue('A' . $kolom, $nomor)
                     ->setCellValue('B' . $kolom, $pengguna['kode_registrasi'])
                     ->setCellValue('C' . $kolom, $pengguna['nik'])
                     ->setCellValue('D' . $kolom, $pengguna['nama_lengkap'])
                     ->setCellValue('E' . $kolom, $pengguna['jenis_kelamin'])
                     ->setCellValue('F' . $kolom, $pengguna['tempat_lahir'])
                     ->setCellValue('G' . $kolom, $pengguna['tgl_lahir'])
                     ->setCellValue('H' . $kolom, $pengguna['nisn'])
                     ->setCellValue('I' . $kolom, $pengguna['sekolah_asal'])
                     ->setCellValue('J' . $kolom, $pengguna['jurusan'])
                     ->setCellValue('K' . $kolom, $pengguna['nama_orang_tua'])
                     ->setCellValue('L' . $kolom, $pengguna['pekerjaan_orang_tua'])
                     ->setCellValue('M' . $kolom, $pengguna['alamat'])
                     ->setCellValue('N' . $kolom, $pengguna['telephone'])
                     ->setCellValue('O' . $kolom, $pengguna['info_sekolah'])
                     ->setCellValue('P' . $kolom, $jalur['name'])
                     ->setCellValue('Q' . $kolom, $pengguna['kategori_spp']);

         $kolom++;
         $nomor++;

    }

    $writer = new Xlsx($spreadsheet);

     header('Content-Type: application/vnd.ms-excel');
     header('Content-Disposition: attachment;filename="PPDB Jurusan Akuntansi- '. get_phrase(urldecode($param1)).' - '.date('d-M-Y').'.xlsx"');
     header('Cache-Control: max-age=0');

     $writer->save('php://output');
  }

  public function export_ap($param1 = ""){
    $semua_pengguna = $this->db->get_where('registrations', array('status' => urldecode($param1),'jurusan' => 'Administrasi Perkantoran'))->result_array();
    $spreadsheet = new Spreadsheet;

    $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'No')
                ->setCellValue('B1', 'Kode Registrasi')
                ->setCellValue('C1', 'NIK')
                ->setCellValue('D1', 'Nama Siswa')
                ->setCellValue('E1', 'Jenis Kelamin')
                ->setCellValue('F1', 'Tempat Lahir')
                ->setCellValue('G1', 'Tanggal Lahir')
                ->setCellValue('H1', 'NISN')
                ->setCellValue('I1', 'Sekolah Asal')
                ->setCellValue('J1', 'Jurusan Yang dipilih')
                ->setCellValue('K1', 'Nama Orang Tua')
                ->setCellValue('L1', 'Pekerjaan Orang Tua')
                ->setCellValue('M1', 'Alamat')
                ->setCellValue('N1', 'No Telepon')
                ->setCellValue('O1', 'Info Sekolah Dari')
                ->setCellValue('P1', 'Jalur Pendaftaran')
                ->setCellValue('Q1', 'Kategori SPP');

    $kolom = 2;
    $nomor = 1;
    foreach($semua_pengguna as $pengguna) {
     $jalur = $this->db->get_where('registration_path', array('id' => $pengguna['jalur_pendaftaran']))->row_array();

         $spreadsheet->setActiveSheetIndex(0)
                     ->setCellValue('A' . $kolom, $nomor)
                     ->setCellValue('B' . $kolom, $pengguna['kode_registrasi'])
                     ->setCellValue('C' . $kolom, $pengguna['nik'])
                     ->setCellValue('D' . $kolom, $pengguna['nama_lengkap'])
                     ->setCellValue('E' . $kolom, $pengguna['jenis_kelamin'])
                     ->setCellValue('F' . $kolom, $pengguna['tempat_lahir'])
                     ->setCellValue('G' . $kolom, $pengguna['tgl_lahir'])
                     ->setCellValue('H' . $kolom, $pengguna['nisn'])
                     ->setCellValue('I' . $kolom, $pengguna['sekolah_asal'])
                     ->setCellValue('J' . $kolom, $pengguna['jurusan'])
                     ->setCellValue('K' . $kolom, $pengguna['nama_orang_tua'])
                     ->setCellValue('L' . $kolom, $pengguna['pekerjaan_orang_tua'])
                     ->setCellValue('M' . $kolom, $pengguna['alamat'])
                     ->setCellValue('N' . $kolom, $pengguna['telephone'])
                     ->setCellValue('O' . $kolom, $pengguna['info_sekolah'])
                     ->setCellValue('P' . $kolom, $jalur['name'])
                     ->setCellValue('Q' . $kolom, $pengguna['kategori_spp']);

         $kolom++;
         $nomor++;

    }

    $writer = new Xlsx($spreadsheet);

     header('Content-Type: application/vnd.ms-excel');
     header('Content-Disposition: attachment;filename="PPDB Jurusan Administrasi Perkantoran- '. get_phrase(urldecode($param1)).' - '.date('d-M-Y').'.xlsx"');
     header('Cache-Control: max-age=0');

     $writer->save('php://output');
  }

	//	SECTION STARTED
	public function section($action = "", $id = "") {

		// PROVIDE A LIST OF SECTION ACCORDING TO CLASS ID
		if ($action == 'list') {
			$page_data['class_id'] = $id;
			$this->load->view('backend/accountant/section/list', $page_data);
		}
	}
	//	SECTION ENDED

  //	district STARTED
	public function district_dropdown($action = "", $province_id = "", $user_id = "") {

		// PROVIDE A LIST OF district ACCORDING TO province_id ID
		if ($action == 'dropdown') {
		  $page_data['province_id'] = $province_id;
		  $this->load->view('backend/accountant/district/dropdown', $page_data);
		}
	
		if ($action == 'edit') {
		  $page_data['user_id'] = $user_id;
		  $this->load->view('backend/accountant/district/dropdown_edit', $page_data);
		}
	  }
	  //	district ENDED
	
	  //	districts STARTED
	  public function districts_dropdown($action = "", $district_id = "") {
	
		// PROVIDE A LIST OF districts ACCORDING TO district_id ID
		if ($action == 'dropdown') {
		  $page_data['district_id'] = $district_id;
		  $this->load->view('backend/accountant/districts/dropdown', $page_data);
		}
	  }
	  //	districts ENDED
	
	  //	ward STARTED
	  public function ward_dropdown($action = "", $districts_id = "") {
	
		// PROVIDE A LIST OF ward ACCORDING TO districts_id ID
		if ($action == 'dropdown') {
		  $page_data['districts_id'] = $districts_id;
		  $this->load->view('backend/accountant/ward/dropdown', $page_data);
		}
	  }
	  //	ward ENDED
	
	  //	postcode STARTED
	  public function postcode_dropdown($action = "", $districts_id = "") {
	
		// PROVIDE A LIST OF district ACCORDING TO districts_id ID
		if ($action == 'dropdown') {
		  $page_data['districts_id'] = $districts_id;
		  $this->load->view('backend/accountant/postcode/dropdown', $page_data);
		}
	  }
	  //	postcode ENDED

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
      $this->load->view('backend/accountant/payment_type/list');
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
      $this->load->view('backend/accountant/account/list');
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
      $this->load->view('backend/accountant/student/dropdown', $page_data);
    } 
	
	// Get the list of student. Here param2 defines roomID
	if ($param1 == 'student_finance') {
      $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
      $this->load->view('backend/accountant/student/dropdown_finance', $page_data);
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
      $this->load->view('backend/accountant/invoice/list', $page_data);
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

          $history_data['ket'] = 'Update data invoces '.$invoice['id'].'';
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
			
            $history_data['ket'] = 'Mengisi data jounal';
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
		$this->load->view('backend/accountant/invoice/dropdown_month', $page_data);
    }
	
	// For recurring
    if ($param1 == 'recurring') {  			
		$page_data['kategori'] = $this->input->get('kategori');
		$page_data['label'] = $param2;  
		$this->load->view('backend/accountant/invoice/dropdown_recurring', $page_data);
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
      $this->load->view('backend/accountant/student/dropdown', $page_data);
    } 
	
    if ($param1 == 'student_finance') {
        $page_data['enrolments'] = $this->user_model->get_student_details_by_id('section', $param2);
        $this->load->view('backend/accountant/student/dropdown_finance', $page_data);
    } 
    
    if ($param1 == 'invoice') { 
      $page_data['invoices'] = $this->crud_model->get_invoices($param2)->result();  		  
      $this->load->view('backend/accountant/finance/dropdown', $page_data);
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
      $this->load->view('backend/accountant/finance/list', $page_data);
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
      $this->load->view('backend/accountant/student/dropdown', $page_data);
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
      $this->load->view('backend/accountant/finance/list', $page_data);
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
      $this->load->view('backend/accountant/expense_category/list');
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
      $this->load->view('backend/accountant/expense/list', $page_data);
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
      $this->load->view('backend/accountant/expense/list', $page_data);
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
      $this->load->view('backend/accountant/journal_in/list', $page_data);
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
      $this->load->view('backend/accountant/journal_out/list', $page_data);
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
			$this->load->view('backend/accountant/partner_ledger/list', $page_data);
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
      $html = $this->load->view('backend/accountant/invoice/export',$page_data, true);

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
	// ACCOUNTING SECTION ENDS

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

  //finance_odoo LIST MANAGER
	public function finance_odoo($param1 = "", $param2 = "", $param3 = '') {
	
		// showing the list of finance_odoo
		if ($param1 == 'list') {
		  $page_data['nama_siswa'] = $param2;
		  $this->load->view('backend/accountant/finance_odoo/list', $page_data);
		}
	
		// showing the index file
		if(empty($param1)){
		  $page_data['folder_name'] = 'finance_odoo';
		  $page_data['page_title']  = 'finance_odoo';
		  $this->load->view('backend/index', $page_data);
		}
	  }
}
