<?php
global $tmpl, $config, $is_mobile;
$tmpl -> addStylesheet('home','modules/news/assets/css');
$total_news_list = count($list);
$Itemid = 7;
FSFactory::include_class('fsstring');	
?>
<div class="detail_page_top">
	<div class="detail_page_l">
		<div class="news_detail ">
			<h1 class="img-title-cat page_title"><span><?php echo FSText::_('Tin tức'); ?></span></h1>
			<?php if($total_news_list){?>
				<div class="news_top">
					<?php include 'default_header.php'; ?>
				</div>
				<div class="news_bottom">
					<?php  include 'default_list.php'; ?>
				</div>
				<?php  if($pagination) echo $pagination->showPagination(3);?>
			<?php }else{?>
				<div><?php echo FSText::_('Không có bài viết nào'); ?></div>
			<?php }?>
		</div>
	</div>
	<div class="detail_page_r">
		<?php if ($tmpl->count_block('right_b')) { ?>
			<?php echo $tmpl->load_position('right_b'); ?>
		<?php } ?>
		
	</div>
</div>