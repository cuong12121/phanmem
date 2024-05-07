<?php 

$redis = new Redis();

// Thiết lập kết nối
$redis->connect('127.0.0.1', 6379);

$check =0;

if ($redis->exists('refresh')) {

	$check = $redis->get("refresh");
}

return $check;
