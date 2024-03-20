<?php
	class ProductsControllersProducts_incentives  extends Controllers
	{
		function __construct()
		{
			$this->view = 'products_incentives' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
			$list = $model->get_data();
		//	$categories = $model->get_categories_tree();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		
		function add_products(){
			$model  = $this -> model;
			$json = '{';
			if(!$model -> check_add()){
				$json .= "'status':2,'html':''";
				$json .= '}'; // end the json array element
				echo $json;
				return;
			}
			if($model -> add_product_incentives()){
				$html = $this -> genarate_html();
				$json .= "'status':1,'html':'".$html."'";
				$json .= '}'; // end the json array element
				echo $json;
				return;
			}else{
				$json .= "'status':0,'html':''";
				$json .= '}'; // end the json array element
				echo $json;
				return;
			}
		}
		
		function genarate_html(){
			$model  = $this -> model;
			
			$id = FSInput::get('id',0,'int');
			$product_incentives_id = FSInput::get('product_incentives_id',0,'int');
			if(!$id || !$product_incentives_id)	
				return;
			$product = $model -> get_record_by_id($product_incentives_id,'fs_products');
			$html = '';
			$html .= '<tr id="record_'.$product_incentives_id.'">';
			$html .= '		<td>';
			$html .= '			'.$product -> name.'	</td>';
			$html .= '		<td>';
			$html .= '			'.format_money( $product -> price,'').'	</td>';
			$html .= '		<td>';
			$html .= '			<input type="text" name="price_new_'.$product ->id.'" value="'. $product -> price.'" >';
			$html .= '			<input type="hidden" name="price_new_'.$product ->id.'_begin" value="'. $product -> price.'" >';
			$html .= '		</td>';
			$html .= '		<td>';
			$html .= '			'.$product_incentives_id.'					</td>';
			$html .= '		<td>';
			$html .= '			<a href="javascript: remove_incentives('.$id.','.$product_incentives_id.')">Xóa</a>';
			$html .= '		</td>';
			$html .= '	</tr>';
			return $html;
		}
	}
	
?>