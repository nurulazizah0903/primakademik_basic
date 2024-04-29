<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// class Finance extends REST_Controller {
class Finance extends CI_Controller {    
    
    public function __construct()
    {
        parent::__construct();

		$this->load->database();
        $this->load->library('session');
        
        $this->load->helper('custom');
        $this->load->model('Crud_model', 'crud_model');
    }

    public function virtual_account() {
        // buat test di lokal
        // $results = curl_get("localhost/project/akademik/api/Finance/send");
        
        // buat lihat hasil test
        // // echo json_encode(json_decode($this->input->raw_input_stream, true));
        // // die();
        // $result = json_decode($results, true)['result'][0];

        $result = json_decode($this->input->raw_input_stream, true)['result'][0];        

        // $check = true; // method cek nomor VA
        $check = $this->crud_model->check_va($result['va']);
        if (!$check) {
            echo json_encode([
                "responCode" => "01",
                "responDeskripsi" => "VA Tidak Ditemukan"
            ]);
            return;
        }

        $data = [
            'namasantri' => $result['namaSantri'],
            'va' => $result['va'],
            'tanggaltransaksi' => $result['tanggalTransaksi'],
            'codeproduk' => $result['codeProduk'],
            'nominal' => $result['nominal'],
        ];

        $insert = $this->crud_model->create_finance_va($data); // method insert database;

        if (!$insert) {
            echo json_encode([
                "responCode" => "02",
                "responDeskripsi" => "Gagal Insert Data",
                "trxid" => json_decode($results, true)['id']
            ]);
        } else {
            echo json_encode([
                "responCode" => "00",
                "responDeskripsi" => "Sukses"
            ]);
        }
        return;
    }

    function send() {
        $array = [
            "jsonrpc" => "2.0",
            "id" => 10,
            "result" => [
                [
                    "namaSantri" => "ADIF PRANOTO",
                    "va" => "122",
                    "tanggalTransaksi" => "2021-12-30",
                    "codeProduk" => "001",
                    "nominal" => 40000
                ]
            ]
        ];
        echo json_encode($array);
    }
}