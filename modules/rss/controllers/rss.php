<?php
/*
 * Huy write
 */
// controller


class RssControllersRss extends FSControllers {
	var $module;
	var $view;
	function display() {
		$uri = $_SERVER['REQUEST_URI'];		
		preg_match('#\/(.*?)\.rss#is',$uri,$u);
		if(isset($u[0])){
			$u = $u[0];				
		}else{
			$u  = $uri;
		}		
		$key = md5($u);
		
		$fsCache = FSFactory::getClass('FSCache');
		$cache_time = 600;
		$content_cache = $fsCache -> get($key,'modules/rss/detail',$cache_time);
		if($content_cache){
			echo $content_cache;
		} else {
			ob_start();
			$model = $this -> model;
			$model = $this->model;
			$cat = $model -> get_category();
			echo $this->generate_header ($cat);
			echo $this->genarate_rss ($cat);
			$content_page = ob_get_contents();
			ob_end_clean();
			$fsCache -> put($key, $content_page,'modules/rss/detail');
			echo 	$content_page;
		}
		include 'modules/rss/views/rss/default.php';

		//			header("Content-Type: application/xml;  charset=utf-8");
		//			$header = '<?xml version="1.0" encoding="UTF-8"? >';
		
		
	}
	
	private function generate_header($cat) {
		header ( "Content-Type: application/xml;  charset=utf-8" );
		$model = $this->model;
		$site_name = $model->get_config ( 'site_name' );
		if($cat && $cat -> name){
			$site_name = $cat -> name.' - '.$site_name;
		}
		$details = '<?xml version="1.0" encoding="utf-8" ?>

		<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
		<channel>
		<atom:link href="' . URL_ROOT . 'rss.xml" rel="self" type="application/rss+xml" />
		<title>' . $site_name . '</title>
		<link>' . URL_ROOT . '</link>
		<description>' . $site_name . '</description>
		<language>' . 'vi' . '</language>
		<content type="html">{{ article.templateContent | htmlToAbsoluteUrls(absoluteArticleUrl) | utf8_xml }}</content>
		<image>
		<title>' . $site_name . '</title>
		<url>' . URL_ROOT . '/images/config/logo42_1556877970_1558501237_1560389234.png' . '</url>
		<link>' . URL_ROOT . '</link>
		<width>' . 180 . '</width>
		<height>' . 42 . '</height>
		</image>';
		return $details;
	}
	
	private function genarate_rss($cat) {
		$model = $this->model;
		$site = isset ( $_GET ['site'] ) ? $_GET ['site'] : '';
		if ($site) {
			$result = $model->get_list_by_site ( $site );
			$xml = $this->genarate_rss_site ( $result );
			return $xml;
			die();
		} else {
			$cat_id = isset($cat -> id)?$cat -> id: null;
			$list = $model->get_news ($cat_id );
			$tool = isset ( $_GET ['tool'] ) ? $_GET ['tool'] : 0;
			if (! $tool) {
				$xml = $this->genarate_rss_normal ( $list );
			} elseif ($tool == 1) { // tool
				$xml = $this->genarate_rss_has_tool ( $list );
			} else { // RSS TAKATAK
				$xml = $this->genarate_rss_tatakaka ( $list );
			}
			return $xml;
		}
	}
	
