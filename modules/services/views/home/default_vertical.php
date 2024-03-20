<div class='vertical projectlist_slide'>
    <?php $tmp = 0; ?>
    <?php if(count($list)){?>
        <?php foreach($list as $item){
            $link = FSRoute::_('index.php?module=projects&view=project&code='.$item -> alias.'&ccode='.$item->category_alias.'&cid='.$item->category_id.'&id='.$item->id);

                ?>
            <div class="item " itemscope="" itemtype="http://schema.org/Product">
                <link itemprop="url" href="<?php echo $link; ?>">
                <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
                    <figure>
                        <figcaption class="media-caption">
                             <?php echo $item->summary;?>
                        </figcaption>
                        <picture>
                            <img  class="img-responsive" alt="<?php echo $item->name;?>" src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image);?>" onerror="javascript:this.src='<?php echo URL_ROOT.'images/NA285x200.jpg'?>';"/>
                        </picture>
                    </figure>
                    <h2 class="name" itemprop="name" >
                        <?php echo $item -> name; ?>
                    </h2> 
                    <div class="desc " ><i class="fa fa-map-marker"></i><?php echo ($item -> location)?$item -> location:'&nbsp;'; ?></div>
                    
                </a>
            </div>

            <?php } ?>  
    <?php }?>
</div><!--end: .vertical-->

