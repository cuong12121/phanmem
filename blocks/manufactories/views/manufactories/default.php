<?php
global $tmpl;
 $tmpl -> addStylesheet('swiper.min');
$tmpl -> addScript('swiper.min');

$tmpl->addStylesheet('default', 'blocks/partners/assets/css');
//$tmpl->addStylesheet('swiper.min', 'blocks/partners/assets/css');
//$tmpl->addStylesheet('owl.carousel', 'libraries/jquery/owl_carousel/owl-carousel');
//$tmpl->addStylesheet('owl.theme', 'libraries/jquery/owl_carousel/owl-carousel');
//$tmpl->addScript('owl.carousel', 'libraries/jquery/owl_carousel/owl-carousel');
//$tmpl->addStylesheet('progress_bar', 'blocks/slideshow/assets/css');
//$tmpl->addScript('swiper.min', 'blocks/partners/assets/js');
$tmpl->addScript('partner', 'blocks/partners/assets/js');
?>
<div class="partner_hightline" style="background: url('<?php echo URL_ROOT . $image_block; ?>') no-repeat top center;     background-position: center;">
<div class="container">
    <h2><span><a href="<?php echo FSRoute::_('index.php?module=manufactories'); ?>"><?php echo $title; ?></a></span></h2>
    <p class="dang-phan-phoi">Đang phân phối</p>
    <div class="row">
    <div class="col-md-7 col-md-offset-5 col-sm-7 col-xs-12">
        <div class="swiper-container">	
            <div class="swiper-wrapper">
                <?php foreach ($list as $item) { ?>
                    <?php $image = URL_ROOT . str_replace('//original/', '/resized/', $item->image); ?>
                    <?php $link = FSRoute::_("index.php?module=manufactories&view=cat&ccode=dong-ho&cid=139&manu=" . $item->alias . "&Itemid=9"); ?>
                        <div class="swiper-slide box-partners">
                            <h3>
                            <a href="<?php echo $link; ?>" title="<?php echo $item->name; ?>"  rel="nofollow" target="_blink">
                                <img class="lazy" data-src="<?php echo $image; ?>" alt="<?php $item->name; ?>" />
                            </a>
                            </h3>
                        </div>
                    <?php } ?>			
            </div>
        </div>
                        <!-- Add Arrows -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
        
    </div>
    </div>
    <div class="clearfix"></div>
</div>
</div>

