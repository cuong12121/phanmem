<div class="list-news">
		<?php 
			$i = 0;
			foreach($list as $item){
				$i ++;
				if($i < 6)
					continue;
				$class='';	
				$link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);
			?>
		<div class='item  cls'>
			<figure class='frame_img'>
				<a class='item-img' href="<?php echo $link; ?>">
					
					<amp-img src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars(@$item->title); ?>" width="165" height="110" />
				</a>
			</figure>
			<div class='frame_right'>
				<h2 class="title"><a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars(@$item->title); ?>"><?php echo htmlspecialchars(@$item->title); ?></a></h2>
				<div class="datetime">
					<?php echo date('d/m/Y',strtotime($item -> created_time)); ?>
				</div>
				<div class="sum">

					<?php 
						
							echo getWord(25,$item->summary);
						
						
					?>
				</div>
				<?php if(1==2){ ?>
				<a class='view-more' href="<?php echo $link; ?>">
					<?php echo $config['icon_arow_2'] ?> Xem thêm
				</a>
				<?php } ?>
			</div>
		</div><!-- end.item  -->
		<?php 
			}
		?>
</div>