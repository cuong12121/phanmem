
  <link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<script type="text/javascript" src="templates/default/js/jquery.1.4/jquery.js"></script>
<script type="text/javascript" src="templates/default/js/jquery-ui.min.js"></script>

<!-- FOR TAB -->	
 <script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
<!-- end FOR TAB -->

<!-- HEAD -->
	
	<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
		$this -> dt_form_begin(0);
	?>
<!-- END HEAD-->

<!-- BODY-->

		<div id="tabs">
		    <ul>
		        <li><a href="#fragment-1"><span><?php echo FSText :: _("Base field"); ?></span></a></li>
		        <li><a href="#fragment-2"><span><?php echo FSText :: _("Bộ sưu tập ảnh"); ?></span></a></li>
		    </ul>
		    <!--	BASE FIELDS    -->
		    <div id="fragment-1">
		    	<?php include_once 'detail_base.php';?>
		    </div>
		    <div id="fragment-2">
		    	<?php include_once 'detail_images.php';?>
		    </div>
	   	</div>
		     
<?php 
$this -> dt_form_end(@$data,0);
?>