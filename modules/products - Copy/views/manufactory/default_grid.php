<?php
$max = IS_MOBILE?2:10;
FSFactory::include_class('fsstring');
?>
<div class='product_grid product_grid_full'>
    <?php $tmp = 0; ?>
    <?php $j = 0; ?>
    <?php if(!empty($list)){?>
		<?php foreach($list as $item){?>
			<?php include 'default_item_lazy.php';?>
			<?php $j ++; ?>               
	    <?php }?>
    <?php }?>
    <div class="clear"></div>
</div><!--end: .vertical-->

