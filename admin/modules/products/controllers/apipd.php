<?php
	// models 

		  
	class ProductsControllersApipd extends Controllers
	{
		function __construct()
		{
			$this->view = 'apipd' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			$model  = $this -> model;
		
			
			$count_result = $this -> model->countRecordCode();
			
			$lists = $this -> model->showAllShop();
			
			$result = [];
			
			if( $count_result>1){
			    
			    $lists = array_chunk($lists, $count_result);
			    
			   
			    
			    $revenue = $net_revenue = $cost =  $return_revenue = $return_cost = $packaging_cost = $shipping_cost = $ads_cost = $other_cost = $gross_profit = [];
			    
			    foreach($lists as $key => $value){
			        
			         $result[$key]['id'] = $value[0]->id;
			        
			        $result[$key]['code'] = $value[0]->code;
			        
			        $result[$key]['name'] = $value[0]->name;
			        
			        $result[$key]['address'] = $value[0]->address;
			        
			        
			        
			        
			        $result[$key]['manager_staff'] = $value[0]->manager_staff;
			        
			        $result[$key]['created_at'] = $value[0]->created_at;
			        
			        for($i = 0; $i<$count_result; $i++){
			            
			            array_push($revenue, $value[$i]->revenue);
			            
			            array_push($return_revenue, $value[$i]->return_revenue);
			            
			            $result[$key]['return_revenue'] = $value[0]->return_revenue;
			            
			            array_push($net_revenue, $value[$i]->net_revenue);
			            
			            array_push($cost, $value[$i]->cost);
			            
			            array_push($return_cost, $value[$i]->return_cost);
			            
			            array_push($packaging_cost, $value[$i]->packaging_cost);
			            
			            array_push($shipping_cost, $value[$i]->shipping_cost);
			            
			            array_push($ads_cost, $value[$i]->ads_cost);
			            
			            array_push($other_cost, $value[$i]->other_cost);
			            
			            array_push($gross_profit, $value[$i]->gross_profit);
			            
			            
			        }
			        
			 		$result[$key]['revenue'] = number_format(array_sum($revenue), 0, '', '.');
			 		
			 		$result[$key]['return_revenue'] = number_format(array_sum($return_revenue), 0, '', '.');
			    
                    $result[$key]['net_revenue'] = number_format(array_sum($net_revenue), 0, '', '.');
                    
                    $result[$key]['cost'] = number_format(array_sum($cost), 0, '', '.');
                    
                    $result[$key]['return_cost'] = number_format(array_sum($return_cost), 0, '', '.');
                    
                    $result[$key]['packaging_cost'] = number_format(array_sum($packaging_cost), 0, '', '.');
                    
                    $result[$key]['shipping_cost'] = number_format(array_sum($shipping_cost), 0, '', '.');
                    
                    $result[$key]['ads_cost'] = number_format(array_sum($ads_cost), 0, '', '.');
                    
                    $result[$key]['other_cost'] = number_format(array_sum($other_cost), 0, '', '.');
                    
                    $result[$key]['gross_profit'] = number_format(array_sum($gross_profit), 0, '', '.');
			        
			       
			    }
			    
			}
			else{
			    foreach($lists as $key => $value){
			        
			        $result[$key]['id'] = $value->id;
			        
			        $result[$key]['code'] = $value->code;
			        
                    $result[$key]['name'] = $value->name;
                    
                    $result[$key]['address'] = $value->address;
                    
                    $result[$key]['manager_staff'] = $value->manager_staff;
                    
                    $result[$key]['return_revenue'] = number_format($value->return_revenue, 0, '', '.');
                    
                     $result[$key]['revenue'] = number_format($value->revenue, 0, '', '.');
                    
                    $result[$key]['net_revenue'] = number_format($value->net_revenue, 0, '', '.');
                    
                    $result[$key]['cost'] = number_format($value->cost, 0, '', '.');
                    
                    $result[$key]['return_cost'] = number_format($value->return_cost, 0, '', '.');
                    
                    $result[$key]['packaging_cost'] = number_format($value->packaging_cost, 0, '', '.');
                    
                    $result[$key]['shipping_cost'] = number_format($value->shipping_cost, 0, '', '.');
                    
                    $result[$key]['ads_cost'] = number_format($value->ads_cost, 0, '', '.');
                    
                    $result[$key]['other_cost'] = number_format($value->other_cost, 0, '', '.');
                    
                    $result[$key]['gross_profit'] = number_format($value->gross_profit, 0, '', '.');
                    
                    $result[$key]['created_at'] = $value->created_at;
			       
			    }     
			}
			
// 			echo "<pre>";
//               print_r($result);
//             echo "</pre>";
			
		
			
		  //  foreach($list as $val){
		  //      echo $val->code.'<br>';
		  //  }
// 		    die();
// 			$pagination = $model->getPagination();
			include 'modules/products/views/apipd/list.php';
		}	
	}
	
?>