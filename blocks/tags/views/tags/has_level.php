<?php global $tmpl;?>
<?php //  $tmpl -> addStylesheet('tags','blocks/tags/assets/css/')?>
<?php 
    $tags = '';
    $module = FSInput::get('module');
    if($module == 'search'){
        $key = FSInput::get('keyword');
        if($key){
            $tags = trim($key);
        }
    }
?>
<div class='tags'>
<!--    <h3><?php echo FSText::_('Tags')?></h3>-->
        <?php 
        $total = count($list);
        for($i = 0; $i < $total; $i ++ ){
        	$item = $list[$i];
        	if($i > 0)
        	   echo ', ';
        	$link = FSRoute::_('index.php?module=products&view=search&keyword='.$item -> name.'&Itemid=9');
        	$class = $item -> level <= 10 ? 'level'.$item -> level : 'level_large';
        	if($tags == trim($item -> name) )
        	   $class .= ' current';
            echo '<a href="'.$link.'" title="'.$item -> name.'" class = " tag lv'.$item -> level.' '.$class.'" >';
            echo  ucfirst( $item->name);
            echo '</a>';
        }
        ?>
</div>
