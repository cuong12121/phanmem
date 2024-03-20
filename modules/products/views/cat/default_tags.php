<?php 
echo '<div class="product_tags">';
if(!empty($tag_group)){
	//echo '<font>Tags: </font>';
	echo '<span>';
	$i = 0;
	foreach ($tag_group as $key => $item) {
		if($item-> link) {
			$link = $item-> link;
		} else {
			$link = FSRoute::_("index.php?module=products&view=tags&code=".$item->alias."&Itemid=9");
		}
		
		if($i > 0)
		echo ' <a href="'.$link.'" title="'.$item->name .'">'.$item->name.'</a>';
		else{
		echo '<a href="'.$link.'" title="'.$item->name .'">'.$item->name.'</a>';
		}
		$i++;
	}
	echo '</span>';
	echo '<div class="clear"></div>';
}
echo '</div>';
?>