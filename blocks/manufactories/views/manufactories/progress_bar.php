 <?php  	global $tmpl;
 $tmpl -> addStylesheet('default','blocks/partners/assets/css');
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl_carousel/owl-carousel');
$tmpl -> addStylesheet('owl.theme','libraries/jquery/owl_carousel/owl-carousel');
$tmpl -> addScript('owl.carousel','libraries/jquery/owl_carousel/owl-carousel');
$tmpl -> addStylesheet('progress_bar','blocks/slideshow/assets/css');
$tmpl -> addScript('progress_bar','blocks/partners/assets/js');
?>


<div  id="owl-demo2" class="content-partners owl-carousel">	
<?php foreach($list as $item){ ?>
	<?php $image = URL_ROOT.str_replace('/original/', '/resized/',$item -> image);?>
	<?php $link = FSRoute::_("index.php?module=manufactories&view=cat&ccode=dong-ho&cid=139&manu=".$item -> alias."&Itemid=9");?>
	<?php $class = '';?>
	<?php if($i == 1)$class .= ' first-item';?> 
	<?php if($i == $total )$class .= ' last-item';?> 
									
						
		<div class="item box-partners<?php echo $class;?>">
    		<a href="<?php  echo $link;?>" title="<?php echo $item -> name; ?>"  rel="nofollow" target="_blink">
    			<img src="<?php echo $image;?>" alt="<?php $item->name;?>" />
    		</a>
		</div>
		<?php $i ++; ?>
<?php }?>			
</div>