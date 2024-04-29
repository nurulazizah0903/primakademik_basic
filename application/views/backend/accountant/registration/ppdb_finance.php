<?php $profile_data = $this->user_model->get_profile_data();

$bulan = date('m');
if($bulan >= 7){
  $tahun = date('Y')+1;
}else{
  $tahun = date('Y');
}

?>
<style type="text/css">
    p.left { 
        text-align: left;
    }
    p.right { 
        text-align: right;
    }
    p.center { 
        text-align: center;
    }
    p.justify { 
        text-align: justify;
    }
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background-color: #FAFAFA;
        font: 14pt "Arial Narrow";
        color: black;
    }
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .page {
        width: 210mm;
        min-height: 297mm;
        padding: 10mm;
        margin: 5mm auto;
        border: 1px #D3D3D3 solid;
        /* border-radius: 5px; */
        background: white;
        /* box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); */
    }
    
    @page {
        size: A4;
        /* transform: rotate(270deg) translateX(-100%);
        transform-origin: left top; */
        /* size: 148mm 220mm landscape; */
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
    .page {
        margin: 0;
        /* transform: rotate(270deg) translateX(-100%);
            transform-origin: left top; */
        /* border: 1px black solid; */
        border: initial;
        border-radius: initial;
        width: initial;
        min-height: initial;
        box-shadow: initial;
        background: initial;
        page-break-after: always;
    }

    .subpage {
        padding: 1cm;
        /* border: 1px black solid; */
        height: 297mm;
        /* outline: 2cm #FFEAEA solid; */
    }
    }
    .garis_tepi1 {
        border: 1px solid black;
    }
    .upper { 
        text-transform: uppercase; 
    }
