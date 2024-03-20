<div class="panel panel-primary">
    <div class="panel-heading">
        <i class="fa fa-cog"></i> <?php echo FSText::_('Parameters'); ?>
    </div>
    <div class="panel-body">
    <?php if(!isset($data)){?>
    <p class="help-block">Bạn chỉ thay đổi tham số khi edit blocks</p>
    <?php } else {?>

    		<?php foreach ($params as $key => $value){?>
    			<div class="form-group">
                    <label class="col-sm-3 col-xs-12 control-label"><?php echo $value['name'];?></label>
    				<div class="col-sm-9 col-xs-12">
    					<?php if(@$value['type'] == 'text' || !@$value['type']){ ?>
    						<?php $v = $current_parameters->getParams($key);?>
    						<?php $v = $v ? $v :(isset($value['default'])?$value['default']:'')  ?>
    						<input class="form-control" type="text" name='<?php echo 'params_'.$key ?>' value="<?php echo $v;?>"  >							
    					<?php }?>
    					
    					<?php if(@$value['type'] == 'select'){ ?>
    						<?php $v = $current_parameters->getParams($key);?>
    						<?php $v = $v ? $v :(isset($value['default'])?$value['default']:'')  ?>
    						<?php if(@$value['attr']['multiple'] == 'multiple' ){?>
    							<?php $arr_value = $v?explode(',',$v):array();?>
    							<select data-placeholder="<?php echo $value['name'];?>" name ="<?php echo 'params_'.$key; ?>[]"  multiple="multiple" class='form-control param_select_multi chosen-select-no-results' >
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
    							<select data-placeholder="<?php echo $value['name'];?>" name ="<?php echo 'params_'.$key; ?>"   class='form-control param_select_multi chosen-select'   >
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
    						
    				</div>				
    			</div>
    		<?php }?>
    	
    <?php }?>
    </div>
</div>