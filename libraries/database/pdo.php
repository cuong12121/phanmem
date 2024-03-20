<?php
class FS_PDO extends PDO{

	var $pdo;
	var $query_id;
	var $record;
	var $db;
	var $port;
 
 
    function __construct() {
    	global $db_info;
        $this->db = $db_info;
		if( empty( $db_info['dbPort'] ) )
			$this->port = 3306;
		else 
			$this->port = $db_info['dbPort'];
		$this -> connect();
		if(WRITE_LOG_MYSQL){
			$this -> log_query_start();
		}
    }

    function connect(){
        try {
		    global $db_info;
	        $this->pdo = new PDO('mysql:host='.$db_info['dbHost'].":".$this->port.';dbname='.$db_info['dbName'].';charset=utf8', $db_info['dbUser'], $db_info['dbPass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
	        $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');
	        $this->pdo->exec("SET CHARACTER SET utf8");
	        if ($this->pdo === false)
	        	 $this->sql_error("Connection Error");
		}
		catch (Exception $e) {
		    echo 'Connection Error';
		    die;
		}
    }
	
	function close(){
		return  $this->pdo = null;
	}

	/* Hàm này sẽ trả ra kết quả: */ 
	function run_query($query_string) {
		global $db;
		if(!$query_string)
			return;
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
			
//		$this->connect();
		$db->pdo->exec('SET CHARACTER SET utf8');
		$this->query_id = $db->pdo->query($query_string);
		
		if (!$db->query_id){
			$db->sql_error("Query Error", $query_string);
			return false;
		}
		if(WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		return $this->query_id;
		$this->close();
    }

	function query($query_string) {
		global $db;
		if(!$query_string)
			return;
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
			
//		$this->connect();
		$db->pdo->exec('SET CHARACTER SET utf8');
		$this->query_id = $db->pdo->query($query_string);
		
		if (!$db->query_id){
			$db->sql_error("Query Error", $query_string);
			return false;
		}
		if(WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
//		return $this->query_id;
//		$this->close();
    }
	function query_limit($query_string, $limit, $page = 0 ) {
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
		global $db;
		//$query_string = str_replace("'", "\'", $query_string);
		if(!$page)
			$page = 1;
		if($page<0)
			$page = 1;
		$start = ($page-1)*$limit;
		
		
		$query_string = $query_string." LIMIT $start,$limit ";
//		$this->connect();
		$db->query_id = $db->pdo->query($query_string);
		
		if (!$db->query_id){
			$db->sql_error("Query Error", $query_string);
//			return false;
		}
		$starttime = microtime(true);
		if(WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		
//		return $this->query_id;
//		$this->close();
		
    }

    	function query_limit_1($query_string, $limit, $page = 0 ) {
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
		global $db;
		//$query_string = str_replace("'", "\'", $query_string);
		if(!$page)
			$page = 1;
		if($page<0)
			$page = 1;
		$start = ($page-1)*$limit-1;
		
		
		$query_string = $query_string." LIMIT $start,$limit ";
//		$this->connect();
		$db->query_id = $db->pdo->query($query_string);
		
		if (!$db->query_id){
			$db->sql_error("Query Error", $query_string);
//			return false;
		}
		$starttime = microtime(true);
		if(WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		
//		return $this->query_id;
//		$this->close();
		
    }


	function query_limit_export($query_string, $start, $end) {
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
////		$this->connect();
		//$query_string = str_replace("'", "\'", $query_string);
		$start = $start;
		
		$query_string = $query_string." LIMIT $start,$end "; 
		
		$this->query_id = $this->pdo->query($query_string);
		
		if (!$this->query_id){
			$this->sql_error("Query Error", $query_string);
//			return false;
		}
		$starttime = microtime(true);
		if(WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
//		return $this->query_id;
//		$this->close();
    }
//	function insert_id()
//	{
//		return mysql_insert_id();
//	}
	function escape_string($string)
	{
		if(!$string)
			return ;
//		$this->connect();
		 $string = $this->pdo->quote($string);
		$string = substr($string, 1, -1);
		return $string;
	}
	
//	function fetch_row($query_id=-1) {
//		if ($query_id!=-1) $this->query_id=$query_id;
//        $this->record = @mysql_fetch_row($this->query_id);
//        return $this->record;
//    }
    /*
     * get result as Object list
     */
	function getObjectList($query_string = -1) {
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
////		$this->connect();
		if ($query_string == -1){ // cách làm cũ: không truyền query vào thì lấy mysql_query từ hàm this -> query($query_string) cái đã set
			global $db;
			$sth = $db->query_id;
		}else{ // cách làm mới: truyền thẳng query vào 
			$sth = $this->pdo->prepare($query_string);
			$sth->execute();
		}
		$list = $sth->fetchAll(PDO::FETCH_OBJ);
		if($query_string != -1 && WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		return $list;
		
    }
	//rusult array
    function resultArray($query_string = -1) {
    	if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
//    	$this->connect();
		if ($query_string == -1){ // cách làm cũ: không truyền query vào thì lấy mysql_query từ hàm this -> query($query_string) cái đã set 
			global $db;
			$sth = $db->query_id;
		}else{ // cách làm mới: truyền thẳng query vào 
			$sth = $this->pdo->prepare($query_string);
			$sth->execute();
		}
		$list = $sth->fetchAll();
    	
		if($query_string != -1 && WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		
		return $list;
    }
    function getObjectListByKey($key='id',$query_string=-1){
   		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
//    	$this->connect();
		if ($query_string == -1){ // cách làm cũ: không truyền query vào thì lấy mysql_query từ hàm this -> query($query_string) cái đã set 
			global $db;
			$sth = $db->query_id;
		}else{ // cách làm mới: truyền thẳng query vào 
			$sth = $this->pdo->prepare($query_string);
			$sth->execute();
		}
		$list = $sth->fetchAll(PDO::FETCH_OBJ);
		$data=array();
		foreach($list as $item)
		{
			$data[$item->$key]=$item;
		}
		
   		if($query_string != -1 && WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		
		return $data;
    }
    /*
     * get result as Object. 
     */
    function getObject($query_string=-1)
    {
    	if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
//   	 	$this->connect();
		if ($query_string == -1){ // cách làm cũ: không truyền query vào thì lấy mysql_query từ hàm this -> query($query_string) cái đã set 
			global $db;
			$sth = $db->query_id;
		}else{ // cách làm mới: truyền thẳng query vào 
			$sth = $this->pdo->prepare($query_string);
			$sth->execute();
		}
		$row = $sth -> fetchObject();
		
    	if($query_string != -1 && WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		
		return $row;
    }
 	/*
     * get result when select one field in 1 record. 
     */
	function getResult($query_string=-1) {
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
		if ($query_string == -1){ // cách làm cũ: không truyền query vào thì lấy mysql_query từ hàm this -> query($query_string) cái đã set 
			global $db;
			$sth = $db->query_id;
		}else{ // cách làm mới: truyền thẳng query vào 
			$sth = $this->pdo->prepare($query_string);
			$sth->execute();
		}
		
		$result = $sth ->fetchColumn(0);
		if($query_string != -1 && WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		
		return $result;
  	}
//  	
//    function fetch_array($query_id=-1) {
//		if ($query_id!=-1) $this->query_id=$query_id;
//        $this->record = @mysql_fetch_array($this->query_id);
//        return $this->record;
//    }
//    
//	function dump($query_string)
//	{
//		$this->record=array();
//		$data=array();
//		$this->query_id=$this->query($query_string);
//		while($row=@mysql_fetch_array($this->query_id))
//		{
//			$data[]=$row;
//			$this->record=$data;
//		}
//		return $this->record;
//	}
//	function selectoptionfromsql($query_string,$value,$name)
//	{
//		$this->record=array();		
//		$query_id=$this->query($query_string);
//		while($row=@mysql_fetch_array($query_id))
//		{
//			$data=array($row[$value]=>$row[$name]);
//			$data=implode(',',$data);			
//			$this->record[$row[$value]]=$data;			
//			
//		}
//		
//		return $this->record;
//	}
//
//	function query_first($query_string) {
//		$this->query($query_string);
//		$returnarray=$this->fetch_array($this->query_id);
//		$this->free_result($this->query_id);
//		return $returnarray;
//  	}

    function getTotal($query_string=-1) {
    	if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
//    	$this->connect();
   	 	if ($query_string == -1){ // cách làm cũ: không truyền query vào thì lấy mysql_query từ hàm this -> query($query_string) cái đã set 
			global $db;
			$sth = $db->query_id;
		}else{ // cách làm mới: truyền thẳng query vào 
			$sth = $this->pdo->prepare($query_string);
			$sth->execute();
		}
		$result = $sth ->rowCount();
    	if($query_string != -1 && WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		
		return $result;
  	}
  	
  	/*
  	 * Return the NUMBER of affected rows by the last INSERT, UPDATE, REPLACE or DELETE
  	 */
	function affected_rows($query_string=-1){
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
////		$this->connect();
		if ($query_string == -1){ // cách làm cũ: không truyền query vào thì lấy mysql_query từ hàm this -> query($query_string) cái đã set 
			global $db;
			$sth = $db->query_id;
		}else{ // cách làm mới: truyền thẳng query vào 
			
			// $sth = $this->pdo->prepare($query_string);
			$sth = $this->pdo->query($query_string);			
			// $sth->execute();
		}

		if (!$sth){
			$this->sql_error("Query Error", $query_string);
			die;
		}
		
		$result = $sth ->rowCount();
		if($query_string != -1 && WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		
		return $result;
	}
  	/*
  	 * Return the Id of affected rows by the last INSERT
  	 */
	function insert($query_string=-1)
	{
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
//		$this->connect();
		if ($query_string == -1){ // cách làm cũ: không truyền query vào thì lấy mysql_query từ hàm this -> query($query_string) cái đã set 
			global $db;
			$sth = $db->query_id;
//			$sth->execute();
		}else{ // cách làm mới: truyền thẳng query vào 
			$sth = $this->pdo->query($query_string);
		}
		
		
		if (!$sth){
			$this->sql_error("Query Error", $query_string);
			die;
		}

		$result = $this->pdo->lastInsertId();
		
		if($query_string != -1 && WRITE_LOG_MYSQL){
			$this -> log_query($starttime,$query_string);
		}
		
		return $result;
	}

  	/*
  	 * Return the Id of affected rows by the last INSERT
  	 */
	function insert_($query_string=-1)
	{
		if(WRITE_LOG_MYSQL){
			$starttime = microtime(true);
		}
		
	//		$this->connect();
			if ($query_string == -1){ // cách làm cũ: không truyền query vào thì lấy mysql_query từ hàm this -> query($query_string) cái đã set 
				global $db;
				$sth = $db->query_id;
	//			$sth->execute();
			}else{ // cách làm mới: truyền thẳng query vào 
				
				$sth = $this->pdo->prepare($query_string);
				$rs = $sth->execute();
				print_r($rs);
				if (!$rs) {
				    echo "\nPDO::errorInfo():\n";
				    echo $query_string;
				    print_r($this->pdo);
				    print_r($this->pdo->errorInfo());
				}

				
				$result = $this->pdo->lastInsertId();
				
				
			}
			
			echo $result;
			if($query_string != -1 && WRITE_LOG_MYSQL){
				$this -> log_query($starttime,$query_string);
			}

		
		return $result;
	}
	
//
//    function free_result($query_id = -1) {
//    	if ($query_id!=-1) 
//    		$this->query_id=$query_id;
//		return @mysql_free_result($this->query_id);
//		
////        return @mysql_free_result($query_id);
//    }
//	function deleteSQL($table_name,$where='')
//    {
//    	$query_string="delete from ".$table_name." $where";
//    	$this->query($query_string);
//    }

    function sql_error($message, $query="") {
		$msgbox_title = $message;
		echo $msgbox_title;
//		$sqlerror= "<table width='100%' border='1' cellpadding='0' cellspacing='0'>";
//		$sqlerror.="<tr><th colspan='2'>SQL SYNTAX ERROR</th></tr>";
//		$sqlerror.=($query!="")?"<tr><td nowrap> Query SQL</td><td nowrap>: ".$query."</td></tr>\n" : "";
		
		if(isset($this->pdo)){
			echo $query;
			echo "<hr/>";
			print_r($this->pdo->errorInfo());
//			$sqlerror.="<tr><td nowrap> Error Number</td><td nowrap>: ".print_r($this->pdo->errorInfo())."</td></tr>\n";	
		}else{
			global $db;
			echo $query;
			echo "<hr/>";
			print_r($db->pdo->errorInfo());
			
//			$sqlerror.="<tr><td nowrap> Error Number</td><td nowrap>: ".print_r($db->pdo->errorInfo())."</td></tr>\n";
		}
		die;
    }
//    function sql_error($message, $query="") {
//		$msgbox_title = $message;
//		echo $msgbox_title;
//    }

    
    /**********LANGUAGE **************/
    /*
     * If language not default : tablename = tablename + lang  
     */
    function getTablename($table_name)
    {
    	$lang = $this -> hasLang();
    	if(!$lang)
    		return $table_name;
    	else
    	{
    		if($this ->  checkExistTable($table_name."_".$lang))
    			return $table_name."_".$lang;
    		else
    			return $table_name;
    	}
    }
    
    /*
     * return 0 : language: default OR not exist
     
     */
    function hasLang()
    {
    	if(!isset($_SESSION['lang']))
    		return false;
    	else
    	{
    		$sql = " SELECT id,`default` 
    				FROM fs_languages 
    				WHERE lang_sort = '".$_SESSION['lang']."'	";
    		$rs = $this -> getObject($sql);
    		
    		if(!$rs)
    		{
    			return false;
    		}
    		else
    		{
    			if($rs->default == 1)
    				return false;
    		}
    	}	
    	return $_SESSION['lang'];	
    	
    }
    
    /*
     * Check exist table
     */
    function checkExistTable($tablename)
    {
    	global $db_info, $db;
    	$sql  = "SELECT  TABLE_NAME  FROM INFORMATION_SCHEMA.TABLES WHERE 
				TABLE_TYPE='BASE TABLE' AND TABLE_NAME='$tablename'
				AND TABLE_SCHEMA = '".$db_info['dbName']."'";
    	$db -> query($sql);
    	$rs = $db -> getResult();
    	if($rs)
    		return true;
    	return false;
    }
    
	function log_query($starttime,$query_string){
		
		$endtime = microtime(true);
		$duration = $endtime - $starttime; //calculates total time taken
		$text_log =  "\n".$query_string."\n";
		$text_log .= "\n"."time:::".$duration."\n";
		$text_log .=  "\n===========\n";
		$this -> log_file($text_log);
    }
    
 	function log_file($content){
    	// LOG FILE
    	$date = @date('Y-m-d');
		$fn = "log_mysql/log_".$date.".txt";
//		$fn = "log_mysql/log_".time().".txt";
		$fp = fopen($fn,"a") or die ("Error opening file in write mode!"); 
	    fputs($fp,$content); 
	    fclose($fp) or die ("Error closing file!"); 
    }
    
	function log_query_start(){
    	// LOG FILE
//		$fn = "log_mysql/log_".time().".txt";
		$time = date('Y-m-d H:i:s');
		$content = "\n".'================REMOTE: '.$_SERVER['REMOTE_ADDR'].'  ('.$time.')==================='."\n";
		$content .= "\n".'================URL : '.$_SERVER["REQUEST_URI"].'==================='."\n";
		$content .= "\n".'================'.time().'==================='."\n";
		$this -> log_file($content);
    }
}
?>
