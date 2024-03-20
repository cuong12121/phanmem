			    
<!--	EXTENDED FIELDS    -->
<?php if(@$extend_fields) { ?>

	<div>
		<?php 
		for($i = 0 ; $i < count($extend_fields); $i ++)
		{
			if($extend_fields[$i] -> is_price != 1 ) {
				continue;
			}
		//	echo "<pre>";
			//print_r($extend_fields[$i]);
		//die();

			$fieldname  = $extend_fields[$i] -> field_name;
			$field_display  = $extend_fields[$i] -> field_name_display;
			$fieldtype  = $extend_fields[$i] -> field_type;
			if($fieldname == 'id' || $fieldname == 'ID' || $fieldname == 'Id')
				continue;
			if($fieldtype == 'foreign_one') { ?>
				<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC" style="margin-bottom: 20px;">
					<thead>
						<tr>
							<th align="center" width="30%" >
								<?php echo $field_display;?>	
							</th>
							<th align="center" width="30%">
								<?php echo FSText::_('Giá');?>	
							</th>
							<th align="center" width="200%">
								<?php echo FSText::_('Là mặc định');?>	
							</th>
							<th align="center"  width="20%" >
								<?php echo FSText::_('Chọn');?>	
							</th>
						</tr>
					</thead>
					<tbody>

						<?php
						if(isset($data_foreign[$fieldname]) && !empty($data_foreign[$fieldname])){
							//print_r($data_foreign[$fieldname]);
							//echo "<br>";
							//print_r($arr_data_by_extend_price);
							//die();
							foreach ($data_foreign[$fieldname] as $item) { 
								@$data_by_extend =$arr_data_by_extend_price[$item -> id];
								?>	
								<?php if(@$data_by_extend){?>
									<tr>
										<td>
											<?php echo $item -> name;?><br/>
										</td>
										<td>
											<input type="text" size="20" id="extend_price_exist_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="extend_price_exist_<?php echo $item->id;?>"  value="<?php echo @$data_by_extend->price;?>">
										</td>
										<td>
											<select class="select_default select_default_<?php echo $extend_fields[$i]-> id; ?>" data_select="<?php echo $extend_fields[$i]-> id; ?>" name="extend_default_exist_<?php echo $item->id;?>" id="extend_default_exist_<?php echo $item->id;?>">
												<option value="0">Không</option>
												<option value="1" <?php if(@$data_by_extend-> is_default == 1) echo 'selected'; ?>>Mặc định</option>
											</select>
										</td>
										<td>
											<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_extend_exit[]" id="other_extend_exit<?php echo $item->id; ?>" checked/>
											<input type="hidden" value="<?php echo @$data_by_extend -> id; ?>" name="id_extend_exist_<?php echo $item->id;?>">
											<input type="hidden" value="<?php echo $item->id; ?>" name="extend_exist_total[]"  />
										</td>
									</tr>

								<?php }else{?>
									<tr>
										<td>

											<?php echo $item -> name;?><br/>
										</td>
										<td>
											<input type="text" size="20" id="new_extend_price_<?php echo $item->id;?>" onkeypress="nurZahlen(this)" name="new_extend_price_<?php echo $item->id;?>" >
										</td>
										<td>
											<select class="select_default select_default_<?php echo $extend_fields[$i]-> id; ?>" data_select="<?php echo $extend_fields[$i]-> id; ?>" name="new_extend_default_<?php echo $item->id;?>" id="new_extend_default_<?php echo $item->id;?>">
												<option value="0">Không</option>
												<option value="1">Mặc định</option>
											</select>
										</td>
										<td>
											<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_extend[]" id="other_extend<?php echo $item->id; ?>" />
										</td>
									</tr>
								<?php } ?>
								<?php
							}
						}
						?>
					</tbody>		
				</table>
				<?php 
			}
		}			
		?>

	</div>
<?php }?>
<!--	end EXTENDED FIELDS    -->

<script>
	$('.select_default').change(function(){
		var value_select = $(this).val();
		if(value_select == 1) {
			var data_select = $(this).attr('data_select');
			$('.select_default_'+data_select).val(0);
			$(this).val(1);
		}
	})
	
</script>

