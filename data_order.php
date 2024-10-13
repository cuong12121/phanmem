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



if ($redis->exists('complete_order')) {

	$data_order = $redis->get("complete_order");

	$data_order = json_decode($data_order);

	foreach ($data_order as $key => $value) {
		print_r($value);
	}

	
}


// // Send the request
// $response = file_get_contents('https://api.'.DOMAIN.'/api/search-data-order-details?search='.$search.'&user_package_id='.$user_id.'&active='.$active, FALSE, $context);


// echo $check;
