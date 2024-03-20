<!--	FIELD	-->
		<fieldset>
			<legend>Bộ lọc trong bảng</legend>
			<div id="tabs">
<!--		    	<p class="notice">T&#234;n tr&#432;&#7901;ng  ch&#7881; ch&#7913;a c&#225;c : Ch&#7919; c&#225;i, s&#7889; ,g&#7841;ch d&#432;&#7899;i. Kh&#244;ng &#273;&#7863;t t&#234;n tr&#432;&#7901;ng l&#224; ID, id, ho&#7863;c Id.</p>-->
		    	
		        <table cellpadding="5"  cellspacing="0" class="field_tbl" width="100%" border="1" bordercolor="#CCC" >
		        	<thead >
			        	<tr bgcolor="#ECF1F4">
			        		<th> Tên trường</th>
			        		<th> T&#234;n hi&#7875;n th&#7883;</th>
			        		<th> T&#234;n hiệu
			        			<br/><span>(duy nhất)</span></th>
			        		<th> T&#237;nh to&#225;n </th>
			        		<th> Gi&#225; tr&#7883;<br/><span>(Nếu có 2 giá trị thì cách nhau dấu phẩy)</span></th>
			        		<th> Published </th>
			        		<th> Id</th>
			        	</tr>
			        </thead>
		        	<?php $i = 0;?>
		        	<?php if(count($filters_in_table)) { ?>
						<?php $field_current = '';?>
		        		<?php foreach ($filters_in_table as $field) { ?>
								<tr id="filter_exist_<?php echo $i; ?>">
									<?php if($field_current != $field->field_name){?>
									<td rowspan="<?php echo $count_field_by_filter_in_table[$field->field_name]-> count_filter; ?>">
										<?php echo $field->field_show; ?>
									</td>
									<?php $field_current = $field->field_name; ?>
									<?php }?>
									<td>
										<?php echo $field->filter_show; ?>
									</td>
									<td>
										<?php echo $field->alias; ?>
									</td>
									
									<td>
										<?php echo $calculators[$field->calculator][1]?>
									</td>
									
									<td>
										<?php echo $field->filter_value; ?>
									</td>
									
									<td>
										<?php echo $field->published?"Yes":"No"; ?>
									</td>
									
									<td>
										<?php echo $field->id; ?>
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