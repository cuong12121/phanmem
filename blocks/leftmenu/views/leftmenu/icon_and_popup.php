<?php global $tmpl;
	$tmpl -> addStylesheet('icon_and_popup','blocks/mainmenu/assets/css');
?>
<?php
$arr_root = array();
$arr_children = array();
$current_root = 0;
foreach($list as $item){
	if($item -> level == 0){
		$arr_root[] = $item;
		$current_root = $item -> id;
	}else if($item -> level == 1){ 
		if(!isset($arr_children[$item-> parent_id]))	
			$arr_children[$item-> parent_id] = array();
		$arr_children[$item-> parent_id][] = $item;
	}else{
		$arr_children[$current_root][] = $item;
	}
}
?>
<div class="navbar">
	<div class="navbar-inner">
    	<ul class='nav'>
    		<?php $url = $_SERVER['REQUEST_URI'];?>
    		<?php $url = substr($url,strlen(URL_ROOT_REDUCE));?>
    		<?php $url = URL_ROOT.$url; ?>
    		<?php if(isset($list) && !empty($list)){?>
    			<?php $i = 0;?>
    			<?php foreach($arr_root as $item){?>
	    			<?php $link = FSRoute::_($item->link);?>
	    			<?php $class= 'menu-item ';?>
	    			<?php if($i == 0) $class .= 'menu-item-first ';?>
	    			<?php if($i == (count($arr_root)-1)) $class .= 'menu-item-last ';?>
	    			<?php if($url == $link) $class .= 'activated';?>
	    			
	    			
		    			<?php if($i):?>
<!--		    			<li class="divider-vertical">-->
<!--			            </li>-->
		    			<?php endif;?>
			        	<li class="<?php echo $class;?> level_0">
			            	<div class="div-menu">
			                	<span class="img-menu"><a href="<?php echo $link;?>"  title="<?php echo $item->name;?>"><img src="<?php echo URL_ROOT.$item->image;?>" alt="<?php echo $item->name;?>" /></a></span>
			                    <span class="text-menu"><a href="<?php echo $link;?>"  title="<?php echo $item->name;?>"><?php echo $item->name;?></a></span>
			                </div>
			                <?php if(isset($arr_children[$item -> id]) && count($arr_children[$item -> id])){?>
				                <ul class='sub_menu' >
					                <div class='sub_menu_wrapper' >
					                		<?php foreach($arr_children[$item -> id] as $child){?>
					                			<li class='level_<?php echo $child -> level;?>'>
					                				<?php $link_child = FSRoute::_($child->link);?>
					                				<a href="<?php echo $link_child;?>" title="<?php echo $child->name;?>"><?php echo $child->treename;?></a>
					                			</li>
					                		<?php }?>
					                </div>	
				                </ul>
			                <?php } // if(isset($arr_children[$item -> id]) && count($arr_children[$item -> id]))?>
			            </li>
		            	<?php $i ++;?>
		            <?php } // end foreach($list as $item)?>
            <?php }  // end if(isset($list) && !empty($list))?>
        </ul>
    </div>
</div>