<?php
global $tmpl; 
$tmpl -> addStylesheet('demo','modules/products/assets/css');
$tmpl -> addStylesheet('demo_pk','modules/products/assets/css');
$tmpl -> addScript('script','modules/products/assets/js');

?>	
<div id="main">
	<div id="gallery">
        <div id="slides">    
        <div class="slide"><img src="<?php echo URL_ROOT.'images/products/medium/'.$data->image; ?>" width="356" height="356" alt="side" /></div>
        <?php for($i = 0 ; $i < count($product_images); $i ++ ){?>
        <?php $item = $product_images[$i];?>
        <div class="slide"><img src="<?php echo URL_ROOT.'images/products/medium/'.$item->image; ?>" width="356" height="356" alt="side" /></div>
        <?php }?>
        </div>
        <div id="menu">
        <ul id="accessories-ul" class="menu-ul" lang="<?php echo count($product_images);?>">
            <li lang="1" class="menuItem"><a href="#"><img width="70px" height="70px" src="<?php echo URL_ROOT.'images/products/small/'.$data->image; ?>" alt="thumbnail" /></a></li>
            <?php for($i = 0 ; $i < count($product_images); $i ++ ){?>
            <?php $item = $product_images[$i];?>
            <li lang="<?php echo $i+2;?>" class="menuItem"><a href="#"><img width="70px" height="70px" src="<?php echo URL_ROOT.'images/products/small/'.$item->image; ?>" alt="thumbnail" /></a></li>
            <?php }?>
        </ul>
        </div>
        <div class="clear"></div>      
  	</div>
  	<div class="clear"></div>
</div>
<div class="clear"></div>