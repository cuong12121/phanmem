<?php
	global $tmpl;
	$tmpl -> addStylesheet('home_amp','modules/news/assets/css');
	
	$total_news_list = count($list);
    $Itemid = 7;
	FSFactory::include_class('fsstring');	
?>	
<div class="news_home news_page">
	<h1 class="img-title-cat page_title">
      <span>Tin tức</span>
    </h1>
    
    <?php if($total_news_list){?>
        <?php  include 'default_list.php'; ?>
     <?php }else{?>
     	<div>Không có bài viết nào</div>
     <?php }?>
</div>
<?php 
	if($pagination) echo $pagination->showPagination(3);
?>