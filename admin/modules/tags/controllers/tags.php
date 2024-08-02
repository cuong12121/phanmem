<?php
	class TagsControllersTags extends Controllers
	{
		function __construct()
		{
			$this->view = 'tags' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();

			var_dump(1);

			die;
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function add()
		{
			global $config;
			$model = $this -> model;

			
			// $wrap_id_warehouses = $model->get_wrap_id_warehouses();
			// $warehouses = $model -> get_records('published = 1 AND id IN ('.$wrap_id_warehouses.')','fs_warehouses');
			// $platforms = $model -> get_records('published = 1','fs_platforms');
			// $houses = $model -> get_records('published = 1','fs_house');
			// $users = $model -> get_record('id = ' . $_SESSION['ad_userid'],'fs_users');
			// if($users->group_id == 1 && $users->shop_id){
			// 	$users->shop_id = substr($users->shop_id, 1, -1);
			// 	$shops = $model -> get_records('id IN ('.$users->shop_id.')','fs_shops');
			// }else{
			// 	$shops = $model -> get_records('','fs_shops');
			// }
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function bold()
		{
			$model = $this -> model;
			$rows = $model->bold(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was bold'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when bold record'),'error');	
			}
		}
		function unbold()
		{
			$model = $this -> model;
			$rows = $model->bold(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was unbold'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when unbold record'),'error');	
			}
		}
	}
	
?>