<?php 
	class ProfitsModelsProfist_shop extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 50;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'fs_profits_shops';
			parent::__construct();
		}
		
		function setQuery()
		{
			$ordering = '';
			$where = " AND user_id = ".$_SESSION['ad_userid'];
			$query = "SELECT * FROM ".$this -> table_name." AS a WHERE 1=1 "  . $where. $ordering. " ";
			return $query;
		}


		function save($row = array(), $use_mysql_real_escape_string = 1) {
			$fsFile = FSFactory::getClass('FsFiles');
			$loi_nhuan = FSInput::get('loi_nhuan');
			$id = FSInput::get('id');

			if (! $this->remove_days($id)){		
			}
			if (! $this->save_exist_days($id)) {
			}
			$this->save_new_days( $id );

			
	
			

			$cyear = date ( 'Y' );
			$cmonth = date ( 'm' );
			$cday = date ( 'd' );
			$path = PATH_BASE.'files/profits/'.$cyear.'/'.$cmonth.'/'.$cday.'/';
			$path = str_replace('/', DS,$path);

	        $file_xlsx = $_FILES["file_xlsx"]["name"];
	
			if($file_xlsx){
				$file_xlsx_name = $fsFile -> upload_file("file_xlsx", $path ,100000000, '_'.time());
				if(!$file_xlsx_name){
					return false;
				}
				$row['file_xlsx'] = 'files/profits/'.$cyear.'/'.$cmonth.'/'.$cday.'/'.$file_xlsx_name;
			}

			

			$file_path = PATH_BASE.$row['file_xlsx'];
			$file_path = str_replace('/', DS,$file_path);

			if($id && $file_xlsx){
				require_once("../libraries/PHPExcel-1.8/Classes/PHPExcel.php");
				$objReader = PHPExcel_IOFactory::createReaderForFile($file_path);
				$objReader->setLoadAllSheets();
				$objexcel = $objReader->load($file_path);
				$data =$objexcel->getActiveSheet()->toArray('null',true,true,true);
				unset($heightRow);	
				$heightRow=$objexcel->setActiveSheetIndex()->getHighestRow();
				unset($j);
				for($j=2;$j<=$heightRow;$j++){
					$row2 = array();
					if(!$data[$j]['A']){
						continue;
					}
					$row2['title'] = trim($data[$j]['A']);
					$row2['money'] = trim($data[$j]['B']);
					$row2['record_id'] = $id;
					$this->_add($row2,'fs_profits_shops_cost');
				}
			}

			$chi_phi_khac = $this->get_record('record_id = '.$id,'fs_profits_shops_cost','SUM(money) as money');
			if(!empty($chi_phi_khac)){
				$row['loi_nhuan_thuc'] = $loi_nhuan - $chi_phi_khac->money;
				$row['chi_phi_khac'] = $chi_phi_khac->money;
			}
			$result_id = parent::save ($row);
			return $id;
		}


		
		function remove_days($record_id) {
			if (! $record_id)
				return true;
			$other_days_remove = FSInput::get('other_days',array(),'array');
			$str_other_days = implode(',',$other_days_remove);
			if ($str_other_days) {
				global $db;
				$sql = " DELETE FROM fs_profits_shops_cost
				WHERE record_id = $record_id AND id IN ($str_other_days)";
				$db->query ( $sql );
				$rows = $db->affected_rows ();
				
				return $rows;
			}
			return true;
		}
		

		function save_exist_days($id) {
			global $db;
	    	// EXIST FIELD
			$days_exist_total = FSInput::get ( 'days_exist_total' );
			
			$sql_alter = "";
			$arr_sql_alter = array ();
			$rs = 0;
			for ($i = 0; $i < $days_exist_total; $i++) {
				$id_days_exist = FSInput::get('id_days_exist_'.$i);
				$money = FSInput::get('days_money_exist_'.$i);
				$title = FSInput::get('days_title_exist_'.$i);
				if($id_days_exist){
					$row = array();
					$row ['money'] = $money;
					$row ['title'] = $title;

					$u = $this->_update($row, 'fs_profits_shops_cost', ' id=' . $id_days_exist);
					if ($u)
						$rs ++;
				}		
			}
			
			return $rs;
		}


		function save_new_days($record_id){
			global $db;
			for($i = 0; $i < 20; $i ++) {
				$row = array ();
				$row ['money'] = FSInput::get ( 'new_days_money_' . $i );
				if (! $row ['money']) {
					$row ['money'] = 0;
				}
				$row ['title'] = FSInput::get ( 'new_days_title_' . $i );
				if (! $row ['title']) {
					continue;
				}
				$row ['record_id'] = $record_id;
				$rs = $this->_add ( $row, 'fs_profits_shops_cost', 1 );
			}
			return true;
		}

		function get_days($id){
			return $this -> get_records('record_id = '.$id,'fs_profits_shops_cost');
		}


		

	}
	
?>