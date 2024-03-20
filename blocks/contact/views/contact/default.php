<?php
global $config, $tmpl;
$tmpl -> addScript('contact','blocks/contact/assets/js');
$tmpl -> addStylesheet('contact','blocks/contact/assets/css');
//$tmpl -> addScript('jquery.modalbox-latest-min','libraries/jquery/jquery.modalbox-1.5.0/js');
//$tmpl -> addStylesheet('jquery.modalbox','libraries/jquery/jquery.modalbox-1.5.0/css');
//FSFactory::include_class('fsstring');
?>	
<div class="contact_menu "> 
    <p><?php echo $config['address'];?></p>
    <p><span title="hotline"><?php echo $config['hotline'];?></span></p> 	

    
    <div class="address">
    	<div class="address_wapper">
    		<div class="address_wapper_right">
    				<a class="directCallData" href="<?php echo  FSRoute::_("index.php?module=contact") ;?>">
    					<img class="zoom-image" alt="<?php echo $item->name; ?>" src="<?php echo URL_ROOT.'blocks/contact/assets/images/bg-maps.png'?>"/>		    
                        <span>(Google Maps)</span>
                    </a>
    		</div>
    	</div>
    </div>
 


</div>

