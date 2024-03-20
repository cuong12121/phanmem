
<?php
if($category -> display_related){
	$total_content_relate = count($relate_news_list);
	if($total_content_relate){
		?>

		<div class="block_title"><span>Bài cùng chuyên mục</span></div>
		<div class="related_content cls">
			<?php
			for($i = 0; $i < $total_content_relate; $i ++){
				if($i>=4){
					break;
				}
				$item = $relate_news_list[$i];
				$link_news = FSRoute::_("index.php?module=news&view=news&code=".$item->alias."&ccode=".$item->category_alias."&id=".$item->id);
				?>                    
				<div class='news-item'>
					<div class="img">
						<a href='<?php echo $link_news;?>' title="<?php echo $item->title;?>">
							<img class="lazy" data-src='<?php echo URL_ROOT.str_replace('/original/','/resized2/',$item -> image)?>' alt="<?php echo $item -> title?>"/>
						</a>

					</div>
					<div class="title_related">
						<a href='<?php echo $link_news;?>' title="<?php echo $item->title;?>"><?php echo get_word_by_length(46,$item->title);?>
					</a> 
				</div>
				<div class="date">
					<?php echo $config['icon_callendar'] ?>
					<?php echo date('d/m/Y',strtotime($item -> created_time)); ?>
				</div>
				<div class="summary">
					<?php echo get_word_by_length(100,$item->summary);?>
				</div>
			</div> 
		<?php } ?> 
	</div>

	<?php 			
}
}
?>

