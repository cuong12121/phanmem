<div class="news_header cls">
	<?php 
		$i = 0;
		foreach($list as $item){
			$link = FSRoute::_("index.php?module=services&view=services&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);
	?>
		<?php if(!$i){?>
			<div class="header_l item">
				<figure class='frame_img'>
				<?php if($item->image){?>				
					<a class='item-img' href="<?php echo $link; ?>">
						<img  class="lazy" data-src="<?php echo URL_ROOT.str_replace('/original/','/large/', $item->image); ?>" alt="<?php echo htmlspecialchars(@$item->title); ?>" />
					</a>				
				<?php } ?>
				</figure>
	    		<h2  class="title" ><a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo htmlspecialchars(@$item->title); ?></a></h2>
	    		<h3 class="summary"><?php echo getWord(50,$item->summary);?></h3>
			</div>
			<div class="header_r">
				<div class="header_r_inner">
		<?php }else{?>
			<div class='item '>
				<div class='inner-item'>
					<figure class='frame_img'>
					<?php if($item->image){?>				
						<a class='item-img' href="<?php echo $link; ?>">
							<img  class="lazy" data-src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars(@$item->title); ?>" />
						</a>				
					<?php } ?>
					</figure>
			        <div class="frame_title">
			    		<h2  class="item_title" ><a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo htmlspecialchars(@$item->title); ?></a></h2>
			    	</div>
		       	</div>         
			</div>
	<?php }?>
	<?php
		if($i > 3) 
			break;
		$i ++;
	}
	?>
		</div> <!-- .header_r_inner -->
	</div> <!-- .header_r -->
</div>	
