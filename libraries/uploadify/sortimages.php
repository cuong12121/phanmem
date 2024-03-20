<?
require_once("config.php");
if(isset($_POST["sort"])){
	if(is_array($_POST["sort"])){
		foreach($_POST["sort"] as $key=>$value){
			$db_del = new db_execute("UPDATE images_source SET ims_order = $key WHERE ims_id = $value");
			unset($db_del);
		}
	}
}
?>