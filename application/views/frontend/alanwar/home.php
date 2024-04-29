<div class="wrapper">

<div class="main-section" id="home">

    <header>
        <div class="container">
            <div class="header-content d-flex flex-wrap align-items-center">
                <div class="logo">
                    <a href="<?= base_url() ?>" title="">
                        <img src="<?php echo $this->settings_model->get_favicon(); ?>" alt="" width="80px" height="80px"> 
                    </a>
                </div><!--logo end-->
                <ul class="contact-add d-flex flex-wrap">
                    <li>
                        <div class="contact-info">
                            <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/img/icon1.png" alt="">
                            <div class="contact-tt">
                                <h4><?php echo get_phrase('contact'); ?></h4>
                                <span><?= get_settings('phone') ?></span>
                            </div>
                        </div><!--contact-info end-->
                    </li>
                    <li>
                        <div class="contact-info">
                            <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/img/icon2.png" alt="" width="30px" height="30px">
                            <div class="contact-tt">
                                <h4><?php echo get_phrase('email'); ?></h4>
                                <span><?= get_settings('system_email') ?></span>
                            </div>
                        </div><!--contact-info end-->
                    </li>
                    <li>
                        <div class="contact-info">
                            <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/img/icon3.png" alt="">
                            <div class="contact-tt">
                                <h4><?php echo get_phrase('alamat'); ?></h4>
                                <span><?= get_settings('address') ?></span>
                            </div>
                        </div><!--contact-info end-->
                    </li>
                </ul><!--contact-information end-->
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
                        <li><a href="#home" title=""><?php echo get_phrase('home'); ?></a></li>
                        <li><a href="#about" title=""><?php echo get_phrase('excellence'); ?></a></li>
                        <li><a href="#bottom" title=""><?php echo get_phrase('alamat'); ?></a></li>
                        <li><a href="<?php echo base_url().'home/simple_registration'; ?>" title=""><?php echo get_phrase('ppdb'); ?></a></li>
                        <li><a href="<?php echo base_url().'home/search'; ?>" title=""><?php echo get_phrase('cari'); ?></a></li>
                    </ul>
                </nav><!--nav end-->
                <ul class="social-links ml-auto">
                    <li><a href="<?php echo get_frontend_settings('facebook'); ?>" target="_blank" title=""><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="<?php echo get_frontend_settings('linkedin'); ?>" target="_blank" title=""><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="<?php echo get_frontend_settings('instagram'); ?>" target="_blank" title=""><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div><!--navigation-bar end-->
        </div>
    </header><!--header end-->

    <div class="responsive-menu">
        <ul>
        <li><a href="#home" title=""><?php echo get_phrase('home'); ?></a></li>
        <li><a href="#about" title=""><?php echo get_phrase('excellence'); ?></a></li>
        <li><a href="#bottom" title=""><?php echo get_phrase('alamat'); ?></a></li>
        <li><a href="<?php echo base_url().'home/simple_registration'; ?>" title=""><?php echo get_phrase('ppdb'); ?></a></li>
        <li><a href="<?php echo base_url().'home/search'; ?>" title=""><?php echo get_phrase('cari'); ?></a></li>
        </ul>
    </div><!--responsive-menu end-->

    <section class="main-banner">
        <div class="container">
        <!-- <?php
            $about_us_text  = get_frontend_settings('about_us');
            echo htmlspecialchars_decode(stripslashes($about_us_text));
            ?> -->
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-7">
                    <div class="banner-text wow fadeInLeft" data-wow-duration="1000ms">
                        <h2>
                            <?= get_frontend_settings('homepage_note_title') ?>
                        </h2>
                        <p><?= get_frontend_settings('homepage_note_description') ?></p>
                        
                        <a href="<?php echo base_url().'login' ?>" class="btn btn-xl btn-warning text-white p-2"><?php echo get_phrase('login'); ?></a>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5">
                    <div class="banner-img wow zoomIn" data-wow-duration="1000ms">
                        <img src="<?= $this->settings_model->get_logo_light() ?>" alt="" width="300px" height="300px">
                    </div><!--banner-img end-->
                    <div class="elements-bg wow zoomIn" data-wow-duration="1000ms"></div>
                </div>
            </div>
        </div>
    </section><!--main-banner end-->

    <h2 class="main-title"><?= get_frontend_settings('website_title') ?></h2>

</div><!--main-section end-->

