<?php 
	class SearchBModelsSearch
	{
		function __construct()
		{
		}
		
	    function get_ajax_search(){
            global $db;
            $sql_where = '';
            $term = FSInput::get('term', '');
            if($term)
                $sql_where = ' AND `name` LIKE \'%'.$term.'%\'';
            $query = '  SELECT id, name 
                        FROM fs_products 
                        WHERE published = 1 '.$sql_where.'
                        ORDER BY ordering DESC
                        LIMIT 5';
            $sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
        }
	}
?>