<?php
/*
 * Huy write
 */
	// controller

class VideosControllersCat extends FSControllers
{
	
	function display()
	{
			// call models
		$model = $this -> model;
		$cat  = $model->getCategory();


		if(!$cat){
			setRedirect(FSRoute::_('index.php?module=notfound&view=notfound&Itemid=1000'),'Not exist this url','error');
		} else {
			$code = FSInput::get ( 'ccode' );
			if($code != $cat-> alias) {
				setRedirect(FSRoute::_('index.php?module=videos&view=cat&cid='.$cat->id.'&ccode='.$cat-> alias.'Itemid=1000'));
			}
		}



		$query_body = $model->set_query_body($cat->id);
		$list = $model->get_list ( $query_body );
		$list_cats = $model -> get_cats();
		$total = $model->getTotal($query_body);
		$pagination = $model->getPagination($total);
		$breadcrumbs = array();
		$breadcrumbs[] = array(0=>'Video', 1 => FSRoute::_('index.php?module=videos&view=home&Itemid=2'));
		$breadcrumbs[] = array(0=>$cat->name, 1 => FSRoute::_('index.php?module=videos&view=cat&id='.$cat -> id.'&ccode='.$cat -> alias. '&Itemid='));


		global $tmpl;	
		$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
		$tmpl -> set_data_seo($cat);
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
	}
}
?>