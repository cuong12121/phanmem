<div class="list-news">
		<?php 
			$i = 0;
			foreach($list as $item){
				$i ++;
				if($i < 5)
					continue;
				$class='';	
				$link = FSRoute::_("index.php?module=services&view=services&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);
			?>
		<div class='item  cls'>
			<figure class='frame_img'>
				<a class='item-img' href="<?php echo $link; ?>">
					<img  class="lazy" data-src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars(@$item->title); ?>" />
				</a>
			</figure>
			<div class='frame_right'>
				<h2 class="title"><a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo htmlspecialchars(@$item->title); ?></a></h2>
				<div class="datetime">
					<?php echo date('d/m/Y',strtotime($item -> created_time)); ?>
				</div>
				<div class="sum">
						<?php echo getWord(50,$item->summary);?>
				</div>
			</div>
		</div><!-- end.item  -->
		<?php 
			}
		?>
</div>