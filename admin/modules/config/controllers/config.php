<?php
	class ConfigControllersConfig  extends Controllers
	{
		function __construct()
		{
			
			parent::__construct(); 
		}

		function display()
		{
			$model  = $this -> model;
			$group = $model->getGroup();
			$data_g = array();

			foreach ($group as $itemg) {
				$data_g[$itemg-> id] = $model->getDataOfGroup($itemg-> id);
			}

			$data_g['other'] = $model->getDataOfGroupOther();

			// print_r($group);
			$data = $model->getData();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

		function save()
		{
			$model  = $this -> model;
		
			// call Models to save
			$cid = $model->save();
			$link = FSRoute::_('index.php?module='.$this -> module.'&view='.$this -> view);
			if($cid)
			{
				setRedirect($link,FSText :: _('Saved'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Not save'),'error');	
			}
			
		}
	

	}
	
?>