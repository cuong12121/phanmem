<?php  	global $tmpl;
$tmpl -> addStylesheet('detail_amp','modules/news/assets/css');
FSFactory::include_class('fsstring');

$print = FSInput::get('print',0);
?>



<div class="news_detail">

	<!-- NEWS NAME-->	
	<h1 class='title'>
		<?php	echo $data -> title; ?>
	</h1>
	
	
	<?php //include_once 'default_share.php'; ?>
	<!-- end NEWS NAME-->
			
	<!-- DATETIME -->
	<div class="time_rate cls">
		 <?php  include 'default_base_rated_fixed.php'; ?>
		<span class='news_time'><?php echo date('d/m/Y',strtotime($data -> created_time)); ?> </span>
		<span>-</span>
		<span class="new_category"><?php	echo $category->name; ?></span>

	</div>
	
								
		<!-- SUMMARY -->
	<?php if($category -> display_summary){?>
		<div class="summary"><?php echo $data -> summary; ?></div>
	<?php }?>
	<?php if(!empty($relate_news_list_by_tags)){?>
	<div class='relate_t'>
		<?php $i = 0;?>
		<?php foreach($relate_news_list_by_tags as $item){?>
			<?php $link_news = FSRoute::_("index.php?module=news&view=news&code=".$item->alias."&id=".$item -> id."&ccode=".$item -> category_alias); ?>
			<h2 class="relate_item">
				<a href="<?php echo $link_news; ?>" title="<?php echo htmlspecialchars($item -> title); ?>"><?php echo $item -> title; ?></a>
			</h2>
			<?php $i++;?>
			<?php if($i > 2) break;?>
		<?php }?>
			
	</div>
	<?php }?>
	<div class='description' itemprop="articleBody">
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

		?>
		<?php echo preg_replace('/[\r\n]+/', '</p><p>', $description) . '</p>'; ?>
	</div>

	
	                	
	<br />
	
	<!--	SHARE BOTTOM-->

	<!--	TAGS	-->
		<?php include_once 'default_tags.php'; ?>

	<!--	RELATED	-->
	<?php include_once 'default_related.php'; ?>
	<input type="hidden" value="<?php echo $data->id; ?>" name='news_id' id='news_id'  />
			
	<!-- COMMENT	-->
	<?php

	?>
	
</div>

