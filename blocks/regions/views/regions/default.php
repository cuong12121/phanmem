<?php 
 global $tmpl; 
 $city_id_cookie = isset($_COOKIE['city_id'])?$_COOKIE['city_id']:null; 
 $url = $_SERVER['REQUEST_URI'];
	$return = base64_encode($url);
 ?>
<div class='block_regions'>
	<div class="pull-right">
					<select onchange="javascript:location.href = this.value;">	
						
						<?php foreach ($regions as $item) {?>
						<option value="<?php echo FSRoute::_('index.php?module=users&task=city_save&city_id='.$item ->id.'&return='.$return);?>" <?php echo $city_id_cookie == $item -> id ? 'selected="selected"':''; ?>><?php echo $item -> name; ?></option>
					<?php }//end: foreach ?>

                    </select>
				</div>	

	
	
</div>