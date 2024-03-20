 <script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB-OFkk-WAZ4loMq93diW2kK2M80E9vcBk&libraries=geometry,places&sensor=false"></script>

<?php
global $config; 
global $tmpl;
$tmpl -> addScript('form');

$tmpl->addStylesheet('contact','modules/contact/assets/css'); 
$tmpl -> addScript('contact','modules/contact/assets/js');

// $tmpl -> addTitle('Liên hệ');

$Itemid = FSInput::get('Itemid',0);
$contact_email = FSInput::get('contact_email');
$contact_name = FSInput::get('contact_name');
$contact_address = FSInput::get('contact_address');
$contact_phone = FSInput::get('contact_phone');
$contact_fax = FSInput::get('contact_fax');
$contact_subject = FSInput::get('contact_subject');
$message = htmlspecialchars_decode(FSInput::get('message'));
?>

<div class="contact">
	
	<h1 class="img-title-cat page_title">
      <span><?php echo FSText::_("Liên hệ");?></span>
    </h1>

	<div class="row top">
		<div class="grid4">
			<?php include_once 'default_from.php'; ?>	
		</div>
		<div class="grid8">
			<div class="pll">
			  <?php include_once 'default_regions.php';?>
			</div>
		</div>
	</div>	
	
</div>