	<?php 
	global $tmpl, $config; 
	$tmpl -> addStylesheet('videos','modules/'.$this -> module.'/assets/css');
	$tmpl -> addStylesheet('home','modules/'.$this -> module.'/assets/css');
	$tmpl -> addScript('normal','modules/'.$this -> module.'/assets/js');
	?>
	<div class='videos-grid'>

	    <h1 class="img-title-cat page_title">
	      <span><?php echo FSText::_("Video");?></span>
	    </h1>

		<?php if(1==1) { ?>
			<div class="cat_item_store">
				<ul>
					<li class="item_tabsds active" id="item_tabds_0">
						<a title="Xem thêm"  href="javascript:void(0)">Tất cả</a>
					</li>
					<?php $x = 0; foreach ($list_cats as $cat) { ?>
						<?php $link = FSRoute::_('index.php?module=videos&view=cat&cid='.$cat -> id.'&ccode='.$cat -> alias. '&Itemid='); ?>
						<li class="item_tabsds">
							<h3><a href="<?php echo $link; ?>" title = "<?php echo $cat -> name; ?>"><?php echo $cat -> name;?></a> </h3>
						</li>
					<?php } ?>
				</ul> 
			</div>
		<?php } ?>
		<h2><?php echo @$config['note_video']; ?></h2>
		<?php include_once 'default_list.php';?>
	</div>

