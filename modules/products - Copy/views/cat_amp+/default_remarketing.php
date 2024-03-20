<?php 
$str_id = '';
$i = 0;
if(count($list)){
  foreach($list as $item){
    if($i > 2)
      break;
    if($str_id)
      $str_id .= ',';
    $str_id .= '"'.$item -> id.'"';
    $i ++;
  }
}
?>

