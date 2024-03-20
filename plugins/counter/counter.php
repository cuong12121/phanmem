<?php
class Counter{
/*
	 * update Hit for estore
	 */
	public static function  updateHit()
	{
		$time_space = 15; // time to recalculate
		$time_unit = 'MINUTE'; 
		$ip_address=$_SERVER['REMOTE_ADDR'];
		$page=$_SERVER['REQUEST_URI'];
		$page = mysql_real_escape_string($page);
		$time = date('Y-m-d H:i:s');
		global $db;
		
		// count
		$sql = " SELECT count(*) FROM fs_hits 
							WHERE ip_address = 	'$ip_address'
							AND page = '($page)'
							AND DATE_SUB('".$time."',INTERVAL $time_space $time_unit) < visited_time ";
		$db -> query($sql);
		$count = $db -> getResult();
		// insert
		if(!$count){
			$sql = " INSERT INTO fs_hits
							(`ip_address`,page,visited_time)
							VALUES ('$ip_address','$page','$time')
							";
				$db->query($sql);
				$id = $db->insert();
				return $id;
		}		
		return;
	}
}
?>