<?php 
$str_order = '[';
$i = 0;
$str_order .= '{ id: "'.$data -> id.'", price: '.$data -> price.', quantity: 1 } ';    
   
$str_order .= ']';
?>

<script type="text/javascript">
  var cr_layout_type = 'viewBasket';  
  var cr_items = <?php echo $str_order; ?>;

</script>


