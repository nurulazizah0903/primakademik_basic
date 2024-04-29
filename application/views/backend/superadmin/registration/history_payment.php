<table class="table table-bordered table-striped" style="text-align: center;" width="100%">
    <thead>
        <tr>
            <th colspan="5">Laporan Keuangan PPDB</th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th>Total</th>
            <th>Voucher</th>
            <th>User</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $payment_data = $this->db->get_where('payment_ppdb', array('kode_registrasi' => $param1))->result_array();
            foreach($payment_data as $row){
            $user = $this->db->get_where('users', array('id' => $row['id_user']))->row_array();
        ?>
        <tr>
            <td><?=(!empty($row['datetime'])) ? $row['datetime'] : $row['date'] ;?></td>
            <td><?= currency( number_format($row['total'],0,",","."))?></td>
            <td><?= currency( number_format($row['voucher'],0,",","."))?></td>
            <td><?= $user['name'];?></td>
            <td><?= $row['description'];?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>