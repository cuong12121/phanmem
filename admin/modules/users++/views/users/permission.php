


<?php 
	if($_SESSION['ad_userid'] !=9){
		echo "Bạn không có quyền này";
		die;
	}
 ?>

<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>

<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/colorpicker/css/colorpicker.css" />
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="../libraries/jquery/colorpicker/js/eye.js"></script>

<!-- FOR TAB -->	
 <script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
	<?php 
	
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('permission_apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('permission_save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png');  
	$this -> dt_form_begin(0);
	?>
<!-- END HEAD-->

		<div id="tabs">
		    <ul>
		        <li><a href="#fragment-1"><span><?php echo FSText::_("Quyền trên modules"); ?></span></a></li>

		        <!-- <li><a href="#fragment-2"><span><?php echo FSText::_("Quyền trên nội dung"); ?></span></a></li> -->

				
				
		    </ul>
			
			<!--	BASE FIELDS    -->
		    <div id="fragment-1">
				<?php include_once 'permission_base.php';?>
			</div>
		    <!--	END BASE FIELDS    -->
		    
		    <!--	IMAGE FIELDS    -->
		    <div id="fragment-2">
		     <?php //include_once 'permission_other.php';?>
		    </div>
		   
		    
	    </div>
<?php 
$this -> dt_form_end(@$data,0);
?>