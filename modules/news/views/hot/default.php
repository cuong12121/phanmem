<?php
	global $tmpl;
	$tmpl -> addStylesheet('news_cat','modules/news/includes/css');
	$tmpl -> addScript('news_cat','modules/news/includes/js');
	
	$page = FSInput::get('page');
	if(!$page)
		$tmpl->addTitle( 'Tin hot');
	else 
		$tmpl->addTitle('Tin hot - Trang '.$page);

	
	$Itemid = 25;
	// set key, des
	$meta_key = '';
	$meta_des = '';
	$meta_key_full = 0;
	$meta_des_full = 0;
	$meta_des_word_count = 150;
	$meta_key_word_count = 30;
	$total_news_list = count($news_list);
	for($i = 0; $i < $total_news_list; $i ++){
		$news = $news_list[$i];
		if(!$meta_key_full)
			$meta_key .= $news -> title;
		if(!$meta_des_full)
			$meta_des .= $news -> title;
		if(strlen($meta_key) > $meta_key_word_count)
			$meta_key_full = 1; // full
		if(strlen($meta_des) > $meta_des_word_count){
			$meta_des_full = 1; // full
			break;
		}
	}
	$tmpl->setMetakey($meta_key.', tin hot');
	$tmpl->setMetades($meta_des.', tin hot');
?>	
<?php 
echo '<div class="frame new_cat">';
			
			// head			
			echo 	'<div class="frame_head">';
			echo 		'<div class="frame_head_inner" >';
			echo 			'<img src="'. URL_ROOT.'images/address/hot_news.jpg'.'" alt="Tin hot"  />';

			echo 			'<h1>';
			echo 				'Tin hot';								
			echo 			'</h1>';
			echo 		'</div>';
			echo 		'<div class="frame_head_r" >&nbsp;</div>';
			echo 	'</div>';
			
			echo 		'<div class="frame_body" >';
			// body
			
			if($total_news_list){?>	
					<?php for($i = 0; $i < $total_news_list; $i ++){?>
						<?php $news = $news_list[$i]; ?>
						<?php $link_news = FSRoute::_("index.php?module=news&view=news&id=$news->id&Itemid=$Itemid"); ?>
<div class="item">
<a rel="nofollow" href="<?php echo $link_news; ?>" title="">
<img
	src="<?php echo URL_IMG_CT_NEWS.'news/resized/'.$news->image; ?>"
	alt="<?php echo htmlspecialchars(@$news->name); ?>" />
    </a>

<h2><a rel="nofollow" href="<?php echo $link_news; ?>" title="">
									<?php echo $news->title; ?>
								</a></h2>
<div class='item-sum'>
								<?php echo $news->summary; ?>
								</div>
</div>
<?php }?>
					<?php  if($pagination) echo $pagination->showPagination();?>
				<?php } else {?>
					Kh&#244;ng c&#243; b&#224;i vi&#7871;t n&#224;o trong chuy&#234;n m&#7909;c n&#224;y
				<?php }?>
			<?php 	
			// end body
			
			
			echo 		'</div>';
			echo 		'<div class="frame_footer" >';
			echo 			'<div class="frame_footer_left">&nbsp;</div>';	
			echo 			'<div class="frame_footer_right">&nbsp;</div>';	
			echo 		'</div>';
			echo 	'</div>';
?>

