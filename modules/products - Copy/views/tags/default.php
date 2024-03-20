	<?php 
	global $tmpl; 
	$tmpl -> addStylesheet('products');
	$tmpl -> addStylesheet('search','modules/'.$this -> module.'/assets/css');
	$tmpl -> addStylesheet('cat','modules/'.$this -> module.'/assets/css');
	$tmpl -> addScript('cat','modules/'.$this -> module.'/assets/js');
	$code  = FSInput::get('code');

	// if($title){
	// 	$tmpl->addTitle( $title);
	// }
	
	$total_in_page = count($list);

	$str_meta_des = $code;

	for($i = 0; $i < $total_in_page ; $i ++ ){
		$item = $list[$i];
		$str_meta_des .= ','.$item -> name;
	}
	// $tmpl->addMetakey($str_meta_des);
	// $tmpl->addMetades($str_meta_des);
	?>


	<?php 
	if(!empty($data->summary)){
		?>
		<div class="all-summary">
			<div class="summary_content_filter description">
				<?php echo $data->summary ?>
			</div>
			<div class="view-more">Xem thêm</div>
		</div>

	<?php } ?>


	<h1 class="key-tags">Kết quả tìm kiếm: <?php echo $data->name ?></h1>

	<?php if(!empty($list)){?>	
		<div class="box_item_tags">
			<div class='product_search'>
				<?php include_once 'default_products.php';?>
			</div>
		</div>
	<?php } ?>

	<?php if(!empty($list_news)){?>
		<div class="box_item_tags">
			<div class='news_search'>
				<?php include_once 'default_news.php';?>
			</div>
		</div>
	<?php } ?>

	<?php if(empty($list) && empty($list_news)){?>
		<div class="box_item_tags">
		<h3>Xin lỗi không tìm thấy vấn đề mà bạn tìm kiếm </h3>
	</div>
	<?php } ?>



	<?php 
	if(!empty($data->description)){
		?>
		<div class="summary_content_cat description">
			<?php echo $data->description ?>
		</div>
		<?php } ?>