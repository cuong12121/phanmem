<?php $i=1;?>
<div class="address">
	<div class="row">
		<p class="region"><strong>Khu vực Hà nội</strong></p>
		<?php 
			$json1 ='[';
			foreach( $address as $item){
				if($item->region =='kv1'){
			?>
				
				<?php $json_names_1[] = "['".$item -> name."',".$item -> latitude.",".$item -> longitude.",17]";?>
				<?php $i++;?>
			<?php 	}
			}
			$json1 .= implode(',', $json_names_1);
			$json1 .=']';
			?>


		<div class="map-warrap">
			<div id="map-canvas-1" class="map-canvas"></div>
			<script>
			var locations  = <?php echo $json1?>;
			var map = new google.maps.Map(document.getElementById('map-canvas-1'), {
			    zoom: 10,
			    center: new google.maps.LatLng(21.037834051277333,105.8411953210175),
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
			    </script>
		</div>
		<div class="address_list">
			
			<?php 
		
			foreach( $address as $item){
				if($item->region =='kv2'){
			?>
				<h2><?php echo $item -> name; ?></h2>
				<p><b>Địa chỉ <?php echo $i;?>:</b> <?php echo $item->address;?></p>
				<p><b>Điện thoại: </b><?php echo $item->phone;?></p>
				<br />
				
				<?php $i++;?>
			<?php 	}
			}
		
			?>
			<div class="clear"	></div>
		</div>
	</div>	
</div>


<div class="address">
	<div class="row">
		<p  class="region"><strong>TP. Hồ Chí Minh</strong></p>
		
			<?php 
			$json3 ='[';
			foreach( $address as $item){
				if($item->region =='kv2'){
			?>
			
				<?php $json_names_3[] = "['".$item -> name."',".$item -> latitude.",".$item -> longitude.",15]";?>
				<?php $i++;?>
			<?php 	}
			
			}
			$json3 .= implode(',', $json_names_3);
			$json3 .=']';
			?>
		
		<div class="">
		<div id="map-canvas-3" class="map-canvas"></div>
			<script>
			var locations3  = <?php echo $json3?>;
			var map = new google.maps.Map(document.getElementById('map-canvas-3'), {
			    zoom: 10,
			    center: new google.maps.LatLng(10.830408608026115,106.45915482037663),
			    mapTypeId: google.maps.MapTypeId.ROADMAP
			  });
			
			  var infowindow = new google.maps.InfoWindow();
			
			  var marker, i;
			
			  for (i = 0; i < locations3.length; i++) {  
			    marker = new google.maps.Marker({
			      position: new google.maps.LatLng(locations3[i][1], locations3[i][2]),
			      map: map
			    });
			
			    google.maps.event.addListener(marker, 'click', (function(marker, i) {
			      return function() {
			        infowindow.setContent(locations3[i][0]);
			        infowindow.open(map, marker);
			      }
			    })(marker, i));
			  }
			  </script>
		</div>

			<div class="address_list">
			
			<?php 
		
			foreach( $address as $item){
				if($item->region =='kv1'){
			?>
				<h2><?php echo $item -> name; ?></h2>
				<p><b>Địa chỉ <?php echo $i;?>:</b> <?php echo $item->address;?></p>
				<p><b>Điện thoại: </b><?php echo $item->phone;?></p>
				<br />
				
				<?php $i++;?>
			<?php 	}
			}
		
			?>
		</div>

	</div>	
</div>

