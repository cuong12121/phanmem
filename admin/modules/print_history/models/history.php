<?php 
	class Print_historyModelsHistory extends FSModels
	{
		var $limit;
		var $page;
		function __construct()
		{
			$limit = 100;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this -> table_name = 'fs_order_uploads_history_prints';
		
			parent::__construct();
		}
		
		function setQuery()
		{
			// ordering
			$ordering = '';
			$where = "  ";

			

			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND action_username LIKE '%".$keysearch."%' ";
				}
			}


			// from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
				if($date_from){
					$date_from = strtotime($date_from);
					$date_new = date('Y-m-d H:i:s',$date_from);
					$where .= ' AND a.created_time >=  "'.$date_new.'" ';
				}
			}
			
				// to
			if(isset($_SESSION[$this -> prefix.'text1']))
			{
				$date_to = $_SESSION[$this -> prefix.'text1'];
				if($date_to){
					$date_to = $date_to . ' 23:59:59';
					$date_to = strtotime($date_to);
					$date_new = date('Y-m-d H:i:s',$date_to);
					$where .= ' AND a.created_time <=  "'.$date_new.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					
					$where .= ' AND a.house_id =  "'.$filter.'" ';
				}
			}


			if(isset($_SESSION[$this -> prefix.'filter1'])){
				$filter = $_SESSION[$this -> prefix.'filter1'];
				if($filter){
					
					$where .= ' AND a.warehouse_id =  "'.$filter.'" ';
				}
			}

			if(isset($_SESSION[$this -> prefix.'filter2'])){
				$filter = $_SESSION[$this -> prefix.'filter2'];
				if($filter){
					
					$where .= ' AND a.platform_id =  "'.$filter.'" ';
				}
			}


			$wrap_id_warehouses = $this->get_wrap_id_warehouses();
			$where .= ' AND warehouse_id IN ('.$wrap_id_warehouses.')';
			
			$query = "SELECT * FROM ".$this -> table_name." AS a WHERE 1=1  " . $where. $ordering. " ";

			return $query;
		}


		//function hỗ trợ in file pdf

		function downloadMultipleFiles($urlArray, $saveFolder = PATH_BASE.'/admin/export/pdf/count_print') {
		    $results = [];

		    foreach ($urlArray as $index => $url) {
		        $fileName = '2.pdf';
		        $fileNames = basename(parse_url($url, PHP_URL_PATH));
		        // Lấy extension (pdf, xlsx, xls, etc.)
		        $ext = pathinfo($fileNames, PATHINFO_EXTENSION);
		        if (!$ext) {
		            $ext = 'bin';
		            $fileName = "file_$index.$ext";
		        }

		        $link = $this->downloadFile($url, $saveFolder, $fileName);

		        $results[] = [
		            'url' => $url,
		            'type' => $ext,
		            'saved' => $link ? true : false,
		            'file_link' => $link
		        ];
		    }

		    return $results;
		}

		function downloadFile($url, $saveFolder = PATH_BASE.'/admin/export/pdf/count_print', $fileName = null) {
		    if (!is_dir($saveFolder)) {
		        mkdir($saveFolder, 0755, true);
		    }

		    // Lấy tên file từ URL nếu không cung cấp
		    if (!$fileName) {
		        $fileName = basename(parse_url($url, PHP_URL_PATH));
		        // Nếu không có tên file, gán tên tạm
		        if (!$fileName || strpos($fileName, '.') === false) {
		            $fileName = 'file_' . uniqid() . '.bin';
		        }
		    }

		    $savePath = rtrim($saveFolder, '/') . '/' . $fileName;

		    $fileContent = @file_get_contents($url);
		    if ($fileContent === false) {
		        return false;
		    }

		    $result = file_put_contents($savePath, $fileContent);
		    if ($result === false) {
		        return false;
		    }

		    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
		    $baseUrl .= "://$_SERVER[HTTP_HOST]";
		    $fileUrl = $baseUrl . '/' . ltrim($savePath, '/');

		    return $fileUrl;
		}

		function calculateCumulativeQuantitiesTiktok(&$data) {
		 
		 
		     $totals_sku = [];
		 
		    // Bước 1: Duyệt qua toàn bộ mảng để tính tổng quantity cho từng SKU
		    foreach ($data as $group) {
		        foreach ($group as $item) {
		            $sku = $item['sku'];
		            $qty = $item['quantity'];
		 
		            if (isset($totals_sku[$sku])) {
		                $totals_sku[$sku] +=  intval($qty);
		            } else {
		                $totals_sku[$sku] = $qty;
		            }
		 
		        }
		    }
		 
		    $skuTotals = [];
		 
		 
		    foreach ($data as $i => $group) {
		        foreach ($group as $j => $item) {
		            $sku = $item['sku'];
		            $qty = $item['quantity'];
		 
		            if (!isset($skuTotals[$sku])) {
		                $skuTotals[$sku] = 0;
		            }
		 
		            $skuTotals[$sku] += $qty;
		            $data[$i][$j]['count'] = $skuTotals[$sku];
		            $data[$i][$j]['parent_index'] =  intval($this->findIndexInArray($item['sku'],$data));
		            $data[$i][$j]['all'] = $totals_sku[$sku];
		            $data[$i][$j]['all_to_sku'] = $this->countSKuInArray($data, $item['sku']);
		        }   
		    }
		}

		function calculateCumulativeQuantities(&$data) {
		 
		 
		     $totals_sku = [];
		 
		    // Bước 1: Duyệt qua toàn bộ mảng để tính tổng quantity cho từng SKU
		    foreach ($data as $group) {
		        foreach ($group as $item) {
		            $sku = $item['sku'];
		            $qty = $item['quantity'];
		 
		            if (isset($totals_sku[$sku])) {
		                $totals_sku[$sku] +=  intval($qty);
		            } else {
		                $totals_sku[$sku] = $qty;
		            }
		 
		        }
		    }
		 
		    $skuTotals = [];
		 
		 
		    foreach ($data as $i => $group) {
		        foreach ($group as $j => $item) {
		            $sku = $item['sku'];
		            $qty = $item['quantity'];
		 
		            if (!isset($skuTotals[$sku])) {
		                $skuTotals[$sku] = 0;
		            }
		 
		            $skuTotals[$sku] += $qty;
		            $data[$i][$j]['count'] = $skuTotals[$sku];
		            $data[$i][$j]['parent_index'] =  intval($this->findIndexInArray($item['sku'],$data));
		            $data[$i][$j]['all'] = $totals_sku[$sku];
		            $data[$i][$j]['all_to_sku'] = $this->countSKuInArray($data, $item['sku']);
		        }   
		    }
		}

		function show_list_array_run($data)
		{
		    // Khởi tạo bộ đếm show_list cho từng SKU
		    $sku_counters = [];

		    foreach ($data as &$group) {
		        foreach ($group as &$item) {
		            $sku = $item['sku'];
		            $quantity = $item['quantity'];

		            // Nếu chưa có vị trí bắt đầu cho SKU, khởi tạo là 1
		            if (!isset($sku_counters[$sku])) {
		                $sku_counters[$sku] = 1;
		            }

		            // Tính show_list từ vị trí hiện tại đến vị trí sau quantity
		            $start = $sku_counters[$sku];
		            $end = $start + $quantity - 1;
		            $item['show_list'] = implode(',', range($start, $end));

		            // Cập nhật bộ đếm tiếp theo cho SKU này
		            $sku_counters[$sku] = $end + 1;
		        }
		    }
		    return $data;

		}

		function findIndexInArray($sku, $data) {

		    $skuList = $this->listSKu($data);
		 
		    // Bước 2: Xóa trùng lặp và sắp xếp lại index
		    $uniqueSkuList = array_values(array_unique($skuList));
		   
		    $index = array_search($sku, $uniqueSkuList);
		 
		    return $index !== false ? $index+1 : -1; // -1 nếu không tìm thấy
		   
		}


		function listSKu($data)
		{
		   $skuList = [];
		    foreach ($data as $group) {
		        foreach ($group as $item) {
		            $skuList[] = $item['sku'];
		        }
		    }
		    return $skuList;
		}

		function listSKuFull($data)
		{
		   $skuList = [];
		    foreach ($data as $group) {
		        foreach ($group as $item) {
		            $skuList[] = $item['sku_full'];
		        }
		    }
		    return $skuList;
		}

		function countSKuInArray($data_result, $target)
		{
		    
		    $datas = $this->listSKu($data_result);

		    $counts = array_count_values($datas);


		    if (isset($counts[$target])) {

		        return $counts[$target];

		    } else {
		        return 0;
		    }
		   
		}

	
	}
	
?>