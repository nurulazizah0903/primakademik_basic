<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
*  @author   : Nurul Azizah
*  https://www.linkedin.com/in/nurul-azizah-661320243
*/

class Multischool_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function school_create()
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['npsn'] = html_escape($this->input->post('npsn'));
		$data['nss'] = html_escape($this->input->post('nss'));
		$data['longitudinal'] = html_escape($this->input->post('longitudinal'));
		$data['address'] = html_escape($this->input->post('address'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$this->db->insert('schools', $data);
		$school_id = $this->db->insert_id();

		$history_data['ket'] = 'Insert data school';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

		$data_accounts = array(
					array(
						'code' => '11110001',
						'name' => 'Kas',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11110010',
						'name' => 'Kas Kecil',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11110020',
						'name' => 'Kas Belum Disetor',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11120001',
						'name' => 'Bank',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11120010',
						'name' => 'Mandiri Personal',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11120020',
						'name' => 'Mandiri Bisnis',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11120030',
						'name' => 'Muamalat',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11120040',
						'name' => 'BNI',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11120050',
						'name' => 'BCA',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11120060',
						'name' => 'BNI Giro',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11120070',
						'name' => 'Mandiri Giro',
						'type' => 'Bank dan Kas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11210010',
						'name' => 'Piutang Usaha',
						'type' => 'Piutang',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11210011',
						'name' => 'Piutang Siswa',
						'type' => 'Piutang',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11210011',
						'name' => 'Piutang Usaha (PoS)',
						'type' => 'Piutang',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11210020',
						'name' => 'Piutang Karyawan',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300010',
						'name' => 'Persediaan Daging',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300020',
						'name' => 'Persediaan Ikan',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300030',
						'name' => 'Persediaan Sayuran',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300040',
						'name' => 'Persediaan Keringan',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300050',
						'name' => 'Persediaan Buah',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300060',
						'name' => 'Persediaan Fresh Drink',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300070',
						'name' => 'Persediaan Rokok',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300080',
						'name' => 'Persediaan Makanan',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300090',
						'name' => 'Persediaan Minuman',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300100',
						'name' => 'Persediaan Makanan Olahan',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300110',
						'name' => 'Persediaan Toiletries',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300120',
						'name' => 'Persediaan Buku, ATK, Asesoris',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300130',
						'name' => 'Persediaan Fashion & Textil',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300140',
						'name' => 'Persediaan Perlengkapan Kebersihan',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300150',
						'name' => 'Persediaan Perlengkapan Rumah Tangga',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300160',
						'name' => 'Persediaan Elektronik',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300170',
						'name' => 'Persediaan Mainan',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11300180',
						'name' => 'Persediaan Lainnya',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11410010',
						'name' => 'Sewa Bangunan',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11410020',
						'name' => 'Asuransi Dibayar Dimuka',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11410030',
						'name' => 'Beban Iklan Dibayar Dimuka',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11510010',
						'name' => 'Pajak Dibayar Dimuka PPH 22',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11510020',
						'name' => 'Pajak Dibayar Dimuka PPH 23',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11510030',
						'name' => 'Pajak Dibayar Dimuka PPH 25',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '11800000',
						'name' => 'Uang Muka Pembelian',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12110030',
						'name' => 'Piutang Owner',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12110040',
						'name' => 'Piutang lainnya',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12210010',
						'name' => 'Tanah',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12210020',
						'name' => 'Bangunan Kantor',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12210030',
						'name' => 'Kendaraan',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12210040',
						'name' => 'Perlatan Kantor',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12210050',
						'name' => 'Software',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12210060',
						'name' => 'Furnitur Kantor',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12281010',
						'name' => 'Akum Peny Bangunan Kantor',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12281020',
						'name' => 'Akum Peny Kendaraan Kendaraan',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12281030',
						'name' => 'Akum Peny Peralatan Kantor',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12281040',
						'name' => 'Akum Peny Software',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '12281050',
						'name' => 'Akum Peny Furnitur Kantor',
						'type' => 'Prabayar',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '19999991',
						'name' => 'Persediaan Toiletries',
						'type' => 'Aktiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21100010',
						'name' => 'Hutang Usaha',
						'type' => 'Utang',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21100011',
						'name' => 'Uang Titipan',
						'type' => 'Utang',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21100020',
						'name' => 'Hutang Pemegang Saham',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21100030',
						'name' => 'Hutang Pihak Ketiga',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21100040',
						'name' => 'Hutang Gaji',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21210010',
						'name' => 'Hutang Pajak PPh 21',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21210020',
						'name' => 'Hutang Pajak PPh 23',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21210030',
						'name' => 'Hutang Pajak PPh 25',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21210040',
						'name' => 'Hutang Pajak Pasal 4 (2)',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21210050',
						'name' => 'Hutang Pajak PPh 29',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21221010',
						'name' => 'PPN Keluaran',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '21210020',
						'name' => 'PPN Masukan',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '22110010',
						'name' => 'Hutang Bank',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '22110020',
						'name' => 'Hutang Leasing',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110010',
						'name' => 'BYMHD Listrik',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110020',
						'name' => 'BYMHD Jamsostek',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110030',
						'name' => 'BYMHD Air',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110040',
						'name' => 'BYMHD Telepon',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110050',
						'name' => 'BYMHD Jasa Pengelola Keamanan',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110060',
						'name' => 'BYMHD Bank',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110070',
						'name' => 'BYMHD PBB',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110080',
						'name' => 'BYMHD Izin Usaha',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110090',
						'name' => 'BYMHD Asuransi',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110100',
						'name' => 'HBYMHD Pendidikan dan Latihan',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '25110110',
						'name' => 'BYMHD Jaminan Kesehatan/BPJS',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '28110010',
						'name' => 'Uang Muka Penjualan',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '28110020',
						'name' => 'Deposit Customer',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '28110030',
						'name' => 'Poin Bonus',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '29000000',
						'name' => 'Stock Interim',
						'type' => 'Pasiva Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '31100010',
						'name' => 'Modal Dasar',
						'type' => 'Ekuitas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '31100020',
						'name' => 'Modal Yang Disetor',
						'type' => 'Ekuitas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '31100030',
						'name' => 'Modal Yang Belum Disetor',
						'type' => 'Ekuitas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '31100040',
						'name' => 'Prive (Pengambilan Pribadi)',
						'type' => 'Ekuitas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '31210010',
						'name' => 'Cadangan Modal',
						'type' => 'Ekuitas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '31510010',
						'name' => 'Laba Rugi Tahun Lalu',
						'type' => 'Ekuitas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '31510020',
						'name' => 'Laba Rugi Tahun Berjalan',
						'type' => 'Ekuitas',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '41000010',
						'name' => 'Penjualan',
						'type' => 'Penghasilan',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '41000011',
						'name' => 'Pendapatan Sekolah',
						'type' => 'Penghasilan',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '42000060',
						'name' => 'Retur Penjualan',
						'type' => 'Penghasilan',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '42000070',
						'name' => 'Discount Penjualan',
						'type' => 'Penghasilan',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '51000010',
						'name' => 'Harga Pokok Penjualan',
						'type' => 'Harga Pokok Penjualan',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100010',
						'name' => 'Gaji Karyawan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100020',
						'name' => 'Tunjangan/ Bonus Karyawan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100030',
						'name' => 'Tunjangan Kesehatan Karyawan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100040',
						'name' => 'Pangan karyawan (catering)',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100050',
						'name' => 'Lembur Karyawan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100060',
						'name' => 'Fee Jasa Keamanan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100070',
						'name' => 'Pakaian Kerja',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100080',
						'name' => 'Tunjangan Ulang Tahun Karyawan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100090',
						'name' => 'Tunjangan Melahirkan Karyawan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '61100100',
						'name' => 'Tunjangan PPH Pasal 21',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '62110010',
						'name' => 'Free Gift',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '62110020',
						'name' => 'Event',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '62110030',
						'name' => 'Advertising',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '62110040',
						'name' => 'Pengiriman Barang Dagang',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110010',
						'name' => 'Air Minum',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110020',
						'name' => 'Keperluan Olahraga',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110030',
						'name' => 'Iuran Bulanan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110040',
						'name' => 'Sumbangan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110050',
						'name' => 'Internet',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110060',
						'name' => 'Telepon',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110070',
						'name' => 'Pulsa',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110080',
						'name' => 'Listrik',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110090',
						'name' => 'PDAM',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110100',
						'name' => 'Research & Development',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110110',
						'name' => 'Keperluan Dapur',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110120',
						'name' => 'Perlengkapan Kantor',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110130',
						'name' => 'P3K',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110140',
						'name' => 'Keperluan Lain-lain',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110150',
						'name' => 'K3 (Pemadam Kebakaran)',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110160',
						'name' => 'Perlengkapan Kebersihan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '63110180',
						'name' => 'Keperluan Owner',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '64110010',
						'name' => 'Alat Tulis Kantor',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '64110020',
						'name' => 'Keperluan Pos',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '64110030',
						'name' => 'Jilid & Photocopy',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '64110040',
						'name' => 'Iklan Lowongan Kerja',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '64110050',
						'name' => 'Materai',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110010',
						'name' => 'Biaya Perizinan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110020',
						'name' => 'Biaya Administrasi Bank',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110030',
						'name' => 'Biaya Konsultan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110040',
						'name' => 'Biaya Sewa',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110060',
						'name' => 'Biaya Pemeliharaan & Perawatan Gedung',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110070',
						'name' => 'Biaya Perawatan Instalasi Listrik, telepon, internet',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110080',
						'name' => 'Pajak',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110090',
						'name' => 'Akomodasi Tamu',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110100',
						'name' => 'Biaya Pemeliharaan & Perawatan Aset',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '65110110',
						'name' => 'Biaya Pengiriman Dokumen/Barang',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '66110010',
						'name' => 'BBM kendaraan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '66110020',
						'name' => 'Service kendaraan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '66110030',
						'name' => 'Parkir & tol kendaraan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '66110040',
						'name' => 'Pajak Kendaraan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '66110050',
						'name' => 'Asuransi Kendaraan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '67100010',
						'name' => 'Tanah',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '67100020',
						'name' => 'Bangunan Kantor',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '67100030',
						'name' => 'Kendaraan',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '67100040',
						'name' => 'Perlatan Kantor',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '67100050',
						'name' => 'Software',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '67100060',
						'name' => 'Furnitur Kantor',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '69000000',
						'name' => 'Biaya Lain-lain',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '81100010',
						'name' => 'Pendapatan Bunga',
						'type' => 'Penghasilan Lainnya',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '81100020',
						'name' => 'Pendapatan Deposit',
						'type' => 'Penghasilan Lainnya',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '81100030',
						'name' => 'Keuntungan Selisih Kurs',
						'type' => 'Penghasilan Lainnya',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '81100040',
						'name' => 'Pendapatan Lain',
						'type' => 'Penghasilan Lainnya',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '81100090',
						'name' => 'Keuntungan Atas Penjualan Aktiva Tetap',
						'type' => 'Penghasilan Lainnya',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '91100010',
						'name' => 'Beban Bunga',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '91100020',
						'name' => 'Beban Administrasi Bank',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '91100030',
						'name' => 'Kerugian Selisih Kurs',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '91100090',
						'name' => 'Kerugian Atas Penjualan Aktiva Tetap',
						'type' => 'Pengeluaran',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					),
					array(
						'code' => '999999',
						'name' => 'Keuntungan/Kerugian Belum Terdistribusi',
						'type' => 'Penghasilan Tahun Terkini',
						'school_id' => $school_id,
						'created_at' => strtotime(date('Y-m-d')),
						'updated_at' => NULL
					)
				);
			$this->db->insert_batch('accounts', $data_accounts);

			$data_journal_type = array(
				array(
					'id' => '1',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'name' => 'Faktur Pelanggan'
				),
				array(
					'id' => '2',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'name' => 'Bank'
				),
				array(
					'id' => '3',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'name' => 'Kas'
				),
				array(
					'id' => '4',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'name' => 'Uang Titipan'
				)
				);
			$this->db->insert_batch('journal_type', $data_journal_type);

			$data_journal_type_temp = array(
				array(
					'id' => '1',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'journal_type_id' => 1,
					'account_id' => 13,
					'type' => 'debit'
				),
				array(
					'id' => '2',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'journal_type_id' => 1,
					'account_id' => 93,
					'type' => 'credit'
				),
				array(
					'id' => '3',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'journal_type_id' => 2,
					'account_id' => 1,
					'type' => 'debit'
				),
				array(
					'id' => '4',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'journal_type_id' => 2,
					'account_id' => 13,
					'type' => 'credit'
				),
				array(
					'id' => '5',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'journal_type_id' => 3,
					'account_id' => 4,
					'type' => 'debit'
				),
				array(
					'id' => '6',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'journal_type_id' => 3,
					'account_id' => 13,
					'type' => 'credit'
				),
				array(
					'id' => '7',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'journal_type_id' => 4,
					'account_id' => 56,
					'type' => 'debit'
				),
				array(
					'id' => '8',
					'school_id' => $school_id,
					'created_at' => strtotime(date('Y-m-d')),
					'journal_type_id' => 4,
					'account_id' => 56,
					'type' => 'credit'
				)
				);
			$this->db->insert_batch('journal_type_temp', $data_journal_type_temp);

		$response = array(
			'status' => true,
			'notification' => get_phrase('school_added_successfully')
		);
		return json_encode($response);
	}

	public function school_update($school_id = '')
	{
		$data['name'] = html_escape($this->input->post('name'));
		$data['npsn'] = html_escape($this->input->post('npsn'));
		$data['nss'] = html_escape($this->input->post('nss'));
		$data['longitudinal'] = html_escape($this->input->post('longitudinal'));		
		$data['address'] = html_escape($this->input->post('address'));
		$data['phone'] = html_escape($this->input->post('phone'));
		$this->db->where('id', $school_id);
		$this->db->update('schools', $data);

        $history_data['ket'] = 'Update data schools '.$school_id.'';
        $history_data['id_user'] = $this->session->set_userdata('user_id');
        $this->db->insert('history', $history_data);

		$response = array(
			'status' => true,
			'notification' => get_phrase('school_updated_successfully')
		);
		return json_encode($response);
	}

	public function school_delete($school_id = '')
	{

		$history_data['ket'] = 'Delete data school '.$school_id.'';
		$history_data['id_user'] = $this->session->set_userdata('user_id');
		$this->db->insert('history', $history_data);

	$this->db->where('school_id', $school_id);
		$this->db->delete('alumni');

    $this->db->where('school_id', $school_id);
		$this->db->delete('alumni_events');

    $this->db->where('school_id', $school_id);
		$this->db->delete('alumni_gallery');

    $this->db->where('school_id', $school_id);
		$this->db->delete('alumni_gallery_photos');

    $this->db->where('school_id', $school_id);
		$this->db->delete('assignment_questions');

	$this->db->where('school_id', $school_id);
	$this->db->delete('assignment_remarks');

    $this->db->where('school_id', $school_id);
		$this->db->delete('assignments');

    $this->db->where('school_id', $school_id);
		$this->db->delete('book_issues');

    $this->db->where('school_id', $school_id);
		$this->db->delete('books');

    $this->db->where('school_id', $school_id);
		$this->db->delete('class_rooms');

    $this->db->where('school_id', $school_id);
		$this->db->delete('classes');

    $this->db->where('school_id', $school_id);
		$this->db->delete('course');

    $this->db->where('school_id', $school_id);
		$this->db->delete('course_section');

    $this->db->where('school_id', $school_id);
		$this->db->delete('daily_attendances');

    $this->db->where('school_id', $school_id);
		$this->db->delete('departments');

    $this->db->where('school_id', $school_id);
		$this->db->delete('enrols');

    $this->db->where('school_id', $school_id);
		$this->db->delete('event_calendars');

    $this->db->where('school_id', $school_id);
		$this->db->delete('exams');

	$this->db->where('school_id', $school_id);
		$this->db->delete('expense_categories');
	
	$this->db->where('school_id', $school_id);
		$this->db->delete('expenses');
		
	$this->db->where('school_id', $school_id);
		$this->db->delete('finances');

	$this->db->where('school_id', $school_id);
		$this->db->delete('grades');

	$this->db->where('school_id', $school_id);
		$this->db->delete('invoices');

	$this->db->where('school_id', $school_id);
		$this->db->delete('lesson');

	$this->db->where('school_id', $school_id);
		$this->db->delete('marks');

	$this->db->where('school_id', $school_id);
		$this->db->delete('noticeboard');

	$this->db->where('school_id', $school_id);
		$this->db->delete('parents');

	$this->db->where('school_id', $school_id);
		$this->db->delete('payment_types');

	$this->db->where('school_id', $school_id);
		$this->db->delete('question');

	$this->db->where('school_id', $school_id);
		$this->db->delete('routines');

	$this->db->where('school_id', $school_id);
		$this->db->delete('sections');

	$this->db->where('school_id', $school_id);
		$this->db->delete('students');

	$this->db->where('school_id', $school_id);
		$this->db->delete('subjects');

	$this->db->where('school_id', $school_id);
		$this->db->delete('syllabuses');

	$this->db->where('school_id', $school_id);
		$this->db->delete('teachers');

	$this->db->where('school_id', $school_id);
		$this->db->delete('users');

	$this->db->where('id', $school_id);
		$this->db->delete('schools');

		$response = array(
			'status' => true,
			'notification' => get_phrase('school_deleted_successfully')
		);
		return json_encode($response);
	}

	public function active_school($school_id = '')
	{
		$this->db->where('id', 1);
		$updater = array(
			'school_id' => $school_id
		);
		$this->db->update('settings', $updater);

		$response = array(
			'status' => true,
			'notification' => get_phrase('school_activated_successfully')
		);
		return json_encode($response);
	}
}
