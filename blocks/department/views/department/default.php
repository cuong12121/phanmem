<?php 
global $tmpl,$config,$is_mobile;
$tmpl -> addStylesheet("default","blocks/department/assets/css");
// $tmpl -> addScript("default","blocks/department/assets/js");
$Itemid=FSInput::get('Itemid');
FSFactory::include_class('fsstring');

$tmpl -> addStylesheet('cat','blocks/department/assets/css');
$tmpl -> addStylesheet('jquery.mCustomScrollbar','blocks/department/assets/css');
$tmpl -> addScript('jquery.mCustomScrollbar.concat.min','blocks/department/assets/js');
$tmpl -> addScript('cat','blocks/department/assets/js','bottom');
$total = count($list);
$i=0;

?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4nafcmVQJr9i_d3UU7sWAlFSxr4mcEDY&libraries=geometry,places&callback=initialize&sensor=false"
type="text/javascript"></script>


<div class="department_wrapper">
	<script>
    function setMapLocation(address,latitude,longitude,info,zoom)
    {
        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap'
        };
        var image = '/images/arrow-up1.png';
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        map.setTilt(45);

        map.setCenter(new google.maps.LatLng(latitude, longitude));
        map.setZoom(14);

        window.setTimeout(function(){
            google.maps.event.trigger(marker[value], 'click');
        },2000);

    }

    function initialize(address,latitude,longitude,info,zoom,k) {

        var map;
        var bounds = new google.maps.LatLngBounds();
        var mapOptions = {
            mapTypeId: 'roadmap'
        };
        var image = '/images/arrow-up1.png';
        // Display a map on the page
        map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
        map.setTilt(45);
        // map.setCenter(new google.maps.LatLng(latitude, longitude));
        // map.setZoom(14);
    // var marker = new google.maps.Marker({
    //   position: myLatLng,
    //   map: map,
    //   icon: image
    // });
    // Multiple Markers

    var markers2 = {

        <?php
        foreach($list as $value){
             $image = URL_ROOT . str_replace('/original/','/original/', $value->image);
            ?>
            <?php echo $value->id; ?>:'<div class="info_content cls">' +'<a href="<?php echo URL_ROOT.$value->link ?>"><div class="map-top"><h4><?php echo $value->name ?></h4><p><?php echo "Địa chỉ: ".$value->address ?></p><p><?php echo "Điện thoại: ".$value->phone ?></p></div>' +'<div class="map-bottom"><img src="<?php echo $image ?>" alt="<?php echo $value->name ?>"></div></a></div>',
            <?php
        }
        ?>

    };
    
    if(address != '' && latitude != '' && longitude != ''){
        // var markers = [
        //     [address, latitude,longitude]
           
        // ];
        var markers = [
        <?php
        foreach($list as $value){
            ?>
            ["<?php echo $value->name; ?>", <?php echo $value->latitude; ?>,<?php echo $value->longitude; ?>],
            <?php
        }
        ?>
        ];
    }else{
        var markers = [
        <?php
        foreach($list as $value){
            ?>
            ["<?php echo $value->name; ?>", <?php echo $value->latitude; ?>,<?php echo $value->longitude; ?>],
            <?php
        }
        ?>
        ];
    }                           
    // Info Window Content
     
        var infoWindowContent = [
        <?php
        foreach($list as $value){
                $image = URL_ROOT . str_replace('/original/','/original/', $value->image);
            ?>
            ['<div class="info_content cls">' +'<a target="_blank" href="<?php echo URL_ROOT.$value->link ?>"><div class="map-top"><h4><?php echo $value->name ?></h4><p><?php echo "Địa chỉ: ".$value->address ?></p><p><?php echo "Điện thoại: ".$value->phone ?></p></div>' +'<div class="map-bottom"><img src="<?php echo $image ?>" alt="<?php echo $value->name ?>"></div></a></div>'],
           
        <?php
        }
        ?>
        ];
    
        
    
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;

    // Loop through our array of markers & place each one on the map
    

    if(address != '' && latitude != '' && longitude != ''){
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
                icon: '/images/point.png'
            });
            
            marker.setMap(map);
            google.maps.event.addListener(marker, 'click', (function(marker, i) {  
                return function() { 
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));
            google.maps.event.trigger(marker, 'click');
        }

        var position = new google.maps.LatLng(latitude, longitude);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: address,
            icon: '/images/point.png'
        });

        infoWindow.setContent(infoWindowContent[k][0]);
        infoWindow.open(map, marker);
        
        map.setCenter(new google.maps.LatLng(latitude, longitude));
        map.setZoom(13);
    }else{
        var k = 0;
        for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
                icon: '/images/point.png'
            });
            
            marker.setMap(map);
            google.maps.event.addListener(marker, 'click', (function(marker, i) {  
                return function() { 
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));
            google.maps.event.trigger(marker, 'click');
        }

        // var position = new google.maps.LatLng(latitude, longitude);
        var position = new google.maps.LatLng(markers[0][1], markers[0][2]);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[0][0],
            icon: '/images/point.png'
        });

        infoWindow.setContent(infoWindowContent[k][0]);
        infoWindow.open(map, marker);
        
        map.setCenter(new google.maps.LatLng(markers[0][1], markers[0][2]));
        map.setZoom(12);

    }
    
    // console.log(map);

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
    if(zoom){

        // this.setZoom(zoom);
    }else{
        
        this.setZoom(<?php echo isset($_SESSION["city"])?"13":"6"; ?>);
    }
    google.maps.event.removeListener(boundsListener);
});

}
// $(document).ready( function(){
    setTimeout(function(){ initialize('','','',0,6,''); }, 3000);
    google.maps.event.addDomListener(window, "load", initialize);
