<?php

class RSS
{
	public function RSS()
	{
	}
	
	

	public function GetFeed()
	{
		return $this->getDetails() . $this->getProducts().$this->getNews().$this->close_rss();
	}
	

	
	private function getDetails2()
	{
		$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
				<rss version="2.0">
					<channel>

           <title>Tin tuc</title>
			<link>'."http://localhost/svn/designs/SourceCode/index.php?module=news/view=news/id=2/Itemid=9".'</link>
           <description>Natural Vibrations.</description>
           <language>en-us</language>
           <pubDate>Tue, 10 Jun 2003 04:00:00 GMT</pubDate>
           <lastBuildDate>Tue, 10 Jun 2003 09:41:01 GMT</lastBuildDate>
           <docs>http://blogs.law.harvard.edu/tech/rss</docs>
           <generator>Weblog Editor 2.0</generator>
           <managingEditor>editor@example.com</managingEditor>
           <webMaster>webmaster@example.com</webMaster>';
		return $details;
	}
	
	private function getDetails()
	{
		$details = '<?xml version="1.0" encoding="ISO-8859-1" ?>
				<rss version="2.0">
					<channel>
						<title>'. 'Msmobile'.'</title>
						<link>'. URL_ROOT.'</link>
						<description>'.'Msmobile'.'</description>
						<language>'. 'vi' .'</language>
						<image>
							<title>'. URL_ROOT .'</title>
							<url>'. URL_ROOT.'images/config/logo.png' .'</url>
							<link>'. URL_ROOT .'</link>
							<width>'. 245 .'</width>
							<height>'. 96 .'</height>
						</image>';
		return $details;
	}
	
