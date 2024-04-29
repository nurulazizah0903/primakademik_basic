<form method="POST" class="col-12 d-block ajaxForm" action="<?php echo route('registration/financial_report'); ?>">
    <input type="hidden" name="date_from" value="<?php echo $date_from; ?>">
    <input type="hidden" name="date_to" value="<?php echo $date_to; ?>">
    <button class="btn btn-primary col-sm-12" onclientclick="window.open('https://stackoverflow.com/questions/8994285/how-do-i-use-target-blank-on-a-response-redirect')" type="submit"><?php echo get_phrase('export_data') ?></button>
</form>
<table class="table table-bordered table-striped" style="text-align: center;" width="100%">
    <thead>
        <tr>
            <th colspan="7">Laporan Keuangan PPDB</th>
        </tr>
        <tr>
            <th>Kode Registrasi</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Tagihan</th>
            <th>Bayar Ke</th>
            <th>Tanggal</th>
            <th>Rp</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($payment_data as $row){
            $data = $this->db->get_where('registrations', array('id' => $row['kode_registrasi']))->row_array();
            $jalur = $this->db->get_where('registration_path', array('id' => $data['jalur_pendaftaran']))->row_array();
        ?>
        <tr>
            <td><?= $data['kode_registrasi'];?></td>
            <td><?= $data['nama_lengkap'];?></td>
            <td>
            <?php 
                if ($data['status'] == 'Not Yet Paid') {
                echo get_phrase('belum_bayar');
                } elseif ($data['status'] == 'Not Selection') {
                echo get_phrase('belum_lulus_seleksi');
                } elseif ($data['status'] == 'Processed') {
                echo get_phrase('diproses');
                }elseif ($data['status'] == 'Accepted') {
                echo get_phrase('diterima');
                }elseif ($data['status'] == 'Not Accepted') {
                echo get_phrase('tidak_diterima');
                }elseif ($data['status'] == 'Removed') {
                echo get_phrase('dicabut');
                }elseif ($data['status'] == 'Installment') {
                echo get_phrase('installment');
                }
            ?>
            </td>
            <td><?=currency( number_format($jalur['total'],0,",","."))?></td>
            <td><?= $row['ket'];?></td>
            <td><?php echo date('d M Y', strtotime($row['date'])); ?></td>
            <td><?= currency( number_format($row['total'],0,",","."))?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>