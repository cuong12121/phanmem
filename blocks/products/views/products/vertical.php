<?php
global $tmpl; 
$tmpl -> addStylesheet('vertical','blocks/products/assets/css');
FSFactory::include_class('fsstring');
$total = count($list);
$j = 0;
$cols = 5;
?>	
<?php if(isset($list) && !empty($list)){ ?>
  <div class="block-products block-products-vertical blocks">
    <?php
    $image_cat = URL_ROOT.str_replace('/original/', '/resized/', $cat->image);
    $Itemid_cat = 34;
    $link_cat = FSRoute::_("index.php?module=products&view=cat&ccode=".$cat -> alias."&cid=".$cat->id."&Itemid=".$Itemid_cat);
    ?>
    <div class="cat_image">
      <span class="summary"><?php echo $cat-> summary; ?></span>
      <a href="<?php echo $link_cat; ?>" class="link_cat" title="Xem tất cả">Xem tất cả</a>
    </div>
    <?php foreach($list as $item){
     $Itemid = $item -> is_accessories ? 37: 35;
     $link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&id='.$item -> id.'&ccode='.$item->category_alias.'&Itemid='.$Itemid);
     $link_buy = FSRoute::_("index.php?module=products&view=cart&task=buy&id=".$item->id."&Itemid=94");
     ?>
     <div class="row row_<?php echo $j%$cols;?>">
      <div class="frame_img_cat ">
        <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" >
          <img class="img-responsive lazy" data-src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item->image); ?>" alt="<?php echo htmlspecialchars ($item -> name); ?>"  />
        </a>
      </div>
      <div class="frame_title">
       <a href="<?php echo $link; ?>" title = "<?php echo $item -> name ; ?>" class="name" ><?php echo get_word_by_length(40,$item -> name); ?>
     </a>	
     <div class="price"><?php echo format_money($item -> price); ?></div>
   </div>
   <div class='clear'></div>
 </div>
 <?php $j ++;?> 	
<?php } ?>
<div class="clear"></div>
</div>

<?php } ?>
