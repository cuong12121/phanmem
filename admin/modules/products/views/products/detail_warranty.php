	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					<?php echo FSText::_('Bảo hành');?>	
				</th>
			
				<th align="center" >
					<?php echo FSText::_('Giá');?>	
				</th>
				<th align="center" width="200px">
					<?php echo FSText::_('Là mặc định');?>	
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
						<select class="select_default_warranty select_default_warranty_<?php echo $extend_fields[$i]-> id; ?>" data_select="<?php echo $extend_fields[$i]-> id; ?>" name="warranty_default_exist_<?php echo $item->id;?>">
							<option value="0">Không</option>
							<option value="1" <?php if(@$data_by_warranty-> is_default == 1) echo 'selected'; ?>>Mặc định</option>
						</select>
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
						 <input type="text" size="20" id="new_warranty_price_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="new_warranty_price_<?php echo $item->id;?>" >
					</td>
					<td>
						<select class="select_default_warranty select_default_warranty_<?php echo $extend_fields[$i]-> id; ?>" data_select="<?php echo $extend_fields[$i]-> id; ?>" name="new_warranty_default_<?php echo $item->id;?>">
							<option value="0">Không</option>
							<option value="1">Mặc định</option>
						</select>
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


<script>
	$('.select_default_warranty').change(function(){
		var value_select = $(this).val();
		if(value_select == 1) {
			var data_select = $(this).attr('data_select');
			$('.select_default_warranty_'+data_select).val(0);
			$(this).val(1);
		}
	})
</script>