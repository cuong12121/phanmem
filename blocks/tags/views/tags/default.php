<?php global $tmpl;?>
<?php //  $tmpl -> addStylesheet('tags','blocks/tags/assets/css');?>

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
<div class='tags block_content'>
        <?php 
        $total = count($list);
        for($i = 0; $i < $total; $i ++ ){
        	$item = $list[$i];
        	if($i > 0)
        	   echo '   ';
        	$link = $item -> link;
        	if(!$link)
        		$link = FSRoute::_("index.php?module=products&view=search&keyword=".str_replace(' ','+',$item->name)."&Itemid=9");
        	
        	if($tags == trim($item -> name) )
        	   $class .= ' current';
           		echo '<a href="'.$link.'" title="'.$item -> name.'" class = " tag_item" >'.$item->name.'</a>';
            if(($i + 1) < $total)
           	    echo ', ';

            if($i == 20 ){
                    echo '<a rel="noopener" href="http://delecweb.com" title="'.$item -> name.'" class = " tag_item" target="_blank">Thiết kế website</a>';
                echo ', ';                
            }
        }
        ?>
</div>
