<?php if($params): ?>
<fieldset>
	<legend>Cấu hình module</legend>
				<!--	PARAMS			-->
				<table class="table table-hover table-striped table-bordered">
					<?php foreach ($params as $key => $value){?>
						<?php if(@$value['type'] == 'sepa'):?>
							<tr class='tr_has_sepa'>
								<td colspan="3"><hr class='sepa'/></td>
							</tr>
						<?php else:?>
						<tr>
							<td width="20%"><?php echo $value['name'];?></td>
							<td>
								<?php if(@$value['type'] == 'text' || !@$value['type']){ ?>
									<?php $v = $current_parameters->getParams($key);?>
									<?php $v = $v ? $v :(isset($value['default'])?$value['default']:'')  ?>
									<?php $size = isset($value['size'])?$value['size']:20; ?>
									<input type="text" name='<?php echo 'params_'.$key ?>' value="<?php echo $v;?>" size="<?php echo $size; ?>"  >							
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
								
								<!--	IS_CHECK: true or false				-->
								<?php if(@$value['type'] == 'textarea'){ ?>
									<?php $v = $current_parameters->getParams($key);?>
									<?php $v = $v ? $v :(isset($value['default'])?$value['default']:'')  ?>
									<?php 
										$k = 'oFCKeditor_'.$key;
										$oFCKeditor[$k] = new FCKeditor('params_'.$key) ;
										$oFCKeditor[$k]->BasePath	=  '../libraries/wysiwyg_editor/' ;
										$oFCKeditor[$k]->Value		= html_entity_decode(stripslashes(@json_decode($v)),ENT_COMPAT,'UTF-8');
										$oFCKeditor[$k]->Width = 450;
										$oFCKeditor[$k]->Height = 450;
										$oFCKeditor[$k]->Create() ;
									?>
								<?php }?>	
									
							</td>
							<td>
								<?php if(@$value['help']):?>
								<div class='help_area'>	
									<img src="templates/default/images/help.png" atl='Hướng dẫn' />
									<div class='help' style="display: none"><?php echo $value['help']; ?></div>
								</div>
								<?php endif;?>
							</td>				
						</tr>
						<?php endif;?>
					<?php }?>
				</table>	
				
				<!--	end PARAMS			-->
				
</fieldset>
<?php endif;?>
<script type="text/javascript">
$('.help_area').mouseover(function(){
	$(this).children('.help').show();
}).mouseout(function(){
	$(this).children('.help').hide();
});
</script>
