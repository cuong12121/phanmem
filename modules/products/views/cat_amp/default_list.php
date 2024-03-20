<?php
	global $tmpl;
	$tmpl -> addStylesheet('categories','modules/products/assets/css');
	$page = FSInput::get('page');
	if(!$page)
		$tmpl->addTitle( $cat->name);
	else 
		$tmpl->addTitle( $cat->name.' - Trang '.$page);
		
    $total = count($products_list);
    
    $str_meta_des = $cat->name;
    
    for($i = 0; $i < $total ; $i ++ ){
        $item = $products_list[$i];
        $str_meta_des .= ','.$item -> name;
    }
	$tmpl->addMetakey($str_meta_des);
	$tmpl->addMetades($str_meta_des);
	$Itemid = 6;

?>
<!-- BREADCRUMBS-->
<!--<div class='breadcrumbs'>-->
<!--	<a href="<?php echo URL_ROOT;?>"> <?php echo FSText::_('Home');?></a> -->
<!--	<img src = "<?php echo URL_ROOT.'images/breadcrumb-sepa.gif'?>" alt="breadcrumbs" />-->
<!--</div>-->
<!-- end BREADCRUMBS-->
<?php 
FSFactory::include_class('fsstring');
?>
<?php 
	echo '<div class="products_categories">';
	$html_main = '';
	for($i = 0; $i < $total; $i ++ ){
		$html_main .= '<div class="row-list">';
			$item = $products_list[$i];
			$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
			$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$cat->alias.'&Itemid='.$Itemid);
			$html_main .='<div title="click để chọn sản phẩm so sánh" class="product-name click-product click_on" id="'.$item -> id.'" src="'.URL_ROOT.'images/products/resized/'.$item->image.'" table_name="'.$cat -> tablename.'">'.$item -> name ;
			if(isset($list_id) && !empty($list_id)){
				if(in_array($item->id, $list_id)) { 
		  			$html_main .= 			'<div class="bg-white-list" style="display:block"></div>';
		  		}else{
		  			$html_main .= 			'<div class="bg-white-list"></div>';
		  		}				
			}else{
				$html_main .= 			'<div class="bg-white-list"></div>';
			}
	  		$html_main .='</div>';
			$html_main .='<div class="view-detail-product"><a href="'.$link.'" title="'.$item -> name.'">Xem chi tiết</a></div>';
			$html_main .='<div class="price">'.format_money($item -> price).''.'</div>';
			if($item -> quantity > 0){
				$html_main .='<div class="status_on">Còn hàng</div>';
			}else{
				$html_main .='<div class="status_off">Hết hàng</div>';
			}
		$html_main .= '</div>';
	}
  	echo $html_main;
  	echo '</div>';
	if($pagination) echo $pagination->showPagination();
?>


