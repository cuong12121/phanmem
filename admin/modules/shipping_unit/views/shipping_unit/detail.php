<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css" />
<script type="text/javascript" src="templates/default/js/jquery-ui.min.js"></script>

<!-- HEAD -->
	
	<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
    //$this -> dt_form_begin(1,4,$title.' '.FSText::_('Banking'));
    $this -> dt_form_begin();
    include_once 'detail_base.php';
    $this -> dt_form_end(@$data,1,0);
?>

<!-- END BODY-->
