<?php
	global $tmpl;
	$tmpl -> addStylesheet('aq_home','modules/aq/assets/css');
	$tmpl -> addScript('aq_home','modules/aq/assets/js');
	$page = FSInput::get('page');
    $Itemid = 7;
//	$tmpl -> addScript('form');
?>	
	
	<div class="aq_home wapper-page  wapper-page-cat">
		<div class="page_head">
		 	<h1 class="home_title page_title">
		     	<span><?php echo FSText::_('Hỏi đáp'); ?> </span>
		    </h1>
		    <div class="clear"></div>
	    </div>
		<div class="wapper-content-page">
<!-- 			<label><?php //echo FSText::_('fqa_note')?></label> -->
			<?php //include 'default_common.php';?>
			<?php 
	for($i = 0 ; $i < count( $array_cats) ; $i ++)
	{
		$cat = $array_cats[$i];
		if(!count($array_records[$cat->id])){
			continue;
		};
		$link_cat = FSRoute::_("index.php?module=aq&view=cat&ccode=".$cat -> alias."&id=".$cat -> id);
		?>
		
		<div class="cat_item_store">
			<div class='cat-title'>
				<h2><a class="cat_readmore" href="<?php echo $link_cat; ?>"><?php echo $cat->name;?></a></h2>
			</div>
			<div class="row">
						<!--	EACH PRODUCT				-->
						<?php 
						$items = $array_records[$cat->id];
						for($j = 0 ; $j < count($items); $j ++)
						{
							$item = $items[$j];
						?>
							<?php include 'default_item.php';?>
						<?php 
						}
						?>		
						<!--	end EACH PRODUCT				-->
                   
			</div>
			<a class="cat_readmore" href="<?php echo $link_cat; ?>"><?php echo FSText::_('Xem tất cả'); ?></a>
            <div class="clear"></div>
		</div>
	<?php 	
	} 
	?>
			<div class='clear'></div>
		</div>	
		<?php  //include PATH_BASE.'modules/aq/views/common/send_request.php';?>

	</div>

	<?php echo $tmpl -> load_direct_blocks('aq',array('style'=>'form_question')); ?>

	
