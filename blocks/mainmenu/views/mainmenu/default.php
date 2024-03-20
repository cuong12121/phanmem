<?php global $tmpl;
$tmpl -> addStylesheet('mainmenu','blocks/mainmenu/assets/css');
?>
 <div class='mainmenu mainmenu-<?php echo $style; ?>'>
   <ul>
       
	<!--	CONTENT -->
	 	<?php 
		 	$Itemid  = FSInput::get('Itemid',1,'int'); 
		 	$total = count($list); 
		 	$i = 0;
		 	$count_children = 0;
		 	$summner_children = 0;
		 	$url = $_SERVER['REQUEST_URI'];
		 	$pos1 = strpos($url,URL_ROOT_REDUCE);
			if( $pos1 !== false)
				$url  = substr($url,strlen(URL_ROOT_REDUCE));
			$url  = URL_ROOT.$url;
//    		$url = str_replace(URL_ROOT_REDUCE,'',$url);
//    		$url = str_replace(URL_ROOT_REDUCE,'',$url);
		 	
		 	echo "<li class='item first_item ".($Itemid == 1? 'activated':'')."' ><a href='".URL_ROOT."' ><span> Trang chủ</span></a>  </li>";
		 	echo "<li class='sepa' ><span>&nbsp;</span></li>";
		 	foreach ( $list as $item ) { 
		 		$class =  $item -> id ==  $Itemid ? 'activated':'';
//		 		if($i == 0)
//		 			  $class .= ' first-item';
		 		if($i == ($total -1))
		 			  $class .= ' last-item';
		 		
		 		$attr = '';
		 		if($item -> target == '_blank')
		 			$attr .= ' target="_blank " ';
		 		
	 			$count_children ++;
	 			if($count_children == $summner_children && $summner_children)
	 				 $class .= ' last-item';
	 			$link = FSRoute::_($item ->link.'&Itemid='.$item -> id);
 				if($url == $link){ 
 					$class .= 'active';
 				}else {
 					$url_1  = str_replace('.html', '',$url);
 					$link_1  = str_replace('.html', '',$link);
 					if($url_1 != URL_ROOT && (strpos($url_1,$link_1) !== false || strpos($link_1,$url_1) !== false))
 						$class .= 'activated';
 				}
 				
		 			echo "<li class='item $class ' ><a href='".$link."' ><span> ".$item -> name."</span></a>  </li>";
		 			
		 		// sepa
		 		if($i < $total - 1)
		 			echo "<li class='sepa' ><span>&nbsp;</span></li>";
		 		$i ++;
		 	}
		 	?>
	 </ul>
	<!--	end CONTENT -->
</div>
