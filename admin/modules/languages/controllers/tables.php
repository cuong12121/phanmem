<?php
	// models 
	include 'modules/'.$module.'/models/tables.php';
	
	class LanguagesControllersTables
	{
		var $module;
		var $gid;
		function __construct()
		{
			global $module;
			$this->module = 'languages' ; 
		}
		function display()
		{
			// call models
			$model = new LanguagesModelsTables();
			
			$list = $model->getTables();
			$language_not_default = $model->get_languages();
			// call views
			
			include 'modules/'.$this->module.'/views/tables/list.php';
		}
		
		function synchronize(){
			$model = new LanguagesModelsTables();
			$rs = $model -> synchronize();
			if($rs){
				setRedirect('index.php?module=languages&view=tables','&#272;&#227; &#273;&#7891;ng b&#7897; th&#224;nh c&#244;ng');
			} else {
				setRedirect('index.php?module=languages&view=tables','Ch&#432;a &#273;&#7891;ng b&#7897; th&#224;nh c&#244;ng');
			}
		}
		/*
		 * Copy data
		 * Only for language default
		 * copy from fs_data to fs_data_lang
		 */
		function copy(){
			$model = new LanguagesModelsTables();
			$rs = $model -> copy();
			if($rs){
				setRedirect('index.php?module=languages&view=tables','Sao ch&#233;p th&#224;nh c&#244;ng');
			} else {
				setRedirect('index.php?module=languages&view=tables','Sao ch&#233;p kh&#244;ng th&#224;nh c&#244;ng');
			}
		}
	}
?>