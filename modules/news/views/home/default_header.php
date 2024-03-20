<div class="news_header cls">
	<?php 
		$i = 0;
		foreach($list as $item){
			$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);
	?>
		<?php if(!$i){?>
			<div class="header_l item">
				<figure class='frame_img'>
				<?php if($item->image){?>				
					<a class='item-img' href="<?php echo $link; ?>">
						<img  class="" src="<?php echo URL_ROOT.str_replace('/original/','/large/', $item->image); ?>" alt="<?php echo htmlspecialchars(@$item->title); ?>" />
					</a>				
				<?php } ?>
				</figure>
	    		<h2  class="title" ><a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo htmlspecialchars(@$item->title); ?></a></h2>
	    		<div class="datetime">
					<?php echo date('d/m/Y',strtotime($item -> created_time)); ?>
				</div>
	    		
	    		<h3 class="summary"><?php echo $item->summary;?></h3>
	    	
					
	    	
			</div>
			<div class="header_r">
				<div class="header_r_inner">
		<?php }else{?>
			<div class='item '>
				<div class='inner-item'>
					<figure class='frame_img'>
					<?php if($item->image){?>				
						<a class='item-img' href="<?php echo $link; ?>">
							<img  class="" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars(@$item->title); ?>" />
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
