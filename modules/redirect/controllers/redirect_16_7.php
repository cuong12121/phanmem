<?php
/*
 * Huy write
 */
	// controller
	
	function movePage($num,$url){
	 static $http = array (
       100 => "HTTP/1.1 100 Continue",
       101 => "HTTP/1.1 101 Switching Protocols",
       200 => "HTTP/1.1 200 OK",
       201 => "HTTP/1.1 201 Created",
       202 => "HTTP/1.1 202 Accepted",
       203 => "HTTP/1.1 203 Non-Authoritative Information",
       204 => "HTTP/1.1 204 No Content",
       205 => "HTTP/1.1 205 Reset Content",
       206 => "HTTP/1.1 206 Partial Content",
       300 => "HTTP/1.1 300 Multiple Choices",
       301 => "HTTP/1.1 301 Moved Permanently",
       302 => "HTTP/1.1 302 Found",
       303 => "HTTP/1.1 303 See Other",
       304 => "HTTP/1.1 304 Not Modified",
       305 => "HTTP/1.1 305 Use Proxy",
       307 => "HTTP/1.1 307 Temporary Redirect",
       400 => "HTTP/1.1 400 Bad Request",
       401 => "HTTP/1.1 401 Unauthorized",
       402 => "HTTP/1.1 402 Payment Required",
       403 => "HTTP/1.1 403 Forbidden",
       404 => "HTTP/1.1 404 Not Found",
       405 => "HTTP/1.1 405 Method Not Allowed",
       406 => "HTTP/1.1 406 Not Acceptable",
       407 => "HTTP/1.1 407 Proxy Authentication Required",
       408 => "HTTP/1.1 408 Request Time-out",
       409 => "HTTP/1.1 409 Conflict",
       410 => "HTTP/1.1 410 Gone",
       411 => "HTTP/1.1 411 Length Required",
       412 => "HTTP/1.1 412 Precondition Failed",
       413 => "HTTP/1.1 413 Request Entity Too Large",
       414 => "HTTP/1.1 414 Request-URI Too Large",
       415 => "HTTP/1.1 415 Unsupported Media Type",
       416 => "HTTP/1.1 416 Requested range not satisfiable",
       417 => "HTTP/1.1 417 Expectation Failed",
       500 => "HTTP/1.1 500 Internal Server Error",
       501 => "HTTP/1.1 501 Not Implemented",
       502 => "HTTP/1.1 502 Bad Gateway",
       503 => "HTTP/1.1 503 Service Unavailable",
       504 => "HTTP/1.1 504 Gateway Time-out"
   );
   header($http[$num]);
   header ("Location: $url");
}
	
	class RedirectControllersRedirect extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			
			// call models
			$model = $this -> model;
			$type = FSInput::get('type');

			switch ($type){
				case 'redirect_all':
					$alias = FSInput::get('code');
					
					
					if($alias){
						// echo $alias;
						// die;
						if($alias=='tin-tuc-su-kien'){
							$link = URL_ROOT . 'tin-tuc.html';
						}

						$record =$model -> get_record('alias_old = "'.$alias.'"','fs_products_categories','id,alias');

						
						if($record){
							$link = FSRoute::_('index.php?module=products&view=cat&ccode=' .$alias. '&cid='.$record->id.'&Itemid=9');
							setRedirect($link);
						}



						if(!$record){
							
							$record = $model -> get_record('alias_old = "'.$alias.'"','fs_products','id,alias,category_alias');




							if($record){
								$link = FSRoute::_('index.php?module=products&view=product&ccode=' .($record ->category_alias).'&code='.$record->alias.'&id='.$record ->id.'&Itemid=10');
								setRedirect($link);
					
							}
						}

						if(!$record){
							$record = $model -> get_record('alias_old = "'.$alias.'"','fs_news_categories','id,alias');
							if($record){
								$link = FSRoute::_('index.php?module=news&view=cat&ccode=' .$record -> alias. '&id='.$id.'&Itemid=3');
								setRedirect($link);
							}
						}

						if(!$record){
							$record = $model -> get_record('alias_old = "'.$alias.'"','fs_news','id,alias,category_alias');
							if($record){
								$link = FSRoute::_('index.php?module=news&view=news&ccode=' .($record ->category_alias).'&code='.$record-> alias.'&id='.$record->id.'&Itemid=10');
								setRedirect($link);
							}
						}

						if(!$record){

							setRedirect(URL_ROOT);

						}
					}

					break;
				
				case 'lienhe':
					$link = FSRoute::_('index.php?module=department&view=department&Itemid=11');
					setRedirect($link);
					break;
				case 'thamdinhdongho':

					$link = FSRoute::_('index.php?module=thamdinhdongho&Itemid=79');
					setRedirect($link);
					break;

				case 'baohiemloinguoidung':
					$link = FSRoute::_('index.php?module=baohiemloinguoidung&Itemid=80');
					setRedirect('https://baohiem.xwatch.vn/');
					break;

				case 'donghonhatban':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho&cid=754&filter=nhat-ban');
					setRedirect($link);
					break;
					
				case 'donghoco':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho-nam&cid=85&filter=automatic');
					setRedirect($link);
					break;

				case 'donghodaykimloai':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho&cid=754&filter=thep-khong-gi');
					setRedirect($link);
					break;
				case 'donghodayda':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho&cid=754&filter=day-da');
					setRedirect($link);
					break;

				case 'donghoop':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho&cid=754&filter=op-olym-pianus-olympia-star');
					setRedirect($link);
					break;

				case 'donghoolympianus':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho&cid=754&filter=op-olym-pianus-olympia-star');
					setRedirect($link);
					break;

				case 'donghoolympiastar':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho&cid=754&filter=op-olym-pianus-olympia-star');
					setRedirect($link);
					break;
				
				case 'dongho':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho&cid=754&Itemid=9');
					setRedirect($link);
					break;

				case 'donghonam':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho-nam&cid=85&Itemid=9');
					setRedirect($link);
					break;

				case 'donghonu':
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho-nu&cid=86&Itemid=9');
					setRedirect($link);
					break;

				case 'product_filter_manu':
					$alias = FSInput::get('code');
					// echo $alias;
					// die;
					if($alias)
						$record = $model -> get_record('alias_old = "'.$alias.'"','fs_manufactories_redirect','id,alias,alias_old');
						
					if(!$record){
						setRedirect(URL_ROOT);
					}
					// print_r($record);
					// die;
					// index.php?module=products&view=cat&ccode=$1&cid=$2&filter=$4&Itemid=9&sort=$6&%{QUERY_STRING}   [L]

					$link = FSRoute::_('index.php?module=products&view=cat&ccode=dong-ho&cid=754&filter='.$record->alias.'&Itemid=9');
					setRedirect($link);
					break;

				case 'product_cat_page':
					$alias = FSInput::get('code');
					$page = FSInput::get('page');
					$link = URL_ROOT.'dong-ho-pc754/'.$alias . '-page'.$page.'.html';
					setRedirect($link);
					break;

				case 'product_cat_page_nu':
					$page = FSInput::get('page');
					$link = URL_ROOT.'dong-ho-nu-pc86-page'.$page.'.html';
					setRedirect($link);
					break;

				case 'product_cat_page_nam':
					$page = FSInput::get('page');
					$link = URL_ROOT.'dong-ho-nam-pc85-page'.$page.'.html';
					setRedirect($link);
					break;



				case 'product_cat':
					$alias = FSInput::get('code');
					// echo $alias;
					// die;
					if($alias)
						$record = $model -> get_record('alias_old = "'.$alias.'"','fs_products_categories','id,alias');
			
					if(!$record){
						setRedirect(URL_ROOT);
					}
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=' .$alias. '&cid='.$record->id.'&Itemid=9');
					setRedirect($link);
					break;



				case 'product_cat_en':
					$alias = FSInput::get('code');
					// echo $alias;
					// die;
					if($alias)
						$record = $model -> get_record('alias_old = "'.$alias.'"','fs_products_categories_en','id,alias');
			
					if(!$record){
						setRedirect(URL_ROOT);
					}
					$link = FSRoute::_('index.php?module=products&view=cat&ccode=' .$alias. '&cid='.$record->id.'&Itemid=9');
					setRedirect($link);
					break;
				case 'product':
					$alias = FSInput::get('code');
					$alias = str_replace('.html', '', $alias);
					$alias_arr = explode("-", $alias);
					$count = count($alias_arr);
					$id_arr = $count - 1;
					$id_pro = $alias_arr[$id_arr];

					$ccode = FSInput::get('ccode');
					$alias = str_replace('.html', '', $alias);
					$alias_arr = explode("-", $alias);
					$count = count($alias_arr);
					$id_arr = $count - 1;
					$id_pro = $alias_arr[$id_arr];

					


					if($id_pro)
						$record = $model -> get_record('id = "'.$id_pro.'"','fs_products','id,alias,category_alias');
						
					if(!$record){
						$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; 
						$dt = date("h:i:s"); 
						$file=fopen("url_log.txt","a"); 
						$data = $url.' '.$dt."\n"; 
						fwrite($file, $data); 
						fclose($file); 
					
						setRedirect(FSRoute::_('index.php?module=notfound&view=notfound&Itemid=1000'));
					}
				
					$link = FSRoute::_('index.php?module=products&view=product&ccode=' .($record ->category_alias).'&code='.$record->alias.'&id='.$record ->id.'&Itemid=10');
					setRedirect($link);
					break;


				
					if($id_pro)
						$record = $model -> get_record('id = "'.$id_pro.'"','fs_products','id,alias,category_alias');
						
					if(!$record){
						setRedirect(URL_ROOT);
					}
					$link = FSRoute::_('index.php?module=products&view=product&ccode=' .($record ->category_alias).'&code='.$record->alias.'&id='.$record ->id.'&Itemid=10');

					setRedirect($link);
					break;
				case 'product_comment_fb':
					$id = FSInput::get('id');
					// echo $id;
					// die;
					if($id)
						$record = $model -> get_record('id = "'.$id.'"','fs_products','id,alias,category_alias');
					if(!$record){
						setRedirect(URL_ROOT);
					}
					$link = FSRoute::_('index.php?module=products&view=product&ccode=' .($record ->category_alias).'&code='.$record->alias.'&id='.$record ->id.'&Itemid=10');
					setRedirect($link);
					break;

				case 'product_en':
					$alias = FSInput::get('code');
					if($alias)
						$record = $model -> get_record('alias_old = "'.$alias.'"','fs_products_en','id,alias,category_alias');
					if(!$record){
						setRedirect(URL_ROOT);
					}
					$link = FSRoute::_('index.php?module=products&view=product&ccode=' .($record ->category_alias).'&code='.$record->alias.'&id='.$record ->id.'&Itemid=10');
					setRedirect($link);
					break;

				case 'news_home':
					$page = FSInput::get('page');
					if(!$page){
						$link = FSRoute::_('index.php?module=news&view=home&Itemid=10');
						setRedirect($link);
					}else{
						$link = FSRoute::_('index.php?module=news&view=home&Itemid=10');
						$search = preg_match('#-page([0-9]+)#is',$link);
						if($search){
							$link = preg_replace('/-page[0-9]+/i','-page'.$page, $link);
						} else {
							$link = preg_replace('/.html/i','-page'.$page.'.html', $link);
						}
						setRedirect($link);
					}

				case 'news_cat':
					$alias = FSInput::get('code');
					// echo $alias;
					// die;
					if($alias)
						$record = $model -> get_record('alias_old = "'.$alias.'"','fs_news_categories','id,alias');
						// print_r($record);
						// die;
					if(!$record){
						setRedirect(URL_ROOT);
					}
					$link = FSRoute::_('index.php?module=news&view=cat&ccode=' .$record -> alias. '&id='.$id.'&Itemid=3');
					setRedirect($link);
					break;

				case 'news':			
					$alias = FSInput::get('code');
					$alias = str_replace('.html', '', $alias);

					// echo $alias;
					// die;
					if($alias == 'chinh-sach-bao-hanh-ca-loi-nguoi-dung-tai-xwatch'){
						$alias = 'chinh-sach-bao-hiem-ca-loi-nguoi-dung-tai-xwatch';

						// echo $alias;
						// die;
						
					}

					$record = $model -> get_record('alias_old = "'.$alias.'"','fs_news','id,alias,category_alias');

		
						
						// print_r($record);
						// die;
					if(!$record){
						$url = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}"; 
						$dt = date("h:i:s"); 
						$file=fopen("url_log.txt","a"); 
						$data = $url.' '.$dt."\n"; 
						fwrite($file, $data); 
						fclose($file); 
					
						setRedirect(FSRoute::_('index.php?module=notfound&view=notfound&Itemid=1000'));
					}
						
					$link = FSRoute::_('index.php?module=news&view=news&ccode=' .($record ->category_alias).'&code='.$record-> alias.'&id='.$record->id.'&Itemid=10');
					setRedirect($link);
					break;

				case 'advices':					
					$id = FSInput::get('id',0,'int');
					$alias = FSInput::get('alias');
					if($id)
						$record = $model -> get_record_by_id($id,'fs_advices','id,alias,category_alias');
					/*else{					
						$alias = FSInput::get('alias');
						$record = $model -> get_record('alias = "'.$alias.'"','fs_advices','id,alias,category_alias');
					}*/
					if(!$record)
						setRedirect(URL_ROOT);
					
					$link = FSRoute::_('index.php?module=advices&view=advice&ccode=' .($record ->category_alias).'&code='.$record-> alias.'&id='.$record->id.'&Itemid=10');
					setRedirect($link);
					break;
				case 'contact':
						$link = FSRoute::_('index.php?module=contact&Itemid=10');
						setRedirect($link);
				case 'content':
					$alias = FSInput::get('alias');
					$record = $model -> get_record('alias = "'.$alias.'"','fs_contents','id,alias,category_alias');
					if(!$record){
						setRedirect(URL_ROOT);
					}
					$link = FSRoute::_('index.php?module=contents&view=content&ccode=' .($record ->category_alias).'&code='.$record-> alias.'&id='.$id.'&Itemid=10');
					setRedirect($link);
					break;
					
				default:

					return;
				
			}
//			if($type == 'news'){
//				$news = $model -> get_news_by_old_link();
//				if(!$news){
//					setRedirect(URL_ROOT);
//				}
//				$link_news = FSRoute::_("index.php?module=news&view=news&id=".$news->id."&code=".$news->alias."&ccode=".$news -> category_alias);
//				setRedirect($link_news);
//			}else{
//				$cat = $model -> get_cat_by_old_link();
//				if(!$cat){
//					setRedirect(URL_ROOT);
//				}
//				$link_cat = FSRoute::_('index.php?module=news&view=cat&ccode='.$cat->alias.'&id='.$cat -> id.'&Itemid=10');
//				setRedirect($link_cat);
//			}
		}
	}
	
?>