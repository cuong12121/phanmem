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
<script type="text/javascript">
  var cr_layout_type = 'viewList';
  var cr_items = <?php echo  '['.$str_id.']'; ?>;
</script>
