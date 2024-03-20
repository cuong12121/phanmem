<?php if(count($news_list)){?>
	<h2 class="search_title mt20 clearfix">
			<span>Tin bài về <?php echo $keyword; ?></span>
	</h2>
	<ul class="newslist clearfix">
		<?php foreach($news_list as $item){
		$link = FSRoute::_('index.php?module=news&view=news&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias);
		$image = str_replace('/original/', '/resized/', $item->image);
        ?>
			<li>
					<a class=" img_news" href='<?php echo  $link;?>' title='<?php echo $item ->title;?>'>
						<img  class="img-responsive"  alt="" src="<?php echo URL_ROOT.str_replace('/original/', '/large/', $item->image);?>">
					</a>
					<h3><a href='<?php echo $link ?>' title="<?php $item -> title ?>" ><?php echo $item->title;?></a></h3>
				</li>
		<?php } ?>
	</ul>
<?php } ?>