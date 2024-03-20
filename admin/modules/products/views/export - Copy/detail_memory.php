	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText::_('Bộ nhớ');?>	
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
			if(isset($memory) && !empty($memory)){
				foreach ($memory as $item) { 
					@$data_by_memory = $array_data_by_memory[$item->id];
		?>
			<?php if(@$data_by_memory){?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="memory_price_exist_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="memory_price_exist_<?php echo $item->id;?>"  value="<?php echo @$data_by_memory->price;?>">
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_memory_exit[]" id="other_memory_exit<?php echo $item->id; ?>" checked/>
						<input type="hidden" value="<?php echo @$data_by_memory -> id; ?>" name="id_memory_exist_<?php echo $item->id;?>">
						<input type="hidden" value="<?php echo $item->id; ?>" name="memory_exist_total[]"  />
					</td>
				</tr>
				
			<?php }else{?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="new_memory_price_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="new_memory_price_<?php echo $item->id;?>" >
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_memory[]" id="other_memory<?php echo $item->id; ?>" />
					</td>
				</tr>
			<?php }?>
				<?php
				}
			}
			?>
	</tbody>		
	</table>