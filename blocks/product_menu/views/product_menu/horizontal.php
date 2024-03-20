<?php global $tmpl;
	$tmpl -> addStylesheet('product_menu','blocks/product_menu/assets/css');
?>
 <div class='cat_menu cat_menu-<?php echo $style; ?>'>
 	<ul>
	<!--	CONTENT -->
	 	<?php 
		 	$Itemid  = FSInput::get('Itemid',1,'int'); 
		 	$total = count(@$list); 
		 	$i = 0;
		 	$count_children = 0;
		 	$summner_children = 0;
//		 	echo "<li class='item first_item ".($Itemid == 1? 'activated':'')."' ><a href='".URL_ROOT."' ><span> Trang ch?</span></a>  </li>";
//		 	echo "<li class='sepa' ><span>&nbsp;</span></li>";
		 	foreach ( $list as $item ) { 
		 		$class = '';
		 	 	if($need_check){
                	$class =  $item -> alias ==  $ccode ? 'activated':'';
                }
		 		if($i == 0)
		 			  $class .= ' first-item';
		 		if($i == ($total -1))
		 			  $class .= ' last-item';
		 		
		 		
		 			$count_children ++;
		 			if($count_children == $summner_children && $summner_children)
		 				 $class .= ' last-item';
		 			$link = FSRoute::_('index.php?module=products&view=cat&ccode='.$item->alias.'&Itemid=7');
		 			echo "<li><a href='".$link."' class='item $class '  ><span> ".$item -> name."</span></a></li> ";
		 			
		 		// sepa
//		 		if($i < $total - 1)
//		 			echo "<li class='sepa' ><span>&nbsp;</span></li>";

		 		//bread line
//		 		if($i == (ceil($total/2) - 1))
//					echo '<br/>';
		 			
		 		$i ++;
		 	}
		 	?>
	<!--	end CONTENT -->
	</ul>
</div>
 