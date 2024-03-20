<?php
	// models 
	// include 'modules/'.$module.'/models/groups.php';
	
	class UsersControllersGroups extends Controllers
	{
		var $module;
		function __construct()
		{
		$this->view = 'warehouses' ; 
		parent::__construct(); 
		}
		function display()
		{
			$sort_field  = FSInput::get('sort_field');
			$sort_direct = FSInput::get('sort_direct');
			$sort_direct = $sort_direct?$sort_direct:'asc';
			
			if(@$sort_field)
			{
				$_SESSION['usersgroup_sort_field']  =  $sort_field  ;
				$_SESSION['usersgroup_sort_direct']  = $sort_direct ;
			}
			
			// call models
			$model = new UsersModelsGroups();
			$list = $model->getUserGroups();
			$pagination = $model->getPagination();
			
			// call views
			
			include 'modules/'.$this->module.'/views/groups/list.php';
		}
		
		function add()
		{
			$model = new UsersModelsGroups();
			$permissions = $model->getModulePermission();
			
			include 'modules/'.$this->module.'/views/groups/detail.php';
		}
		function edit()
		{
			$model = new UsersModelsGroups();
			$data = $model->getUserGroupById();
			$permissions = $model->getModulePermission();
			
			include 'modules/'.$this->module.'/views/groups/detail.php';
		}
		function remove()
		{
			$cids = FSInput::get('cid',array(),'array');
			$remove_admin = 0;
			foreach ($cids as $cid)
			{				
				if( $cid == 1)
				{
					$remove_admin = 1; 
					break;
				}
			}
			
			$msg_alert = "";
			if($remove_admin == 1)
				$msg_alert = FSText ::  _ ("Can not remove SuperAdmin group");
			
			$model = new UsersModelsGroups();
			
			
			$rows = $model->remove();
			if($rows)
			{
				setRedirect('index.php?module=users&view=groups',$rows.' '.FSText :: _('record was deleted').".".$msg_alert);	
			}
			else
			{
				setRedirect('index.php?module=users&view=groups',FSText :: _('Not delete'),'error');	
			}
		}
		function published()
		{
			$model = new UsersModelsGroups();
			$rows = $model->published(1);
			if($rows)
			{
				setRedirect('index.php?module=users&view=groups',$rows.' '.FSText :: _('record was published'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=groups',FSText :: _('Error when published record'),'error');	
			}
		}
		function unpublished()
		{
			$model = new UsersModelsGroups();
			$rows = $model->published(0);
			if($rows)
			{
				setRedirect('index.php?module=users&view=groups',$rows.' '.FSText :: _('record was unpublished'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=groups',FSText :: _('Error when unpublished record'),'error');	
			}
		}
		function save()
		{
			$model = new UsersModelsGroups();
			$cid = $model->save();
			
			if($cid)
			{
				setRedirect('index.php?module=users&view=groups',FSText :: _('Saved'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=groups',FSText :: _('Not save'),'error');	
			}
			
		}
		function apply()
		{
			$model = new UsersModelsGroups();
			$cid = $model->save();
			
			if($cid)
			{
				setRedirect("index.php?module=users&view=groups&task=edit&cid=$cid",FSText :: _('Saved'));	
			}
			else
			{
				setRedirect('index.php?module=users&view=groups',FSText :: _('Not save'),'error');	
			}
			
		}
		
		function cancel()
		{
			setRedirect('index.php?module=users&view=groups');	
		}
	}
	
?>