	/*
	 * RSS TOOL
	 */
	function genarate_rss_has_tool($result) {
		$xml = '';
		for($i = 0; $i < count ( $result ); $i ++) {
			$row = $result [$i];
			$link = FSRoute::_ ( 'index.php?module=news&view=news&id=' . $row->id . '&code=' . $row->alias . '&ccode=' . $row->category_alias . '&Itemid=9' );
			$image_small = str_replace ( '/original/', '/large/', $row->image );
			$xml .= '
			<item>
			<title>' . str_replace ( '&', '-', $row->title ) . '</title>
			<link>' . $link . '</link>
			<guid isPermaLink="false"><![CDATA[ ' . $link . ' ]]></guid>
			<description>' . $row->summary.'<br>'.$this -> utf8_for_xml($row-> content) . '</description>
			<pubDate>' . date ( 'Y-m-d H:i:s', strtotime ( $row->published_time ) ) . '</pubDate>						 
			<image>
			' . URL_ROOT . $image_small . '
			</image>
			</item>';
		}
		$xml .= '
		</channel>
		</rss>';
		return $xml;
	}
	/*
	 * RSS FOR TATAKAKA
	 */
	function genarate_rss_tatakaka($result) {
		$xml = '';
		for($i = 0; $i < count ( $result ); $i ++) {
			$row = $result [$i];
			$link = FSRoute::_ ( 'index.php?module=news&view=news&id=' . $row->id . '&code=' . $row->alias . '&ccode=' . $row->category_alias . '&Itemid=9' );
			$image_small = str_replace ( '/original/', '/large/', $row->image );
			$xml .= '
			<item>
			<title>' . str_replace ( '&', '-', $row->title ) . '</title>
			<link>' . $link . '</link>
			<guid isPermaLink="false"><![CDATA[ ' . $link . ' ]]></guid>
			<description><![CDATA[
			<a href="' . $link . '" title="' . htmlspecialchars ( $row->title ) . '" width="126">
			<img alt="' . htmlspecialchars ( $row->title ) . '" src="' . URL_ROOT . $image_small . '" width="126" />
			</a>' . '<div>' . $row->summary.'<br>'.$this -> utf8_for_xml($row-> content) . '
			</div>' . ']]></description>
			<pubDate>' . date ( 'Y-m-d H:i:s', strtotime ( $row->published_time ) ) . '</pubDate>						 
			<image>
			' . URL_ROOT . $image_small . '
			</image>
			</item>';
		}
		$xml .= '
		</channel>
		</rss>';
		return $xml;
	}
	/*
	 * RSS FOR normal
	 */
	function genarate_rss_normal($result) {
		$xml = '';
		for($i = 0; $i < count ( $result ); $i ++) {
			$row = $result [$i];
			$link = FSRoute::_ ( 'index.php?module=news&view=news&id=' . $row->id . '&code=' . $row->alias . '&ccode=' . $row->category_alias . '&Itemid=9' );
			$image_small = str_replace ( '/original/', '/small/', $row->image );
			$xml .= '<item>
			<title>' . str_replace ( '&', '-', $row->title ) . '</title>
			<link>' . $link . '</link>
			<guid isPermaLink="false"><![CDATA[ ' . $link . ' ]]></guid>
			<description><![CDATA[
			<a href="' . $link . '" title="' . htmlspecialchars ( $row->title ) . '" width="126">
			<img alt="' . htmlspecialchars ( $row->title ) . '" src="' . URL_ROOT . $image_small . '" width="126" />
			</a>' . '<div>' . $row->summary.'<br>'.$this -> utf8_for_xml($row-> content) . '
			</div>' . ']]></description>
			<pubDate>' . date ( 'r', strtotime ( $row->published_time ) ) . '</pubDate>						 
			</item>';
		}
		$xml .= '
		</channel>
		</rss>';
		return $xml;
	}
	/*
	 * RSS FOR normal
	 * Theo từng site
	 */
	function genarate_rss_site($result) {
		$xml = '';
		for($i = 0; $i < count ( $result ); $i ++) {
			$row = $result [$i];
			$link = FSRoute::_ ( 'index.php?module=news&view=news&id=' . $row->id . '&code=' . $row->alias . '&ccode=' . $row->category_alias . '&Itemid=9' );
			$image_small = str_replace ( '/original/', '/large/', $row->image );
			$xml .= '
			<item>
			<title>' . str_replace ( '&', '-', $row->title ) . '</title>
			<link>' . $link . '</link>
			<guid isPermaLink="false"><![CDATA[ ' . $link . ' ]]></guid>
			<description>' . $row->summary.'<br>'.$this -> utf8_for_xml($row-> content) . '</description>
			<pubDate>' . date ( 'Y-m-d H:i:s', strtotime ( $row->published_time ) ) . '</pubDate>						 
			<image>
			' . URL_ROOT . $image_small . '
			</image>
			</item>';
		}
		$xml .= '
		</channel>
		</rss>';
		return $xml;
	}

	function utf8_for_xml($string)
	{
		$string = str_replace("/upload_images/images/",URL_ROOT."/upload_images/images/",$string);
		return preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+$/u', ' ', $string);
	}
}

?>