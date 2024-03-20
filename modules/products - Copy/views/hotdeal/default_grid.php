<?php
FSFactory::include_class('fsstring');
 $max = IS_MOBILE?2:10;
?>
<div class='product_grid product_grid_full'>
    <?php 
    $products = $array_products[$cat2->id];
    for($j = 0 ; $j < count($products); $j ++)
    {
      $item = $products[$j];  
      
    ?>
					<?php  include 'default_item.php'; ?>					

  
	   <?php }?>
 
    <div class="clear"></div>
</div>

