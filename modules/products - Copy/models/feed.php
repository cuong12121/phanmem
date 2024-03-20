<?php 
	class ProductsModelsFeed  extends FSModels {
		
		
		function get_list()
		{
			return $this -> get_records('published = 1 AND is_feed = 1','fs_products','id,name,code,summary,image,price,quantity,alias ,category_alias,is_accessories ,is_new,is_hot,promotion_info,manufactory_name,manufactory,category_name',' ordering DESC, id DESC ');
			
		
		}
		
		
	}
	
?>