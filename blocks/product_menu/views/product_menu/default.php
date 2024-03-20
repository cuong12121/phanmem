
<?php global $tmpl;
	$tmpl -> addStylesheet('product_menu','blocks/product_menu/assets/css');
//	$tmpl -> addScript('product_menu','blocks/product_menu/assets/js');
?>
	<!--	CONTENT -->
        <ul class='product_menu_default  product_menu_default-<?php echo $style; ?>' >
	 	<?php 
	 	$Itemid  = 5; // config
        $num_child = array();
        $parant_close = 0;
	 	$i = 0;
	 	$count_children = 0;
	 	$summner_children = 0;
	 	$id = 0;
	 	if($need_check)
	 		$id = FSInput::get('id',0,'int');
	 		
        $total = count($list);
		 	foreach ( $list as $item ) { 
                $class = '';
                if($need_check){
                	$class =  $item -> alias ==  $ccode ? 'activated':'';
                }
                $link = FSRoute::_('index.php?module=products&view=cat&id='.$item->id.'&ccode='.$item->alias.'&Itemid='.$Itemid);
                
		 		$class  .= ' level_'.$item -> level;
		 		if($i == 0)
		 			  $class .= ' first-item';
		 		if($i == ($total -1))
		 			  $class .= ' last-item';
		 		
                if($item -> level ){
		 			$count_children ++;
		 			if($count_children == $summner_children && $summner_children)
		 				 $class .= ' last-item';

		 			echo "<li class='item $class child_".$item->parent_id."' ><h2 class='h2_".$item->level."'><a href='".$link."'  ><span> ".$item -> name."</span></a></h2>  ";
                } else {
                    $count_children = 0;
                    $summner_children = $item -> children;
//                    if($summner_children){
//	                    echo "<li class='point plus point_change' id='pr_".$item -> id."' >";
//	                    echo "  <span> ".$item -> name."</span> </li>";
//                    } else {
                    	echo "<li class='item $class  ' id='pr_".$item -> id."' >";
//                        echo "  <span> ".$item -> name."</span> </li>";
                        echo "<h2 class='h2_".$item->level."'><a href='".$link."' ><span> ".$item -> name."</span></a></h2>  ";
//                    }
                } 
            ?>
            <!--<li class='<?php echo $class;?> <?php echo $item->children > 0? 'category cat_close ':'new new_close'; ?> ' id = '<?php echo 'pr_'.$item->id; ?>'>
                <span  >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <a href='<?php echo $link; ?>'><?php echo FSText::_(trim($item->name)); ?></a>
            </li>
        --><?php 
            $num_child[$item->id] = $item->children ;
            if($item->children  > 0){
            	if($item -> level)
                	echo "<ul id='c_".$item->id."' class='wrapper_children wrapper_children_level".$item -> level."' style='display:none' >";
                else 
                	echo "<ul id='c_".$item->id."' class='wrapper_children_level".$item -> level."' >";
            }

            if(@$num_child[$item->parent_id] == 1) 
            {
                // if item has children => close in children last, don't close this item 
                if($item->children > 0)
                {
                    $parant_close ++;
                }
                else
                {
                    $parant_close ++;
                    for($i = 0 ; $i < $parant_close; $i++)
                    {
//                      echo "<li class='sub-footer'></li></ul>";
                        echo "</ul>";
                    }
                    $parant_close = 0;
                    $num_child[$item->parent_id]--;
                }
                
                if(( (@$num_child[$item->parent_id] == 0) && (@$item->parent_id >0 ) ) || !$item->children )
                {
                  echo "</li>";
                }
                if(@$num_child[$item->parent_id] >= 1) 
                    $num_child[$item->parent_id]--;
            }   
                
            
            if(isset($num_child[$item->parent_id] ) && ($num_child[$item->parent_id] == 1) )
                echo "</ul>";
            if(isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] >= 1) )
                $num_child[$item->parent_id]--;
                  
        }
            ?>
         </ul>
	<!--	end CONTENT -->

 