<?php
/*
 * Huy write
 */
// controller


class AqControllersHome extends FSControllers {
	var $module;
	var $view;
	function display() {
		// use cache
		global $page_cache;
		$page_cache = 0;
		
		$model = $this->model;
		
		// cat list
		$list_cats = $model->get_cats ();
		
		// danh sách các câu hỏi phổ biến
		$list_common = $model -> get_data_common();
		
		$array_cats = array ();
		$array_records = array ();
		$i = 0;
		foreach ( @$list_cats as $item ) {
			$records_in_cat = $model->get_records_cat ( $item->id );
			if (count ( $records_in_cat )) {
				$array_cats [] = $item;
				$array_records [$item->id] = $records_in_cat;
				$i ++;
			}
			if ($i > 5)
				break;
		}
		$breadcrumbs = array ();
		$breadcrumbs [] = array (0 => FSText::_('Hỏi đáp'), 1 => FSRoute::_ ( 'index.php?module=aq&view=home&Itemid=101' ) );
		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$tmpl->set_seo_special ();

		$tmpl-> assign ( 'noindex', 1 );
		
		// call views			
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
	function save_ask() {
		$model = $this->model;
		$id = $model->save_ask ();
		if ($id) {
			$link = FSRoute::_ ( "index.php?module=aq&view=home" );
			$msg = "Câu hỏi của bạn đã được gửi đến ban quản trị và chúng tôi sẽ sớm hồi đáp. Xin cảm ơn. ";
		} else {
			$link = FSRoute::_ ( "index.php?module=aq&view=home" );
			$msg = "Xin lỗi bạn không thể gửi được cho BQT";
		}
		setRedirect ( $link, $msg );
		return;
	}
}

?>