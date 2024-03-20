<?php
/*
 * Huy write
 */
include 'blocks/discount/models/discount.php';

class DiscountBControllersDiscount {
	function __construct() {
	}
	function display($parameters, $title) {
		$model = new DiscountBModelsDiscount();
		$discount_id = $parameters->getParams ( 'discount_id' );
		$discount = $model -> get_data($discount_id);
//		if(!$discount)
//			return;
		$style = $parameters->getParams ( 'style' );
		include 'blocks/discount/views/discount/' . $style . '.php';
	}
}
?>