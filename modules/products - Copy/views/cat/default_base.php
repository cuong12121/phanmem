<?php
global $tmpl;
$tmpl -> addStylesheet('categories','modules/products/assets/css');
$page = FSInput::get('page');
if(!$page)
  $tmpl->addTitle( $cat->name);
else 
  $tmpl->addTitle( $cat->name.' - Trang '.$page);

$total = count($list);

$str_meta_des = $cat->name;

for($i = 0; $i < $total ; $i ++ ){
  $item = $list[$i];
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
//echo 	'<h1>'.$cat -> name.'</h1>';			
  $html_main = '';
  
  
  for($i = 0; $i < $total; $i ++ ){
    if( (!($i%4) && $i) || !$i )
      $html_main .= '<div class="row">';
    $item = $list[$i];
    $link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
    $link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$cat->alias.'&Itemid='.$Itemid);
    $html_main .=  '<div class="col_'.($i%4).' cat_item frame " id="prd-'.$item -> id.'">';
    $html_main .= 	 '<div class="frame_inner">';
    $html_main .= 			'<div id="'.$item->id.'" class="frame_img_cat click-product click_on" table_name="'.$cat -> tablename.'" src="'.URL_ROOT.'images/products/resized/'.$item->image.'">';
    if(isset($list_id) && !empty($list_id)){
     if(in_array($item->id, $list_id)) { 
      $html_main .= 			'<div class="bg-white" style="display:block"></div>';
    }else{
      $html_main .= 			'<div class="bg-white"></div>';
    }	
  }else{
   $html_main .= 			'<div class="bg-white"></div>';
 }  
 if($item->image){  	
  $html_main .= 			'<img onerror="javascript:this.src='.'\''.URL_ROOT.'news/resized/no-img.gif\'" title="click vào ảnh để chọn sản phẩm so sánh" class="avatar-pro" width="130px" height="130px" src="'.URL_ROOT.'images/products/resized/'.$item->image.'" alt="'.htmlspecialchars ($item -> name).'"  />';
} else {
  $html_main .= 			'<img onerror="javascript:this.src='.'\''.URL_ROOT.'news/resized/no-img.gif\'" title="click để chọn sản phẩm so sánh" class="avatar-pro" width="130px" height="130px" src="'.URL_ROOT.'templates/default/images/apple-avatar.jpg'.'" alt="'.htmlspecialchars ($item -> name).'"  />';
}
$html_main .=           '</div>';
if(@$arr_product_new[$item -> id])
 $html_main .=           '<div class="new_icon"></div>';
if(@$arr_product_hot[$item -> id])
 $html_main .=           '<div class="hot_icon"></div>';
if(@$arr_product_sale[$item -> id])
 $html_main .=           '<div class="sale_icon"></div>';

$html_main .=  		'<h2><a href="'.$link.'" title = "'.$item -> name .'" class="name" >';
$html_main .= 			FSString::getWord(5,$item -> name);
$html_main .= 		'</a> </h2>	';
//  	 	if(!@$item -> price_new){
//        	$html_main .= '<p class="price">'.format_money($item -> price).''.'</p>';
//        } else {
//        	$html_main .= '<p class="old_price">'.FSText::_('Old price').' : <span>'.format_money($item -> price).' ' .FSText::_('Currency') .'</span></p>';
//        	$html_main .= '<p class="price">'.FSText::_('New price').' : '.format_money($item -> price_new).' ' .FSText::_('Currency') .'</p>';
//        }
$html_main .='<div class="price_area">';
if($item -> promotion_price){
 $html_main .='<p class="price_old"><span class="value">'.format_money($item -> price) .' ' .' </span></p>';
 $html_main .='<p class="price_promotion"><span class="value">'.format_money($item -> promotion_price).''.'</span></p>';
//													echo '<p class="percent_promotion">(Sản phẩm này được khuyến mại: <strong class="value">'.number_format((($item -> price) - ($item -> promotion_price))/($item -> price)*100, 0).' % '.'</strong> )</p>';
} else {
 $html_main .= '<p class="price"><span class="value">'.format_money($item -> price) .' ' .' </span></p>';
}
$html_main .='</div>';

$html_main .= 	'<a href="'.$link_buy.'"><span class="button-cart"></span></a>';
$html_main .= 	'<a href="'.$link.'"><span class="button-detail"></span></a>';
$html_main .= 	'<div class="clear"></div>'; 
$html_main .= 	'</div> 	';
if($item -> promotion_info ){
 $html_main .='<div id="tool-tip-prd-'.$item -> id.'" class="tooltip-content">';
 $html_main .='<div class="tool-top-title">'.$item -> name.'</div>';
 $html_main .='<div class="tool-top-content">';
 $html_main .= '<div class="promotion_info"><strong class="promotion_label">Khuyến mãi: </strong>'.$item -> promotion_info.'</div>';
 $html_main .= '</div></div> 	';
}
$html_main .= '</div> 	';

if(!(($i+1)%4) || (($i+1) == $total))
 $html_main .= '</div>';
}
$html_main .='<div class="tooltip-content" id="tool-tip">Test tool tip</div>';
echo $html_main;
echo '</div>';
echo "<div class='clear'></div>";
if($pagination) echo $pagination->showPagination();?>

