<?php global $tmpl;
	$tmpl -> addStylesheet('product_menu','eblocks/product_menu/assets/css');
?>
 <div class='mainmenu mainmenu-<?php echo $style; ?>'>
   <ul>
	<!--	CONTENT -->
	 	<?php 
		 	$Itemid  = FSInput::get('Itemid',1,'int'); 
		 	$total = count(@$list); 
		 	global $econfig;
		 	$i = 0;
		 	$count_children = 0;
		 	$summner_children = 0;
//		 	echo "<li class='item first_item ".($Itemid == 1? 'activated':'')."' ><a href='".URL_ROOT."' ><span> Trang ch?</span></a>  </li>";
//		 	echo "<li class='sepa' ><span>&nbsp;</span></li>";
		 	foreach ( $list as $item ) { 
		 		$class =  $item -> id ==  $Itemid ? 'active':'';
		 		if($i == 0)
		 			  $class .= ' first-item';
		 		if($i == ($total -1))
		 			  $class .= ' last-item';
		 		
		 		
		 			$count_children ++;
		 			if($count_children == $summner_children && $summner_children)
		 				 $class .= ' last-item';
		 			$link = FSRoute::_($item ->link.'&Itemid='.$item -> id);
		 			$target = $item -> target == '_blank' ? 'target="_blank"':'';
		 			echo "<li class='item $class ' ><a href='".$link."' ".$target." ><span> ".$item -> name."</span></a>  </li>";
		 			
		 		// sepa
		 		if($i < $total - 1)
		 			echo "<li class='sepa' ><span>&nbsp;</span></li>";
		 		$i ++;
		 	}
		 	?>
	 </ul>
	<!--	end CONTENT -->
</div>
 