<!-- HEAD -->
	<?php 
	$title = FSText :: _('Cấu hình SEO, Module'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png');
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png');
    
    $this -> dt_form_begin(1,4,$title); 
?>
    <?php   include_once 'detail_seo.php';?>	
	<?php   include_once 'detail_cache.php';?>	
	<?php   include_once 'detail_params.php';?>	
<?php    
    $this -> dt_form_end(@$data,1,0); 
?>
<style>
.seo_conjugate{
	width: 50px;
}
</style>
<script type="text/javascript">
$('.help_area').mouseover(function(){
	$(this).children('.help').show();
}).mouseout(function(){
	$(this).children('.help').hide();
});
</script>