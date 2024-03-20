<?php
global $tmpl;
$tmpl -> addStylesheet('home','modules/services/assets/css');
$tmpl -> addScript('cat','modules/services/assets/js');	
$total_news_list = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');	
?>	



<div class="services_home news_page">
 <h1 class="img-title-cat page_title">
  <span><?php echo FSText::_('Dịch vụ'); ?></span>
</h1>
<?php if(1==2) { ?>
    <div class="cat_item_store">
     <ul>
        <li class="item_tabsds active" id="item_tabds_0">
            <a title="Xem thêm"  href="javascript:void(0)">Tất cả</a>
        </li>

        <?php $x = 0; foreach ($list_cats as $cat) { ?>
            <?php $link = FSRoute::_('index.php?module=services&view=cat&cid='.$cat -> id.'&ccode='.$cat -> alias. '&Itemid=93'); ?>
            <li class="item_tabsds">
                <a href="<?php echo $link; ?>" title = "<?php echo $cat -> name; ?>"><?php
                echo $cat -> name;?></a> 
            </li>
        <?php } ?>
    </ul> 
</div>
<?php } ?>

<?php if($total_news_list){?>
  <div class="services-block cls">
    <?php
    $Itemid = 94;
    for($i = 0; $i < count($list); $i ++ ){
      $item = $list[$i];
      $link = FSRoute::_("index.php?module=services&view=services&id=".$item->id."&code=".$item->alias."&ccode=".$item-> category_alias."&Itemid=$Itemid"); 
      $data_out = $i % 3 == 0 ? 'fade-right' : ($i % 3 == 1 ? 'flip-down':'fade-up-left') ; 
      ?>
      <div id="item_<?php echo $i; ?>" class="item aos-item">
        <div class="img">
        <a href="<?php echo $link ?>" title="<?php echo $item->title; ?>">
           <?php $image_webp = $this -> image_webp(URL_ROOT.str_replace('/original/', '/resized/', $item -> image)) ;?>
            <img src="<?php echo URL_ROOT.str_replace('/original/', '/resized/', $item -> image); ?>" srcset="<?php echo $image_webp;  ?>" alt="<?php echo $item->title; ?>"/>
         </a>
        </div>

        <div class="name_item">
          <a href="<?php echo $link ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a>
        </div>
      </div>
      <?php     
    }
    ?>
  </div>
<?php }else{?>
  <div><?php echo FSText::_('Không có bài viết nào'); ?></div>
<?php }?>
</div>
<div class="clear"></div>
<?php 
if($pagination) echo $pagination->showPagination(3);
?>

