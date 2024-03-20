		<?php if($videos_relate_tags){ ?>
		 	<?php foreach ($videos_relate_tags as $item){?>
			        	<?php $link = FSRoute::_("index.php?module=videos&view=video&id=".$item->id."&code=".$item->alias);?>
			            <?php $image = URL_ROOT.str_replace('/original/', '/resized/',$item -> image);?>
			            
			            	 <div class="videos-item videos-item-first">
			            	 	<a class="item-img" href="<?php echo $link; ?>"  title="<?php echo $item -> title; ?>" >
			            	 		<span class="icon-click"></span>
					                	<img class="" alt="<?php echo $item->title?>" src="<?php echo $image; ?>"  />
				                </a>
						        <div class="item-title">
						            <a href="<?php echo $link; ?>" title="<?php echo $item->title?>"><?php echo $item->title?> </a>
						        </div>
							</div>
							
				        <?php $i++?>
					<?php } ?>
		<?php } ?>
