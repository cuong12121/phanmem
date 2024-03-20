
<?php 
	class UsersModelsCommission
	{
		var $limit;
		function __construct()
		{
			$this -> limit = 30;
		}
		
		/*
		 * fields : array ( prefix, suffix)
		 * add_field = array( field1, field2)
		 */
		function getDataTable($tablename )
		{
			$userid = $_SESSION['userid'];
			$month_current = date('m');
			$year_current = date('Y');
			
			global $db ;
			$sql = " SELECT * 
					FROM $tablename
					 WHERE userid = '$userid'
					 AND month = $month_current
					 AND year = $year_current ";
					// $db->query($sql);
			return $db->getObject($sql);
		}
		
		/*
		 * select data from fs_ct_typecommission in month
		 */
		function set_query_ct_cm($tablename)
		{
			if(!$tablename)
				return;
			// commissionerid is current person.
			$commissionerid = $_SESSION['userid'];
			$month = FSInput::get('month',date('m'));
			$year = FSInput::get('year',date('y'));
			
			$sql = " SELECT a.*, b.sim_number 
					FROM $tablename AS a
					INNER JOIN fs_members AS b ON a.userid = b.id
					WHERE a.commissionerid = $commissionerid
						AND YEAR(a.datecreated) = $year
						AND MONTH(a.datecreated) = $month
					ORDER BY a.datecreated ";
			return $sql;
		}
		
		function get_data_ct_cm($tablename)
		{
			global $db ;
			$page = FSInput::get('page',0);
			$query  = $this -> set_query_ct_cm($tablename);
			if(!$query)
				return;
			$db->query_limit($query, $this-> limit,$page );
			return $db->getObjectList();
		}
		
		/*
		 * select total of data from fs_ct_typecommission in month
		 */
		function get_total_ct_cm($tablename){
			
			// commissionerid is current person.
			$commissionerid = $_SESSION['userid'];
			$month = FSInput::get('month',date('m'));
			$year = FSInput::get('year',date('y'));
			
			$sql = " SELECT count(*)
					FROM $tablename AS a
					WHERE a.commissionerid = $commissionerid
						AND YEAR(a.datecreated) = $year
						AND MONTH(a.datecreated) = $month
					ORDER BY a.datecreated ";
			global $db;
			// $db->query($sql);
			return $db->getResult($sql);
		}
		
		function get_pagination_ct_cm($total)
		{
			$page = FSInput::get('page');
			$pagination = new Pagination($this->limit,$total,$page);
			return $pagination;
		}
		
		/******************* DATA IN USERHISTORY ********************/
		/*
		 * get info in table FS_USERHISTORY
		 * By Userid , month, year
		 */
		function getTotalCommission()
		{
			$userid = $_SESSION['userid'];
			$month_current = date('m');
			$year_current = date('Y');
			global $db ;
			$sql = " SELECT *
					FROM fs_userhistory
					 WHERE userid = '$userid'
					 AND month = $month_current
					 AND year = $year_current ";
					// $db->query($sql);
			return $db->getObject($sql);
		}
		/************************* AJAX ***********************/
		
		/*
		 * get info in table fs_userhistory
		 */
		function ajax_getTotalCommissionInMonths($cm_field_total, $cm_field_receiver)
		{
			if(!$cm_field_total || !$cm_field_receiver)
				return;
			$yf = FSInput::get('yf');
			$yt = FSInput::get('yt');
			$mf = FSInput::get('mf');
			$mt = FSInput::get('mt');
			
			if($yf > $yt)
			{
				return;	
			}
			$where = "";
			if($yf == $yt)
			{
				if($mf > $mt)
					return;
				$where .= " AND  year = $yf AND month <= $mt AND month >= $mf ";
			}
			else {
				$where .= " AND ( ( year = $yf AND month >= $mf ) OR ( year = $yt AND month <= $mt ) OR (year > $yf AND year < $yt)) ";
			}
			
			$userid = $_SESSION['userid'];
			global $db ;
			$sql = " SELECT year, month, $cm_field_total ,$cm_field_receiver
					FROM fs_userhistory
					 WHERE userid = '$userid'
					 ". $where ." 
					 ORDER BY id
					 ";
				// $db->query($sql);
			return $db->getObjectList($sql);
			
		}
		
		
	}
	
?>