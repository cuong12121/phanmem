<?php 
class HomeModelsHome extends FSModels{
    public function __construct(){
        parent::__construct();
    }
    /**
     * Lay tat ca cac menu noi bat
     * 
     * @return Object $list
     */ 
    public function get_menu_modules(){
        global $db;
		$sql = $db->query(' SELECT id, name, image, link  
                            FROM fs_menus_admin 
                            WHERE published = 1 AND featured = 1
                            ORDER BY ordering');
		$list = $db->getObjectList();
        return $list;
    }
    /**
     * Lay ten website
     * 
     * @return String
     */ 
    public function get_site_name(){
        global $db;
		$sql = $db->query(' SELECT name, title, value  
                            FROM fs_config 
                            WHERE id = 1 
                            LIMIT 1');
		$site = $db->getObject();
        if($site)
            return $site->value;
        else
            return '';
    }

    function get_category_sales() {
        $today_time = date('Y-m-d H:i:s');
        $where = "published = 1 AND type = 1 AND  started_time < '".$today_time ."' AND finished_time > '".$today_time."'";
        global $db;
        $query = " SELECT id,name
        FROM fs_sales 
        WHERE ".$where."
        ORDER BY ordering
        ";
        $db->query($query);
        $list = $db->getObjectList();
        return $list;   
    }
}