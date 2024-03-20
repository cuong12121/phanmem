<link href="modules/news/includes/css/news.css" media="screen" type="text/css" rel="stylesheet" />
	
<?php 
	$Itemid = FSInput::get('Itemid',1);
?>	
<div id="news-cat">
	<div id="news-title">
		<h1>K&#7871;t qu&#7843; t&#236;m ki&#7871;m</h1>
		<div class='date'></div>
	</div>
	<div id="news-list">
		
		<div id="news-head-t">
			<div class="news-head-t-l">
				<div class="news-head-t-r">
				</div>	
			</div>	
		</div>	
		<div class="news-list-inner">
			<div class="news-list-inner-wrap">
				<?php if(count($news_list)){?>	
					<?php for($i = 0; $i < count($news_list); $i ++){?>
						<?php $news = $news_list[$i]; ?>
						<?php $link_news = FSRoute::_("index.php?module=news&view=news&id=$news->id&Itemid=$Itemid"); ?>
							<div class='item'>
								<div class='item-img'>
									<a href="<?php echo $link_news; ?>"><img src="<?php echo URL_IMG_CT_NEWS_DETAIL.$news->image; ?>"  alt="<?php echo $news->image; ?>" /></a>
								</div>
								<div class='item-content'>				
									<h2><a href="<?php echo $link_news; ?>">
										<?php echo $news->title; ?>
									</a></h2>
									<div class='item-sum'>
									<?php echo $news->summary; ?>
									</div>
									<p class='read-more'>
										<a href="<?php echo $link_news; ?>">
											<?php echo FSText :: _("Xem chi ti&#7871;t"); ?>
										</a>
									</p>
								</div>
						</div>
						<?php if($i < (count($news_list)-1)) {?>
						<div class='separate'></div>
						<?php }?>
					<?php }?>
				<?php } else {?>
					Kh&#244;ng c&#243; k&#7871;t qu&#7843; n&#224;o cho t&#7915; kh&#243;a t&#236;m ki&#7871;m c&#7911;a b&#7841;n
				<?php }?>
			</div>
		</div>
		<?php if($pagination) echo $pagination->showPagination();?>
	</div>

</div>