<?php
global $tmpl; 
$tmpl -> addStylesheet('carousel','blocks/weblinks/assets/css');
$tmpl -> addScript('jquery.carouFredSel-6.0.4-packed','libraries/jquery/coolcarousel/js');
$tmpl -> addScript('carousel','blocks/weblinks/assets/js');
?>

<?php if(isset($data) && !empty($data)){?>
		<div class='weblinks_label'>Hệ thống website:</div>
		<div id="wrapper" class="weblinks">
			<div id="carousel">
				<ul>	
					<?php $i = 0;$j = 0; ?>
            		<?php foreach($data as $item){?>
            			<?php $link = $item -> website;?>
            			<?php 
	            			list($width, $height, $type, $attr) = getimagesize(URL_ROOT.str_replace('/original/','/resized/',$item->image));
	            			$wd=$width;
	            		?>
            				<li style="width: <?php echo $wd + 10 ; ?>px">
		                   		<a href="<?php  echo $link;?>" title="<?php echo $item -> name; ?>"  rel="nofollow" >
		                   			<img id="myimg" src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item->image);?>"  alt="<?php $item->name;?> " />		                  			
		                   		</a>
		                   		<div id="store"></div>
		                   		<?php $i++; ?>
		                   	
                	<?php }?>		
				</ul>
				<div class="clearfix"></div>
				
			</div>
		<a id="prev" class="prev" href="#">&lt;</a>
		<a id="next" class="next" href="#">&gt;</a>
		</div>
 <?php }?>	

