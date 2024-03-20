<?php 
global $tmpl, $config,$is_mobile;
$tmpl -> addStylesheet('products');
$tmpl -> addStylesheet("combo","modules/products/assets/css");
FSFactory::include_class('fsstring');
$max = $is_mobile ? 6 : 10;
?>
<?php if($tmpl->count_block('pos1_combo')) {?>
  <div class="pos1_combo">
    <?php  echo $tmpl -> load_position('pos1_combo','XHTML2'); ?>
  </div>
<?php }?>
<div class="wapper-content-page container">
  <?php  echo $tmpl -> load_position('top-home-product', 'XHTML'); ?>
  <?php 
  for($i = 0 ; $i < count( $array_cats) ; $i ++)
  {
    $cat = $array_cats[$i];
    if(!count($array_products[$cat->id])){
     continue;
   }

   $link_cat = FSRoute::_("index.php?module=products&view=cat&ccode=".$cat -> alias.'&cid='.$cat -> id);
   ?>

   <div class="cat_item_store" id="catcombo<?php echo $cat -> id; ?>">
    <div class="cat_label">
      <a href="<?php echo $link_cat; ?>" title="<?php echo $cat -> name; ?>"><?php echo $cat -> name; ?></a>
    </div>
    <div class="product_star">
      <span class="line-thought"></span>
      <span class="star_small"><i class="fa fa-star"></i></span>
      <span class="star_large"><i class="fa fa-star"></i></span>
      <span class="star_small"><i class="fa fa-star"></i></span>
      <span class="line-thought"></span>
    </div>
    <div class="row product_grid">
      <!--	EACH PRODUCT				-->
      <?php 
        $j = 1;
        if(!$cat->count_combo_home){
            $cat->count_combo_home =8;
        }
        foreach($array_products[$cat->id] as $item){            
          include 'default_item.php';
          if($j == $cat->count_combo_home){
            break;
          }
          $j++;
        }
      ?>		
      <!--	end EACH PRODUCT				-->
    </div>
    <div class="view_all_cat_item">
      <a href="<?php echo $link_cat; ?>" title="<?php echo $cat -> name; ?>">Xem thêm
      </a>
    </div>
    <div class="clear"></div>
  </div>
  <?php 	
} 
?>
</div>
