<div class="list-images">
		<?php 
			
			foreach($list as $item){
				
				$class='';	
				$link = FSRoute::_("index.php?module=images&view=images&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);
			?>
		<div class='item  cls'>
			<figure class='frame_img'>
				<a class='item-img' href="<?php echo $link; ?>">
					<img  class="lazy" data-src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars(@$item->title); ?>" />
				</a>
			</figure>
			<div class='frame_right'>
				<h2 class="title"><a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo getWord(10,@$item->name); ?></a></h2>
			
			</div>
		</div><!-- end.item  -->
		<?php 
			}
		?>
</div>