<div class="lbl-add"><a lang="1" class="show-hidden-register bottom-expand" href="javascript:void(0);">Các lĩnh vực tôi quan tâm</a> &nbsp;(Chọn 5 thư mục để nhận email khi có thông tin mới liên quan)</div>	
	<div id="hidden-professional1" >
		<div class="bound-fields-email">
			<select id="list_relate" name="list_relate[]" class="form" multiple="multiple" style="height:400px; width:300px;">
				<?php foreach($sitemap as $module => $items_in_module){?>
				<option value="<?php echo $module; ?>" rel="<?php echo $arr_module_name[$module]; ?>"><?php echo $arr_module_name[$module];?></option>
					<!--	CHILDREN				-->
					<?php
						if(count($items_in_module)){
							$arr_str_parent = array();
							$str_parent = $module. ' > ';
							foreach ($items_in_module as $item) {
								if($item -> parent_id) 
									$arr_str_parent[$item->id]  = $arr_str_parent[$item->parent_id].'>'.$item->name;
								else 
									$arr_str_parent[$item->id]  = $arr_module_name[$module].'>'.$item->name;
					?>
								<option value="<?php echo $item->sitemap_id; ?>" rel="<?php echo $arr_str_parent[$item->id]; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $item-> treename;?></option>
							<?php }?>	
						<?php }?>	
					<!--	ENd CHILDREN				-->
				<?php }?>
			</select>
		</div>
		<div class="add-newletter"><a href="javascript:void(0)" id="append_field">Thêm danh mục quan tâm</a></div>
		<div class="bound-fields-email">
			<div id="area_selected"></div>				
		</div>
		<div id="advance-hidden"><input id="sitemap_count" type="hidden" value="0" /></div>
		<div style="clear:both;"></div>
		
	</div>