<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php 
  $school_id = school_id();

  $role_name = array('teacher', 'librarian', 'other_employee', 'accountant', '0');
	$this->db->or_where_in('role', $role_name);	
  $this->db->where('school_id', $school_id);
  $employees = $this->db->get('users')->result_array();
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
      padding-top: 20px;
    }

    .info_ket{
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
      height: 9cm;
      width: 5cm;
      border: 1px solid black;
      margin-top:150px;
      background-image: url(<?php echo base_url('assets/backend/images/card/tp1d.png') ?>);
      background-size: 100% 100%;
    }

    .fieldset-auto-width2 {
      height: 9cm;
      width: 5cm;
      border: 1px solid black;
      margin-top:150px;
      float: left;
      background-image: url(<?php echo base_url('assets/backend/images/card/tp1b.png') ?>);
      background-size: 100% 100%;
    }

    @media print{
    * {-webkit-print-color-adjust:exact;}
    }
  </style>
</head>
<?php
    foreach($employees as $employee){
?>
<body>
  <fieldset class="fieldset-auto-width">
    <div class="info">
      <div class="school"><?php echo get_settings('system_title'); ?></div>
      <div class="address"><?php echo get_settings('address')." Telp. ".get_settings('phone'); ?></div>
    </div> <br>
    <div class="container">
      <center>
      <img src="<?php echo $this->user_model->get_user_image($employee['id']); ?>" style="height: 170px; width: 165px;border:1px solid; margin-top:5px; border-radius: 50%; padding-top: 2px;">
      <br>
        <table class="name">
          <tr>
            <td style="text-align: center; font-size: 8pt; font-weight: bold; text-transform: uppercase;"><?php echo $employee['name'] ?></td>
          </tr>
          <tr>
            <td style="text-align: center; font-size: 8pt; font-weight: bold; text-transform: uppercase;"><?php echo $employee['nip'] ?></td>
          </tr>
        </table>
      </center>
      <div class="image">
        <img style="width:125pt; height:18pt;" src="<?= route('employee_barcode_create/'.$employee['nip']) ?>" alt="">
        <p style="font-size: 7pt; margin-top:5px;"><i>Dicetak tanggal <?= date('d-M-Y')?></i></p>
      </div>

  </fieldset>
  
  <fieldset class="fieldset-auto-width2">
    <div class="info_ket">
      <div class="school" style="margin-top: 15px; font-size: 12pt;"><u>KETERANGAN</u></div>
      <div class="school"></div>
      <div class="address"></div>
    </div>
  
    <div class="container">
      <table class="name" style="margin-bottom: 15px; margin-top: 20px; font-size: 9pt;">
        <tr>
          <td style="vertical-align: top;">1. </td>
          <td>Kartu berlaku selama masih berstatus menjadi TENDIK / TEPENDIK di sekolah ini.</td>
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
<?php } ?>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
      // var d = new Date();
      // var strDate = d.getDate() + "/" + (d.getMonth()+1) + "/" + d.getFullYear();
      // var strTime = d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

      // $("p i").text("Dicetak tanggal " + strDate + " pukul " + strTime);

      window.print();
      window.onafterprint = window.close;
</script>