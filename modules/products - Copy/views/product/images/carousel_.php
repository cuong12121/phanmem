<?php 
global $tmpl;

// $tmpl -> addScript('product_images_carousel','modules/products/assets/js');
// $tmpl -> addStylesheet('product_images_carousel','modules/products/assets/css');
$i=0;$j=0;
// $array1 = array("0" => $data);
// $product_images_new = array_merge($array1, $product_images);
// $total =count($product_images_new);
?>
<!-- <img src="<?php //echo URL_ROOT.str_replace('/original/','/large/', $data -> image); ?>" class="img-responsive" > -->
<a class="hidden-xs" href="javascript:void(0);">
	<img  property="image" property="image"  src="<?php echo image_to_bytes(URL_ROOT.$data -> image,'cut_image',400,460); ?>" class="img-responsive" >			 				
</a>


							

