    <div id="map_canvas" style="width: 840px; height: 320px"></div>
    <script src="//maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyCizc1LCp_DXiRVST2wYUaxaMvQoyfWBAw" type="text/javascript"></script>
    <script src="<?php echo URL_ROOT?>libraries/jquery/jquery-1.5.1.min.js" type="text/javascript"></script>
        <script type="text/javascript">
	    $(document).ready( function(){
	    	initialize();
	    });
    	function initialize() {
        	var map = new GMap2(document.getElementById("map_canvas"));
        	map.addControl(new GSmallMapControl());
        	map.addControl(new GMapTypeControl());
        	map.setCenter(new GLatLng(<?php echo $google_map -> latitude.', '.$google_map -> longitude; ?>), 13);

        	// Our info window content
        	var infoTabs = [
        	  new GInfoWindowTab('sd',"<?php echo $str_des; ?>"),
        	  
        	];

        	// Place a marker in the center of the map and open the info window
        	// automatically
        	var marker = new GMarker(map.getCenter());
        	GEvent.addListener(marker, "click", function() {
        	  marker.openInfoWindowTabsHtml(infoTabs);
        	});
        	map.addOverlay(marker);
        	marker.openInfoWindowTabsHtml(infoTabs);
        }
    </script>

    