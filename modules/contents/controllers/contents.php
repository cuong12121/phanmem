<?php
/*
 * Huy write
 */
	// controller

class ContentsControllersContents extends FSControllers
{
	var $module;
	var $view;
	
	function display()
	{
			// call models
		$model = new ContentsModelsContents();

		$data = $model->getContents();
		if(!$data)
			setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound' ), FSText::_('Link này không tồn tại') );
		global $tmpl,$module_config;
		$tmpl -> set_data_seo($data);

		$amp = FSInput::get ( 'amp', 0, 'int' );


		$ccode = FSInput::get('ccode');
		$category_id = $data -> category_id;
		$category = $model -> get_category_by_id($category_id);
		if(!$category)
			setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound' ), FSText::_('Link này không tồn tại') );
		$Itemid = 7;
		if($ccode){
			if(trim($ccode) != trim($category-> alias )){
				$link_contents = FSRoute::_("index.php?module=contents&view=contents&code=".trim($data->alias)."&ccode=".trim($category-> alias)."&Itemid=$Itemid");
				setRedirect($link_contents);
			}
		}
		$relate_contents_list = $model->getRelateContentList($category_id);
			//$relate_contents_list = $model->get_relate_by_tags($data -> tags,$data -> id);
		$total_content_relate  = count($relate_contents_list);
		$str_ids = '';
		for($i = 0; $i < $total_content_relate; $i ++){
			$item = $relate_contents_list[$i];
			if($i > 0) $str_ids .= ',';
			$str_ids .= $item -> category_id;
		}
		$content_category_alias = $model->get_content_category_ids($str_ids);
		$breadcrumbs = array();
			//$breadcrumbs[] = array(0=>$category -> name, 1 => FSRoute::_('index.php?module=contents&view=cat&id='.$data -> category_id.'&ccode='.$data -> category_alias));	
		$breadcrumbs[] = array(0=>$category ->name, 1 => '');
			// $breadcrumbs[] = array(0=>$data->title, 1 => '');	
		global $tmpl;	
		$tmpl -> assign('breadcrumbs', $breadcrumbs);

		if(!empty($data->schema)){
			$tmpl->addHeader($data->schema);
		}

			// seo
		$tmpl -> set_data_seo($data);
		$this->set_header ( $data );
			// call views			
		include 'modules/' . $this->module . '/views/' . $this->view.($amp?'_amp':'') . '/default.php';
	}

