<div class="row">
	<?php 
	if($total_news_list){
		for($i = 0; $i < 3; $i ++){
			$news = $news_list[$i];
			$link_news = FSRoute::_("index.php?module=services&view=home&id=".$news->id."&code=".$news->alias."&ccode=".$news-> category_alias."&Itemid=$Itemid");
	?>
	<div class='col-lg-4 col-md-4 col-sm-4 col-xs-4 column-item '>
		<div class='inner-item'>
			<div class='frame_img'>
			<?php if($news->image){?>				
				<a class='item-img' href="<?php echo $link_news; ?>">
					<img onerror="javascript:this.src='<?php echo URL_ROOT?>images/Na290x220.png';" class="img-responsive" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $news->image); ?>" alt="<?php echo htmlspecialchars(@$news->title); ?>" />
				</a>				
			<?php } ?>
			</div>
	        <div class="frame_title">
	    		<h2  class="item_title" ><a href="<?php echo $link_news; ?>" title="<?php echo htmlspecialchars(@$news->title); ?>"><?php echo htmlspecialchars(@$news->title); ?></a></h2>
	    	</div>
       	</div>         
	</div>
	<?php 
		}
	}
	?>
</div>	
