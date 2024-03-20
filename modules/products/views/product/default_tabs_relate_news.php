<?php FSFactory::include_class('fsstring');	?>
<div class="new_cat">
				<?php 
				if(count($relate_news)){
					for($i = 0; $i < count($relate_news); $i ++){
						$news = $relate_news[$i];
						$link_news = FSRoute::_("index.php?module=news&view=news&id=".$news->id."&code=".$news->alias."&ccode=".$news-> category_alias."&Itemid=44");
				?>
				<div class='item'>
					<?php if($news->image){?>
					<div class='frame_img_news'>
						<a class='item-img' href="<?php echo $link_news; ?>">
							<img height="105" width="155" onerror="javascript:this.src='<?php echo URL_IMG_CT_NEWS.'news/resized/no-img.gif'; ?>';" src="<?php echo URL_IMG_CT_NEWS.'news/resized/'.$news->image; ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
						</a>
					</div>
					<?php }?>
					<div class="news-intro">
						<h2><a href="<?php echo $link_news; ?>" title="<?php echo htmlspecialchars(@$news->title); ?>"><?php echo htmlspecialchars(@$news->title); ?></a></h2>
<!--						<div class='item-date'><?php echo date('d/m/Y',strtotime($news -> created_time)); ?></div>-->
						<div class='item-sum'>	<?php echo FSString::getWord('25',$news->summary) ; ?>	</div>
						<div class="view-detail"><a href="<?php echo $link_news; ?>" title="Chi tiết">Chi tiết</a></div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<?php 
					}
				} 
				?>
			</div>