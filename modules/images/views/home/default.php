<?php
	global $tmpl;
	$tmpl -> addStylesheet('home','modules/images/assets/css');
//	$tmpl -> addScript('cat','modules/news/assets/js');	
	$total_news_list = count($list);
  
    $Itemid = 98;
	FSFactory::include_class('fsstring');	
?>	
<div class="images_home news_page">
	<h1 class="img-title-cat page_title">
      <span><?php echo FSText::_('Hình ảnh'); ?></span>
    </h1>
    <?php if($total_news_list){?>
        <?php  include 'default_list.php'; ?>
     <?php }else{?>
     	<div><?php echo FSText::_('Không có bài viết nào'); ?></div>
     <?php }?>
</div>
<?php 
	if($pagination) echo $pagination->showPagination(3);
?>