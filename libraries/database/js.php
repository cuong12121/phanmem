<?php 
include("../../includes/config.php");
$db = new Mysql_DB();
$db -> export_db(1);
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
	
	function export_db($use_mysqldump = 0){
		global $db_info;
		$backup_file = 'js/database_'. date("Y-m-d") . '.sql';
//		$backup_file = 'E:\wamp\www\svn\ionevn\code\libraries\database\\'.'database_'. date("Y-m-d") . '.sql';
//		echo $this -> connect();
		if($use_mysqldump){
			$db = mysql_connect($db_info['dbHost'], $db_info['dbUser'], $db_info['dbPass']) or die ("Error connecting to database.");
			mysql_select_db($db_info['dbName'], $db) or die ("Couldn't select the database.");
			
			$command = "mysqldump --opt --skip-extended-insert --complete-insert --host=".$db_info['dbHost']." --user=".$db_info['dbUser']."  "." --password='".$db_info['dbPass']."' ".$db_info['dbName']." > ".$backup_file;
			
			system($command, $returned);
			
//			echo $command;
			
//			$this->close();
			print_r($returned);
		} else { // chua chay
			$this->connect();
			$table_name = "fs_blocks";
			echo $sql = "SELECT * INTO OUTFILE '$backup_file' FROM $table_name";
			
			$retval = $this->query_id = @mysql_query($sql,$this->conn_id);
			if(! $retval )
			{
			  die('Could not load data : ' . mysql_error());
			}
			echo "Loaded  data successfully\n";
			$this -> close();
		}
		
	}
}
?>

