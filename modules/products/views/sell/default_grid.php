<?php

$max = IS_MOBILE?2:10;
?>
<div class='product_grid product_grid_full'>
    <?php $j = 0; ?>
    <?php if(count($list)){?>
    <?php foreach($list as $item){?>      
      <?php 
      include 'default_item.php';
      ?>
      <?php $j ++; ?>
      <?php }?>
    <?php }?>
    <div class="clear"></div>
</div><!--end: .vertical-->
