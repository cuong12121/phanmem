<div class="tab-title cls">
	<div class="cat-title-main" id="characteristic-label">
		<span><?php echo $title_relate; ?></span>
	</div>
</div>
<div class="default_news_inner news_related_vertical">
	<?php if($list_related){ ?>
		<?php $k = 0; ?>
		<?php foreach ($list_related as $item){?>
			<?php if($k > 4) break; ?>
			<?php $link = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias);?>
			<?php $image = URL_ROOT.str_replace('/original/', '/resized/',$item -> image);?>
			<div class="item-related cls">
				<a class="img_a" <?php echo $blanks = 1?'target="_blank"':''; ?> href="<?php echo $link; ?>" title="<?php echo $item -> title; ?>">
					<amp-img class="" src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item -> image); ?>" alt="<?php echo $item -> title; ?>" width="162" height="108" />
				</a>
				<div class="time"><?php echo date('d/m/Y',strtotime($item -> created_time)); ?></div>
				<div class="title-item-related"><a href="<?php echo $link; ?>" title="<?php echo $item -> title; ?>" <?php echo $blanks = 1?'target="_blank"':''; ?>><?php echo $item -> title; ?></a></div>
			</div>
			<?php $k++?>
		<?php } ?>
	<?php } ?>
	<div class='clear'></div>
</div>