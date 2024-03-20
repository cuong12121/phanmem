<?php
	global $tmpl;
	$tmpl -> addStylesheet('categories','modules/products/assets/css');
	$keyword = FSInput::get('keyword');
	$page = FSInput::get('page');
	$title = 'Tìm kiếm sản phẩm với từ khóa "'.$keyword.'"';
	if(!$page)
		$tmpl->addTitle( $title);
	else 
		$tmpl->addTitle( $title.' - Trang '.$page);
		
    $total = count($products_list);
    
    $str_meta_des = $keyword;
    
    for($i = 0; $i < $total ; $i ++ ){
        $item = $products_list[$i];
        $str_meta_des .= ','.$item -> title;
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
$cols = 3;
$Itemid = 7;
?>
<?php 
echo '<div class="product_categories">';
//echo 	'<h1>'.$cat -> name.'</h1>';			
	$html_main = '';
	$class = '';	
  	for($i = 0; $i < $total; $i ++ ){
  	  		if($i == $total-1){
  			  $class .= ' last-item';
  		}
  		if( (!($i%4) && $i) || !$i )

  		$html_main .= '<div class="vertical">';
  		$item = $products_list[$i];
		//print_r($item);
  		$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
  		//$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
  		$link = FSRoute::_('index.php?module=news&view=news&code='.$item -> alias.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
  		$html_main .=  '<div class="col_'.($i%4).' item '.(($i)% $cols ?"item-l":"item-r").'">';
  		$html_main .= 	 '<div class="frame_inner'.$class.'">';
        $html_main .= 			'<div id="'.$item->id.'" class="frame_img_cat click-product click_on"  src="'.URL_ROOT.'images/products/resized/'.$item->image.'">';
		if(isset($list_id) && !empty($list_id)){
			if(in_array($item->id, $list_id)) { 
	  			$html_main .= 			'<div class="bg-white" style="display:block"></div>';
	  		}else{
	  			$html_main .= 			'<div class="bg-white"></div>';
	  		}	
		}else{
			$html_main .= 			'<div class="bg-white"></div>';
		}  
		$html_main .='<a href="'.$link.'" title="">';
		if($item->image){
//		$html_main .= 			'<img title="click để xem chi tiết" class="avatar-pro" width="130px" height="130px" src="'.URL_ROOT.$item->image.'" alt="'.htmlspecialchars ($item -> name).'"  />';
		$html_main .= 			'<img title="click để xem chi tiết" class="avatar-pro" src="'.URL_ROOT.str_replace('/original/','/small/', $item->image).'" alt="'.htmlspecialchars ($item -> title).'"  />';
		} else {
			$html_main .= 			'<img title="click để xem chi tiết" class="avatar-pro" src="'.URL_ROOT.'templates/default/images/apple-avatar.jpg'.'" alt="'.htmlspecialchars ($item -> name).'"  />';
		}
		$html_main .='</a>';
		
        $html_main .=           '</div>';
        if(@$arr_product_new[$item -> id])
        	$html_main .=           '<div class="new_icon"></div>';
        if(@$arr_product_hot[$item -> id])
        	$html_main .=           '<div class="hot_icon"></div>';
        if(@$arr_product_sale[$item -> id])
        	$html_main .=           '<div class="sale_icon"></div>';
        	
		$html_main .=  		'<h3 class="name"><a href="'.$link.'" title = "'.$item -> title .'" class="name" >';
//  		$html_main .= 			FSString::getWord(5,$item -> name);
        $html_main .= 			$item -> title;
  		$html_main .= 		'</a> </h3>	';
//  		$html_main .= 		'<div class="updated_time">'; 
//		$html_main .= 		'<span class="time">'.date('h:i A',strtotime($data -> updated_time)).'</span>';
//		$html_main .= 		'<span class="date">'.date('| d/m/Y',strtotime($data -> updated_time)).'</span>';
//		$html_main .=		'</div>';
		$html_main .=		'<div class="item-sum">'.$item->summary.'</div>';
		$html_main .=		'<span class="read_more"><a href	="'.$link.'" title="'.htmlspecialchars(@$news->title).'">'.FSText::_('Read more').'	</a></span>';
//  	 	if(!@$item -> price_new){
//        	$html_main .= '<p class="price">'.format_money($item -> price).''.'</p>';
//        } else {
//        	$html_main .= '<p class="old_price">'.FSText::_('Old price').' : <span>'.format_money($item -> price).' ' .FSText::_('Currency') .'</span></p>';
//        	$html_main .= '<p class="price">'.FSText::_('New price').' : '.format_money($item -> price_new).' ' .FSText::_('Currency') .'</p>';
//        }
//		$html_main .= '<div class="price_area">';
//		if(@$item -> discount && @$item -> price_old){
//			$html_main .='<div class="price_old">'.format_money($item -> price_old).''.'</div>';
//			$html_main .= '<p class="price">'.format_money($item -> price).''.'</p>';
//        } else {
//        	$html_main .= '<br />';
//        	$html_main .= '<p class="price">'.format_money($item -> price).''.'</p>';
//        }
//        $html_main .= '</div>';
//        $html_main .= 	' <div class="detail_button"><div class="buy-now"><a href="'.$link_buy.'"><span class="button-cart">Mua sản phẩm</span></a></div></div>';
		$html_main .= 	'<a href="'.$link.'"><span class="button-detail"></span></a>';
		$html_main .= 	'<div class="clear"></div>'; 
        $html_main .= 	'</div> 	';
        $html_main .= '</div> 	';
//        
        if(!(($i+1)%4) || (($i+1) == $total))
        	$html_main .= '</div>';
  	}
  	echo $html_main;
  	echo '</div>';
  	echo "<div class='clear'></div>";
  	if($pagination) echo $pagination->showPagination();?>

