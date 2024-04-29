<?php
if ($desain = '1b.png') {
    $desain_blkng = "1dpn.png";
} elseif($desain = '2b.png') {
    $desain_blkng = "2dpn.png";
} elseif($desain = '3b.png') {
    $desain_blkng = "3dpn.png";
} elseif($desain = '4b.png') {
    $desain_blkng = "4dpn.png";
} elseif($desain = '5b.png') {
    $desain_blkng = "5dpn.png";
}
?>
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

    .school {
      font-size: 7pt;
      font-weight: bold;
      text-align: center;
      text-transform: uppercase;
      padding-top: 2px
      /* padding-bottom: 0px;
      padding-top: 0px; */
      /* /width: 50%;/ */
    }

    .address {
      font-size: 5pt;
      text-align: center;
      /* padding-bottom: -10px; */
      /* /width: 50%;/ */
    }

    .phone {
      font-size: 5pt;
      text-align: center;
      font-style: italic;
      /* padding-bottom: -10px; */
      /* /width: 50%;/ */
    }
    .sub-title{
        font-size: 13pt;
        font-weight: 550;
    }
    hr {
      border: none;
      height: 2px;
      /* Set the hr color */
      color: #333;
      /* old IE */
      background-color: #333;
      /* Modern Browsers */
    }

    .container {
      /* position: relative; */
    }

    .topright {
      position: absolute;
    }

    .fieldset-auto-width {
      display: inline-block;
      width: 40%;
      padding-top: 0px;
      border: 1px solid black;
      padding-bottom: 5px;
    }
    @media print{
        .row{
            width: 100%;
            text-align: center;
            float: right;
        }
        .col-xl-8 {
            width: 60%;
        }
    }
</style>
<?php
    $student = $this->user_model->get_student_details_by_id('student', $student_id);

    $this->db->where('id', $student['session']);
    $tahun_ajaran = $this->db->get('sessions')->row('name');

?>
<div class="row d-print-none">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title">
                    <i class="mdi mdi-calendar-today title_icon"></i> <?php echo get_phrase('student_card'); ?>
                    <a href="<?php echo route('print_student_card/'.$student_id); ?>" class="btn btn-outline-primary btn-rounded alignToTitle" target="_blank"> <i class="mdi mdi-printer"></i> <?php echo get_phrase('print'); ?></a>
                    <a href="<?php echo route('student'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-arrow-left"></i> <?php echo get_phrase('back'); ?></a>
                    <!-- <a href="<?php echo route('print_student_card/'.$student_id); ?>" target="_blank">Print</a> -->
                    <!-- <a href="<?php echo route('student/move'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"> <i class="mdi mdi-account-switch"></i> <?php echo get_phrase('move_student'); ?></a> -->
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
<div class="row d-print-none">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- Front Card Section -->
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-md-12 col-xl-8">                       
                        <div class="card" style="background-image: url(<?php echo base_url('assets/backend/images/card/1b.png') ?>);">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-12 col-md-12 d-flex justify-content-center align-items-center">
                                        <div class="media text-center">
                                            <div class="media-body overflow-hidden">
                                                <h3 class="card-text text-uppercase"><?=get_phrase('student_card');?></h3>
                                                <h3 class="card-text text-uppercase"><?=get_settings('system_title');?></h3>
                                                <p class="card-text">
                                                    <?=get_settings('address');?>
                                                    <?= 'Telp. '.get_settings('phone') ?>
                                                </p>
                                            </div>
                                        </div><a href="#" class="tile-link"></a>
                                    </div>
                                </div>
                                
                                <div class="row mb-3">
                                    <div class="col-md-8 text-left">
                                        <table class="name">
                                            <tr>
                                                <td colspan="3" class="text-center"><h5><?php echo $student['name'] ?></h5> </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-center" style="text-transform: uppercase;"><?php echo get_phrase($student['gender']) ?></td>
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
                                                <td><?php echo $this->db->get_where('district', array('id' => $student['birthday_place']))->row('name').', '.$student['birthday'] ?></td>
                                            </tr>
                                            <tr>
                                                <td>Agama</td>
                                                <td>:</td>
                                                <td><?= $student['religion'] ?></td>
                                            </tr>
                                        </table>                               
                                    </div>
                                    <div class="col-md-4 d-flex justify-content-center">
                                        <div class="container">
                                            <img src="<?= base_url().'/uploads/users/placeholder.jpg'; ?>" style="height: 100%; width: 100%;border:1px solid">
                                        </div>

                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center mb-3">
                                    <img style="width:145pt; height:28pt;z-index:6;" src="<?= route('barcode_create/'.$student['NIS']) ?>" alt="">
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 text-center">
                                        <p><i>Dicetak tanggal <?= date('d-M-Y')?></i></p>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Front Card Section -->

                <!-- Back Card Section -->
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-md-12 col-xl-8">                       
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-12 col-md-12 d-flex justify-content-center align-items-center">
                                        <div class="media text-center">
                                            <div class="media-body overflow-hidden">
                                                <h4 class="card-text text-uppercase"><u>KETENTUAN</u></h4>
                                            </div>
                                        </div><a href="#" class="tile-link"></a>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12 text-left">
                                        <table class="name">
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
                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Back Card Section -->

            </div>
        </div><!-- end col-->
    </div><!-- end col-->
</div>            
<script>
    function printDiv(areaID) { 
        var divContents = document.getElementById(areaID).innerHTML; 
        var a = window.open('', '', 'height=500, width=500'); 
        a.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"><html>'); 
        a.document.write('<body >'); 
        a.document.write(divContents); 
        a.document.write('</body></html>'); 
        a.document.close(); 
        a.print(); 
    }   
</script>