<?php if(!empty($list_news)){?>
	<h2 class="title_h1">
		<span>Tin tức</span>
	</h2>
	<ul class="newslist clearfix">
		<?php foreach($list_news as $item){
		$link = FSRoute::_('index.php?module=news&view=news&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias);
		$image = str_replace('/original/', '/resized/', $item->image);
        ?>
			<li>
					<a class=" img_news" href='<?php echo  $link;?>' title='<?php echo $item ->title;?>'>
						<?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); ?>
					</a>
					<h3><a href='<?php echo $link ?>' title="<?php $item -> title ?>" ><?php echo $item->title;?></a></h3>
			</li>
		<?php } ?>
	</ul>
<?php } ?>