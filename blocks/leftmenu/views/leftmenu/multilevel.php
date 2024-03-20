<?php 
global $tmpl;
$tmpl -> addStylesheet('multilevel','blocks/mainmenu/assets/css');
//$tmpl -> addStylesheet('superfish','libraries/jquery/superfish-1.4.8/css');
$tmpl -> addScript('hoverIntent','libraries/jquery/superfish-1.4.8/js');
$tmpl -> addScript('superfish','libraries/jquery/superfish-1.4.8/js');
$tmpl -> addScript('menu_animation','blocks/mainmenu/assets/js');
?>
 <div class='mainmenu mainmenu-<?php echo $style; ?>'>

<?php 
$Itemid = 7;
$root_total = 0;
$root_last = 0;
for($i = 1 ; $i <= count($list); $i++)
{
	if(@$list[$i]->level == 0){
		$root_total ++ ;
		$root_last = $i;
	}
}
?>
<?php $url = $_SERVER['REQUEST_URI'];?>
<?php $url = substr($url,strlen(URL_ROOT_REDUCE));?>
<?php $url = URL_ROOT.$url; ?>
<ul id="navmenu-v1" class="menu catmenu sf-menu">
	<li class='item level0  first_item <?php echo $Itemid == 1? 'activated':''; ?>' ><a href='<?php echo URL_ROOT; ?>' ><span> Trang chủ</span></a>  </li>
	<li class='sepa' ><span>&nbsp;</span></li>
	<?php
	$html = ""; 
	$i = 1;
	$num_child = array();
	$parant_close = 0;
	foreach ($list as $item) {?>
		<?php 
				$link = FSRoute::_($item ->link.'&Itemid='.$item -> id);
			$class = '';
			$class .= ' level'.$item->level;
			
    		if($url == $link) $class .= ' activated ';
			
			// level = 1
			if($item->level==0)
			{
				if($i == 1)
					$class .= ' first-item';
				if($i == ($root_last-1) )
					$class .= ' last-item';
				if($i != ($root_last-1))
					$class .= ' menu-item';
			}
			
			// level > 1
			else
			{
				$parent = $item->parent_id;
				// total children
				$total_children_of_parent = @$list[$parent]->children;
				if(isset($num_child[$parent]))
				{
					if($total_children_of_parent == $num_child[$parent])
					{
						$class .= " first-sitem ";	
					}
					else
					{
						$class .= " mid-sitem ";	
					}
				}
			}
		
		$html .= "<li class=' $class' >\n";
        $html .= "	<a href='$link'>";
        $name   = $item -> name;
        if(strlen($name) > 28 && $item -> level > 0)
        	$name = getWord(4,$name)."...";
        
        $html .= "		$name ";
        $html .= "	</a>\n";
        	
		// browse child
		$num_child[$item->id] = $item->children ;
		if($item->children  > 0)
			 $html .= "		<ul>";
		
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
					$html .= "	</li><li class='sepa' ><span>&nbsp;</span></li>";
					$html .= "	<li class='sub-footer'>&nbsp;</li>";
					$html .= "</ul>";
				}
				$parant_close = 0;
				$num_child[$item->parent_id]--;
			}
		}
		if(( (@$num_child[$item->parent_id] == 0) && (@$item->parent_id >0 ) ) || !$item->children )
		{
			$html .= "</li><li class='sepa' ><span>&nbsp;</span></li>";
		}
		if(@$num_child[$item->parent_id] >= 1) 
			$num_child[$item->parent_id]--;
			  
		$i ++;
	}
	echo $html;
	?>
	<!-- NEWS_TYPE for menu	-->
    	
    </ul>
</div>
