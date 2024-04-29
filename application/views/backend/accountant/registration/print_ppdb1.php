<?php
$bulan = date('m');
if($bulan >= 7){
  $tahun = date('Y')+1;
}else{
  $tahun = date('Y');
}
?>
<style type="text/css">
    .horizontal_center{
        border-top: 1px solid black;
        height: 1px;
        width : auto;
    }
    .horizontal_center2{
        border-top: 2px solid black;
        height: 1px;
        width : auto;
        margin-bottom: 1px;
    }
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
        font: 11pt "Calibri";
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
        margin: 0;
    }
    @media print {
        html, body {
            width: 210mm;
            height: 297mm;        
        }
    .page {
        margin: 0;
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
        height: 320mm;
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

<div class="d-print-none mt-4">
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
        <div class="horizontal_center2"></div>
        <div class="horizontal_center"></div>
        <center>
            <b><p><div class="upper"><?php echo get_phrase('formulir_pendaftaran'); ?></div>
            <div class="upper">< <?php echo $this->db->get_where('registration_path', array('id' => $ppdb_data['jalur_pendaftaran']))->row('name');?> ></div></p></b>
            <table width="100%">
                <tr>
                    <th><div class="upper"><?php echo get_phrase('kode_registrasi'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['kode_registrasi'];?></td>
                    <th><div class="upper"><?php echo get_phrase('nisn'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['nisn'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('Nama_Calon_Peserta_Didik'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['nama_lengkap'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('jenis_kelamin'); ?></div></th>
                    <td>:</td>
                    <td>
                    <?php
                    if($ppdb_data['jenis_kelamin'] == "Male"){
                        echo 'Laki - Laki';
                    }else{
                        echo 'Perempuan';
                    }
                    ?></td>
                    <th><div class="upper"><?php echo get_phrase('nik'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['nik'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('alamat'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['alamat'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('asal_sekolah'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['sekolah_asal'];?></td>
                    <th><div class="upper"><?php echo get_phrase('kelas/jurusan'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['jurusan'];?></td>
                </tr>
                <tr>
                    <th><div class="upper"><?php echo get_phrase('no_telp'); ?></div></th>
                    <td>:</td>
                    <td><?= $ppdb_data['telephone'];?></td>
                </tr>
            </table><br>
        </center>
        <div class="horizontal_center2"></div>
        <div class="horizontal_center"></div>
            <table width="100%" style="font-size: 10px;">
                <tr>
                    <td>
                        <center><b><p><div class="upper"><?php echo get_phrase('SYARAT_DAN_KETENTUAN_PENGUNDURAN_DIRI'); ?></div></p></b></center>
                        <ol>
                            <li>Calon peserta didik bisa mengambil perlengkapan jika telah lunas.</li>
                            <li>Perlengkapan yang sudah diterima tidak dapat dikembalikan.</li>
                            <li>Siswa yang mengundurkan diri :</li>
                                <ol type="a">
                                    <li>Sampai dengan 10 Juli <?php echo date('Y')+1; ?>, mendapatkan pengembalian uang pendaftaran sebesar 50%.</li>
                                    <li>11 – 31 Juli <?php echo date('Y')+1; ?>, mendapatkan pengembalian uang pendaftaran sebsar 25%.</li>
                                    <li>Setelah tanggal 31 Juli <?php echo date('Y')+1; ?>, tidak ada pengembalian uang pendaftaran.</li>
                                </ol>  
                            <li>Pengunduran diri atau mutasi pada tengah tahun pelajaran, wajib melunasi uang infak bulanan terhitung hingga saat yang bersangkutan mengajukan pengunduran diri atau mutasi.</li>
                            <li>Pengembalian uang pendaftaran bagi siswa yang mengundurkan diri sebagaimana poin 3a dan 3b, dihitung setelah dikurangi biaya perlengkapan sebesar Rp 1.150.000,-.</li>
                            <li>Pengunduran diri khusus pendaftar inden angsur yang belum lunas dihitung sebagaimana poin 3 tanpa dikurangi biaya perlengkapan.</li>
                        </ol>
                    </td>
                    <td>
                        <center><b><p><div class="upper"><?php echo get_phrase('petunjuk_pendaftaran'); ?></div></p></b></center>
                        <ol>
                            <li>Formulir dicetak dan dilengkapi persyaratan dokumen sebagai berikut :</li>
                                <ol type="a">
                                <li>Fotokopi KK 2 lembar</li>
                                <li>Fotokopi akta kelahiran 2 lembar</li>
                                <li>Surat Keterangan Lulus</li>
                                <li>Dokumen Pendukung:</li>
                                <table border="1" width="100%">
                                    <tr>
                                        <td>KATEGORI</td>
                                        <td>DOKUMEN PENDUKUNG</td>
                                    </tr>
                                    <tr>
                                        <td>SKM / SKTM</td>
                                        <td>Surat keterangan Miskin atau Tidak mampu dari dinas Sosial atau setidak-tidaknya dari RT/RW</td>
                                    </tr>
                                    <tr>
                                        <td>Kakak Beradik</td>
                                        <td>Fotokopi KK</td>
                                    </tr>
                                    <tr>
                                        <td>Orang Tua Alumni YWH</td>
                                        <td>Fotokopi Ijazah Orang Tua Alumni YWH Yang dilegalisir</td>
                                    </tr>
                                    <tr>
                                        <td>Alumni WH</td>
                                        <td>Fotokopi SKL atau rapor terakhir yang dilegalisir</td>
                                    </tr>
                                    <tr>
                                        <td>AWS</td>
                                        <td>Fotokopi KK</td>
                                    </tr>
                                    <tr>
                                        <td>MBR</td>
                                        <td>Surat Keterangan MBR dari Dinas Sosial</td>
                                    </tr>
                                    <tr>
                                        <td>Prestasi</td>
                                        <td>Sertifikat atau Piagam Penghargaan</td>
                                    </tr>
                                </table>
                                </ol>  
                            <li>Alamat Sekolah :<br>
                                Jl. Surabaya Jawa Timur<br>
                                Narahubung :  0877 xxxx xxxx<br>
                                Jam Operasional : 08.00 – 13.00
                                </li>
                        </ol>
                    </td>
                </tr>
            </table>
            <table width="100%" style="font-size: 11px;">
                <tr>
                    <td colspan="2">
                        <center><b><p><div class="upper"><?php echo get_phrase('cara_pembayaran_ppdb'); ?></div></p></b></center>
                    </td>
                </tr>
                <tr>
                    <td>
                        Cara pembayaran biaya PPDB adalah sebagai berikut :
                        <ol>
                            <li>Tunai, datang langsung ke sekolah menemui panitia PPDB</li>
                            <li>Transfer melalui ATM atau Bank sebagai berikut :<br>
                                Rekening Bank Jatim Cabang Perak Surabaya (kode 114 di ATM)<br>
                                No 		: 000 XXX XXX <br>
                                atas nama	: SMK PRIMAVISI GLOBALINDO
                            </li>
                            <li>Pembayaran dengan QRIS, scan barcode disamping ini.</li>
                        </ol>
                    </td>
                    <td>
                        <img src="<?php echo base_url();?>assets/payment/qr/qris.png" alt="" width="70px" height="35px" style="transform: rotate(270deg);" />
                        <img src="<?php echo base_url();?>assets/payment/qr/smk.jpg" alt="" width="150px" height="150px"/>
                    </td>
                </tr>
            </table>
            <table width="100%" style="text-align: center; font-size: 11px;">
                <tr>
                    <td>Dibuat tanggal : <?php echo date('d M Y', strtotime($ppdb_data['tgl_daftar'])); ?></td>
                    <td>Dicetak tanggal : <?= date("d M Y");?></td>
                </tr>
                <tr>
                    <td>Orang Tua</td>
                    <td>Petugas Pendaftaran</td>
                </tr>
                <tr>
                    <td>
                        <br><br><br><br><br><br>
                    </td>
                    <td>
                        <br><br><br><br><br><br>
                    </td>
                </tr>
                <tr>
                    <td><b><u><div class="upper"><?= $ppdb_data['nama_orang_tua'];?></div></u></b></td>
                    <td><b><u>.......................................................</u></b></td>
                </tr>
            </table>
        </div>
        </div>
</div>