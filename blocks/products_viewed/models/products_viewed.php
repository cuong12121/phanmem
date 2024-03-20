<?php 
class Products_viewedBModelsProducts_viewed  extends FSModels
{
	function __construct()
	{
	}

	function getProductsee($product_alias){
            $query = "  SELECT id,name,alias,category_alias,category_id ,image,price,price_old,quantity,alias,discount,types,is_hot,is_new,style_types,type FROM fs_products WHERE alias = '$product_alias'";
            global $db;
            $db->query($query);
            return $db->getObject();
        }
      

    function get_types(){
        global $db;
            $query = "SELECT id,name
                 FROM fs_products_types
                 WHERE  published = 1

                 ORDER BY ordering
            ";
        if(!$query)
            return;
        $sql = $db->query($query);
        $result = $db->getObjectListByKey('id');
        return $result;
    }
     function setCookie() {
            $listProduct = array();
            $code = FSInput::get('code');
            if(isset($_SESSION['products']) && in_array($code, $_SESSION['products'])){
            	$ss_products = isset($_SESSION['products'])?$_SESSION['products']:null;
                $count = 0;
                if(!empty($ss_products)){
                    $count = count( $ss_products);
                }
                
                if($count>=10)
                	array_shift($_SESSION['products']);
                $_SESSION['products'][] = $code;
            }else{
            	$_SESSION['products'][] = $code;
            }

            if (isset($_SESSION['products'])) {
            	$_SESSION['products'] = array_unique($_SESSION['products'], 0);
                foreach ($_SESSION['products'] as $value) {
                    $product = $this->getProductsee($value);
                    $listProduct[] = $product;
                }
            }
            return array_reverse($listProduct);
        }

}

?>