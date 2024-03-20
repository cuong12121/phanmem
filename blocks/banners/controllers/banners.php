<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/banners/models/banners.php';
	
class BannersBControllersBanners {
	function __construct() {
	}
	function display($parameters, $title, $id = null) {
//		die('vvv');
		global $folder_admin,$check_edit;
		$link_admin_banner = $folder_admin.'module=banners&view=banners&task=edit&id=';
		$style = $parameters->getParams ( 'style' );
		$suffix = $parameters->getParams ( 'suffix' );
		$category_id = $parameters->getParams ( 'category_id' );
		$out_id = $parameters->getParams ( 'id' );
		$load_lazy = $parameters->getParams ( 'load_lazy' );
		$style = $style ? $style : 'default';
	
			// call models
			$model = new BannersBModelsBanners();
			$list = $model->getList($category_id);
			if(!$list)
				return;
			// call views
			include 'blocks/banners/views/banners/'.$style.'.php';
		}
	}
	
?>