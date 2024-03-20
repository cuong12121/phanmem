<?php
/*
 * Huy write
 */
	// controller
	
	class SitemapControllersSitemap extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			$model = $this -> model;
			$cats_products = $model->get_records('published = 1 AND level = 0','fs_products_categories','id,alias,updated_time');
			header("Content-Type: application/xml; charset=utf-8");
			$xml = '<?xml version="1.0" encoding="UTF-8"?>';
			$xml .= '
			<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
			foreach ($cats_products as $item) {
				$link = URL_ROOT.'sitemap-'.$item->alias.'-spc'.$item->id.'.xml';
				$xml .='
				<sitemap>
					<loc>'.$link.'</loc>
					<lastmod>'.date('Y-m-d').'</lastmod>
				</sitemap>';
			}

			$xml .='
				<sitemap>
					<loc>'.URL_ROOT.'sitemap_news.xml</loc>
					<lastmod>'.date('Y-m-d').'</lastmod>
				</sitemap>';

			$xml .='
				<sitemap>
					<loc>'.URL_ROOT.'sitemap_news_cat.xml</loc>
					<lastmod>'.date('Y-m-d').'</lastmod>
				</sitemap>';

			$xml .='
				<sitemap>
					<loc>'.URL_ROOT.'sitemap_contents.xml</loc>
					<lastmod>'.date('Y-m-d').'</lastmod>
				</sitemap>';

			$xml .='
				<sitemap>
					<loc>'.URL_ROOT.'sitemap_product_cat.xml</loc>
					<lastmod>'.date('Y-m-d').'</lastmod>
				</sitemap>';

			$xml .='
				<sitemap>
					<loc>'.URL_ROOT.'sitemap_video_cat.xml</loc>
					<lastmod>'.date('Y-m-d').'</lastmod>
				</sitemap>';

			$xml .='
				<sitemap>
					<loc>'.URL_ROOT.'sitemap_video.xml</loc>
					<lastmod>'.date('Y-m-d').'</lastmod>
				</sitemap>';

			$xml .= '
			</sitemapindex>';
			echo $xml;

		}
		function show_products(){
			$model = $this -> model; 
			$list = $model -> get_products ();
			
			$xml = '';
			header("Content-Type: application/xml; charset=utf-8");
			?>
				
				<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
			
			<?php
			foreach($list as $item){
				$link = FSRoute::_('index.php?module=products&view=product&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);

				if(!empty($item->image)){
					$xml .= '
                        <url>
                          	<loc>'.$link.'</loc>
                          	<changefreq>daily</changefreq>
							<priority>0.9</priority>
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
							<priority>0.9</priority>
                        </url>  
                    ';
				}
				
			}

			$xml .= '
                        </urlset>  
                    ';
			echo $xml;
		}
		
		function show_products_cat(){
			$model = $this -> model; 
			$list = $model -> get_products_cat ();
			$xml = '';
			foreach($list as $item){
				$link = FSRoute::_('index.php?module=products&view=cat&ccode='.$item -> alias.'&cid='.$item->id);
				$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                        </url>  
                    ';
			}
			return $xml;
		}

		function show_news(){
			$model = $this -> model; 
			$list = $model -> get_news ();
			$xml = '';
			foreach($list as $item){
				$link = FSRoute::_('index.php?module=news&view=news&code='.$item -> alias.'&ccode='.$item->category_alias.'&id='.$item->id);
				$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                        </url>  
                    ';
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
				$xml .= '
                      <url>
                          <loc>'.$link.'</loc>
                        </url>  
                    ';
			}
			return $xml;
		}
	}
	
?>