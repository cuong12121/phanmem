	<?php 
	global $tmpl; 
	$tmpl -> addStylesheet('products');
	$tmpl -> addStylesheet('search','modules/'.$this -> module.'/assets/css');
	$tmpl -> addStylesheet('cat','modules/'.$this -> module.'/assets/css');
	// $tmpl -> addScript('cat','modules/'.$this -> module.'/assets/js');
	$keyword  = FSInput::get('keyword');
	$keyword = urldecode($keyword);
	$keyword = str_replace('+', ' ',$keyword);
	$title = '"'.$keyword.'" - tìm kiếm';
	if($cat_act || $manf_act ) {
		$title .= ' trong';
	}
	if ($cat_act) {
		$title .= ' danh mục '.$cat_act-> name;
	}
	if ($manf_act) {
		$title .= ' thương hiệu '.$manf_act-> name;
	}
	if($title)
		$tmpl->addTitle( $title);

	$total_in_page = count($list);

	$str_meta_des = $keyword;

	for($i = 0; $i < $total_in_page ; $i ++ ){
		$item = $list[$i];
		$str_meta_des .= ','.$item -> name;
	}
	$tmpl->addMetakey($str_meta_des);
	$tmpl->addMetades($str_meta_des);
	?>

	<div class='product_search'>
		<?php include_once 'default_products.php';?>
		<?php //include_once 'default_news.php';?>
	</div>
