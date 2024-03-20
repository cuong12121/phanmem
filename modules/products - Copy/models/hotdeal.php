
<?php 
class ProductsModelsHotdeal extends FSModels
{
	var $limit;
	var $page;
	function __construct()
	{
		$page = FSInput::get('page');
		$this->page = $page;
		$limit = 20;
		$this->limit = $limit;
	}


		/* return query run
		 * get products list in category list.
		 * These categories is Children of category_current
		 */
		function set_query_body()
		{
			$fs_table = FSFactory::getClass('fstable');
			$where = "";
			
			$where .= " AND a.id = b.product_id";

			$sql   = "  FROM fs_products as a LEFT JOIN fs_sales_products as b ON a.id = b.product_id WHERE published =1 and category_published = 1 ".
			$where ;



			return $sql;
			
		}
		function get_list($query_body)
		{
			if(!$query_body)
				return;

			global $db;

			$query = " SELECT a.id,a.name,a.alias,a.category_id,a.category_alias_old,a.category_id_wrapper,a.category_alias,b.*,a.image,a.types,a.is_hot,a.style_types,a.is_new,a.type";
			$query .= $query_body;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			return $result;
			
		}

		function get_categorys() {
			$today_time = date('Y-m-d H:i:s');
			// $where = "published = 1 AND type = 1 AND  started_time < '".$today_time ."' AND finished_time > '".$today_time."'";
			$where = "published = 1 AND type = 1 ";
			global $db;
			$query = " SELECT *
			FROM fs_sales 
			WHERE ".$where."
			ORDER BY ordering
			";
			$db->query($query);
			$list = $db->getObjectList();
			return $list;	
		}

		function get_category_default() {
			$today_time = date('Y-m-d H:i:s');
			$where = "is_default = 1 AND type = 1 AND published = 1 AND started_time < '".$today_time ."' AND finished_time > '".$today_time."'";
			global $db;
			$query = " SELECT *
			FROM fs_sales 
			WHERE ".$where."
			ORDER BY ordering
			";
			$db->query($query);
			$list = $db->getObject();
			return $list;	
		}

		function get_sale_being($type){
			$today_time = date('Y-m-d H:i:s');
			$fs_table = FSFactory::getClass ( 'fstable' );
			$query = " SELECT id,name,started_time
			FROM " . $fs_table->getTable ( 'fs_sales' ) . "
			WHERE is_default = 1 AND published = 1 AND started_time > '".$today_time ."' AND type =".$type.  " ORDER BY started_time ASC, ordering ASC";
			global $db;
			$sql = $db->query ( $query );
			$result = $db->getObject ();
			return $result;
		}


		function getProducts($cat_id){
			global $db;
			$where = "";
			
			$where .= " AND a.id = b.product_id";

			$sql   = "SELECT a.id,a.name,a.alias,a.alias_old,a.category_id,a.category_alias_old,a.category_id_wrapper,a.category_alias,b.price,b.price_old,b.price_id,b.product_id,b.sale_id,b.price_id,a.image,a.types,a.is_hot,a.style_types,a.is_new,a.type,b.total_item,b.total_item_buy FROM fs_products as a LEFT JOIN fs_sales_products as b ON a.id = b.product_id WHERE  b.sale_id = ".$cat_id." AND a.published =1 and a.category_published = 1 ".$where . ' ORDER BY b.ordering ASC' ;

			$db->query($sql);

			$result = $db->getObjectList();
			// print_r($result);

			return $result;

		}
		function set_query_select(){
			$query = " SELECT id,name,summary,image,price,price_old,quantity,alias,category_alias,category_id, discount,manufactory_alias,manufactory_image,manufactory_name,summary_auto ,types,warranty,(price_old - price)/price_old as discount_rate ";
			return $query;
		}
		function getTotal($query_body){
			global $db;
			$query = "SELECT count(*) ";
			$query .= $query_body;
			$db->query($query);
			$total = $db->getResult();
			return $total;
		}
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
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
		
	}
	
	?>