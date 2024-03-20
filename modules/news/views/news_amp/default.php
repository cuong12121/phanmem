<?php  	global $tmpl, $config;
$tmpl -> addStylesheet('detail_amp','modules/news/assets/css');
FSFactory::include_class('fsstring');
?>



<div class="news_detail">
	<?php if(1==2){ ?>
	<div class="avatar-detail">
		<img src="<?php echo URL_ROOT.str_replace('/original/','/large/', $data->image); ?>" alt="<?php echo htmlspecialchars(@$data->title); ?>"/>
	</div>
	<?php } ?>
	<div class="bot-content">
		<div class="name_cate hidden">
			<?php echo $data->category_name ?>
		</div>	
		<h1 class='title'>
			<?php echo $data -> title; ?>
		</h1>

		<div class="time_rate_author cls">
			<div class="time_rate cls <?php echo !$data -> summary ? 'not_summary' : '' ?>">
				 <?php  include 'default_base_rated_fixed.php'; ?>
				<span class='news_time'>
					<?php echo date('d/m/Y',strtotime($data -> created_time)); ?>
				</span>

				<div class="share-news">
					<?php //include_once 'default_share.php'; ?>
				</div>
			</div>
			<?php if(!empty($authors[$data-> author_id])){ ?>
				<div class="author-info-top">
					
<!-- 					<a class="author-name" href="<?php echo $authors[$data-> author_id]->link ; ?>">
						<?php $avt_user = URL_ROOT.str_replace('/original/','/resized/',$authors[$data-> author_id]->image); ?>
						<amp-img alt="<?php echo htmlspecialchars($authors[$data-> author_id]->name);?>" src="<?php echo $avt_user;?>"  width="40" height="40"/>
					</a>	 -->					
					
					<div class="author-meta">						
						<?php echo $authors[$data-> author_id]->name ; ?>																														
					</div>
				</div>
			<?php } ?>
		</div>

		<?php if($data -> summary){?>
			<div class="summary" ><?php echo $data -> summary; ?></div>
		<?php }?>
		
		<div class='description'>
			
			<?php 
			$description = preg_replace ( '#style\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#style\=\'(.*?)\'#is', '', $description );
			$description = preg_replace ( '#<style>(.*?)</style>#is', '', $description );
			$description = preg_replace ( '#layout\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '# h\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '# w\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#photoid\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#rel\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#type\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#align\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#longdesc\=\"(.*?)\"#is', '', $description );
			
		
			$description = preg_replace ( '#onclick\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#onclick\=\'(.*?)\'#is', '', $description );
			$description = preg_replace ( '#onmouseover\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#onmouseover\=\'(.*?)\'#is', '', $description );
			$description = preg_replace ( '#color\=\'(.*?)\'#is', '', $description );
			$description = preg_replace ( '#color\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#face\=\'(.*?)\'#is', '', $description );
			$description = preg_replace ( '#face\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#frameborder\=\'(.*?)\'#is', '', $description );
			$description = preg_replace ( '#frameborder\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#border\=\'(.*?)\'#is', '', $description );
			$description = preg_replace ( '#border\=\"(.*?)\"#is', '', $description );
			$description = preg_replace ( '#<iframe(.*?)</iframe>#is', '', $description );
			$description = preg_replace ( '#dofollow"(.*?)"#is', '', $description );
			$description = preg_replace ( '#noreferrer="(.*?)"#is', '', $description );
			$description = preg_replace ( '#data-sheets-value(.*?)\"[\s]*>#is', '>', $description );

			
			$description = str_replace('dofollow=""','',$description);
			$description = str_replace('noopener=""','',$description);
			$description = str_replace('dofollow','',$description);
			$description = str_replace('noopener','',$description);
			$description = str_replace('noreferrer"','',$description);
			$description = str_replace('ch=""','',$description);
			
			$description = str_replace('<font','<span',$description);
			$description = str_replace('</font','</span',$description);
			$description = str_replace('data-height','height',$description);
			$description = str_replace('data-width','width',$description);
			$description = str_replace('target="null"','',$description);
			$description = str_replace('new=""','',$description);
			$description = str_replace('roman=""','',$description);
			$description = str_replace('times=""','',$description);
			$description = str_replace('Times New Roman";"','',$description);
			$description = str_replace('Times New Roman','',$description);
			

			$description = $this -> amp_add_size_into_img($description);
			$description = str_replace('<img','<amp-img  layout="responsive"',$description);
			$description = str_replace('</img','</amp-img',$description);
			
			$description = str_replace('<iframe','<amp-iframe layout="responsive" sandbox="allow-scripts allow-same-origin allow-popups" ',$description);
			$description = str_replace('</iframe','</amp-iframe',$description);
			$description = preg_replace('/[\r\n]+/', '</p><p>', $description) . '</p>';
			$description = html_entity_decode($description);
			echo $description;
			?>


			
		</div>          	
	
		<?php include_once 'default_tags.php'; ?>
				


		<?php if(!empty($authors[$data-> author_id])){ ?>
		<div class="author-info">
<!-- 			<div class="author-avatar">
				<?php $avt_user = URL_ROOT.str_replace('/original/','/resized/',$authors[$data-> author_id]->image); ?>
				<amp-img alt="<?php echo htmlspecialchars($authors[$data-> author_id]->name);?>" src="<?php echo $avt_user;?>"  width="40" height="40"/>						
			</div> -->
			<div class="author-meta">						
				<a class="author-name" href="<?php echo $authors[$data-> author_id]->link ; ?>">
					<?php echo $authors[$data-> author_id]->name ; ?>						
				</a>							
				<p class="author-des">
					<?php echo $authors[$data-> author_id]->summary ; ?>
				</p>
																														
			</div>
		</div>
		<?php } ?>





		<div class="related-news">
			<?php include_once 'default_related.php'; ?>
		</div>
		<div class="mbl tab_content_right">
			<?php
		       
		        //include 'plugins/comments/controllers/comments.php'; 
		        	//$pcomment = new CommentsPControllersComments(); 
				//$pcomment->display($data);
				//include 'default_comments_fb.php'; 
			
			?>
		</div>
	</div>

</div>

<div class="col-right-detail-news">
	<?php if ($tmpl->count_block('col-right-detail-news') && 1==2) { ?>
        <?php echo $tmpl->load_position('col-right-detail-news'); ?>
    <?php } ?>

	<?php 
        include 'related/default_related.php';			
	?>
</div>



<input type="hidden" value="<?php echo $data->id; ?>" name='news_id' id='news_id'  />

<div class="clear"></div>
	



