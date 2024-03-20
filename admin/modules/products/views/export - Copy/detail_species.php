	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText::_('RAM');?>	
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
			if(isset($species) && !empty($species)){
				foreach ($species as $item) { 
					@$data_by_species = $array_data_by_species[$item->id];
		?>
			<?php if(@$data_by_species){?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="species_price_exist_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="species_price_exist_<?php echo $item->id;?>"  value="<?php echo @$data_by_species->price;?>">
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_species_exit[]" id="other_species_exit<?php echo $item->id; ?>" checked/>
						<input type="hidden" value="<?php echo @$data_by_species -> id; ?>" name="id_species_exist_<?php echo $item->id;?>">
						<input type="hidden" value="<?php echo $item->id; ?>" name="species_exist_total[]"  />
					</td>
				</tr>
				
			<?php }else{?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="new_species_price_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="new_species_price_<?php echo $item->id;?>" >
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_species[]" id="other_species<?php echo $item->id; ?>" />
					</td>
				</tr>
			<?php }?>
				<?php
				}
			}
			?>
	</tbody>		
	</table>