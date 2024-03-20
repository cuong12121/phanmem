<!--	FIELD	-->

<?php //printr($arr_filters_value_by_current_field); ?>
		<fieldset>
			<legend>Bộ lọc trong trường</legend>
			<div id="tabs">
		        <table cellpadding="5"  cellspacing="0" class="field_tbl" width="100%" border="1" bordercolor="red">
		        	<thead>
			        	<tr bgcolor="#ECF1F4">
			        		<th > STT</th>
			        		<th> <input type="checkbox" onclick="checkAll(<?php echo count($foreign); ?>);" value="" name="toggle"> 
			        			Chọn trường cần lọc</th>
			        		<th>Thứ tự</th>
			        	</tr>
			        </thead>
		        	<?php $i = 0;?>

		        	<?php if(count($foreign)) { ?>
		        		<?php foreach ($foreign as $item) { ?>
							<tr id="filter_exist_<?php echo $i; ?>">
								<td align="center">
									<?php echo ($i + 1);?>
								</td>
								<td>
									
									<?php if(in_array($item -> id, $arr_filters_value_by_current_field) ){?>
									<input type="checkbox" value="<?php echo $item->id; ?>"  name="foreign_id[]" id="cb<?php echo $i; ?>" checked="checked">
									<?php } else { ?>
									<input type="checkbox" value="<?php echo $item->id; ?>"  name="foreign_id[]" id="cb<?php echo $i; ?>">
									<?php } ?>
									<?php echo $item -> name; ?>
								</td>
								<td>
								
									<input type="text" name="ordering_exist_<?php echo $item->id; ?>" value="<?php echo $item->ordering; ?>" size="4">
								</td>
							</tr>
						<?php $i ++ ;?>
						<?php }?>
					<?php } ?>
					
					<?php for( $i = 0 ; $i< 10; $i ++ ) {?>
					<tr id="tr<?php echo $i; ?>" ></tr>
					<?php }?>
					
				</table>
			</div>
		</fieldset>