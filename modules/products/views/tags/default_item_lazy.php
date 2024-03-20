<div class="item">                    
    <div class="frame_inner">
        <figure class="product_image "  >
            <?php $image_small = str_replace('/original/', '/resized/', $item->image); ?>
            <a href="<?php echo $link;?>" title='<?php echo $item->name;?>'>
                <?php echo set_image_webp($item->image,'resized',@$item->name,'lazy',1,''); ?>
            </a>
            <?php if($item->status == 17){ ?>
                <div class="text-sold-out">Hết<br \>hàng</div>
            <?php } ?>
            <?php 
                if($item -> is_new == 1 && $item -> is_hot ==1){
                    echo "<span class='icon_br'>Hot</span>";
                }elseif($item -> is_new == 1){
                    echo "<span class='icon_br'>New</span>";
                }elseif($item -> is_hot == 1){
                    echo "<span class='icon_br'>Hot</span>";
                }
            ?>
            <?php 
                if(!empty($types) && !empty($item ->type)){
                    $type = $types[$item ->type];
                    if(!empty($type)){
                        echo "<span class='icon_bl'>".$type->name."</span>";
                    }
                }
            ?>
        </figure>
        
        <h3 >
            <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" >
              <span class="cat_name"><?php echo $item-> category_name  . ' '.($item-> manufactory_name) ;?></span>
              <?php echo FSString::getWord(15,$item -> code) ?>
              
            </a>  
        </h3>

       <div class='price_arae'>
            <?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            <div class='price_old'>
                Giá: <span><?php echo format_money($item -> price_old).''?></span>
            </div>
            <?php }?>
            <div class='price_current'>
                <?php if( $item -> price_old && $item -> price_old > $item -> price){?>
                    Giá KM: 
                <?php }else{?>
                    Giá:
                <?php } ?>
                <?php echo format_money($item -> price)?>  
            </div>
        </div>

        <?php if( $item -> price_old && $item -> price_old > $item -> price){?>
            <div class='discount'><span><?php echo '-'.round((($item -> price_old - $item -> price) /$item -> price_old) * 100).'%'; ?></span></div>
        <?php }?>

        <div class="clear"></div>  
        
    </div>   <!-- end .frame_inner -->
    <div class="clear"></div> 
</div>     
