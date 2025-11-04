<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379); // IP & Port Redis server
$key = "list_xuat_kho_t8_t10";

// $redis->set($key, json_encode($list));

$cache_data = $redis->get($key);

$list = json_decode($cache_data);



print_r($list);



?>