</style>
<div class="book">
    <div class="d-print-none mt-12">
        <div class="text-left">
            <a href="<?php echo route('registration/create/admitted'); ?>" class="btn btn-success"><i class="mdi mdi-arrow-collapse-left"></i> <?php echo get_phrase('back'); ?></a>
        </div>
    </div>
    <div class="d-print-none mt-12">
        <div class="text-right">
            <a href="javascript:window.print()" class="btn btn-primary"><i class="mdi mdi-printer"></i> <?php echo get_phrase('print'); ?></a>
        </div>
    </div>
    <div class="page">
        <div class="subpage">
        <center>
            <table width="100%">
                <tr>
                    <td rowspan="3" align="left"><img class="img-mid-places" src="<?php echo $this->settings_model->get_logo_dark(); ?>" alt="" width="100px" height="100px"></td>
                    <td align="center"><b>PENERIMAAN PESERTA DIDIK BARU (PPDB) TAHUN <?= $tahun ?>/<?= $tahun+1; ?></b></td>
                </tr>
                <tr>
                    <td align="center"><b><div class="upper"><?= get_current_school_data("name") ?></b></div></td>
                </tr>
                <tr>
                    <td align="center"><b><?= get_settings('complete_address') ?></b></td>
                </tr>
            </table><br>
        </center>
        <b><hr size="30" noshade></b>
        <center>
            <b><p><div class="upper"><?php echo get_phrase('bukti_pembayaran_ppdb'); ?></div></p></b><br>
            <table width="100%">
                <tr>
                    <th><div class="upper"><?php echo get_phrase('kode_registrasi'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['kode_registrasi'];?></td>
                    <th><div class="upper"><?php echo get_phrase('nik'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['nik'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('name'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['nama_lengkap'];?></td>
                    <th><div class="upper"><?php echo get_phrase('nisn'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['nisn'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('jenis_kelamin'); ?></div></th>
                    <td>:</td>
                    <td><?php
                    if($ppdb_data['jenis_kelamin'] == "Male"){
                        echo 'Laki - Laki';
                    }else{
                        echo 'Perempuan';
                    }
                    ?></td>                    
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('kelas/jurusan'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['jurusan'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('nama_orang_tua/wali'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['nama_orang_tua'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('telephone'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['telephone'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('kategori'); ?></div></th>
                    <td>:</td>
                    <td><?php echo $this->db->get_where('registration_path', array('id' => $ppdb_data['jalur_pendaftaran']))->row('name');?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('total_biaya_ppdb'); ?></div></th>
                    <td>:</td>
                    <td>Rp. <?php echo ( number_format($this->db->get_where('registration_path', array('id' => $ppdb_data['jalur_pendaftaran']))->row('total'),0,",","."));?></td>
                </tr>
            </table><br>
        </center>
        <center>
            <table width="100%" border="1">
                <thead>
                    <tr>
                        <th>Bayar Ke</th>
                        <th>Tanggal</th>
                        <th>Rp</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $payment_ppdb = $this->db->get_where('payment_ppdb', array('kode_registrasi' => $ppdb_data['id']))->result_array();
                        $registration_path = $this->db->get_where('registration_path', array('id' => $ppdb_data['jalur_pendaftaran']))->row_array();
                        $this->db->select_sum('total');
                        $this->db->where('kode_registrasi', $ppdb_data['id']);
                        $total = $this->db->get('payment_ppdb')->row_array();
                        $i = 1;
                        $sisa = $registration_path['total'] - $total['total'];
                        foreach($payment_ppdb as $data){
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?php echo date('d M Y', strtotime($data['date'])); ?></td>
                        <td><?= currency( number_format($data['total'],0,",","."))?></td>
                        <td><?= $data['ket'];?></td>
                    </tr>
                    <?php
                    $i++;
                    } ?>
                    <tr>
                        <th colspan="2">Total Pembayaran</th>
                        <th colspan="3" style="text-align: right;"><?= currency( number_format($total['total'],0,",","."))?></th>
                    </tr>
                    <tr>
                        <th colspan="2">Kurang Bayar</th>
                        <th colspan="3" style="text-align: right;"><?= currency( number_format($sisa,0,",","."))?></th>
                    </tr>
                </tbody>
            </table><br>
            <table width="100%">
                <tr>
                    <th>
                    Narahubung Panitia PPDB 0852 3047 3839<br>
	            Narahubung Panitia PPDB 0878 7913 6979
                    </th>
                    <td>Surabya, <?=date('d M Y');?><br>
                        Petugas Penerima
                        <br><br><br><br>
                        (<?= $profile_data['name']?>) </td>
                </tr>
            </table><br>
        </center>
        <b><hr size="30" noshade></b>
        <b><p class="left"><?php echo get_phrase('ket'); ?></p></b>
        <div class="modal-body" style="color: #2b2b2b; font-size: 14px;">
            <ul>
                <li>Simpan bukti ini dengan baik</li>
                <li>Terima kasih telah mempercayakan pendidikan putra / putri Bapak / Ibu kepada kami.<br> 
                    Semoga senantiasa diberikan kemudahan kelapangan sampai dengan kelulusan. <br>
                    Semoga putra /  putri Bapak / Ibu berhasil menjadi keturunan qurrata a’yuun.<br>
                </li>
                <li>Calon peserta didik bisa mengambil perlengkapan jika telah lunas.</li>
                <li>Perlengkapan yang sudah diterima tidak dapat dikembalikan.</li>
                <li>Siswa yang mengundurkan diri :</li>
                    <ol type="a">
                        <li>Sampai dengan 10 Juli <?php echo date('Y'); ?>, mendapatkan pengembalian uang pendaftaran sebesar 50%.</li>
                        <li>11 – 31 Juli <?php echo date('Y'); ?>, mendapatkan pengembalian uang pendaftaran sebsar 25%.</li>
                        <li>Setelah tanggal 31 Juli <?php echo date('Y'); ?>, tidak ada pengembalian uang pendaftaran.</li>
                    </ol>  
                <li>Pengunduran diri atau mutasi pada tengah tahun pelajaran, wajib melunasi uang infak bulanan terhitung hingga saat yang bersangkutan mengajukan pengunduran diri atau mutasi.</li>
                <li>Pengembalian uang pendaftaran bagi siswa yang mengundurkan diri sebagaimana poin 3a dan 3b, dihitung setelah dikurangi biaya perlengkapan sebesar Rp 1.150.000,-.</li>
                <li>Pengunduran diri khusus pendaftar inden angsur yang belum lunas dihitung sebagaimana poin 3 tanpa dikurangi biaya perlengkapan.</li>
            </ul>
		</div>
        </div>
        </div>
</div>
