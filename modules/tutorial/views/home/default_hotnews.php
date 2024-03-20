<div class='news_hot_title'><?php echo FSText::_('Highlight news')?></div>
<ul id = 'hot_news'>
	<?php 
	if(count($news_right)){
		foreach($news_right as $item){
			$link_news = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&Itemid=$Itemid");
	?>
		<li>
			<h2 class='title' >
				<a href="<?php echo $link_news; ?>" > <?php echo $item -> title; ?></a>
			</h2>
			<div class="hot_new_detail" style="display: none" >
				<?php if($item->image){?>
					<a href="<?php echo $link_news; ?>" >
						<img src="<?php echo URL_IMG_NEWS.'news/resized/'.$item->image?>" alt='<?php echo $item -> title?>' />
					</a>
				<?php }?>
					<h3><a href="<?php echo $link_news; ?>" ><?php echo $item -> title; ?></a></h3>
				<div class='clear'></div>
				
				<p><?php echo getWord(30,$item -> summary);?></p>
			</div>
		</li>
	
	<?php 		
		}
	}
	?>
	
</ul>