<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
	<thead>
		<tr>
			<th align="center" >
				<?php echo FSText::_('Thủ tục nhận');?>	
			</th>
			<th align="center"  width="15" >
				<?php echo FSText::_('Chọn');?>	
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(isset($receives) && !empty($receives)){
			foreach ($receives as $item) { 
		?>	
				<?php if(strpos(@$data->receives,','.$item->id.',') !== false ){?>
					<tr>
						<td>
							<?php echo $item -> name;?><br/>
						</td>
						<td>
							<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_receives[]" checked />
						</td>
					</tr>

				<?php }else{ ?>
					<tr>
						<td>
							<?php echo $item -> name;?><br/>
						</td>
						
						<td>
							<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_receives[]" />
						</td>
					</tr>
				<?php }?>
				<?php
			}
		}
		?>
	</tbody>		
</table>