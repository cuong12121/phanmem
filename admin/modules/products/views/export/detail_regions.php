	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText::_('Khu vực');?>	
				</th>
			
				<th align="center" >
					<?php echo FSText::_('Giá');?>	
				</th>
				<th align="center"  width="15" >
					<?php echo FSText::_('Chọn');?>	
				</th>
			</tr>
		</thead>
		<tbody>
		
		<?php
			if(isset($regions) && !empty($regions)){
				foreach ($regions as $item) { 
					@$data_by_regions = $array_data_by_regions[$item->id];
		?>
			<?php if(@$data_by_regions){?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="regions_price_exist_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="regions_price_exist_<?php echo $item->id;?>"  value="<?php echo @$data_by_regions->price;?>">
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_regions_exit[]" id="other_regions_exit<?php echo $item->id; ?>" checked/>
						<input type="hidden" value="<?php echo @$data_by_regions -> id; ?>" name="id_regions_exist_<?php echo $item->id;?>">
						<input type="hidden" value="<?php echo $item->id; ?>" name="regions_exist_total[]"  />
					</td>
				</tr>
				
			<?php }else{?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="new_regions_price_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="new_regions_price_<?php echo $item->id;?>" >
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_regions[]" id="other_regions<?php echo $item->id; ?>" />
					</td>
				</tr>
			<?php }?>
				<?php
				}
			}
			?>
	</tbody>		
	</table>