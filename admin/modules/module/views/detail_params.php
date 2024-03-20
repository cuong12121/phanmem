<div class='params'>
<?php if(!isset($data)){?>
	<span class='red'>Bạn chỉ thay đổi tham số khi edit blocks</span>
<?php } else {?>
	<table width="100%" cellpadding="5" >
		<?php foreach ($params as $key => $value){?>
			<tr>
				<td><?php echo $value['name'];?></td>
				<td>
					<?php if(@$value['type'] == 'text' || !@$value['type']){ ?>
						<?php $v = $current_parameters->getParams($key);?>
						<?php $v = $v ? $v :(isset($value['default'])?$value['default']:'')  ?>
						<input type="text" name='<?php echo 'params_'.$key ?>' value="<?php echo $v;?>"  >							
					<?php }?>
					
					<?php if(@$value['type'] == 'select'){ ?>
						<?php $v = $current_parameters->getParams($key);?>
						<?php $v = $v ? $v :(isset($value['default'])?$value['default']:'')  ?>
						<?php if(@$value['attr']['multiple'] == 'multiple' ){?>
							<?php $arr_value = $v?explode(',',$v):array();?>
							<select name ="<?php echo 'params_'.$key; ?>[]"  multiple="multiple" class='param_select_multi'   >
								<?php 
								foreach(@$value['value'] as $option_key => $option_value) {
									
									$html_check = "";
									if(in_array($option_key,$arr_value)) {
										$html_check = "' selected='selected' ";
									}
								?>
									<option value="<?php echo $option_key;?>" <?php echo $html_check; ?>><?php echo $option_value; ?></option>
								<?php } ?>
							</select>							
						<?php } else {?>
							<select name ="<?php echo 'params_'.$key; ?>"   class='param_select_multi'   >
								<?php 
								foreach($value['value'] as $option_key => $option_value) {
									
									$html_check = "";
									if($option_key == $v) {
										$html_check = "' selected='selected' ";
									}
								?>
									<option value="<?php echo $option_key;?>" <?php echo $html_check; ?>><?php echo $option_value; ?></option>
								<?php } ?>
							</select>	
						<?php }?>
					<?php }?>
					
					<!--	IS_CHECK: true or false				-->
					<?php if(@$value['type'] == 'is_check'){ ?>
						<?php $v = $current_parameters->getParams($key);?>
						<?php $v = isset($v) ? $v :(isset($value['default'])?$value['default']:'')  ?>
						<input type="radio" name="<?php echo 'params_'.$key; ?>" value="1" <?php echo $v? "checked='checked'":""; ?>  />Có &nbsp;
						<input type="radio" name="<?php echo 'params_'.$key; ?>" value="0" <?php echo !$v? "checked='checked'":""; ?>/>Không
					<?php }?>	
						
				</td>				
			</tr>
		<?php }?>
	</table>
<?php }?>
</div>