		/*
		 * Tạo ra các tham số header ( cho fb)
		 */
		function set_header($data, $image_first = '') {
			global $config;
			FSFactory::include_class('fsstring');
			$link = FSRoute::_ ( "index.php?module=contents&view=contents&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias );
			$str = '<meta property="og:title"  content="' . htmlspecialchars ( $data->title ) . '" />
			<meta property="og:type"   content="website" />
			';
			$image = URL_ROOT . str_replace ( '/original/', '/large/', $data->image );

			$str_content = htmlspecialchars(FSString::getWord(300,$data -> content));


			$str .= '<meta property="og:image"  content="' . $image . '" />
			<meta property="og:image:width" content="600 "/>
			<meta property="og:image:height" content="315"/>
			<meta property="og:image:alt" content="'.htmlspecialchars ( $data->title ).'" />
			';


			$amp = FSInput::get('amp',0,'int');
			$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'vi';
			if(!$amp && $lang == 'vi'){
				$str .= '<link rel="amphtml" href="'.str_replace('.html','.amp',$link).'">';
			}
			$str .= '<meta property="og:description"  content="' . htmlspecialchars ( $data->summary ) . '" />';

			$str .= '

			<script type="application/ld+json">
			{
				"@graph": [{
					"@context": "http://schema.org",
					"@type": "NewsArticle",
					"mainEntityOfPage": {
						"@type": "WebPage",
						"@id": "'.$link.'"
						},
						"headline": "'.substr($str_content, 0,100).'",
						"image": {
							"@type": "ImageObject",
							"url": "' . $image . '",
							"height": 420,
							"width": 800
							},
							"datePublished": "'.date('d/m/Y',strtotime($data -> created_time)).'",
							"dateModified": "'.date('d/m/Y',strtotime(($data -> updated_time) ? ($data -> updated_time) : ($data -> created_time)  )).'",
							"author": {
								"@type": "Person",
								"name": "'.URL_ROOT.'"
								},
								"publisher": {
									"@type": "Organization",
									"name": "'.URL_ROOT.'",
									"logo": {
										"@type": "ImageObject",
										"url": "'.URL_ROOT.$config['logo'].'",
										"width": 174,
										"height": 50
									}
									},
									"description": "'.substr($str_content, 101,500).'"
									}, {
										"@context": "http://schema.org",
										"@type": "WebSite",
										"name": "'.URL_ROOT.'",
										"url": "'.URL_ROOT.'"
										},
										{
											"@context": "http://schema.org",
											"@type": "Organization",
											"url": "'.URL_ROOT.'",
											"@id": "'.URL_ROOT.'/#organization",
											"name": "'.URL_ROOT.'",
											"logo": "'.URL_ROOT.$config['logo'].'"
										}
										]
									}
									</script>
									';	



									global $tmpl;
									$tmpl->addHeader ( $str );
								}


								/* Save comment */
								function save_comment(){
									$return = FSInput::get('return');
									$url = base64_decode($return);

									if(!$this -> check_captcha()){
										$msg = 'Mã hiển thị không đúng';
										setRedirect($url,$msg,'error');
									}
									$model = new ContentsModelsContents();
									if(!$model -> save_comment()){
										$msg =  'Chưa lưu thành công comment!';
										setRedirect($url,$msg,'error');
									} else {
										setRedirect($url,'Cảm ơn bạn đã gửi comment');
									}

								}
								/* Save comment */
								function save_comment_ajax(){
									if(!$this -> check_captcha()){
										echo 0;
										return;
									}
									$model = new ContentsModelsContents();
									if(!$model -> save_comment()){
										echo 0;
										return;
									} else {
										echo 1;
										return;
									}

								}

		// check captcha
								function ajax_check_captcha(){
									$captcha = FSInput::get('txtCaptcha');
									if ( $captcha == $_SESSION["security_code"]){
										echo 1;
										return;
									} else {
										echo 0;
										return;
									}
								}
		// check captcha
								function check_captcha(){
									$captcha = FSInput::get('txtCaptcha');
									if ( $captcha == $_SESSION["security_code"]){
										return true;
									} 
									return false;
								}

								function rating(){
									$model = new ContentsModelsContents();
									if(!$model -> save_rating()){
										echo '0';
										return;
									} else {
										echo '1';
										return;
									}
								}

		/*
		 * Trả về thẻ h2 (true) hay h3 (false)
		 * @$field_config: trường cần lấy từ module_config
		 * @$value_need_articulation: giá trị cần khớp để trả về đúng h2
		 */

			function amp_add_size_into_img($content){
		preg_match_all('#<img(.*?)>#is',$content,$images);
		$arr_images = array();
		if(!count($images[0]))
			return $content;
		$i = 0;
		foreach($images[0] as $item){			
			
			unset($height);
			preg_match('#height([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]#is',$item,$height);

			if(!isset($height[3])){
				$item_new = str_replace('<img','<img height="400" ', $item);
	// $content = str_replace($item,$item_new, $content);
			}elseif(!$height[3]){
				$item_new = preg_replace('%height([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]%i', 'height="402"', $item);

	// $content = str_replace($item,$item_new, $content);
			}else{
				$item_new = $item;
	// $content = str_replace($item,$item_new, $content);
			}

			unset($width);
			preg_match('#width([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]#is',$item_new,$width);
			if(!isset($width[3])){
				$item_new_2 = str_replace('<img','<img width="600" ', $item_new);
	// $content = str_replace($item_new,$item_new_2, $content);
			}elseif(!$width[3]){
				$item_new_2 = preg_replace('%width([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]%i', 'width="602"', $item_new);
	// $content = str_replace($item_new,$item_new_2, $content);
			}else{
				$item_new_2 = preg_replace('%width([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]%i', 'width="601"', $item_new);
	// $content = str_replace($item_new,$item_new_2, $content);
			}
			if($item != $item_new_2){
				$content = str_replace($item,$item_new_2, $content);
			}


		}
		return $content;	
	}


		function get_tags_seo_from_config($field_config,$value_need_articulation){
			global $module_config;
			$fields_seo_h2 = isset($module_config -> $field_config)?$module_config -> $field_config:'';
			if(!$fields_seo_h2){
				return true;
			}else{
				if(strpos($fields_seo_h2, $value_need_articulation) !== false){
					return true;	
				}else{	
					return false;
				}
			}
		}
	}
	
	?>