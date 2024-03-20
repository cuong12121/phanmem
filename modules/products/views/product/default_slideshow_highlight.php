<?php if(count($slideshow_highlight)){ ?>
<div class="tab-title cls">
	<div class="cat-title-main" id="characteristic-label">
		<!-- <div class="title_icon"><i class="icon_v1"></i></div> -->
		<span>Hình ảnh nổi bật của</span>
	</div>
</div>

<div id="products_slideshow_hightlight" class="owl-carousel">
	<?php $i = 0; ?>
	<?php foreach($slideshow_highlight as $item){?>	
		<div class="item <?php echo $i ? 'hide1':''; ?>">	
			<?php if(!$i){ ?>
			<img src="<?php echo URL_ROOT.str_replace('/original/', '/original/', $item -> image); ?>" alt="<?php echo htmlspecialchars($item->name); ?>"  />
			<?php }else{ ?>
			<img class="owl-lazy"  data-src="<?php echo URL_ROOT.str_replace('/original/', '/original/', $item -> image); ?>" alt="<?php echo htmlspecialchars($item->name); ?>"  />
			<?php } ?>
		</div>
		<?php $i ++; ?>
	<?php }?>
</div>

<?php } ?>