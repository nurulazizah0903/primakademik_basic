<?php
if (isset($nama_siswa)):
$raw = json_encode(["params" => ["nama_siswa" => html_escape($nama_siswa) ]]);
$contents = stream_context_create(["http" => [
    "header"=>"Content-Type: application/json",
    "content"=>$raw
]]);

$results = file_get_contents(config_item('odoo_url')."/web/transaksi", false, $contents);
$data = json_decode($results, true);
?>
    <table id="basic-datatable" class="table table-striped dt-responsive nowrap" width="100%">
        <thead>
        <tr>
                <th><?php echo get_phrase('student'); ?></th>
                <th><?php echo get_phrase('total'); ?></th>
                <th><?php echo get_phrase('sisa'); ?></th>
                <th><?php echo get_phrase('tanggal'); ?></th>
                <th><?php echo get_phrase('status'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($data['result'] as $finance):
            ?>
                <tr>
                    <td><?php echo $finance['nama_siswa']; ?></td>  
                    <td><?php echo get_phrase('Rp.'); ?><?php echo number_format($finance['amount']); ?></td>
                    <td><?php echo get_phrase('Rp.'); ?><?php echo number_format($finance['sisa_tagihan']); ?></td>
                    <td><?php echo date('D, d/M/Y', strtotime($finance['tagihan_date'])); ?></td>
                    <td><?php echo ($finance['status_tagihan']) ?></td>
                </tr>
        </tbody>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
  <?php include APPPATH.'views/backend/empty.php'; ?>
<?php endif; ?>