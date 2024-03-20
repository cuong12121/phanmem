<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class LandingpagesControllersLandingpages extends Controllers
{
	function __construct()
	{
		$this->modules = 'landingpages' ; 
		$this->view = 'landingpages' ; 
		parent::__construct(); 
	}
	function display()
	{
		$model = $this -> model;
		parent::display();
		$sort_field = $this -> sort_field;
		$sort_direct = $this -> sort_direct;

		$list = $this -> model->get_data();
		$content = $this -> model ->get_content();
		$categories = $model->get_categories_tree();
		$pagination = $this -> model->getPagination();
		include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}

	function add()
	{
		$model = $this -> model;
		$maxOrdering = $model->getMaxOrdering();
		$content = $this -> model ->get_content();
		$categories = $model->get_categories_tree();
		// $projects_categories = $model->get_projects_categories_tree();
		$videos_categories = $model->get_videos_categories_tree();
		$aq_categories = $model->get_aq_categories_tree();
			// $content[0]-> id = 0;
			// $content[0]-> title = 'Không';

		include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
	}

	function edit()
	{
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);
		$content = $this -> model ->get_content();
		$categories  = $model->get_categories_tree();
		// $projects_categories = $model->get_projects_categories_tree();
			// $projects_related = $model -> get_projects_related($data -> projects_related);

			$videos_categories = $model->get_videos_categories_tree();
			// $videos_related = $model -> get_videos_related($data -> videos_related);
			$aq_categories = $model->get_aq_categories_tree();
			// $aq_related = $model -> get_aq_related($data -> aq_related);
			// $content['999']-> id = 0;
			// $content['999']-> title = 'Không';
		include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
	}
	function edit_grapesjs() {
		$ids = FSInput::get('id',array(),'array');
		$id = $ids[0];
		$model = $this -> model;
		$data = $model->get_record_by_id($id);
		$content = $this -> model ->get_content();
		global $path;
		//print_r( $path);
		//die;
		include( $path.'/libraries/grapesjs/index.php'); 
	}
	function ajax_get_projects_related(){
			$model = $this -> model;
			$data = $model->ajax_get_projects_related();
			$html = $this -> projects_genarate_related($data);
			echo $html;
			return;
		}
		function projects_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="projects_related">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red projects_related_item  projects_related_item_'.$item -> id.'" onclick="javascript: set_projects_related('.$item->id.')" style="display:none" >';	
					$html .= $item -> name;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="projects_related_item  projects_related_item_'.$item -> id.'" onclick="javascript: set_projects_related('.$item->id.')">';	
					$html .= $item -> name;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
		}
	function ajax_get_aq_related(){
			$model = $this -> model;
			$data = $model->ajax_get_aq_related();
			$html = $this -> aq_genarate_related($data);
			echo $html;
			return;
		}
		function aq_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="aq_related">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red aq_related_item  aq_related_item_'.$item -> id.'" onclick="javascript: set_aq_related('.$item->id.')" style="display:none" >';	
					$html .= $item -> title;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="aq_related_item  aq_related_item_'.$item -> id.'" onclick="javascript: set_aq_related('.$item->id.')">';	
					$html .= $item -> title;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
		}
	function ajax_get_videos_related(){
			$model = $this -> model;
			$data = $model->ajax_get_videos_related();
			$html = $this -> videos_genarate_related($data);
			echo $html;
			return;
		}
		function videos_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
			$html .= '<div class="videos_related">';
			foreach ($data as $item){
				if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
					$html .= '<div class="red videos_related_item  videos_related_item_'.$item -> id.'" onclick="javascript: set_videos_related('.$item->id.')" style="display:none" >';	
					$html .= $item -> title;				
					$html .= '</div>';					
				}else{
					$html .= '<div class="videos_related_item  videos_related_item_'.$item -> id.'" onclick="javascript: set_videos_related('.$item->id.')">';	
					$html .= $item -> title;				
					$html .= '</div>';	
				}
			}
			$html .= '</div>';
			return $html;
		}

	function save_html_css() {
		$model = $this -> model;
		$save = $model-> save_html_css();
	}
}

?>