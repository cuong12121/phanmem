<?php 
global $tmpl;
//$tmpl -> addScript('form');
//$tmpl -> addScript('jquery.colorbox-min','libraries/jquery/colorbox');
//$tmpl -> addStylesheet('colorbox','libraries/jquery/colorbox');
$tmpl -> addStylesheet('compare','modules/products/assets/css');
$Itemid = FSInput::get('Itemid');
$str_list_id = 0;
$first = 0;
$total = count($data);
for($i  = 0; $i < $total; $i ++){
	if($first != 0)
			$str_list_id .= ',';
	if($data[$i]->record_id){
		$str_list_id .= $data[$i]->record_id;
		$first=1;
	}
}
$row_table = 960;
$row_label = 170;
$row_width =( $row_table - $row_label ) / $total;
$print = FSInput::get('print');

$col = count($data) < 5 ? count($data): 4;
echo $col;
?>
<div class='compare'>
	<div id="news-title">
		<h1>So sánh sản phẩm</h1>
	</div>
	<div id="news-detail">
		<div id="news-head-t">
			<div class="news-head-t-l">
				<div class="news-head-t-r">
				</div>	
			</div>	
		</div>	
		<div class="news_detail-inner">
			
			<div class="news_detail-inner-wrap compare_<?php echo $col?>_cols">
				
				<!--	COMPARE TABLE			-->
				<table class='compare_table' border="0" bordercolor="#E2E2E2" cellpadding="5px" width="<?php echo $row_table; ?>">
					<!--	IMAGE			-->
					<tr >
						<td class='title' width="<?php echo $row_label; ?>">
							<?php if(!$print){?>
								<a id="print_icon" class="dt-print" href="javascript:;" onclick="return OpenPrint();">
							  		<div></div>
							  	</a>
								<a id="button_back" class="button_back" href="javascript:void(0);" onclick="return history.go(-1);">
							  		<div></div>
							  	</a>
							<?php }?>
						</td>
						<?php 
						for($i  = 0; $i < count($data)&& $i < 5; $i ++ ){
							$item = $data[$i]; 
							$link_detail = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid=31');
						?>
						<td class='content ' width='<?php echo $row_width;?>'>
								<div class="picture_small">
									<?php if($item->image){?>
										<a href="<?php echo $link_detail;?>">
											<img alt="<?php echo $item->name; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item->image); ?>"  width="130" height="130" />
										</a>
									<?php } else {?>
										<a href="<?php echo $link_detail;?>">
											<img alt="<?php echo $item->name; ?>" src="<?php echo URL_ROOT.'images/no-img.gif'; ?>" width="130" height="130" />
										</a>
									<?php }?>
								</div>
						</td>		
						<?php }?>
					</tr>
					<!--	end IMAGE			-->
					
					<!--	NAME			-->
					<tr >
						<td class='title' >
						</td>
						<?php 
						for($i  = 0; $i < count($data)&& $i < 5; $i ++ ){
							$item = $data[$i]; 
							$link_detail = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid=31');
						?>
						<td class='content' >
								<div class="navigate">
									<?php if(($i > 0) && count($data) > 1) { ?>
									<a href="javascript:changePosition(<?php echo $i?>, 'back');" class="back" title="&#272;&#7849;y s&#7843;n ph&#7849;m sang tr&#225;i">&nbsp;</a>
									<?php }?>
									
									<?php if(($i + 1) < count($data)) { ?>
									<a href="javascript:changePosition(<?php echo $i;?>, 'forward');" class="forward" title="&#272;&#7849;y s&#7843;n ph&#7849;m sang ph&#7843;i">&nbsp;</a>
									<?php }?>
									
								</div>
								<div class="name">
									<a href="<?php echo $link_detail;?>">
										<?php echo $item -> name; ?>
									</a>
								</div>
								
						</td>		
						<?php }?>
					</tr>
					<!--	end NAME			-->
				</table>
				<table class='compare_table' border="1" bordercolor="#E2E2E2" cellpadding="5px" width="<?php echo $row_table; ?>">
					<tr class="tr-1">
						<td colspan="<?php echo $total + 1?>">
							<span class='compare_label'>Thông số tổng quan</span>
						</td>
					</tr>
					<!--	PRICE			-->
					<tr class="tr-0">
						<td class='title' width="<?php echo $row_label; ?>">
							Gi&#225;
						</td>
						<?php 
						for($i  = 0; $i < count($data)&& $i < 5; $i ++ ){
							$item = $data[$i]; 
						?>
						<td class='content' width='<?php echo $row_width;?>'>
							<strong class='red'><?php echo $item -> price? format_money($item -> price) : '--'; ?></strong>
						</td>		
						<?php }?>
					</tr>
					<!--	end PRICE			-->
					
					<!--	MANUFACTORY			-->
					<!--<tr>
						<td class='title'>
							H&#227;ng s&#7843;n xu&#7845;t
						</td>
						<?php 
						
						for($i  = 0; $i < count($data)&& $i < 5; $i ++ ){
							$item = $data[$i]; 
						?>
						<td class='content'>
							<?php echo isset($manufactory_list[$item -> record_id])?$manufactory_list[$item -> record_id]:'&#272;ang c&#7853;p nh&#7853;t'; ?>
						</td>		
						<?php }?>
					</tr>
					--><!--	end MANUFACTORY			-->
					
					
					<!--	EXTENSION FIELDS			-->
					<?php 
					for($j = 0; $j < count($ext_fields); $j ++){
						$row = $ext_fields[$j];
						$field_name = $row -> field_name;
						$field_type = $row -> field_type;
						if($field_name !='id'){
					?>
					
					<tr <?php if($j%2==0){?> class="tr-0" <?php }else{?> class="tr-1" <?php }?>>
						<td class='title'>
							<?php echo $row->field_name_display ?$row->field_name_display: $row->field_name; ?>
						</td>
						<?php 
						
						for($i  = 0; $i < count($data)&& $i < 5; $i ++ ){
							$item = $data[$i]; 
						?>
						<td class='content'>
							<?php if($field_type != 'image'){?>
								<?php echo isset($item->$field_name)?$item->$field_name:'-'; ?>
							<?php } else {?>
								<?php if(@$item->$field_name){?>
									<img alt="<?php echo $data -> name?>" src="<?php echo URL_IMG_PRODUCTS.'extension'.'/'.@$item->$field_name; ?>" />
								<?php }?>
							<?php }?>
						</td>		
						<?php }?>
					</tr>
					<?php 
						}
					}?>
					<!--	end EXTENSION FIELDS	 		-->
					
				</table>
				<!--	end COMPARE TABLE			-->
				
				
			</div>
		</div>
	</div>
</div>
