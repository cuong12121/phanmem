<?php
	global $tmpl;
	$tmpl -> addStylesheet('aq_home','modules/aq/assets/css');
	$tmpl -> addScript('aq_home','modules/aq/assets/js');
	$page = FSInput::get('page');
    $Itemid = 7;
		
?>	
	<div class="aq_home wapper-page  wapper-page-cat">
		<div class="page_head">
		 	<h1 class="home_title page_title">
		     	<span><?php echo $cat -> name; ?> </span>
		    </h1>
		    <div class="clear"></div>
	    </div>
		<div class="wapper-content-page">
		
			<div class="cat_item_store">
				<div class="row">
							<!--	EACH PRODUCT				-->
							<?php 
							foreach($list as  $item){
							?>
								<?php include 'default_item.php';?>
							<?php 
							}
							?>		
							<!--	end EACH PRODUCT				-->
	                   
				</div>
			</div>
		</div>	
		<?php include PATH_BASE.'modules/aq/views/common/send_request.php';?>
	</div>
