<?php
/*
 * Huy write
 */
	// controller

class ServicesControllersServices extends FSControllers
{
	var $module;
	var $view;
	
	function display()
	{
			// call models
		$model = $this -> model;
			// $amp = FSInput::get ( 'amp', 0, 'int' );
		$data = $model->getContents();
		$id = FSInput::get ( 'id', 0, 'int' );
		if(!$data)
			setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound' ), FSText::_('Link này không tồn tại') );
		global $tmpl,$module_config;
		// $tmpl -> set_data_seo($data);


		$code = FSInput::get('code');
		$category_id = $data -> category_id;
		$category = $model -> get_category_by_id($category_id);
		if(!$category)
			setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound' ), FSText::_('Danh mục không tồn tại') );
		$Itemid = 7;

		if ($code != $data->alias || $id != $data->id ) {
			$link = FSRoute::_("index.php?module=services&view=services&code=".trim($data->alias)."&ccode=".trim($category-> alias)."&id=".$data->id."&Itemid=$Itemid");					
			setRedirect($link);
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
		$breadcrumbs[] = array(0=>$category -> name, 1 => FSRoute::_('index.php?module=services&view=cat&cid='.$data -> category_id.'&ccode='.$category -> alias));	
			//$breadcrumbs[] = array(0=>$category ->name, 1 => '');
		$breadcrumbs[] = array(0=>$data->title, 1 => '');	
		global $tmpl;	
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
		$tmpl-> assign ( 'title', $data->title );
			// seo
		$tmpl -> set_data_seo($data);
		$this-> set_header ( $data );
			// call views			
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';

	}


	/* Save comment */
	function save_comment(){
		$return = FSInput::get('return');
		$url = base64_decode($return);

		if(!$this -> check_captcha()){
			$msg = 'Mã hiển thị không đúng';
			setRedirect($url,$msg,'error');
		}
		$model = new ServicesModelsServices();
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
		$model = new ServicesModelsServices();
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
		$model = new ServicesModelsServices();
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

		function set_header($data, $image_first = '') {
			global $config;
			$link = FSRoute::_ ( "index.php?module=news&view=news&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias );
			$str = '<meta property="og:title"  content="' . htmlspecialchars ( $data->title ) . '" />
			<meta property="og:type"   content="website" />
			';
			$image = URL_ROOT . str_replace ( '/original/', '/large/', $data->image );
			$str .= '<meta property="og:image"  content="' . $image . '" />
			<meta property="og:image:width" content="600 "/>
			<meta property="og:image:height" content="315"/>
			';
			$amp = FSInput::get('amp',0,'int');
			if(!$amp){
				$str .= '<link rel="amphtml" href="'.str_replace('.html','.amp',$link).'">';
			}
			$str .= '<meta property="og:description"  content="' . strip_tags (html_entity_decode ( $data->summary )) . '" />';
			$str .= '
			<script type="application/ld+json">
			{
				"@context": "http://schema.org",
				"@type": "NewsArticle",
				"mainEntityOfPage": "'.$link.'",
				"description": "' . strip_tags (html_entity_decode( $data->summary )) . '",
				"headline": "' . strip_tags (html_entity_decode( $data->title ) ). '",
				"image": {
					"@type": "ImageObject",
					"url": "' . $image . '",
					"width": 1200,
					"height": 618      },
					"datePublished": "'.date('d/m/Y',strtotime($data -> created_time)).'",
					"dateModified": "'.date('d/m/Y',strtotime($data -> created_time)).'",
					"publisher": {
						"@type": "Organization",
						"name": "'.URL_ROOT.'",
						"logo": {
							"@type": "ImageObject",
							"url": "'.URL_ROOT.$config['logo'].'",
							"width": 60,
							"height": 60        }
							},
							"author": {
								"@type": "Person",
								"name": "'.URL_ROOT.'"
							}
						}
						</script>';
						
						global $tmpl;
						$tmpl->addHeader ( $str );
					}

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
				}
				
			?>