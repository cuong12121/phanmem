<?php 
	class ProductsModelsApipd extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 100;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'booth_api';
			$this -> arr_img_paths = array(array('resized',370,247,'cut_image'),array('small',127,72,'cut_image'),array('large',600,315,'cut_image'));
			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );
			$this->img_folder = 'images/tags/' . $cyear . '/' . $cmonth . '/' . $cday;
			$this->check_alias = 0;
			$this->field_img = 'image';
			$this -> check_alias = 1;
			parent::__construct();
		}
		
		// 		dem so luong 1 san pham trong  model cuong
		
		function countRecordCode()
		{
		    global $db;
		    
		    $where = '';
		    
		    
		    
		    // 			lấy thời gian trong form post
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND created_at >=  "'.$date_new.'" ';
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
					$where .= ' AND created_at <=  "'.$date_new.'" ';
				}
			}
			
			if(!empty(FSInput::get('address'))){
			    
			    $address = FSInput::get('address');
			    
			    $where .= ' AND address =  "'.$address.'" ';
			    
			}
			
			
		    if(empty($_SESSION[$this -> prefix.'keysearch'])){
		        
		      //  trường hợp load trang mà không tìm theo ngày giờ
		      
		      if(empty($_SESSION[$this -> prefix.'text0']) && empty($_SESSION[$this -> prefix.'text1'])){
		        $time = 'SELECT created_at FROM booth_api WHERE 1=1 ORDER BY id DESC LIMIT 1';
			    
			    $time = $db->getObjectList($time);
			    
			    $time = $time[0]->created_at;
			    
			    $where .= ' AND created_at =  "'.$time.'" ';
			    
			    $query = 'SELECT * FROM booth_api WHERE 1=1'.$where.' AND code ="KLO" ORDER BY code DESC';
			    
		      }  
		      else{
		      
    		      $query = 'SELECT code FROM booth_api WHERE 1=1 AND code ="KLO"'.$where.' ORDER BY created_at DESC';
    		     
		      }
		        
		    }
		    else{
		        $search = trim($_SESSION[$this -> prefix.'keysearch']);
				if(!empty($search)){
				    
				    //  trường hợp load trang mà không tìm theo ngày giờ
    		        if(empty($_SESSION[$this -> prefix.'text0']) && empty($_SESSION[$this -> prefix.'text1'])){
        		        $time = 'SELECT created_at FROM booth_api WHERE 1=1 ORDER BY id DESC LIMIT 1';
        			    
        			    $time = $db->getObjectList($time);
        			    
        			    $time = $time[0]->created_at;
        			    
        			    $where .= ' AND created_at =  "'.$time.'" ';
        			    
        			 //   chỉ cần lấy thời gian là ngày cuối cùng để show dữ liệu ra
        			    
        			    $query = 'SELECT * FROM booth_api WHERE 1=1'.$where.' AND code ="KLO" ORDER BY code DESC';
        			    
        		      }
        		     else{
    				
    					$where .= ' AND code =  "'.$search.'"  OR name =  "'.$search.'" OR manager_staff =  "'.$search.'"';
    					
    					
    					$query = 'SELECT * FROM booth_api WHERE 1=1'.$where.' ORDER BY code DESC';
        		     }	
				}
		    }
		    
			$count = $db->getObjectList($query);

			return count($count);
		}
		
		function showAllShop(){
		    
		    global $db;
		    
		    $where = '';
		    
		    
		    
		     // 			lấy thời gian trong form post
			if(!empty($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND created_at >=  "'.$date_new.'" ';
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
					$where .= ' AND created_at <=  "'.$date_new.'" ';
				}
			}
			
			if(!empty(FSInput::get('address'))){
			    
			    $address = FSInput::get('address');
			    
			    $where .= ' AND address =  "'.$address.'" ';
			    
			}
			
			if(isset($_SESSION[$this -> prefix.'keysearch']))
			{
			    
				$search = trim($_SESSION[$this -> prefix.'keysearch']);
				
				if(!empty($search)){
				      //  trường hợp load trang mà không tìm theo ngày giờ thì load ngày cuối cùng
				    
				     if(empty($_SESSION[$this -> prefix.'text0']) && empty($_SESSION[$this -> prefix.'text1'])){
        		        $time = 'SELECT created_at FROM booth_api WHERE 1=1 ORDER BY id DESC LIMIT 1';
        			    
        			    $time = $db->getObjectList($time);
        			    
        			    $time = $time[0]->created_at;
        			    
        			    $query_add = ' AND created_at >=  "'.$time.'" ';
        			    
        			    $where .= ' AND address =  "'.$search.'"'.$query_add.' OR code =  "'.$search.'"'.$query_add.' OR name =  "'.$search.'"'.$query_add.' OR manager_staff =  "'.$search.'"'.$query_add;
        			  
				     }  
				     else{
				          $where .= ' AND code =  "'.$search.'" OR name =  "'.$search.'" OR manager_staff =  "'.$search.'"';
				     }
				     
				     
        			   
				}
				
			}
			
			if(empty($where)){
			    
			    $time = 'SELECT created_at FROM booth_api WHERE 1=1 ORDER BY id DESC LIMIT 1';
			    
			    $time = $db->getObjectList($time);
			    
			    $time = $time[0]->created_at;
			    
			    $where .= ' AND created_at =  "'.$time.'" ';
			    
			     $query = 'SELECT * FROM booth_api WHERE 1=1'.$where.' ORDER BY code DESC';
			}
			else{
			    $query = 'SELECT * FROM booth_api WHERE 1=1'.$where.' ORDER BY code DESC';
			}
		    
		    
		    
		 
		    
		    $list = $db->getObjectList($query);
		    
		    return $list;
		    
		    
		    
		}

		
		function setQuery()
		{
			// ordering
			$ordering = '';
			$where = "  ";
			
// 			lấy thời gian trong form post
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND created_at >=  "'.$date_new.'" ';
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
					$where .= ' AND created_at <=  "'.$date_new.'" ';
				}
			}
			
			
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_at DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_at DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
				}
			}
			$query = " 	   SELECT * 
						
						  FROM ".$this -> table_name." 
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}


		function save($row = array(), $use_mysql_real_escape_string = 1){
			$row['edited_time'] = date('Y-m-d H:i:s');
			$row['user_edit_id'] = $_SESSION['ad_userid'];
			$row['user_edit_name'] = $_SESSION['ad_username'];
			
			$record_id =  parent::save($row);
			
			return $record_id;
		}
		
		
	}
	
?>