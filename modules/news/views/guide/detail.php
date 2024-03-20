<link href="modules/news/includes/css/news.css" media="screen" type="text/css" rel="stylesheet" />
<?php 
	$Itemid = FSInput::get('Itemid',1);
?>	
<div id="news-cat">
	<div id="news-title">
		<h1><?php echo "H&#432;&#7899;ng d&#7851;n s&#7917; d&#7909;ng"; ?></h1>
		<div class='date'><?php echo fsdate($data->created_time); ?></div>
	</div>
	<div id="news-detail">
		
		<div id="news-head-t">
			<div class="news-head-t-l">
				<div class="news-head-t-r">
				</div>	
			</div>	
		</div>	
		<div class="news_detail-inner">
			<div class="news_detail-inner-wrap">
				<div id="print">
					<div class="news-detail">
					
						<h2 class="news_title"><?php echo $data->title;?></h2>
						<div class="news-summary">
							<?php echo $data->summary;?>
						</div>
						<div class="news-content">
							<?php echo $data->content;?>
						</div>
						<div class="news-authors">
							<?php if($data->source_website)
										echo FSText :: _("From source")." ". $data->source_website;
								else
									echo "<span>".$data->creator."</span>";
							?>
								
						</div>
					</div>
				</div>
				<div class="add-task">
					 <ul>
						  <li><a onclick="share_facebook();" href="javascript:;">
						  	<img  alt="Share on Facebook" src="images/facebook-icon.jpg"> </a>
						  </li>
						  <li><a  onclick="share_twitter();" href="javascript:;">
						  	<img  alt="Share on Twitter" src="images/twitter-icon.jpg"></a>
						  </li>
						  <li><a  onclick="share_google();" href="javascript:;">
						  	<img alt="Share on Google" src="images/google-icon.jpg"></a>
						  </li>
						  <li><a onclick="return OpenPrint();" href="javascript:;" class="dt-print">
						  	<img alt="Print" src="images/print-icon.jpg">
						  	<span><?php echo FSText :: _("Print");?></span></a>
						  </li>
						  <li><a onclick="sendEmail();return false;" href="javascript:;">
			  				<img alt="Print" src="images/email-icon.jpg">
					  		<span><?php echo FSText :: _("E-mail")?></span></a>
			  			</li>
					 </ul>
						
				</div>
					
			</div>
		</div>
	</div>

</div>