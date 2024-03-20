<?php 
class LandingpagesModelsLandingpages extends FSModels
{
	var $limit;
	var $prefix ;
	function __construct()
	{
		$this -> limit = 30;
		$this -> view = 'landingpages';
		$this -> table_name = FSTable_ad::_ ('fs_landingpages');
		$this -> table_template = FSTable_ad::_ ('fs_templates');
		$this -> table_category_name = FSTable_ad::_ ('fs_slideshow_categories');
			// config for save
			// $this -> arr_img_paths = array(array('resized',297,374,'resized_not_crop'),array('large',450,566,'resized_not_crop'));
			// $this -> img_folder = 'images/landingpages';
		$this -> check_alias = 0;
			// $this -> field_img = 'image';
		parent::__construct();
	}

	function get_data()
	{
		global $db;
		$query = $this->setQuery();
		if(!$query)
			return array();

		$sql = $db->query_limit($query,$this->limit,$this->page);
		$result = $db->getObjectList();

		return $result;
	}
	function get_categories_tree() {
		global $db;
		$query = " SELECT a.*
						  FROM 
						  	" . $this->table_category_name . " AS a
						  	ORDER BY ordering ";
		$result = $db->getObjectList ( $query );
		
		return $result;
	}

	function setQuery1(){

			// ordering
		$ordering = "";
		if(isset($_SESSION[$this -> prefix.'sort_field']))
		{
			$sort_field = $_SESSION[$this -> prefix.'sort_field'];
			$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
			$sort_direct = $sort_direct?$sort_direct:'asc';
			$ordering = '';
			if($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";

		}
		if(!$ordering)
			$ordering .= " ORDER BY created_time DESC , id DESC ";

		$where = "  ";

		if(isset($_SESSION[$this -> prefix.'keysearch'] ))
		{
			if($_SESSION[$this -> prefix.'keysearch'] )
			{
				$keysearch = $_SESSION[$this -> prefix.'keysearch'];
				$where .= " AND name LIKE '%".$keysearch."%' ";
			}
		}

		$query = " SELECT a.*
		FROM 
		fs_landingpages AS a
		WHERE 1=1".
		$where.
		$ordering. " ";

		return $query;
	}


	function save($row = array(), $use_mysql_real_escape_string = 1){
		$title = FSInput::get('title');
		$alias= FSInput::get('alias');
		$ctn= FSInput::get('content');

		$fsstring = FSFactory::getClass('FSString','','../');
		if(!$title)
			return false;
		$idss= FSInput::get('id');
		if($idss){
			$template=$idss;
		}
		else{
			$template = FSInput::get ( 'template' );
		}

		$record_projects_relate = FSInput::get('projects_record_related',array(),'array');
		$row['projects_related'] ='';
		if(count($record_projects_relate)){
			$record_projects_relate = array_unique($record_projects_relate);
			$row['projects_related'] = ','.implode(',', $record_projects_relate).',';	
		}	
		$record_videos_relate = FSInput::get('videos_record_related',array(),'array');
		$row['videos_related'] ='';
		if(count($record_videos_relate)){
			$record_videos_relate = array_unique($record_videos_relate);
			$row['videos_related'] = ','.implode(',', $record_videos_relate).',';	
		}	
		$record_aq_relate = FSInput::get('aq_record_related',array(),'array');
		
		$row['aq_related'] ='';
		if(count($record_aq_relate)){
			$record_aq_relate = array_unique($record_aq_relate);
			$row['aq_related'] = ','.implode(',', $record_aq_relate).',';	
		}	

		// $get_template = $this -> get_record(' id = '.$template.'',$this -> table_template,'*');

		// if($ctn==''){
		// 	$row ['content'] =  $get_template->content;
		// 	$row ['template'] =  $get_template->id;
		// }
		

		return parent::save($row);
	}

	function save_html_css(){
		$table_name = FSInput::get('table_name','','txt');
		$html = FSInput::get('grapesjs_html','','txt');
		$css = FSInput::get('grapesjs_css','','txt');
		$js = FSInput::get('grapesjs_js','','txt');
		$id = FSInput::get('id',0,'int');
		// $html = str_replace('\&quot;','"',$html);
		$html = html_entity_decode($html);
		$html = str_replace("\'","'",$html);
		$html = str_replace('\"','"',$html);
		//$html = str_replace(URL_ROOT,'',$html);
		$js = str_replace('\"','"',$js);
		$js = str_replace("\'","'",$js);
		$js = str_replace('\&quot;','"',$js);
		$css = str_replace('// IE 11 bugfix','',$css);
		$css = preg_replace('!\s+!', ' ', $css);
		 
		$row['html'] = $html;
		$row['css'] = $css;
		$row['js'] = $js;
		$save = $this-> _update($row,$table_name, 'id = '.$id,1);
	}
	
	function get_projects_related($projects_related){
		if(!$projects_related)
			return;
		$query   = " SELECT id, name 
		FROM fs_projects
		WHERE id IN (0".$projects_related."0) 
		ORDER BY POSITION(','+id+',' IN '0".$projects_related."0')
		";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}


function get_projects_categories_tree() {
	global $db;
	$sql = " SELECT id, name, parent_id AS parent_id 
	FROM fs_projects_categories" ;
	$db->query ( $sql );
	$categories = $db->getObjectList ();

	$tree = FSFactory::getClass ( 'tree', 'tree/' );
	$rs = $tree->indentRows ( $categories, 1 );
	return $rs;
}
function ajax_get_projects_related(){
	$category_id = FSInput::get('category_id',0,'int');
	$keyword = FSInput::get('keyword');
	$where = ' WHERE published = 1 ';
	if($category_id){
		$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
	}
	$where .= " AND ( name LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";

	$query_body = ' FROM fs_projects '.$where;
	$ordering = " ORDER BY created_time DESC , id DESC ";
	$query = ' SELECT id,category_id,name,category_name '.$query_body.$ordering.' LIMIT 40 ';
	global $db;
	$sql = $db->query($query);
	$result = $db->getObjectList();
	return $result;
}
	function get_aq_related($aq_related){
		if(!$aq_related)
			return;
		$query   = " SELECT id, title 
		FROM fs_aq
		WHERE id IN (0".$aq_related."0) 
		ORDER BY POSITION(','+id+',' IN '0".$aq_related."0')
		";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

function get_aq_categories_tree() {
	global $db;
	$sql = " SELECT id, name, parent_id AS parent_id 
	FROM fs_aq_categories" ;
	$db->query ( $sql );
	$categories = $db->getObjectList ();

	$tree = FSFactory::getClass ( 'tree', 'tree/' );
	$rs = $tree->indentRows ( $categories, 1 );
	return $rs;
}
function ajax_get_aq_related(){
	$category_id = FSInput::get('category_id',0,'int');
	$keyword = FSInput::get('keyword');
	$where = ' WHERE published = 1 ';
	if($category_id){
		$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
	}
	$where .= " AND ( title LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";

	$query_body = ' FROM fs_aq '.$where;
	$ordering = " ORDER BY created_time DESC , id DESC ";
	$query = ' SELECT id,category_id,title,category_name '.$query_body.$ordering.' LIMIT 40 ';
	global $db;
	$sql = $db->query($query);
	$result = $db->getObjectList();
	return $result;
}

function get_videos_related($videos_related){
		if(!$videos_related)
			return;
		$query   = " SELECT id, title 
		FROM fs_videos
		WHERE id IN (0".$videos_related."0) 
		ORDER BY POSITION(','+id+',' IN '0".$videos_related."0')
		";
		global $db;
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}


function get_videos_categories_tree() {
	global $db;
	$sql = " SELECT id, name, parent_id AS parent_id 
	FROM fs_videos_categories" ;
	$db->query ( $sql );
	$categories = $db->getObjectList ();

	$tree = FSFactory::getClass ( 'tree', 'tree/' );
	$rs = $tree->indentRows ( $categories, 1 );
	return $rs;
}
function ajax_get_videos_related(){
	$category_id = FSInput::get('category_id',0,'int');
	$keyword = FSInput::get('keyword');
	$where = ' WHERE published = 1 ';
	if($category_id){
		$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
	}
	$where .= " AND ( title LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' )";

	$query_body = ' FROM fs_videos '.$where;
	$ordering = " ORDER BY created_time DESC , id DESC ";
	$query = ' SELECT id,category_id,title,category_name '.$query_body.$ordering.' LIMIT 40 ';
	global $db;
	$sql = $db->query($query);
	$result = $db->getObjectList();
	return $result;
}
	function get_content() {
		global $db;
		$query = " SELECT id, title
		FROM ".$this -> table_template." ORDER BY ordering";
		global $db;
		$sql = $db->query ( $query );
		$result = $db->getObjectList ();
		return $result;
	}

}

?>