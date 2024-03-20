<?php /*?><?php 
$tmpl -> addScript('jquery.easing.1.2','libraries/jquery','top');
$tmpl -> addScript('jquery.galleryview-1.1','libraries/jquery/galleryview','top');
$tmpl -> addScript('jquery.timers-1.1.2','libraries/jquery','top');
$tmpl -> addStylesheet('galleryview','libraries/jquery/galleryview');
?><?php */?>
<div class="galleryview" id="ngg-gallery-1-232">
	<?php 
	if(count($host_news)){
		foreach($host_news as $item){
			$link_news = FSRoute::_("index.php?module=news&view=news&id=".$item->id."&Itemid=$Itemid");
	?>
	<div class="panel">
		<img src="<?php echo URL_IMG_NEWS.'news/slideshow/'.$item->image?>" alt='<?php echo $item -> title?>' />
		<div class="panel-overlay">
			<h2><a href="<?php echo $link_news; ?>" > <?php echo $item -> title; ?></a></h2>
			<p><?php echo getWord(30,$item -> summary);?></p>
		</div>
	</div>
	<?php 		
		}
	}
	?>
	<ul class="filmstrip">
		<?php 
		if(count($host_news)){
			foreach($host_news as $item){
		?>
		 <li><img title="<?php echo $item -> title; ?>" alt="<?php echo $item -> title; ?>" src="<?php echo URL_IMG_NEWS.'news/resized/'.$item->image?>"></li>
		<?php 		
			}
		}
		?>
	</ul>
</div> 			