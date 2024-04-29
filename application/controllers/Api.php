<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    require APPPATH . 'libraries/REST_Controller.php';
    
    class Api extends CI_Controller {
        function __construct() {
            // Construct the parent class
            parent::__construct();
            $this->load->database();
            $this->load->library('session');
        
            $this->load->helper('custom');
            $this->load->model('Crud_model', 'crud_model');
        }

        function employee() {
            $year_now = date('Y');
            $query = $this->db->query('SELECT users.certificate, users.name, users.role, users.address, users.email, users.birthday, users.remember_token, users.religion, users.phone, users.gender, users.nik, users.nip, users.npwp, departments.name as jabatan, employee_status.name as status_pegawai, job_management.start_date as tanggal_masuk, job_management.ptk_type, job_management.last_study, job_management.term_work FROM users LEFT JOIN employee_status ON employee_status.id=users.employee_status_id LEFT JOIN job_management ON job_management.user_id=users.id LEFT JOIN departments ON departments.id=users.department_id WHERE users.role ="teacher" OR users.role ="librarian" OR users.role ="other_employee" OR users.role ="accountant"')->result_array();
            $row= [];
            foreach($query as $data){
                $nip =  preg_replace("/[^0-9]/","",$data['nip']);
                $phone =  preg_replace("/[^0-9]/","",$data['phone']);
                $tahun_masuk = (date('Y', strtotime($data['tanggal_masuk'])));
                if($data['gender'] == 'Male'){
                    $gender = 'Pria';
                }else{
                    $gender = 'Wanita';
                }

                if ($data['ptk_type'] == '1') {
                    $ptk_type = 'Kepala Sekolah';
                }elseif($data['ptk_type'] == '2'){
                    $ptk_type = 'Wakil Kepala Sekolah';
                }elseif($data['ptk_type'] == '3'){
                    $ptk_type = 'Kepala TU';
                } else {
                    $ptk_type = NULL;
                }

                if ($data['last_study'] == '1') {
                    $last_study = 'SMA';
                }elseif($data['last_study'] == '2'){
                    $last_study = 'S1';
                }elseif($data['last_study'] == '3'){
                    $last_study = 'S2';
                } else {
                    $last_study = NULL;
                }
                
                if($data['role'] == 'teacher'){
                    $role = 'Pimpinan &amp; Guru';
                }elseif($data['role'] == 'librarian'){
                    $role = 'Tenaga Kependidikan';
                }elseif($data['role'] == 'other_employee'){
                    $role = 'Karyawan';
                }elseif($data['role'] == 'accountant'){
                    $role = 'Tenaga Kependidikan';
                }else{
                    $role = 'Karyawan';
                }
                
                if ($data['certificate'] == 'yes') {
                    $certificate = 'Sertifikasi';
                }elseif($data['certificate'] == 'no'){
                    $certificate = 'Non_sertifikasi';
                } else {
                    $certificate = NULL;
                }
                array_push($row, array('nama' => $data['name'], 'address' => $data['address'], 'email' => $data['email'], 'birthday' => $data['birthday'], 'religion' => $data['religion'], 'phone' => $phone, 'gender' => $gender, 'nik' => $data['nik'], 'nip' => $nip, 'npwp' => $data['npwp'], 'jenis_ptk' => $role, 'tugas_tambahan' => $data['jabatan'], 'status_pegawai' => $data['status_pegawai'], 'mulai_kerja' => $tahun_masuk, 'no_rek' => $data['remember_token'], 'sertifikasi' => $certificate, 'jabatan' => $ptk_type, 'pendidikan_terakhir' => $last_study, 'periode_jabatan' => $data['term_work']));
            }
            echo json_encode($row);
        }

        function department() {
		    $query = $this->db->query('SELECT name FROM departments')->result_array();
            echo json_encode($query);
        }

        function job_management() {
            $year_now = date('Y');
		    $query = $this->db->query('SELECT users.name, job_management.start_date as tanggal_masuk FROM job_management LEFT JOIN users ON job_management.user_id=users.id')->result_array();
            $row= [];
            foreach($query as $data){
                $tahun_masuk = (date('Y', strtotime($data['tanggal_masuk'])));
                $masa_kerja = $year_now-$tahun_masuk;
                array_push($row, array('masa_kerja' => $masa_kerja, 'nama' => $data['name']));
            }
            echo json_encode($row);
        }
    }
?>