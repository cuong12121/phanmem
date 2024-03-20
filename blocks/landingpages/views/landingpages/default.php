<?php
global $tmpl,$is_mobile,$config; 
FSFactory::include_class('fsstring');
$tmpl -> addStylesheet("default","blocks/landingpages/assets/css");
// $tmpl -> addScript("default","blocks/landingpages/assets/js");

?>

<?php
?>

<div class="landingpages landingpages_js">
	<div class="container">
	<?php foreach ($list as $item) {?>
		<style>
			<?php echo $item->css; ?>
		</style>
		
		<?php echo $item->html; ?>
		<?php echo $item->js; ?>
	<?php } ?>
	</div>
</div>


