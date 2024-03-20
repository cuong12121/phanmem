	<?php 
	global $tmpl, $config; 
	$tmpl -> addStylesheet('videos','modules/'.$this -> module.'/assets/css');
	$tmpl -> addStylesheet('home','modules/'.$this -> module.'/assets/css');
	?>
	<div class='videos-grid page_no_home'>
		<!-- <h1 class="page_title"><?php //echo $cat -> name; ?></h1> -->
		<h1 class="img-title-cat page_title">
			<span><?php echo $cat -> name; ?></span>
		</h1>
		
		<div class="cat_item_store">
			<ul>
				<li class="item_tabsds" id="item_tabds_0">
					<a title="Xem thêm"  href="/video.html">Tất cả</a>
				</li>
				<?php $x = 0; foreach ($list_cats as $cat_l) { ?>
					<?php $link = FSRoute::_('index.php?module=videos&view=cat&cid='.$cat_l -> id.'&ccode='.$cat_l -> alias. '&Itemid=30'); ?>
					<li class="item_tabsds <?php if($cat_l -> id == $cat -> id) echo 'active';  ?>">
						<a href="<?php echo $link; ?>" title = "<?php echo $cat_l -> name; ?>"><?php
						echo $cat_l -> name;?></a> 
					</li>
				<?php } ?>
			</ul> 
		</div>
		<h2><?php 
		$note_video_cat = @$config['note_video_cat'];
		$note_video_cat = str_replace('{name}',$cat -> name,$note_video_cat);
		$note_video_cat = str_replace('{year}',date('Y'),$note_video_cat);
		echo  $note_video_cat;
	?></h2>
	<?php include_once 'default_list.php';?>
</div>

