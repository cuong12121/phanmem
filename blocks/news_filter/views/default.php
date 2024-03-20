<?php 
global $tmpl;
	$tmpl -> addStylesheet('styles','blocks/news_filter/assets/css');
	$tmpl -> addScript('script','blocks/news_filter/assets/js');
	$ccode = FSInput::get('ccode');

?>
<div class='news_filter'>
	<div id='cssmenu'>
       <h2><?php echo FSText::_("Tin tức"); ?></h2>
	   <ul style="display: block;" id="sf-cate"><!-- leve 0 -->
	      	<?php 
		      	$id = 0;
		 		if($need_check)
		 		$id = FSInput::get('id',0,'int'); 

		       	foreach ($product_category as $item) { 
		      	 $class = '';
	                if($need_check){
	                	$class =  $item -> id ==  $cid ? 'active':'';
	                }
		      	 $link = FSRoute::_('index.php?module=news&view=cat&ccode='.$item->alias.'&cid='.$item->id.'&cid='.$item->id); 
	      	?>

	      	
	         <li class='parent has-sub <?php echo  $item -> alias ==  $ccode ? 'active':''; ?>' >
		       <a class=" level_0 <?php echo  $item -> alias ==  $ccode ? 'selected':''; ?>" rel="nofollow" href='<?php echo $link; ?>' title="<?php echo $item->name ?>"> <span><?php echo $item->name ?></span></a>
                    <ul><!-- leve 1 -->
	                <?php foreach ($category_level1 as $cate_leve1) { 

	                 $link_level1 = FSRoute::_('index.php?module=news&view=cat&ccode='.$cate_leve1->alias.'&cid='.$cate_leve1->id);

	                 ?>
	                   <?php if($cate_leve1-> parent_id ==  $item-> id){ ?>
	                  <li class="parent_2 has-sub <?php echo  $cate_leve1 -> alias ==  $ccode ? 'active':''; ?>">
	                  	<a class=" level_1 <?php echo  $cate_leve1 -> alias ==  $ccode ? 'selected':''; ?>" rel="nofollow" href='<?php echo $link_level1; ?>' title="<?php echo $cate_leve1->name ?>"><span><?php echo $cate_leve1->name ?></span></a>
	                     <?php if(count($category_level2)){?>
		                     <ul><!-- leve 2 -->
		                        <?php foreach ($category_level2 as $cate_leve2) { 
		                        		$link_level2 = FSRoute::_('index.php?module=news&view=cat&ccode='.$cate_leve2->alias.'&cid='.$cate_leve2->id);
		                        	?> 
	
		                           <?php if($cate_leve2-> parent_id ==  $cate_leve1-> id){ ?>
		                              <li class="<?php echo  $cate_leve2 -> alias ==  $ccode ? 'active':''; ?> ">
		                              	<a class="<?php echo  $cate_leve2 -> alias ==  $ccode ? 'selected':''; ?> " rel="nofollow" href='<?php echo $link_level2; ?>' title="<?php echo $cate_leve2->name ?>"><span><?php echo getword(6,$cate_leve2->name); ?></span></a>
		                             </li>
		                           <?php } ?>
		                        <?php } ?>
		                     </ul>
						<?php } ?>					
	                  </li>
	                  <?php } ?>
	               <?php } ?>
	            </ul>
	         </li>

	     <?php } ?>
	   </ul>
	</div>
<!-- 	<?php 

	//include_once 'default_manufactories.php';
	

	?>  -->
</div>
<div class="clear"></div>