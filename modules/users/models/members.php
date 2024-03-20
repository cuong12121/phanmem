
<?php 
	class UsersModelsMembers
	{
		function __construct()
		{
		}
		function getConfig($name)
		{
			global $db;
			$sql = " SELECT value FROM fs_config 
				WHERE name = '$name' ";
			// $db->query($sql);
			return $db->getResult($sql);
		}
		
		/*
		 * return child member.
		 */
		function getMembers()
		{
//			$sim_number = $_SESSION["sim_number"];
			$userid = $_SESSION["userid"];
			$rs = $this->getChildren($userid);
			return $rs;
		}
		
		
		/*
		 * Get childen members.
		 * Use recursive
		 * 
		 */
		function getChildren($parents_id,$level = 0, $max = 6)
		{
			global $db;
			$rs = array();
			if($level > $max)
				return $rs;
			if(!$parents_id)
				return $rs;
			$sql = " SELECT  fname,lname as name,mname,id , created_date,sim_number , ".($level+1)." as level, referrer as parent_id
					 FROM fs_members
					 WHERE  referrer IN ($parents_id) ";
			// $db->query($sql);
			$rs_query =  $db->getObjectList($sql);
			
			if(count($rs_query))
			{
				$array_simnumbers = array();
				foreach ($rs_query as $item)
				{
					$rs[] = $item;
					$array_simnumbers[] = $item->id;
				}
				$str_simnumber = implode(",",$array_simnumbers);
				$children = $this->getChildren($str_simnumber, ($level+1), $max );
				
				if(count($children))
				{
					foreach ($children as $child)
					{
						$rs[] = $child;
					}
				}
			}
			return $rs;
		}
		
		/*
		 * cal count children
		 * from level 1-7
		 */
		function countChildren($parents_id,$level = 0, $max = 6)
		{
			$length = array();
			
			global $db;
			$rs[0] = 0;
			$rs[1] = 0;
			$rs[2] = 0;
			
			if($level > $max)
				return $length;
			if(!$parents_id)
				return $length;
			$sql = " SELECT  id, level
					 FROM fs_members
					 WHERE  referrer IN ($parents_id) ";
			// $db->query($sql);
			$rs_query =  $db->getObjectList($sql);
			
			
			if(count($rs_query))
			{
				$array_simnumbers = array();
				$rs[0] = count($rs_query);
				foreach ($rs_query as $item)
				{
					$array_simnumbers[] = $item->id;
					if($item -> level == 1)
					{
						$rs[1] ++ ;
					}
					if($item -> level == 2)
					{
						$rs[2] ++ ;
					}
				}
				$length[] = $rs;
				$str_simnumber = implode(",",$array_simnumbers);
				$children = $this->countChildren($str_simnumber, ($level+1), $max );
				if(count($children))
				{
					foreach ($children as $child)
					{
						$length[] = $child;
					}
				}
			}
			return $length;
		}
		
		/*
		 * get data about member
		 */
		function getMemberById($userid)
		{
			global $db;
			$sql = " SELECT * FROM fs_members 
				WHERE id = '$userid'
					 ";
			// $db->query($sql);
			return $db->getObject($sql);
		}
		
		/*
		 * get fullname of referrer
		 */
		function getReferrer($userid)
		{
			global $db;
			$sql = " SELECT full_name, level FROM fs_members 
				WHERE id = '".$userid."'
					 ";
			// $db->query($sql);
			return $db->getObject($sql);
		}
		
		
	/*
		 * get info in table fs_userhistory
		 * By Userid , month, year
		 * for ajax
		 */
		function getTotalCommission($userid)
		{
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
		
	/*
		 * get info in table fs_userhistory
		 * By Userid , month, year
		 * for ajax
		 */
		function getTotalMload($userid)
		{
			$month_current = date('m');
			$year_current = date('Y');
			global $db ;
			$sql = " SELECT *
					FROM fs_ch_sale
					 WHERE userid = '$userid'
					 AND month = $month_current
					 AND year = $year_current ";
					// $db->query($sql);
			return $db->getObject($sql);
		}
	}
	
?>