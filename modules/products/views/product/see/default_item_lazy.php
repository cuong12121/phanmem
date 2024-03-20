
<div class="item ">
    <div class="frame_inner">
        <link itemprop="url" href="<?php echo $link; ?>" />
        <figure class="product_image "  >
            <?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
            <a href="<?php echo $link;?>" title='<?php echo htmlspecialchars($item->name);?>'  itemprop="url">
                <?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); ?>
            </a>
        </figure>
        
        <?php if($item -> style_types){ ?>
           <div class="note_hotdeal">
            <?php $arr_style_type = explode(',', $item -> style_types); ?>
            <?php foreach( $arr_style_type as $st){ ?>
                <?php if($st){ ?>
                    <div class= '<?php echo $st; ?> '><span><?php echo $style_types_rule[$st]; ?></span></div>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
    

    <h2 itemprop="name"><a href="<?php echo $link; ?>" title = "<?php echo htmlspecialchars($item -> name) ; ?>" class="name" >
        <?php echo FSString::getWord(15,$item -> name); ?>
    </a> </h2>  
    <div class='price_arae'>
        Giá:<div class='price_current' ><?php echo format_money($item -> price).''?></div>

        <?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            <span class='price_old'><span><?php echo format_money($item -> price_old).''?></span></span>
        <?php }?>
    </div>

    <div class="clear"></div> 
    <?php if(count($types)){?>
        <?php $k  = 0;?>
        <?php foreach($types as $type){?>
            <?php if(strpos($item -> types,','.$type->id.',') !== false || $item -> types == $type->id){?>
                <div class='product_type product_type_<?php echo $type -> alias; ?> product_type_order_<?php echo $k; ?>'><?php echo $type -> name; ?></div>
                <?php $k ++; ?>
            <?php }?>

        <?php }?>
    <?php }?>                           
</div>   	
</div>
