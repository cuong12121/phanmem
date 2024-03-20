<?php
/*
 * Huy write
 */
	// controller

class Sitemap_autoControllersSitemap_auto extends FSControllers
{
	var $module;
	var $view;
	function display()
	{
		$type = FSInput::get('type','product','txt');
		header("Content-Type: application/xml; charset=utf-8");
		$header = '<?xml version="1.0" encoding="UTF-8"?>
		';
		echo $header;
		?>
		<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
			
			<?php
			switch ($type) {
				
				case 'product_cat':
				echo $this->show_products_cat();					
				break;
				case 'news':
				echo $this->show_news();					
				break;
				case 'news_cat':
				echo $this->show_news_cat();					
				break;
				case 'contents':
				echo $this->show_contents();					
				break;
				case 'video_cat':
				echo $this->show_video_cat();					
				break;
				case 'video':
				echo $this->show_video();					
				break;

				case 'product':
				default:
				echo $this->show_products();					
				break;				
			}

			?>
		</urlset>
		<?php 
	}
	function show_products(){
		$model = $this -> model; 
		$list = $model -> get_products ();
		$xml = '';
		foreach($list as $item){
			$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
			$xml .= '
			<url>
			<loc>'.$link.'</loc>
			</url>  
			';
		}
		return $xml;
	}

	function show_products_cat(){
		$model = $this -> model; 
		$list = $model -> get_products_cat();

		$xml = '';
		foreach($list as $item){

			$list_manf = $model-> get_records('tablename = "'.$item-> tablename.'" AND field_name = "manufactory"','fs_products_filters','*');
			$link = FSRoute::_('index.php?module=products&view=cat&ccode='.$item -> alias.'&cid='.$item->id);
			$xml .= '
			<url>
			<loc>'.$link.'</loc>
			<changefreq>daily</changefreq>
			<priority>0.9</priority>
			</url>   
			';

			if(!empty($list_manf)) {
				foreach ($list_manf as $manf) {
					$link1 = FSRoute::_('index.php?module=products&view=cat&ccode='.$item -> alias.'&cid='.$item->id.'&manu='.$manf-> alias);
					$xml .= '
					<url>
					<loc>'.$link1.'</loc>
					<changefreq>daily</changefreq>
					<priority>0.9</priority>
					</url>   
					';
				}
			}
		}
		return $xml;
	}

	function show_video_cat(){
		$model = $this -> model; 
		$list = $model -> get_video_cat();
			// printr($list);
		$xml = '';
		foreach($list as $item){
			$link = FSRoute::_('index.php?module=videos&view=cat&ccode='.$item -> alias.'&cid='.$item->id);
			$xml .= '
			<url>
			<loc>'.$link.'</loc>
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
			</url>   
			';
		}
		return $xml;
	}


	function show_video(){
		$model = $this -> model; 
		$list = $model -> get_video();
		$xml = '';
		foreach($list as $item){
			$link = FSRoute::_('index.php?module=videos&view=video&code='.$item -> alias.'&id='.$item->id);
			if(!empty($item->image)){
				$xml .= '
				<url>
				<loc>'.$link.'</loc>
				<changefreq>daily</changefreq>
				<priority>0.8</priority>
				<image:image>
				<image:loc>'.URL_ROOT.$item->image.'</image:loc>
				</image:image>
				</url>  
				';
			}else{
				$xml .= '
				<url>
				<loc>'.$link.'</loc>
				<changefreq>daily</changefreq>
				<priority>0.8</priority>
				</url>  
				';
			}
		}
		return $xml;
	}

	function show_news(){
		$model = $this -> model; 
		$list = $model -> get_news ();
		$xml = '';
		foreach($list as $item){
			$link = FSRoute::_('index.php?module=news&view=news&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);

			if(!empty($item->image)){
				$xml .= '
				<url>
				<loc>'.$link.'</loc>
				<changefreq>daily</changefreq>
				<priority>0.8</priority>
				<image:image>
				<image:loc>'.URL_ROOT.str_replace('images/','upload_images/images/',$item->image).'</image:loc>
				</image:image>
				</url>  
				';
			}else{
				$xml .= '
				<url>
				<loc>'.$link.'</loc>
				<changefreq>daily</changefreq>
				<priority>0.8</priority>
				</url>  
				';
			}

		}
		return $xml;
	}
	function show_news_cat(){
		$model = $this -> model; 
		$list = $model -> get_news_cat ();
		$xml = '';
		foreach($list as $item){
			$link = FSRoute::_('index.php?module=news&view=cat&ccode='.$item -> alias.'&cid='.$item->id);
			$xml .= '
			<url>
			<loc>'.$link.'</loc>
			<changefreq>daily</changefreq>
			<priority>0.8</priority>
			</url>  
			';
		}
		return $xml;
	}


	function show_contents(){
		$model = $this -> model; 
		$list = $model -> get_contents ();
		$xml = '';
		foreach($list as $item){
			$link = FSRoute::_('index.php?module=contents&view=contents&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
			if(!empty($item->image)){
				$xml .= '
				<url>
				<loc>'.$link.'</loc>
				<changefreq>daily</changefreq>
				<priority>0.8</priority>
				<image:image>
				<image:loc>'.URL_ROOT.$item->image.'</image:loc>
				</image:image>
				</url>  
				';
			}else{
				$xml .= '
				<url>
				<loc>'.$link.'</loc>
				<changefreq>daily</changefreq>
				<priority>0.8</priority>
				</url>  
				';
			}
		}
		return $xml;
	}
}

?>