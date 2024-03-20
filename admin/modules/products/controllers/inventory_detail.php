<?php	  
	class ProductsControllersInventory_detail extends Controllers
	{
		function __construct()
		{
			$this->view = 'inventory_detail' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$id = FSInput::get('id');
			$data = $this -> model->get_records('product_id = '.$id,'fs_warehouses_products','*','','','warehouses_id');
			// if(!empty($data)){
			// 	printr($data);
			// }
			
			$warehouses = $model -> get_records('published = 1','fs_warehouses');
			
			$pagination = $model->getPagination();

			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

	
	}

	function view_amount($controle,$warehouse_product_id){
		$model = $controle -> model;
		return $warehouse_product_id;
		// $link = '';
		// if(!empty($_SESSION['products_products_filter1'])){
		// 	$data = $model->get_record('product_id = ' .$id . ' AND warehouses_id = ' . $_SESSION['products_products_filter1'],'fs_warehouses_products','amount');
		// 	return '<a target="_blink" href="' . $link . '">'.@$data->amount.'</a>';
		// }else{
		// 	$amount = 0;
		// 	$data = $model->get_records('product_id = ' .$id,'fs_warehouses_products','amount');
		// 	if(!empty($data)){
		// 		foreach ($data as $item) {
		// 			if($item->amount){
		// 				$amount += (int)$item->amount;
		// 			}
					
		// 		}
		// 	}
		// 	return '<a target="_blink" href="' . $link . '">'.@$amount.'</a>';
		// }
	}
	
?>