	private function getProducts()
	{
		global $db;
		
		$query = "SELECT *
				FROM fs_products
				WHERE published = 1
				ORDER BY ID DESC
				LIMIT 0,4000
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_("index.php?module=products&view=product&id=".$row->id."&code=".$row->alias."&ccode=".$row-> category_alias);
			$image_small = URL_ROOT.str_replace('/original/', '/resized/', $row->image);
			$xml .= '<item>
						 <title>'. $row->name .'</title>
						 <link>'. $link.'</link>
						 <description><![CDATA['.'<a href = "'.$link.'" >
						<a href="'. $link.'" title="'.$row->name.'" width="126" height="197">
							<img alt="'.$row->name.'" src="'.$image_small.'" width="126" height="197"/>
						</a>' 
						.']]></description>
						 <pubDate>'.date('d/m/Y H:i',strtotime($row->created_time)).'</pubDate>
					 </item>';
		}
		
		return $xml;
	}
	private function getNews()
	{
		global $db;
		
		$query = "SELECT *
				FROM fs_news
				WHERE published = 1
				ORDER BY ID DESC
				LIMIT 0,6
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_("index.php?module=news&view=news&id=".$row->id."&code=".$row->alias."&ccode=".$row-> category_alias);
			$image_small = URL_ROOT.str_replace('/original/', '/resized/', $row->image);
			$xml .= '<item>
						 <title>'. $row->title .'</title>
						 <link>'. $link.'</link>
						 <description><![CDATA['.'<a href = "'.$link.'" >
						<a href="'. $link.'" title="'.$row->title.'" width="126" height="197">
							<img alt="'.$row->title.'" src="'.$image_small.'" width="126" height="197"/>
						</a>' 
						.']]></description>
						 <pubDate>'.date('d/m/Y H:i',strtotime($row->created_time)).'</pubDate>
					 </item>';
		}
		
		return $xml;
	}
	
	function close_rss(){
		$xml = '</channel>
				 </rss>';
		return $xml;
	}


	public function getFeedInstantArticles()
	{
		return $this->getHeadInstantArticles() .$this->getNewsInstantArticles().$this->closeInstantArticles();
	}

	private function getHeadInstantArticles()
	{
		$details = '<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/">
  				<channel>
					<title>Msmobile - Instant Articles</title>
					<link>'. URL_ROOT.'</link>
					<description>Msmobile - Instant Articles</description>
					<language>vn-vi</language>
				    
				    <lastBuildDate>'.date('Y-m-d H:i:s').'</lastBuildDate>
					';
					
		return $details;
	}
	private function getNewsInstantArticles()
	{
		global $db;
		
		$query = "SELECT *
				FROM fs_news
				WHERE published = 1
				ORDER BY ID DESC
				LIMIT 0,40
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_("index.php?module=news&view=news&id=".$row->id."&code=".$row->alias."&ccode=".$row-> category_alias);
			$image_small = URL_ROOT.str_replace('/original/', '/large/', $row->image);

			$description = $row->content;
			if(strpos($description, 'iframe') !== false)
					continue;
			$description = str_replace('src="/upload_images', 'src="'.URL_ROOT.'upload_images', $description);
			$description = str_replace('<h3', '<h2', $description);
			$description = str_replace('</h3>', '</h2>', $description);
			$description = str_replace('<h4', '<h2', $description);
			$description = str_replace('</h4>', '</h2>', $description);
			
			

			$xml .= '<item>
						<title>'. htmlspecialchars(str_replace('&', '', $row->title)) .'</title>
						<link>'. $link.'</link>						
						<pubDate>'.date('Y-m-d H:i:s',strtotime($row->created_time)).'</pubDate>
						<modDate>'.date('Y-m-d H:i:s',strtotime($row->created_time)).'</modDate>
						<author>Msmobile</author>
						<description><![CDATA['.$row->summary .']]></description>
						<content:encoded>				

							<![CDATA[<!doctype html><html lang="en" prefix="op: http://media.facebook.com/op#">
								<head>
									<link rel="canonical" href="'. $link.'"/>
									<meta charset="utf-8"/>
									<meta property="op:generator" content="facebook-instant-articles-sdk-php"/>
									<meta property="op:generator:version" content="1.5.7"/>
									<meta property="op:generator:application" content="facebook-instant-articles-delectech"/>
									<meta property="op:generator:application:version" content="3.3.5"/>
									<meta property="op:generator:transformer" content="facebook-instant-articles-sdk-php"/>
									<meta property="op:generator:transformer:version" content="1.5.7"/>
									<meta property="op:markup_version" content="v1.0"/>
									<meta property="fb:article_style" content="default"/>
								</head>
								<body>
									<article>
										<header>
											<figure>
												<img src="'.$image_small .'" alt="'. htmlspecialchars($row->title) .'"/>
												<figcaption>'. $row->title .'</figcaption>

											</figure>
											<h1>'. htmlspecialchars($row->title) .'</h1>
											<time class="op-published" datetime="'.date('Y-m-d H:i:s',strtotime($row->created_time)).'">'.date('Y-m-d H:i:s',strtotime($row->created_time)).'</time>
											<time class="op-modified" datetime="'.date('Y-m-d H:i:s',strtotime($row->created_time)).'">'.date('Y-m-d H:i:s',strtotime($row->created_time)).'</time>
																									
										</header>
										<h2>
										'.$row -> summary.'
										</h2>
										'.$description .'

									</article>
								</body>
							</html>]]>
						</content:encoded>
						
					</item>
			';

		
		}
		
		return $xml;
	}

	function closeInstantArticles(){
		$xml = '
							</channel>
				</rss>';
		return $xml;
	}





								
	public function getFeedRemarketing()
	{
		return $this->getHeadRemarketing() .$this->getProductsRemarketing().$this->closeRemarketing();
	}

	private function getHeadRemarketing()
	{
		$details = '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
	<channel>
		<title>MSMobile</title>
		<link>https://msmobile.com.vn/</link>
		<description>Msmobile Feed</description>
					';
					
		return $details;
	}
	private function getProductsRemarketing()
	{
		global $db;
		
		$query = "SELECT *
				FROM fs_products
				WHERE published = 1
				ORDER BY ID DESC
				LIMIT 0,4000
				";
		$db->query($query);
		$result = $db->getObjectList();
		$xml = '';
		for($i = 0; $i < count($result); $i ++ ){
			$row = $result[$i];
			$link = FSRoute::_("index.php?module=products&view=product&id=".$row->id."&code=".$row->alias."&ccode=".$row-> category_alias);
			$image_small = URL_ROOT.str_replace('/original/', '/large/', $row->image);
		
			

			$xml .= '<item>
							<g:id>'. $row -> id.'</g:id>
							<g:title>'. htmlspecialchars(str_replace('&', '', $row->name)) .'</g:title>
							<g:description/>
							<g:link>'. $link.'</g:link>
							<g:image_link>'.$image_small.'</g:image_link>
							<g:availability>in stock</g:availability>
							<g:price>'.$row-> price.'</g:price>
							<g:sale_price>'.$row-> price.'</g:sale_price>
							<g:product_type>'.$row -> category_name.' > '. $row -> manufactory_name.'</g:product_type>
						</item>';	
		
		}
		
		return $xml;
	}

	function closeRemarketing(){
		$xml = '
							</channel>
				</rss>';
		return $xml;
	}




}

?>