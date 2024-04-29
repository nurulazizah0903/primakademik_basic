<?php
  $school_title = get_settings('system_title');
  $theme        = get_frontend_settings('theme');
  $active_school_id = $this->frontend_model->get_active_school_id();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title><?php echo get_phrase($page_title); ?> | <?php echo get_frontend_settings('website_title') ?></title>

        <link rel="shortcut icon" href="<?php echo $this->settings_model->get_favicon(); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/alanwar/css/animate.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/alanwar/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/alanwar/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/alanwar/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/frontend/alanwar/css/responsive.css">
        <link href="<?php echo base_url(); ?>assets/backend/css/vendor/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap CSS -->
    <!--CSS LeafletJS-->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
      integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin=""
    />
    <!--JavaScript LeafletJS-->
    <script
      src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
      integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
      crossorigin=""
    ></script>
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

    <body>

    <?php include $page_name . '.php'; ?>

    </body>
</html>
