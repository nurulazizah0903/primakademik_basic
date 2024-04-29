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
<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-6">
        <form method="POST" class="col-12 updateMapsSettings" action="<?php echo route('maps') ;?>">
          <label><?php echo get_phrase('latitude'); ?></label>
          <input type="text" class="form-control" name="latitude" id="latitude" value="<?php echo get_frontend_settings('latitude') ;?>"><br>
          <label><?php echo get_phrase('longitude'); ?></label>
          <input type="text" class="form-control" name="longitude" id="longitude" value="<?php echo get_frontend_settings('longitude') ;?>"><br>
          <button type="submit" class="btn btn-secondary col-xl-6 col-lg-6 col-md-12 col-sm-12" onclick="updateMapsSettings()"><?php echo get_phrase('save_maps') ;?></button>
        </form>
        <div id="googleMap" style="width:700px;height:300px;"></div>
      </div>
    </div>
  </div>
</div>