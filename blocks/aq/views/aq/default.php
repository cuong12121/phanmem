<?php
global $tmpl,$config; 
$tmpl -> addStylesheet('aq','blocks/aq/assets/css');
$tmpl -> addScript('aq','blocks/aq/assets/js');
?>


<ul class='news_list_body newslist_grid'>
  <?php 
  $Itemid = 4;
  for($i = 0; $i < count($list); $i ++ ){
    $item = $list[$i];
    $link = FSRoute::_("index.php?module=aq&view=aq&id=".$item->id."&code=".$item->alias."&Itemid=$Itemid");
    ?>
    <li class="item ">
      <a href="<?php echo $link; ?>">
        <img width="100" height="70" src="<?php echo URL_ROOT.str_replace('/original/','/resized/', $item->image); ?>">
        <h3><?php echo htmlspecialchars(@$item->question); ?></h3>
      </a>
    </li>     
    <?php       
  }
  ?>
</ul>
