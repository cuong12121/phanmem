<?php

//Thông tin cấu hình
// define('URL_DEMO', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '/alepay-installment/');
define('URL_DEMO', (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . '');
define('URL_CALLBACK', URL_ROOT . 'alepay_result.htm'); // URL đón nhận kết quả 
//Alepay cung cấp 

// $config = array(
//     "apiKey" => "y07Va306F4UdZn4PvKCNHBPLXkso8P", //Là key dùng để xác định tài khoản nào đang được sử dụng.
//     "encryptKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCVa30tAcOeM98MEqmETWXuvmuzlgkR0DKPPfQfHqL/66wBGVHiEsCQBxhEBavFw2utHQLQ329RMcbRzGtkyFPKnURLRPkdrv3ZZFpgse1AQHsA/ogfOi4yS6RHc9k+9BI19ZjwqIHlABfBKU+Oqieb8ESWDNG+xeMC2744oyTobwIDAQAB
// ", //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
//     "checksumKey" => "c6XdnfTH460w1i3bi5Lx4vzeAkoO8Y", //Là key dùng để tạo checksum data.
//     "callbackUrl" => URL_CALLBACK,
//     "env" => "live",
// );

$config = array(
    "apiKey" => "kyER0uvC8UWbkfVfbvenSKumqHVV4U", //Là key dùng để xác định tài khoản nào đang được sử dụng.
    "encryptKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCW56C30JS8TQNdmK99AGcik3ylUbkFSRAbqnm4eff8Fr3DcV0YqAIpR9HnHZ3iI7hFaqmgYoFA7wO9X7stC3S+0PfjrkWGYuwH+NVloOxotSVQY/rlrNNtdP8UmnoJWlAWy8aoNVl7qwWBC3Q4tCdZZgdpY3/ltaYfg5AvabW1IwIDAQAB
", //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
    "checksumKey" => "IpBbObMJijIXc1lo0df5J3WsugHABl", //Là key dùng để tạo checksum data.
    "callbackUrl" => URL_CALLBACK,
    "env" => "live",
);


// $config = array(
//     "apiKey" => "0COVspcyOZRNrsMsbHTdt8zesP9m0y", //Là key dùng để xác định tài khoản nào đang được sử dụng.
//     "encryptKey" => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCIh+tv4h3y4piNwwX2WaDa7lo0uL7bo7vzp6xxNFc92HIOAo6WPZ8fT+EXURJzORhbUDhedp8B9wDsjgJDs9yrwoOYNsr+c3x8kH4re+AcBx/30RUwWve8h/VenXORxVUHEkhC61Onv2Y9a2WbzdT9pAp8c/WACDPkaEhiLWCbbwIDAQAB", //Là key dùng để mã hóa dữ liệu truyền tới Alepay.
//     "checksumKey" => "hjuEmsbcohOwgJLCmJlf7N2pPFU1Le", //Là key dùng để tạo checksum data.
//     "callbackUrl" => URL_CALLBACK,
//     "env" => "test",
// );
?>