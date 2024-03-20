	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText::_('Nguồn gốc');?>	
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
			if(isset($origin) && !empty($origin)){
				foreach ($origin as $item) { 
					@$data_by_origin = $array_data_by_origin[$item->id];
		?>
			<?php if(@$data_by_origin){?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="origin_price_exist_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="origin_price_exist_<?php echo $item->id;?>"  value="<?php echo @$data_by_origin->price;?>">
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_origin_exit[]" id="other_origin_exit<?php echo $item->id; ?>" checked/>
						<input type="hidden" value="<?php echo @$data_by_origin -> id; ?>" name="id_origin_exist_<?php echo $item->id;?>">
						<input type="hidden" value="<?php echo $item->id; ?>" name="origin_exist_total[]"  />
					</td>
				</tr>
				
			<?php }else{?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="new_origin_price_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="new_origin_price_<?php echo $item->id;?>" >
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_origin[]" id="other_origin<?php echo $item->id; ?>" />
					</td>
				</tr>
			<?php }?>
				<?php
				}
			}
			?>
	</tbody>		
	</table>