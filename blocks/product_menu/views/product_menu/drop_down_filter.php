<!--
ÁP dụng cho vidic.com.vn
Có danh mục con + Filter
-->
<?php global $tmpl;
$tmpl -> addStylesheet('drop_down_filter','blocks/product_menu/assets/css');
	//$tmpl -> addScript('drop_down_filter','blocks/product_menu/assets/js');
?>
<?php
global $tmpl; 
	$Itemid = FSInput::get('Itemid');
	$max_filter_in_column = 7;
	$total =count($level_0);
	?>

<div class="product_menu ">
	<div class='menu_label '>
		<span>			
			<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
			 viewBox="0 0 455 455" style="enable-background:new 0 0 455 455;" xml:space="preserve">
		<g>
			<rect y="312.5" width="455" height="30"/>
			<rect y="212.5" width="455" height="30"/>
			<rect y="112.5" width="455" height="30"/>
		</g>
		</svg>

			Danh mục<font> sản phẩm</font>
		</span>
	</div>
	<div id="product_menu_ul" class="menu">
		<ul id = 'product_menu_ul_innner' class="menu" >
			<?php $t = 0;?>
			<!--	LEVEL 0			-->
			<?php foreach($level_0 as $item){?>			
				<?php $link = FSRoute::_('index.php?module=products&view=cat&cid='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid); ?>
				<?php $class = $item-> level ?'level_0 level_1_same_0' :'level_0';?>
				<li class="<?php echo $class; ?>">
					<a href="<?php echo $link; ?>" id="menu_item_<?php echo $item->id;?>" class="menu_item_a" title="<?php echo htmlspecialchars($item -> name);?>">
						<span class="icon_svg"><?php echo $item-> icon; ?></span>
						<span class="text-menu"><?php echo $item -> name;?></span>
					</a>
					<!--	LEVEL 1			-->
					

					<?php  if(isset($children[$item -> id]) && count($children[$item -> id]) || !empty($arr_filter_by_field[$item -> tablename])){?>

					

						<div class='highlight layer_menu_<?php echo ceil(($t+1)/3); ?>' id='childs_of_<?php echo $item -> id; ?>'>
					<?php // }?>
							<?php if(isset($children[$item -> id]) && count($children[$item -> id])  ){?>
								<ul class='highlight1 cls '>
									<?php $j = 0;?>
			
									<?php foreach($children[$item -> id] as $key=>$child){?>
										<?php $link = FSRoute::_('index.php?module=products&view=cat&cid='.$child->id.'&ccode='.$child->alias.'&Itemid='.$Itemid); ?>

										<li class='sub-menu sub-menu-level1 <?php if($arr_activated[$child->id]) $class .= ' activated ';?> '>
											
												<a href="<?php echo $link; ?>" id="menu_item_<?php echo $child->id;?>" title="<?php echo htmlspecialchars($child -> name);?>">
													<?php echo $child -> name;?>
												</a>									
											
										</li>
										<?php $j++;?>
									<?php }?>
								</ul><!--  end <ul class='highlight1'> -->
								<div class="clear"></div>
								<?php }?>

								<!--	end LEVEL 1			-->
								<!--	FILTER			-->
						<?php 
						$filter_in_table_name = isset($arr_filter_by_field[$item -> tablename])?$arr_filter_by_field[$item -> tablename]:array();

					if(count($filter_in_table_name)){
									$j = 0;
						echo '<div class="box_field cls">';
						foreach($filter_in_table_name as $field_name => $filters_in_field){
							
							$i = 0;
							
							echo '<div class="field_name normal" data-id="id_field_'.$field_name.'">';

							foreach($filters_in_field as $filter){
								if(!$i){
									echo '<div class="field_label" id="mn_id_field_'.$filter -> id.'">'.$filter-> field_show.'</div>';
								}
								$str_filter_id = isset($filter_request)?$filter_request.",".$filter -> alias:$filter -> alias;
								$link = FSRoute::_('index.php?module=products&view=cat&cid='.$item->id.'&ccode='.$item->alias.'&filter='.$str_filter_id.'&Itemid='.$Itemid);
								$link_cat = FSRoute::_('index.php?module=products&view=cat&cid='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid);
								if($i <10 )
									echo '<a href="'.$link.'" title="'.$filter ->filter_show.'" >'.$filter ->filter_show.'</a>';
								else
								{
									echo '<div class="read_more"><a  href="'.$link_cat.'">Xem đầy đủ</a></div>';
									break;
								}
								$i++;
							}
							echo '</div>';
							
						}
						echo '</div>';?>
					<?php } ?>
				
					<!--	FILTER			-->
			</div>
			<?php }?>
			</li>

			<?php $t ++; ?>	
		<?php }//.foreach($level_0 as $item)?>

	
		</ul>
	</div>
</div>
