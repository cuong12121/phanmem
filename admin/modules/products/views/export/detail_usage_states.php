	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText::_('Trạng thái');?>	
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
			if(isset($usage_states) && !empty($usage_states)){
				foreach ($usage_states as $item) { 
					@$data_by_usage_states = $array_data_by_usage_states[$item->id];
		?>
			<?php if(@$data_by_usage_states){?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="usage_states_price_exist_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="usage_states_price_exist_<?php echo $item->id;?>"  value="<?php echo @$data_by_usage_states->price;?>">
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_usage_states_exit[]" id="other_usage_states_exit<?php echo $item->id; ?>" checked/>
						<input type="hidden" value="<?php echo @$data_by_usage_states -> id; ?>" name="id_usage_states_exist_<?php echo $item->id;?>">
						<input type="hidden" value="<?php echo $item->id; ?>" name="usage_states_exist_total[]"  />
					</td>
				</tr>
				
			<?php }else{?>
				<tr>
					<td>
						
						<?php echo $item -> name;?><br/>
					</td>
					<td>
						 <input type="text" size="20" id="new_usage_states_price_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="new_usage_states_price_<?php echo $item->id;?>" >
					</td>
					<td>
						<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_usage_states[]" id="other_usage_states<?php echo $item->id; ?>" />
					</td>
				</tr>
			<?php }?>
				<?php
				}
			}
			?>
	</tbody>		
	</table>