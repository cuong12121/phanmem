<?php
class FSRoute
{
	var $url;
	
	function __construct($url){
	}
	
	static function _($url)
	{
		return FSRoute::enURL($url);
	}
	
	/*
	 * Trả lại tên mã hóa trên URL
	 */
	static function get_name_encode($name,$lang){
		$lang_url = array('ct'=>'ce',
	);
		if($lang == 'vi')
			return $name;
		else 
			return $lang_url[$name];
	}
	static function addParameters($params,$value){
		// only filter
		$module = FSInput::get('module');
		$view = FSInput::get('view');
		if($module == 'products' && $view== 'search'){
			$array_paras_need_get = array('ccode','filter','manu','order','style','Itemid','keyword');
			$url = 'index.php?module='.$module.'&view='.$view;
			foreach($array_paras_need_get as $item){
				if($item != $params){
					$value_of_param = FSInput::get($item);
					if($value_of_param){
						$url .= "&".$item."=".$value_of_param;
					}
				}else {
					if($value)
						$url .= "&".$item."=".$value;
				}
			}
			return FSRoute :: _($url);
		}
		if($module == 'products' && ($view== 'cat' || $view== 'product')){
			$array_paras_need_get = array('ccode','filter','manu','sort','style','Itemid','cid');
			$url = 'index.php?module='.$module.'&view=cat';
			foreach($array_paras_need_get as $item){
				if($item != $params){
					$value_of_param = FSInput::get($item);
					if($value_of_param){
						$url .= "&".$item."=".$value_of_param;
					}
				}else {
					if($value)
						$url .= "&".$item."=".$value;
				}
			}
			return FSRoute :: _($url);
		}
//		if($module == 'products' && $view= 'product'){
//			$ccode = FSInput::get('ccode');
//			$code = FSInput::get('code');
//			$Itemid = FSInput::get('Itemid');
//			
//			$url = 'index.php?module='.$module.'&view='.$view;
//			if($ccode){
//				$url .= '&ccode='.$ccode;
//			}
//			if($code){
//				$url .= '&code='.$code;
//			}
//			
//			// manufactory
//			if($params == 'layout'){
//				$url .= '&layout='.$value;
//			}
//			return FSRoute :: _($url);
//		}
		
		return FSRoute :: _($_SERVER['REQUEST_URI']);
	}
	function removeParameters($params){
		// only filter
		$module = FSInput::get('module');
		$view = FSInput::get('view');
		$ccode = FSInput::get('ccode');
		$filter = FSInput::get('filter');
		$manu = FSInput::get('manu');
		$Itemid = FSInput::get('Itemid');
		
		$url = 'index.php?module='.$module.'&view='.$view;
		if($ccode){
			$url .= '&ccode='.$ccode;
		}
		if($manu){
			$url .= '&manu='.$manu;
		}
		if($filter){
			$url .= '&filter='.$filter;
		}
		$url .= '&Itemid='.$Itemid;
		$url =  trim(preg_replace('/&'.$params.'=[0-9a-zA-Z_-]+/i', '', $url));
	}
	/*
	 * rewrite
	 */
	static function enURL($url){
		if(!$url)
			$url = $_SERVER['REQUEST_URI'];
		if(!IS_REWRITE)
			return URL_ADMIN.$url;
		if(strpos($url, 'http://') !== false || strpos($url, 'https://') !== false || strpos($url, 'tel:') !== false || strpos($url, 'mailto:') !== false)
			return $url;
		$url_reduced  = substr($url,10); // width : index.php
		$array_buffer = explode('&',$url_reduced,10);
		$array_params = array();
		for($i  = 0; $i < count($array_buffer) ; $i ++ ){
			$item = $array_buffer[$i];
			$pos_sepa = strpos($item,'=');
			$array_params[substr($item,0,$pos_sepa)] = substr($item,$pos_sepa+1);  
		}	
		
		$module  = isset($array_params['module'])?$array_params['module']: '';
		$view  = isset($array_params['view'])?$array_params['view']: $module;
		$task  = isset($array_params['task'])?$array_params['task']: 'display';
		$Itemid  = isset($array_params['Itemid'])?$array_params['Itemid']: 0;
		
		$languge = isset($_SESSION['lang'])?$_SESSION['lang']:'en';	
		$url_first  = URL_ADMIN; 
		$url1 = '';
		$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'en';

		switch($module){
			case 'products':
			switch ($view){
				case 'products':
				switch ($task){
					case 'edit':
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.'product/edit/'.$id;
					case 'add':
					$id =  isset($array_params['cid'])?$array_params['cid']: '';
					return $url_first.'product/add/'.$id;
					case 'export':
					return $url_first.'product/export';
					default:
					return $url_first.'product';
				}
				return $url_first.'product';

				case 'categories':
				switch ($task){
					case 'add':
					return $url_first.'product/categories/add/';
					case 'edit':
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.'product/categories/edit/'.$id;
					default:
					return $url_first.'product/categories';
				}

				case 'types':
				switch ($task){
					case 'add':
					return $url_first.'product/types/add/';
					case 'edit':
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.'product/types/edit/'.$id;
					default:
					return $url_first.'product/types';
				}

				case 'view_amount_hold':
				switch ($task){
					
					// return $url_first.'product/view-amount-hold/'.$id;
					case 'add':
					return $url_first.'product/view-amount-hold/add/';
					case 'edit':
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.'product/view-amount-hold/edit/'.$id;
					default:
					$id =  isset($array_params['id'])?$array_params['id']: '';
					$warehouse_id =  isset($array_params['warehouse_id'])?$array_params['warehouse_id']: '';
					if($warehouse_id){
						return $url_first.'product/view-amount-hold/'.$id.'/'.$warehouse_id;
					}else{
						return $url_first.'product/view-amount-hold/'.$id;
					}
				}

				case 'house':
				switch ($task){
					case 'add':
					return $url_first.'product/house/add/';
					case 'edit':
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.'product/house/edit/'.$id;
					default:
					return $url_first.'product/house';
				}

				case 'platforms':
				switch ($task){
					case 'add':
					return $url_first.'product/platforms/add/';
					case 'edit':
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.'product/platforms/edit/'.$id;
					default:
					return $url_first.'product/platforms';
				}

				case 'inventory':
					return $url_first.'product/inventory';

				case 'inventory_detail':
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.'product/inventory-detail/'.$id;
				

				case 'manufactories':
				switch ($task){
					case 'add':
					return $url_first.'product/manufactories/add/';
					case 'edit':
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.'product/manufactories/edit/'.$id;
					default:
					return $url_first.'product/manufactories';
				}

				case 'tables':
				switch ($task){
					case 'add':
					return $url_first.'product/tables/add/';
					case 'edit':
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.'product/tables/edit/'.$id;
					default:
					return $url_first.'product/tables';
				}
			}
			break;

			case 'extends':
			switch ($view){
				case 'groups':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'extends/groups/edit/'.$id;
					case 'add':
					return $url_first.'extends/groups/add/'.$id;
					default:
					return $url_first.'extends/groups';
				}
				return $url_first.'extends/groups';

				case 'data':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'extends/data/edit/'.$id;
					case 'add':
					return $url_first.'extends/data/add/'.$id;
					default:
					return $url_first.'extends/data';
				}
				return $url_first.'extends/data';
			}
			break;


