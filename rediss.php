<?php 

$redis = new Redis();

// Thiết lập kết nối
$redis->connect('127.0.0.1', 6379);

$check =0;

if ($redis->exists('refresh')) {

	$check = $redis->get("refresh");

	if($check ==1){
		$redis->delete("refresh");
		$redis->set("refresh", 0);
	}
}


echo $check;
