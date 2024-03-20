<?php 
	$title = FSText::_('L&#7921;a ch&#7885;n loại'); 
	global $toolbar;
	$toolbar->setTitle($title);
	//$toolbar->addButton('add',FSText::_('Th&#234;m m&#7899;i'),'','add.png'); 
	$toolbar->addButton('cancel',FSText::_('Tho&#225;t'),'','cancel.png'); 
	
?>
<!-- BODY-->
	<!--	CONTENT -->
        <ul class='product_types' >
	 	<?php 
        $total = count($types);
		 	foreach ( $types as $item ) { 
                $class = '';
                $link = 'index.php?module=sales&view=sales&task=add&type='.$item  -> id;
		 			echo "<li class='item' ><a  href='".$link."'  ><span> ".$item -> name."</span></a></li>  ";
            
        	}
        ?>
	<!--	end CONTENT -->
</ul>
<style>
.product_types{
	line-height: 25px;
    font-size: 15px;
}
.product_types a:hover{
	color: #00AFF0;
	display: block;
}
</style>
