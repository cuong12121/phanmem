<?php 

$redis = new Redis();

// Thiết lập kết nối
$redis->connect('127.0.0.1', 6379);

$context = stream_context_create(array(
    'http' => array(
        
        'method' => 'GET',

        'header' => "Content-Type: application/x-www-form-urlencoded\r\n".
                    "token: 7ojTLYXnzV0EH1wRGxOmvLFga",
        
    )
));
$DOMAIN = 'dienmayai.com';


if ($redis->exists('complete_order')) {


	$data_order = json_decode($redis->get("complete_order"));

	$redis->del("complete_order");

	foreach ($data_order as $key => $value) {

		// Send the request
		$response = file_get_contents('https://api.'.$DOMAIN.'/api/search-data-order-details?search='.$value->search.'&user_package_id='.$value->user_package_id.'&active='.$value->active, FALSE, $context);

		print_r($response);

		die;
		
	}

}

$keyExists = $redis->exists('refresh');

if ($keyExists) {
    $redis->del("refresh");

    $redis->set("refresh", 1);

} 


echo 'thành công';
