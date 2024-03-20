<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
	<thead>
		<tr>
			<th align="center" >
				<?php echo FSText::_('Thủ tục thôi việc');?>	
			</th>
			<th align="center"  width="15" >
				<?php echo FSText::_('Chọn');?>	
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if(isset($quits_job) && !empty($quits_job)){
			foreach ($quits_job as $item) { 
		?>	
				<?php if(strpos(@$data->quits_job,','.$item->id.',') !== false ){?>
					<tr>
						<td>
							<?php echo $item -> name;?><br/>
						</td>
						<td>
							<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_quits_job[]" checked />
						</td>
					</tr>

				<?php }else{ ?>
					<tr>
						<td>
							<?php echo $item -> name;?><br/>
						</td>
						
						<td>
							<input type="checkbox"  value="<?php echo $item->id; ?>"  name="other_quits_job[]" />
						</td>
					</tr>
				<?php }?>
				<?php
			}
		}
		?>
	</tbody>		
</table>