<?php
  $school_title = get_settings('system_title');
  $theme        = get_frontend_settings('theme');
  $active_school_id = $this->frontend_model->get_active_school_id();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="<?php echo base_url(); ?>assets/backend/css/vendor/fullcalendar.min.css" rel="stylesheet" type="text/css" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/calender/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/style.css">
    <link rel="stylesheet" id="switcher-id" href="">
    
    <link rel="shortcut icon" href="<?php echo $this->settings_model->get_favicon(); ?>">
    <title><?php echo get_phrase($page_title); ?> | <?= get_frontend_settings('website_title'); ?></title>
    <!-- Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBn_ezlaiZJHDxbK28Kk_dIIxF52iRmo7g&callback=initialize" async defer></script>
    <script type="text/javascript">   
    var marker;
        function initialize(){
            // Variabel untuk menyimpan informasi lokasi
            var infoWindow = new google.maps.InfoWindow;
            //  Variabel berisi properti tipe peta
            var mapOptions = {
                mapTypeId: google.maps.MapTypeId.ROADMAP
            } 
            // Pembuatan peta
            var peta = new google.maps.Map(document.getElementById('googleMap'), mapOptions);      
            // Variabel untuk menyimpan batas kordinat
            var bounds = new google.maps.LatLngBounds();
            // Pengambilan data dari database MySQL
            <?php
            // Sesuaikan dengan konfigurasi koneksi Anda
            $nama =  get_settings('address');
                    $lat  =  get_frontend_settings('latitude') ;
                    $long =  get_frontend_settings('longitude') ;
                    echo "addMarker($lat, $long, '$nama');\n";
            ?> 
            // Proses membuat marker 
            function addMarker(lat, lng, info){
                var lokasi = new google.maps.LatLng(lat, lng);
                bounds.extend(lokasi);
                var marker = new google.maps.Marker({
                    map: peta,
                    position: lokasi
                });       
                peta.fitBounds(bounds);
                bindInfoWindow(marker, peta, infoWindow, info);
            }
            // Menampilkan informasi pada masing-masing marker yang diklik
            function bindInfoWindow(marker, peta, infoWindow, html){
                google.maps.event.addListener(marker, 'click', function() {
                infoWindow.setContent(html);
                infoWindow.open(peta, marker);
            });
            }
        }
    </script>
    <!-- Maps End -->

    <!-- Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBn_ezlaiZJHDxbK28Kk_dIIxF52iRmo7g&callback=initialize" async defer></script>
    <script type="text/javascript">   
    var marker;
        function initialize(){
            // Variabel untuk menyimpan informasi lokasi
            var infoWindow = new google.maps.InfoWindow;
            //  Variabel berisi properti tipe peta
            var mapOptions = {
                mapTypeId: google.maps.MapTypeId.ROADMAP
            } 
            // Pembuatan peta
            var peta = new google.maps.Map(document.getElementById('googleMap'), mapOptions);      
            // Variabel untuk menyimpan batas kordinat
            var bounds = new google.maps.LatLngBounds();
            // Pengambilan data dari database MySQL
            <?php
            // Sesuaikan dengan konfigurasi koneksi Anda
            $nama =  get_settings('address');
                    $lat  =  get_frontend_settings('latitude') ;
                    $long =  get_frontend_settings('longitude') ;
                    echo "addMarker($lat, $long, '$nama');\n";
            ?> 
            // Proses membuat marker 
            function addMarker(lat, lng, info){
                var lokasi = new google.maps.LatLng(lat, lng);
                bounds.extend(lokasi);
                var marker = new google.maps.Marker({
                    map: peta,
                    position: lokasi
                });       
                peta.fitBounds(bounds);
                bindInfoWindow(marker, peta, infoWindow, info);
            }
            // Menampilkan informasi pada masing-masing marker yang diklik
            function bindInfoWindow(marker, peta, infoWindow, html){
                google.maps.event.addListener(marker, 'click', function() {
                infoWindow.setContent(html);
                infoWindow.open(peta, marker);
            });
            }
        }
    </script>
    <!-- Maps End -->
</head>
<!-- https://www.studytonight.com/post/build-a-theme-switcher-for-your-website-with-javascript -->

