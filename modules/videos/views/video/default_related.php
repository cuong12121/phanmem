<?php if(count($related)){?>
	<div class="related_title"><span>Video liên quan</span></div>
	<div class="vertical videos-grid">

		<?php foreach($related as $item){?>
			<?php $image_webp = $this -> image_webp(URL_ROOT.str_replace('/original/','/resized/', $item->image)) ;?>
			<?php $link = FSRoute::_("index.php?module=videos&view=video&id=".$item->id."&code=".$item->alias); ?>
			<div  class='item'>
				<div class='item_inner'>
					<div>
						<a href="<?php  echo $link;?>" title="<?php echo $item -> title; ?>"  rel="nofollow" class="item-img">
							<img srcset="<?php echo $image_webp; ?>" src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item->image);?>"  alt="<?php $item->title;?> " />
						</a>
					</div>	
					<a href="<?php  echo $link;?>" title="<?php echo $item -> title; ?>" class='name' ><span><?php echo get_word_by_length( 50,$item -> title,'...');?></span></a>
					<div class='clear'></div>
				</div>
			</div>
		<?php }?>	
	</div>
<?php }?>  