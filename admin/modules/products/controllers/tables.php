<?php
	// models 
class ProductsControllersTables  extends Controllers
{
	function __construct()
	{
		$this -> type = 'products';
		parent::__construct(); 
	}
	function display()
	{
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;
		
			// call models
		$model = $this -> model;
		$list = $model->get_data();
			// echo "<pre>";
			// print_r($list);
			// die;
		$group_field = $model->get_group_field();
		$foreign_data = $model->get_foreign_data();
		$pagination = $model->getPagination();
			// call views
		
		include 'modules/'.$this->module.'/views/tables/list.php';
	}
	function edit()
	{
		$model = $this -> model;
		$data = $model->getTableFields();
		$group_field = $model->get_group_field();
		$foreign_data = $model->get_foreign_data();
		
			// default field
		$fields_default = $model->get_default_fields_in_extends();
		$str_field_default = 'id, record_id';
		foreach($fields_default as $item)
			$str_field_default .= ', '.$item -> field_name;
		
		include 'modules/'.$this->module.'/views/tables/detail.php';
	}
	
	
//		/*********** FIELD ***************/
	function apply_edit()
	{

		$model = $this -> model;
		$tablename = FSInput::get('table_name');
		$tablename = strtolower($tablename);
		$tablename = $tablename;
	
		$rs = $model->save_edit();

		if($rs)
		{
			$cid = FSInput::get('cid');
			setRedirect("index.php?module=".$this -> module.'&view='.$this -> view."&task=edit&tablename=$rs",FSText::_('Saved'));
		}
		else 
		{
			setRedirect("index.php?module=".$this -> module.'&view='.$this -> view."&task=edit&tablename=$tablename",FSText::_('Error'),'error');
			// setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
		}	
		
	}
	function save_edit()
	{
		$model = $this -> model;
		$rs = $model->save_edit();
		if($rs)
		{
			$cid = FSInput::get('cid');
			setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Saved'));
		}
		else 
		{
			setRedirect("index.php?module=".$this -> module.'&view='.$this -> view."&task=edit&tablename=$tablename",FSText::_('Error'),'error');
			// setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
		}	
	}
	
	function cancel()
	{
		setRedirect("index.php?module=".$this -> module.'&view='.$this -> view);
	}
	
		/*
		 * Create table
		 */
		function apply_new()
		{
			
			$model = $this -> model;
			$rs = $model->table_new();
			$table_name = FSInput::get('table_name');
			$table_name = strtolower($table_name);
			
			if($rs)
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view."&task=edit&tablename=$rs","L&#432;u th&#224;nh c&#244;ng");
			}
			else 
			{

				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
		}
		/*
		 * Create table
		 */
		function save_new()
		{
			

			$model = $this -> model;
			$rs = $model->table_new();
			if($rs)
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,"L&#432;u th&#224;nh c&#244;ng");
			}
			else 
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
		}
		
		function table_add()
		{
			$model = $this -> model;
			$group_field = $model->get_group_field();
			$foreign_data = $model->get_foreign_data();
			// default field
			$fields_default = $model->get_default_fields_in_extends();
			$str_field_default = 'id, record_id';
			foreach($fields_default as $item)
				$str_field_default .= ', '.$item -> field_name;
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
		/*
		 * create Filter
		 */
		function filter()
		{
			$tablename  = FSInput::get('table_name');
			
			if($tablename)
			{
				setRedirect("index.php?module=".$this -> module."&view=filters&tablename=$tablename");
			}
			else
			{
				$this->table_add();
			}
		}
		
	}
	
	?>