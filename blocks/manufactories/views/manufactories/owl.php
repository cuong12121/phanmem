<?php
global $tmpl;

$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addScript('owl','blocks/partners/assets/js');
$tmpl -> addStylesheet('owl','blocks/partners/assets/css');
$page = 4;

//  $tmpl -> addStylesheet('swiper.min');
// $tmpl -> addScript('swiper.min');

// $tmpl->addStylesheet('default', 'blocks/partners/assets/css');
//$tmpl->addStylesheet('swiper.min', 'blocks/partners/assets/css');
//$tmpl->addStylesheet('owl.carousel', 'libraries/jquery/owl_carousel/owl-carousel');
//$tmpl->addStylesheet('owl.theme', 'libraries/jquery/owl_carousel/owl-carousel');
//$tmpl->addScript('owl.carousel', 'libraries/jquery/owl_carousel/owl-carousel');
//$tmpl->addStylesheet('progress_bar', 'blocks/slideshow/assets/css');
//$tmpl->addScript('swiper.min', 'blocks/partners/assets/js');
// $tmpl->addScript('partner', 'blocks/partners/assets/js');
?>
<div class="partner_hightline" style="background: url('<?php echo URL_ROOT . $image_block; ?>') no-repeat top center;     background-position: center;">
<div class="container">
    <h2><span><a href="<?php echo FSRoute::_('index.php?module=manufactories'); ?>"><?php echo $title; ?></a></span></h2>
    <p class="dang-phan-phoi">Đang phân phối</p>
    <div class="row">
    
        <div class="owl-partners-container">	
            <div class="owl-partners-wrapper">
                <?php $i = 0; ?>
                <?php foreach ($list as $item) { ?>

                    <?php if( !$i || !($i%$page) ){?>
                        <div class="item ">
                            <div class="item_inner cls">
                     <?php }?> 

                    <?php $image = URL_ROOT . str_replace('//original/', '/resized/', $item->image); ?>
                    <?php $link = FSRoute::_("index.php?module=manufactories&view=cat&ccode=dong-ho&cid=139&manu=" . $item->alias . "&Itemid=9"); ?>
                        <div class="partner-item">
                            
                            <a href="<?php echo $link; ?>" title="<?php echo $item->name; ?>"  rel="nofollow" target="_blink">
                                <img class="owl-lazy" data-src="<?php echo $image; ?>" alt="<?php $item->name; ?>" />
                            </a>
                            
                        </div>
                    		

                     <?php if(($i+1) == count($list) || !(($i+1)%$page) ){?>
                            </div> <!-- .item_inner -->
                        </div> <!-- .item -->
                     <?php }?> 
                      <?php $i++;?>
                <?php } ?>

            </div>
        </div>
   
        
   
    </div>
    <div class="clearfix"></div>
</div>
</div>

