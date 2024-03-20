<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/jquery.ui/jquery-ui.js"></script>

<link type="text/css" rel="stylesheet" media="all" href="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="<?php echo URL_ROOT; ?>/libraries/jquery/colorpicker/js/eye.js"></script>

<!-- FOR TAB -->	
<script>
	$(document).ready(function() {
		$("#tabs").tabs();
	});
</script>

<!-- HEAD -->
<?php 

$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  


$this -> dt_form_begin();
?>
<div id="tabs">
	<ul>	
		<li><a href="#fragment-1"><span><?php echo FSText::_("Thông tin"); ?></span></a></li>
		<li><a href="#fragment-2"><span><?php echo FSText::_("Danh sách vị trí"); ?></span></a></li>
	</ul>

	<!--	BASE FIELDS    -->
	<div id="fragment-1">
		<?php include_once 'detail_base.php';?>
	</div>
	<!--	IMAGE FIELDS    -->
	<div id="fragment-2">
		<?php include_once 'detail_positions.php';?>
	</div>
</div>

<?php $this -> dt_form_end(@$data,1,0); ?>