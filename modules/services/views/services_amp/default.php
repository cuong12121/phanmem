<?php  	global $tmpl;
$tmpl -> addStylesheet('services_amp','modules/services/assets/css');
//$tmpl -> addScript('detail','modules/contents/assets/js');
FSFactory::include_class('fsstring');

$print = FSInput::get('print',0);
?>
<div class="content_detail wapper-page wapper-page-detail" itemscope="" itemtype="https://schema.org/Product">


		<h1 class='page_title' itemprop="name">
			<span><?php	echo $data -> title; ?></span>
		</h1>
		<!-- PRICE -->
		<div class='price cls' itemprop="offers" itemscope="" itemtype="https://schema.org/AggregateOffer">

			<link itemprop="availability" href="https://schema.org/InStock">
			<meta itemprop="lowPrice" content="<?php echo $data -> maxPrice; ?>">
			<meta itemprop="highPrice" content="<?php echo $data -> minPrice; ?>">
			<meta itemprop="priceCurrency" content="VND">

		</div>
		

		<!-- PRICE -->

		<div class='description' itemprop="articleBody">
		<?php 
		$description= $data -> content;
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
		

		

		$description = str_replace('border','',$description);
		$description = str_replace('<font','<span',$description);
		$description = str_replace('</font','</span',$description);

		$description = $this -> amp_add_size_into_img($description);
		$description = str_replace('<img','<amp-img  layout="responsive"',$description);
		$description = str_replace('</img','</amp-img',$description);
		
		$description = str_replace('<iframe','<amp-iframe layout="responsive" sandbox="allow-scripts allow-same-origin allow-popups" ',$description);
		$description = str_replace('</iframe','</amp-iframe',$description);
		
		?>
		<?php   echo $description; ?>
	</div>
		




</div>

