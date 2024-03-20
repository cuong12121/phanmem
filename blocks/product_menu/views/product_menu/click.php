<?php
global $tmpl;
$tmpl->addStylesheet ( 'click', 'blocks/product_menu/assets/css' );
$tmpl->addScript ( 'product_menu_click', 'blocks/product_menu/assets/js' );
$Itemid = 5; // config
$num_child = array ();
$parant_close = 0;
$i = 0;
$count_children = 0;
$summner_children = 0;

$html_normal = '';
$html_normal = '';
$total = count ( $list );
// echo "<pre>";
// print_r($group_has_parent_activated);
foreach ( $list as $item ) {
	$class = '';
	$class .= ' level_' . $item->level;
	if ($item->children > 0) {
		$class .= ' parent';

	}
	// if ($i == 0)
	// 	$class .= ' first-item';
	// if ($i == ($total - 1))
	// 	$class .= ' last-item';
	
	$group_activated = 0;
	$link = FSRoute::_ ( 'index.php?module=products&view=cat&cid=' . $item->id . '&ccode=' . $item->alias . '&Itemid=' . $Itemid );
	if (in_array ( $item->id, $group_has_parent_activated ) || in_array ( $item->parent_id, $group_has_parent_activated )) {
		if(in_array ( $item->id, $group_has_parent_activated ))
			$class .= ' activated';
		$group_activated = 1;
		$group_has_parent_activated [] = $item->id;
	}

	
	if ($item->level) {
		$count_children ++;
		if ($count_children == $summner_children && $summner_children)
			$class .= ' last-item';
		if ($group_activated) {
			$html_normal .= '<li class="item '.$class.' child_' . $item->parent_id . '" ><h3 class="h3_' . $item->level . '"><a href="' . $link . '"  ><span> ' . $item->name .  '</span></a></h3>  ';
		} else {
			$html_normal .= "<li class='item $class child_" . $item->parent_id . "' ><h3 class='h3_" . $item->level . "'><a href='" . $link . "'  ><span> " . $item->name . "</span></a></h3>  ";
		}
	} else {
		$count_children = 0;
		$summner_children = $item->children;
		if ($group_activated) {
			$html_normal .= "<li class='item $class  ' id='pr_" . $item->id . "' >";
			$html_normal .= '<a href="' . $link . '" ><span><svg  viewBox="0 0 512 512"  ><path  style="fill: currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z" class=""></path></svg> ' . $item->name.'</span></a>';
		} else {
			$html_normal .= "<li class='item $class  ' id='pr_" . $item->id . "' >";
			$html_normal .= '<a href="' . $link . '" ><span> <svg  viewBox="0 0 512 512"  ><path  style="fill: currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zm113.9 231L234.4 103.5c-9.4-9.4-24.6-9.4-33.9 0l-17 17c-9.4 9.4-9.4 24.6 0 33.9L285.1 256 183.5 357.6c-9.4 9.4-9.4 24.6 0 33.9l17 17c9.4 9.4 24.6 9.4 33.9 0L369.9 273c9.4-9.4 9.4-24.6 0-34z" class=""></path></svg>' . $item->name . '</span></a> ';
		}
	}
	$num_child [$item->id] = $item->children;
	if ($item->children > 0) {
		if ($item->level) {
//			if ($group_activated) {
//				$html_normal .= "<ul id='c_" . $item->id . "' class='wrapper_children wrapper_children_level" . $item->level . "' style='display:none' >";
//			} else {
//				$html_normal .= "<ul id='c_" . $item->id . "' class='wrapper_children wrapper_children_level" . $item->level . "' style='display:none' >";
//			}
			if ($group_activated) {
				$html_normal .= "<ul id='c_" . $item->id . "' class=' hide wrapper_children wrapper_children_level" . $item->level . "'  >";
			} else {
				$html_normal .= "<ul id='c_" . $item->id . "' class='hide wrapper_children wrapper_children_level" . $item->level . "'  >";
			}
		} else {
			if ($group_activated) {
				$html_normal .= "<ul id='c_" . $item->id . "' class='hide wrapper_children_level" . $item->level . "' >";
			} else {
				$html_normal .= "<ul id='c_" . $item->id . "' class='hide wrapper_children_level" . $item->level . "   '  >";
			}
		}
	}
	
	if (@$num_child [$item->parent_id] == 1) {
		// if item has children => close in children last, don't close this item 
		if ($item->children > 0) {
			$parant_close ++;
		} else {
			$parant_close ++;
			for($i = 0; $i < $parant_close; $i ++) {
				if ($group_activated) {
					$html_normal .= "</ul>";
				} else {
					$html_normal .= "</ul>";
				}
			}
			$parant_close = 0;
			$num_child [$item->parent_id] --;
		}
		
		if (((@$num_child [$item->parent_id] == 0) && (@$item->parent_id > 0)) || ! $item->children) {
			if ($group_activated) {
				$html_normal .= "</li>";
			} else {
				$html_normal .= "</li>";
			}
		}
		if (@$num_child [$item->parent_id] >= 1)
			$num_child [$item->parent_id] --;
	}
	
	if (isset ( $num_child [$item->parent_id] ) && ($num_child [$item->parent_id] == 1)) {
		if ($group_activated) {
			$html_normal .= "</ul>";
		} else {
			$html_normal .= "</ul>";
		}
	}
	if (isset ( $num_child [$item->parent_id] ) && ($num_child [$item->parent_id] >= 1))
		$num_child [$item->parent_id] --;

}
?>
<ul class="block_body product_menu-click" >
   <?php echo $html_normal; ?>

</ul>

