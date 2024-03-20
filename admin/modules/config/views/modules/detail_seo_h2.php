<?php if(isset($config['fields_seo_h2']['fields']) && $config['fields_seo_h2']['fields'] && count($config['fields_seo_h2']['fields'])): ?>
	<?php $count_fields = count($config['fields_seo_h2']['fields']);?>	
	<tr>
		<td valign="top" width="109">
			<?php $title = isset($config['fields_seo_title']['title'])?$config['fields_seo_title']['title']:FSText::_('H2'); ?>
			<?php echo $title; ?>
		</td>
		<td   valign="top">
			<?php 
			$data_fields_seo_h2 = $data -> fields_seo_h2;
			$arr_fields_seo_h2 = count($data_fields_seo_h2)? explode('|',$data_fields_seo_h2 ):array();	
			?>
				<select name="fields_seo_h2[]" class='seo_field' multiple="multiple">
					<?php foreach($config['fields_seo_h2']['fields'] as $field_name => $field_title):?>
						<option value="<?php echo $field_name;?>" <?php echo in_array($field_name,$arr_fields_seo_h2)?'selected="selected"':''?> ><?php echo $field_title;?></option>
					<?php endforeach;?>
				</select>
				<?php echo "Giữ phím Ctrl để chọn được nhiều option"?>
		</td>
		<td  width="30">
			<?php if(isset($config['fields_seo_h2']['help']) && $config['fields_seo_h2']['help'] ) {?>
				<div class='help_area'>	
						<img src="templates/default/images/help.png" atl='Hướng dẫn' />
						<div class='help' style="display: none"><?php echo $config['fields_seo_h2']['help'] ;?></div>
					</div>
			<?php }else{?>
				&nbsp;
			<?php }?>
		</td>
	</tr>
<?php endif;?>
	