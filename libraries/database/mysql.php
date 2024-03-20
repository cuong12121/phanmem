<?php
class Mysql_DB {

	var $conn_id;
	var $query_id;
	var $record;
	var $db;
	var $port;
 
 
    function Mysql_DB() {
    	global $db_info;
        $this->db = $db_info;
		if( empty( $db_info['dbPort'] ) )
			$this->port = 3306;
		else 
			$this->port = $db_info['dbPort'];
    }

    function connect() {
    	global $db_info;
        $this->conn_id = @mysql_pconnect($db_info['dbHost'].":".$this->port,$db_info['dbUser'],$db_info['dbPass']);
        if ($this->conn_id === false)
        	 $this->sql_error("Connection Error");
        	 
        if (!@mysql_select_db($db_info['dbName'], $this->conn_id))
        	$this->sql_error("Database Error");

        return $this->conn_id;
    }
	
	function close(){
		return mysql_close($this->conn_id);
	}

	function query($query_string) {
		//$query_string = str_replace("'", "\'", $query_string);
		$this->connect();
		mysql_query("SET NAMES 'utf8'");
		$this->query_id = @mysql_query($query_string,$this->conn_id);
		if (!$this->query_id){
			$this->sql_error("Query Error", $query_string);
//			return false;
		}
		return $this->query_id;
		$this->close();
    }
	function query_limit($query_string, $limit, $page = 0 ) {
		//$query_string = str_replace("'", "\'", $query_string);
		if(!$page)
			$page = 1;
		if($page<0)
			$page = 1;
		$start = ($page-1)*$limit;
		
		$query_string = $query_string." LIMIT $start,$limit "; 
		$this->connect();
		mysql_query("SET NAMES 'utf8'");
		$this->query_id = @mysql_query($query_string,$this->conn_id);
		if (!$this->query_id){
			$this->sql_error("Query Error", $query_string);
		}
		return $this->query_id;
		$this->close();
    }
	function query_limit_export($query_string, $start, $end) {
		//$query_string = str_replace("'", "\'", $query_string);
		$start = $start;
		
		$query_string = $query_string." LIMIT $start,$end "; 
		$this->connect();
		mysql_query("SET NAMES 'utf8'");
		$this->query_id = @mysql_query($query_string,$this->conn_id);
		if (!$this->query_id){
			$this->sql_error("Query Error", $query_string);
		}
		return $this->query_id;
		$this->close();
    }
	function insert_id()
	{
		return mysql_insert_id();
	}
	function escape_string($str)
	{
		return mysql_real_escape_string($str,$this->conn_id);
	}
	
	function fetch_row($query_id=-1) {
		if ($query_id!=-1) $this->query_id=$query_id;
        $this->record = @mysql_fetch_row($this->query_id);
        return $this->record;
    }
    /*
     * get result as Object list
     */
	function getObjectList($query_id=-1) {
		$data=array();
		if ($query_id!=-1) $this->query_id=$query_id;
		while($row=@mysql_fetch_object($this->query_id))
		{
			$data[]=$row;
		}
		return $data;
    }
	//rusult array
    function resultArray($query_id=-1) {
		$data=array();
		if ($query_id!=-1) $this->query_id=$query_id;
		while($row=@mysql_fetch_array($this->query_id))
		{
			$data[]=$row;
		}
		return $data;
    }
    function getObjectListByKey($key='id',$query_id=-1){
    	$data=array();
    	if(!$key)
    		$key = 'id';
		if ($query_id!=-1) $this->query_id=$query_id;
		while($row=@mysql_fetch_object($this->query_id))
		{
			$data[$row->$key]=$row;
		}
		return $data;
    }
    /*
     * get result as Object. 
     */
    function getObject($query_id=-1)
    {
		if ($query_id!=-1) $this->query_id=$query_id;
		$row=@mysql_fetch_object($this->query_id);
		return $row;
    }
 	/*
     * get result when select one field in 1 record. 
     */
	function getResult($query_id=-1) {
		if ($query_id!=-1) 
		$this->query_id=$query_id;
		
		$result = mysql_fetch_row($this->query_id);
		
		return $result[0];
  	}
  	
    function fetch_array($query_id=-1) {
		if ($query_id!=-1) $this->query_id=$query_id;
        $this->record = @mysql_fetch_array($this->query_id);
        return $this->record;
    }
    
