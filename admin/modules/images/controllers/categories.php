<?php
	class ImagesControllersCategories extends ControllersCategories{

	function home()
	{
		$model = $this -> model;
		$rows = $model->home(1);
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		$page = FSInput::get('page',0);
		if($page > 1)
			$link .= '&page='.$page;
		if($rows)
		{
			setRedirect($link,$rows.' '.FSText :: _('record was home'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Error when home record'),'error');	
		}
	}
	function unhome()
	{
		$model = $this -> model;
		$rows = $model->home(0);
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
		$page = FSInput::get('page',0);
		if($page > 1)
			$link .= '&page='.$page;
		if($rows)
		{
			setRedirect($link,$rows.' '.FSText :: _('record was unhome'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Error when unhome record'),'error');	
		}
	}
	}

	
?>