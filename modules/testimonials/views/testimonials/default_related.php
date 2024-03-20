<!--	RELATE CONTENT		-->
<?php
	if($category -> display_related){
		$total_content_relate = count($relate_news_list);
		if($total_content_relate){
		?>
		<div class="related cf">
			<div class="relate_title"><span>Các tin khác</span></div>
			<div class="related_content cls">
				<?php
				for($i = 0; $i < $total_content_relate; $i ++){
					if($i>=4){
						break;
					}
					$item = $relate_news_list[$i];
					$link_news = FSRoute::_("index.php?module=news&view=news&code=".$item->alias."&ccode=".$item->category_alias."&id=".$item->id);
	        	?>                    
                            <div class="item-related">
                                <a class="img_a" href="<?php echo $link_news; ?>" title="<?php echo $item -> title; ?>">
                                	<img class="lazy" data-src="<?php echo URL_ROOT.$item -> image; ?>" alt="<?php echo $item -> title; ?>" />
                                </a>
                                <h2 class="title-item-related"><a href="<?php echo $link_news; ?>" title="<?php echo $item -> title; ?>"><?php echo $item -> title; ?></a></h2>
                            </div>
	          	<?php } ?> 
			</div>
		</div>	
		<?php 			
		}
	}
?>
<!--	end RELATE CONTENT		-->
