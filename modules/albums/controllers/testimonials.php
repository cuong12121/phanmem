<?php
/*
 * Huy write
 */
// controller


class NewsControllersNews extends FSControllers {
	var $module;
	var $view;
	function display() {
		// call models
		$model = $this->model;
		
		$data = $model->getNews ();
		// check xem id co dung ko
		// Ok da hieu :d
		$id = FSInput::get ( 'id', 0, 'int' );
		
		if (! $data) {
			setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound' ), 'Link này không tồn tại' );
		}
		$code = FSInput::get('code');
		$category_id = $data -> category_id;
		$category = $model -> get_category_by_id($category_id);
		if(!$category){
			setRedirect ( FSRoute::_ ( 'index.php?module=notfound&view=notfound' ), 'Danh mục không tồn tại' );
		}
		if ($code != $data->alias || $id != $data->id) {
			$link = FSRoute::_ ( "index.php?module=news&view=news&code=" . trim ( $data->alias ) . "&id=" . $data->id . "&ccode=" . trim ( $data->category_alias ) );
			setRedirect ( $link );
		}
		
		// relate
		$relate_news_list = $model->getRelateNewsList ( $category_id );
		// tin liên quan theo tags
		$relate_news_list_by_tags = $model->get_relate_by_tags ( $data->tags, $data->id, $category_id );
		$total_content_relate = count ( $relate_news_list );
//		$content_category_alias = $model->get_content_category_ids ( $str_ids );
//		// comments
//		$comments = $model->get_comments ( $data->id );
//		$total_comment = count ( $comments );
//		if ($total_comment) {
//			$list_parent = array ();
//			$list_children = array ();
//			foreach ( $comments as $item ) {
//				if (! $item->parent_id) {
//					$list_parent [] = $item;
//				} else {
//					if (! isset ( $list_children [$item->parent_id] ))
//						$list_children [$item->parent_id] = array ();
//					$list_children [$item->parent_id] [] = $item;
//				}
//			}
//		}
		
		// old relate and newest relate
		//			$newer_news_list = $model->getNewerNewsList($category->id,$data->created_time);
		//			$older_news_list = $model->getOlderNewsList($category->id,$data->created_time);
		

		// chèn keyword  vào trong nội dung
		

		$description = $this->insert_link_keyword ( $data->content );
		
		$breadcrumbs = array ();
		$breadcrumbs [] = array (0 => 'Tin tức', 1 => FSRoute::_ ( 'index.php?module=news&view=home&Itemid=2' ) );
		$breadcrumbs [] = array (0 => $category->name, 1 => FSRoute::_ ( 'index.php?module=news&view=cat&id=' . $data->category_id . '&ccode=' . $data->category_alias ) );
		//			$breadcrumbs[] = array(0=>$data->title, 1 => '');	
		global $tmpl, $module_config;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$tmpl->assign ( 'title', $data->title );
		$tmpl->assign ( 'tags_news', $data->tags );
		$tmpl->assign ( 'products_related', $data->products_related );
		$tmpl->assign ( 'news_related', $data->news_related );
//		$tmpl->assign ( 'og_image', URL_ROOT . $data->image );
		// seo
		$this->set_header ( $data );
		$tmpl->set_data_seo ( $data );
		
		// call views			
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
	
	/* Save comment */
	function save_comment() {
		$return = FSInput::get ( 'return' );
		$url = base64_decode ( $return );
		
		if (! $this->check_captcha ()) {
			$msg = 'Mã hiển thị không đúng';
			setRedirect ( $url, $msg, 'error' );
		}
		$model = $this->model;
		if (! $model->save_comment ()) {
			$msg = 'Chưa lưu thành công comment!';
			setRedirect ( $url, $msg, 'error' );
		} else {
			setRedirect ( $url, 'Cảm ơn bạn đã gửi comment' );
		}
	}
	/* Save comment reply*/
	function save_reply() {
		$return = FSInput::get ( 'return' );
		$url = base64_decode ( $return );
		
		$model = $this->model;
		if (! $model->save_comment ()) {
			$msg = 'Chưa lưu thành công comment!';
			setRedirect ( $url, $msg, 'error' );
		} else {
			setRedirect ( $url, 'Cảm ơn bạn đã gửi comment' );
		}
	}
	
	// check captcha
	function check_captcha() {
		$captcha = FSInput::get ( 'txtCaptcha' );
		
		if ($captcha == $_SESSION ["security_code"]) {
			return true;
		} else {
		}
		return false;
	}
	
	function rating() {
		$model = $this->model;
		if (! $model->save_rating ()) {
			echo '0';
			return;
		} else {
			echo '1';
			return;
		}
	}
	function count_views() {
		$model = $this->model;
		if (! $model->count_views ()) {
			echo 'hello';
			return;
		} else {
			echo '1';
			return;
		}
	}
	// update hits
	function update_hits() {
		$model = new NewsModelsNews ();
		$news_id = FSInput::get ( 'id' );
		$id = $model->update_hits ( $news_id );
		if ($id) {
			echo 1;
		} else {
			echo 0;
		}
		return;
	}
	/*
		 * Tạo ra các tham số header ( cho fb)
		 */
	function set_header($data, $image_first = '') {
		$link = FSRoute::_ ( "index.php?module=news&view=news&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias );
		$str = '<meta property="og:title"  content="' . htmlspecialchars ( $data->title ) . '" />
					<meta property="og:type"   content="website" />
					';
		$image = URL_ROOT . str_replace ( '/original/', '/large/', $data->image );
		$str .= '<meta property="og:image"  content="' . $image . '" />
				<meta property="og:image:width" content="600 "/>
				<meta property="og:image:height" content="315"/>
			';
		
		$str .= '<meta property="og:description"  content="' . htmlspecialchars ( $data->summary ) . '" />';
		
		global $tmpl;
		$tmpl->addHeader ( $str );
	}
}

?>