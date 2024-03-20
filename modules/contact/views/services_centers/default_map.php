<?php

?>
<div class="address">
				
    <div id="gmap" class="map-canvas"></div>
	<script>
	var locations  = <?php echo $json?>;
	var map = new google.maps.Map(document.getElementById('gmap'), {
	    zoom: 10,
	    center: new google.maps.LatLng(<?php echo $address[0] -> latitude ?>, <?php echo $address[0] -> longitude ?> ),
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  });
	
	  var infowindow = new google.maps.InfoWindow();
	
	  var marker, i;
	
	  for (i = 0; i < locations.length; i++) {  
	    marker = new google.maps.Marker({
	      position: new google.maps.LatLng(locations[i][1], locations[i][2]),
	      map: map
	    });
	
	    google.maps.event.addListener(marker, 'click', (function(marker, i) {
	      return function() {
	        infowindow.setContent(locations[i][0]);
	        infowindow.open(map, marker);
	      }
	    })(marker, i));
	  }
	//  google.maps.event.addDomListener(window, 'load', initialize());
	    </script>	  
</div>
