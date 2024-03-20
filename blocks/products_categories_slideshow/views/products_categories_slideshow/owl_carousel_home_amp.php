<?php if(isset($data) && !empty($data)){?>
	<div class="slide-cat">
		<?php $i = 0; ?>
		<?php foreach($data as $item){?>	
			<?php $image_webp =URL_ROOT.str_replace('/original/','/compress/',$item -> image) ; ?>
			<div class="item <?php echo $i ? 'hide':''; ?>">	
				<a href="<?php echo $item->url; ?>" title="<?php echo htmlspecialchars($item->name); ?>">
					<amp-img alt="<?php echo htmlspecialchars($item->name);?>" src="<?php echo $image_webp;?>"  width="394" height="63"/>
				</a>
				
			</div>
			<?php break; ?>
		<?php }?>
	</div>
<?php }?>
