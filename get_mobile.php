<?php 
if (!function_exists('apache_request_headers')) { 
        function apache_request_headers() { 
            foreach($_SERVER as $key=>$value) { 
                if (substr($key,0,5)=="HTTP_") { 
                    $key=str_replace(" ","-",ucwords(strtolower(str_replace("_"," ",substr($key,5))))); 
                    $out[$key]=$value; 
                }else{
                    $out[$key]=$value; 
		}
            } 
            return $out; 
        } 
}

$headers = apache_request_headers();
print_R($headers); 
//$headers = get_nginx_headers();
 
foreach ($headers as $header => $value) {
	if ($header == 'x-up-calling-line-id') { 
		$phone_number = $value; 
		rewrite_log('1:'.$phone_number);
		break; 
	} 
}
$header = apache_request_headers(); 
if(isset($header['x-up-calling-line-id']) && !empty($header['x-up-calling-line-id'])){ 
	$phone_number = $header['x-up-calling-line-id'];
	rewrite_log('2:'.$phone_number);
}else{ 
	$error_phone_number = "Phone number missing...!"; 
	rewrite_log('3:Phone number missing...');
}

function rewrite_log($main_content){
	 $fn = "log/mobile_".time().".txt";
	$fp = fopen($fn,"w+") or die ("Error opening file in write mode!"); 
	$content = '\n================'.time().'===================\n';
	$content .= $main_content;
    fputs($fp,$content); 
    fclose($fp) or die ("Error closing file!"); 
}
?>