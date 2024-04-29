<?php
if ($desain == '1b.png') {
    $desain_blkng = "1dpn.png";
} elseif($desain == '2b.png') {
    $desain_blkng = "2dpn.png";
} elseif($desain == '3b.png') {
    $desain_blkng = "3dpn.png";
} elseif($desain == '4b.png') {
    $desain_blkng = "4dpn.png";
} elseif($desain == '5b.png') {
    $desain_blkng = "5dpn.png";
}
?>
<head>
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <title><?php echo $student['student_full_name'] ?></title>

  <style type="text/css">
    body {
      font-family: Tahoma;
    }

    @page {
      margin-top: 0.5cm;
      margin-bottom: 0.2cm;
      margin-left: 0.3cm;
      margin-right: 0.3cm;
    }

    .info{
      padding-top: 2px;
    }

    .school {
      font-size: 8pt;
      font-weight: bold;
      text-align: center;
      text-transform: uppercase;
      /* padding-bottom: 0px;
      padding-top: 0px; */
    }

    .address {
      font-size: 5pt;
      text-align: center;
      /* padding-bottom: -10px; */
    }

    hr {
      border: none;
      height: 3px;
      /* Set the hr color */
      color: #333;
      /* old IE */
      background-color: #333;
      margin-bottom: 0px;
      /* Modern Browsers */
    }

    .container {
      position: relative;
      margin-top: 0px;
    }

    .image{
      text-align: center;
      /* padding: 1px 2px; */
    }

    .topright {
      position: absolute;
    }

    table{
      margin-left: 2%;
    }

    .name {
      /* margin-left: 60px; */
      font-size: 7pt;
    }

    .fieldset-auto-width {
      display: inline-block;
      width: 9cm;
      height: 5cm;
      border: 1px solid black;
      margin-top:50px;
      /* float: right; */
      background-image: url(<?php echo base_url('assets/backend/images/card/'.$desain_blkng) ?>);
      background-size: 100% 100%;
    }

    .fieldset-auto-width2 {
      width: 9cm;
      height: 5cm;
      border: 1px solid black;
      margin-top:50px;
      float: left;
      background-image: url(<?php echo base_url('assets/backend/images/card/'.$desain) ?>);
      background-size: 100% 100%;
    }

    @media print{
    * {-webkit-print-color-adjust:exact;}
    }
  </style>
</head>
<?php
    // $this->db->join('users', 'users.id=students.user_id');
    
    $student = $this->user_model->get_student_details_by_id('student', $student_id);

    $this->db->where('id', $student['session']);
    $tahun_ajaran = $this->db->get('sessions')->row('name');

?>
<body>
  <fieldset class="fieldset-auto-width">
    <div class="info">
      <div class="school"><?=get_phrase('student_card');?></div>
      <div class="school"><?php echo get_settings('system_title'); ?></div>
      <div class="address"><?php echo get_settings('address')." Telp. ".get_settings('phone'); ?></div>
    </div>
  
    <div class="container">
      <!-- <div class="topright">
        <img src="<?= base_url().'/uploads/users/placeholder.jpg'; ?>" style="height: 55px; width: 45px;border:1px solid">
      </div> -->

      <table class="name">
        <tr style="">
          <td colspan="3" style="text-align: center; font-size: 8pt; font-weight: bold; text-transform: uppercase;"><?php echo $student['name'] ?></td>
          <td rowspan="7" style="text-align: center;">
            <img src="<?php echo $this->user_model->get_user_image($student['user_id']); ?>" style="height: 3cm; width: 2cm; border:1px solid;">
          </td><br>
        </tr>
        <tr>
          <td colspan="3" style="text-align: center; text-transform: uppercase;font-size: 8pt; font-weight: bold;"><?php echo get_phrase($student['gender']) ?></td>
        </tr>
        <tr>
          <td width="100px;">NIS</td>
          <td>:</td>
          <td width="200px;"><?php echo $student['NIS'] ?></td>
        </tr>
        <tr>
          <td>NISN</td>
          <td>:</td>
          <td><?php echo $student['nisn'] ?></td>
        </tr>
        <tr>
          <td>TTL</td>
          <td>:</td>
          <td style="font-size: 6pt;"><?php echo $this->db->get_where('district', array('id' => $student['birthday_place']))->row('name').', '.$student['birthday'] ?></td>
        </tr>
        <tr>
          <td>Agama</td>
          <td>:</td>
          <td>
          <?php 
          if(empty($student['religion'])){
            echo 'Islam';
          }else{
            echo $student['religion']; 
          }
          ?></td>
        </tr>
        <tr>
          <td colspan="3">
            <div class="image">
              <img style="width:125pt; height:18pt;" src="<?= route('barcode_create/'.$student['NIS']) ?>" alt="">
              <p style="font-size: 7pt; margin-top:5px;"><i>Cetak tanggal <?= date('d-M-Y')?></i></p>
            </div>
          </td>
        </tr>
      </table>

  </fieldset>
  
  <fieldset class="fieldset-auto-width2">
    <div class="info">
      <div class="school" style="margin-top: 15px;"><u>KETERANGAN</u></div>
    </div>
    <div class="container">
      <table class="name" style="margin-bottom: 15px; margin-top: 20px;">
        <tr>
          <td style="vertical-align: top;">1. </td>
          <td>Kartu berlaku selama masih berstatus menjadi pelajar di sekolah ini.</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">2. </td>
          <td>Kartu tidak dapat dipindahkan kepemilikannya, atau dipinjamkan dan digunakan oleh orang lain.</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">3. </td>
          <td>Apabila kartu hilang atau rusak segera lapor kepada sekolah.</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">4. </td>
          <td>Penggantian atau pembuatan kartu baru karena hilang atau rusak, akan dikenakan biaya.</td>
        </tr>
        <tr>
          <td style="vertical-align: top;">5. </td>
          <td>Apabila anda menemukan kartu ini, mohon menghubungi / mengembalikan kepada sekolah.</td>
        </tr>
      </table>
    </div>

  </fieldset>

</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
      // var d = new Date();
      // var date = date('Y-m-d');
      // var strDate = d.getDate() + "-" + (d.getMonth()+1) + "-" + d.getFullYear();
      // var strTime = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

      // $("p i").text("Dicetak tanggal " + date );

      window.print();
      window.onafterprint = window.close;
</script>