			case 'users':
			switch ($view){
				case 'profile':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'users/profile/edit/'.$id;
					case 'add':
					return $url_first.'users/profile/add/'.$id;
					default:
					return $url_first.'users/profile';
				}
				return $url_first.'users/profile';

				case 'groups_file':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'users/groups_file/edit/'.$id;
					case 'add':
					return $url_first.'users/groups_file/add/'.$id;
					default:
					return $url_first.'users/groups_file';
				}
				return $url_first.'users/groups_file';


				case 'files':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'users/files/edit/'.$id;
					case 'add':
					return $url_first.'users/files/add/'.$id;
					default:
					return $url_first.'users/files';
				}
				return $url_first.'users/files';

				case 'groups':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'users/groups/edit/'.$id;
					case 'add':
					return $url_first.'users/groups/add/'.$id;
					default:
					return $url_first.'users/groups';
				}
				return $url_first.'users/groups';

			
			}
			break;


			case 'sells':
			switch ($view){
				case 'retail':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'sells/retail/edit/'.$id;
					case 'add':
					return $url_first.'sells/retail/add/'.$id;
					default:
					return $url_first.'sells/retail';
				}
				return $url_first.'sells/retail';
			}
			break;

			case 'config':
			switch ($view){
				case 'config':
				return $url_first.'config/data';
			}
			break;


			case 'shops':
			switch ($view){
				case 'shop':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'shops/shop/edit/'.$id;
					case 'add':
					return $url_first.'shops/shop/add/'.$id;
					default:
					return $url_first.'shops/shop';
				}
				case 'recharges':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'shops/recharges/edit/'.$id;
					case 'add':
					return $url_first.'shops/recharges/add/'.$id;
					default:
					return $url_first.'shops/recharges';
				}
				return $url_first.'shops/recharges';

				case 'transfer_money':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'shops/transfer_money/edit/'.$id;
					case 'add':
					return $url_first.'shops/transfer_money/add/'.$id;
					default:
					return $url_first.'shops/transfer_money';
				}
				return $url_first.'shops/transfer_money';
			}
			break;

			case 'warehouse_sales':
			switch ($view){
				case 'sales':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'warehouse_sales/sales/edit/'.$id;
					case 'add':
					return $url_first.'warehouse_sales/sales/add/'.$id;
					default:
					return $url_first.'warehouse_sales/sales';
				}

				case 'barcode':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
	
					default:
					return $url_first.'warehouse_sales/barcode';
				}

				case 'excel':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'import_excel':
					return $url_first.'warehouse_sales/excel/import_excel';
					case 'download_file':
					return $url_first.'warehouse_sales/excel/download_file';
					default:
					return $url_first.'warehouse_sales/excel';
				}
				return $url_first.'warehouse_sales/sales';
			}
			break;


			case 'profits':
			switch ($view){
				case 'items':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
	
					default:
					return $url_first.'profits/items';
				}
				case 'profist_shop':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'profits/profist_shop/edit/'.$id;
					default:
					return $url_first.'profits/profist_shop';
				}

			}
			break;


			case 'company_profits':
			switch ($view){
				case 'items':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
	
					default:
					return $url_first.'company_profits/items';
				}
				case 'profist_time':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'company_profits/profist_time/edit/'.$id;
					default:
					return $url_first.'company_profits/profist_time';
				}

			}
			break;

			case 'add_shop':
			switch ($view){
				case 'excel':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'import_excel':
					return $url_first.'add_shop/excel/import_excel';
					case 'download_file':
					return $url_first.'add_shop/excel/download_file';
					default:
					return $url_first.'add_shop/excel';
				}
				return $url_first.'add_shop/excel';
			}
			break;

			case 'add_product':
			switch ($view){
				case 'excel':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'import_excel':
					return $url_first.'add_product/excel/import_excel';
					case 'download_file':
					return $url_first.'add_product/excel/download_file';
					case 'export_product':
					return $url_first.'add_product/excel/export_product';
					default:
					return $url_first.'add_product/excel';
				}
				return $url_first.'add_product/excel';
			}
			break;



			case 'refunds':
			switch ($view){
				case 'refund':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'refunds/refund/edit/'.$id;
					case 'add':
					return $url_first.'refunds/refund/add/'.$id;
					case 'excel_hoan_hang':
					return $url_first.'refunds/refund/excel_hoan_hang';
					default:
					return $url_first.'refunds/refund';
				}
				case 'barcode':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
	
					default:
					return $url_first.'refunds/barcode';
				}

				case 'excel':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'import_excel':
					return $url_first.'refunds/excel/import_excel';
					case 'download_file':
					return $url_first.'refunds/excel/download_file';
					default:
					return $url_first.'refunds/excel';
				}
				return $url_first.'refunds/refund';
			}
			break;

			case 'order':
			switch ($view){
				case 'upload':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'order/upload/edit/'.$id;
					case 'add':
					return $url_first.'order/upload/add/'.$id;
					default:
					return $url_first.'order/upload';
				}
				return $url_first.'order/upload';
			}
			break;

			case 'order_items':
			switch ($view){
				case 'items':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'excel_nhat':
					return $url_first.'order_items/items/excel_nhat';
					case 'excel_misa':
					return $url_first.'order_items/items/excel_misa';
					case 'excel_tong_ngay':
					return $url_first.'order_items/items/excel_tong_ngay';
					case 'edit':
					return $url_first.'order_items/items/edit/'.$id;
					default:
					return $url_first.'order_items/items';
				}
			}
			break;


			case 'warranty':
			switch ($view){
				case 'return':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'warranty/return/edit/'.$id;
					case 'add':
					return $url_first.'warranty/return/add/'.$id;
					default:
					return $url_first.'warranty/return';
				}
				case 'tutorial':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'warranty/tutorial/edit/'.$id;
					case 'add':
					return $url_first.'warranty/tutorial/add/'.$id;
					default:
					return $url_first.'warranty/tutorial';
				}
				return $url_first.'warranty/tutorial';

				case 'create_order':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'warranty/create_order/edit/'.$id;
					case 'add':
					return $url_first.'warranty/create_order/add/'.$id;
					default:
					return $url_first.'warranty/create_order';
				}
				return $url_first.'warranty/create_order';

				case 'video':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'warranty/video/edit/'.$id;
					case 'add':
					return $url_first.'warranty/video/add/'.$id;
					default:
					return $url_first.'warranty/video';
				}
				return $url_first.'warranty/video';

			}
			return $url_first.'warranty/return';
			break;


			case 'request_products':
			switch ($view){
				case 'import_products':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'edit':
					return $url_first.'request_products/import_products/edit/'.$id;
					case 'add':
					return $url_first.'request_products/import_products/add/'.$id;
					default:
					return $url_first.'request_products/import_products';
				}
			}
			return $url_first.'request_products/import_products';
			break;


			case 'packages':
			switch ($view){
				case 'package':
					return $url_first.'packages/package';
				case 'statistic':
					return $url_first.'packages/statistic';
				case 'excel':
				$id =  isset($array_params['id'])?$array_params['id']: '';
				switch ($task){
					case 'import_excel':
					return $url_first.'packages/excel/import_excel';
					case 'download_file':
					return $url_first.'packages/excel/download_file';
					default:
					return $url_first.'packages/excel';
				}
				return $url_first.'packages/refund';
			}
			return $url_first.'packages/package';
			break;



			case 'print_history':
			switch ($view){
				case 'history':
					return $url_first.'print_history/history';
			}
			return $url_first.'print_history/history';
			break;
			

			case 'news':
			switch ($view){
				case 'news':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$ccode =  isset($array_params['ccode'])?$array_params['ccode']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				$amp =  isset($array_params['amp'])?$array_params['amp']: '';
				$suf = $amp?'.amp':'.html';
					//return $url_first.$ccode.'/'.$code.'-n'.$id.$suf;
				return $url_first.$code.'-n'.$id.$suf;

				case 'cat':
				$page =  isset($array_params['page'])?$array_params['page']: '';
				$cid =  isset($array_params['cid'])?$array_params['cid']: '';
				$ccode =  isset($array_params['ccode'])?$array_params['ccode']: '';
				$amp =  isset($array_params['amp'])?$array_params['amp']: '';
				$suf = $amp?'.amp':'.html';
				return $url_first.$ccode.'-kn'.$cid.$suf;
				case 'home':
				return $url_first.'tin-tuc.html';
				case 'search':

				$keyword  = isset($array_params['keyword'])?$array_params['keyword']:'';
				$url = URL_ROOT.'tim-kiem-tin-tuc';
				if($keyword){
					$url .= '/'.$keyword.'.html';
				}
				return $url;	
				default:
				return $url_first.$url;
			}
			break;
			case 'warehousessss':
			switch ($view){
				case 'warehouses':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				if($id){
					return $url_first.'warehouses/edit/'.$id;
				}
				return $url_first.'warehouses';

				case 'supplier':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				if($id){
					return $url_first.'supplier/edit/'.$id;
				}
				return $url_first.'supplier';

				case 'bill':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				$task =  isset($array_params['task'])?$array_params['task']: '';
				if($id){
					switch ($task){
						case 'print':
						return $url_first.'warehouses/bill/print/'.$id;
						default:
						return $url_first.'warehouses/bill/edit/'.$id;
					}
				}
				return $url_first.'warehouses/bill';
				break;

				case 'bill_detail':
				$product_id =  isset($array_params['product_id'])?$array_params['product_id']: '';
				return $url_first.'warehouses/bill_detail/'.$product_id;
				break;

				case 'check':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				$task =  isset($array_params['task'])?$array_params['task']: '';
				if($id){
					switch ($task){
						case 'print':
						return $url_first.'warehouses/check/print/'.$id;
						default:
						return $url_first.'warehouses/check/edit/'.$id;
					}

				}
				return $url_first.'warehouses/check';
				break;

				case 'positions_categories':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				$task =  isset($array_params['task'])?$array_params['task']: '';
				if($id){
					switch ($task){
						case 'print':
						return $url_first.'warehouses/positions_categories/print/'.$id;
						default:
						return $url_first.'warehouses/positions_categories/edit/'.$id;
					}
				}
				return $url_first.'warehouses/positions_categories';
				break;

				case 'positions_bill':

				$code =  isset($array_params['code'])?$array_params['code']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				$task =  isset($array_params['task'])?$array_params['task']: '';
				if($id){
					switch ($task){
						case 'print':
						return $url_first.'warehouses/positions_bill/print/'.$id;
						default:
						return $url_first.'warehouses/positions_bill/edit/'.$id;
					}
				}

				switch ($task){
					case 'add':
					return $url_first.'warehouses/positions_bill/add';
				}

				return $url_first.'warehouses/positions_bill';
				break;

			}

			case 'tutorial':
			switch ($view){
				case 'tutorial':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				return $url_first.$code.'-hd'.$id.'.html';					
			}
			break;
			case 'images':
			switch ($view){
				case 'images':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$ccode =  isset($array_params['ccode'])?$array_params['ccode']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';

				return $url_first.$ccode.'/'.$code.'-im'.$id.'.html';
				case 'home':
				return $url_first.'hinh-anh.html';
				case 'search':

				$keyword  = isset($array_params['keyword'])?$array_params['keyword']:'';

				$url = URL_ROOT.'tim-kiem';
				if($keyword){
					$url .= '/'.$keyword.'.html';
				}
				return $url;	
				default:
				return $url_first.$url;
			}
			break;

			case 'albums':
			switch ($view){
				case 'home':
				return $url_first.'bo-suu-tap.html';
			}
			break;

			case 'certifications':
			switch ($view){
				case 'home':
				return $url_first.'giai-thuong.html';
			}
			break;
			
			case 'services':
			switch ($view){
				case 'cat':
				$ccode =  isset($array_params['ccode'])?$array_params['ccode']: '';
				$cid =  isset($array_params['cid'])?$array_params['cid']: '';
				$amp =  isset($array_params['amp'])?$array_params['amp']: '';
				$suf = $amp?'.amp':'.html';
				return $url_first.$ccode.'-csv'.$suf;	
				case 'services':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				$ccode =  isset($array_params['ccode'])?$array_params['ccode']: '';
				$amp =  isset($array_params['amp'])?$array_params['amp']: '';
				$suf = $amp?'.amp':'.html';
				return $url_first.$code.'-sv'.$id.$suf;
				case 'home':
				return $url_first.'dich-vu.html';
			}
			break;	

			case 'search':
			$keyword  = isset($array_params['keyword'])?$array_params['keyword']:'';
			$url = URL_ROOT.'tim-kiem';
			if($keyword){
				$url .= '/'.$keyword.'.html';
			}
			return $url;
			case 'aq':
			switch ($view){
				case 'aq':
				if($task == 'send_question'){
					return $url_first.'gui-cau-hoi.html';
				} else{
					$code =  isset($array_params['code'])?$array_params['code']: '';
					$ccode =  isset($array_params['ccode'])?$array_params['ccode']: '';
					$id =  isset($array_params['id'])?$array_params['id']: '';
					return $url_first.$code.'-q'.$id.'.html';
				}

				case 'cat':
				$ccode =  isset($array_params['ccode'])?$array_params['ccode']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				return $url_first.$ccode.'-cq.html';

				case 'home':
				return $url_first.'hoi-dap.html';
				default:
				return $url_first.$url;
			}
			break;					
			case 'contents':
			switch ($view){
				case 'cat':
				$ccode =  isset($array_params['ccode'])?$array_params['ccode']: '';
				//return $url_first.'danh-muc/'.$ccode.'.html';
				return $url_first.$ccode.'.html';
				case 'contents':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$ccode =  isset($array_params['ccode'])?$array_params['ccode']: '';
				return $url_first.FSRoute::get_name_encode('ct',$lang).'-'.$code.'.html';
			}
			case 'landingpages' :
			switch ($view) {
				case 'landingpages' :
				$code = isset ( $array_params ['code'] ) ? $array_params ['code'] : '';
				$id = isset ( $array_params ['id'] ) ? $array_params ['id'] : '';
				return $url_first  . $code . '-ld' . $id . '.html';
				return $url;
			}
			break;						
			case 'videos' :
			switch ($view) {
				case 'home' :
				return $url_first . 'video.html';
				case 'cat' :
				$ccode = isset ( $array_params ['ccode'] ) ? $array_params ['ccode'] : '';
				$id = isset ( $array_params ['cid'] ) ? $array_params ['cid'] : '';
				return $url_first . $ccode . '-cv' . $id . '.html';
				case 'video' :
				$code = isset ( $array_params ['code'] ) ? $array_params ['code'] : '';
				///		$ccode = isset ( $array_params ['ccode'] ) ? $array_params ['ccode'] : '';
				$id = isset ( $array_params ['id'] ) ? $array_params ['id'] : '';
				return $url_first  . $code . '-vd' . $id . '.html';
				case 'search' :
				$keyword = isset ( $array_params ['keyword'] ) ? $array_params ['keyword'] : '';
				$url = URL_ROOT . 'tim-kiem-video';
				if ($keyword) {
					$url .= '/' . $keyword . '.html';
				}
				return $url;
			}
			break;
			case 'partners':
			return $url_first.'doi-tac.html';
			break;
			case 'department':
			return $url_first.'he-thong-cua-hang.html';
			break;
			case 'contact':
			return $url_first.'lien-he.html';
			switch ($view){
				case 'contact':
				$code =  isset($array_params['code'])?$array_params['code']: '';
				$id =  isset($array_params['id'])?$array_params['id']: '';
				return $url_first.$code.'-c'.$id.'.html';

				case 'services_centers':
				return 'trung-tam-bao-hanh.html';

				default:
				return $url_first.$url;
			}

			case 'sitemap':
			return $url_first.'site-map.html';


			case 'notfound':				
			return $url_first.'404.html';			
			break;		
			
			default:

			// echo '1';die;
			$module =  isset($array_params['module'])?$array_params['module']: '';
			$view =  isset($array_params['view'])?$array_params['view']: '';
			$code =  isset($array_params['code'])?$array_params['code']: '';
			$id =  isset($array_params['id'])?$array_params['id']: '';
			$task =  isset($array_params['task'])?$array_params['task']: '';

			if($id){
				switch ($task){
					case 'print':
					return $url_first.$module.'/'.$view.'/print/'.$id;
					case 'revoke':
					return $url_first.$module.'/'.$view.'/revoke/'.$id;
					case 'edit':
					return $url_first.$module.'/'.$view.'/edit/'.$id;
					default:
					return $url_first.$module.'/'.$view.'/edit/'.$id;
				}
			}

			switch ($task){
				case 'add':
				return $url_first.$module.'/'.$view.'/add';
			}

			return $url_first.$module.'/'.$view;

			break;
			return URL_ROOT.$url;
		}
	}
	/*
	 * get real url from virtual url
	 */
	function deURL($url){
		if(!IS_REWRITE)
			return $url;
		return $url;
		if(strpos($url,URL_ROOT_REDUCE) !== false){
			$url =  substr($url,strlen(URL_ROOT_REDUCE));
		}
		if($url == 'news.html')
			return 'index.php?module=news&view=home&Itemid=1';
		if(strpos($url,'news-page') !== false){
			$f = strpos($url,'news-page')+9;
			$l = strpos($url,'.html');
			$page = intval(substr($url,$f,($l-$f)));
			return "index.php?module=news&view=home&page=$page&Itemid=1"; 
		}
		$array_url = explode('/',$url);
		$module = isset($array_url[0]) ? $array_url[0] : '';
		switch ($module){
			case 'news':
				// if cat
			if(preg_match('#news/([^/]*)-c([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s',$url,$arr)){
				return "index.php?module=news&view=cat&id=".@$arr[2]."&Itemid=".@$arr[3].'&page='.@$arr[5];
			}
				// if article
			if(preg_match('#news/detail/([^/]*)-i([0-9]*)-it([0-9]*).html#s',$url,$arr)){
				return "index.php?module=news&view=news&id=".@$arr[2]."&Itemid=".@$arr[3];
			}
			case 'companies':
			$str_continue   = ($module = isset($array_url[1])) ? $array_url[1] : '';
			if($str_continue == 'register.html')
				return "index.php?module=companies&view=company&task=register&Itemid=5";
			if(preg_match('#category-id([0-9]*)-city([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s',$str_continue,$arr)){
				if(isset($arr[5]))
					return "index.php?module=companies&view=category&id=".@$arr[1]."&city=".@$arr[2]."&Itemid=".@$arr[3]."&page=".@$arr[5];
				else 
					return "index.php?module=companies&view=category&id=".@$arr[1]."&city=".@$arr[2]."&Itemid=".@$arr[3];
			}	
			default:
			return $url;
		}
		
	}
	function get_home_link(){
		$lang = isset($_SESSION['lang']) ? $_SESSION['lang']: 'vi';
		if($lang == 'vi'){
			return URL_ROOT;
		}else{
			return URL_ROOT.'en';
		}
	}	
	/*
	 * Dịch ngang
	 */
	function change_link_by_lang($lang,$link = ''){
		$module = FSInput::get('module');
		$view = FSInput::get('view',$module);
		if(!$module || ($module == 'home' && $view == 'home')){
			if($lang == 'en'){
//				return URL_ROOT;
			}else{
				return URL_ROOT.'vi';
			}
		}
		switch($module){

			case 'contents':
			switch ($view){	
				case 'contents':
				$code =  FSInput::get('code');
				$record = FSRoute::trans_record_by_field($code,'alias','fs_contents',$lang,'id,alias,category_alias');
				if(!$record)
					return ;
				$url = URL_ROOT.FSRoute::get_name_encode('ct',$lang).'-'.$record -> alias;
				return $url.'.html';
				return $url;
			}
			break;
			default:
			$url =  URL_ROOT.'ce-about-digiworld';
			return $url.'.html';
		}
	}
	function get_record_by_id($id,$table_name,$lang,$select){
		if(!$id)
			return;
		if(!$table_name)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$table_name = $fs_table->getTable ( $table_name );
		
		$query = " SELECT ".$select."
		FROM ".$table_name."
		WHERE id = $id ";
		
		global $db;
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	}
	/*
	 * Lấy bản ghi dịch ngôn ngữ 
	 */
	function trans_record_by_field($value,$field = 'alias',$table_name,$lang,$select = '*'){
		if(!$value)
			return;
		if(!$table_name)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$table_name_old = $fs_table->getTable ( $table_name );
		
		$query = " SELECT id
		FROM ".$table_name_old."
		WHERE ".$field." = '".$value."' ";
		
		global $db;
		$sql = $db->query($query);
		$id = $db->getResult();
		if(!$id)
			return;
		$query = " SELECT ".$select."
		FROM ".$fs_table->translate_table ( $table_name)."
		WHERE id = '".$id."' ";
		global $db;
		$sql = $db->query($query);
		$rs = $db->getObject();
		return $rs;
	}
	/*
	 * Dịch từ field -> field ( tìm lại id rồi dịch ngược)
	 */
	function translate_field($value,$table_name,$field = 'alias'){
		
		if(!$value)
			return;
		if(!$table_name)
			return;
		$fs_table = FSFactory::getClass ( 'fstable' );
		$table_name_old = $fs_table->getTable ( $table_name );
		
		$query = " SELECT id
		FROM ".$table_name_old."
		WHERE $field = '".$value."' ";
		global $db;
		$sql = $db->query($query);
		$id = $db->getResult();
		if(!$id)
			return;
		$query = " SELECT ".$field."
		FROM ".$fs_table->translate_table ( $table_name)."
		WHERE id = '".$id."' ";
		global $db;
		$sql = $db->query($query);
		$rs = $db->getResult();
		return $rs;
	}
}	