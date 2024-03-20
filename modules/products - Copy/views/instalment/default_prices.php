<input type="hidden" value="0" id='memory_curent'  />
<input type="hidden" value="0" id='usage_states_curent'  />
<input type="hidden" value="0" id='color_curent'  />
<input type="hidden" value="0" id='warranty_curent'  />
<input type="hidden" value="0" id='origin_curent'  />
<input type="hidden" value="0" id='species_curent'  />
<input type="hidden" value="0" id='region_curent'  />
<input type="hidden" value="0" id='price_extend'  />

<input type="hidden" value="0" id='color'  name='color' />
<input type="hidden" value="<?php echo $price;  ?>" id='basic_price'  />
<input type="hidden" value="<?php echo $data->id; ?>" name='product_id' id='product_id'  />
<input type="hidden" id="product-price" name="product_price" value="<?php echo $price_by_region;?>">
<input type="hidden" id="is_instalment" name="is_instalment" value="1">
<input type="hidden" id="instalment_money_before" name="instalment_money_before" value="">
<input type="hidden" id="instalment_money_per_month" name="instalment_money_per_month" value="">
<input type="hidden" id="instalment_money_total" name="instalment_money_total" value="">




<div class="_color">
					<?php if(count($price_by_color)){?>
			   			<span>Chọn màu: </span>
			   			<?php 	foreach ($price_by_color as $item){

		   				$price_color =0;
						if($item->price > 0){
							$price_color = '+'.format_money($item->price,'₫') ;
						}else if($item->price < 0){
							$price_color = format_money($item->price,'₫') ;
						}else{
							$price_color = '+0₫';
						}
						?>
			   			<a  href="javascript:void(0)" class="Selector"  onclick="load_quick(this);" data-price="<?php echo $item -> price;?>" data-type="color"  data-id="<?php echo $item -> id;?>"   data-color="<?php echo $item -> color_id;?>">
							<span  class="color_item icon_v1" data-toggle="tooltip" data-original-title="<?php echo $price_color ;?>"  style="background-color: <?php  echo '#'.$item->color_code?>;">
								<font><?php echo $price_color ;?></font>
							</span>
						</a>
						<?php 	 }	?>
					<?php }?>
				</div>
	<div class="region_wp">		
		<?php $city_id_cookie = isset($_COOKIE['city_id'])?$_COOKIE['city_id']:0; ?>
		
		 <?php if(count($prices_by_regions)){?>
		 
	   			<select  class="box_region" onchange="load_quick(this)" name="region">
	   				<option value="0" data-price="0" data-type="region">-- Chọn khu vực --</option>
					<?php 	foreach ($prices_by_regions as $item){?>
						<option value="<?php echo $item->region_id ?>" <?php echo $city_id_cookie == $item -> region_id ? 'selected="selected"':''; ?> data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="region"><?php echo $item -> region_name;?></option>
					<?php }	?>
				</select>
		<?php }?>
	</div>	


				<?php if(count($price_by_extend_group)){
					foreach ($price_by_extend_group as $price_extend_group) { ?>
						<select  class="box_extend box_extend_<?php echo $price_extend_group-> group_extend_id ?>" name = "extend_price_n[<?php echo $price_extend_group-> group_extend_id; ?>]" id = "box_extend_<?php echo $price_extend_group-> group_extend_id ?>">
							<option value="0" data-price="0" data-type="extend_<?php echo $price_extend_group-> group_extend_id ?>"><?php echo $price_extend_group-> ground_extend_name?></option>
							<?php foreach ($price_by_extend[$price_extend_group -> group_extend_id]   as $item){?>
								<option <?php if($item-> is_default == 1) echo 'selected'; ?> value="<?php echo $item->id ?>" class= "price_extend_id_<?php echo $item->id  ?>" data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="extend_<?php echo $price_extend_group-> group_extend_id ?>"><?php echo $item -> extend_name;?></option>
							<?php }	?>
						</select>
					<?php } }
					?>
					
	 <div class="_attributes clearfix cls">
	    <?php if(count($price_by_memory)){?>
	   			<select  class="boxmemory" name="boxmemory" onchange="load_quick(this)">
	   				<option value="0" data-price="0" data-type="memory">Bộ nhớ sản phẩm</option>
					<?php 	foreach ($price_by_memory as $item){?>
						<option value="<?php echo $item->id ?>" data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="memory"><?php echo $item -> memory_name;?></option>
					<?php }	?>
				</select>
		<?php }?>
			    <?php if(count($price_by_usage_states)){?>
	   			<select  class="boxusage_states"  name="boxusage_states" onchange="load_quick(this)">
	   				<option value="0" data-price="0" data-type="usage_states">Trạng thái</option>
					<?php 	foreach ($price_by_usage_states as $item){?>
						<option value="<?php echo $item->id ?>" data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="usage_states"><?php echo $item -> usage_states_name;?></option>
					<?php }	?>
				</select>
		<?php }?>

		<?php if(count($price_by_warranty)){?>
	   			<select class="boxwarranty" name="boxwarranty" onchange="load_quick(this);">
	   				<option value="0"  data-price="0" data-type="warranty">Chế độ bảo hành</option>
					<?php foreach ($price_by_warranty as $item){?>
						<option value="<?php echo $item->id ?>" data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="warranty"  ><?php echo $item -> warranty_name?></option>
					<?php }	?>
				</select>
				<div class="warranty_aq">
					<?php global $config;?>
					<font><i class="icon_v1 "></i></font>
					<span class="warranty_popup"><?php echo $config['warranty_aq']; ?></span>
				</div>
		<?php }?>
		<?php if(count($price_by_origin)){?>
	   			<select class="boxorigin"  name="boxorigin" onchange="load_quick(this);">
	   				<option value="0"  data-price="0" data-type="origin" >Nguốn gốc</option>
					<?php foreach ($price_by_origin as $item){?>
						<option value="<?php echo $item->id ?>" data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="origin"  ><?php echo $item -> origin_name?></option>
					<?php }	?>
				</select>
		<?php }?>
		<?php if(count($price_by_species)){?>
	   			<select class="boxsspecies"  name="boxsspecies" onchange="load_quick(this);">
	   				<option value="0"  data-price="0" data-type="species" >Ram</option>
					<?php foreach ($price_by_species as $item){?>
						<option value="<?php echo $item->id ?>" data-price="<?php echo ($item -> price)?$item -> price:0;?>" data-type="species"  ><?php echo $item -> species_name?></option>
					<?php }	?>
				</select>
		<?php }?>
	</div>
	
	
	