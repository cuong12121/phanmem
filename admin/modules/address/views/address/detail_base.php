<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&libraries=places&language=vi"></script>
<script type="text/javascript">
var oldMarker;
function initialize() {
    <?php 
    $latitude = @$data -> latitude? $data -> latitude:'21.028224';
    $longitude = @$data -> longitude? $data -> longitude:'105.835419';
    ?>
    var latlng = new google.maps.LatLng(<?php echo $latitude ?>, <?php echo $longitude ?>);
    var markers = [];
	var image = '/images/arrow-up1.png';
    var myOptions = {
        zoom: 13,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,  
    };
    var map = new google.maps.Map(document.getElementById("gmap"),myOptions);
    google.maps.event.addListener(map, 'click', function(event) {
        placeMarker(event.latLng);
    });
    // Create the search box and link it to the UI element.
  var input = /** @type {HTMLInputElement} */(
      document.getElementById('pac-input'));
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  var searchBox = new google.maps.places.SearchBox(
    /** @type {HTMLInputElement} */(input));

  // [START region_getplaces]
  // Listen for the event fired when the user selects an item from the
  // pick list. Retrieve the matching places for that item.
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }

    // For each place, get the icon, place name, and location.
    markers = [];
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      var marker = new google.maps.Marker({
        map: map,
        icon: image,
        title: place.name,
        position: place.geometry.location
      });

      markers.push(marker);

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);
  });
  // [END region_getplaces]

  // Bias the SearchBox results towards places that are within the bounds of the
  // current map's viewport.
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
    function placeMarker(location) {
        marker = new google.maps.Marker({
            position: location,
            map: map,
            animation: google.maps.Animation.DROP,
			icon: image,
        });
        if (oldMarker != undefined){
            oldMarker.setMap(null);
        }
        oldMarker = marker;
        map.setCenter(location);
		//var infowindow = new google.maps.InfoWindow({
//			content: $('#title').val(),
//			maxWidth: 3500
//		});
		//infowindow.open(map,marker);
		document.getElementById("latitude").value = location.lat();

		document.getElementById("longitude").value = location.lng();
    }
 	placeMarker(latlng);
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>

<style>
    #gmap {
  height: 400px;
  margin: 20px 0px;
  width: 100% !important; 
}

.controls {
    margin-top: 16px;
    border: 1px solid transparent;
    border-radius: 2px 0 0 2px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    height: 32px;
    outline: none;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
}

#pac-input {
    background-color: #fff;
    font-family: Roboto;
    font-size: 15px;
    font-weight: 300;
    margin-left: 12px;
    padding: 15px;
    text-overflow: ellipsis;
    width: 400px;
}

#pac-input:focus {
    border-color: #4d90fe;
}

.pac-container {
    font-family: Roboto;
}

#type-selector {
    color: #fff;
    background-color: #4d90fe;
    padding: 5px 11px 0px 11px;
}

#type-selector label {
    font-family: Roboto;
    font-size: 13px;
    font-weight: 300;
}
</style>
<!-- <link rel="stylesheet" href="<?php //echo URL_ROOT.'libraries/jquery/google_map/gg_map.css'?>" /> -->
			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Name'); ?>
					</td>
					<td>
						<input type="text" name='name' value="<?php echo @$data->name; ?>"  id="name">
						
					</td>
				</tr>
                <!-- 
				<tr>
					<td valign="top" class="key">
						<?php //echo FSText :: _('Alias'); ?>
					</td>
					<td>
						<input type="text" name='alias' value="<?php //echo @$data->alias; ?>"  id="alias">
					</td>
				</tr> -->
				<tr>
		<td valign="top" class="key">
			<?php echo FSText :: _('Khu v'); ?>
		</td>
		<td>
			<select name="region_id"  id="region_id">
				<?php 
				
				// selected category
				if(isset($data->region_id)){
					$compare = $data->region_id;
				} else {
					$compare = 0;
				}
				
				foreach ($regions as $item) {
					$checked = "";
					if($compare == $item->id)
						$checked = "selected=\"selected\"";
						
				?>
					<option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name;  ?> </option>	
				<?php }?>
			</select>
		</td>
	</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Địa chỉ'); ?>
					</td>
					<td>
						<input type="text" name='address' value="<?php echo @$data->address; ?>"  id="address">
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Điện thoại'); ?>
					</td>
					<td>
						<input type="text" name='phone' value="<?php echo @$data->phone; ?>"  id="phone">
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Fax'); ?>
					</td>
					<td>
						<input type="text" name='fax' value="<?php echo @$data->fax; ?>"  id="fax">
					</td>
				</tr>
                
                <tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Email'); ?>
					</td>
					<td>
						<input type="text" name='email' value="<?php echo @$data->email; ?>"  id="email">
					</td>
				</tr>
                
                <tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Website'); ?>
					</td>
					<td>
						<input type="text" name='website' value="<?php echo @$data->website; ?>"  id="website">
					</td>
				</tr>

				<tr style="display:none;">
					<td valign="top" class="key">
						<?php echo FSText :: _('Image'); ?>
					</td>
					<td>
						<?php if(@$data->image){?>
						<img alt="<?php echo $data->title?>" src="<?php echo URL_IMG_ADDRESS.'resized/'.$data->image; ?>" /><br/>
						<?php }?>
						<input type="file" name="image"  />
					</td>
				</tr>
				<?php TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1); ?>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Ordering'); ?>
					</td>
					<td>
						<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>">
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Thông tin thêm'); ?>
					</td>
					<td>
						<?php
						$oFCKeditor1 = new FCKeditor('more_info') ;
						$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
						$oFCKeditor1->Value		= @$data->more_info;
						$oFCKeditor1->Width = 650;
						$oFCKeditor1->Height = 450;
						$oFCKeditor1->Create() ;
						?>
					</td>
			
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Bản đồ'); ?>
					</td>
					<td>
                            <div id="map">
                                <input id="pac-input" class="controls" type="text" placeholder="search your location..." />
                				<div id="gmap" style="width: 100%; height: 400px;"></div> 
                				<input type="hidden" name="latitude" id="latitude" value="<?php echo $latitude ?>"  />
                				<input type="hidden" name="longitude" id="longitude" value="<?php echo $longitude ?>"  />
                			</div>
                            <!-- 21.028224, 105.835419
							<div id="gmap"></div>
							<input type="hidden" name="latitude" id="latitude" value="<?php //echo @$data -> latitude? $data -> latitude:'21.028224'?>"  />
							<input type="hidden" name="longitude" id="longitude" value="<?php //echo @$data -> longitude? $data -> longitude:'105.835419'?>"  /> -->
					</td>
				</tr>
			</table>
<!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php //echo URL_ROOT.'libraries/jquery/google_map/gg_map.js'?>"></script> -->