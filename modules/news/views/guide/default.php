<link href="modules/news/includes/css/news.css" media="screen" type="text/css" rel="stylesheet" />
	
<?php 
	$Itemid = FSInput::get('Itemid',1);
	global $tmpl;
	$tmpl -> setTitle("H&#432;&#7899;ng d&#7851;n s&#7917; d&#7909;ng");
?>	
<div id="news-cat">
	<div id="news-title">
		<h1><?php echo "H&#432;&#7899;ng d&#7851;n s&#7917; d&#7909;ng"; ?></h1>
		<div class='date'><?php echo fsdate(); ?></div>
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
				<div class="guide_top">
					V&#7899;i s&#7889; l&#432;&#7907;ng ng&#432;&#7901;i truy c&#7853;p g&#7847;n 500.000 l&#432;&#7907;t m&#7895;i ng&#224;y , sanEPS.com l&#224; 1 s&#224;n giao d&#7883;ch Th&#432;&#417;ng M&#7841;i &#272;i&#7879;n T&#7917; s&#7889; 1 Vi&#7879;t Nam hi&#7879;n nay v&#224; x&#7913;ng &#273;&#225;ng &#273;&#7875; b&#7841;n &#273;&#7847;u t&#432; Qu&#7843;ng C&#225;o . N&#7871;u c&#243; m&#7897;t n&#417;i &#273;&#7911; s&#7913;c m&#7841;nh &#273;&#7875; th&#432;&#417;ng hi&#7879;u b&#7841;n lan r&#7897;ng , mang l&#7841;i s&#7889; l&#432;&#7907;t ng&#432;&#7901;i mua h&#224;ng v&#432;&#7907;t tr&#7897;i cho c&#244;ng vi&#7879;c kinh doanh c&#7911;a b&#7841;n , n&#417;i &#273;&#243; ch&#7881; c&#243; th&#7875; l&#224; sanEPS.com.!  
				</div>
				<div class="guide_body">
					<?php echo $html; ?>
				</div>
				
				<div class="guide_footer">
					
					<!--	ADVERTISEMENT				-->
					<div class='f_item'>
						<h3>B&#7841;n mu&#7889;n qu&#7843;ng c&#225;o tr&#234;n s&#224;n EPS</h3>
						<div class='f_item_body'>
						<img alt="advertisement" src="images/price-adv.jpg" />
						<ul>
							<?php 
							$html = "";
							if(count($news_advantage))
							{
								foreach ($news_advantage as $item) {
									$html .= "<li class='li-arrow'>";
									$link = FSRoute::_("index.php?module=news&view=guide&id=$item->id&task=detail&Itemid=$Itemid");
									$html .= "<a href='".$link."'>".$item -> title ."</a>";	
									
									$html .= "</li>";
								}
								
							}
							echo $html;
							?>
						</ul>	
						</div>
					</div>
					<!--	end ADVERTISEMENT				-->
					
					<!--	JOB				-->
					<div class='f_item'>
						<h3>B&#7841;n mu&#7889;n l&#224;m vi&#7879;c t&#7841;i EPS</h3>
						<div class='f_item_body'>
						<img alt="advertisement" src="images/job.jpg" />
						<ul>
							<?php 
							$html = "";
							if(count($news_job))
							{
								foreach ($news_job as $item) {
									$html .= "<li class='li-arrow'>";
									$link = FSRoute::_("index.php?module=news&view=guide&id=$item->id&task=detail&Itemid=$Itemid");
									$html .= "<a href='".$link."'>".$item -> title ."</a>";	
									
									$html .= "</li>";
								}
								
							}
							echo $html;
							?>
						</ul>	
						</div>
					</div>
					<!--	end JOB				-->
					
					
					<!--	ENTERED			-->
					<div class='f_item'>
						<h3>Kinh doanh v&#7899;i EPS</h3>
						<div class='f_item_body'>
						<img alt="advertisement" src="images/entered.jpg" />
						<ul>
							<?php 
							$html = "";
							if(count($news_sale))
							{
								foreach ($news_sale as $item) {
									$html .= "<li class='li-arrow'>";
									$link = FSRoute::_("index.php?module=news&view=guide&id=$item->id&task=detail&Itemid=$Itemid");
									$html .= "<a href='".$link."'>".$item -> title ."</a>";	
									
									$html .= "</li>";
								}
								
							}
							echo $html;
							?>
						</ul>	
						</div>
					</div>
					<!--	end ENTERED			-->
					
					
				</div>
				
			</div>
		</div>
	</div>

</div>