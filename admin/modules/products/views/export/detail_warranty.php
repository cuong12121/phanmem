	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText::_('Bảo hành');?>	
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
			if(isset($warranty) && !empty($warranty)){
				foreach ($warranty as $item) { 
					@$data_by_warranty = $array_data_by_warranty[$item->id];
		?>
			<?php if(@$data_by_warranty){?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="warranty_price_exit_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="warranty_price_exist_<?php echo $item->id;?>"  value="<?php echo @$data_by_warranty->price;?>">
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_warranty_exit[]" id="other_warranty_exit<?php echo $item->id; ?>" checked/>
						<input type="hidden" value="<?php echo @$data_by_warranty -> id; ?>" name="id_warranty_exist_<?php echo $item->id;?>">
						<input type="hidden" value="<?php echo $item->id; ?>" name="warranty_exist_total[]"  />
					</td>
				</tr>
				
			<?php }else{?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="new_warranty_price_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="new_warranty_price_<?php echo $item->id;?>" value="3000000">
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_warranty[]"  />
					</td>
				</tr>
			<?php }?>
				<?php
				}
			}
			?>
	</tbody>		
	</table>