<?php
class HomeControllersHome extends Controllers{
    public function __construc(){
        $this->view = 'home';
        parent::__construct();
    }
    public function display(){
        parent::display();
        $model  = $this -> model;
        // setRedirect('/'.LINK_AMIN.'/index.php?module=order&view=order');
        $list = $model->get_menu_modules();
        $site_name = $model->get_site_name();

    
		require('modules/'.$this->module.'/views/'.$this->view.'.php');
    }
}