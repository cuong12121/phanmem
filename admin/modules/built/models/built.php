<?php 
	class BuiltModelsBuilt extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 40;
			$this -> view = 'built';
			$this -> table_name = 'fs_built';
			$this->type = 'products';
			$this->table_category = 'fs_' . $this->type . '_categories';
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
		
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
			}
			
			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND a.created_time >=  "'.$date_new.'" ';
				}
			}
			
			// to
			if(isset($_SESSION[$this -> prefix.'text1']))
			{
				$date_to = $_SESSION[$this -> prefix.'text1'];
				if($date_to){
					$date_to = $date_to . ' 23:59:59';
					$date_to = strtotime($date_to);
					$date_new = date('Y-m-d H:i:s',$date_to);
					$where .= ' AND a.created_time <=  "'.$date_new.'" ';
				}
			}
			
			// idpro
			if(isset($_SESSION[$this -> prefix.'text2']))
			{
				$pro_id = $_SESSION[$this -> prefix.'text2'];
				$pro_id  = intval($pro_id );
				if($pro_id){
					$where .= ' AND a.products_id =  '.$pro_id ;
				}
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY id DESC ";
			
			
//			if(isset($_SESSION[$this -> prefix.'filter0'])){
//				$filter = $_SESSION[$this -> prefix.'filter0'];
//				if($filter){
//					$where .= ' AND b.id =  "'.$filter.'" ';
//				}
//			}
			
//			if(isset($_SESSION[$this -> prefix.'filter1'])){
//				$filter = $_SESSION[$this -> prefix.'filter1'];
//				if($filter){
//					$where .= ' AND a.user_id =  "'.$filter.'" ';
//				}
//			}
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$filter = (int)$filter - 1;
					$where .= ' AND a.status =  "'.$filter.'" ';
				}
			}
			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					$where .= ' AND a.order_type_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					if(strpos($keysearch, 'DH') === 0){
						$keysearch_id = str_replace('DH','', $keysearch);
						$keysearch_id = (int)$keysearch_id;
					}
					$where .= " AND ( a.id LIKE '%".$keysearch."%' OR username LIKE  '%".$keysearch."%' OR sender_name LIKE  '%".$keysearch."%' 
								OR sender_email LIKE  '%".$keysearch."%' OR recipients_name LIKE  '%".$keysearch."%' OR sender_telephone LIKE  '%".$keysearch."%' ";
					if(isset($keysearch_id))
						$where .= "	OR a.id LIKE '%".$keysearch_id."%' ";
						
					$where .= "	)"; 
				}
			}
			
			$query = " SELECT a.*
						  FROM fs_built AS a  
						   WHERE 1=1 
						   AND is_temporary = 0 "
						  .$where .$ordering;
						
			return $query;
		}

		function get_categories_tree() {
			global $db;
			$sql = " SELECT id, name,list_parents, parent_id AS parent_id 
					FROM " . $this->table_category;
			$db->query ( $sql );
			$categories = $db->getObjectList ();
			
			$tree = FSFactory::getClass ( 'tree', 'tree/' );
			$rs = $tree->indentRows ( $categories, 1 );
			return $rs;
		}
		function get_data_order(){
			$id = FSInput::get('id',0,'int');
			global $db;
			$query = "  SELECT a.*,b.name as product_name, b.alias as product_alias,b.category_alias
					FROM fs_built_items AS a
					INNER JOIN fs_products AS b on a.product_id = b.id
					WHERE
						a.order_id = $id
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function ajax_get_products_related(){
			$news_id = FSInput::get('product_id',0,'int');
			$category_id = FSInput::get('category_id',0,'int');
			$categories_filter = FSInput::get('categories_filter',0,'int');
		
			$keyword = FSInput::get('keyword');
			$where = ' WHERE 1 = 1 ';
			if($category_id){
				$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
			}elseif($categories_filter){
				$where .= ' AND (category_id_wrapper LIKE "%,'.$categories_filter.',%"	) ';
			}
			
			$where .= " AND ( name LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' OR code LIKE '%".$keyword."%' )";
			$query_body = ' FROM fs_products '.$where;
			$ordering = " ORDER BY created_time DESC , id DESC ";
			$query = ' SELECT id,price,category_id,name,category_name '.$query_body.$ordering.' LIMIT 30 ';
			
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_data_order_name($id){
			global $db;
			$query = "  SELECT a.*,b.name as product_name, b.alias as product_alias,b.category_alias
					FROM fs_built_items AS a
					INNER JOIN fs_products AS b on a.product_id = b.id
					WHERE
						a.order_id = $id
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function getOrderById(){
			$id = FSInput::get('id',0,'int');
			global $db;
			$query = "  SELECT *
					FROM fs_built AS a
					WHERE
						id = $id
					";
			$db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
//		function get_username(){
//			$id = FSInput::get('id',0,'int');
//			global $db;
//			$query = "  SELECT *
//					FROM fs_built AS a
//					WHERE
//						id = $id
//					";
//			$db->query($query);
//			$result = $db->getObject();
//			return $result;
//		}
//		
//		/*
//		 * get Cities
//		 */
//		function getCityNameById($city_id){
//			if(!$city_id)
//				return;
//			global $db;
//			$query = "SELECT name
//							FROM fs_cities 
//						WHERE id = $city_id
//						";
//			$db->query($query);
//			$rs = $db->getResult();
//			
//			return $rs;	
//		}
//		/*
//		 * get District
//		 */
//		function getDistrictById($district_id){
//			if(!$district_id)
//				return;
//			global $db;
//			$query = "SELECT name
//							FROM fs_districts
//						WHERE id = $district_id
//						";
//			$db->query($query);
//			$rs = $db->getResult();
//			
//			return $rs;	
//		}
		
		
		function cancel_order(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
			global $db;
			// get order_id to return
			$query = " SELECT * 
						FROM fs_built
						WHERE   
							id = $id 
							AND is_temporary = 0
					";	
			$db -> query($query);
			$order = $db -> getObject();
			
			$order_id = $order -> id;
			if(!$order_id)
				return false;
			if($order ->  status)
				return false;
				
				$row['status'] = 2;
				$row['edited_time'] = $time;
				$row['cancel_people'] = $cancel_people;
				$row['cancel_time'] = $time;
				$row['cancel_is_penalty'] = 1;
				$row['cancel_is_compensation'] = 1;
				$row['status_before_cancel'] = 0;
				$row['is_dispute'] = 0;
				$rs = $this -> _update($row, 'fs_built', ' id = '.$order -> id);
				return $rs;
			return;	
		}
		
		function finished_order(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
				
			global $db;
			// get order_id to return
			$query = " SELECT * 
						FROM fs_built
						WHERE   
							id = $id 
							AND is_temporary = 0
					";	
			$db -> query($query);
			$order = $db -> getObject();
			$order_id = $order -> id;
			if(!$order_id)
				return false;
			if($order ->  status >= 1)
				return false;
			if(!$order ->  status){	
				$row['status'] = 1;
				$row['edited_time'] = $time;
				$row['status_before_cancel'] = 0;
				$rs = $this -> _update($row, 'fs_built', ' id = '.$order -> id);
				if(!$rs)
					return false;
					
				// cộng tiền thanh toán vào bảng thành viên	
				$this -> add_money_to_member($order -> total_after_discount,$order -> user_id);				
				$this -> add_buy_number_to_product($order -> id);
				$this -> change_status_oder($order -> id);
				// send email after payment successful
				$this -> mail_to_buyer_after_successful($order -> id);
				return $rs;
			} 
			return;	
		}
		
		function mail_to_buyer_after_successful($id){
			if(!$id)
				return;
			global $db;
			
	         
			// get order
			$query = " SELECT * 
						FROM fs_built
						WHERE  id = '$id' 
							AND is_temporary = 0 
					";	
			$db -> query($query);
			$order = $db->getObject();
//			$estore = $this -> getEstore($order -> estore_id);
			$data = $this -> get_orderdetail_by_orderId($id);
			if(count($data)){
				$i = 0;
				$str_prd_ids = '';
				foreach($data as $item){
					if($i > 0)
						$str_prd_ids .= ',';
					$str_prd_ids .= $item -> product_id;
					$i ++;
				}
				$arr_product = $this -> get_products_from_orderdetail($str_prd_ids);
				
			}
				
			if(!$order)
				return;
			
				// send Mail()
				$mailer = FSFactory::getClass('Email','mail');
				
				$select = 'SELECT * FROM fs_config WHERE published = 1';
				global $db;
				$db -> query($select);
				$config = $db->getObjectListByKey('name');

				$admin_name  = $config['admin_name']-> value;
				$admin_email  = $config['admin_email']-> value;
				$mail_order_body  = $config['mail_order_successful_body']-> value;
				$mail_order_subject  = $config['mail_order_successful_subject']-> value;
				
//				$admin_name = $global -> getConfig('admin_name');
//				$admin_email = $global -> getConfig('admin_email');
//				$mail_order_body = $global -> getConfig('mail_order_successful_body');
//				$mail_order_subject = $global -> getConfig('mail_order_successful_subject');
//				echo $mail_order_body;
//				die;
				$mailer -> isHTML(true);
				$mailer -> setSender(array($admin_email,$admin_name));
				$mailer -> AddBCC('phamhuy@finalstyle.com','pham van huy');
				$mailer -> AddAddress($order->recipients_email,$order->recipients_name);
				$mailer -> setSubject($mail_order_subject); 
				
				// body
				$body = $mail_order_body;
				$body = str_replace('{name}', $order-> sender_name, $body);
				$body = str_replace('{ma_don_hang}', 'DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT), $body);
				
				// SENDER
				$sender_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
				$sender_info .= '	<tbody>'; 
			  	$sender_info .= ' <tr>';
				$sender_info .= '<td width="173px">Tên người đặt hàng </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'.$order-> sender_name.'</td>';
			  	$sender_info .= '</tr>';
			  	$sender_info .= '<tr>';
				$sender_info .= '<td>Giới tính</td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>';
				if(trim($order->sender_sex) == 'female')
					$sender_info .= "N&#7919;";
				else 
					$sender_info .= "Nam";
				$sender_info .= '</td>';
				$sender_info .= '</tr>';
				$sender_info .= '<tr>';
				$sender_info .= '<td>Địa chỉ  </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'.$order-> sender_address.'</td>';
			  	$sender_info .= '</tr>';
			  	$sender_info .= '<tr>';
				$sender_info .= '<td>Email </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'.$order-> sender_email.'</td>';
			  	$sender_info .= '</tr>';
			 	$sender_info .= '<tr>';
				$sender_info .= '<td>Điện thoại </td>';
				$sender_info .= '<td width="5px">:</td>';
				$sender_info .= '<td>'. $order-> sender_telephone .'</td>';
			  	$sender_info .= '</tr>';
				$sender_info .= ' </tbody>';
				$sender_info .= '</table>';
//				$sender_info .= 			'</td>';
				// end SENDER
				
				// RECIPIENT
				$recipient_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
				$recipient_info .= '	<tbody> ';
			  	$recipient_info .= '<tr>';
				$recipient_info .= '<td width="173px">Tên người nhận hàng</td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_name.'</td>';
			 	$recipient_info .= '</tr>';
			  	$recipient_info .= '<tr>';
				$recipient_info .= '<td>Giới tính </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>';
				if(trim($order->recipients_sex) == 'female')
					$recipient_info .= "N&#7919;";
				else 
					$recipient_info .= "Nam";
				$recipient_info .= 	'</td>';
			 	$recipient_info .= ' </tr>';
			 	$recipient_info .= ' <tr>';
				$recipient_info .= '<td>Địa chỉ  </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_address .'</td>';
			 	$recipient_info .= '</tr>';
				$recipient_info .= ' <tr>';
				$recipient_info .= '<td>Email </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_email .'</td>';
				$recipient_info .= '</tr>';
			  	$recipient_info .= '<tr>';
				$recipient_info .= '<td>Điện thoại </td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>'.$order-> recipients_telephone .'</td>';
			  	$recipient_info .= '</tr>';
			  	$recipient_info .= '<tr>';
			  	
				$recipient_info .= '<td>Thời gian đặt hàng</td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>';
					$hour = date('H',strtotime($order-> received_time));
					if($hour)
						$recipient_info .= $hour." h, ";
					$recipient_info .=  "ng&#224;y ". date('d/m/Y',strtotime($order-> received_time));
				$recipient_info .= '</td>';
			  	$recipient_info .= '</tr>';
			  	
			  	$recipient_info .= '<td>Địa điểm nhân hàng </b></td>';
				$recipient_info .= '<td width="5px">:</td>';
				$recipient_info .= '<td>';
				$recipient_info .=  $order->recipients_here ? 'Đặt lấy tại nhà hàng':'Nhận tại địa chỉ người nhận';
				$recipient_info .= '</td>';
			  	$recipient_info .= '</tr>';
			  	
			 	$recipient_info .= '</tbody>';
				$recipient_info .= '</table>';
				// end RECIPIENT
				
				
//				$body .= '<br/>';
//				$body .= '<div style="background: none repeat scroll 0 0 #55AEE7;color: #FFFFFF;font-weight: bold;height: 27px;padding-left: 10px;line-height: 25px; margin: 2px;">Chi tiết đơn hàng</div>';
//				$body .= '<div style="padding: 10px">';
				// detail
				$order_detail = '	<table width="964" cellspacing="0" cellpadding="6" bordercolor="\#CCC" border="1" align="center" style="border-style:solid;border-collapse:collapse;margin-top:2px">';
				$order_detail .= '		<thead style=" background: #E7E7E7;line-height: 12px;">';
				$order_detail .= '			<tr>';
				$order_detail .= '				<th width="30">STT</th>';
				$order_detail .= '				<th>T&#234;n s&#7843;n ph&#7849;m</th>';
				$order_detail .= '				<th width="117" >Giá</th>';
				$order_detail .= '				<th width="117">S&#7889; l&#432;&#7907;ng</th>';
				$order_detail .= '				<th width="117">T&#7893;ng gi&#225; ti&#7873;n</th>';
				$order_detail .= '			</tr>';
				$order_detail .= '		</thead>';
				$order_detail .= '		<tbody>';
				
//				$total_money = 0;
				$total_discount = 0;
				for($i = 0 ; $i < count($data); $i ++ ){
					$item = $data[$i];
//					$link_view_product = FSRoute::_('index?module=products&view=product&ename='.@$estore->estore_url.'&id='.$item->product_id.'&code='.@$arr_product[$item->product_id] -> alias.'&Itemid=6');
					$link_view_product = FSRoute::_('index.php?module=products&view=product&pcode='.@$arr_product[$item->product_id] -> alias.'&id='.$item->product_id.'&ccode='.@$arr_product[$item->product_id] ->category_alias.'&Itemid=5');
//					$total_money += $item -> total;
//					$total_discount += $item -> discount * $item -> count;

					$order_detail .= '				<tr>';
					$order_detail .= '					<td align="center">';
					$order_detail .= '						<strong>'.($i+1).'</strong><br/>';
					$order_detail .= '					</td>';
					$order_detail .= '					<td> ';
					$order_detail .= '						<a href="'.$link_view_product.'">';
					$order_detail .= 							@$arr_product[$item -> product_id] -> name;
					$order_detail .= '						</a> ';
					$order_detail .= '					</td>';
										
										//		PRICE 	
					$order_detail .= '					<td> ';
					$order_detail .= '						<strong>';
					$order_detail .= 							format_money($item -> price);
					$order_detail .= '						</strong> VND';
					$order_detail .= '					</td>';
					$order_detail .= '					<td> ';
					$order_detail .= '						<strong>';
					$order_detail .= 							$item -> count?$item -> count:0;
					$order_detail .= '						</strong>';
					$order_detail .= '					</td>';
					$order_detail .= '					<td> ';
					$order_detail .= '						<span >';
					$order_detail .= 							format_money($item -> total);
					$order_detail .= '						</span> VND';
					$order_detail .= '					</td>';
					$order_detail .= '				</tr>';
				}
				$order_detail .= '				<tr>';
				$order_detail .= '					<td colspan="4"  align="right"><strong>Tổng:</strong></td>';
				$order_detail .= '					<td ><strong >'.format_money($order -> total_before_discount).'</strong> VND</td>';
				$order_detail .= '				</tr>';
				if($order -> payment_method){
					$order_detail .= '				<tr>';
					$order_detail .= '					<td colspan="4"  align="right"><strong>Giảm giá (khi mua qua address):</strong></td>';
					$order_detail .= '					<td ><strong >'.format_money($order -> total_before_discount - $order -> total_after_discount).'</strong> VND</td>';
					$order_detail .= '				</tr>';
					$order_detail .= '				<tr>';
					$order_detail .= '					<td colspan="4"  align="right"><strong>Thành tiền:</strong></td>';
					$order_detail .= '					<td ><strong >'.format_money($order -> total_after_discount).'</strong> VND</td>';
					$order_detail .= '				</tr>';
				}
				$order_detail .= '		</tbody>';
				$order_detail .= '	</table>	';
				
//				$body .= '	<br/><br/>	';
//				$body .= '<div style="padding: 10px;font-weight: bold;margin-bottom: 30px;">';
//				$body .= '<div>Ch&acirc;n th&agrave;nh c&#7843;m &#417;n!</div>';
//				$body .=  '<div> '.$site_name.' (<a href="'.URL_ROOT.'" target="_blank">'.URL_ROOT.'</a>)</div>';
//				$body .= '	</div>	';
//				$body .= '</div>';
				$body = str_replace('{thong_tin_nguoi_dat}', $sender_info, $body);
				$body = str_replace('{thong_tin_nguoi_nhan}', $recipient_info, $body);
				$body = str_replace('{thong_tin_don_hang}', $order_detail, $body);
				
				$mailer -> setBody($body);
				if(!$mailer ->Send())
					return false;
				return true;
		}
		
		
		
		/*
		 * Add điểm vào bảng thành viên
		 */
		function add_money_to_member($money,$user_id){
			if(!$money || !$user_id)
				return;
			$sql = 'UPDATE fs_members SET money = money + '.$money.'
						WHERE id = '.$user_id	;
			global $db;
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		
		/*
		 * Thêm số lần mua vào bảng sản phẩm
		 */
		function add_buy_number_to_product($oder_id){
			$order_items = $this -> get_records('order_id = '.$oder_id,'fs_built_items','*');
			if(!count($order_items))
				return;
			global $db;
			foreach($order_items as $item){
				$sql = 'UPDATE fs_products SET sale_count = sale_count + '.$item -> count.'
						WHERE id = '.$item ->product_id	;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
			} 
		}
		function change_status_oder($oder_id){
			global $db;
				$sql = 'UPDATE fs_built_items SET status = 1
						WHERE order_id = '.$oder_id	;
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
		}
		/*
		 * Repay the money after cancel order for guest
		 */
		function repay($money,$guest_username,$str_penaty = ''){
			// SAVE FS_MEMBERS
			// add money 
			global $db;
			if(!$guest_username)
				return false;
			$sql = "UPDATE fs_members SET `money` = money + ".$money." WHERE username = '".$guest_username."' ";
			// $db->query($sql);
			$rows = $db->affected_rows($sql);
			if(!$rows)
				return false;
				
			// SAVE HISTORY	
			$time = date("Y-m-d H:i:s");
			$row3['money'] = $money;
			$row3['type'] = 'deposit';
			$row3['username'] = $guest_username;
			$row3['created_time'] = $time;
			$row3['description'] = $str_penaty;
			$row3['service_name'] = 'Trả lại tiền';
			if(!$this -> _add($row3, 'fs_history'))
				return false;
		}
		
		
		function pay_penalty(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
				
			$row['edited_time'] = $time;
			$row['cancel_is_penalty'] = 1;
			$rs = $this -> _update($row, 'fs_built', ' id = '.$id. ' AND status = 6 ');
			return $rs;
		}
		function pay_compensation(){
			$cancel_people = $_SESSION['ad_username'];
			$id = FSInput::get('id',0,'int');
			$time = date("Y-m-d H:i:s");
			if(!$id)
				return;
				
			$row['edited_time'] = $time;
			$row['cancel_is_compensation'] = 1;
			$rs = $this -> _update($row, 'fs_built', ' id = '.$id. ' AND status = 6 ');
			return $rs;
		}
		function get_orderdetail_by_orderId($order_id){
			if(!$order_id)
				return;
			$session_id = session_id();	
			$query = " SELECT a.*
						FROM fs_built_items AS a
						WHERE  a.order_id = $order_id ";
			global $db;
			$db -> query($query);
			return $rs = $db->getObjectList();
		}
		
		function get_products_from_orderdetail($str_product_ids){
			if(!$str_product_ids)
				return false;
			$query = " SELECT a.*
						FROM fs_products AS a
						WHERE id IN ($str_product_ids) ";
			global $db;
			$db -> query($query);
			$products = $db->getObjectListByKey('id');
			return $products;
		}
		
					function get_member_info($start = 0,$end = 0){
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
			$sql = $db->query_limit_export($query,$start,$end);
			$result = $db->getObjectList();
			if(	isset($_POST['filter'])){
				$_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
			}
		
			return $result;
		}
		function getConfig()
		{
			global $db;
			$query = " SELECT *
						  FROM 
						  	fs_config
						  WHERE published = 1
						  ORDER BY ordering, id 
						 ";
			if(!$query)
				return array();
				
			$sql = $db->query($query);
			$result = $db->getObjectListByKey('name');
			
			return $result;
		}

		function ajax_change_count_item() {
			$order_id = FSInput::get('order_id');
			$count = FSInput::get('count');
			$id = FSInput::get('id');

			$price = FSInput::get('price');
			
			if(!$id || !$count){
				return 0;
			}

			$row = array();
			$row['price'] = $price;
			$row['unit'] = FSInput::get('unit');
			$row['note'] = FSInput::get('note');
			$row['count'] = (int)$count;
			$row['total'] = $price * (int)$count;

			$rs = $this -> _update($row, 'fs_built_items', ' id = '.$id);
			// printr($row);
			// die;
			if($rs){
				$row2 = array();
				$items = $this->get_records('order_id = '. $order_id,'fs_built_items');
				$total = 0;
				foreach ($items as $item) {
					$total += $item->total;
				}

				$row2['total_before_discount'] = $total;
				$row2['total_after_discount'] = $total;

				$rs2 = $this -> _update($row2, 'fs_built', ' id = '.$order_id);
				// die;
			}

			return $rs;

		}

		function save($row = array(), $use_mysql_real_escape_string = 1) {
			
			$id = FSInput::get ( 'id', 0, 'int' );
			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			// $row ['warehouse_id'] = FSInput::get('warehouse_id');
			// $row ['channel'] = FSInput::get('channel');
			// $row ['card_rank'] = FSInput::get('card_rank');
			// $row ['liabilities'] = FSInput::get('liabilities');
			$row ['name'] = FSInput::get('name');
			$row ['sender_name'] = FSInput::get('sender_name');
			$row ['sender_telephone'] = FSInput::get('sender_telephone');
			$row ['sender_address'] = FSInput::get('sender_address');
			$row ['sender_email'] = FSInput::get('sender_email');
			// $row ['sender_comments'] = FSInput::get('sender_comments');
			$row ['created_time'] = date('Y-m-d H:i:s');
			// $row ['payment_method'] = FSInput::get('payment_method');
			// $row ['old_debt'] = FSInput::get('old_debt');
			// $row ['single_match_code'] = FSInput::get('single_match_code');
			// $row ['referral_code'] = FSInput::get('referral_code');
			// $row ['delivery_date'] = date('Y-m-d',strtotime(FSInput::get('delivery_date')));
			// $row ['earliest_time'] = FSInput::get('earliest_time',date('H:i'));
			// $row ['latest_time'] = FSInput::get('latest_time',date('H:i'));
			$row ['is_temporary'] = 0;

			// printr($row);
			$id = parent::save ( $row );
			

			$row2 = array();
			if($id){
				///save new
				$get_proid = array ();
				for($i = 0; $i < 20; $i ++) {
	                $get_proid[] = FSInput::get ( 'pro_id_' . $i );
	                if (! $get_proid) {
	    				continue;
	    			}
	    		}
	    		$get_proid = array_filter($get_proid);
	    		$row2['products_id'] = ','.implode(',', $get_proid).',';
	    		$u = $this->_update($row2, 'fs_built', ' id=' . $id);

	    		$total_order = 0;
	    		for($i = 0; $i < 20; $i ++) {
	    			$row3 = array();
	    			$row3['order_id']  = $id;
	    			$row3['product_id']  = FSInput::get ( 'pro_id_' . $i );
	    		//	$row3['price']  = FSInput::get ( 'price_' . $i );
	    			// $row3['unit']  = FSInput::get ( 'unit_' . $i );
	    			// $row3['note']  = FSInput::get ( 'note_' . $i );
	    			$row3['count']  = FSInput::get ( 'count_' . $i );
	    			if(! $row3['count']){
	    				$row3['count']  = 1;
	    			}
	    			// $row3['total'] = $row3['price'] * $row3['count'];
	    			if(! $row3['product_id'] ){
	    				continue;
	    			}
	    			$total_order = $total_order + $row3['total'];
	    			$rs = $this->_add ( $row3, 'fs_built_items', 0 );
	    		}

	    		//save changes
	    		$get_proid_change = array ();
				for($i = 0; $i < 20; $i ++) {
	                $get_proid_change[] = FSInput::get ( 'change_pro_id_' . $i );
	                if (! $get_proid_change) {
	    				continue;
	    			}
	    		}

	    		$get_proid_change = array_filter($get_proid_change);
	    		// echo $row2['products_id'];
	    		// echo "<pre>";
	    		// print_r($get_proid_change);
	    		// die;
	    		$row4['products_id'] = $row2['products_id'] . implode(',', $get_proid_change).',';
	    		// echo $row4['products_id'];
	    		// die;
	    		$u2 = $this->_update($row4, 'fs_built', ' id=' . $id);

	    		//total money
	    		$total_money = 0;
	    		$data_money = $this->get_total_money($id);

	    		if(!empty($data_money)){
	    			foreach ($data_money as $key => $val) {
	    				$total_money += $val -> total ;
	    			}
	    			
		    		$row5['total_before_discount'] = $total_money;
		    		$row5['total_after_discount'] = $total_money;
		    		$u3 = $this->_update($row5, 'fs_built', ' id=' . $id);
		    	}
	    		
			}
			if (!isset($id)) {
				Errors::setError ( 'Not save' );
				return false;
			}
			
			return $id;
		}

		function get_total_money($id){
			global $db;
			$query = "  SELECT id, total
						FROM 
						fs_built_items WHERE order_id = $id ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function ajax_remove_order_item() {
			$id = FSInput::get('id',0,'int');
			if (!$id)
				return false;
			global $db;
			$data =  $this->get_record('id = '. $id,'fs_built_items');
			$order_id = $data->order_id;
			// remove in database
			$sql = " DELETE FROM fs_built_items
						WHERE id = $id";
			$db->query ( $sql );
			$rows = $db->affected_rows ();


			$row2 = array();
			$items = $this->get_records('order_id = '. $order_id,'fs_built_items');
			$total = 0;
			foreach ($items as $item) {
				$total += $item->total;
				
			}

			$row2['total_before_discount'] = $total;
			$row2['total_after_discount'] = $total;
			
			$rs2 = $this -> _update($row2, 'fs_built', ' id = '.$order_id);
			return $rows;
		}

		

		function get_product($id){
			global $db;
			$query = " SELECT id, price,unit
						  FROM 
						  	fs_products AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

		function get_order_items($id) {
			global $db;
			$query = "  SELECT a.*,b.name as product_name, b.alias as product_alias,b.category_alias
					FROM fs_built_items AS a
					INNER JOIN fs_products AS b on a.product_id = b.id
					WHERE
						a.order_id = $id
					";
			$db->query($query);
			$result = $db->getObjectList();
			return $result;
		}




		
		function get_products_related($product_related){
			if(!$product_related)
					return;
			$query   = " SELECT id, name 
						FROM fs_products
						WHERE id IN (0".$product_related."0) 
						 ORDER BY POSITION(','+id+',' IN '0".$product_related."0')
						";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		/*
		 * select in category of home
		 */
		function get_warehouse()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_warehouse AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_payment_method()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	fs_payment_method AS a
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}

		function get_ajax_search($limit = 15){
	        global $db;
	        $where[1] = '';
	        $where[2] = '';
	        $where[3] = '';
	        $where[4] = '';
	        $query = FSInput::get('query', '');
	        if(!$query)
	      	    return;
		      
		      $where[1] .= " AND name like  '%" . $query . "%'";			
					$where[2] .= " AND tags like  '%" . $query . "%'";

					$arr_tags = explode ( ' ', $query );
					$total_tags = count ( $arr_tags );
					if ($total_tags) {
						$where[3] .= ' AND (';
						$j = 0;
						for($i = 0; $i < $total_tags; $i ++) {
							$item = trim ( $arr_tags [$i] );
							if ($item) {
								if ($j > 0)
									$where[3] .= ' AND ';
									$where[3] .= " `name` like '%" . $item . "%'";
								$j ++;
							}
						}
						 $where[3] .= ' ) ';
					}

					if ($total_tags) {
						$where[4] .= ' AND (';
						$j = 0;
						for($i = 0; $i < $total_tags; $i ++) {
							$item = trim ( $arr_tags [$i] );
							if ($item) {
								if ($j > 0)
									$where[4] .= ' OR ';
									$where[4] .= " `name` like '%" . $item . "%'";
									$where[4] .= " OR `tags` like '%" . $item . "%'";
								$j ++;
							}
						}
						 $where[4] .= ' ) ';
					}

				$list = array();
				for($i = 1; $i < 5; $i ++)	{				
					$sql_where = $where[$i];
						
		        $query = '  SELECT *
		                      FROM fs_products 
		                      WHERE published = 1  '.$sql_where.' 
		                      ORDER BY is_service ASC , ordering DESC
		                      LIMIT 8
		                      ';  
		                      	
		        $sql = $db->query($query);
					$result = $db->getObjectList();
					
					$list = array_merge($list,$result);					
				}
				return $this -> unique_array_objects($list);
		}

		function get_price_by_colors($record_id) {
			if (! $record_id)
				return;
			$limit = 10;
			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT *
			FROM " . $fs_table->getTable ( 'fs_products_price' ) . "
			WHERE record_id =  $record_id
			ORDER BY  price ASC
			";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObjectList ();
			return $result;
		}

		function get_price_by_extend($record_id, $group_id) {
			if (! $record_id)
				return;
			$limit = 10;
			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT *
			FROM " . $fs_table->getTable ( 'fs_products_price_extend' ) . "
			WHERE record_id =  $record_id AND group_extend_id = $group_id
			ORDER BY price ASC
			";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObjectList ();
			return $result;
		}

		function get_price_by_extend_group($record_id) {
			if (! $record_id)
				return;
			$limit = 10;
			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT DISTINCT group_extend_id, ground_extend_name
			FROM " . $fs_table->getTable ( 'fs_products_price_extend' ) . "
			WHERE record_id =  $record_id
			ORDER BY group_ordering ASC
			";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObjectList ();
			return $result;
		}
	}
?>
