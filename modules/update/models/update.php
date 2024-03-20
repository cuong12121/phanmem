<?php 
	class UpdateModelsUpdate extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 40;
			$this -> view = 'order';
			$this -> table_name = 'fs_order';
			parent::__construct();
		}
		
		/*
		 * Vidic: Lấy dữ liệu cho bảng fs_content từ bảng page
		 */
		function add_content_from_page(){

			$arr_syn = array(
					'id'	=>	'id',
				  'url'=>'alias',
				  'title'=>'title',
				  'summary'=>'summary',
				  'status' =>'published',
				   'createDate' =>'created_time',
				   'lastUpdate' =>'updated_time',
//				   'content' =>'content',
			);
			
			$fsstring = FSFactory::getClass('FSString','','../');
			
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' select a.*,b.content from idv_seller_page AS a
			LEFT JOIN idv_seller_page_content AS b ON a.id = b.id
						 ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$row = array();
				$item_r = $list_remote[$i]; 
				
//				// check convert:
//				$cat = $this -> get_record('old_id = '.$item_r -> ChuyenMuc ,'fs_news_categories' );
//				
//				if(!$cat){
//					echo "==".$item_r -> ID."== NOT convert by cat_id = ".$item_r -> ChuyenMuc. "not found </br>";
//					continue;
//				}
				
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				
				// check alias exist
//				$exist = $this -> check_exist($alias,0,'alias','fs_news');
//				if($exist){
//					echo "<br/>Da ton tai ".$item_r -> ID."<br/>";
//					continue;
//				}
				$row['category_id'] = 165;
				$row['category_alias'] = 'thong-tin-vidic';
				$row['category_name'] = 'Thông tin Vidic';
				$row['category_id_wrapper'] = ',165,';
				$row['category_alias_wrapper'] = ',thong-tin-vidic,';
				$row['ordering'] = $i + 1;
				
				$fsremote_class = FSFactory::include_class ( 'remote' );
				$content = $item_r -> content;
				$content = FSRemote::save_image_in_remote_content ( $content,'http://vidic.com.vn/' );
				$row ['content'] = htmlspecialchars_decode ( $content );
				
				// check exist
				$exist = $this -> check_exist($item_r -> id,0,'id','fs_contents');
				if($exist){
					$this -> _update($row, 'fs_contents','id='.$item_r -> id,1);
				}else{
					$this -> _add($row, 'fs_contents',1);
				}
			}
		}
		/*
		 * Vidic: Lấy dữ liệu cho bảng fs_news từ vidic cũ
		 */
		function add_news(){
			// catId,thumnail, 
			$arr_syn = array(
					'article_id'=>	'id',
				  'title'=>'title',
//				  'summary'=>'summary',
				  'is_open' =>'published',
				   'add_time' =>'created_time',
//				   'lastUpdate' =>'updated_time',
//					'meta_title'=>'seo_title',
				  'keywords'=>'seo_keyword',
//				  'meta_description'=>'seo_description',
				   'content' =>'content',
			);
			
			$fsstring = FSFactory::getClass('FSString','','../');
			
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' select a.*
				from ecs_article AS a
				ORDER BY add_time ASC
						 ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$row = array();
				$item_r = $list_remote[$i]; 
				
//				// check convert:
				$cat = $this -> get_record('id = '.$item_r -> cat_id ,'fs_news_categories' );
				if(!$cat)
					continue;
				
				foreach($arr_syn as $field_old => $field_new){
					if($field_new == 'created_time' ){
						$row[$field_new] =  date("Y-m-d H:i:s", $item_r -> $field_old) ;
					}else{
						$row[$field_new] = $item_r -> $field_old;
					}
				}
				$row['alias'] = $fsstring -> stringStandart($item_r -> title);
				$row['category_id'] = $cat -> id;
				$row['category_alias'] = $cat ->alias;
				$row['category_name'] = $cat ->name;
				$row['category_id_wrapper'] = $cat ->list_parents;
				$row['category_alias_wrapper'] = $cat ->alias_wrapper;
				$row ['category_published'] = $cat->published;
				$row['show_in_homepage'] = $cat->show_in_homepage;
				$row['ordering'] = $i + 1;
				$fsremote_class = FSFactory::include_class ( 'remote' );
				$content = $item_r -> content;
				$content = FSRemote::save_image_in_remote_content ( $content,'http://msmobile.vn/' );
				$row ['content'] = htmlspecialchars_decode ( $content );
				// image
//				$row['image'] = $this -> get_main_image_for_news($item_r -> file_img );
				
				// check exist
				$exist = $this -> check_exist($item_r -> article_id,0,'id','fs_news');
				if($exist){
					$this -> _update($row, 'fs_news','id='.$item_r -> article_id,1);
				}else{
					$this -> _add($row, 'fs_news',1);
				}
			}
		}
		
		function remove_duplicate(){
			$list = $this -> get_records(' id >= 100 ','fs_news','*',' id ASC');
//			print_r($list);
			foreach($list as $item){
				$old_id = $item -> old_id;
				if(!$old_id){
					continue;
				}
				// check records
				$count = $this -> get_count( 'old_id ='.$item -> old_id,'fs_news' );
				if(!$count || $count == 1)
					continue;
				$this -> _remove(' id <> '.$item -> id.' AND old_id = '.$item -> old_id.' ', 'fs_news');
				// check exist
//				$summary = $item -> summary;
//				$summary = preg_replace('#<p(.*)>\(Phunutoday\).*-([/s]*)(.*)</p>#is','$3',$summary);
//
//				$row2 = array();
//				$row2['summary1'] = $summary;
//				$this -> _update($row2, 'fs_news', ' id = '.$item -> id);
			}
		}
		
		/*
		 * Remove cat
		 * Remove width, height
		 */
		function clean_description($description){
//			$description = preg_replace('#&gt;&gt; <strong>[\s]*<a href=".*" class="read_more" id="[a-zA-Z0-9_]*">(.*)<\/a><\/strong><br \/>#e','',$description);
			$description  = preg_replace('#<p style="text-align: justify;">.*</a>.*\)\s\-\s#','<p>',$description,1);
			$description  = preg_replace('#width\=\"([0-9]+)\"#e','',$description);
			$description  = preg_replace('#height\=\"([0-9]+)\"#e','',$description);
			$description  = preg_replace('#style\=\"(.*)\"#e','',$description);
			return $description;
		}
		function clear_summary(){
			$list = $this -> get_records(' id >= 100','fs_news','*','');
			foreach($list as $item){
				// check exist
				$summary = $item -> summary;
				$summary = preg_replace('#<p(.*)>\(Phunutoday\).*-([/s]*)(.*)</p>#is','$3',$summary);

				$row2 = array();
				$row2['summary1'] = $summary;
				$this -> _update($row2, 'fs_news', ' id = '.$item -> id);
			}
		}
		
		/*
		 * Xử lý summary: bo phunutoday trên cùng đi
		 */
		function clean_summary($summary){
			$summary = preg_replace('#<p(.*)>\(Phunutoday\).*-([/s]*)(.*)</p>#is','$3',$summary);
			return $summary;
		}
		
		/*
		 * Lấy ảnh tin tức cho dự án phunutoday
		 */
		function get_images($news_id, $path_main_image){
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT b.DuongDan,a.TinBaiId  FROM post_photo AS a LEFT JOIN photo AS b ON b.ID = a.AnhId WHERE a.TinBaiId = '.$news_id.' AND b.DuongDan <> "'.$path_main_image.'"';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			
			$folder_image_begin = 'E:\phunutoday.vn\\';
			
			$folder_image_destination = 'D:\projects\phunutoday\code\\';
			$fsFile = FSFactory::getClass('FsFiles','');
			
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				if(!file_exists($folder_image_begin.$item_r ->DuongDan )){
					echo "ko co ".$folder_image_begin.$item_r ->DuongDan." <br/>";
					return;
				}
				if(!$fsFile -> copy_file($folder_image_begin.$item_r ->DuongDan,$folder_image_destination.$item_r ->DuongDan))
					return;
			}
		}
		
		/*
		 * Lấy ảnh chính cho phunutoday
		 * Resign làm 2 kích thước
		 * Copy lại ảnh bỏ vào FOLDER normal để đảm bảo SEO (ảnh này không dùng)
		 */
		function add_main_images($path_original){
			$arr_img_paths = array(array('small',215,215,'cut_image'),array('large',408,436,'cut_image'),array('normal',150,85,'cut_image'));
			$folder_image_begin = 'E:\phunutoday.vn\\';
			
			$folder_image_destination = 'D:\projects\phunutoday\code\\';
			$fsFile = FSFactory::getClass('FsFiles','');
			
				$image = $path_original;
				$image = str_replace('/', DS,$image);
//				$fsFile -> create_folder($folder_image_destination);
				if(!file_exists($folder_image_begin.$image)){
					echo "ko co $folder_image_begin.$image <br/>";
					return;
				}
				if(!$fsFile -> copy_file($folder_image_begin.$image,$folder_image_destination.$image))
					return;
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination.$image);
					$fsFile -> create_folder(dirname($path_resize));
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($folder_image_destination.$image, $path_resize,$path[1], $path[2]))
						return false;
				}
		}
		function add_main_images_msmobile(){
			global $db;
			$select = ' SELECT * from fs_products where is_edit = 0  ORDER BY id DESC LIMIT 300';
			$sql = $db->query($select);
			
			$list_remote = $db->getObjectList();
			
			$arr_img_paths = array(array('large',390,488,'resize_image'),array('resized',216,202,'resize_image'),array('small',86,60,'resized_not_crop'));
			$folder_image_begin = '/home/msmobile/public_html/';
			
			$folder_image_destination = '/home/beta/public_html/';
			$fsFile = FSFactory::getClass('FsFiles','');
			
			foreach($list_remote as $item){
				$image = $item -> image;
				$image_name = basename($image);
				$image = str_replace('/', DS,$image);
				$path_img = str_replace('/',DS,$image);
//				$fsFile -> create_folder($folder_image_destination);
				if(!file_exists($folder_image_begin.str_replace('/',DS,$image))){
					echo "ko co $folder_image_begin.$image <br/>";
					return;
				}
				if(!$fsFile -> copy_file($folder_image_begin.$path_img,$folder_image_destination.$path_img))
					return;
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination.$path_img);
					$fsFile -> create_folder(dirname($path_resize));
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($folder_image_destination.$path_img, $path_resize,$path[1], $path[2]))
						return false;
				}
				$row = array();
				$row['is_edit'] = 1;
				$this ->_update($row, 'fs_products','id = '.$item -> id);
			}
		}
		
		function add_images_other_msmobile(){
			global $db;
			$select = ' SELECT * from fs_products_images where is_edit = 0  ORDER BY id DESC LIMIT 300';
			$sql = $db->query($select);
			
			$list_remote = $db->getObjectList();
			
//			$arr_img_paths = array(array('large',390,488,'resize_image'),array('resized',216,202,'resize_image'),array('small',86,60,'resized_not_crop'));
			$arr_img_paths = array(array('large',390,488,'resize_image'),array('small',86,60,'resized_not_crop'));
			$folder_image_begin = '/home/msmobile/public_html/';
			
			$folder_image_destination = '/home/beta/public_html/';
			$fsFile = FSFactory::getClass('FsFiles','');
			
			foreach($list_remote as $item){
				$image = $item -> image;
				$image_name = basename($image);
				$image = str_replace('/', DS,$image);
				$path_img = str_replace('/',DS,$image);
//				$fsFile -> create_folder($folder_image_destination);
				if(!file_exists($folder_image_begin.str_replace('/',DS,$image))){
					echo "ko co $folder_image_begin.$image <br/>";
					return;
				}
				if(!$fsFile -> copy_file($folder_image_begin.$path_img,$folder_image_destination.$path_img))
					return;
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination.$path_img);
					$fsFile -> create_folder(dirname($path_resize));
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($folder_image_destination.$path_img, $path_resize,$path[1], $path[2]))
						return false;
				}
				$row = array();
				$row['is_edit'] = 1;
				$this ->_update($row, 'fs_products_images','id = '.$item -> id);
			}
		}
		
	function add_main_images_news_msmobile(){
			global $db;
			$select = ' SELECT * from fs_news where is_edit = 0  ORDER BY id DESC LIMIT 150';
			$sql = $db->query($select);
			
			$list_remote = $db->getObjectList();
			
			$arr_img_paths =	array (array ('resized', 270,180, 'cut_image'),array('small',114,68,'cut_image'),array('large',454,260,'cut_image')) ;
//								array(array('large',390,488,'resize_image'),array('resized',216,202,'resize_image'),array('small',86,60,'resized_not_crop'));
			$folder_image_begin = '/home/msmobile/public_html/';
			
			$folder_image_destination = '/home/beta/public_html/';
			$fsFile = FSFactory::getClass('FsFiles','');
			
			foreach($list_remote as $item){
				$image = $item -> image;
				$image_name = basename($image);
				$image = str_replace('/', DS,$image);
				$path_img = str_replace('/',DS,$image);
//				$fsFile -> create_folder($folder_image_destination);
				if(!file_exists($folder_image_begin.str_replace('/',DS,$image))){
					echo "ko co $folder_image_begin.$image <br/>";
					continue;
//					return;
				}
				if(!$fsFile -> copy_file($folder_image_begin.$path_img,$folder_image_destination.$path_img)){
					continue;
//					return;
				}
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination.$path_img);
					$fsFile -> create_folder(dirname($path_resize));
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($folder_image_destination.$path_img, $path_resize,$path[1], $path[2])){
//						continue;
//						return false;
					}
				}
				$row = array();
				$row['is_edit'] = 1;
				$this ->_update($row, 'fs_news','id = '.$item -> id);
			}
		}
		/*
		 * Convert dữ liệu trong category ảnh sang dạng ảnh
		 */
		function convert_to_gallery(){

			$list = $this -> get_records('category_id = 67 AND type <> "image" ','fs_news','*','');
			foreach($list as $item){
				// check exist
				$exist = $this -> check_exist($item -> id,0,'news_id','fs_news_images');
				if($exist)
					continue;
				$description = $item -> content;
//				echo $description;
//				echo "<br/><br/>========<br/><br/>";
				preg_match_all('#<table align="center" class="image center" >(.*?)</table>[\s]*[\n]*<p>&nbsp;</p>#is',$description,$list_html_images);
				$list_html_images = $list_html_images[0];
				if(!count($list_html_images))
					continue;
				foreach($list_html_images as $html_image){
					preg_match('#src="(.*?)"#is',$html_image,$link_img);
					$link_img = $link_img[1];
					preg_match('#<td class="image_desc">(.*)</td>#is',$html_image,$alt_img);
					$alt_img = $alt_img[1];
					
					// copy image
					$this -> get_image_in_slideshow($link_img);
					
					$time = date('Y-m-d H:i:s');
					$row = array();
					$row['created_time'] = $time;
					$row['updated_time'] = $time;
					$row['published'] = 1;
					$row['image'] = $link_img;
					$row['summary'] = $alt_img;
					$row['news_id'] = $item -> id;
					$rs = $this -> _add($row, 'fs_news_images',1);
					if($rs){
						$row2 = array();
						$row2['type'] = 'image';
						$this -> _update($row2, 'fs_news', ' id = '.$item -> id);
					}
				}	
			}
		}
		
		/*
		 * Lấy ảnh trong tin bài dạng slideshow
		 */
		function get_image_in_slideshow($path_original){
			if(!$path_original)
				return;
			$arr_img_paths = array(array('small',80,80,'cut_image'));
			$folder_image_begin = 'E:\phunutoday.vn\\';
			
			$folder_image_destination = 'D:\projects\phunutoday\code\\';
			$fsFile = FSFactory::getClass('FsFiles','');
			
			$image = $path_original;
			$image = str_replace('/', DS,$image);
			if(!file_exists($folder_image_begin.$image)){
				echo "ko co $folder_image_begin.$image <br/>";
				return;
			}
			if(!$fsFile -> copy_file($folder_image_begin.$image,$folder_image_destination.$image))
				return;
			foreach($arr_img_paths as $path){
				$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination.$image);
				$fsFile -> create_folder(dirname($path_resize));
				$method_resize = $path[3]?$path[3]:'resized_not_crop';
				if(!$fsFile ->$method_resize($folder_image_destination.$image, $path_resize,$path[1], $path[2]))
					return false;
			}
		}	
		/*
		 * Vidic: Lấy dữ liệu cho bảng sản phẩm
		 * warranty_time => cover ( varchar)
		 */
		function syn_products(){
			$root = 136; 
			$table_extend = 'fs_products_accessories';

//===============
			//product_cat => Ok
			//brandId => Ok
			//meta_description: xóa kí tự xuống dòng , kí tự tròn và ô vuông( VD: 2039) => OK
			
			// image, => Ok
			// manufactories_,origin_, => Ok
			// tags(idv_sell_product_info) => ok
			// fs_products_... (extend)
			
			// hasVas(idv_sell_product_info)
			$arr_syn = array(
					'goods_id'	=>	'id',
				  'goods_sn'=>'code',
				  'goods_name'=>'name',
//				  'url'=>'alias',
				  'click_count'=>'hits',
				  'shop_price'=>'price_old',
				  'warn_number'=>'warranty_time',
				  'goods_brief'=>'promotion_info',
				  'goods_desc'=>'description',	
				  'add_time'=>'created_time',
				  'last_update'=>'edited_time',
//				  'warranty'=>'warranty_time',
//				  'meta_title'=>'seo_title',
				  'keywords'=>'seo_keyword',
//				  'quantity'=>'quantity',
				  'is_real'=>'published',
//				  'spec'=>'specification',
//				  'meta_description'=>'seo_description',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
			$array_new_cat = $this -> get_records('','fs_products_categories','*','','','id');
			
//			$array_new_manufactories = $this -> get_records(' tablenames LIKE "%,'.$table_extend.',%"','fs_manufactories','*','','','old_id');
			$array_new_manufactories = $this -> get_records('','fs_manufactories','*','','','old_id');
//			$array_new_origin = $this -> get_records('','fs_origin','*','','','id');
			
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM ecs_goods ';
			$sql = $remote_db->query($select);
			// get child_id
//			$select = ' select childListId  FROM idv_seller_category where id = '.$root;
//			$sql = $remote_db->query($select);
//			$list_id_root = $remote_db->getResult();
			
			// danh sách sp trong root
			$select = ' select a.*
				 from ecs_goods 	AS a
					ORDER BY a.goods_id ASC
			';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$row = array();
				$item_r = $list_remote[$i]; 
				if($item_r ->cat_id == 84 || $item_r ->cat_id == 101 || $item_r ->cat_id == 102 || $item_r ->cat_id == 103 || $item_r ->cat_id == 106 || $item_r ->cat_id == 84 || $item_r ->cat_id == 108 || $item_r ->cat_id == 84 || $item_r ->cat_id == 109 || $item_r ->cat_id == 110 || $item_r ->cat_id == 111 || $item_r ->cat_id == 112 || $item_r ->cat_id == 117 || $item_r ->cat_id == 118 || $item_r ->cat_id == 118 || $item_r ->cat_id == 120 || $item_r ->cat_id == 121 || $item_r ->cat_id == 122 || $item_r ->cat_id == 123 || $item_r ->cat_id == 124 || $item_r ->cat_id == 125 || $item_r ->cat_id == 126|| $item_r ->cat_id == 128 || $item_r ->cat_id == 129 || $item_r ->cat_id == 131 || $item_r ->cat_id == 133 || $item_r ->cat_id == 134 || $item_r ->cat_id == 136 ){
//				continue;
//				}
				$row['alias'] = $fsstring -> stringStandart($item_r -> goods_name);
				foreach($arr_syn as $field_old => $field_new){
					if($field_new == 'created_time' || $field_new == 'edited_time' ){
						$row[$field_new] =  date("Y-m-d H:i:s", $item_r -> $field_old) ;
					}else{
						$row[$field_new] = $item_r -> $field_old;
					}
				}
				$row['tablename'] = $table_extend;
				
			//price
			$price_old = 0;
			$price_old = $item_r -> shop_price;
			if($price_old > 30000000){
				$price_old = 0;
			}
			$discount = '';
			$discount_unit = '';
			if ($discount_unit == 'percent') {
				if ($discount > 100 || $discount < 0) {
					$row ['price_old'] = $price_old;
					$row ['price'] = $price_old;
					$row ['discount'] = 0;
					
				} else {
					$row ['price_old'] = $price_old;
					$row ['discount'] = $discount;
					$row ['price'] = $price_old * (100 - $discount) / 100;			
				}
			
			} else {
				if ($discount > $price_old || $discount < 0) {
					$row ['price_old'] = $price_old;
					$row ['price'] = $price_old;
					$row ['discount'] = 0;
				} else {
					$row ['price_old'] = $price_old;
					$row ['discount'] = $discount;
					$row ['price'] = $price_old - $discount;
				}
			}
				// product_cat
//				$cats_old = $item_r -> product_cat;
//				$arr_cat_old = explode(',',$cats_old);
//				$cat_id = 0;
//				for($k = count($arr_cat_old); $k > 0; $k --){
//					$buff = trim($arr_cat_old[$k - 1]); 
//					if(!$buff)
//						continue;
//					$buff = intval($buff);
//					if(!$buff)
//						continue;
//					$cat_id = $buff;
//					break;
//				}
				$cat = $array_new_cat[$root];
				$row['category_id'] = $cat -> id;
				$row['category_id_wrapper'] = $cat -> list_parents;
				$row['category_root_alias'] = $cat -> root_alias;
				$row['category_name'] = $cat -> name;
				$row['category_alias'] = $cat -> alias;
				$row['category_alias_wrapper'] = $cat -> alias_wrapper;
				$row ['category_published'] = $cat->published;
				$row['show_in_homepage'] = $cat->show_in_homepage;
				
				// manufactory
				$brandId = $item_r -> brand_id;
				$manufactory = $array_new_manufactories[$brandId];
				$row['manufactory'] = $manufactory -> id;
				$row['manufactory_alias'] = $manufactory -> alias;
				$row['manufactory_name'] = $manufactory -> name;
//				$row['manufactory_image'] = $manufactory -> image;
				
				// origin
//				$sql = 'select a.pro_id,a.attr_value_id,b.new_id from idv_product_attribute AS a
//						LEFT JOIN idv_attribute_value AS b ON a.attr_value_id = b.id
//						where 
//						attr_value_id IN (select id from idv_attribute_value
//						where new_type = "origin"
//						)
//						AND 
//						pro_id ='.$item_r -> id;
//				$sql = $remote_db->query($sql);
//				$origin_old = $remote_db->getObject();
//				$origin_new = $array_new_origin[$origin_old -> new_id];
//				if(isset($origin_new)){
//					$row['origin'] = $origin_new -> id;
//					$row['origin_alias'] = $origin_new -> alias;
//					$row['origin_name'] = $origin_new -> name;
//					$row['origin_image'] = $origin_new -> image;
//				}
				
				// tags
//				$row['tags'] = preg_replace( "/\r|\n/", ",", $item_r -> tags );
				// vat
//				$row['vat'] = $item_r -> hasVAT == 1 ? 1: 0;
				$row['ordering'] = $i + 1;
				$row ['quantity'] = 10;
				
				// image
				if($item_r -> goods_img){
					$row['image'] = $this -> get_main_image($item_r -> goods_img );
				}
				$exist = $this -> check_exist($item_r -> goods_id,0,'id','fs_products');
				if($exist){
					$this -> _update($row, 'fs_products','id='.$item_r -> goods_id,1);
					$this -> save_extension($table_extend,$item_r -> goods_id);
				}else{
					$rs = $this -> _add($row, 'fs_products',1);
					$this -> save_extension($table_extend,$item_r -> goods_id);
				}
			  }
			}
		}
	function syn_products_update(){
//			$root = 136; 
//			$table_extend = 'fs_products_accessories';
			
//			$root = 138; 
//			$table_extend = 'fs_products_advice';

//			$root = 137; 
//			$table_extend = 'fs_products_tablet';

			$root = 135; 
			$table_extend = 'fs_products_phone';

			$arr_syn = array(
					'goods_id'	=>	'id',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
			$array_new_cat = $this -> get_records('','fs_products_categories','*','','','id');
			
			$array_new_manufactories = $this -> get_records('','fs_manufactories','*','','','old_id');
			
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM ecs_goods ';
			$sql = $remote_db->query($select);
			
			// danh sách sp trong root
			$select = ' select a.*
				 from ecs_goods 	AS a
					ORDER BY a.goods_id ASC
			';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$row = array();
				$item_r = $list_remote[$i]; 
				switch($item_r ->cat_id){
					//fs_products_accessories
//					case 77:
//					case 84:
//					case 117:
//					case 118:
//					case 119:
//					case 121:
//					case 122:
//					case 129:
//					case 130:
//					case 131:
//					case 133:
//					case 134:
					//fs_products_advice
//					case 101:
//					case 102:
//					case 103:
//					case 106:
//					case 107:
//					case 108:
//					case 109:
//					case 110:
//					case 111:
//					case 112:
//					case 113:
//					case 114:
//					case 115:
//					case 116:
//					case 123:
//					case 136:	
					//fs_products_tablet
//					case 99:
					//fs_products_phone
					case 1:
					case 36:
					case 41:
					case 44:
					case 46:
					case 63:
					case 64:
					case 75:
					case 93:
					case 94:
					case 95:
					case 97:
					case 98:
					case 100:
					case 120:
					case 124:		
					case 125:
					case 126:
					case 128:
					case 135:				
										
						foreach($arr_syn as $field_old => $field_new){
							$row[$field_new] = $item_r -> $field_old;
						}
						$row['tablename'] = $table_extend;
						
						$cat = $array_new_cat[$root];
						$row['category_id'] = $cat -> id;
						$row['category_id_wrapper'] = $cat -> list_parents;
						$row['category_root_alias'] = $cat -> root_alias;
						$row['category_name'] = $cat -> name;
						$row['category_alias'] = $cat -> alias;
						$row['category_alias_wrapper'] = $cat -> alias_wrapper;
						$row ['category_published'] = $cat->published;
						$row['show_in_homepage'] = $cat->show_in_homepage;
						
						$exist = $this -> check_exist($item_r -> goods_id,0,'id','fs_products');
						if($exist){
							$this -> _update($row, 'fs_products','id='.$item_r -> goods_id,1);
							$this -> save_extension($table_extend,$item_r -> goods_id);
						}
					break;
			  	}
			}
		}
		/*
		 * Vidic: Sửa trường warranty_time trong các bảng mở rộng bị lỗi INT
		 */
	function fix_warranty(){
	
		$array_table = array('fs_products_generator','fs_products_shower_mixer_panel','fs_products_washer');
		foreach($array_table as $table_name){
			$list = $this -> get_records('tablename  = "'.$table_name.'"','fs_products','id,warranty_time');
			foreach($list as $item){
				echo $item -> id;
				$row = array();
				$row['warranty_time'] = $item -> warranty_time;
				$this -> _update($row, $table_name,'record_id = '.$item -> id);	
			}
		}
				
	}
	
	
		
	/*
		 * save into extension table
		 * (insert or update)
		 */
	function save_extension($tablename, $record_id) {
		$data = $this->get_record ( 'id = ' . $record_id, 'fs_products' );
		global $db;
		// field default: cai nay can xem lai vi hien dang ko su dung. Can phai su dung de luoc bot cac  truong thua
		$field_default = $this->get_records ( ' type = "products"  ', 'fs_tables' );
		if (! $record_id)
			return false;
		
		if (! $db->checkExistTable ( $tablename ))
			return false;
		
		// data same fs_TYPE
		
		$fields_all_of_ext_table = $this->get_field_table ( $tablename, 1 );
		foreach ( $data as $field_name => $value ) {
			if ($field_name == 'id' || $field_name == 'tablename')
				continue;
			if (! isset ( $fields_all_of_ext_table [$field_name] ))
				continue;
			$row [$field_name] = $value;
		}
		$row ['record_id'] = $record_id;
		// extention
		$fields_ext = $this->getExtendFields ( $tablename );
		
		// old_data 
//		$sql = 'select a.*,b.id,b.`value`,b.new_id,b.new_type,b.new_extend_table 
//			FROM idv_product_attribute AS a
//			LEFT JOIN idv_attribute_value AS b ON a.attr_value_id = b.id
//			where new_type = "extend" AND a.pro_id = '.$record_id;
		// remote db
//		include_once 'remote_db.php';
//		$remote_db = new Remote_db();
//		$remote_db->query($sql);
//		$old_data = $remote_db->getObjectList();
//		foreach($old_data as $item){
//			$field_name = '';
//			$field_type = '';
//			foreach($fields_ext as $field) {
//				if(trim($field -> foreign_tablename) == trim($item -> new_extend_table) && ($field -> field_type == 'foreign_multi' || $field -> field_type == 'foreign_one' )){
//					$field_name = $field -> field_name;
//					$field_type = $field -> field_type;
//					break;
//				}
//			}
//			if(!$field_name)
//				continue;
//			if($field_type == 'foreign_multi'){
//				$row[$field_name]  =','.$item -> new_id.',';	
//			}else{
//				$row[$field_name]  = $item -> new_id;
//			}
//			if(isset($fields_ext['f_'.$field_name])){
//				$row['f_'.$field_name] = $item -> value_sort;
//			}
//		}
		$exist = $this -> check_exist($record_id,0,'record_id',$tablename);
		if ($exist) {
			return $this->_update ( $row, $tablename, ' record_id =  ' . $record_id );
		} else {
			return $this->_add ( $row, $tablename , 1);
		}
		return;
	}
		
	
	function getExtendFields($tablename) {
		global $db;
		if ($tablename == 'fs_products' || $tablename == '')
			return;
		
		$exist_table = $db->checkExistTable ( $tablename );
		if (! $exist_table) {
			Errors::setError ( FSText::_ ( 'Table' ) . ' ' . $tablename . FSText::_ ( ' is not exist' ) );
			return;
		}
		
		$cid = FSInput::get ( 'cid' );
		$query = " SELECT * 
						FROM fs_products_tables
						WHERE table_name =  '$tablename' 
						AND field_name <> 'id' ";
		$sql = $db->query ( $query );
		$result = $db->getObjectListByKey('field_name');
		
		return $result;
	}
	
		function syn_cats(){

			$arr_syn = array(
					'cat_id'  =>'id',
				  'cat_name' =>'name',
				  'cat_order' =>'ordering',
				  'cat_active' => 'published',
				  'cat_parent_id' => 'parent_id'
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM categories_multi WHERE cat_type = "product" ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['alias'] = $fsstring -> stringStandart($item_r -> cat_name);
				
				$row['created_time'] = $time;
				$row['updated_time'] = $time;
				echo $this -> _add($row, 'fs_products_categories',1);
			}
		}
		/*
		 * Vidic: Lấy hãng sản xuất theo từng nhóm sản phẩm
		 */
		function get_manufactory(){
			//return;

			
			$root = 135; //điện thoại
			$table_extend = 'fs_products_phone';
//			$prefix_alias = 'dien-thoai-';
			$prefix_name = 'Điện thoại';
			
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			
	// get child_id
//			$select = ' select parent_id  FROM ecs_category where cat_id = '.$root;
//			$sql = $remote_db->query($select);
//			$list_id_root = $remote_db->getResult();
//			print_r($list_id_root);die;
			//get manufactory
			
			$select = ' select * from ecs_brand';
			$sql = $remote_db->query($select);
			$manufactories_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			for($i = 0; $i < count($manufactories_remote) ; $i ++){
				$item = $manufactories_remote[$i];
				$row = array();
				$row['prefix_name'] = $prefix_name;
				$row['name'] = $item -> brand_name;
				$row['old_id'] = $item -> brand_id;
				$row ['alias'] = $fsstring->stringStandart ( $item -> brand_name );
				$row['tablenames'] = ','.$table_extend.',';
//				$row['image'] = $item -> brand_logo;
				$row['created_time'] = $time;
//				$row['updated_time'] = $time;
				$row['published'] = 1;
				$row['ordering'] = ($i + 1);
				$this -> _add($row, 'fs_manufactories',1);
			}
		}
		/*
		 * Vidic: Lấy danh mục sản phẩm nhóm danh mục
		 */
		function get_category(){
			return;
//			$root = 2; // điều hòa
//			$root = 6; // Quạt
//			$root = 4; // Máy phát điện
//			$root = 58; //Bình nóng lạnh
//			$root = 19; //Máy sấy
			$root = 18; //Máy giặt
//			$root = 86; //Đèn sưởi
			
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			
			// get child_id
			$select = ' select childListId  FROM idv_seller_category where id = '.$root;
			$sql = $remote_db->query($select);
			$list_id_root = $remote_db->getResult();
			
			//get manufactory
			$select = '  select * from idv_seller_category where id IN  ('.$list_id_root.') ';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			
			$time = date('Y-m-d H:i:s');
			
			
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item = $list_remote[$i];

				$record =  $this -> get_record('name = "'.$item -> name.'" OR alias = "'.$item->url.'" ','fs_products_categories','* ');
				if(!$record && !$record -> id){
					echo 'Moi:'.$item -> id.'->'.$item -> name. '<br/>';
				}else{
					$row = array();
					$row['old_id'] = $item -> id;	
					$row['seo_title'] = $item -> meta_title;	
					$row['seo_keyword'] = $item -> meta_keyword;	
					$row['seo_description'] = $item -> meta_description;
					echo 'Edit:'.$item -> id.'->'.'->'.$record -> id.'->'.$item -> name. '<br/>';
					$this -> _update($row, 'fs_products_categories','id='.$record->id);	
				}
			}
		}
		
	/*
		 * Vidic: Lấy danh mục sản phẩm nhóm danh mục
		 */
		function get_origin(){
			return;
//			$root = 2; // điều hòa
//			$root = 6; // Quạt
//			$root = 4; // Máy phát điện
//			$root = 58; //Bình nóng lạnh
//			$root = 19; //Máy sấy
			$root = 18; //Máy giặt
//			$root = 86; //Đèn sưởi
			$array_root = array(2 =>'fs_products_air_conditioner',6=>'fs_products_fan',4=>'fs_products_generator',58=>'fs_products_shower_mixer_panel',19=>'fs_products_dryer',18=>'fs_products_washer');
			
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			
			$fsstring = FSFactory::getClass('FSString','','../');
			
			// get child_id
			$select = ' select DISTINCT(value) as value from idv_attribute_value
				where attributeId IN ( select id from idv_attribute where attribute_code like "xuat-xu") ';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			// full dữ liệu vào bảng mới fs_origin
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item = $list_remote[$i];

				$record =  $this -> get_record('name = "'.$item -> name.'" OR alias = "'.$item->url.'" ','fs_origin','* ');
				if(!$record && !$record -> id){
					$row = array();
					$row['name'] = $item -> value;	
					$row['alias'] = $fsstring -> stringStandart($row['name']);
//					$row['old_id'] = $item -> id;	
					
					
					// các bảng mở rộng có dữ liệu
					$str_tablenames = '';
					foreach($array_root as $root_id=>$table_name){
						// get child_id
						$select = ' select childListId  FROM idv_seller_category where id = '.$root_id;
						$sql = $remote_db->query($select);
						$list_id_root = $remote_db->getResult();
						
						echo $sql = 'select count(*) from idv_sell_product_store where id IN ( select DISTINCT(pro_id) from idv_product_attribute
						where  attr_value_id IN ( select id from idv_attribute_value
						where attributeId IN ( select id from idv_attribute where attribute_code like "xuat-xu") AND `value` = "'.$item->value.'")
						) AND id IN (select pro_id from idv_product_category where category_id IN  ('.$list_id_root.') )
						';
						$remote_db->query($sql);
						$rs = $remote_db->getResult();
						if($rs >0){
							if(!$str_tablenames)
								$str_tablenames .= ',';
							$str_tablenames .= $table_name.	',';
						}
					}
					
					$row['published'] = 1;	
					$row['tablenames'] = $str_tablenames;	
					$this -> _add($row, 'fs_origin');
					echo 'Moi:'.$item -> id.'->'.$item -> name. '<br/>';
				}else{
//					$row = array();
//					$row['old_id'] = $item -> id;	
//					$row['seo_title'] = $item -> meta_title;	
//					$row['seo_keyword'] = $item -> meta_keyword;	
//					$row['seo_description'] = $item -> meta_description;
//					echo 'Edit:'.$item -> id.'->'.'->'.$record -> id.'->'.$item -> name. '<br/>';
//					$this -> _update($row, 'fs_products_categories','id='.$record->id);	
				}
			}
			// cập nhật lại bản cũ
			$news_records = $this -> get_all_record('fs_origin');
			foreach($news_records as $item){
				$sql = 'select id from idv_attribute_value
								where attributeId IN ( select id from idv_attribute where attribute_code like "xuat-xu")
								AND `value` = "'.$item -> name.'"
						';
						$remote_db->query($sql);
						$list = $remote_db->getObjectList();
				$str_id = '';
				foreach($list as $old_item){
					if($str_id)
						$str_id .= ',';
					$str_id .= $old_item -> id;
				}
				if(!$str_id)
					continue;
				$sql = 'UPDATE idv_attribute_value  SET new_id = "'.$item->id.'", new_type = "origin" WHERE id IN ('.$str_id.'
				)';
				$remote_db->query($sql);
				$rows = $remote_db->affected_rows();
			}
		}
		/*
		 * Vidic: Lấy dữ liệu cho bảng mở rộng
		 */
		function get_extends(){
//			$array_extend = array(3 =>'fs_extends_dh_loai_may',
//								4=>'fs_extends_dh_kieu_may',
//								5=>'fs_extends_dh_cong_suat',
//								6=>'fs_extends_dh_noi_bat',
//								10=>'fs_extends_dh_loai_gas',
//								11=>'fs_extends_dh_dieu_hoa_multi',
//								25=>'fs_extends_dh_ngoai_ap_suat_tinh',
//								26=>'fs_extends_dh_loc_khong_khi'
//								);
//			$array_extend = array(52 =>'fs_extends_quat_cat_gio_kieu_thoi',
//								53=>'fs_extends_quat_cat_gio_do_dai',
//								54=>'fs_extends_quat_cat_gio_do_cao_thoi ',
//								);
//			$array_extend = array(59 =>'fs_extends_quat_thong_gio_chuc_nang',
//								60=>'fs_extends_quat_thong_gio_khung_vo',
//								);
//			$array_extend = array(62 =>'fs_extends_pd_loai_may',
//								63=>'fs_extends_pd_kieu_may',
//								9=>'fs_extends_pd_so_pha',
//								37=>'fs_extends_pd_cong_suay_lien_tuc',
//								39=>'fs_extends_pd_khoi_dong',
//								22=>'fs_extends_pd_nhien_lieu',
//								23=>'fs_extends_pd_vo_chong_on',
//								21=>'fs_extends_pd_dai_cong_suat',
//								);
//			$array_extend = array(64 =>'fs_extends_bnl_loai_binh',
//								65=>'fs_extends_bnl_kieu_dang',
//								);
//			$array_extend = array(50 =>'fs_extends_dryer_cong_suat',
//								73=>'fs_extends_dryer_trong_luong',
//								74=>'fs_extends_dryer_toc_do_quay',
//								);
//			$array_extend = array(69 =>'fs_extends_washer_trong_luong',
//								70=>'fs_extends_washer_loai_may',
//								71=>'fs_extends_washer_toc_do_vat',
//								72=>'fs_extends_washer_toc_do_giat',
//								29=>'fs_extends_washer_chuc_nang_khac',
//								);
			
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			
			$fsstring = FSFactory::getClass('FSString','','../');
			
			foreach ( $array_extend as $old_id => $new_table){
				// get child_id
				$select = ' select * from idv_attribute_value
						where attributeId = '.$old_id;
				$sql = $remote_db->query($select);
				$list_remote = $remote_db->getObjectList();
				$i = 0;
				$time = date('Y-m-d H:i:s');
				foreach($list_remote as $item){
					$row = array();
					$row['name'] = $item -> value;
					$row['seo_title'] = $row['name'];
					$row['seo_keyword'] = $row['name'];
					$row['seo_description'] = $row['name'];
					$row['alias'] = $fsstring -> stringStandart($row['name']);
					$row['ordering'] = $i + 1;
					$row['published'] = 1;
					$row['old_id'] = $item -> id;
					$row['created_time'] = $time;
					$row['edited_time'] = $time;
					$new_id = $this -> _add($row, $new_table);
					
					if($new_id){
						$sql = 'UPDATE idv_attribute_value  SET new_id = "'.$new_id.'", new_type = "extend", new_extend_table = "'.$new_table.'" WHERE id  =  '.$item -> id .' ';
						$remote_db->query($sql);
						$rows = $remote_db->affected_rows();
					}
					$i ++;
				}
			}
		}
		
		function update_home_cats(){

			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM categories_multi WHERE cat_type = "product" ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				$row['show_in_homepage'] = $item_r -> cat_show;
				echo $this -> _update($row, 'fs_products_categories',' id = '.$item_r -> cat_id,1);
			}
		}
		
		function syn_manufactories(){

			$arr_syn = array(
					'sup_id'  =>'id',
				  'sup_name' =>'name',
				  'sup_order' =>'ordering',
				  'sup_active' => 'published',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM supplier ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['alias'] = $fsstring -> stringStandart($item_r -> sup_name);
				
				$row['created_time'] = $time;
				$row['edited_time'] = $time;
				echo $this -> _add($row, 'fs_manufactories',1);
				
				$row3['manufactory_alias'] = $row['alias'];
				$row3['manufactory_name'] = $row['name'];
				$this -> syn_product_vs_foreign($row['id'],'manufactory',$row3);
			}
		}
		function valid_manufactory(){
			$list = $this -> get_records('','fs_manufactories');
			foreach($list as $item){
				$row3 = array();
				$row3['manufactory_alias'] = $item -> alias;
				$row3['manufactory_name'] = $item -> name;
				$this -> syn_product_vs_foreign($item -> id,'manufactory',$row3);
			}
		}
		function syn_author(){

			$arr_syn = array(
					'aut_id'  =>'id',
				  'aut_name' =>'name',
				  'aut_order' =>'ordering',
				  'aut_active' => 'published',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM author ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['alias'] = $fsstring -> stringStandart($row['name']);
				
				$row['created_time'] = $time;
				$row['edited_time'] = $time;
				echo $this -> _add($row, 'fs_products_authors',1);
				
				$row3['author_alias'] = $row['alias'];
				$row3['author_name'] = $row['name'];
				$this -> syn_product_vs_foreign($row['id'],'author_id',$row3);
			}
		}
		
		function syn_translator(){

			$arr_syn = array(
					'dic_id'  =>'id',
				  'dic_name' =>'name',
				  'dic_order' =>'ordering',
				  'dic_active' => 'published',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM dichgia ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['alias'] = $fsstring -> stringStandart($row['name']);
				
				$row['created_time'] = $time;
				$row['edited_time'] = $time;
				echo $this -> _add($row, 'fs_products_translators',1);
				
				$row3['translator_alias'] = $row['alias'];
				$row3['translator_name'] = $row['name'];
				$this -> syn_product_vs_foreign($row['id'],'translator_id',$row3);
			}
		}
		function syn_pagenumber(){

			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM products ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				$row['pagenumber'] = $item_r -> pro_pagenumber;
				echo $this -> _update($row, 'fs_products',' `id` = '.$item_r->pro_id );
			}
		}
		function add_main_images_huongthuy(){
			$arr_img_paths = array(array('resized',126,197,'resized_not_crop'),array('large',240,350,'resized_not_crop'));
			$list = $this -> get_records('id >= 1700','fs_products','id,image,image_old','id ');
			$folder_image_begin = 'D:\xampp\htdocs\backup\nhasachhuongthuy\pictures_products\\';
			$day = '20';
			$month = '9';
			
			$folder_image_destination = 'D:\xampp\htdocs\svn\nhasachhuongthuy\code\images\products\2012\\'.$month.'\\'.$day.'\original\\';
			$fsFile = FSFactory::getClass('FsFiles','');
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i]; 
				$image = $item -> image_old;
				$fsFile -> create_folder($folder_image_destination);
				if(!$fsFile -> copy_file($folder_image_begin.$image,$folder_image_destination.$image))
					continue;
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
					$fsFile -> create_folder($path_resize);
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($folder_image_destination.$image, $path_resize.$image,$path[1], $path[2]))
						return false;
				}
				$row3['image'] = 'images/products/2012/'.$month.'/'.$day.'/original/'.$image;
				$this -> syn_product_vs_foreign($item->id,'id',$row3);
			}
		}
		/*
		 * Lấy ảnh chính
		 */
		function  get_main_image($image ){
			$arr_img_paths = array (array ('large',778,390, 'resize_image' ), array ('resized',160,130, 'resize_image' ), array ('small', 86,60, 'resize_image' ) );

			// lấy 2 ảnh (gốc về crop 250_ ) về folder /media/product/
			$fsremote_class = FSFactory::include_class ( 'remote' );
			FSRemote:: save_image('http://msmobile.vn/'.$image,1,'/images/products/upload_img/',0);
		
			$filename = FSRemote::get_filename_from_url('http://msmobile.vn/'.$image);
			$folder_image_begin = 'D:\xampp\htdocs\msmobile\code\images\products\upload_img\\'.$filename;
			$day = '25';
			$month = '11';
			$folder_image_destination = 'D:\xampp\htdocs\msmobile\code\images\products\2014\\'.$month.'\\'.$day.'\original\\';
			$fsFile = FSFactory::getClass('FsFiles','');
			$fsFile -> create_folder($folder_image_destination);
			$fsFile -> copy_file($folder_image_begin,$folder_image_destination.$filename);
			foreach($arr_img_paths as $path){
				$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
				$fsFile -> create_folder($path_resize);
				$method_resize = $path[3]?$path[3]:'resized_not_crop';
				if(!$fsFile ->$method_resize($folder_image_destination.$filename, $path_resize.$filename,$path[1], $path[2]))
					continue;
			}
			return 'images/products/2014/'.$month.'/'.$day.'/original/'.$filename;
//				$this -> _update($row3, 'fs_products_images',' `id` = '.$item->id);
		}
		/*
		 * Vidic: Lấy ảnh chính cho tin tức
		 */
		function  get_main_image_for_news($image ){
			$arr_img_paths = array (array ('resized', 178,135, 'resize_image'),array('small',90,64,'cut_image'),array('large',290,220,'resize_image'));

			// lấy 2 ảnh (gốc về crop 250_ ) về folder /media/product/
			$fsremote_class = FSFactory::include_class ( 'remote' );
			if(strpos($image, 'http:') !== false || strpos($image, 'https:') !== false){
				FSRemote:: save_image($image,1,'/images/news/upload_img/',0);
				$filename = FSRemote::get_filename_from_url($image);
			}else{
				FSRemote:: save_image('http://msmobile.vn/'.$image,1,'/images/news/upload_img/',0);
				$filename = FSRemote::get_filename_from_url('http://msmobile.vn/'.$image);
			}
			if(!$filename)
				return;
		
			$folder_image_begin = 'D:\xampp\htdocs\msmobile\code\images\news\upload_img\\'.$filename;
			$day = '5';
			$month = '1';
			$folder_image_destination = 'D:\xampp\htdocs\msmobile\code\images\news\2015\\'.$month.'\\'.$day.'\original\\';
			$fsFile = FSFactory::getClass('FsFiles','');

			$fsFile -> create_folder($folder_image_destination);
			$fsFile -> copy_file($folder_image_begin,$folder_image_destination.$filename);
			foreach($arr_img_paths as $path){
				$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
				$fsFile -> create_folder($path_resize);
				$method_resize = $path[3]?$path[3]:'resized_not_crop';
				if(!$fsFile ->$method_resize($folder_image_destination.$filename, $path_resize.$filename,$path[1], $path[2]))
					continue;
			}
				return 'images/news/2015/'.$month.'/'.$day.'/original/'.$filename;
			
					
//				$this -> _update($row3, 'fs_products_images',' `id` = '.$item->id);
		}
		function add_other_images(){
			$arr_img_paths = array(array('trainer_small',70,110,'resized_not_crop'),array('trainer_large',597,473,'resized_not_crop'));
			$list = $this -> get_records(' id >= 576','fs_products_images','id,image,image_old','id ');
			$folder_image_begin = 'D:\xampp\htdocs\backup\nhasachhuongthuy\pictures_products\\';
			$day = '25';
			$month = '10';
			
			$folder_image_destination = 'D:\xampp\htdocs\svn\nhasachhuongthuy\code\images\products_trainer\2012\\'.$month.'\\'.$day.'\original\\';
			$fsFile = FSFactory::getClass('FsFiles','');
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i]; 
				$image = $item -> image_old;
				$fsFile -> create_folder($folder_image_destination);
				if(!$fsFile -> copy_file($folder_image_begin.$image,$folder_image_destination.$image))
					continue;
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
					$fsFile -> create_folder($path_resize);
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
					if(!$fsFile ->$method_resize($folder_image_destination.$image, $path_resize.$image,$path[1], $path[2]))
						continue;
				}
				$row3['image'] = 'images/products_trainer/2012/'.$month.'/'.$day.'/original/'.$image;
				$this -> _update($row3, 'fs_products_images',' `id` = '.$item->id);
			}
		}
		
		
		function syn_images_huongthuy(){

			$arr_syn = array(
					'pipr_id'  =>'id',
				  'pipr_name' =>'name',
				  'pipr_order' =>'ordering',
				  'pipr_product' => 'product_id',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM pictures_product ';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectList();
			
			$row = array();
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$arr_types = array(1=>'bia-truoc',2=>'muc-luc',3=>'trich-doan',4=>'bia-sau');
				$row['type'] = $arr_types[$item_r -> pipr_type];
				echo $this -> _add($row, 'fs_products_images',1);
			}
		}
		
		function syn_product_vs_foreign($foreign_id,$foreign_name,$row){
			$this -> _update($row, 'fs_products',' `'.$foreign_name.'` = '.$foreign_id,1);
		}
		
		function _save()
		{
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' SELECT * FROM item ';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			
			
			// select db in local
			global $db;
			$select = ' SELECT * FROM fs_products ';
			$db->query($select);
			$list = $db->getObjectList();
			$arr_result = array();
			$time = date('Y-m-d H:i:s');
			
			for($i = 0; $i < count($list_remote) ; $i ++){
				$item_r = $list_remote[$i]; 
				for($j = 0; $j < count($list) ; $j ++){
					$item = $list[$j];
					if((trim($item_r -> Code) == trim($item -> code)) && trim($item -> code) != ''){
						$price_r = (int)$item_r -> SellPriceTot;
						$quantity_r = (int)$item_r -> StockCrt;
						
						// address from remote db
						
						// update if different
						if($price_r != $item -> price || $quantity_r != $item -> quantity){
							$sql = 'UPDATE fs_products '; 
							$sql .= ' ';
							$sql .= ' ';
							$sql .= ' edited_time = \''.$time.'\' ';
							$sql .= ' WHERE id = '.$item -> id;
							global $db;
							// $db->query($sql);
							$rows = $db->affected_rows($sql);
							if($rows)
								if( $price_r != $item -> price && $item -> tablename ){
									if($db -> checkExistTable($item -> tablename)){
										$sql = 'UPDATE '.$item -> tablename; 
										$sql .= ' SET ext_price = \''.$price_r.'\' ';
										$sql .= ' WHERE productid = '.$item -> id;	
										
										// $db->query($sql);
										$rows2 = $db->affected_rows($sql);
									}
								}
								$arr_result[] = array('id' => $item ->id, 'name'=> $item -> name);
							}
						}
					}
				}
			return $arr_result;
		}
		
		/*
		 * Sua truong alias va price_old
		 */
		function repair_products(){
			$list = $this -> get_records('','fs_products','id,name,price,price_old,price_outsite','id ');
			$fsstring = FSFactory::getClass('FSString','','../');
				
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i]; 
				$row3['alias'] = $fsstring -> stringStandart($item -> name);
				$row3['price_old'] = $fsstring -> stringStandart($item -> price_outsite);
				$this -> syn_product_vs_foreign($item->id,'id',$row3);
			}
		}
		/*
		 * Sua truong alias va price_old
		 */
		function recal_prices(){
			$list = $this -> get_records('','fs_products','id,name,price,price_old,tablename','id ');
			$fsstring = FSFactory::getClass('FSString','','../');
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i];
				$row3 = array(); 
				$price = $item -> price;
				$price_old = $item -> price_old;
				$row3['discount'] = $price_old - $price;
				if($row3['discount'] )
					$row3['discount_unit'] = 'price';
				else 
					$row3['discount_unit'] = '';
				
				$this -> _update($row3,'fs_products','id='.$item->id);
				if($item->tablename){
					$row3['price'] = $item -> price;
					$row3['price_old'] = $item -> price_old;
					$this -> _update($row3,$item->tablename,'record_id='.$item->id);
				}
			}
		}
		
		
		/* Vidic: Sinh tags tự động
		 */
		function generate_tags(){
			// phần điều hòa
			$this -> generate_tags_for_dieu_hoa();
		}
		/* Vidic: Sinh tags tự động phần điều hòa
		 */
		function generate_tags_for_dieu_hoa(){
			$cat_root = 41;
			$suffix = 'điều hòa';
			
			// loại
			$data_ext_loc_khong_khi = $this -> get_records('','fs_extends_loc_khong_khi','*',' id ASC ','','id');
			$data_ext_loai_may = $this -> get_records('','fs_extends_dh_loai_may','*',' id ASC ','','id');
			
//			$list = $this ->  get_records('category_id_wrapper LIKE "%,'.$cat_root.',%"','fs_products','*','id',10);
			$list = $this ->  get_records(' category_id_wrapper LIKE "%,'.$cat_root.',%"','fs_products_air_conditioner','*','id');
//			$fsstring = FSFactory::getClass('FSString','','../');
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i];
				$str_tags = '';
				
				// Danh mục:
				$str_tags .= $item -> category_name;
				// Hãng sx
				$str_tags .= ','.$suffix.' '.$item -> manufactory_name;
				$str_tags .= ','.'dieu hoa'.' '.$item -> manufactory_name;
				// Loại máy: dạng multi
				$str_buff = $item -> loai_may;
				if($str_buff){
					$arr_buff = explode(',', $str_buff);
					foreach($arr_buff as $r){
						if($r){
							if($data_ext_loai_may[$r]){
								$ext_name = $data_ext_loai_may[$r] -> name;
								if(strpos($ext_name, '(') !== false){
									$pos = strpos($ext_name, '(');
									$ext_name = mb_substr($ext_name, 0,$pos);
								}
								if(strpos($ext_name, $suffix) === false)
									$ext_name = $suffix.' '.mb_strtolower($ext_name,'UTF-8');
								$str_tags .= ','.$ext_name;
							}
						}
					}
				}
				
				// Lọc không khí: dạng multi
				$str_buff = $item -> loc_khong_khi;
				if($str_buff){
					$arr_buff = explode(',', $str_buff);
					foreach($arr_buff as $r){
						if($r){
							if($data_ext_loc_khong_khi[$r]){
								$ext_name = $data_ext_loc_khong_khi[$r] -> name;
								if(strpos($ext_name, $suffix) === false)
									$ext_name = $suffix.' '.$ext_name;
								$str_tags .= ','.$ext_name;
							}
						}
					}
				}
				$row3 = array();
				$row3['tags'] = $str_tags;
				$this -> _update($row3,'fs_products','id='.$item->record_id);
			}
		}
		/* Vidic: Sinh tags tự động danh mục bình nóng lạnh
		 */
		function generate_tags_for_binh_nong_lanh(){
			$cat_root = 41;
			$suffix = 'bình nóng lạnh';
			
			// loại
			$data_ext_loc_khong_khi = $this -> get_records('','fs_extends_loc_khong_khi','*',' id ASC ','','id');
			$data_ext_loai_may = $this -> get_records('','fs_extends_dh_loai_may','*',' id ASC ','','id');
			
//			$list = $this ->  get_records('category_id_wrapper LIKE "%,'.$cat_root.',%"','fs_products','*','id',10);
			$list = $this ->  get_records('category_id_wrapper LIKE "%,'.$cat_root.',%"','fs_products_air_conditioner','*','id');
//			$fsstring = FSFactory::getClass('FSString','','../');
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i];
				$str_tags = '';
				
				// Danh mục:
				$str_tags .= $item -> category_name;
				// Hãng sx
				$str_tags .= ','.$suffix.' '.$item -> manufactory_name;
				// Loại máy: dạng multi
				$str_buff = $item -> loai_may;
				if($str_buff){
					$arr_buff = explode(',', $str_buff);
					foreach($arr_buff as $r){
						if($r){
							if($data_ext_loai_may[$r]){
								$ext_name = $data_ext_loai_may[$r] -> name;
								if(strpos($ext_name, '(') !== false){
									$pos = strpos($ext_name, '(');
									$ext_name = mb_substr($ext_name, 0,$pos);
								}
									
								if(strpos($ext_name, $suffix) === false)
									$ext_name = $suffix.' '.mb_strtolower(trim($ext_name));
								$str_tags .= ','.$ext_name;
							}
						}
					}
				}
				
				// Lọc không khí: dạng multi
				$str_buff = $item -> loc_khong_khi;
				if($str_buff){
					$arr_buff = explode(',', $str_buff);
					foreach($arr_buff as $r){
						if($r){
							if($data_ext_loc_khong_khi[$r]){
								$ext_name = $data_ext_loc_khong_khi[$r] -> name;
								if(strpos($ext_name, $suffix) === false)
									$ext_name = $suffix.' '.$ext_name;
								$str_tags .= ','.$ext_name;
							}
						}
					}
				}
				$row3 = array();
				$row3['tags'] = $str_tags;
				$this -> _update($row3,'fs_products','id='.$item->record_id);
			}
		}
		
		/*
		 * Resize lai anh tu bang fs_products
		 * Ko update lai db
		 */
		function new_resize_images(){

			global $db;
			$select = ' SELECT * FROM fs_products WHERE  id <= 500';
//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
			$sql = $db->query($select);
			
			$list = $db->getObjectList();
			
			$arr_img_paths = array(array('resized',141,197,'resized_not_crop'),array('large',251,350,'resized_not_crop'));
			$fsFile = FSFactory::getClass('FsFiles','');
			for($i = 0; $i < count($list) ; $i ++){
				$item = $list[$i]; 
				$image = PATH_BASE.str_replace('/',DS,$item -> image);
//				$fsFile -> create_folder($folder_image_destination);
//				if(!$fsFile -> copy_file($folder_image_begin.$image,$folder_image_destination.$image))
//					continue;
				foreach($arr_img_paths as $path){
					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $image);
//					$fsFile -> create_folder($path_resize);
					$method_resize = $path[3]?$path[3]:'resized_not_crop';
//					$fsFile -> remove_file_by_path($path_resize);
					if(!$fsFile ->$method_resize($image, $path_resize,$path[1], $path[2])){
						echo $item->id.'_';
					}
//						return false;
				}
			}
		}
		
	}
?>
