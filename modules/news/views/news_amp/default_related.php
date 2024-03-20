
<?php
if($category -> display_related){
	$total_content_relate = count($relate_news_list);
	if($total_content_relate){
		?>

		<div class="block_title"><span>Bài cùng chuyên mục</span></div>
		<div class="related_content cls">
			<?php
			for($i = 0; $i < $total_content_relate; $i ++){
				if($i>=3){
					break;
				}
				$item = $relate_news_list[$i];
				$link_news = FSRoute::_("index.php?module=news&view=news&code=".$item->alias."&ccode=".$item->category_alias."&id=".$item->id);
				?>                    
				<div class='news-item cls'>
					<div class="img">
						<a href='<?php echo $link_news;?>' title="<?php echo $item->title;?>">
						

							<amp-img  class="lazy" src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item -> image)?>" alt="<?php echo htmlspecialchars($item -> title); ?>" width="187" height="125"  layout="responsive" />
						</a>

					</div>
					<div class="news-it-l">
						<div class="title_related">
							<a href='<?php echo $link_news;?>' title="<?php echo $item->title;?>">
								<?php echo $item->title;?>
						</a> 
						<div class="date">
							<?php echo date('d/m/Y',strtotime($item -> created_time)); ?>
						</div>
						<div class="summary-r">
							<?php echo $item->summary;?>
						</div>
						</div>
						<a class='view-more' href="<?php echo $link_news; ?>">
							<?php echo $config['icon_arow_2'] ?> Xem thêm
						</a>
					</div>
						
				</div> 
		<?php } ?> 
	</div>

	<?php 			
}
}
?>

