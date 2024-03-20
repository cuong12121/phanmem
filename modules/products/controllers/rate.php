<?php
/*
 * Huy write
 */
	// controller

class ProductsControllersRate extends FSControllers {
	var $module;
	var $view;

	function display(){
		$model = $this->model;
		$ids = FSInput::get('id');
		// $ids = array_filter($ids);
		$query_body = $model->set_query_body();
		$rates = $model->get_parents($query_body);
		$rates_children = $model->get_list($query_body);
		$data=$model->get_record_by_id($ids,'fs_products');
		global $config;
		$cat = $model->getCategoryById ( $data->category_id );
		if (! $cat){
			setRedirect(FSRoute::_('index.php?module=notfound&view=notfound'),'Danh mục này không tồn tại');
		}
		$ccode = FSInput::get ( 'ccode' );
		if ($cat->alias != $ccode) {
			$Itemid = 6;
			$link = FSRoute::_ ( 'index.php?module=products&view=product&code=' . $data->alias . '&id=' . $data->id . '&ccode=' . $cat->alias . '&Itemid=' . $Itemid );
			setRedirect ( $link );
		}
		$total_rate = count ( $rates );
		if ($total_rate) {
			$list_parent = array ();
			$list_children = array ();
			foreach ( $rates as $item ) {
				if (! $item->parent_id) {

					$list_parent [] = $item;
//						$rates_children = $model->get_rates_child($item->id);
				} 
			}

			foreach ( $rates_children as $child ) {
				if (! isset ( $list_children [$child->parent_id] ))
					$list_children [$child->parent_id] = array ();
				$list_children [$child->parent_id] [] = $child;
			}
		}
		
		$total = $model -> getTotal($query_body);
		if(!empty($list_parent)){
			foreach ($list_parent as $item){
				$count_rt[$item->id]=$model->get_countrate($item->id); 
			}
		}

		$breadcrumbs = array ();
			$filter_manu = $model -> get_filter_menu($data->manufactory, $data->tablename);
			
		if($filter_manu){
			$breadcrumbs[] = array(0=>$data->manufactory_name, 1 => FSRoute::_('index.php?module=products&view=cat&cid='.$data -> category_id.'&ccode='.$data -> category_alias.'&filter='.$filter_manu->alias));
		}

		$breadcrumbs[] = array(0=>$cat -> name, 1 => FSRoute::_('index.php?module=products&view=cat&cid='.$data -> category_id.'&ccode='.$data -> category_alias));

		$breadcrumbs[] = array(0=>$data -> name, 1 => FSRoute::_ ( 'index.php?module=products&view=product&code=' . $data->alias . '&id=' . $data->id . '&ccode=' . $cat->alias));

		$canonical = FSRoute::_ ( 'index.php?module=products&view=product&code=' . $data->alias . '&id=' . $data->id . '&ccode=' . $cat->alias);

		global $tmpl;
		$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
		$tmpl->assign ( 'noindex', 1 );

		$tmpl->assign ('canonical', $canonical);

		$pagination = $model->getPagination ( $total );

		$count1 = $model->get_countr(1);
		$count2 = $model->get_countr(2);
		$count3 = $model->get_countr(3);
		$count4 = $model->get_countr(4);
		$count5 = $model->get_countr(5);


		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';

	}
}


?>