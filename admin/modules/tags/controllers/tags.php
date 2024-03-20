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
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
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