<?php 
$link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
$Itemid = 35;
$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id.'&cid='.$item->category_id.'&Itemid='.$Itemid);
?>
<div class="item item_often">                   
    <div class="frame_inner">
        <figure class="product_image ">
            <?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
                <a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
                    <?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); ?>
                </a>
                <?php  if(!empty($item->type) && !empty($types)){ ?>
                    <!-- <div class="type"><span><?php //echo $types[$item->type]->name ?></span></div> -->
                <?php } ?>

                
        </figure>
        <?php if($item-> is_hot == 1){ ?>
            <!-- <span class="icon_hot">Hot</span> -->
        <?php } ?>
        <div class="box_content">           
                <?php if( $item-> price_old > $item-> price){ ?>
                    <span class="discount_tt"><span>-<?php echo round((($item -> price_old - $item -> price) /$item -> price_old) * 100) ?></span>Giảm sốc</span>
                <?php } ?>
            <h3><a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
                    <?php echo FSString::getWord(15,$item -> name); ?>
            </a></h3>   
            <div class='price_arae'> 
                <span class='price_current'><?php echo format_money($item -> price).''?></span> 
                <?php if($item-> price_old > $item-> price) {?>
                    <span class='price_old'><?php echo format_money($item -> price_old) ?></span>
                    
                <?php }?>
            </div>
            
        </div>
    </div>                                                  
</div>      
