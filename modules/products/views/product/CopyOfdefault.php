<?php  	global $tmpl,$config;

$total_relative = count(@$relate_products_list);
$Itemid = 6;
$noWord = 80;

//$tmpl -> addStylesheet('jquery-ui.min','libraries/jquery/jquery.ui');
//$tmpl -> addScript('jquery-ui.min','libraries/jquery/jquery.ui');
//$tmpl -> addScript('jquery.youtubepopup.min','libraries/jquery/youtubepopup/js');

$tmpl -> addStylesheet('product','modules/products/assets/css');
$tmpl -> addScript('main');
$tmpl -> addScript('form');
$tmpl -> addScript('product','modules/products/assets/js');
?>
<div class='product mt20'>
	<div class="clearfix">
		<div class="column-left">
		<?php include_once 'images/styling.php'; ?>
		</div>
		<div class="column-right">
			<?php include_once 'default_base.php'; ?>
		</div>
		<div class='clear'></div>
	</div>
	<div class="product-tabs mt20">
		<?php if($description){ ?>
			<div class='descriptions'><?php echo $description; ?></div>
		<?php }?>
		
		<?php 	include 'comments/default_comments.php'; ?>
	</div>
</div>
<input type="hidden" value="<?php echo $data->id; ?>" name='product_id' id='product_id'  />
<?php 
$arr_relate =  array();
if(count($products_in_cat)){
	$title_relate =  'Sản phẩm tương tự';
	$list_related = $products_in_cat;
	include 'related/default_related_masory.php';	
}
//if(count($products_same_member)){
if(count($products_in_cat)){
	$title_relate =  'Sản phẩm cùng thành viên';
	$list_related = $products_in_cat;
	include 'related/default_related_masory.php';	
}
?>
