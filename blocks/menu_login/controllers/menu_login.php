<?php
/*
 * Huy write
 */
	// models 
	include 'blocks/menu_login/models/menu_login.php';
	
	class Menu_loginBControllersMenu_login
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{
			$group = $parameters->getParams('group');
			$style = $parameters->getParams('style');
			
			$style = $style?$style:'default';
			// call models
			$model = new Menu_loginBModelsMenu_login();
			$list_user = array(
				'Thông tin tài khoản' => FSRoute::_('index.php?module=users&view=users&task=edit&Itemid=45'),
				'Sổ địa chỉ' => FSRoute::_('index.php?module=users&view=users&task=address&Itemid=45'),
				'Lịch sử giao dịch' => FSRoute::_(''),
				'Thông tin bảo hành' => FSRoute::_('index.php?module=warranties&view=warranty&Itemid=494'),
				'Nhận bản tin' => FSRoute::_('index.php?module=estores&view=schedules&Itemid=45'),
                'List sản phẩm yêu thích' => FSRoute::_('')
			);
			include 'blocks/menu_login/views/menu_login/'.$style.'.php';
		}
	}
	
?>