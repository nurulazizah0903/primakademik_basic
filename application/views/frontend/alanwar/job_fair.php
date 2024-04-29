<div class="wrapper">

<div class="main-section" id="home">

    <header>
        <div class="container">
            <div class="header-content d-flex flex-wrap align-items-center">
                <div class="logo">
                    <a href="<?= base_url() ?>" title="">
                        <img src="<?php echo $this->settings_model->get_favicon(); ?>" alt="" width="50" length="50"> 
                    </a>
                </div><!--logo end-->
                
                <div class="menu-btn">
                    <a href="#">
                        <span class="bar1"></span>
                        <span class="bar2"></span>
                        <span class="bar3"></span>
                    </a>
                </div><!--menu-btn end-->
            </div><!--header-content end-->
            <div class="navigation-bar d-flex flex-wrap align-items-center">
                <nav>
                    <ul>
                        <li><a href="<?php echo base_url(); ?>" title=""><i class="fas fa-arrow-left"></i></a></li>
                    </ul>
                </nav><!--nav end-->
            </div><!--navigation-bar end-->
        </div>
    </header><!--header end-->

    <div class="responsive-menu">
        <ul>
            <li><a href="<?php echo base_url(); ?>" title=""><i class="fas fa-arrow-left"></i></a></li>
        </ul>
    </div><!--responsive-menu end-->

    <section style="margin-bottom: 2em;">
        <div class="container">
            <div class="col align-items-center">
                <div class="container-md shadow-sm bg-light rounded px-4 py-4">
                  <h2 class="mb-3 text-center" style="font-size:28px; color: #2b2b2b;"><?php echo get_phrase('job_fair') ?> <?= get_frontend_settings('website_title') ?></h2>
                  <?php if (count($job_fairs) > 0): ?>
                    <table id="example" class="table table-striped dt-responsive" width="100%">
                        <thead>
                            <tr style="background-color: #313a46; color: #ababab;">
                                <th><?php echo get_phrase('job_fair_title'); ?></th>
                                <th><?php echo get_phrase('photo'); ?></th>
                                <th><?php echo get_phrase('description'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach($job_fairs as $job_fair):
                          ?>
                          <tr>
                              <td><?php echo $job_fair['title']; ?></td>
                              <td> <a href="<?= base_url();?>uploads/job_fair/<?= $job_fair['photo']?>" target="_blank" class="btn btn-info"><img class="w3-round" width="50" height="50" src="<?php echo $this->crud_model->get_job_fair_image($job_fair['photo']); ?>"></a> </td>
                              <td><?php echo $job_fair['description']; ?></td>
                          </tr>
                          <?php endforeach; ?>
                      </tbody>
                    </table>
                  <?php else: ?>
                    <center><?php include APPPATH.'views/backend/empty.php'; ?></center>
                  <?php endif; ?>
                </div>
            </div>
        </div>
    </section><!--main-banner end-->

</div><!--main-section end-->
</div>

<script type="text/javascript">
initDataTable('example');

</script>

<script src="<?php echo base_url();?>assets/frontend/alanwar/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/isotope.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/html5lightbox.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/slick.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/tweenMax.js"></script>
<script src="<?php echo base_url();?>assets/frontend/alanwar/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.bootstrap4.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/vendor/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/backend/js/pages/demo.datatable-init.js"></script>