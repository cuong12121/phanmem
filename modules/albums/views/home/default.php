<?php
global $tmpl;
$tmpl -> addStylesheet('owl.carousel','libraries/jquery/owl.carousel.2/assets');
$tmpl -> addScript('owl.carousel.min','libraries/jquery/owl.carousel.2');
$tmpl -> addStylesheet('home','modules/albums/assets/css');
$tmpl -> addScript('home','modules/albums/assets/js');	
$total_list = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');	
?>	
<div class="albums_page">
	<h1 class="img-title-cat page_title">
      <span>Bộ sưu tập</span>
    </h1>
    <?php if($total_list){?>
    	<?php  include 'default_list.php'; ?>
	<?php }else{?>
  	<div>Không có bài viết nào</div>
	<?php }?>
</div>
<?php 
if($pagination) echo $pagination->showPagination(3);
?>