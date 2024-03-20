<div class="item">         
    <figure class="product_image "  >
        <?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
        <a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
          <?php echo set_image_webp($item->image,'resized',@$item->name,'','',''); ?>
        </a>
        <?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            <div class='hot_icon'><?php echo '-'.round((($item -> price_old - $item -> price) /$item -> price_old) * 100).'%'; ?></div>
        <?php }?>
    </figure>
    <h3>
        <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
            <?php echo $item -> name ?>
        </a> 
    </h3>
    <div class='price_arae'>
        <?php if( $item -> price_old && $item -> price_old > $item -> price){?>
        <div class='price_old'>
            <span><?php echo format_money($item -> price_old).''?></span>
        </div>
        <?php }?>
        <div class='price_current'>
            <?php echo format_money($item -> price)?>  
        </div>
    </div>
</div>