// });

</script>



<div class="wraper-department">

    

    <div class="wrapper-ct-depart cf">
       
        <div class="right-de fl">
            <div class="block_title">
                <span>Hệ thống cửa hàng</span>
            </div>
            <div class="wrapper-select-add">
	            <select name="province" id="province"  onchange="changeCity22(this.value,'district');" >
	                <!-- <option value="">--Chọn tỉnh/thành phố--</option> -->
	                <?php  foreach($regions as $province){ 
	                    ?>
	                    <option <?php if(@$_SESSION["city"]==$province->id) echo 'selected="selected"';?> value="<?php echo $province->id;?>">
	                        <?php  echo $province->name;?>
	                    </option>
	                <?php }?>
	            </select> 
        	</div>
	        <div class="wrapper-list-agency">
	            <ul class="list-item-agency">
	                <?php 
	                $html="";
	                foreach($list as $k => $value){

	                    ?>
	                    <li class="item-agency cf">

	                        <div class="wrapper-info-agency"> 
	                            <div data-id="<?php echo $value->id;?>" class="name-agency" onclick="initialize('<?php echo $value->name;?>',<?php  echo  $value->latitude; ?>,<?php  echo $value->longitude ?>,<?php echo $value->id; ?>,14,<?php echo $k ?>)"> 
	                                <?php echo $config['icon_map'] ?>
	                                <?php echo $value->address; ?>
	                                
	                            </div>

	                            <!-- <p class="add-phone"><?php// echo $value->phone; ?></p>
	                            <p class="add-email"><?php //echo $value->email; ?></p> -->
	                        </div>
	                    </li>
	                    <?php 
	                }
	                ?>
	            </ul>
	        </div>
    	</div>

	    <div class="left-de">
	        <div id="map_canvas" ></div>
	        <div class="content-map-active">
	            <?php foreach ($list as $key => $it) {?>
	                <div class="item item-<?php echo $it->id ?> ">
	                    <?php echo $it->more_info; ?>
	                </div>
	            <?php } ?>
	        </div>
	    </div>
	</div>
</div>

<div class="clearfix"></div>
</div>

