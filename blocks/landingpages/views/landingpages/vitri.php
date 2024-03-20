<?php
	global $tmpl,$is_mobile,$config; 
	FSFactory::include_class('fsstring');
	$tmpl -> addStylesheet("vitri","blocks/landingpages/assets/css");
	$tmpl -> addScript("vitri","blocks/landingpages/assets/js");
	$tmpl -> addScript('lightbox','libraries/jquery/lightbox2');
$tmpl -> addStylesheet('lightbox','libraries/jquery/lightbox2');
?>

<?php
	$link = FSRoute::_("index.php?module=contents&view=content&code=gioi-thieu&ccode=thong-tin-chung&id=52");
?>
<div class="landingpages_vitri">
	<?php 
		foreach ($list_content as $item) {

	?>
<?php if($item->id==2) {?>
	<div class="body-landingpages_vitri cls">
		<div class="content-bl">
			<div class="body_img">
				<a href="<?php echo URL_ROOT.str_replace('/original/','/large/', $item -> image); ?>" data-lightbox="roadtrip">
					<img src='<?php echo URL_ROOT.str_replace('/original/','/large/', $item -> image); ?>' alt='<?php echo $item->name;?>'>
				</a>
				
			</div>
			<div class="description-bl">
				<?php
					echo $item -> content;
					// if(!$is_mobile){ 
					// 	echo $item -> content;
					// }else{
					//  	echo FSString::getWord(50,$item -> content);

					
				?>
			</div>
		</div>


	</div>
<?php } ?>

	<?php } ?>

	
</div>


