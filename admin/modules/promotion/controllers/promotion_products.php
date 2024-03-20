<?php
	class PromotionControllersPromotion_products  extends Controllers
	{
		function __construct()
		{
			$this->view = 'promotion_products' ; 
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
			if($model -> add_promotion_products()){
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
			$promotion_product_id = FSInput::get('promotion_product_id',0,'int');
			if(!$id || !$promotion_product_id)	
				return;
			$product = $model -> get_record_by_id($promotion_product_id,'fs_products');
			$html = '';
			$html .= '<tr id="record_product_'.$promotion_product_id.'">';
			$html .= '		<td>';
			$html .= '			'.$product -> name.'	</td>';
			$html .= '		<td>';
			$html .= '			'.format_money( $product -> price,'').'	</td>';
			$html .= '		<td>';
			$html .= '			<input type="text" name="price_new_'.$product ->id.'" value="'. $product -> price.'" >';
			$html .= '			<input type="hidden" name="price_new_'.$product ->id.'_begin" value="'. $product -> price.'" >';
			$html .= '		</td>';
			$html .= '		<td>';
			$html .= '			<a href="javascript: remove_product('.$id.','.$promotion_product_id.')">Xóa</a>';
			$html .= '		</td>';
			$html .= '		<td>';
			$html .= '			'.$promotion_product_id.'					</td>';
			$html .= '	</tr>';
			return $html;
		}
	}
	
?>