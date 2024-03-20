$(document).ready( function(){
//	showGoogleMap();
});
function showGoogleMap(){

	var lat = $('#latitude').val();
	var lon = $('#longitude').val();
	initialize(lat,lon);
}
//start
var geocoder = new google.maps.Geocoder();

function geocodePosition(pos) {
  geocoder.geocode({
    latLng: pos
  }, function(responses) {
    if (responses && responses.length > 0) {
//      updateMarkerAddress(responses[0].formatted_address);
    } else {
//      updateMarkerAddress('Cannot determine address at this location.');
    }
  });
}

function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

// send value lat,lon to input tag
function updateMarkerPosition(latLng) {
	$('#latitude').val( latLng.lat());
	$('#longitude').val(latLng.lng());
}

//function updateMarkerAddress(str) {
//  document.getElementById('address').innerHTML = str;
//}

function initialize() {
	var lat = $('#latitude').val();
	var lon = $('#longitude').val();
  var latLng = new google.maps.LatLng(lat, lon);
  var map = new google.maps.Map(document.getElementById('gmap'), {
    zoom: 17,
    center: latLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
    position: latLng,
    title: 'Point A',
    map: map,
    draggable: true
  });
  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
//  google.maps.event.addListener(marker, 'dragstart', function() {
//    updateMarkerAddress('Dragging...');
//  });
//  
  google.maps.event.addListener(marker, 'drag', function() {
//    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
//  
//  google.maps.event.addListener(marker, 'dragend', function() {
//    updateMarkerStatus('Drag ended');
//    geocodePosition(marker.getPosition());
//  });
}

// Onload handler to fire off the app.
google.maps.event.addDomListener(window, 'load', initialize);