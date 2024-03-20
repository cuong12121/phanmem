<?php global $tmpl;
	$tmpl -> addStylesheet('parents_scroll','blocks/product_menu/assets/css');
	$tmpl -> addScript('parents_scroll','blocks/product_menu/assets/js');
?>
		
		 <ul class="product_menu_2" >
	<?php  
		foreach ( $list as $item ){
			if($item->alias ==  @$ccode){
				if($item -> level > 0 ){
					$root_parrent = 	$item -> parent_id;
				}else{
					$root_parrent = 	$item -> id;
				}
				break;
			}
		}
		
		foreach ( $list as $item ){
			// echo '<pre>';
			// print_r($list);
			$link = FSRoute::_('index.php?module=products&view=cat&id='.$item->id.'&ccode='.$item->alias);
			if($item->id == $root_parrent){
				echo "<li id='pr_".$item->id."' class='item level_".$item->level."'><a href='".$link."'>".$item->name."</a></li>";
			}
			if($item->parent_id ==  $root_parrent){
				echo "<li id='pr_".$item->id."' class='item level_".$item->level."'><a href='".$link."'>".$item->name."</a></li>";
			}
		}
		?>
	</ul>
        
 
        <ul class='product_menu  product_menu-<?php echo $style; ?>  ' >
	 	<?php 
//	 	print_r($list);
	$Itemid  = 5;
	$root_parrent = 0;
	foreach ($list as $item){
		 	$link = FSRoute::_('index.php?module=products&view=cat&id='.$item->id.'&ccode='.$item->alias);
		if($item -> level == 0){
			echo "<li class='item  ' id='pr_".$item -> id."' >";
	        echo "<a href='".$link."' ><span> ".$item -> name."</span></a>  ";
		}
	}
	?>
	 </ul> 	
	