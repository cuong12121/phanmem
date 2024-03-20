<?php 
global $tmpl; 
$tmpl -> addStylesheet('news_search','modules/news/assets/css');

$page = FSInput::get('page');
$title = $keyword;
	if(!$page)
		$tmpl->addTitle( $title);
	else 
		$tmpl->addTitle( $title.' - Trang '.$page);
		
    $total_news_list = count($list);
    
    $str_meta_des = $keyword;
    
    for($i = 0; $i < $total_news_list ; $i ++ ){
        $item = $list[$i];
        $str_meta_des .= ','.$item -> title;
    }
	$tmpl->addMetakey($str_meta_des);
	$tmpl->addMetades($str_meta_des);
	$Itemid = 6;
?>
<?php
?>
<div class="news_search news_page">
	    <h1 class="img-title-cat page_title">
	      <span><?php echo FSText::_('Kết quả tìm kiếm cho từ khóa').' "'.$keyword.'"'; ?></span>
	    </h1>
    <?php if($total_news_list){?>
	        <?php  include 'default_list.php'; ?>
			
			<?php 
				if($pagination) echo $pagination->showPagination(3);
			} else {
				echo "Không có kết quả nào cho từ khóa <strong>".$keyword."</strong>";
			 }
			 ?>
		<div class='clear'></div>
</div>