	function dump($query_string)
	{
		$this->record=array();
		$data=array();
		$this->query_id=$this->query($query_string);
		while($row=@mysql_fetch_array($this->query_id))
		{
			$data[]=$row;
			$this->record=$data;
		}
		return $this->record;
	}
	function selectoptionfromsql($query_string,$value,$name)
	{
		$this->record=array();		
		$query_id=$this->query($query_string);
		while($row=@mysql_fetch_array($query_id))
		{
			$data=array($row[$value]=>$row[$name]);
			$data=implode(',',$data);			
			$this->record[$row[$value]]=$data;			
			
		}
		
		return $this->record;
	}

	function query_first($query_string) {
		$this->query($query_string);
		$returnarray=$this->fetch_array($this->query_id);
		$this->free_result($this->query_id);
		return $returnarray;
  	}

    function getTotal($query_id=-1) {
        if ($query_id!=-1) $this->query_id=$query_id;
		return @mysql_num_rows($this->query_id);
  	}
  	
  	/*
  	 * Return the NUMBER of affected rows by the last INSERT, UPDATE, REPLACE or DELETE
  	 */
	function affected_rows($query_id=-1)
	{
		if ($query_id!=-1) $this->query_id=$query_id;
		$result =  @mysql_affected_rows();
		
		return $result;
	}
  	/*
  	 * Return the Id of affected rows by the last INSERT
  	 */
	function insert($query_id=-1)
	{
		if ($query_id!=-1) $this->query_id=$query_id;
		$result =  @mysql_insert_id();
		return $result;
	}

    function free_result($query_id = -1) {
    	if ($query_id!=-1) 
    		$this->query_id=$query_id;
		return @mysql_free_result($this->query_id);
		
//        return @mysql_free_result($query_id);
    }
	function deleteSQL($table_name,$where='')
    {
    	$query_string="delete from ".$table_name." $where";
    	$this->query($query_string);
    }

    function sql_error($message, $query="") {
		$msgbox_title = $message;
		echo $msgbox_title;
		$sqlerror= "<table width='100%' border='1' cellpadding='0' cellspacing='0'>";
		$sqlerror.="<tr><th colspan='2'>SQL SYNTAX ERROR</th></tr>";
		$sqlerror.=($query!="")?"<tr><td nowrap> Query SQL</td><td nowrap>: ".$query."</td></tr>\n" : "";
		$sqlerror.="<tr><td nowrap> Error Number</td><td nowrap>: ".mysql_errno()." ".mysql_error()."</td></tr>\n";
        $sqlerror.="<tr><td nowrap> Date</td><td nowrap>: ".date("D, F j, Y H:i:s")."</td></tr>\n";
        $sqlerror.="<tr><td nowrap> IP</td><td>: ".getenv("REMOTE_ADDR")."</td></tr>\n";
        $sqlerror.="<tr><td nowrap> Browser</td><td nowrap>: ".getenv("HTTP_USER_AGENT")."</td></tr>\n";
		$sqlerror.="<tr><td nowrap> Script</td><td nowrap>: ".getenv("REQUEST_URI")."</td></tr>\n";
        $sqlerror.="<tr><td nowrap> Referer</td><td nowrap>: ".getenv("HTTP_REFERER")."</td></tr>\n";
        $sqlerror.="<tr><td nowrap> PHP Version </td><td>: ".PHP_VERSION."</td></tr>\n";
        $sqlerror.="<tr><td nowrap> OS</td><td>: ".PHP_OS."</td></tr>\n";
        $sqlerror.="<tr><td nowrap> Server</td><td>: ".getenv("SERVER_SOFTWARE")."</td></tr>\n";
        $sqlerror.="<tr><td nowrap> Server Name</td><td>: ".getenv("SERVER_NAME")."</td></tr>\n";
		$sqlerror.="</table>";
		$msgbox_messages = "<meta http-equiv=\"refresh\" content=\"9999\">\n<table class='smallgrey' cellspacing=1 cellpadding=0>".$sqlerror."</table>";
		$msg_header = "header_listred.gif";
		$msg_icon = "msg_error.gif";
		$imagesdir = "images";
		$redirecturl = '';
		$lang['gallery_back'] = "Back to the last request";
		if(!$templatefolder) $templatefolder = "templates";
		print $msgbox_messages;
		exit;
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
    		$db = new Mysql_DB();
    		$db -> query($sql);
    		$rs = $db -> getObject();
    		
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
    	global $db_info;
    	$sql  = "SELECT  TABLE_NAME  FROM INFORMATION_SCHEMA.TABLES WHERE 
				TABLE_TYPE='BASE TABLE' AND TABLE_NAME='$tablename'
				AND TABLE_SCHEMA = '".$db_info['dbName']."'";
    	$db = new Mysql_DB();
    	$db -> query($sql);
    	$rs = $db -> getResult();
    	if($rs)
    		return true;
    	return false;
    }
}
?>
