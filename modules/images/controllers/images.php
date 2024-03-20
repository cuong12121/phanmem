<?php
/*
 * Huy write
 */
	// controller
	
	class ImagesControllersImages extends FSControllers
	{
		var $module;
		var $view;
		
		function display()
		{
			// call models
			$model = $this -> model;
			$data = $model->get_images();
			if(!$data)
				die('Not found this record!!');
			$cat = $model -> getCategoryById($data -> category_id);
			if(!$cat)
				return;
//			
//			$ccode = FSInput::get('ccode');
//			
//			if($cat -> alias != $ccode){
//				$Itemid = 6;
//				$link = FSRoute::_('index.php?module=projects&view=project&code='.$data -> alias.'&id='.$data->id.'&ccode='.$cat->alias.'&Itemid='.$Itemid);
//				setRedirect($link);
//			}
			
			$getlist_images = $model->getImages($data -> id);
			$relate_images_list = $model->getRelateImagesList($data -> category_id, $data -> id);
			$projects_out_related = $model->getWithoutRelatedImagesList($data -> category_id, $data -> id);
			$total_relative  = count($relate_images_list);
			
//			$types = $model -> get_types();
			// get from table fs_project_incentives
		$comments = $model->get_comments ( $data->id );
		$total_comment = count ( $comments );
		$str_user_ids = '';
		if ($total_comment) {
			$list_parent = array ();
			$list_children = array ();
			foreach($comments as $item){
				if(!$item -> parent_id){
					$list_parent[] = $item;
				}else{
					if(!isset($list_children[$item->parent_id]))
						$list_children[$item->parent_id] = array();
					$list_children[$item->parent_id][] = $item;	
				}
//				if(!$str_user_ids)
//					$str_user_ids .= ',';
//				$str_user_ids .= $item -> user_id;
			}
		}
			$description = $this->insert_link_image($data->description);	

			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>FSText::_('Hình ảnh'), 1 => FSRoute::_('index.php?module=images&view=home&Itemid=98'));
			
		
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
		
			$tmpl -> assign ( 'og_image', URL_ROOT.$data -> image );
			// seo
		$this->set_header ( $data );
			$tmpl -> set_data_seo($data);
			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		/* Save comment */
		function save_comment() {
			$return = FSInput::get ( 'return' );
			$url = base64_decode ( $return );
			
			$model = $this->model;
			if (! $model->save_comment ()) {
			// 	$msg = 'Chưa lưu thành công comment!';
			// 	setRedirect ( $url, $msg, 'error' );
				echo 0;
			} else {
				// setRedirect ( $url, 'Cảm ơn bạn đã gửi comment' );
				echo 1;
			}
		}
		/* Save comment reply*/
		function save_reply() {
			$return = FSInput::get ( 'return' );
			$url = base64_decode ( $return );
			
			$model = $this->model;
			if (! $model->save_comment ()) {
				// $msg = 'Chưa lưu thành công comment!';
				// setRedirect ( $url, $msg, 'error' );
				echo 0;

			} else {
				echo 1;
			}
		}
		function insert_link_image($description){
			$model = $this -> model;
			$description = htmlspecialchars_decode($description);
			preg_match_all("/<img[\s\S]*?(.jpg|.png|.gif)+?[\s\S]*?>/im",$description,$rs);
			if(count($rs[0] )){	
				foreach ( $rs[0] as $item ) {
					preg_match_all('/(alt|title|src)=("[^"]*")/i',$item, $img[$item]);
					$img_alt = $img[$item][2][0];
					$img_src = $img[$item][2][1];
					$description  = str_replace($item,'<a href='.$img_src.' title='.$img_alt.' class="selected cboxElement cb-image-link-desc" rel="image_large" >'.$item.'</a>',$description);
				}			
			}
			 $description;
			return $description;
		}

	/*
		 * Tạo ra các tham số header ( cho fb)
		 */
	function set_header($data, $image_first = '') {
		global $config;
		$link = FSRoute::_ ( "index.php?module=images&view=images&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias );
		$str = '<meta property="og:title"  content="' . htmlspecialchars ( $data->name ) . '" />
					<meta property="og:type"   content="website" />
					';
		$image = URL_ROOT . str_replace ( '/original/', '/large/', $data->image );
		$str .= '<meta property="og:image"  content="' . $image . '" />
				<meta property="og:image:width" content="600 "/>
				<meta property="og:image:height" content="315"/>
			';
	
		$str .= '<meta property="og:description"  content="' . htmlspecialchars ( $data->summary ) . '" />';
		$str .= '
	<script type="application/ld+json">
    {
      "@context": "http://schema.org",
      "@type": "NewsArticle",
      "mainEntityOfPage": "'.$link.'",
      "description": "' . htmlspecialchars ( $data->summary ) . '",
      "headline": "' . htmlspecialchars ( $data->name ) . '",
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
}
?>