<body>
    <!-- Main Navbar -->
    <nav class="navbar-expand-sm shadow font-poppins navbar-dark bg-1 position-relative">
        <div class="container-fluid px-0 ">
            <div class="position-relative container-fluid px-0 d-flex justify-content-center ps-lg-5 ps-3">
                <a class="navbar-brand me-0" href="<?php echo get_frontend_settings('facebook'); ?>">
                    <i class="fab fa-lg fa-facebook"></i>
                </a>
                <a class="navbar-brand me-0 px-3" href="<?php echo get_frontend_settings('instagram'); ?>">
                    <i class="fab fa-lg fa-instagram"></i>
                </a>
                <a class="navbar-brand me-0" href="<?php echo get_frontend_settings('twitter'); ?>">
                    <i class="fab fa-lg fa-twitter"></i>
                </a>
            </div>
            <div class="position-absolute top-0 pt-1 d-lg-block d-none pr-3" style="right: 3%;">
                <button class="btn px-4 bg-3 btn-sm py-1 text-white ml-3 shadow-none rounded-pill" type="button"
                    data-bs-toggle="modal" data-bs-target="#loginModal">
                    <svg width="15" class="me-2" height="23" viewBox="0 0 27 35" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M18.2315 14.4128C20.8167 11.8276 20.8358 7.65492 18.274 5.09308C15.7121 2.53124 11.5395 2.55032 8.95422 5.13559C6.36895 7.72086 6.35022 11.8932 8.91206 14.455C11.4739 17.0168 15.6462 16.9981 18.2315 14.4128Z"
                            fill="currentColor" />
                        <path
                            d="M7.93896 20.4101H19.2393C21.2231 20.4101 23.1255 21.1982 24.5283 22.601C25.9311 24.0038 26.7192 25.9063 26.7192 27.8902C26.7192 29.569 26.0523 31.179 24.8652 32.3661C23.6781 33.5532 22.068 34.2201 20.3892 34.2201H6.77881C5.09999 34.2201 3.49033 33.5532 2.30322 32.3661C1.11612 31.179 0.449219 29.569 0.449219 27.8902C0.449219 25.9063 1.23688 24.0038 2.63965 22.601C4.04242 21.1982 5.94538 20.4101 7.9292 20.4101H7.93896Z"
                            fill="currentColor" />
                    </svg>
                    <?php echo get_phrase('login'); ?>
                </button>
            </div>
        </div>
    </nav>
    <!-- End:Main Navbar -->

    <!-- Menu Mobile -->
    <nav id="mob-nav"
        class="navbar d-lg-none d-block mb-5 rounded-pill shadow fixed-bottom navbar-light mx-auto w-max-95 py-1 bg-light">
        <div class="d-flex flex-row justify-content-center py-1 px-1 gap-md-5 gap-4">
            <li class="d-flex align-items-center justify-content-center ">
                <a class="navbar-brand mx-0 d-flex align-items-center justify-content-center " href="#aboutUs">
                    <svg class="nav-mobsize-1 nav-icon-desktop" viewBox="0 0 108 71" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M95.82 0H11.74C8.62635 0 5.64021 1.23689 3.43854 3.43857C1.23686 5.64025 0 8.62636 0 11.74V59.26C0 62.3736 1.23686 65.3598 3.43854 67.5614C5.64021 69.7631 8.62635 71 11.74 71H95.82C98.9336 71 101.92 69.7631 104.121 67.5614C106.323 65.3598 107.56 62.3736 107.56 59.26V11.74C107.56 8.62636 106.323 5.64025 104.121 3.43857C101.92 1.23689 98.9336 0 95.82 0ZM60.5 38.76H86.5C86.9502 38.7908 87.37 38.9984 87.6678 39.3375C87.9657 39.6765 88.1175 40.1195 88.09 40.57C88.1176 41.0215 87.9661 41.4657 87.6685 41.8063C87.3709 42.1469 86.9511 42.3567 86.5 42.39H60.5C60.0489 42.3567 59.6291 42.1469 59.3315 41.8063C59.0339 41.4657 58.8824 41.0215 58.91 40.57C58.8825 40.1195 59.0343 39.6765 59.3322 39.3375C59.63 38.9984 60.0498 38.7908 60.5 38.76V38.76ZM24.79 9.65C28.5606 9.66058 32.1735 11.1652 34.8369 13.8343C37.5004 16.5034 38.9974 20.1193 39 23.89C39 27.6667 37.4997 31.2887 34.8292 33.9592C32.1587 36.6297 28.5367 38.13 24.76 38.13C20.9833 38.13 17.3613 36.6297 14.6908 33.9592C12.0203 31.2887 10.52 27.6667 10.52 23.89C10.5213 22.0178 10.8915 20.1643 11.6095 18.4352C12.3275 16.7062 13.3791 15.1356 14.7043 13.8131C16.0296 12.4907 17.6024 11.4423 19.3329 10.728C21.0635 10.0137 22.9178 9.64737 24.79 9.65V9.65ZM39.89 60.84H10.74V56.55C10.7453 52.6875 12.2841 48.9852 15.0181 46.2568C17.7521 43.5285 21.4575 41.9973 25.32 42C27.2334 42 29.128 42.3769 30.8957 43.1091C32.6634 43.8413 34.2696 44.9145 35.6226 46.2675C36.9755 47.6204 38.0487 49.2266 38.7809 50.9943C39.5132 52.762 39.89 54.6566 39.89 56.57V60.84ZM96 60H60.5C60.0498 59.9692 59.63 59.7616 59.3322 59.4225C59.0343 59.0835 58.8825 58.6405 58.91 58.19C58.8798 57.7379 59.0303 57.2923 59.3284 56.951C59.6266 56.6098 60.0479 56.4008 60.5 56.37H96C96.4503 56.4033 96.8692 56.6134 97.1652 56.9543C97.4612 57.2953 97.6103 57.7395 97.58 58.19C97.6076 58.6388 97.4572 59.0805 97.1614 59.4192C96.8657 59.758 96.4484 59.9667 96 60V60ZM96 51.59H60.5C60.0489 51.5567 59.6291 51.3469 59.3315 51.0063C59.0339 50.6657 58.8824 50.2215 58.91 49.77C58.8933 49.3263 59.0499 48.8935 59.3467 48.5631C59.6434 48.2328 60.057 48.0308 60.5 48H96C96.4484 48.0333 96.8657 48.242 97.1614 48.5808C97.4572 48.9195 97.6076 49.3612 97.58 49.81C97.5969 50.2532 97.442 50.6857 97.1476 51.0174C96.8532 51.3491 96.442 51.5542 96 51.59V51.59Z"
                            fill="currentColor" />
                    </svg>
                </a>
            </li>
            <li class="d-flex align-items-center justify-content-center">
                <a class="navbar-brand mx-0 d-flex align-items-center justify-content-center " href="#newsFlashIds">
                    <svg class="nav-mobsize-2 nav-icon-desktop" viewBox="0 0 128 82" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M127.32 60.8301L106.74 47.5601V53.1801H88.47C86.083 53.1801 83.7938 54.1283 82.106 55.8161C80.4182 57.5039 79.47 59.7931 79.47 62.1801V82.0001H94.76V71.4601C94.76 70.6644 95.0761 69.9014 95.6387 69.3387C96.2013 68.7761 96.9644 68.4601 97.76 68.4601H106.76V74.08L127.32 60.8301Z"
                            fill="currentColor" />
                        <path
                            d="M64.31 56.19C64.31 56.19 64.31 56.12 64.31 56.09H18.85C18.4837 56.0838 18.1283 55.9655 17.8314 55.7509C17.5346 55.5363 17.3107 55.2358 17.19 54.89C17.0458 54.5363 17.0058 54.1486 17.075 53.7729C17.1441 53.3972 17.3193 53.0492 17.58 52.77L32.85 36.31C33.1528 35.9739 33.5764 35.7716 34.0281 35.7472C34.4798 35.7229 34.9228 35.8785 35.26 36.18L42.44 42.5L59.23 23.93C59.3896 23.7468 59.5861 23.5995 59.8068 23.4978C60.0274 23.3961 60.2671 23.3423 60.51 23.34V23.34C60.7555 23.3472 60.9968 23.4051 61.2188 23.51C61.4408 23.615 61.6387 23.7648 61.8 23.95L75.3 39.38C77.6099 38.3766 80.1016 37.8592 82.62 37.86H108.55V18.8C108.547 13.9376 106.614 9.27534 103.175 5.83809C99.7357 2.40083 95.0724 0.46997 90.21 0.469971H18.62C13.7577 0.46997 9.09434 2.40083 5.65521 5.83809C2.21608 9.27534 0.282681 13.9376 0.280029 18.8V53C0.280029 57.864 2.21226 62.5289 5.65167 65.9683C9.09109 69.4077 13.7559 71.34 18.62 71.34H64.28L64.31 56.19ZM31.39 14.65C33.6939 14.6526 35.9027 15.569 37.5319 17.1981C39.161 18.8273 40.0774 21.036 40.08 23.34C40.0774 25.6439 39.161 27.8527 37.5319 29.4818C35.9027 31.1109 33.6939 32.0273 31.39 32.03C29.0861 32.0273 26.8773 31.1109 25.2482 29.4818C23.6191 27.8527 22.7027 25.6439 22.7 23.34C22.7027 21.036 23.6191 18.8273 25.2482 17.1981C26.8773 15.569 29.0861 14.6526 31.39 14.65V14.65Z"
                            fill="currentColor" />
                    </svg>
                </a>
            </li>
            <li class="d-flex align-items-center justify-content-center">
                <a class="navbar-brand mx-0 d-flex align-items-center justify-content-center " href="#keunggulanIds">
                    <svg class="nav-mobsize-3 nav-icon-desktop" viewBox="0 0 117 155" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M76.4501 37.5899C76.4474 42.5053 75.4767 47.372 73.5932 51.9122C71.7097 56.4524 68.9505 60.5772 65.4729 64.0511C61.9953 67.5249 57.8677 70.2798 53.3254 72.1584C48.7832 74.037 43.9154 75.0025 39.0001 74.9999C34.0838 75.0012 29.2155 74.034 24.6732 72.1536C20.1308 70.2732 16.0034 67.5163 12.5266 64.0405C9.04986 60.5646 6.29188 56.4379 4.41022 51.8961C2.52856 47.3542 1.56006 42.4861 1.56006 37.5699C1.56536 27.6446 5.51256 18.1278 12.5336 11.1123C19.5547 4.09686 29.0747 0.157264 39.0001 0.159917C43.9171 0.15729 48.7865 1.1235 53.33 3.00336C57.8735 4.88322 62.0022 7.63986 65.48 11.1158C68.9578 14.5918 71.7167 18.7189 73.5989 23.2614C75.4812 27.804 76.4501 32.6728 76.4501 37.5899V37.5899Z"
                            fill="currentColor" />
                        <path
                            d="M27.83 111C27.1925 110.541 26.7173 109.891 26.4729 109.144C26.2285 108.398 26.2274 107.593 26.4698 106.845C26.7123 106.098 27.1857 105.447 27.8219 104.986C28.4581 104.525 29.2243 104.278 30.0099 104.28H62.2399C63.0245 104.28 63.7888 104.031 64.423 103.569C65.0573 103.108 65.5289 102.457 65.77 101.71L69.4199 90.48C65.8479 85.8099 61.2466 82.0269 55.9739 79.4253C50.7013 76.8236 44.8995 75.4735 39.02 75.48C28.8595 75.48 19.1152 79.5162 11.9307 86.7007C4.74615 93.8853 0.709961 103.63 0.709961 113.79V125.07H47.1599L27.83 111Z"
                            fill="currentColor" />
                        <path
                            d="M86.1099 93.0501L92.3299 112.19C92.4803 112.658 92.7753 113.066 93.1725 113.355C93.5697 113.645 94.0485 113.8 94.5399 113.8H114.67C115.158 113.806 115.631 113.966 116.023 114.257C116.415 114.548 116.705 114.954 116.853 115.42C117 115.885 116.997 116.384 116.844 116.848C116.691 117.311 116.395 117.714 116 118L99.7099 129.83C99.314 130.12 99.0196 130.527 98.8688 130.994C98.718 131.461 98.7184 131.963 98.8699 132.43L105.09 151.58C105.24 152.046 105.239 152.547 105.087 153.012C104.935 153.477 104.64 153.882 104.244 154.17C103.848 154.457 103.371 154.612 102.882 154.612C102.393 154.612 101.916 154.457 101.52 154.17L85.2299 142.34C84.8327 142.053 84.355 141.898 83.8649 141.898C83.3748 141.898 82.8971 142.053 82.4999 142.34L66.2099 154.17C65.8138 154.457 65.337 154.612 64.8478 154.612C64.3585 154.612 63.8817 154.457 63.4856 154.17C63.0896 153.882 62.7946 153.477 62.6427 153.012C62.4908 152.547 62.4898 152.046 62.6399 151.58L68.8599 132.43C69.012 131.963 69.0116 131.459 68.8589 130.992C68.7061 130.524 68.4088 130.118 68.0099 129.83L51.7699 118C51.3725 117.713 51.0764 117.307 50.924 116.841C50.7717 116.374 50.7711 115.872 50.9222 115.405C51.0732 114.939 51.3683 114.532 51.765 114.244C52.1617 113.955 52.6395 113.8 53.1299 113.8H73.2599C73.7513 113.8 74.2301 113.645 74.6273 113.355C75.0245 113.066 75.3195 112.658 75.4699 112.19L81.6899 93.0501C81.8396 92.5815 82.1343 92.1726 82.5316 91.8825C82.9288 91.5924 83.408 91.436 83.8999 91.436C84.3919 91.436 84.871 91.5924 85.2682 91.8825C85.6655 92.1726 85.9602 92.5815 86.1099 93.0501V93.0501Z"
                            fill="currentColor" />
                    </svg>
                </a>
            </li>
            <li class="d-flex align-items-center justify-content-center">
                <a class="navbar-brand mx-0 d-flex align-items-center justify-content-center " href="#galleryIds">
                    <svg class="nav-mobsize-4 nav-icon-desktop" viewBox="0 0 109 72" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M90.2401 0.860107H18.6501C13.7877 0.860107 9.12437 2.79098 5.68524 6.22823C2.24611 9.66549 0.31271 14.3278 0.310059 19.1901V53.3801C0.310058 55.7881 0.784505 58.1725 1.7063 60.397C2.62809 62.6216 3.97915 64.6427 5.68231 66.3449C7.38547 68.0471 9.40733 69.3971 11.6324 70.3177C13.8574 71.2383 16.2421 71.7114 18.6501 71.7101H90.2401C92.648 71.7114 95.0326 71.2383 97.2577 70.3177C99.4827 69.3971 101.505 68.0471 103.208 66.3449C104.911 64.6427 106.262 62.6216 107.184 60.397C108.106 58.1725 108.58 55.7881 108.58 53.3801V19.1901C108.577 14.3278 106.644 9.66549 103.205 6.22823C99.7658 2.79098 95.1024 0.860107 90.2401 0.860107V0.860107ZM31.3901 15.0001C33.694 15.0028 35.9028 15.9192 37.5319 17.5483C39.161 19.1774 40.0774 21.3862 40.0801 23.6901C40.0774 25.994 39.161 28.2028 37.5319 29.8319C35.9028 31.4611 33.694 32.3775 31.3901 32.3801C29.0862 32.3775 26.8773 31.4611 25.2482 29.8319C23.6191 28.2028 22.7027 25.994 22.7001 23.6901C22.7027 21.3862 23.6191 19.1774 25.2482 17.5483C26.8773 15.9192 29.0862 15.0028 31.3901 15.0001V15.0001ZM87.3901 55.2601C87.2667 55.6006 87.0429 55.8957 86.7484 56.1064C86.4538 56.3171 86.1022 56.4334 85.7401 56.4401H18.8301C18.4642 56.4325 18.1093 56.3136 17.8127 56.0993C17.5162 55.8849 17.292 55.5852 17.17 55.2401C17.0258 54.8864 16.9859 54.4988 17.055 54.1231C17.1241 53.7474 17.2994 53.3993 17.5601 53.1201L32.8301 36.6601C32.9793 36.4926 33.1602 36.3562 33.3624 36.2589C33.5645 36.1616 33.784 36.1053 34.008 36.0932C34.232 36.0811 34.4563 36.1135 34.6677 36.1885C34.8792 36.2635 35.0737 36.3796 35.2401 36.5301L42.42 42.8501L59.2101 24.2701C59.3714 24.0897 59.5685 23.945 59.7889 23.8451C60.0093 23.7453 60.2481 23.6925 60.4901 23.6901V23.6901C60.7363 23.6929 60.9791 23.7488 61.2017 23.8541C61.4244 23.9594 61.6217 24.1115 61.7801 24.3001L87.0201 53.1601C87.281 53.4433 87.4568 53.7942 87.5276 54.1726C87.5983 54.5511 87.5611 54.9418 87.42 55.3001L87.3901 55.2601Z"
                            fill="currentColor" />
                    </svg>
                </a>
            </li>
            <li class="d-flex align-items-center justify-content-center">
                <a class="navbar-brand mx-0 d-flex align-items-center justify-content-center " data-bs-toggle="modal"
                    data-bs-target="#KalenderModal" href="#">
                    <svg class="nav-mobsize-5 nav-icon-desktop" viewBox="0 0 41 48" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4 7C1.79086 7 0 8.79086 0 11V44C0 46.2091 1.79086 48 4 48H37C39.2091 48 41 46.2091 41 44V11C41 8.79086 39.2091 7 37 7H4ZM35.469 38.4663C35.469 40.6754 33.6781 42.4663 31.469 42.4663H9.53103C7.32189 42.4663 5.53102 40.6754 5.53102 38.4663V16.5337C5.53102 14.3246 7.32189 12.5337 9.53102 12.5337H31.469C33.6781 12.5337 35.469 14.3246 35.469 16.5337V38.4663Z"
                            fill="currentColor" />
                        <path
                            d="M27.5 20H26.5C25.1193 20 24 21.1193 24 22.5C24 23.8807 25.1193 25 26.5 25H27.5C28.8807 25 30 23.8807 30 22.5C30 21.1193 28.8807 20 27.5 20Z"
                            fill="currentColor" />
                        <path
                            d="M21.5 31H14.5C13.1193 31 12 32.1193 12 33.5C12 34.8807 13.1193 36 14.5 36H21.5C22.8807 36 24 34.8807 24 33.5C24 32.1193 22.8807 31 21.5 31Z"
                            fill="currentColor" />
                        <path
                            d="M15 6.5V2.5C15 1.11929 13.8807 0 12.5 0C11.1193 0 10 1.11929 10 2.5V6.5C10 7.88071 11.1193 9 12.5 9C13.8807 9 15 7.88071 15 6.5Z"
                            fill="currentColor" />
                        <path
                            d="M31 6.5V2.5C31 1.11929 29.8807 0 28.5 0C27.1193 0 26 1.11929 26 2.5V6.5C26 7.88071 27.1193 9 28.5 9C29.8807 9 31 7.88071 31 6.5Z"
                            fill="currentColor" />
                    </svg>
                </a>
            </li>
            <li class="d-flex align-items-center justify-content-center">
                <a class="navbar-brand mx-0 d-flex align-items-center justify-content-center " data-bs-toggle="modal"
                    data-bs-target="#ppdbMobileModals" href="#">
                    <svg class="nav-mobsize-6 nav-icon-desktop" viewBox="0 0 156 76" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M86 44.12L104 19.53V18.45C104 13.5568 102.056 8.86392 98.5961 5.40387C95.1361 1.94382 90.4432 0 85.55 0H18.45C13.5568 0 8.86392 1.94382 5.40387 5.40387C1.94382 8.86392 0 13.5568 0 18.45V52.55C0 57.4432 1.94382 62.1361 5.40387 65.5961C8.86392 69.0562 13.5568 71 18.45 71H85.55H86V44.12ZM61 61H17V48H61V61ZM83 36H17V16H83V36Z"
                            fill="currentColor" />
                        <path
                            d="M133.21 6.84986L101 50.8499V75.1999L122.21 65.7799L156 23.3499C156 23.3499 149.71 4.48986 133.21 6.84986Z"
                            fill="currentColor" />
                    </svg>
                </a>
            </li>
        </div>
    </nav>
    <!-- End:Menu Mobile -->

    <!-- Login Modal-->
    <div class="modal align-items-center fade overflow-auto" id="loginModal" tabindex="-1" aria-labelledby="loginModals"
        aria-hidden="true">
        <div
            class="modal-dialog LoginBg d-flex flex-column align-items-center justify-content-center modal-dialog-centered">
            <div class="w-100 h-100 bg-transparent mx-5 px-5 position-relative">
                <button type="button" class="btn-login-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header ms-lg-5 ms-4 mb-lg-3 mb-0 border-0 justify-content-center flex-column">
                    <h5 class="modal-title mb-lg-4 mb-3 font-size-7 font-size-sm-1 color-5 fw-bolder">Login</h5>
                    <div class="loginVector login-vector-responsive"></div>
                </div>
                <div class="modal-body d-flex flex-column align-items-center justify-content-center ms-lg-5 ms-4 px-4">
                    <button type="button" onclick="location.href='<?php echo base_url().'login' ?>'"
                        class="btn w-100 w-max-95 font-size-sm-2 fs-xs-5 shadow-none rounded-pill font-poppins d-flex flex-row justify-content-center align-items-center position-relative btn-logins">
                        <img class="miniButtonIcon" width="7%" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/miniPeople.svg" alt="">
                        <?php echo get_phrase('teacher'); ?>
                    </button>
                    <button type="button" data-bs-target="#loginSiswa" data-bs-toggle="modal"
                        class="btn w-100 w-max-95 font-size-sm-2 fs-xs-5 shadow-none rounded-pill font-poppins d-flex flex-row justify-content-center align-items-center position-relative btn-logins my-2 my-lg-3">
                        <img class="miniButtonIcon" width="7%" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/miniPeople.svg" alt="">
                        <?php echo get_phrase('student'); ?>
                    </button>
                    <button type="button" data-bs-target="#loginWali" data-bs-toggle="modal"
                        class="btn w-100 w-max-95 font-size-sm-2 fs-xs-5 shadow-none rounded-pill font-poppins d-flex flex-row justify-content-center align-items-center position-relative btn-logins">
                        <img class="miniButtonIcon" width="7%" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/miniPeople.svg" alt="">
                        <?php echo get_phrase('parent'); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- End: Login Modal -->
    <!-- SignUp -->
    <div class="modal align-items-center fade overflow-auto" id="SignUpModal" tabindex="-1"
        aria-labelledby="SignUpModals" aria-hidden="true">
        <div
            class="modal-dialog LoginBg d-flex flex-column align-items-center justify-content-center modal-dialog-centered">
            <div class="w-100 h-100 bg-transparent mx-5 px-5 position-relative">
                <button type="button" class="btn-login-close-5 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div
                    class="modal-header py-lg-0 py-2 ms-lg-5 ms-4 mb-lg-2 mb-0 border-0 justify-content-center flex-column">
                    <h5 class="modal-title mb-lg-2 mb-3 font-size-7 font-size-sm-6 color-5 fw-bolder">Sign Up</h5>
                    <div class="loginVectors login-vector-responsive"></div>
                </div>
                <div
                    class="modal-body d-flex flex-column align-items-center justify-content-center ms-lg-5 ms-4 px-4 py-0">
                    <div class="my-1 w-100 w-max-95 input-group-sm">
                        <label for="SignUplogin"
                            class="font-poppins form-label font-size-sm-4 fs-xs-5 mb-0 mb-md-1 shadow-none">Email
                            address</label>
                        <input type="email" class="font-poppins form-control p-lg-2 font-size-sm-2 fs-xs-5"
                            id="SignUplogin" placeholder="nama@google.com">
                    </div>
                    <div class="mt-1 w-100 w-max-95 input-group-sm">
                        <label for="SignUpPassword"
                            class="font-poppins form-label font-size-sm-4 fs-xs-5 mb-0 mb-md-1 shadow-none">Password</label>
                        <input type="password" class="font-poppins form-control p-lg-2 font-size-sm-2 fs-xs-5"
                            id="SignUpPassword">
                    </div>
                    <button type="button"
                        class="btn w-100 w-max-95 shadow-none rounded-pill d-flex flex-row justify-content-center align-items-center position-relative font-poppins btn-logins my-2 mt-lg-3">
                        <a href="siswaMainPage.html" class="text-decoration-none text-white fs-xs-3">
                            Login
                        </a>
                    </button>
                    <p class="font-size-9 mt-lg-2 mb-lg-3 font-poppins fs-xs-1">belum punya akun?
                        <a href="" data-bs-target="#SignUpModal" data-bs-toggle="modal">Login!</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- End:SignUp -->

    <!-- LoginSiswa -->
    <div class="modal align-items-center fade overflow-auto" id="loginSiswa" tabindex="-1" aria-labelledby="loginSiswas"
        aria-hidden="true">
        <div
            class="modal-dialog LoginBg d-flex flex-column align-items-center justify-content-center modal-dialog-centered">
            <div class="w-100 h-100 bg-transparent mx-5 px-5 position-relative">
                <button type="button" class="btn-login-close-5 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header py-1 ms-lg-5 ms-4 mb-lg-3 mb-1 border-0 justify-content-center flex-column">
                    <h5 class="modal-title mb-lg-4 mb-2 font-size-7 font-size-sm-6 color-5 fw-bolder">Login Siswa</h5>
                    <div class="loginVectors login-vector-responsive"></div>
                </div>
                <div
                    class="modal-body d-flex flex-column align-items-center justify-content-center ms-lg-5 ms-4 px-4 py-0">
                    <div class="my-1 w-100 w-max-95 input-group-sm">
                    <form action="<?php echo site_url('login/validate_login'); ?>" method="post" id="loginForm">
                        <label for="Siswalogin"
                            class="font-poppins form-label font-size-sm-4 fs-xs-5 mb-0 mb-md-1 shadow-none"><?php echo get_phrase('email'); ?></label>
                        <input class="font-poppins form-control p-lg-2 font-size-sm-2 fs-xs-5"
                        type="text" name="email" id="emailaddress" required="" placeholder="<?php echo get_phrase('enter_your_email'); ?>">
                    </div>
                    <div class="mt-1 w-100 w-max-95 input-group-sm">
                        <label for="SiswaPassword"
                            class="font-poppins form-label font-size-sm-4 fs-xs-5 mb-0 mb-md-1 shadow-none">Password</label>
                        <input type="password" class="font-poppins form-control p-lg-2 font-size-sm-2 fs-xs-5"
                        name="password" required="" id="password" placeholder="<?php echo get_phrase('enter_your_password'); ?>">
                    </div>
                    <button type="submit"
                        class="btn w-100 w-max-95 shadow-none rounded-pill d-flex flex-row justify-content-center align-items-center position-relative font-poppins btn-logins mt-3 mb-lg-5 mb-4 mt-lg-3">
                        <?php echo get_phrase('login'); ?>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End:LoginSiswa -->

    <!-- Login Wali -->
    <div class="modal align-items-center fade overflow-auto" id="loginWali" tabindex="-1" aria-labelledby="loginWalis"
        aria-hidden="true">
        <div
            class="modal-dialog LoginBg d-flex flex-column align-items-center justify-content-center modal-dialog-centered">
            <div class="w-100 h-100 bg-transparent mx-5 px-5 position-relative">
                <button type="button" class="btn-login-close-5 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header py-1 ms-lg-5 ms-4 mb-lg-3 mb-1 border-0 justify-content-center flex-column">
                    <h5 class="modal-title mb-lg-4 mb-2 font-size-7 font-size-sm-6 color-5 fw-bolder">Login Wali</h5>
                    <div class="loginVectors login-vector-responsive"></div>
                </div>
                <div
                    class="modal-body d-flex flex-column align-items-center justify-content-center ms-lg-5 ms-4 px-4 py-0">
                    <div class="my-1 w-100 w-max-95 input-group-sm">
                    <form action="<?php echo site_url('login/validate_login'); ?>" method="post" id="loginForm">
                        <label for="Siswalogin"
                            class="font-poppins form-label font-size-sm-4 fs-xs-5 mb-0 mb-md-1 shadow-none"><?php echo get_phrase('email'); ?></label>
                        <input class="font-poppins form-control p-lg-2 font-size-sm-2 fs-xs-5"
                        type="text" name="email" id="emailaddress" required="" placeholder="<?php echo get_phrase('enter_your_email'); ?>">
                    </div>
                    <div class="mt-1 w-100 w-max-95 input-group-sm">
                        <label for="SiswaPassword"
                            class="font-poppins form-label font-size-sm-4 fs-xs-5 mb-0 mb-md-1 shadow-none">Password</label>
                        <input type="password" class="font-poppins form-control p-lg-2 font-size-sm-2 fs-xs-5"
                        name="password" required="" id="password" placeholder="<?php echo get_phrase('enter_your_password'); ?>">
                    </div>
                    <button type="submit"
                        class="btn w-100 w-max-95 shadow-none rounded-pill d-flex flex-row justify-content-center align-items-center position-relative font-poppins btn-logins mt-3 mb-lg-5 mb-4 mt-lg-3">
                        <?php echo get_phrase('login'); ?>
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End:Login Wali -->

    <!-- End:Login Modal -->

    <!-- PPDB Modal-->
    <!-- Desktop Version -->
    <div class="modal align-items-center fade overflow-auto" id="PpdbModal" tabindex="-1" aria-labelledby="PPBDmodals"
        aria-hidden="true">
        <div
            class="modal-dialog PpdbLoginBg d-flex flex-column align-items-center justify-content-center modal-dialog-centered">
            <div class="w-100 mx-height-1 bg-transparent ms-5 ps-5 position-relative  align-items-center">
                <button type="button" class="btn-login-close-2 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header mt-5 pt-5 mb-lg-3 mb-0 border-0 position-relative">
                    <h5
                        class="modal-title mb-lg-4 mb-3 pb-3 font-size-7 font-size-sm-1 position-absolute right-2 text-white fw-bolder">
                        <?php echo get_phrase('ppdb_online'); ?>
                    </h5>
                </div>
                <div class="modal-body mt-4 pt-5 position-relative">
                    <div class="w-40 position-absolute right-1">
                    <a href="<?php echo base_url().'home/registration'; ?>" style="text-decoration:none">
                        <button type="button"
                            class="btn w-100 w-max-95 shadow-none rounded-pill d-flex flex-row justify-content-start align-items-center position-relative btn-logins-2 fw-normal psp-lg-6">
                            <svg class="miniButtonIcon" width="9%" width="42" height="48" viewBox="0 0 42 48"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.421875 6.42993V47.1799H41.1919V6.42993H0.421875ZM35.6919 41.6799H5.92188V11.9299H35.6919V41.6799Z"
                                    fill="currentColor" />
                                <path d="M30.5389 19.6699H12.3789V24.9398H30.5389V19.6699Z" fill="currentColor" />
                                <path d="M29.6216 19.6699H24.3516V24.9398H29.6216V19.6699Z" fill="currentColor" />
                                <path d="M24.0889 30.49H12.3789V35.76H24.0889V30.49Z" fill="currentColor" />
                                <path d="M14.8684 0.919983H9.89844V9.53998H14.8684V0.919983Z" fill="currentColor" />
                                <path d="M31.7005 0.919983H26.7305V9.53998H31.7005V0.919983Z" fill="currentColor" />
                            </svg>
                            <?php echo get_phrase('daftar_ppdb_online'); ?>
                        </button></a>
                        <a href="<?php echo base_url().'home/search'; ?>" style="text-decoration:none">
                        <button type="button"
                            class="btn w-100 w-max-95 shadow-none rounded-pill d-flex flex-row justify-content-start align-items-center position-relative btn-logins-2 fw-normal my-2 my-lg-3 psp-lg-6">
                            <svg class="miniButtonIcon" width="11%" width="55" height="47" viewBox="0 0 55 47"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0.421875 6V46.75H41.1919V6H0.421875ZM35.6919 41.25H5.92188V11.5H35.6919V41.25Z"
                                    fill="currentColor" />
                                <path d="M30.5389 19.2H12.3789V24.47H30.5389V19.2Z" fill="currentColor" />
                                <path d="M24.0889 30.01H12.3789V35.28H24.0889V30.01Z" fill="currentColor" />
                                <path d="M14.8684 0.439941H9.89844V9.06006H14.8684V0.439941Z" fill="currentColor" />
                                <path d="M31.7005 0.439941H26.7305V9.06006H31.7005V0.439941Z" fill="currentColor" />
                                <path
                                    d="M43.26 2.06984L27 24.2999V36.6099L37.72 31.8399L54.79 10.3999C54.79 10.3999 51.59 0.86984 43.26 2.06984Z"
                                    fill="currentColor" />
                            </svg>
                            <?php echo get_phrase('cek_status_ppdb'); ?>
                        </button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End:Desktop Version -->
    <!-- Mobile Version -->
    <div class="modal align-items-center fade overflow-auto" id="ppdbMobileModals" tabindex="-1"
        aria-labelledby="ppdbMobileModals" aria-hidden="true">
        <div
            class="modal-dialog ppdbLoginMobile d-flex flex-column align-items-center justify-content-center modal-dialog-centered">
            <div class="w-100 h-100 bg-transparent mx-5 px-5 position-relative">
                <button type="button" class="btn-login-close shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                <div class="modal-header ms-lg-5 ms-4 mb-lg-3 mb-0 border-0 justify-content-center flex-column">
                    <h5 class="modal-title mb-lg-4 mb-3 font-size-7 font-size-sm-1 fs-xs-6 text-white fw-bolder">
                    <?php echo get_phrase('ppdb_online'); ?>
                    </h5>
                    <div class="ppdbPeoples"></div>
                </div>
                <div
                    class="modal-body d-flex flex-column align-items-center justify-content-center gap-2 ms-lg-5 ms-4 px-1">
                    <a href="<?php echo base_url().'home/registration'; ?>" style="text-decoration:none">
                    <button type="button"
                        class="btn w-100 w-max-95 shadow-none rounded-pill d-flex flex-row justify-content-start align-items-center position-relative btn-logins-2 fw-normal psp-lg-6 fs-xs-3">
                        <svg class="miniButtonIcon" width="9%" width="42" height="48" viewBox="0 0 42 48"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.421875 6.42993V47.1799H41.1919V6.42993H0.421875ZM35.6919 41.6799H5.92188V11.9299H35.6919V41.6799Z"
                                fill="currentColor" />
                            <path d="M30.5389 19.6699H12.3789V24.9398H30.5389V19.6699Z" fill="currentColor" />
                            <path d="M29.6216 19.6699H24.3516V24.9398H29.6216V19.6699Z" fill="currentColor" />
                            <path d="M24.0889 30.49H12.3789V35.76H24.0889V30.49Z" fill="currentColor" />
                            <path d="M14.8684 0.919983H9.89844V9.53998H14.8684V0.919983Z" fill="currentColor" />
                            <path d="M31.7005 0.919983H26.7305V9.53998H31.7005V0.919983Z" fill="currentColor" />
                        </svg>
                        <?php echo get_phrase('daftar_ppdb_online'); ?>
                    </button></a>
                    <a href="<?php echo base_url().'home/search'; ?>" style="text-decoration:none">
                    <button type="button"
                        class="btn w-100 w-max-95 shadow-none rounded-pill d-flex flex-row justify-content-start align-items-center position-relative btn-logins-2 fw-normal psp-lg-6 fs-xs-3">
                        <svg class="miniButtonIcon" width="9%" width="42" height="48" viewBox="0 0 42 48"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M0.421875 6.42993V47.1799H41.1919V6.42993H0.421875ZM35.6919 41.6799H5.92188V11.9299H35.6919V41.6799Z"
                                fill="currentColor" />
                            <path d="M30.5389 19.6699H12.3789V24.9398H30.5389V19.6699Z" fill="currentColor" />
                            <path d="M29.6216 19.6699H24.3516V24.9398H29.6216V19.6699Z" fill="currentColor" />
                            <path d="M24.0889 30.49H12.3789V35.76H24.0889V30.49Z" fill="currentColor" />
                            <path d="M14.8684 0.919983H9.89844V9.53998H14.8684V0.919983Z" fill="currentColor" />
                            <path d="M31.7005 0.919983H26.7305V9.53998H31.7005V0.919983Z" fill="currentColor" />
                        </svg>
                        <?php echo get_phrase('cek_status_ppdb'); ?>
                    </button></a>
                </div>
            </div>
        </div>
    </div>
    <!-- End:Mobile Version -->
    <!-- End:PPDB Modal -->

    <!-- Kalender Modal-->
    <div class="modal align-items-center fade overflow-auto" id="KalenderModal" tabindex="-1"
        aria-labelledby="PPBDmodals" aria-hidden="true">
        <div class="modal-dialog KalenderBg d-flex flex-column align-items-center justify-content-center modal-dialog-centered">
            <div class="w-100 mx-height-2 bg-transparent ms-5 ps-5 position-relative  align-items-center">
                <button type="button" class="btn-login-close-3 shadow-none" data-bs-dismiss="modal"
                    aria-label="Close"></button>
                    <div class="modal-body p-0 h-100 w-75 bg-4 rounded position-absolute right-1 me-lg-2 overflow-auto">
                    <div style="background-color: white;" id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End:Kalender Modal -->

    <!-- Jumbotron -->
    <div class="container-fluid mb-lg-5 px-0 ">
        <div class="container-fluid JumboImg d-flex flex-column justify-content-center mt-n1">
            <div class="d-flex flex-column">
                <div class="d-flex flex-row justify-content-lg-evenly justify-content-around pt-lg-0 pt-lg-3 pt-2">
                    <div class="img-mid-container align-items-center justify-content-start me-lg-5">
                        <img class="img-mid-places-1" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/logo_NEW_EDNA_WARNA.svg" alt="">
                    </div>

                    <div class="d-flex flex-column justify-content-center">
                        <div class="img-mid-container mx-auto">
                        </div>
                        <h1 class="font-poppins text-white font-size-xl-1 font-size-sm-5 text-center mt-n1">
                        <?= get_frontend_settings('website_title'); ?></h1>
                        <button
                            class="btn d-lg-none mx-auto d-block w-75 bg-3 btn-sm mb-2 text-white shadow-none rounded-pill"
                            type="button"
                            data-bs-toggle="modal" data-bs-target="#loginModal">
                            <svg width="15" class="me-2" height="23" viewBox="0 0 27 35" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.2315 14.4128C20.8167 11.8276 20.8358 7.65492 18.274 5.09308C15.7121 2.53124 11.5395 2.55032 8.95422 5.13559C6.36895 7.72086 6.35022 11.8932 8.91206 14.455C11.4739 17.0168 15.6462 16.9981 18.2315 14.4128Z"
                                    fill="currentColor" />
                                <path
                                    d="M7.93896 20.4101H19.2393C21.2231 20.4101 23.1255 21.1982 24.5283 22.601C25.9311 24.0038 26.7192 25.9063 26.7192 27.8902C26.7192 29.569 26.0523 31.179 24.8652 32.3661C23.6781 33.5532 22.068 34.2201 20.3892 34.2201H6.77881C5.09999 34.2201 3.49033 33.5532 2.30322 32.3661C1.11612 31.179 0.449219 29.569 0.449219 27.8902C0.449219 25.9063 1.23688 24.0038 2.63965 22.601C4.04242 21.1982 5.94538 20.4101 7.9292 20.4101H7.93896Z"
                                    fill="currentColor" />
                            </svg>
                            <?php echo get_phrase('login'); ?>
                        </button>
                    </div>

                    <div class="img-mid-container justify-content-end ms-lg-5">
                        <img class="img-mid-places" src="<?php echo $this->settings_model->get_logo_light(); ?>" alt="">
                    </div>
                </div>
                <!-- Menu -->
                <div class="px-lg-7 mt-lg-3">
                    <nav
                        class="navbar d-lg-block d-none shadow d-flex mb-3 justify-content-center rounded-pill navbar-light bg-2 container-md">
                        <div class="w-100 d-flex flex-row justify-content-center px-1">
                            <li class="d-flex align-items-center flex-row justify-content-center">
                                <a class="d-flex align-items-center flex-row justify-content-center navbar-brand py-2 px-0 ms-2 me-0"
                                    href="#aboutUs">
                                    <svg class="me-2 nav-icon-desktop" width="18%" viewBox="0 0 108 71"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M95.82 0H11.74C8.62635 0 5.64021 1.23689 3.43854 3.43857C1.23686 5.64025 0 8.62636 0 11.74V59.26C0 62.3736 1.23686 65.3598 3.43854 67.5614C5.64021 69.7631 8.62635 71 11.74 71H95.82C98.9336 71 101.92 69.7631 104.121 67.5614C106.323 65.3598 107.56 62.3736 107.56 59.26V11.74C107.56 8.62636 106.323 5.64025 104.121 3.43857C101.92 1.23689 98.9336 0 95.82 0ZM60.5 38.76H86.5C86.9502 38.7908 87.37 38.9984 87.6678 39.3375C87.9657 39.6765 88.1175 40.1195 88.09 40.57C88.1176 41.0215 87.9661 41.4657 87.6685 41.8063C87.3709 42.1469 86.9511 42.3567 86.5 42.39H60.5C60.0489 42.3567 59.6291 42.1469 59.3315 41.8063C59.0339 41.4657 58.8824 41.0215 58.91 40.57C58.8825 40.1195 59.0343 39.6765 59.3322 39.3375C59.63 38.9984 60.0498 38.7908 60.5 38.76V38.76ZM24.79 9.65C28.5606 9.66058 32.1735 11.1652 34.8369 13.8343C37.5004 16.5034 38.9974 20.1193 39 23.89C39 27.6667 37.4997 31.2887 34.8292 33.9592C32.1587 36.6297 28.5367 38.13 24.76 38.13C20.9833 38.13 17.3613 36.6297 14.6908 33.9592C12.0203 31.2887 10.52 27.6667 10.52 23.89C10.5213 22.0178 10.8915 20.1643 11.6095 18.4352C12.3275 16.7062 13.3791 15.1356 14.7043 13.8131C16.0296 12.4907 17.6024 11.4423 19.3329 10.728C21.0635 10.0137 22.9178 9.64737 24.79 9.65V9.65ZM39.89 60.84H10.74V56.55C10.7453 52.6875 12.2841 48.9852 15.0181 46.2568C17.7521 43.5285 21.4575 41.9973 25.32 42C27.2334 42 29.128 42.3769 30.8957 43.1091C32.6634 43.8413 34.2696 44.9145 35.6226 46.2675C36.9755 47.6204 38.0487 49.2266 38.7809 50.9943C39.5132 52.762 39.89 54.6566 39.89 56.57V60.84ZM96 60H60.5C60.0498 59.9692 59.63 59.7616 59.3322 59.4225C59.0343 59.0835 58.8825 58.6405 58.91 58.19C58.8798 57.7379 59.0303 57.2923 59.3284 56.951C59.6266 56.6098 60.0479 56.4008 60.5 56.37H96C96.4503 56.4033 96.8692 56.6134 97.1652 56.9543C97.4612 57.2953 97.6103 57.7395 97.58 58.19C97.6076 58.6388 97.4572 59.0805 97.1614 59.4192C96.8657 59.758 96.4484 59.9667 96 60V60ZM96 51.59H60.5C60.0489 51.5567 59.6291 51.3469 59.3315 51.0063C59.0339 50.6657 58.8824 50.2215 58.91 49.77C58.8933 49.3263 59.0499 48.8935 59.3467 48.5631C59.6434 48.2328 60.057 48.0308 60.5 48H96C96.4484 48.0333 96.8657 48.242 97.1614 48.5808C97.4572 48.9195 97.6076 49.3612 97.58 49.81C97.5969 50.2532 97.442 50.6857 97.1476 51.0174C96.8532 51.3491 96.442 51.5542 96 51.59V51.59Z"
                                            fill="currentColor" />
                                    </svg>
                                    <?php echo get_phrase('about_us'); ?>
                                </a>
                            </li>
                            <li class="d-flex align-items-center flex-row justify-content-center">
                                <a class="d-flex align-items-center flex-row justify-content-center navbar-brand py-2 px-0 mx-0"
                                    href="#newsFlashIds">
                                    <svg class="me-2 nav-icon-desktop" width="25%" viewBox="0 0 128 82"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M127.32 60.8301L106.74 47.5601V53.1801H88.47C86.083 53.1801 83.7938 54.1283 82.106 55.8161C80.4182 57.5039 79.47 59.7931 79.47 62.1801V82.0001H94.76V71.4601C94.76 70.6644 95.0761 69.9014 95.6387 69.3387C96.2013 68.7761 96.9644 68.4601 97.76 68.4601H106.76V74.08L127.32 60.8301Z"
                                            fill="currentColor" />
                                        <path
                                            d="M64.31 56.19C64.31 56.19 64.31 56.12 64.31 56.09H18.85C18.4837 56.0838 18.1283 55.9655 17.8314 55.7509C17.5346 55.5363 17.3107 55.2358 17.19 54.89C17.0458 54.5363 17.0058 54.1486 17.075 53.7729C17.1441 53.3972 17.3193 53.0492 17.58 52.77L32.85 36.31C33.1528 35.9739 33.5764 35.7716 34.0281 35.7472C34.4798 35.7229 34.9228 35.8785 35.26 36.18L42.44 42.5L59.23 23.93C59.3896 23.7468 59.5861 23.5995 59.8068 23.4978C60.0274 23.3961 60.2671 23.3423 60.51 23.34V23.34C60.7555 23.3472 60.9968 23.4051 61.2188 23.51C61.4408 23.615 61.6387 23.7648 61.8 23.95L75.3 39.38C77.6099 38.3766 80.1016 37.8592 82.62 37.86H108.55V18.8C108.547 13.9376 106.614 9.27534 103.175 5.83809C99.7357 2.40083 95.0724 0.46997 90.21 0.469971H18.62C13.7577 0.46997 9.09434 2.40083 5.65521 5.83809C2.21608 9.27534 0.282681 13.9376 0.280029 18.8V53C0.280029 57.864 2.21226 62.5289 5.65167 65.9683C9.09109 69.4077 13.7559 71.34 18.62 71.34H64.28L64.31 56.19ZM31.39 14.65C33.6939 14.6526 35.9027 15.569 37.5319 17.1981C39.161 18.8273 40.0774 21.036 40.08 23.34C40.0774 25.6439 39.161 27.8527 37.5319 29.4818C35.9027 31.1109 33.6939 32.0273 31.39 32.03C29.0861 32.0273 26.8773 31.1109 25.2482 29.4818C23.6191 27.8527 22.7027 25.6439 22.7 23.34C22.7027 21.036 23.6191 18.8273 25.2482 17.1981C26.8773 15.569 29.0861 14.6526 31.39 14.65V14.65Z"
                                            fill="currentColor" />
                                    </svg>
                                    <?php echo get_phrase('news_flash'); ?>
                                </a>
                            </li>
                            <li class="d-flex align-items-center flex-row justify-content-center">
                                <a class="d-flex align-items-center flex-row justify-content-center navbar-brand py-2 px-0 mx-0"
                                    href="#keunggulanIds">
                                    <svg class="me-2 nav-icon-desktop" width="15%" viewBox="0 0 117 155"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M76.4501 37.5899C76.4474 42.5053 75.4767 47.372 73.5932 51.9122C71.7097 56.4524 68.9505 60.5772 65.4729 64.0511C61.9953 67.5249 57.8677 70.2798 53.3254 72.1584C48.7832 74.037 43.9154 75.0025 39.0001 74.9999C34.0838 75.0012 29.2155 74.034 24.6732 72.1536C20.1308 70.2732 16.0034 67.5163 12.5266 64.0405C9.04986 60.5646 6.29188 56.4379 4.41022 51.8961C2.52856 47.3542 1.56006 42.4861 1.56006 37.5699C1.56536 27.6446 5.51256 18.1278 12.5336 11.1123C19.5547 4.09686 29.0747 0.157264 39.0001 0.159917C43.9171 0.15729 48.7865 1.1235 53.33 3.00336C57.8735 4.88322 62.0022 7.63986 65.48 11.1158C68.9578 14.5918 71.7167 18.7189 73.5989 23.2614C75.4812 27.804 76.4501 32.6728 76.4501 37.5899V37.5899Z"
                                            fill="currentColor" />
                                        <path
                                            d="M27.83 111C27.1925 110.541 26.7173 109.891 26.4729 109.144C26.2285 108.398 26.2274 107.593 26.4698 106.845C26.7123 106.098 27.1857 105.447 27.8219 104.986C28.4581 104.525 29.2243 104.278 30.0099 104.28H62.2399C63.0245 104.28 63.7888 104.031 64.423 103.569C65.0573 103.108 65.5289 102.457 65.77 101.71L69.4199 90.48C65.8479 85.8099 61.2466 82.0269 55.9739 79.4253C50.7013 76.8236 44.8995 75.4735 39.02 75.48C28.8595 75.48 19.1152 79.5162 11.9307 86.7007C4.74615 93.8853 0.709961 103.63 0.709961 113.79V125.07H47.1599L27.83 111Z"
                                            fill="currentColor" />
                                        <path
                                            d="M86.1099 93.0501L92.3299 112.19C92.4803 112.658 92.7753 113.066 93.1725 113.355C93.5697 113.645 94.0485 113.8 94.5399 113.8H114.67C115.158 113.806 115.631 113.966 116.023 114.257C116.415 114.548 116.705 114.954 116.853 115.42C117 115.885 116.997 116.384 116.844 116.848C116.691 117.311 116.395 117.714 116 118L99.7099 129.83C99.314 130.12 99.0196 130.527 98.8688 130.994C98.718 131.461 98.7184 131.963 98.8699 132.43L105.09 151.58C105.24 152.046 105.239 152.547 105.087 153.012C104.935 153.477 104.64 153.882 104.244 154.17C103.848 154.457 103.371 154.612 102.882 154.612C102.393 154.612 101.916 154.457 101.52 154.17L85.2299 142.34C84.8327 142.053 84.355 141.898 83.8649 141.898C83.3748 141.898 82.8971 142.053 82.4999 142.34L66.2099 154.17C65.8138 154.457 65.337 154.612 64.8478 154.612C64.3585 154.612 63.8817 154.457 63.4856 154.17C63.0896 153.882 62.7946 153.477 62.6427 153.012C62.4908 152.547 62.4898 152.046 62.6399 151.58L68.8599 132.43C69.012 131.963 69.0116 131.459 68.8589 130.992C68.7061 130.524 68.4088 130.118 68.0099 129.83L51.7699 118C51.3725 117.713 51.0764 117.307 50.924 116.841C50.7717 116.374 50.7711 115.872 50.9222 115.405C51.0732 114.939 51.3683 114.532 51.765 114.244C52.1617 113.955 52.6395 113.8 53.1299 113.8H73.2599C73.7513 113.8 74.2301 113.645 74.6273 113.355C75.0245 113.066 75.3195 112.658 75.4699 112.19L81.6899 93.0501C81.8396 92.5815 82.1343 92.1726 82.5316 91.8825C82.9288 91.5924 83.408 91.436 83.8999 91.436C84.3919 91.436 84.871 91.5924 85.2682 91.8825C85.6655 92.1726 85.9602 92.5815 86.1099 93.0501V93.0501Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span class=" pl-5">
                                    <?php echo get_phrase('superiority'); ?>
                                    </span>
                                </a>
                            </li>
                            <li class="d-flex align-items-center flex-row justify-content-center">
                                <a class="d-flex align-items-center flex-row justify-content-center navbar-brand py-2 px-0 mx-0"
                                    href="#galleryIds">
                                    <svg class="me-2 nav-icon-desktop" width="23%" viewBox="0 0 109 72"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M90.2401 0.860107H18.6501C13.7877 0.860107 9.12437 2.79098 5.68524 6.22823C2.24611 9.66549 0.31271 14.3278 0.310059 19.1901V53.3801C0.310058 55.7881 0.784505 58.1725 1.7063 60.397C2.62809 62.6216 3.97915 64.6427 5.68231 66.3449C7.38547 68.0471 9.40733 69.3971 11.6324 70.3177C13.8574 71.2383 16.2421 71.7114 18.6501 71.7101H90.2401C92.648 71.7114 95.0326 71.2383 97.2577 70.3177C99.4827 69.3971 101.505 68.0471 103.208 66.3449C104.911 64.6427 106.262 62.6216 107.184 60.397C108.106 58.1725 108.58 55.7881 108.58 53.3801V19.1901C108.577 14.3278 106.644 9.66549 103.205 6.22823C99.7658 2.79098 95.1024 0.860107 90.2401 0.860107V0.860107ZM31.3901 15.0001C33.694 15.0028 35.9028 15.9192 37.5319 17.5483C39.161 19.1774 40.0774 21.3862 40.0801 23.6901C40.0774 25.994 39.161 28.2028 37.5319 29.8319C35.9028 31.4611 33.694 32.3775 31.3901 32.3801C29.0862 32.3775 26.8773 31.4611 25.2482 29.8319C23.6191 28.2028 22.7027 25.994 22.7001 23.6901C22.7027 21.3862 23.6191 19.1774 25.2482 17.5483C26.8773 15.9192 29.0862 15.0028 31.3901 15.0001V15.0001ZM87.3901 55.2601C87.2667 55.6006 87.0429 55.8957 86.7484 56.1064C86.4538 56.3171 86.1022 56.4334 85.7401 56.4401H18.8301C18.4642 56.4325 18.1093 56.3136 17.8127 56.0993C17.5162 55.8849 17.292 55.5852 17.17 55.2401C17.0258 54.8864 16.9859 54.4988 17.055 54.1231C17.1241 53.7474 17.2994 53.3993 17.5601 53.1201L32.8301 36.6601C32.9793 36.4926 33.1602 36.3562 33.3624 36.2589C33.5645 36.1616 33.784 36.1053 34.008 36.0932C34.232 36.0811 34.4563 36.1135 34.6677 36.1885C34.8792 36.2635 35.0737 36.3796 35.2401 36.5301L42.42 42.8501L59.2101 24.2701C59.3714 24.0897 59.5685 23.945 59.7889 23.8451C60.0093 23.7453 60.2481 23.6925 60.4901 23.6901V23.6901C60.7363 23.6929 60.9791 23.7488 61.2017 23.8541C61.4244 23.9594 61.6217 24.1115 61.7801 24.3001L87.0201 53.1601C87.281 53.4433 87.4568 53.7942 87.5276 54.1726C87.5983 54.5511 87.5611 54.9418 87.42 55.3001L87.3901 55.2601Z"
                                            fill="currentColor" />
                                    </svg>
                                    <?php echo get_phrase('gallery'); ?>
                                </a>
                            </li>
                            <li class="d-flex align-items-center flex-row justify-content-center">
                                <a data-bs-toggle="modal" data-bs-target="#KalenderModal" href="#"
                                    class="d-flex align-items-center flex-row justify-content-center navbar-brand py-2 px-0 mx-0"
                                    href="#">
                                    <svg class="me-2 nav-icon-desktop" width="16%" viewBox="0 0 41 48"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M4 7C1.79086 7 0 8.79086 0 11V44C0 46.2091 1.79086 48 4 48H37C39.2091 48 41 46.2091 41 44V11C41 8.79086 39.2091 7 37 7H4ZM35.469 38.4663C35.469 40.6754 33.6781 42.4663 31.469 42.4663H9.53103C7.32189 42.4663 5.53102 40.6754 5.53102 38.4663V16.5337C5.53102 14.3246 7.32189 12.5337 9.53102 12.5337H31.469C33.6781 12.5337 35.469 14.3246 35.469 16.5337V38.4663Z"
                                            fill="currentColor" />
                                        <path
                                            d="M27.5 20H26.5C25.1193 20 24 21.1193 24 22.5C24 23.8807 25.1193 25 26.5 25H27.5C28.8807 25 30 23.8807 30 22.5C30 21.1193 28.8807 20 27.5 20Z"
                                            fill="currentColor" />
                                        <path
                                            d="M21.5 31H14.5C13.1193 31 12 32.1193 12 33.5C12 34.8807 13.1193 36 14.5 36H21.5C22.8807 36 24 34.8807 24 33.5C24 32.1193 22.8807 31 21.5 31Z"
                                            fill="currentColor" />
                                        <path
                                            d="M15 6.5V2.5C15 1.11929 13.8807 0 12.5 0C11.1193 0 10 1.11929 10 2.5V6.5C10 7.88071 11.1193 9 12.5 9C13.8807 9 15 7.88071 15 6.5Z"
                                            fill="currentColor" />
                                        <path
                                            d="M31 6.5V2.5C31 1.11929 29.8807 0 28.5 0C27.1193 0 26 1.11929 26 2.5V6.5C26 7.88071 27.1193 9 28.5 9C29.8807 9 31 7.88071 31 6.5Z"
                                            fill="currentColor" />
                                    </svg>
                                    <?php echo get_phrase('event_calender'); ?>
                                </a>
                            </li>
                            <li class="d-flex align-items-center flex-row justify-content-center">
                                <a data-bs-toggle="modal" data-bs-target="#PpdbModal"
                                    class="d-flex align-items-center flex-row justify-content-center navbar-brand py-2 px-0 ms-1 me-0 "
                                    href="#">
                                    <svg class="me-2 nav-icon-desktop" width="26%" viewBox="0 0 156 76"
                                        fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M86 44.12L104 19.53V18.45C104 13.5568 102.056 8.86392 98.5961 5.40387C95.1361 1.94382 90.4432 0 85.55 0H18.45C13.5568 0 8.86392 1.94382 5.40387 5.40387C1.94382 8.86392 0 13.5568 0 18.45V52.55C0 57.4432 1.94382 62.1361 5.40387 65.5961C8.86392 69.0562 13.5568 71 18.45 71H85.55H86V44.12ZM61 61H17V48H61V61ZM83 36H17V16H83V36Z"
                                            fill="currentColor" />
                                        <path
                                            d="M133.21 6.84986L101 50.8499V75.1999L122.21 65.7799L156 23.3499C156 23.3499 149.71 4.48986 133.21 6.84986Z"
                                            fill="currentColor" />
                                    </svg>
                                    <?php echo get_phrase('ppdb_online'); ?>
                                </a>
                            </li>
                        </div>
                    </nav>
                </div>
                <!-- End:Menu -->
            </div>
            <div
                class="container-fluid d-flex justify-content-center flex-column align-items-center mx-auto mt-xl-5 ps-lg-5 position-relative">
                <div class="d-flex flex-column">
                    <div class="position-relative mx-auto pe-lg-5">
                        <div class="d-flex flex-column justify-content-center align-items-center ms-lg-0 ms-3">
                            <img draggable="false" class="mini-icons-3" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/icon-email.png" alt="">
                            <h3 class="text-white font-size-8 font-size-xs-8 fw-light mb-0 mt-1"><?php echo get_phrase('email'); ?></h3>
                            <p class="text-black fw-light font-size-8 font-size-xs-8"><?= get_settings('system_email') ?>
                            </p>
                        </div>
                    </div>
                    <div class="position-absolute Telpons">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img draggable="false" class="mini-icons" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconTelp.svg" alt="">
                            <h3 class="text-white font-size-8 font-size-xs-8 fw-light mb-0 mt-1"><?php echo get_phrase('contact'); ?></h3>
                            <p class="text-black fw-light font-size-8 font-size-xs-8"><?= get_settings('phone') ?>
                            </p>
                        </div>
                    </div>
                    <div class="position-absolute Alamats">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img draggable="false" class="mini-icons-2" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconMaps.svg" alt="">
                            <h3 class="text-white font-size-8 font-size-xs-8 fw-light mb-0 mt-1"><?php echo get_phrase('address'); ?></h3>
                            <!-- <a href="#openLocalMaps"
                                class="text-black fw-light font-size-8 font-size-xs-8 text-decoration-none alamatLink"><?= get_settings('address') ?>
                            </a> -->
                            <p class="text-black fw-light font-size-8 font-size-xs-8 text-decoration-none alamatLink"><?= get_settings('address') ?>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="w-100 mx-auto d-flex justify-content-center">
                    <!-- <img class="w-25 w-sm-70 d-lg-block peopleBrandImg d-none mx-auto" draggable="false" src="" alt=""> -->
                    <div class="peopleBrandImg w-25 w-sm-70 d-lg-block d-none mx-auto"></div>
                </div>
                <img class="ps-2 ms-5 w-40 w-md-25 w-sm-35 mt-2 d-lg-none d-block"
                    src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/peopleBrand-ppl-mobile.svg" alt="">
                <!-- Mobile -->
                <!-- <img class="mb-3 w-40 w-sm-40 d-lg-none d-block" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/peopleBrand-des-mobile.svg" alt="">-->

                <!-- End:mobile -->
            </div>
        </div>
    </div>
    <!-- End:jumbotron -->

    <!-- Tentang Kami -->
    <div id="aboutUs" class="container-fluid py-lg-5 position-relative mt-4 mt-lg-0">
        <div class="d-flex text-center flex-column">
            <h1 class="font-poppins font-size-2 color-1 fw-bolder font-size-sm-3">Tentang Kami</h1>
            <div class="container-lg">
            <p class="fw-lighter font-size-3 font-poppins font-size-sm-2 color-2 pt-3 px-lg-5">
                    <?php
                    $about_us_text  = get_frontend_settings('about_us');
                    echo htmlspecialchars_decode(stripslashes($about_us_text));
                    ?>
                </p>
            </div>
        </div>
    </div>
    <!-- End:Tentang Kami -->


    <!-- Keunggulan -->
    <div id="keunggulanIds" class="container-fluid position-relative my-lg-5 py-lg-5 mt-5 bg-unggul-main">
        <h1 class="font-poppins font-size-2 color-1 fw-bolder font-size-sm-3 text-center">Keunggulan
        </h1>
        <div class="d-flex flex-lg-row flex-column justify-content-center">
            <div class="d-flex justify-content-center mt-5 mt-lg-0 bg-unggul-cards-2">
                <div class="card bg-transparent card-width text-center border-0">
                    <div class="cards-unggul bg-white rounded shadow-sm overflow-hidden">
                        <img class="unggulImages"
                        src="<?php echo $this->frontend_model->get_superiority_image_one(); ?>"
                            alt="images">
                    </div>
                    <div class="card-body fw-lighter">
                        <h5 class="card-title color-3 my-2 my-lg-0"><?php echo get_frontend_settings('superiority_title_one'); ?></h5>
                        <p class="card-text color-2 font-size-sm-4"><?php echo get_frontend_settings('superiority_description_one'); ?></p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4 mt-lg-0 bg-unggul-cards-1">
                <div class="card bg-transparent card-width pt-lg-5 mt-lg-5 text-center border-0">
                    <div class="cards-unggul bg-white rounded shadow-sm">
                        <img class="unggulImages"
                        src="<?php echo $this->frontend_model->get_superiority_image_two(); ?>"
                            alt="images">
                    </div>
                    <div class="card-body fw-lighter">
                        <h5 class="card-title color-3 my-2 my-lg-0"><?php echo get_frontend_settings('superiority_title_two'); ?></h5>
                        <p class="card-text color-2 font-size-sm-4"><?php echo get_frontend_settings('superiority_description_two'); ?></p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4 mt-lg-0 bg-unggul-cards-2">
                <div class="card bg-transparent card-width pt-lg-5 mt-lg-5 text-center border-0">
                    <div class="cards-unggul bg-white rounded shadow-sm">
                        <img class="unggulImages"
                        src="<?php echo $this->frontend_model->get_superiority_image_tree(); ?>"
                            alt="images">
                    </div>
                    <div class="card-body fw-lighter">
                        <h5 class="card-title color-3 my-2 my-lg-0"><?php echo get_frontend_settings('superiority_title_tree'); ?></h5>
                        <p class="card-text color-2 font-size-sm-4"><?php echo get_frontend_settings('superiority_description_tree'); ?></p>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4 mt-lg-0 bg-unggul-cards-1">
                <div class="card bg-transparent card-width text-center border-0">
                    <div class="cards-unggul bg-white rounded shadow-sm">
                        <img class="unggulImages"
                        src="<?php echo $this->frontend_model->get_superiority_image_four(); ?>"
                            alt="images">
                    </div>
                    <div class="card-body fw-lighter">
                        <h5 class="card-title color-3 my-2 my-lg-0"><?php echo get_frontend_settings('superiority_title_four'); ?></h5>
                        <p class="card-text color-2 font-size-sm-4"><?php echo get_frontend_settings('superiority_description_four'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End:Keunggulan -->


    <!-- Gallery -->
    <div id="galleryIds" class="container-fluid py-lg-5 pt-5">
        <h1 class="font-poppins font-size-2 color-1 fw-bolder font-size-sm-3 text-center">Gallery</h1>
        <div class="gallery-wrapper py-lg-5 my-lg-5 flex-column d-flex">
            <div class="container-gallery ">
                <input type="radio" class="" name=" slider-gallery" id="gallerys-1" checked>
                <input type="radio" class="" name=" slider-gallery" id="gallerys-2">
                <input type="radio" class="" name=" slider-gallery" id="gallerys-3">
                <div class="icon-gallerys">
                    <!-- <img class="icon-width-gallery" width="80px" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/gallery_topIcon.svg" alt=""> -->
                    <div class="galleryIcons icon-width-gallery"></div>
                </div>
                <div class="cards-gallery">
                <label class="card-gallery" for="gallerys-1" id="images-1">
                        <img src="<?php echo $this->frontend_model->get_gallery_image_one(); ?>"
                            alt="images">
                    </label>
                    <label class="card-gallery" for="gallerys-2" id="images-2">
                        <img src="<?php echo $this->frontend_model->get_gallery_image_two(); ?>"
                            alt="images">
                    </label>
                    <label class="card-gallery" for="gallerys-3" id="images-3">
                        <img src="<?php echo $this->frontend_model->get_gallery_image_tree(); ?>"
                            alt="images">
                    </label>
                </div>
            </div>
        </div>
    </div>
    <!-- End:Gallery -->

    <!-- News Flash -->
    <div id="newsFlashIds" class="container-fluid position-relative z-10 my-lg-5 py-lg-5 bg-unggul-main">
        <h1 class="font-poppins font-size-2 color-1 fw-bolder font-size-sm-3 text-center">News Flash</h1>
        <div class="d-flex flex-lg-row flex-column justify-content-center mt-4 mt-lg-0">
            <div class="d-flex justify-content-center px-lg-3">
                <a href="<?php echo base_url('home/news_flash1'); ?>" class="text-decoration-none">
                    <div class="card bg-white rounded-3 shadow-lg card-style-1 p-2 text-start border-0">
                        <img src="<?php echo $this->frontend_model->get_new_flash_image_one(); ?>" class="w-100 rounded-3 mx-auto" alt="...">
                        <div class="card-body px-1 fw-lighter position-relative">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="card-title font-size-5 fw-bold color-3"><?php echo get_frontend_settings('new_flash_title_one'); ?></h5>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconKeunggulan.svg" class="" width="30px" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="d-flex justify-content-center px-lg-3 mt-lg-5 mb-lg-0 my-4">
                <a href="<?php echo base_url('home/news_flash2'); ?>" class="text-decoration-none">
                    <div class="card bg-white mt-lg-3 rounded-3 shadow-lg card-style-1 p-2 text-start border-0">
                        <img src="<?php echo $this->frontend_model->get_new_flash_image_two(); ?>" class="w-100 rounded-3 mx-auto" alt="...">
                        <div class="card-body px-1 fw-lighter position-relative">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="card-title font-size-5 fw-bold color-3"><?php echo get_frontend_settings('new_flash_title_two'); ?></h5>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconKeunggulan.svg" class="" width="30px" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="d-flex justify-content-center px-lg-3">
                <a href="<?php echo base_url('home/news_flash3'); ?>" class="text-decoration-none">
                    <div class="card bg-white rounded-3 shadow-lg card-style-1 p-2 text-start border-0">
                        <img src="<?php echo $this->frontend_model->get_new_flash_image_tree(); ?>" class="w-100 rounded-3 mx-auto" alt="...">
                        <div class="card-body px-1 fw-lighter position-relative">
                            <div class="row">
                                <div class="col-10">
                                    <h5 class="card-title font-size-5 fw-bold color-3"><?php echo get_frontend_settings('new_flash_title_tree'); ?></h5>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/IconKeunggulan.svg" class="" width="30px" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- End:News Flash -->

    <!-- Maps -->
    <div class="container-fluid py-lg-5 py-3 mt-lg-0 mt-5 mb-lg-0 mb-3">
        <div class="row flex-column flex-lg-row">
            <div class="col py-4 py-lg-0 d-flex flex-column justify-content-center" id="openLocalMaps">
                <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/allMapHijau.png" class="all-maps-responsive mx-auto" alt="mapps">
                <div class="w-100 bg-white shadow-sm d-flex flex-lg-row flex-column align-items-center p-2">
                    <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/IconMapHijau.png" class="maps-icon-responsive" width="6%" alt="">
                    <h1 class="font-size-8 font-size-sm-7 ms-3 fw-bold"><?= get_settings('complete_address') ?></h1>
                </div>
            </div>
            <div class="col">
                <div class="maps-responsive" id="googleMap" style="border:0;" allowfullscreen="" loading="lazy">
                </div>
            </div>
        </div>
    </div>
    <!-- End:Maps -->

    <!-- Download Section -->
    <?php 
    if (!empty(get_settings('apk'))) { ?>
        <div class="container-fluid my-lg-4 mt-5 mb-3 d-flex justify-content-center">
            <div class="cards-download shadow-sm rounded-3">
                <div class="container px-0">
                    <div class="cards-img-containers">
                        <div class="w-50 position-absolute z-10">
                            <img width="100%" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/EDNA-logo-color.png" alt="">
                        </div>
                        <img width="75%" class="position-relative" src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/image/flowers.png" alt="">
                    </div>
                    <div class="card-body d-flex justify-content-center">
                    <a href="<?php echo base_url('uploads/'.get_settings('apk').''); ?>" style="text-decoration:none" download>
                        <button class="btn bg-gradie text-white rounded-pill w-100 d-flex align-items-center justify-content-center gap-2">
                            <img src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/icon/downloads.png" width="15%" alt="" draggable="false">
                            <?php echo get_phrase('download'); ?>
                        </button>
                    </a>
                    </div>
                </div>
            </div>
        </div>
    <?php }else { ?>
       
    <?php } ?>
    <!-- End:Download Section -->

    <!-- Footer -->
    <footer class="container-fluid mt-lg-3 px-lg-5 py-lg-0 py-2">
        <div class="hr-styled"></div>
        <div class="row flex-column flex-lg-row align-items-center py-lg-3 px-lg-5 pt-0 pb-5 my-lg-0 my-3">
            <div class="col-8">
                <div class="row d-flex flex-lg-row flex-column-reverse gap-4">
                    <div class="col align-items-center d-flex justify-content-center">
                        <h3 class="font-size-6 font-size-sm-5 fw-lighter text-lg-start text-center mb-0">© <?php echo get_settings('footer_text'); ?>
                        </h3>
                    </div>
                    <div
                        class="col mt-2 mt-lg-0 d-flex flex-lg-row flex-column align-items-center justify-content-center">
                        <h1 class="font-size-6 font-size-sm-5 fw-lighter mb-0">Choose Themes :</h1>
                        <div class="d-flex flex-row mt-lg-1">
                            <div data-theme="themes-green" class="choose-color" id="switch-1"></div>
                            <div data-theme="themes-blue" class="choose-color" id="switch-2"></div>
                            <div data-theme="themes-red" class="choose-color" id="switch-3"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col py-lg-0 py-3 d-flex align-items-center justify-content-lg-end justify-content-center">
                <a class="mx-3" href="<?php echo get_frontend_settings('facebook'); ?>">
                    <i class="fab color-4 fa-3x fa-facebook-f"></i>
                </a>
                <a class="mx-3" href="<?php echo get_frontend_settings('instagram'); ?>">
                    <i class="fab color-4 fa-2x fa-instagram"></i>
                </a>
                <a class="mx-3" href="<?php echo get_frontend_settings('twitter'); ?>">
                    <i class="fab color-4 fa-lg fa-twitter"></i>
                </a>
            </div>
        </div>
    </footer>
    <!-- End:Footer -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    </script>
    <script src="<?php echo base_url();?>assets/frontend/<?php echo $theme;?>/calender/js/script.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/app.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/backend/js/vendor/fullcalendar.min.js"></script>
    <?php include 'assets/frontend/edn/script.php'; ?>

<script>
    $(document).ready(function() {
    refreshEventCalendar();
    });

    var showAllEvents = function () {
    var url = '<?php echo site_url('home/event_calendar/list'); ?>';

    $.ajax({
        type : 'GET',
        url: url,
        success : function(response) {
            $('.event_calendar_content').html(response);
            initDataTable("basic-datatable");
            refreshEventCalendar();
        }
    });
    }

    var refreshEventCalendar = function () {
    var url = '<?php echo site_url('home/event_calendar/all_events'); ?>';
    $.ajax({
        type : 'GET',
        url: url,
        dataType: 'json',
        success : function(response) {

            var event_calendar = [];
            for(let i = 0; i < response.length; i++) {

                var obj;
                obj  = {"title" : response[i].title, "start" : response[i].starting_date, "end" : response[i].ending_date};
                event_calendar.push(obj);
            }

            $('#calendar').fullCalendar({
                disableDragging: true,
                events: event_calendar,
                displayEventTime: false
            });
        }
    });
    }
    </script>

</body>

</html>