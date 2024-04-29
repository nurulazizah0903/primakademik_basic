<?php
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
        <b><hr size="30" noshade></b>
        <center>
            <b><p><div class="upper"><?php echo get_phrase('identitas_calon_peserta_didik'); ?></div></p></b><br>
            <table width="100%">
                <tr>
                    <td><div class="upper"><?php echo get_phrase('kode_registrasi'); ?></div></td>
                    <td>:</td>
                    <td><?= $ppdb_data['kode_registrasi'];?></td>
                </tr>
                <tr>
                    <td><div class="upper"><?php echo get_phrase('name'); ?></div></td>
                    <td>:</td>
                    <td><?= $ppdb_data['nama_lengkap'];?></td>
                </tr>
                <tr>
                    <td><div class="upper"><?php echo get_phrase('jenis_kelamin'); ?></div></td>
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
                    <td><div class="upper"><?php echo get_phrase('nik'); ?></div></td>
                    <td>:</td>
                    <td><?= $ppdb_data['nik'];?></td>
                </tr>
                <tr>
                    <td><div class="upper"><?php echo get_phrase('jurusan'); ?></div></td>
                    <td>:</td>
                    <td><?= $ppdb_data['jurusan'];?></td>
                </tr>
                <tr>
                    <td><div class="upper"><?php echo get_phrase('kategori'); ?></div></td>
                    <td>:</td>
                    <td><?php echo $this->db->get_where('registration_path', array('id' => $ppdb_data['jalur_pendaftaran']))->row('name');?></td>
                </tr>
            </table><br>
        </center>
        <b><hr size="30" noshade></b>
        <center>
            <b>
            Narahubung Panitia PPDB 0852 3047 3839<br>
            Narahubung Panitia PPDB 0878 7913 6979
            </b>
        </center>
        <b><hr size="30" noshade></b>
        <center>
            <b>TERIMA KASIH TELAH MELAKUKAN PENDAFTARAN SECARA ONLINE</b>
        </center>
        <div class="modal-body" style="color: #2b2b2b; font-size: 19px;">
            <ol>
                <li>UNTUK LANGKAH SELANJUTNYA SILAKAN BAPAK/IBU ORANG TUA CALON PESERTA DIDIK DATANG KE SEKOLAH BERSAMA PUTRA/PUTRINYA DENGAN MEMBAWA BERKAS BERIKUT :</li>
                <br>
                <ol>
                    <li>Fotokopi KK 2 lembar</li>
                    <li>Fotokopi Akte Kalahiran 2 lembar</li>
                    <li>Surat Keterangan Lulus</li>
                    <li>Dokumen pendukung sesuai pilihan kategori :</li>
                    <table border="1" width="100%">
                        <tr>
                            <td>NO</td>
                            <td>KATEGORI</td>
                            <td>DOKUMEN PENDUKUNG</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>SKM / SKTM</td>
                            <td>Surat Keterangan Miskin atau Tidak Mampu dari Dinas Sosial atau setidak-tidaknya dari RT/RW</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Kakak Beradik</td>
                            <td>Fotokopi KK</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Orang Tua Alumni YWH</td>
                            <td>Fotokopi Ijazah Orang Tua Alumni YWH yang dilegalisir</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Alumni WH</td>
                            <td>Fotokopi SKL atau rapor terakhir yang dilegalisir</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>AWS</td>
                            <td>Fotokopi KK</td>
                        </tr>
                        <!--<tr>
                            <td>6</td>
                            <td>MBR</td>
                            <td>Surat Keterangan MBR dari Dinas Sosial</td>
                        </tr>-->
                        <tr>
                            <td>6</td>
                            <td>Prestasi</td>
                            <td>Sertifikat atau Piagam Penghargaan</td>
                        </tr>
                    </table>
                </ol><br>
                <li>MENUNJUKKAN BUKTI PENDAFTARAN INI KEPADA PANITIA PPDB</li>
                <li>MEMBAYAR BIAYA PPDB</li>
                <li>MELAKUKAN PENGUKURAN BAJU</li>
                <li>MENGAMBIL PERLENGKAPAN JIKA BIAYA PPDB SUDAH DILUNASI.</li>
            </ol>
		</div>
            <table width="100%">
                <tr>
                    <td>Dibuat tanggal :</td>
                    <td><?php echo date('d M Y', strtotime($ppdb_data['tgl_daftar'])); ?></td>
                    <td>Dicetak tanggal :</td>
                    <td><?= date("d M Y");?></td>
                </tr>
            </table>
        </div>
        </div>
</div>
