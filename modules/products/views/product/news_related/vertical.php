<div class="detail-list-related">
	<div class="tab-title cls">
		<div class="cat-title-main" id="characteristic-label">
			<span><?php echo $title_relate; ?></span>
		</div>
	</div>

	<div class="newsr_grid">
		<?php if($list_related){ ?>
			<?php $k = 0; ?>
			<?php foreach ($list_related as $item){?>
				<?php if($k > 4) break; ?>
				<?php $link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);?>
				<?php $image = URL_ROOT.str_replace('/original/', '/small/',$item -> image);?>
				<div class="item cls">
					<figure class="product_image ">
						<a class="" <?php echo $blanks = 1?'target="_blank"':''; ?> href="<?php echo $link; ?>" title="<?php echo $item -> title; ?>">
							<?php echo set_image_webp($item->image,'small',@$item->title,'lazy',1,''); ?>
						</a>
					</figure>
					<div class="box_content">
						<div class="title-item-related">
							<a href="<?php echo $link; ?>" title="<?php echo $item -> title; ?>" <?php echo $blanks = 1?'target="_blank"':''; ?>><?php echo $item -> title; ?></a>
							<div class="datetime">
								<?php echo date('d/m/Y',strtotime($item -> created_time)); ?>
							</div>
						</div>
					</div>
				</div>
				<?php $k++?>
			<?php } ?>
		<?php } ?>	
	</div>
</div>
<div class='clear'></div>