<section class="about-us-section" id="about">
    <div  class="container">
        <div class="section-title text-center">
            <h2><?php echo get_phrase('excellence'); ?> <span><?= get_frontend_settings('website_title') ?></span></h2>
            <p><?= get_frontend_settings('website_title') ?> adalah sekolah dengan kualitas serta fasilitas yang sangat baik.</p>
        </div><!--section-title end-->
        <div class="about-sec">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="abt-col wow fadeInUp" data-wow-duration="1000ms">
                            <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/img/icon5.png" alt="">
                            <h3><?php echo get_frontend_settings('superiority_title_one'); ?></h3>
                            <p><?php echo get_frontend_settings('superiority_description_one'); ?></p>
                        </div><!--abt-col end-->
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="abt-col wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="200ms">
                            <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/img/icon7.png" alt="">
                            <h3><?php echo get_frontend_settings('superiority_title_two'); ?></h3>
                            <p><?php echo get_frontend_settings('superiority_description_two'); ?></p>
                        </div><!--abt-col end-->
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="abt-col wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/img/icon8.png" alt="">
                            <h3><?php echo get_frontend_settings('superiority_title_tree'); ?></h3>
                            <p><?php echo get_frontend_settings('superiority_description_tree'); ?></p>
                        </div><!--abt-col end-->
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="abt-col wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/img/icon9.png" alt="">
                            <h3><?php echo get_frontend_settings('superiority_title_four'); ?></h3>
                            <p><?php echo get_frontend_settings('superiority_description_four'); ?></p>
                        </div><!--abt-col end-->
                    </div>
                </div>
            </div>
        </div>

        <div class="abt-img">
            <ul class="masonary">
                <li class="width1 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_one(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_one(); ?>" alt=""></a></li>
                <li class="width2 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_two(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_two(); ?>" alt=""></a></li>
                <li class="width3 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_tree(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_tree(); ?>" alt=""></a></li>
                <li class="width4 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_4(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_4(); ?>" alt=""></a></li>
                <li class="width5 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_5(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_5(); ?>" alt=""></a></li>
                <li class="width6 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_6(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_6(); ?>" alt=""></a></li>
                <li class="width7 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_7(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_7(); ?>" alt=""></a></li>
                <li class="width8 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_8(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_8(); ?>" alt=""></a></li>
                <li class="width9 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_9(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_9(); ?>" alt=""></a></li>
                <li class="width10 wow zoomIn" data-wow-duration="1000ms"><a href="<?php echo $this->frontend_model->get_gallery_image_10(); ?>" data-group="set1" title="" class="html5lightbox"><img src="<?php echo $this->frontend_model->get_gallery_image_10(); ?>" alt=""></a></li>
            </ul>
        </div>
    </div>
</section>

<footer>
    <div class="container" id="bottom">
        <div class="section-title text-center">
            <h2><span><?= get_frontend_settings('website_title') ?></span>,</h2>
            <p>Siap mengembangkan potensi anak-anak Anda!</p>
        </div><!--section-title end-->

        <div class="top-footer">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="widget widget-about">
                        <img src="<?= $this->settings_model->get_logo_dark("smaill") ?>" alt="" width="250px" height="250px">
                        <p><?= get_settings('complete_address') ?></p>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="widget widget-iframe">
                        <div class="mapouter"><div class="gmap_canvas">
                            <div id="googleMap" style="width:700px;height:300px;"></div>
                        <style>.mapouter{position:relative;text-align:right;height:250px;width:600px;}</style>
                        <style>.gmap_canvas {overflow:hidden;background:none!important;height:250px;width:600px;}</style></div></div>
                    </div><!--widget-iframe end-->
                </div>
            </div>
        </div><!--top-footer end-->
        <div class="bottom-footer">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <p>© Copyrights 2021 <?= get_frontend_settings('website_title') ?> All rights reserved</p>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <ul class="social-links">
                    <li><a href="<?php echo get_frontend_settings('facebook'); ?>" target="_blank" title=""><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="<?php echo get_frontend_settings('linkedin'); ?>" target="_blank" title=""><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="<?php echo get_frontend_settings('instagram'); ?>" target="_blank" title=""><i class="fab fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div><!--bottom-footer end-->
    </div>
</footer><!--footer end-->

</div>

<script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/js/jquery.js"></script>
<script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/js/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/js/isotope.js"></script>
<script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/js/html5lightbox.js"></script>
<script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/js/slick.min.js"></script>
<script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/js/tweenMax.js"></script>
<script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/js/scripts.js"></script>   