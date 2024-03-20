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

		function convert_img_webp() {
			global $db;
			$select = ' SELECT id, image  FROM fs_products where id >=4586 AND image_old NOT LIKE "%.gif%" ORDER BY id ASC';
			$sql = $db->query($select);
			$list = $db->getObjectList();
			// echo count($list);
			// die;
			// id > 6391 AND 

			// $arr_img_paths = array (array ('resized', 375, 275, 'cut_image' ), array ('small', 120, 80, 'cut_image' ), array ('large', 600, 400, 'cut_image' ) );

			$fsFile = FSFactory::getClass ( 'FsFiles', '' );

			for($i = 0; $i < count ( $list ); $i ++) {
				$item = $list [$i];

				echo $item->id . "+";

				if(empty($item->image)){
					continue;
				}
				$arr_date=explode('/',$item->image);
				$day = $arr_date[4];
				$month = $arr_date[3];
				$year = $arr_date[2];

				// $folder_image_begin = DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'suachualaptop.delectech.vn'.DS.'public_html'.DS.'images'.DS.'products'.DS.$year.DS.$month.DS.$day.DS.'large'.DS;

				$folder_image_destination =  DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'suachualaptop.delectech.vn'.DS.'public_html'.DS.'images'.DS.'products'.DS.$year.DS.$month.DS.$day.DS.'small'.DS;



				$image = $item->image;
				$image_new = basename ( $image );

				$image_new = $fsFile->genarate_filename_standard ( $image_new );

				$file_ext = $fsFile -> getExt($image_new);
				
				$path_resize = str_replace ( DS . 'original' . DS, DS . 'small' . DS, $folder_image_destination );
				$file_ext = $fsFile -> getExt($path_resize.$image_new);
				$fsFile -> convert_to_webp($path_resize.$image_new,$file_ext);
			}
		}

		// Lấy sản phẩm từ bảng cũ vè
		function syn_products_daikin(){
			global $db; 
			$query = " SELECT * 
						FROM fs_products_categories
						";
			$sql = $db->query ( $query );
			$categories = $db->getObjectListByKey('old_id');

			$fields_in_table = $this -> get_field_table('fs_products');
			$fields_ext = $this -> get_field_table('fs_products_dieu_hoa_khong_khi');
			// remote db

			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			
			$fsstring = FSFactory::getClass('FSString','','../');
			
			// get child_id
			$select = ' select * FROM fs_products 
							ORDER BY id ASC 
							LIMIT 4000';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			

			foreach($list_remote as $item){
				$row = array();
				// $row = (array)$item;
				$cat = isset($categories[$item -> category_id])?$categories[$item -> category_id]:null;

				if($cat){
					$item -> category_id = $cat -> id;
					$item -> category_alias  = $cat -> alias;
					$item -> category_name  = $cat -> name;
					$item -> category_id_wrapper  = $cat -> list_parents;
					$item -> category_alias_wrapper  = $cat -> alias_wrapper;
				}


				foreach($fields_in_table as $field){
					$field_name  = $field -> Field;
					if(isset($item -> $field_name))
						$row[$field_name] = $item -> $field_name;
				}
				// unset($row['origin']);
				// unset($row['description']);
				// unset($row['summary']);
				// unset($row['summary_auto']);
				// unset($row['specs_copy']);
				


				// print_r($row);

				
				$exist = $this -> check_exist($item -> id,0,'id','fs_products');
				if($exist){
					// $this -> _update($row, 'fs_products','id='.$item -> id,1);
				}else{
					$this -> _add($row, 'fs_products',1);
				}

				$this -> update_extend_product_dhkk_daikin($row,$fields_ext);
			}
		}

		function update_extend_product_dhkk_daikin($row,$fields_ext){
			$row1 = array();
			foreach($fields_ext as $field){
				$field_name  = $field -> Field;
				if(isset($row[$field_name]))
					$row1[$field_name] = $row[$field_name];
			}
			$row1['record_id'] = $row1['id'];
			unset( $row1['id'] );

			$exist = $this -> check_exist($row1['record_id'],0,'record_id','fs_products_dieu_hoa_khong_khi');
			if($exist){
				$this -> _update($row1, 'fs_products_dieu_hoa_khong_khi','record_id='.$row1['record_id'] ,1);
			}else{
				$this -> _add($row1, 'fs_products_dieu_hoa_khong_khi',1);
			}

		}

		/*
		Get ảnh cho trang tĩnh từ site cũ của Tuấn Anh sang
		*/
		function get_images_inner_4_contents(){
			$list = $this -> get_records('','fs_contents','*');

				
			for($i = 0; $i < count($list) ; $i ++){				
				$item_r = $list[$i]; 
				$content = $item_r -> content;
				$this -> save_image_in_content_on_local($content,$link_root = '');
			}
		}

		/*
	 * Tự động lấy ảnh từ trên cùng server và cùng hệ thống nên giữ nguyên link ảnh
	 */
	function save_image_in_content_on_local($content,$link_root = ''){
		$folder_image_begin = 'E:\project\navado_asp\\';
		$folder_image_destination = 'E:\project\navado\code\\';
		$fsFile = FSFactory::getClass('FsFiles','');
		preg_match_all('#<img (.*?)>#is',$content,$images);
		 
		$arr_images = array();
		if(!count($images[0]))
			return $content;
		foreach($images[0] as $item){
			preg_match('#src([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]#is',$item,$link_img);
			$link_img = $link_img[3];
			if (filter_var($link_img, FILTER_VALIDATE_URL) === FALSE) {
			}else{
				continue;
			}

			if(!$fsFile -> copy_file($folder_image_begin.str_replace('/', DS,$link_img ),$folder_image_destination.str_replace('/', DS,$link_img )));

			
		}
		// return $content;
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

		function add_news_navado(){
			// catId,thumnail, 
			$arr_syn = array(
					'm8881'=>	'id',
				  'm8884'=>'title',
				  'm8888'=>'summary',
				  'm8889'=>'content',
				  'm8892'=>'tags',
				  'm888P'=>'created_time',
				  'm888T'=>'updated_time',
				  'm8887'=>'image_old'
				  
			);
			
			$fsstring = FSFactory::getClass('FSString','','../');
			
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			// $select = ' SELECT TOP 2 [m8881] ,* 
  	//  					FROM mT888
			//  ';
			 	$select = ' SELECT * FROM [suachualaptop].[dbo].[Pictures] WHERE ObjId = 4577
			 ';

			 // LIMIT 0,500
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			printr($list_remote);
			for($i = 0; $i < count($list_remote) ; $i ++){
				$row = array();
				$item_r = $list_remote[$i]; 
				
//				// check convert:
				$cat = $this -> get_record('id = 1 ' ,'fs_news_categories' );
				if(!$cat)
					continue;
				
				foreach($arr_syn as $field_old => $field_new){

					if($field_new == 'created_time' || $field_new == 'updated_time' ){
						$date = $item_r -> $field_old;
						$row[$field_new] =  $date->format('Y-m-d H:i:s');
					
						
					}else{
						$row[$field_new] = $item_r -> $field_old;
					}
				}
				$row['alias'] = $fsstring -> stringStandart($row['title']);
				$row['category_id'] = $cat -> id;
				$row['category_alias'] = $cat ->alias;
				$row['category_name'] = $cat ->name;
				$row['category_id_wrapper'] = $cat ->list_parents;
				$row['category_alias_wrapper'] = $cat ->alias_wrapper;
				$row ['category_published'] = $cat->published;
				$row['show_in_homepage'] = $cat->show_in_homepage;
				// $row['ordering'] = $i + 1;
				$fsremote_class = FSFactory::include_class ( 'remote' );
				$content = $row['content'];
				// $this -> save_image_in_content_on_local($content);
				// $content = FSRemote::save_image_in_remote_content ( $content,'http://navado.com.vn/' );
				$row ['content'] = htmlspecialchars_decode ( $content );
				// image
//				$row['image'] = $this -> get_main_image_for_news($item_r -> file_img );
				// die($row);
				// check exist
				$exist = $this -> check_exist($row['id'],0,'id','fs_news');
				if($exist){
					$this -> _update($row, 'fs_news','id='.$row['id'],1);
				}else{
					// $this -> _add($row, 'fs_news',1);
				}
			}
		}

		function get_images_inner_4_products_navado(){
			$list = $this -> get_records('','fs_products','*',2);

				
			for($i = 0; $i < count($list) ; $i ++){				
				$item = $list[$i]; 
				$description = $item -> description;
				$row = array();
				$row ['description']  = $this -> save_image_in_content_on_local($description,$link_root = '');
				// $this -> _update($row, 'fs_news','id='.$item -> id,1);
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
		function add_main_images_($path_original){
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
			$select = ' SELECT * from fs_products where is_edit = 0  ORDER BY id DESC LIMIT 3';
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
		function find_product_error_image_msmobile(){
			global $db;
			$select = ' SELECT * from fs_products where id <= 500 AND id >=0 ORDER BY id DESC LIMIT 502';
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
				if(file_exists($folder_image_destination.$path_img)){
//					echo "ko co $folder_image_begin.$image <br/>";
					continue;
				}
//				if(!$fsFile -> copy_file($folder_image_begin.$path_img,$folder_image_destination.$path_img))
//					return;
//				foreach($arr_img_paths as $path){
//					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination.$path_img);
//					$fsFile -> create_folder(dirname($path_resize));
//					$method_resize = $path[3]?$path[3]:'resized_not_crop';
//					if(!$fsFile ->$method_resize($folder_image_destination.$path_img, $path_resize,$path[1], $path[2]))
//						return false;
//				}
				$row = array();
				$row['is_edit'] = 0;
				$this ->_update($row, 'fs_products','id = '.$item -> id);
			}
		}
		
		function add_images_other_msmobile(){
			global $db;
			$select = ' SELECT * from fs_products_images where id = 8954  ORDER BY id DESC LIMIT 300';
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
//				if(!file_exists($folder_image_begin.str_replace('/',DS,$image))){
//					echo "ko co $folder_image_begin.$image <br/>";
//					return;
//				}
				if(file_exists($folder_image_destination.$path_img)){
//					echo "ko co $folder_image_begin.$image <br/>";
					continue;
				}
//				if(!$fsFile -> copy_file($folder_image_begin.$path_img,$folder_image_destination.$path_img))
//					return;
//				foreach($arr_img_paths as $path){
//					$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination.$path_img);
//					$fsFile -> create_folder(dirname($path_resize));
//					$method_resize = $path[3]?$path[3]:'resized_not_crop';
//					if(!$fsFile ->$method_resize($folder_image_destination.$path_img, $path_resize,$path[1], $path[2]))
//						return false;
//				}
				$row = array();
				$row['is_edit'] = 0;
				$this ->_update($row, 'fs_products_images','id = '.$item -> id);
			}
		}
		
	function add_main_images_news_msmobile(){
			global $db;
			$select = ' SELECT * from fs_news where id > 8872  ORDER BY id DESC LIMIT 250';
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
				$this ->_update($row, 'fs_news','id = '.$item -> id);
			}
		}
		
	function find_news_error_image_msmobile(){
			global $db;
			$select = ' SELECT * from fs_news where id > 8872  ORDER BY id DESC LIMIT 250';
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


		function syn_products(){

			$arr_syn = array(
					'product_id'  =>'id',
					'model' => 'code',
				  'name' =>'name',				  
				  'status' => 'published',
				  // 'parent_id' => 'parent_id',
				  // 'manufacturer_id'=> 'manufactory_id',
				  'image'=>'image_old',
				  'price' => 'price'

			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = 'select a.*,b.name,b.description,c.category_id
					from product AS a
					LEFT JOIN product_description AS b ON a.product_id = b.product_id 
					LEFT JOIN product_to_category AS c ON a.product_id = c.product_id
					
					GROUP BY a.product_id
					ORDER BY a.product_id ASC
					LIMIT 7500,1000
			 ';
			 // LIMIT 0,500
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();

		
			$array_new_cat = $this -> get_records('','fs_products_categories','*','','','id');			
			$array_new_manufactories = $this -> get_records('','fs_manufactories','*','','','id');

			$fsremote_class = FSFactory::include_class ( 'remote' );

			// $list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			$i = 0;
			foreach($list_remote as $item_r){
				
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$category_id = $item_r -> category_id;
				$row['alias'] = $fsstring -> stringStandart(trim($item_r -> name));
				
				$cat = $array_new_cat[$category_id];
				$row['category_id'] = $cat -> id;
				$row['category_id_wrapper'] = $cat -> list_parents;
				$row['category_root_alias'] = $cat -> root_alias;
				$row['category_name'] = $cat -> name;
				$row['category_alias'] = $cat -> alias;
				$row['category_alias_wrapper'] = $cat -> alias_wrapper;
				$row ['category_published'] = $cat->published;
				$row['show_in_homepage'] = $cat->show_in_homepage;
				
				// manufactory
				$manufactory_id = $item_r -> manufacturer_id;
				$manufactory = $array_new_manufactories[$manufactory_id];
				
				$row ['manufactories_ids'] = $manufactory -> list_parents;
				$row ['manufactories_alias'] =  $manufactory ->  alias_wrapper;
				$row ['manufactories_alias_wrapper'] = $manufactory -> alias_wrapper;
				$row ['manufactories_ids_wrapper'] = $manufactory -> list_parents;


				$row['created_time'] = $time;
				$row['edited_time'] = $time;



				$description = $item_r -> description;
				// $description = FSRemote::save_image_in_remote_content ( $content,'http://vidic.com.vn/' );
				$row ['description'] = htmlspecialchars_decode ( $description );

				$row['image'] = $this -> get_main_image($item_r -> image, $item_r -> product_id );
				
				// check exist
				$exist = $this -> check_exist($item_r -> product_id,0,'id','fs_products');
				if($exist){
					$this -> _update($row, 'fs_products','id='.$item_r -> product_id,1);
				}else{
					$this -> _add($row, 'fs_products',1);
				}
				
				// $this -> _add($row, 'fs_products',1);
				$i ++;
			}
		}

		function syn_products_navado(){

			$arr_syn = array(
					'm8441'  =>'id',
					'm8443' => 'name',		  
					'm844A' => 'category_id',	
				  'm8445'=>'image_old',
				  'm8447' => 'description'


			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = 'SELECT *
  						FROM mT844

			 ';

			 // LIMIT 0,500
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// print_r($list_remote);
			// die;

			
			$array_cats = $this -> get_records('','fs_products_categories','*','','','id');			
			// $array_new_manufactories = $this -> get_records('','fs_manufactories','*','','','id');
			// print_r($array_cats);
			// die;

			$fsremote_class = FSFactory::include_class ( 'remote' );

			// $list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			$i = 0;
			foreach($list_remote as $item_r){
				
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$category_id = $row['category_id'];
				$row['alias'] = $fsstring -> stringStandart(trim($row['name']));
				
				$cat = $array_cats[$category_id];
				$row['category_id'] = $cat -> id;
				$row['category_id_wrapper'] = $cat -> list_parents;
				$row['category_root_alias'] = $cat -> root_alias;
				$row['category_name'] = $cat -> name;
				$row['category_alias'] = $cat -> alias;
				$row['category_alias_wrapper'] = $cat -> alias_wrapper;

				// print_r($row);
				// die;
				// $row ['category_published'] = $cat->published;
				// $row['show_in_homepage'] = $cat->show_in_homepage;
				
				// manufactory
				// $manufactory_id = $item_r -> manufacturer_id;
				// $manufactory = $array_new_manufactories[$manufactory_id];
				
				// $row ['manufactories_ids'] = $manufactory -> list_parents;
				// $row ['manufactories_alias'] =  $manufactory ->  alias_wrapper;
				// $row ['manufactories_alias_wrapper'] = $manufactory -> alias_wrapper;
				// $row ['manufactories_ids_wrapper'] = $manufactory -> list_parents;


				$row['created_time'] = $time;
				$row['edited_time'] = $time;



				// $description = $item_r -> description;
				// $description = FSRemote::save_image_in_remote_content ( $content,'http://vidic.com.vn/' );
				// $row ['description'] = htmlspecialchars_decode ( $description );

				// $row['image'] = $this -> get_main_image($item_r -> image, $row['id']  );
				
				// check exist
				$exist = $this -> check_exist($row['id'] ,0,'id','fs_products');
				if($exist){
					$this -> _update($row, 'fs_products','id='.$row['id'] ,1);
				}else{
					$this -> _add($row, 'fs_products',1);
				}
				
				// $this -> _add($row, 'fs_products',1);
				$i ++;
			}
		}	

		

		/*
		 * Lấy ảnh chính
		 */
		function  get_main_image($image,$product_id ){

			$fsFile = FSFactory::getClass('FsFiles','');

			// $image_new = str_replace('.jpg', '-500x500.jpg', $image);
			// $image_new = str_replace('.png', '-500x500.png', $image_new);
			$arr_img_paths = array (array ('large',510,518, 'cut_image' ), array ('resized',250,254, 'cut_image' ), array ('small', 52,50, 'cut_image' ) );

			// lấy 2 ảnh (gốc về crop 250_ ) về folder /media/product/
			$fsremote_class = FSFactory::include_class ( 'remote' );
			// $image_new = FSRemote::get_filename_from_url($image);
			// die;
			$image_new = str_replace(" ", '%20', $image); 
			$filename = FSRemote::get_filename_from_url('http://phutungoto.vn/images/'.$image_new);
			$fsstring = FSFactory::getClass('FSString','','../');

			
	    	$file_ext = $fsFile ->  getExt($image);
	    	$filename = $fsFile ->  getFileName($image, $file_ext).'.'.$file_ext;
			$day =  date('d')-3;
			$month =  date('m');
			$cyear = date('Y');


			FSRemote:: save_image('http://phutungoto.vn/image/'.$image_new,1,'/images/products/'.$cyear.'/'.$month.'/'.$day.'/'.$product_id.'/'.'original'.'/',0,$filename);

			// die;
			// $folder_image_begin = 'F:\project\phutungoto\code\images\products\\'.$filename;
			
			$folder_image_destination = 'F:\project\phutungoto\code\images\products\\'.$cyear.'\\'.$month.'\\'.$day.'\\'.$product_id.'\original\\';
			
			$fsFile -> create_folder($folder_image_destination);
			// $fsFile -> copy_file($folder_image_begin,$folder_image_destination.$filename);
			foreach($arr_img_paths as $path){
				$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
				$fsFile -> create_folder($path_resize);
				$method_resize = $path[3]?$path[3]:'resized_not_crop';
				if(!$fsFile ->$method_resize($folder_image_destination.$filename, $path_resize.$filename,$path[1], $path[2]))
					continue;
			}
			return 'images/products/'.$cyear.'/'.$month.'/'.$day.'/'.$product_id.'/original/'.$filename;
//				$this -> _update($row3, 'fs_products_images',' `id` = '.$item->id);
		}

		/*
		 * Vidic: Lấy dữ liệu cho bảng sản phẩm
		 * warranty_time => cover ( varchar)
		 */
		function syn_products_(){
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
	
	// function syn_manufactories(){

	// 		$arr_syn = array(
	// 				'manufacturer_id'  =>'id',
	// 			  'name' =>'name',
	// 			  'parent_id' =>'parent_id',
	// 			  // 'sup_active' => 'published',
	// 		);
	// 		$fsstring = FSFactory::getClass('FSString','','../');
							
	// 		// remote db
	// 		include_once 'remote_db.php';
	// 		$remote_db = new Remote_db();
	// 		$select = ' select a.*,b.name
	// 				from manufacturer AS a
	// 				LEFT JOIN manufacturer_description AS b ON a.manufacturer_id = b.manufacturer_id 
	// 				GROUP BY a.manufacturer_id
					
	// 				';
	// 		$sql = $remote_db->query($select);
			
	// 		$list_remote = $remote_db->getObjectListByKey('manufacturer_id');
	// 		$time = date('Y-m-d H:i:s');
			
	// 		$row = array();
	// 		$i = 0;
	// 		foreach($list_remote as $item_r){
	// 		// for($i = 0; $i < count($list_remote) ; $i ++){
	// 			// $item_r = $list_remote[$i]; 
	// 			foreach($arr_syn as $field_old => $field_new){
	// 				$row[$field_new] = $item_r -> $field_old;
	// 			}
	// 			$row['alias'] = $fsstring -> stringStandart($item_r -> name);
				
	// 			$id = $item_r -> manufacturer_id;
	// 			$row['created_time'] = $time;
	// 			$row['edited_time'] = $time;
	// 			$row['list_parents'] = $item_r -> parent_id ? ','.$item_r -> parent_id .','.$id.',': ','.$id.',';
	// 			$row['alias_wrapper'] = $item_r -> parent_id ? ','.$fsstring -> stringStandart($list_remote[$item_r -> parent_id]->name).','.$row['alias'] .',':','.$row['alias'].',' ;
	// 			// print_r($row);
	// 			 $this -> _add($row, 'fs_manufactories',1);
				
	// 			// $row3['manufactory_alias'] = $row['alias'];
	// 			// $row3['manufactory_name'] = $row['name'];
	// 			// $this -> syn_product_vs_foreign($row['id'],'manufactory',$row3);
	// 			 $i ++;
	// 		}
	// 	}

		function syn_cats(){

			$arr_syn = array(
					'category_id'  =>'id',
				  'name' =>'name',				  
				  'status' => 'published',
				  'parent_id' => 'parent_id'
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' select a.*,b.name
					from category AS a
					LEFT JOIN category_description AS b ON a.category_id = b.category_id 
					GROUP BY a.category_id
					
			 ';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectListByKey('category_id');
			// $list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			$i = 0;
			foreach($list_remote as $item_r){
				
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$id = $item_r -> category_id;
				$row['alias'] = $fsstring -> stringStandart(trim($item_r -> name));
				
				$row['created_time'] = $time;
				$row['updated_time'] = $time;
				$row['list_parents'] = $item_r -> parent_id ? ','.$item_r -> parent_id .','.$id.',': ','.$id.',';
				$row['alias_wrapper'] = $item_r -> parent_id ? ','.$fsstring -> stringStandart(trim($list_remote[$item_r -> parent_id]->name)).','.$row['alias'] .',':','.$row['alias'].',' ;
				echo $this -> _add($row, 'fs_products_categories',1);
				$i ++;
			}
		}

		function get_category_navado(){

			$arr_syn = array(
					'm0841'  =>'id',
				  'm0843' =>'name'			  
				 
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_sqlsrv.php';

			$remote_db = new Remote_db();
			$select = '  SELECT * FROM mT084
					
			 ';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();

			// print_r($list_remote);
			// die;
			// $list_remote = $remote_db->getObjectList();
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			$i = 0;
			foreach($list_remote as $item_r){
				
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$id = $item_r -> category_id;
				$row['alias'] = $fsstring -> stringStandart(trim($row['name']));
				
				$row['created_time'] = $time;
				$row['updated_time'] = $time;
				$row['list_parents'] = ','.$row['id'].',';
				$row['alias_wrapper'] = ','.$row['alias'].',' ;
				$row['link_old'] =  str_replace('http://navado.com.vn', '', $item_r -> m0844) ;
				echo $this -> _add($row, 'fs_products_categories',1);
				$i ++;
			}
		}

		function syn_cats__(){

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
					'manufacturer_id'  =>'id',
				  'name' =>'name',
				  'parent_id' =>'parent_id',
				  // 'sup_active' => 'published',
			);
			$fsstring = FSFactory::getClass('FSString','','../');
							
			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			$select = ' select a.*,b.name
					from manufacturer AS a
					LEFT JOIN manufacturer_description AS b ON a.manufacturer_id = b.manufacturer_id 
					GROUP BY a.manufacturer_id
					
					';
			$sql = $remote_db->query($select);
			
			$list_remote = $remote_db->getObjectListByKey('manufacturer_id');
			$time = date('Y-m-d H:i:s');
			
			$row = array();
			$i = 0;
			foreach($list_remote as $item_r){
			// for($i = 0; $i < count($list_remote) ; $i ++){
				// $item_r = $list_remote[$i]; 
				foreach($arr_syn as $field_old => $field_new){
					$row[$field_new] = $item_r -> $field_old;
				}
				$row['alias'] = $fsstring -> stringStandart($item_r -> name);
				
				$id = $item_r -> manufacturer_id;
				$row['created_time'] = $time;
				$row['edited_time'] = $time;
				$row['list_parents'] = $item_r -> parent_id ? ','.$item_r -> parent_id .','.$id.',': ','.$id.',';
				$row['alias_wrapper'] = $item_r -> parent_id ? ','.$fsstring -> stringStandart($list_remote[$item_r -> parent_id]->name).','.$row['alias'] .',':','.$row['alias'].',' ;
				// print_r($row);
				 $this -> _add($row, 'fs_manufactories',1);
				
				// $row3['manufactory_alias'] = $row['alias'];
				// $row3['manufactory_name'] = $row['name'];
				// $this -> syn_product_vs_foreign($row['id'],'manufactory',$row3);
				 $i ++;
			}
		}

		function syn_manufactories_(){

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
				// $row['list_parents'] = $item_r -> parent_id ? ','.$item_r -> parent_id .','.$item_r -> id ;
				
				// echo $this -> _add($row, 'fs_manufactories',1);
				
				// $row3['manufactory_alias'] = $row['alias'];
				// $row3['manufactory_name'] = $row['name'];
				// $this -> syn_product_vs_foreign($row['id'],'manufactory',$row3);
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
		function  get_main_image_1($image ){
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


		/*
		 * Daikin: Lấy ảnh chính cho tin tức: trên local và cùng hệ thống
		 */
		function  get_main_image_for_news_daikin(){
			$list = $this -> get_records('','fs_news','*');

				
			for($i = 0; $i < count($list) ; $i ++){				
				$item_r = $list[$i]; 
				$image = $item_r -> image;
				$this -> exec_image_on_local($image);
			}
		
		}

		function  get_main_image_for_products_daikin(){
			$list = $this -> get_records('','fs_products','*','id ASC ',20000);
			
				
			for($i = 0; $i < count($list) ; $i ++){				
				$item_r = $list[$i]; 
				$image = $item_r -> image;
				$this -> exec_image_on_local($image);
			}
		
		}

		function  get_main_image_for_news_navado(){
			$list = $this -> get_records('','fs_news','*','');

				
			for($i = 0; $i < count($list) ; $i ++){				
				$item = $list[$i]; 
				$image = $item -> image_old;
				// $this -> exec_image_on_local($image);
				$row3 = array();
				$row3['image'] = $this -> exec_image_on_local($image);;
				// $this -> _update($row3, 'fs_news',' `id` = '.$item->id);
			}
		}
		

		function get_main_image_for_news_phapluat(){
			
			// $list = $this -> get_records('image','fs_news','*','id DESC','10');
			global $db;
			$select = ' SELECT * FROM fs_news WHERE image is NULL AND id > 35000 ';
			
			$sql = $db->query ( $select );
			$list = $db->getObjectList ();
			// print_r($list);
			// die;


			for($i = 0; $i < count($list) ; $i ++){				
				$item = $list[$i]; 
				$image = $item -> image_old;
				$type = $item -> type;
				$d =  date("j",strtotime($item-> created_time));
				$m =  date("n",strtotime($item-> created_time));
				$y =  date("Y",strtotime($item-> created_time));
				$image_copy = $this -> exec_image_on_local_phapluat($type,$y,$m,$d,$image);
				$row3 = array();
				if($image_copy){
					$row3['image'] = $image_copy;
					$row3['is_image_cover'] = 1;
				}else{
					$row3['is_image_cover'] = 0;
				}
				
				$this -> _update($row3, 'fs_news',' `id` = '.$item->id);
			}
		}

		function  get_main_image_for_products_navado(){
			$list = $this -> get_records('','fs_products','*','');

				
			for($i = 0; $i < count($list) ; $i ++){				
				$item = $list[$i]; 
				$image = $item -> image_old;
				// $this -> exec_image_on_local($image);
				$row3 = array();
				$row3['image'] = $this -> exec_image_on_local($image,'products');;
				$this -> _update($row3, 'fs_products',' `id` = '.$item->id);


			}
		
		}


		/*
		Copy ảnh: Cover khi: cùng hệ thống & ảnh trên local
		*/

		function exec_image_on_local_phapluat($type,$year,$month,$day,$link_img,$folder_module = 'news'){
			$folder_image_begin = DS.'mnt'.DS.'data'.DS;
			$folder_image_destination_root = DS.'mnt'.DS.'data'.DS;
			$folder_image_destination = DS.'home'.DS.'phapluatnet'.DS.'public_html'.DS.'images'.DS.$folder_module.DS.$year.DS.$month.DS.$day.DS.'original'.DS;

			// $folder_image_begin = 'E:\project\phapluatnet\code\\';
			// $folder_image_destination_root = 'E:\project\phapluatnet\code\\';
			// $folder_image_destination = 'E:\project\phapluatnet\code\images\\'.$folder_module.'\\'.$year.'\\'.$month.'\\'.$day.'\original\\';
			
			$fsFile = FSFactory::getClass('FsFiles','');

			// copy bảo toàn link ảnh gốc cũ			
			// $file_ext = $fsFile ->  getExt($link_img);
	  //   	$filename = $fsFile ->  getFileName($link_img, $file_ext).'.'.$file_ext;
	  //   	$fsFile -> create_folder($folder_image_destination);
			// if(!$fsFile -> copy_file($folder_image_begin.str_replace('/', DS,$link_img ),$folder_image_destination.$link_img)){
			// }
			
			// $link_img_org = str_replace('-240x135', '', $link_img);
			// $link_img_org = str_replace('-200x200', '', $link_img);
			
			// if($link_img_org != $link_img){
			// 	if(file_exists($folder_image_begin.$link_img_org))
			// 		$link_img = $link_img_org;
			// }

			// $type = FSInput::get ( 'type' );

			$file_exists = file_exists($folder_image_begin.str_replace('/', DS,$link_img ));
			if(!$file_exists){
				return;
			}
			

			// if(file_exists($folder_image_begin.str_replace('/', DS,$link_img )))
			// 	return;			
			// }

			$arr_img_paths = array (array ('small', 100, 100, 'cut_image' ), array('resized', 240, 160, 'cut_image' ), array ('large', 450, 300, 'cut_image' ) , array ('slide', 750, 500, 'cut_image' ));
		
			$fsFile -> create_folder($folder_image_destination);
			$file_ext = $fsFile ->  getExt($link_img);
	    	$filename = $fsFile ->  getFileName($link_img, $file_ext).'.'.$file_ext;
			if(!$fsFile -> copy_file($folder_image_begin.str_replace('/', DS,$link_img ),$folder_image_destination.$filename)){
			}

			foreach($arr_img_paths as $path){
				$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
				$fsFile -> create_folder($path_resize);
				$method_resize = $path[3]?$path[3]:'resized_not_crop';

				if(!$fsFile ->$method_resize($folder_image_destination.$filename, $path_resize.$filename,$path[1], $path[2]))
					echo "Không resized đươc";
			}

			return 'images/'.$folder_module.'/'.$year.'/'.$month.'/'.$day.'/original/'.$filename;
		}



		function exec_image_on_local($link_img,$folder_module = 'news'){
			$year = 2019;
			$month = '02';
			$day = 20;
			$folder_image_begin = 'E:\project\navado_asp\\';
			$folder_image_destination_root = 'E:\project\navado\code\\';
			$folder_image_destination = 'E:\project\navado\code\images\\'.$folder_module.'\\'.$year.'\\'.$month.'\\'.$day.'\original\\';
			$fsFile = FSFactory::getClass('FsFiles','');


			// copy bảo toàn link ảnh gốc cũ			
			$file_ext = $fsFile ->  getExt($link_img);
	    	$filename = $fsFile ->  getFileName($link_img, $file_ext).'.'.$file_ext;
	    	$fsFile -> create_folder($folder_image_destination_root.str_replace($filename, '', $link_img));
			if(!$fsFile -> copy_file($folder_image_begin.str_replace('/', DS,$link_img ),$folder_image_destination_root.$link_img)){
			}
			
			// $link_img_org = str_replace('-240x135', '', $link_img);
			$link_img_org = str_replace('-200x200', '', $link_img);
			
			if($link_img_org != $link_img){
				if(file_exists($folder_image_begin.$link_img_org))
					$link_img = $link_img_org;
			}



			// $arr_img_paths =  array (array ('resized', 365, 245, 'cut_image' ), array ('small', 102, 68, 'cut_image' ), array ('large', 620, 355, 'cut_image' ) );
			$arr_img_paths =  array (array ('resized',320,320, 'resize_image' ), array ('small', 56,56, 'cut_image' ), array ('large',  500,500, 'resize_image' ) );


			$fsFile -> create_folder($folder_image_destination);
			$file_ext = $fsFile ->  getExt($link_img);
	    	$filename = $fsFile ->  getFileName($link_img, $file_ext).'.'.$file_ext;
			if(!$fsFile -> copy_file($folder_image_begin.str_replace('/', DS,$link_img ),$folder_image_destination.$filename)){
			}
			
		
			foreach($arr_img_paths as $path){

				$path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
				$fsFile -> create_folder($path_resize);
				$method_resize = $path[3]?$path[3]:'resized_not_crop';

				if(!$fsFile ->$method_resize($folder_image_destination.$filename, $path_resize.$filename,$path[1], $path[2]))
					echo "Không resized đươc";

				
				// Đóng dấu
				if($path[0] == "resized" || $path[0] == "large"){
					// echo $path_resize,$image,PATH_BASE.str_replace('/',DS, 'images/mask/mask_'.$item[0].'.png'),5;
					// $fsFile->add_logo($path_resize,$image,PATH_BASE.str_replace('/',DS, 'images/mask/mask_'.$path[0].'.png'),5);
				}

				// if(!$fsFile ->$method_resize($folder_image_destination.str_replace('/', DS,$link_img ), $path_resize.str_replace('/', DS,$link_img ),$path[1], $path[2])){
				// 	echo "Không resized đươc";
				// 	// continue;
				// }
			}

			echo 'images/'.$folder_module.'/'.$year.'/'.$month.'/'.$day.'/original/'.$filename;
			die;
			
		}



		function  get_other_image_for_products_daikin(){

			// remote db
			include_once 'remote_db.php';
			$remote_db = new Remote_db();
			
			$fsstring = FSFactory::getClass('FSString','','../');
			
			// get child_id
			$select = ' select * FROM fs_products_images 
								WHERE product_id >= 1389
							ORDER BY id ASC 

							LIMIT 4000';
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
						

			foreach($list_remote as $item){
				$row = array();
				$row['image'] = $item -> image;
				$row['record_id'] = $item -> product_id;
				
				$row['id'] = $item -> id;
				
				$exist = $this -> check_exist($item -> id,0,'id','fs_products_images');
				if($exist){
					// $this -> _update($row, 'fs_products','id='.$item -> id,1);
				}else{
					$this -> _add($row, 'fs_products_images',1);
				}

				$this -> exec_other_image_on_local_daikin($row['image']);
			}
		
		}

		/*
		Copy ảnh: Cover khi: cùng hệ thống & ảnh trên local
		*/
		function exec_other_image_on_local_daikin($link_img){
			$folder_image_begin = 'F:\project\daikin_v1_online\\';
			$folder_image_destination = 'F:\project\daikinv2\code\\';
			$fsFile = FSFactory::getClass('FsFiles','');

			


			$arr_img_paths = array ( array ('small', 86, 70, 'cut_image' ), array ('large', 512, 420, 'resize_image' ) );

			
			if(!$fsFile -> copy_file($folder_image_begin.str_replace('/', DS,$link_img ),$folder_image_destination.str_replace('/', DS,$link_img ))){
			}

						
			// $fsFile -> create_folder($folder_image_destination);
			// $fsFile -> copy_file($folder_image_begin,$folder_image_destination.$filename);
			foreach($arr_img_paths as $path){
				// $path_resize = str_replace(DS.'original'.DS, DS.$path[0].DS, $folder_image_destination);
				
				$path_resize =  $folder_image_destination.str_replace(DS.'original'.DS, DS.$path[0].DS,str_replace('/', DS,$link_img ) );
				
				$path_resize = str_replace(basename($path_resize),'',$path_resize);
				$image = basename($link_img);
				$fsFile -> create_folder($path_resize);
				$method_resize = $path[3]?$path[3]:'resized_not_crop';
				echo $folder_image_destination.str_replace('/', DS,$link_img );
				echo "<br/>";
				echo $path_resize.str_replace(DS.'original'.DS, DS.$path[0].DS,str_replace('/', DS,$link_img ) );
				// die;
				if(!$fsFile ->$method_resize($folder_image_destination.str_replace('/', DS,$link_img ), $folder_image_destination.str_replace(DS.'original'.DS, DS.$path[0].DS,str_replace('/', DS,$link_img ) ),$path[1], $path[2])){
					echo "Không resized đươc";
					// continue;
				}

				// Đóng dấu
				if($path[0] == "resized" || $path[0] == "large"){
					// echo $path_resize,$image,PATH_BASE.str_replace('/',DS, 'images/mask/mask_'.$item[0].'.png'),5;
					$fsFile->add_logo($path_resize,$image,PATH_BASE.str_replace('/',DS, 'images/mask/mask_'.$path[0].'.png'),5);
				}

				// if(!$fsFile ->$method_resize($folder_image_destination.str_replace('/', DS,$link_img ), $path_resize.str_replace('/', DS,$link_img ),$path[1], $path[2])){
				// 	echo "Không resized đươc";
				// 	// continue;
				// }
			}
			
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

	/******** UPDATE SP TƯ WP *********/
	function syn_product_cats_wp() {
		
		$arr_syn = array ('term_id' => 'id', 'name' => 'name', 'slug' => 'alias', 'parent' => 'parent_id' );
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		$select = "select * 
					from 
					wp_terms AS a
					LEFT JOIN wp_term_taxonomy AS b ON a.term_id = b.term_id 
					WHERE 
					b.taxonomy = 'product_cat' ";
		
		$sql = $remote_db->query ( $select );
		
		$list_remote = $remote_db->getObjectList ();
		$time = date ( 'Y-m-d H:i:s' );
		
		$row = array ();
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$item_r = $list_remote [$i];
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			//				$row['alias'] = $fsstring -> stringStandart($item_r -> cat_name);
			

			$row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
			$row ['list_parents'] = ',' . $row ['id'] . ',';
			$row ['level'] = 0;
			$row ['published'] = 1;
			$row ['show_in_homepage'] = 1;
			$row ['show_in_footer'] = 1;
			$row ['updated_time'] = $time;
			$this->_add ( $row, 'fs_products_categories', 1 );
		}
	}
	function syn_news_cats_wp() {
		
		$arr_syn = array ('term_id' => 'id', 'name' => 'name', 'slug' => 'alias', 'parent' => 'parent_id' );
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		$select = "select * 
					from 
					wp_terms AS a
					LEFT JOIN wp_term_taxonomy AS b ON a.term_id = b.term_id 
					WHERE 
					b.taxonomy = 'blogs' ";
		
		$sql = $remote_db->query ( $select );
		
		$list_remote = $remote_db->getObjectList ();
		$time = date ( 'Y-m-d H:i:s' );
		
		$row = array ();
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$item_r = $list_remote [$i];
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			//				$row['alias'] = $fsstring -> stringStandart($item_r -> cat_name);
			

			$row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
			$row ['list_parents'] = ',' . $row ['id'] . ',';
			$row ['level'] = 0;
			$row ['published'] = 1;
			$row ['show_in_homepage'] = 1;
			// $row ['show_in_footer'] = 1;
			$row ['updated_time'] = $time;
			$row ['alias_old'] = $row['alias'];
			$this->_add ( $row, 'fs_news_categories', 1 );
		}
	}

	
	function add_user_phapluatnet() {
		$arr_syn = array (
							'UserId' => 'userId_code',
							'UserName' => 'username',
							'LastActivityDate' => 'created_time',
						); 
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		// remote db
		include_once 'remote_sqlsrv.php';
		$remote_db = new Remote_db ();
		$select = "SELECT *
  					FROM [phapluat_db].[dbo].[aspnet_Users]";
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		$row = array ();
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$item_r = $list_remote [$i];
			foreach ( $arr_syn as $field_old => $field_new ) {
				if($field_new == 'created_time' || $field_new == 'updated_time'){
					$date = $item_r -> $field_old;
					$row[$field_new] =  $date->format('Y-m-d H:i:s'); 
				}else{
					$row[$field_new] = $item_r -> $field_old;
				}
			}
			$row ['published'] = 1;
			$this->_add ($row, 'fs_users', 1);
		}
	}

	function update_member() {
		$arr_syn = array (
							'id' => 'id',
							'username' => 'username',
							'created_time' => 'created_time',
							'userId_code' => 'userId_code',
						); 
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		// remote db
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		$select = "SELECT *
  					FROM fs_users";
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		$row = array ();
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$item_r = $list_remote [$i];
			foreach ( $arr_syn as $field_old => $field_new ) {
				
				$row[$field_new] = $item_r -> $field_old;
				
			}
			$row ['published'] = 1;
			$this->_add ($row, 'fs_members', 1);
		}
	}


	// update them userid_code

	function news_update_userid_code() {
		$arr_syn = array (
						'UserId' => 'userId_code',
						);
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		// remote db
		include_once 'remote_sqlsrv.php';
		$remote_db = new Remote_db ();
		$select = "SELECT [ID],[CreatorID] 
  					FROM [phapluat_db].[dbo].[Website_Content]";
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		$row = array ();
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$item_r = $list_remote [$i];
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			// $row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
			$this->_update ($row, 'fs_news', ' id = ' . $item_r->ID);
		}
	}


	function news_update_image_name_phapluat() {
		// die;
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		include_once 'remote_sqlsrv.php';
		$remote_db = new Remote_db ();
		$news = $this->get_records ( '', 'fs_news', 'id, image, created_time', 'id ASC', '', 'id' );
		foreach ($news as $key => $value) {
			$d =  date("j",strtotime($value-> created_time));
			$m =  date("n",strtotime($value-> created_time));
			$y =  date("Y",strtotime($value-> created_time));

			$row = array();
			$row["image"] = 'images/news/'.$y.'/'.$m.'/'.$d.'/original/'.$value-> image;
			$this->_update ($row, 'fs_news', ' id = ' . $value->id);
		}

	}

	function news_update_image_old_name_phapluat() {

		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		include_once 'remote_sqlsrv.php';
		$remote_db = new Remote_db ();
		$news = $this->get_records ( '', 'fs_news', 'id, image, created_time', 'id ASC', '', 'id' );
		foreach ($news as $key => $value) {
			$d =  date("j",strtotime($value-> created_time));
			$m =  date("n",strtotime($value-> created_time));
			$y =  date("Y",strtotime($value-> created_time));

			$row = array();
			$row["image_old"] = 'Uploads/Originals/'.$y.'/'.$m.'/'.$d.'/'.$value-> image;
			$this->_update ($row, 'fs_news', ' id = ' . $value->id);
		}

	}


	
	function add_tags_news_phapluatnet() {
		$arr_syn = array (
							'ID' => 'id',
							'Name' => 'name',
							'NameAscii' => 'alias',
							'IsShow' => 'published',
							'IsDelete' => 'is_delete',
						); 
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		// remote db
		include_once 'remote_sqlsrv.php';
		$remote_db = new Remote_db ();
  		$select = "SELECT [ID],[Name],[IsShow],[NameAscii]
  		FROM [phapluat_db].[dbo].[System_Tag]
  		WHERE ID > 20000
  		";

		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		// echo "<pre>";
		// print_r($list_remote);
		// die;
		$row = array ();
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$item_r = $list_remote [$i];
			foreach ( $arr_syn as $field_old => $field_new ) {
				
				$row[$field_new] = $item_r -> $field_old;
				
			}
			
			$this->_add ($row, 'fs_tags', 1);
		}
	}





	function syn_news_cats_phapluatnet() {
		
		$arr_syn = array ('ID' => 'id', 'Name' => 'name', 'NameAscii' => 'alias', 'ParentID' => 'parent_id', 'SeoDescription' => 'seo_description', 'SeoKeyword' => 'seo_keyword', 'SEOTitle' => 'seo_title' , 'TotalViews' => 'hits' ); 
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_sqlsrv.php';

		$remote_db = new Remote_db ();
		$select = "select * 
					from 
					Website_Modules";
		// $select = "select * 
		// 			from 
		// 			Website_Modules where IsShow = 1 AND IsDeleted = 0";
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		
		$time = date ( 'Y-m-d H:i:s' );
		$categories = $this->get_records ( '', 'fs_news_categories', '*', '', '', 'id' );
		$row = array ();
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$item_r = $list_remote [$i];
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			//				$row['alias'] = $fsstring -> stringStandart($item_r -> cat_name);
			

			$row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
			$row ['list_parents'] = ',' . $row ['id'] . ',';
			$row ['level'] = 0;
			
			$row ['show_in_homepage'] = 1;
			// $row ['show_in_footer'] = 1;
			$row ['updated_time'] = $time;
			$row ['alias_old'] = $row['alias'];
			
			if($item_r-> IsShow && !$item_r-> IsDeleted){
				$row ['published'] = 1;
			}else{
				$row ['published'] = 0;
			}
			$this->_add ( $row, 'fs_news_categories', 1 );
		}
	}

	function syn_news_toppic_phapluatnet() {
		
		$arr_syn = array (
			'ID' => 'id',
			'Name' => 'name',
			'NameAscii' => 'alias'
		); 

		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_sqlsrv.php';

		$remote_db = new Remote_db ();
		$select = "select * 
					from 
					Website_Modules
					WHERE IsIndex = 1
					";
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		// echo "<pre>";
		// print_r($list_remote);
		// die;
		
		$time = date ( 'Y-m-d H:i:s' );
		$categories = $this->get_records ( '', 'fs_news_topics', '*', '', '', 'id' );
		$row = array ();
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$item_r = $list_remote [$i];
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
	
			$row ['published'] = 1;

			$this->_add ( $row, 'fs_news_topics', 1 );
		}
	}







	function add_news_phapluatnet() {
		$arr_syn = array (
						'ID' => 'id',
		 				'ModuleID' => 'category_id',
		 				'Name' => 'title',
						'NameAscci' => 'alias',
						'Video' => 'link_video',
						'IsPicture' => 'is_slideshow',
						'CreatedDate'=>'created_time',
				  		'PublicDate'=>'published_time',
				  		'IsDeleted'=>'is_garbage',
				  		'SeoDescription'=>'seo_description',
				  		'SeoKeyword'=>'seo_keyword',
				  		'SEOTitle'=>'seo_title',
				  		'TotalViews'=>'hits',
				  		'CreatorName'=>'editor_name',
				  		'Tags'=>'tags_old',
				  		'IsLive'=>'is_live',
				  		'Url'=>'image',
				  		
						);
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		// remote db


		include_once 'remote_sqlsrv.php';
		$remote_db = new Remote_db ();
		$select = 'SELECT a.*,b.Url FROM ( 
  								SELECT *, ROW_NUMBER() OVER (ORDER BY ID) as row  
  								FROM [phapluat_db].[dbo].[Website_Content]) a 
  								LEFT JOIN [phapluat_db].[dbo].[Gallery_Picture] AS b ON a.PictureID = b.ID
  								WHERE a.ID >= 25000 and a.ID <= 27000
  								
								Order by a.ID ASC
  								';
											
		$sql = $remote_db->query( $select );
		$list_remote = $remote_db->getObjectList ();

		global $db;

		$categories = $this->get_records ( '', 'fs_news_categories', '*', '', '', 'id' );
		// echo "<pre>";
		// print_r($categories);
		// die;
		
		$time = date ( 'Y-m-d H:i:s' );
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$row = array ();
			$item_r = $list_remote [$i];
			
			// check exist
			$exist = $this->check_exist ( $item_r->ID, 0, 'id', 'fs_news' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->ID . "<br/>";
				continue;
			}
			$cat = isset ( $categories [$item_r->ModuleID] ) ? $categories [$item_r->ModuleID] : null;
			// echo $item_r->term_taxonomy_id . "++";
			
			if (! $cat) {
				echo "==" . $item_r->ID . "== NOT convert by cat_id = " . $item_r->ModuleID . "not found </br>";
				$row['category_id'] = $item_r->ModuleID;
				// continue;
			}
			// $cat =  $categories [7];
			foreach ( $arr_syn as $field_old => $field_new ) {
				if($field_new == 'created_time' || $field_new == 'updated_time' || $field_new == 'published_time' ){
					$date = $item_r -> $field_old;
					$row[$field_new] =  $date->format('Y-m-d H:i:s'); 
				
					
				}else{
					$row[$field_new] = $item_r -> $field_old;
				}
			}

			if($item_r -> IsShow  == 1){
				$row['status'] = 6;			
			}else{
				$row['status'] = 1;	
			}

			$row['summary'] = trim($item_r ->ShortDescription);	
			$row['header'] = $row['summary'];	
		
	
			if($item_r -> IsVideo  == 1){
				$row['type'] = 'video';
			}elseif($item_r -> IsPicture == 1){
				$row['type'] = 'image';
			}else{
				$row['type'] = 'default';
			}
			$news_related ='';
			if($item_r -> RelatedContentIDs !='' AND $item_r -> RelatedContentIDs != NULL){
				$news_related = str_replace(".",",",$item_r -> RelatedContentIDs);
				$news_related = ','.$news_related.',';
				$row['news_related'] = $news_related;
			}

			// Tin gợi ý
			$news_suggest ='';
			if($item_r -> SuggestContentIDs !='' AND $item_r -> SuggestContentIDs != NULL){
				$news_suggest = str_replace(".",",",$item_r -> SuggestContentIDs);
				$news_suggest = ','.$news_suggest.',';
				$row['news_suggest'] = $news_suggest;
			}
				


			// check alias exist
			$exist = $this->check_exist ( $item_r->ID, 0, 'id', 'fs_news' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->ID . "<br/>";
				continue;
			}

			$row ['category_id'] = $cat->id;
			$row ['category_alias'] = $cat->alias;
			$row ['category_name'] = $cat->name;
			$row ['category_id_wrapper'] = $cat->list_parents;
			$row ['category_alias_wrapper'] = $cat->alias_wrapper;
			// $row ['published'] = $item_r -> post_status == 'publish'?1:0 ;
			// $row ['alias_old'] = $item_r -> post_name ;

			$this->_add ( $row, 'fs_news', 1 );

			$row2 = array ();
			$row2 ['id'] = $item_r->ID;
			$exist = $this->check_exist ( $row2 ['id'], 0, 'id', 'fs_news_content' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->ID . "<br/>";
				continue;
			}
			$row2 ['content'] =   $db -> escape_string($item_r->Content); 
			$this->_add ( $row2, 'fs_news_content', 0 );


		}
	}


	/*
		 * Lấy dữ liệu từ wp
		 */
	function add_products_wp() {
		
		$arr_syn = array ('ID' => 'id', 'post_title' => 'name', 'post_name' => 'alias', //				  'post_author'=>'reporter_id',
		'post_date' => 'created_time', 'post_date' => 'created_time', 'post_content' => 'description', 'post_excerpt' => 'summary' )//				  'post_date_gmt'=>'old_category_id',
		//				  'post_content' =>'old_creator_id',
		//				  'ANHDAIDIEN' =>'image',
		;
		
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		$select = 'select a.* , c.term_taxonomy_id
				from wp_posts AS a
				
				INNER JOIN wp_term_relationships AS c ON (a.ID = c.object_id)
				where post_status = "publish"
				AND post_type = "post"
				ORDER BY a.ID ASC
				';
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		$categories = $this->get_records ( '', 'fs_products_categories', '*', '', '', 'id' );
		
		$time = date ( 'Y-m-d H:i:s' );
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$row = array ();
			$item_r = $list_remote [$i];
			
			// check exist
			$exist = $this->check_exist ( $item_r->ID, 0, 'id', 'fs_products' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->ID . "<br/>";
				continue;
			}
			//				echo $exist."===";
			//				die;
			

			// check convert:
			//				$cat = $this -> get_record('old_id = '.$item_r -> ChuyenMuc ,'fs_products_categories' );
			$cat = isset ( $categories [$item_r->term_taxonomy_id] ) ? $categories [$item_r->term_taxonomy_id] : null;
			echo $item_r->term_taxonomy_id . "++";
			
			if (! $cat) {
				echo "==" . $item_r->ID . "== NOT convert by cat_id = " . $item_r->term_taxonomy_id . "not found </br>";
				continue;
			}
			
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			
			//				$alias = $fsstring -> stringStandart($item_r -> TieuDe);
			

			// check alias exist
			$exist = $this->check_exist ( $item_r->ID, 0, 'id', 'fs_products' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->ID . "<br/>";
				continue;
			}
			//				$row['alias'] = $alias;
			$row ['category_id'] = $cat->id;
			$row ['category_alias'] = $cat->alias;
			$row ['category_name'] = $cat->name;
			$row ['category_id_wrapper'] = $cat->list_parents;
			$row ['category_alias_wrapper'] = $cat->alias_wrapper;
			//				$row['categories_id_wrapper'] = $cat -> alias_wrapper; // chứa cả cat phụ
			//				$row['published'] = 1;
			$row ['published'] = $item_r -> post_status == 'publish'?1:0 ;
			$row ['alias_old'] = $item_r -> post_name ;
			

			//				$row['type'] = 'default';
			

			// WP này ko có summary
			//				$row['content'] = $this -> clean_description($item_r -> NoiDung);
			//				$row['summary'] = $this -> clean_summary($item_r -> TrichDan);
			

			//				$this -> add_main_images($item_r -> ANHDAIDIEN);
			//				$this -> get_images($item_r -> ID,$item_r -> ANHDAIDIEN);
			$this->_add ( $row, 'fs_products', 1 );
		}
	}

	/*
		 * Lấy dữ liệu từ wp
		 */
	function add_news_wp() {
		
		$arr_syn = array (
						'ID' => 'id',
		 				'post_title' => 'title',
		 				'post_name' => 'alias',
						'post_date' => 'created_time',
						'post_date ' => 'created_time',
						'post_content' => 'content',
						'post_excerpt' => 'summary'
						);
						
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		$select = 'select a.* , c.term_taxonomy_id
				from wp_posts AS a
				
				INNER JOIN wp_term_relationships AS c ON (a.ID = c.object_id)
				where post_status = "publish"
				AND post_type = "blog"
				ORDER BY a.ID ASC
				';
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		$categories = $this->get_records ( '', 'fs_news_categories', '*', '', '', 'id' );
		
		$time = date ( 'Y-m-d H:i:s' );
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$row = array ();
			$item_r = $list_remote [$i];
			
			// check exist
			$exist = $this->check_exist ( $item_r->ID, 0, 'id', 'fs_news' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->ID . "<br/>";
				continue;
			}
			$cat = isset ( $categories [$item_r->term_taxonomy_id] ) ? $categories [$item_r->term_taxonomy_id] : null;
			echo $item_r->term_taxonomy_id . "++";
			
			if (! $cat) {
				echo "==" . $item_r->ID . "== NOT convert by cat_id = " . $item_r->term_taxonomy_id . "not found </br>";
				continue;
			}
			
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			
			// check alias exist
			$exist = $this->check_exist ( $item_r->ID, 0, 'id', 'fs_news' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->ID . "<br/>";
				continue;
			}
			$row ['category_id'] = $cat->id;
			$row ['category_alias'] = $cat->alias;
			$row ['category_name'] = $cat->name;
			$row ['category_id_wrapper'] = $cat->list_parents;
			$row ['category_alias_wrapper'] = $cat->alias_wrapper;
			$row ['published'] = $item_r -> post_status == 'publish'?1:0 ;
			$row ['alias_old'] = $item_r -> post_name ;
			$this->_add ( $row, 'fs_news', 1 );
		}
	}


	function update_price_wp() {
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		
		$select = 'SELECT
						p1.*,
						wm1.meta_value as price_old,
						wm2.meta_value as price
					FROM
						wp_posts p1
					LEFT JOIN
						wp_postmeta wm1
						ON (
							wm1.post_id = p1.id
							AND wm1.meta_value IS NOT NULL
							AND wm1.meta_key = "_eb_product_oldprice"
						)
					LEFT JOIN
						wp_postmeta wm2
						ON (
							wm2.post_id = p1.id
							AND wm2.meta_key = "_eb_product_price"
							AND wm2.meta_value IS NOT NULL
						)
					WHERE
						p1.post_status="publish"
						AND p1.post_type="post"
					ORDER BY
						p1.post_date DESC';
		
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		foreach ( $list_remote as $item ) {
			$row = array ();
			$row ['price'] = $item->price;
			$row ['price_old'] = $item->price_old;
			$this->_update ( $row, 'fs_products', ' id = ' . $item->ID );
		}
	}

	function update_size_wp() {
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		
		$select = 'SELECT
						p1.*,
						wm1.meta_value as size
					FROM
						wp_posts p1
					LEFT JOIN
						wp_postmeta wm1
						ON (
							wm1.post_id = p1.id
							AND wm1.meta_value IS NOT NULL
							AND wm1.meta_key = "_eb_product_size"
						)
					LEFT JOIN
						wp_postmeta wm2
						ON (
							wm1.meta_value = wm2.post_id
							AND wm2.meta_key = "_wp_attached_file"
							AND wm2.meta_value IS NOT NULL
						)
					WHERE
						p1.post_status="publish"
						AND p1.post_type="post"
					ORDER BY
						p1.post_date DESC';
		
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		foreach ( $list_remote as $item ) {
			$row = array ();
			// echo $item -> size;
			// echo "<br/>";
			$size_value = null;
			if($item -> size){
				
				// preg_match('#name"\:\"(.*?)\"\,\"sku#is',$body,$value);
				$size = $item -> size;
				// preg_match('#name(.*?)#is',$size,$value);
				preg_match('#name"\:\"(.*?)\"\,\"sku#is',$size,$value);
				if(isset($value[1])){
					$size_1 = $value[1];
					if($size_1){
						if(strpos($size_1, 'val') !== false){
							preg_match('#name"\:\"(.*?)\"\,\"val#is',$size,$value1);
							
							if(isset($value1[1])){
								$size_2 = $value1[1];
								if($size_2){
									
									$size_value  = $size_2;
								}
						
							}
						}else{
							$size_value  = $size_1;
						}
						$row = array();
					 	$row ['size'] = $size_value;
					 	$this->_update ( $row, 'fs_products', ' id = ' . $item->ID );
					 		// echo $size_value;
						echo "<br/>";
					}
			
				}
			
			}
			//
		}
	}

	function add_images_wp() {
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		
		$select = 'SELECT
						p1.*,
						wm2.meta_value
					FROM
						wp_posts p1
					LEFT JOIN
						wp_postmeta wm1
						ON (
							wm1.post_id = p1.id
							AND wm1.meta_value IS NOT NULL
							AND wm1.meta_key = "_thumbnail_id"
						)
					LEFT JOIN
						wp_postmeta wm2
						ON (
							wm1.meta_value = wm2.post_id
							AND wm2.meta_key = "_wp_attached_file"
							AND wm2.meta_value IS NOT NULL
						)
					WHERE
						p1.post_status="publish"
						AND p1.post_type="post"
					ORDER BY
						p1.post_date DESC';
		
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		foreach ( $list_remote as $item ) {
			$row = array ();
			$row ['image'] = 'wp-content/uploads/' . $item->meta_value;
			$this->_update ( $row, 'fs_products', ' id = ' . $item->ID );
		}
	}

	function add_images_news_wp() {
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		
		$select = 'SELECT
						p1.*,
						wm2.meta_value
					FROM
						wp_posts p1
					LEFT JOIN
						wp_postmeta wm1
						ON (
							wm1.post_id = p1.id
							AND wm1.meta_value IS NOT NULL
							AND wm1.meta_key = "_thumbnail_id"
						)
					LEFT JOIN
						wp_postmeta wm2
						ON (
							wm1.meta_value = wm2.post_id
							AND wm2.meta_key = "_wp_attached_file"
							AND wm2.meta_value IS NOT NULL
						)
					WHERE
						p1.post_status="publish"
						AND p1.post_type="blog"
					ORDER BY
						p1.post_date DESC';
		
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		foreach ( $list_remote as $item ) {
			$row = array ();
			$row ['image_old'] = 'wp-content/uploads/' . $item->meta_value;
			$this->_update ( $row, 'fs_news', ' id = ' . $item->ID );
		}
	}
	
	/*
		 * Resize lai anh tu bang fs_products
		 * Ko update lai db
		 */
	function products_resize_images_wp() {
		
		global $db;
		$select = ' SELECT * FROM fs_products ';
		//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
		$sql = $db->query ( $select );
		
		$list = $db->getObjectList ();
		$day = '04';
		$month = '04';
		
		$folder_image_begin = 'E:\project\eurohome\bk_wp\\';
		$folder_image_destination = 'E:\project\eurohome\code\images\products\2018\\' . $month . '\\' . $day . '\original\\';
		;
		$arr_img_paths = array (array ('resized', 270,180, 'cut_image' ), array ('large', 570,380, 'cut_image' ), array ('small', 86,60, 'cut_image' ) );
		$fsFile = FSFactory::getClass ( 'FsFiles', '' );
		for($i = 0; $i < count ( $list ); $i ++) {
			$item = $list [$i];
			$image = $item->image_old;
			//				$image = PATH_BASE.str_replace('/',DS,$item -> image_old);
			$image_new = basename ( $image );
			$image_new = $fsFile->genarate_filename_standard ( $image_new );
			
			$fsFile->create_folder ( $folder_image_destination );
			if (! $fsFile->copy_file ( $folder_image_begin . str_replace ( '/', DS, $image ), $folder_image_destination . $image_new ))
				continue;
			foreach ( $arr_img_paths as $path ) {
				$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination );
				$fsFile->create_folder ( $path_resize );
				$method_resize = $path [3] ? $path [3] : 'cut_image';
				//					$fsFile -> remove_file_by_path($path_resize);
				if (! $fsFile->$method_resize ( $folder_image_destination . $image_new, $path_resize . $image_new, $path [1], $path [2] )) {
					echo $item->id . '_';
				}
			
		//						return false;
			}
			
			$row = array ();
			$row ['image'] = 'images/products/2018/04/04/original/' . $image_new;
			$this->_update ( $row, 'fs_products', ' id = ' . $item->id );
		}
	}

	/*
		 * Resize lai anh tu bang fs_products
		 * Ko update lai db
		 */
	function news_resize_images_wp() {
		
		global $db;
		$select = ' SELECT * FROM fs_news ';
		//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
		$sql = $db->query ( $select );
		
		$list = $db->getObjectList ();
		$day = '04';
		$month = '04';
		
		$folder_image_begin = 'E:\project\eurohome\bk_wp\\';
		$folder_image_destination = 'E:\project\eurohome\code\images\news\2018\\' . $month . '\\' . $day . '\original\\';
		;
		$arr_img_paths = array (array ('resized', 270,180, 'cut_image' ), array ('large', 454, 260, 'cut_image' ), array ('small', 114, 68, 'cut_image' ) );
		$fsFile = FSFactory::getClass ( 'FsFiles', '' );
		for($i = 0; $i < count ( $list ); $i ++) {
			$item = $list [$i];
			$image = $item->image_old;
			//				$image = PATH_BASE.str_replace('/',DS,$item -> image_old);
			$image_new = basename ( $image );
			$image_new = $fsFile->genarate_filename_standard ( $image_new );
			
			$fsFile->create_folder ( $folder_image_destination );
			if (! $fsFile->copy_file ( $folder_image_begin . str_replace ( '/', DS, $image ), $folder_image_destination . $image_new ))
				continue;
			foreach ( $arr_img_paths as $path ) {
				$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination );
				$fsFile->create_folder ( $path_resize );
				$method_resize = $path [3] ? $path [3] : 'cut_image';
				//					$fsFile -> remove_file_by_path($path_resize);
				if (! $fsFile->$method_resize ( $folder_image_destination . $image_new, $path_resize . $image_new, $path [1], $path [2] )) {
					echo $item->id . '_';
				}
			
		//						return false;
			}
			
			$row = array ();
			$row ['image'] = 'images/news/2018/04/04/original/' . $image_new;
			$this->_update ( $row, 'fs_news', ' id = ' . $item->id );
		}
	}
	
	function products_update_extends() {
		
		global $db;
		$select = ' SELECT a.*,b.tablename AS table_name FROM fs_products  AS a
				LEFT JOIN fs_products_categories AS b ON a.category_id = b.id ';
		//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
		$sql = $db->query ( $select );
		
		$list = $db->getObjectList ();
		foreach($list as $item){
			$tablename = $item -> table_name;
			$row2 = array();
			$row2 ['tablename'] = $item -> table_name;
			$this -> _update($row2, 'fs_products', 'id = '.$item -> id);
			
			$row = array();
			$row ['record_id'] = $item -> id;
			$fields_all_of_ext_table = $this->get_field_table ( $tablename, 1 );
			foreach ( $item as $field_name => $value ) {
				if ($field_name == 'id' || $field_name == 'tablename')
					continue;
				if (! isset ( $fields_all_of_ext_table [$field_name] ))
					continue;
				if ($field_name == 'record_id')
					continue;
				$row [$field_name] = $value;
			}
			$this->_add ( $row, $tablename , 1 );
		}
	}
			/*
		 * get field of table
		 */
		function get_field_table($table_name = '',$key_field_name = 0){
			if(!$table_name)	
				$table_name = $this -> table_name;
			global $db;
			$query = "SHOW COLUMNS FROM ".$table_name." ";
			$db->query($query);
			if($key_field_name)
				$fields_in_table = $db->getObjectListByKey('Field');
			else 
				$fields_in_table = $db->getObjectList();
			return $fields_in_table;
		}

	/*
		 * Lấy dữ liệu từ wp
		 */
	function add_products_orfarm() {
		
		$arr_syn = array ('product_id' => 'id', 'product_name' => 'name','product_description'=>'description', 'product_code' => 'alias','product_keywords'=>'seo_keyword','product_meta_description'=>'seo_description')//				  'post_date_gmt'=>'old_category_id',
		//				  'post_content' =>'old_creator_id',
		//				  'ANHDAIDIEN' =>'image',
		;
		
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		$select = 'select * FROM win_hikashop_product
				WHERE product_name <> ""
				ORDER BY product_id ASC 
				LIMIT 1000
				';
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		$categories = $this->get_records ( '', 'fs_products_categories', '*', '', '', 'id' );
		
		$time = date ( 'Y-m-d H:i:s' );
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$row = array ();
			$item_r = $list_remote [$i];
			
			// check exist
			$exist = $this->check_exist ( $item_r->product_id, 0, 'id', 'fs_products' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->product_id . "<br/>";
				continue;
			}
			//				echo $exist."===";
			//				die;
			

			// check convert:
			//				$cat = $this -> get_record('old_id = '.$item_r -> ChuyenMuc ,'fs_products_categories' );
			$cat =  $categories [7]  ;
			
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			
			//				$alias = $fsstring -> stringStandart($item_r -> TieuDe);
			

			
			//				$row['alias'] = $alias;
			$row ['category_id'] = $cat->id;
			$row ['category_alias'] = $cat->alias;
			$row ['category_name'] = $cat->name;
			$row ['category_id_wrapper'] = $cat->list_parents;
			$row ['category_alias_wrapper'] = $cat->alias_wrapper;
			//				$row['categories_id_wrapper'] = $cat -> alias_wrapper; // chứa cả cat phụ
			//				$row['published'] = 1;
			$row ['published'] = 1;
			//				$row['type'] = 'default';
			

			// WP này ko có summary
			//				$row['content'] = $this -> clean_description($item_r -> NoiDung);
			//				$row['summary'] = $this -> clean_summary($item_r -> TrichDan);
			

			//				$this -> add_main_images($item_r -> ANHDAIDIEN);
			//				$this -> get_images($item_r -> ID,$item_r -> ANHDAIDIEN);
			$this->_add ( $row, 'fs_products', 1 );
		}
	}

	/*
		 * Lấy dữ liệu từ wp
		 */
	function add_news_category_orfarm() {
		
		$arr_syn = array ('id' => 'id', 'title' => 'name','description'=>'description', 'alias' => 'alias','metakey'=>'seo_keyword','metadesc'=>'seo_description')//				  'post_date_gmt'=>'old_category_id',
		//				  'post_content' =>'old_creator_id',
		//				  'ANHDAIDIEN' =>'image',
		;
		
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		$select = 'select * FROM win_categories
				WHERE extension = "com_content"
				ORDER BY id ASC 
				LIMIT 1000
				';
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		$categories = $this->get_records ( '', 'fs_news_categories', '*', '', '', 'id' );
		
		$time = date ( 'Y-m-d H:i:s' );
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$row = array ();
			$item_r = $list_remote [$i];
			
			// check exist
			$exist = $this->check_exist ( $item_r->id, 0, 'id', 'fs_news_categories' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->id . "<br/>";
				continue;
			}
			//				echo $exist."===";
			//				die;
			

			// check convert:
			//				$cat = $this -> get_record('old_id = '.$item_r -> ChuyenMuc ,'fs_products_categories' );
			$cat =  $categories [7]  ;
			
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			
		
			$row ['published'] = 1;
			//				$row['type'] = 'default';
			

			// WP này ko có summary
			//				$row['content'] = $this -> clean_description($item_r -> NoiDung);
			//				$row['summary'] = $this -> clean_summary($item_r -> TrichDan);
			

			//				$this -> add_main_images($item_r -> ANHDAIDIEN);
			//				$this -> get_images($item_r -> ID,$item_r -> ANHDAIDIEN);
			$this->_add ( $row, 'fs_news_categories', 1 );
		}
	}

	/*
		 * Lấy dữ liệu cho bảng tin tức trong dự án phunutoday
		 */
	function add_news_orfarm() {
		
			$arr_syn = array ('id' => 'id', 'title' => 'title','introtext'=>'summary','fulltext'=>'content', 'alias' => 'alias','metakey'=>'seo_keyword','metadesc'=>'seo_description','catid'=>'category_id')//				  'post_date_gmt'=>'old_category_id',
		//				  'post_content' =>'old_creator_id',
		//				  'ANHDAIDIEN' =>'image',
		;
		
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		$select = 'select * FROM win_content
				WHERE state > 0
				ORDER BY id ASC 
				LIMIT 1000
				';
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();
		
		$categories = $this->get_records ( '', 'fs_news_categories', '*', '', '', 'id' );
		
		$time = date ( 'Y-m-d H:i:s' );
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$row = array ();
			$item_r = $list_remote [$i];
			
			// check exist
			$exist = $this->check_exist ( $item_r->id, 0, 'id', 'fs_news' );
			if ($exist) {
				echo "<br/>Da ton tai " . $item_r->id . "<br/>";
				continue;
			}
			//				echo $exist."===";
			//				die;
			

			// check convert:
			//				$cat = $this -> get_record('old_id = '.$item_r -> ChuyenMuc ,'fs_news_categories' );
			$cat = isset ( $categories [$item_r->catid] ) ? $categories [$item_r->catid] : null;
			echo $item_r->id . "++";
			
			if (! $cat) {
				echo "==" . $item_r->id . "== NOT convert by cat_id = " . $item_r->catid . "not found </br>";
				continue;
			}
			
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			
			//				$alias = $fsstring -> stringStandart($item_r -> TieuDe);
			

			//				$row['alias'] = $alias;
			$row ['category_id'] = $cat->id;
			$row ['category_alias'] = $cat->alias;
			$row ['category_name'] = $cat->name;
			$row ['category_id_wrapper'] = $cat->list_parents;
			$row ['category_alias_wrapper'] = $cat->alias_wrapper;
//			$row ['categories_id_wrapper'] = $cat->alias_wrapper; // chứa cả cat phụ
			//				$row['published'] = 1;
			$row ['published'] = 1;
//			$row ['type'] = 'default';
			
			// WP này ko có summary
			//				$row['content'] = $this -> clean_description($item_r -> NoiDung);
			//				$row['summary'] = $this -> clean_summary($item_r -> TrichDan);
			

			//				$this -> add_main_images($item_r -> ANHDAIDIEN);
			//				$this -> get_images($item_r -> ID,$item_r -> ANHDAIDIEN);
			$this->_add ( $row, 'fs_news', 1 );
			
//			$row2 = array ();
//			$row2 ['id'] = $item_r->ID;
//			$exist = $this->check_exist ( $row2 ['id'], 0, 'id', 'fs_news_content' );
//			if ($exist) {
//				echo "<br/>Da ton tai " . $item_r->ID . "<br/>";
//				continue;
//			}
//			$row2 ['content'] = mysql_real_escape_string ( $item_r->post_content );
//			$this->_add ( $row2, 'fs_news_content', 0 );
		}
	}

	function add_news_images_orfarm() {


		$arr_img_paths = array(array('resized',370,270,'cut_image'),array('large',600,400,'cut_image'),array('small',80,80,'cut_image'));

		$folder_image_begin = 'F:\backup\orfarm_img\\';
		
		$folder_image_destination = 'F:\project\orfarm\code\images\news\2017\06\22\original\\';
		$fsFile = FSFactory::getClass ( 'FsFiles', '' );


		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		
		$select = 'select * FROM win_content
				WHERE state > 0
				ORDER BY id ASC 
				LIMIT 1000
				';
		
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();


		
		foreach ( $list_remote as $item ) {
			$row = array ();

			$pictures = json_decode($item  -> images,
                         true);
			if(!$pictures['image_intro'])
				continue;
			$image_old = $pictures['image_intro']; 


			
			// $image = basename ( $image_old );
			$image =  $fsFile->genarate_filename_standard($image_old);
			$link =  'images/news/2017/06/22/original/'.$image ;


			$path_old = $folder_image_begin . str_replace('/', DS, $image_old) ;
			
					
			//				$fsFile -> create_folder($folder_image_destination);
			if (! file_exists ( $path_old )) {
				echo "ko co " . $path_old. "<br/>";
				continue;
			}
			//$fsFile->create_folder ( dirname ( $folder_image_destination . $link ) );

			
			if (! $fsFile->copy_file ($path_old, $folder_image_destination . $image ))
				continue;
			
			foreach ( $arr_img_paths as $path ) {
				$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination . $image );
				$fsFile->create_folder ( dirname ( $path_resize ) );
				$method_resize = $path [3] ? $path [3] : 'resized_not_crop';
				if (! $fsFile->$method_resize ( $folder_image_destination . $image, $path_resize, $path [1], $path [2] )) {
					continue;
				}
			}
			$row2 = array ();
			$row2 ['image'] = $link;
			
			$this->_update ( $row2, 'fs_news', ' id = ' . $item->id );

		}
			
	}

	
	/********* EURO HOME ************/
	function syn_product_cats_eurohome_wp() {
		
		$arr_syn = array ('term_id' => 'id', 'name' => 'name', 'slug' => 'alias', 'parent' => 'parent_id' );
		$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
		
		// remote db
		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		$select = "select * 
					from 
					wp_terms AS a
					LEFT JOIN wp_term_taxonomy AS b ON a.term_id = b.term_id 
					WHERE 
					b.taxonomy = 'category' ";
		
		$sql = $remote_db->query ( $select );
		
		$list_remote = $remote_db->getObjectList ();
		$time = date ( 'Y-m-d H:i:s' );
		
		$row = array ();
		for($i = 0; $i < count ( $list_remote ); $i ++) {
			$item_r = $list_remote [$i];
			foreach ( $arr_syn as $field_old => $field_new ) {
				$row [$field_new] = $item_r->$field_old;
			}
			//				$row['alias'] = $fsstring -> stringStandart($item_r -> cat_name);
			

			$row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
			$row ['list_parents'] = ',' . $row ['id'] . ',';
			$row ['level'] = 0;
			$row ['published'] = 1;
			$row ['show_in_homepage'] = 1;
			$row ['show_in_footer'] = 1;
			$row ['updated_time'] = $time;
			$row ['updated_time'] = $time;
			$this->_add ( $row, 'fs_products_categories', 1 );
		}
	}

	function add_images_other_eurohome_wp(){


		include_once 'remote_db.php';
		$remote_db = new Remote_db ();
		
		$select = 'SELECT
						p1.*,
						wm1.meta_value as gallery
					FROM
						wp_posts p1
					LEFT JOIN
						wp_postmeta wm1
						ON (
							wm1.post_id = p1.id
							AND wm1.meta_value IS NOT NULL
							AND wm1.meta_key = "_eb_product_gallery"
						)
					
					WHERE
						p1.post_status="publish"
						AND p1.post_type="post"
					ORDER BY
						p1.post_date DESC';
		
		$sql = $remote_db->query ( $select );
		$list_remote = $remote_db->getObjectList ();

		$day = '13';
		$month = '04';
		
		$folder_image_begin = 'E:\project\eurohome\bk_wp\\';
		$folder_image_destination = 'E:\project\eurohome\code\images\products\2018\\' . $month . '\\' . $day . '\original\\';
		;
		$arr_img_paths = array (array ('large', 570,380, 'cut_image' ), array ('small', 86,60, 'cut_image' ) );
		$fsFile = FSFactory::getClass ( 'FsFiles', '' );
		
		foreach ( $list_remote as $item ) {
			$row = array ();
			// echo $item -> size;
			// echo "<br/>";
			// $size_value = null;
			if($item -> gallery){
				
				// preg_match('#name"\:\"(.*?)\"\,\"sku#is',$body,$value);
				$gallery = $item -> gallery;

				 preg_match_all('#<img (.*?)>#is',$gallery,$images);				 
				$arr_images = array();
				if(!count($images[0]))
					continue;
				foreach($images[0] as $img){
					preg_match('#src([\s]*)=([\s]*)[\'|\"](.*?)[\'|\"]#is',$img,$link_img);
					$image = $link_img[3];

					if(!$image)
						continue;
					$image = str_replace('https://noithateurohome.com/', '', $image);	
					$image_new = basename ( $image );
					$image_new = $fsFile->genarate_filename_standard ( $image_new );
			
					$fsFile->create_folder ( $folder_image_destination );
					if (! $fsFile->copy_file ( $folder_image_begin . str_replace ( '/', DS, $image ), $folder_image_destination . $image_new )){
						continue;
					
					}

					foreach ( $arr_img_paths as $path ) {
						$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination );
						$fsFile->create_folder ( $path_resize );
						$method_resize = $path [3] ? $path [3] : 'cut_image';
						//					$fsFile -> remove_file_by_path($path_resize);
						if (! $fsFile->$method_resize ( $folder_image_destination . $image_new, $path_resize . $image_new, $path [1], $path [2] )) {
							
						}					
				
					}

					$row = array ();
					$row ['record_id']  = $item -> ID;
					$row ['image'] = 'images/products/2018/04/13/original/' . $image_new;
					$this->_add ( $row, 'fs_products_images' );
				}	

			}
			//
		}

	}


	function synd_cat_products_suachualt() {
			$arr_syn = array (
				'CategoryID' => 'id',
				'Status' => 'published',
				'Order' => 'ordering',
				'TreeCode' => 'treeCode_old',
				'Level' => 'level',
				'ImageUrl' => 'image_old',
				'CategoryKey' => 'alias_old',
				'Name' => 'name',
				'Keyword'=>'seo_keyword',
				'Description'=>'seo_description',
				'TitleName'=>'seo_title',
				'Preview'=>'summary',
				'Detail'=>'description'
				
			);

			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );

			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[Category] AS a INNER JOIN [suachualaptop].[dbo].[CategoryDetails] AS b ON a.CategoryID = b.CategoryID WHERE a.TypeCode = 'Product' AND b.CategoryLangID !=748 ORDER BY a.Level ASC";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			printr($list_remote);


			$time = date ( 'Y-m-d H:i:s' );
			$row = array ();
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$item_r = $list_remote [$i];
				foreach ( $arr_syn as $field_old => $field_new ){
					$row [$field_new] = $item_r->$field_old;
				}

				// printr($item_r);
				// $parent_tree_code = $item_r -> TreeCode[strlen($item_r -> TreeCode)-2];
				$parent_tree_code = substr($item_r -> TreeCode, 0, -5);
				if($parent_tree_code == ''){
					// $row ['parent_id'] = 0;
				}else{
					global $db;
					$get_pr = ' SELECT * FROM fs_products_categories WHERE treeCode_old = "' .$parent_tree_code.'"' ;
					$sql = $db->query ( $get_pr );
					$it = $db->getObject();
					if(!empty($it)){
						$row ['parent_id'] = $it->id;
					}
					
				}
				
				// die;

				
				$row['alias'] = $fsstring -> stringStandart($item_r -> Name);
				$row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
				$row ['list_parents'] = isset($row ['parent_id']) ? ',' .$row ['parent_id'].','. $row ['id'] . ',': ','.$row ['id'] . ',';
				$row ['level'] = 0;
				$row ['updated_time'] = $time;

				$check_exist = $this->get_record('id =' .$item_r ->CategoryID,'fs_products_categories');
				
				if(empty($check_exist)){
					$this->_add ( $row, 'fs_products_categories', 1 );
				}
				
			}
		}

		function update_list_parents_category(){

			$tablename = 'fs_albums_categories';
			$list_cats = $this->get_records('',$tablename,'*');
			foreach ($list_cats as $key => $record) {
				// $record =  $this->get_record_by_id($value->id,$tablename);
				$alias =  $record -> alias;
				if($record -> parent_id){
					$parent =  $this->get_record_by_id($record -> parent_id,$tablename);
					$list_parents = ','.$record ->id.$parent -> list_parents ;
					$alias_wrapper = ','.$alias.$parent -> alias_wrapper ;
				} else {
					$list_parents = ','.$record ->id.',';
					$alias_wrapper = ','.$alias.',' ;
				}
				
				$row2['alias_wrapper'] =  $alias_wrapper;
				$row2['list_parents'] = $list_parents;


				$this -> _update($row2,$tablename,' id = '.$record ->id.' ');
			}
		}


		function synd_manu_suachualt() {
			$arr_syn = array (
				'Id' => 'id',
				'Status' => 'published',
				'Order' => 'ordering',
				'ImageUrl' => 'image_old',
				'Name' => 'name'
			);

			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );

			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[LandProject] AS a INNER JOIN [suachualaptop].[dbo].[LandProjectDetail] AS b ON a.id = b.LandProjectId";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);


			$time = date ( 'Y-m-d H:i:s' );
			$row = array ();
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$item_r = $list_remote [$i];
				foreach ( $arr_syn as $field_old => $field_new ){
					$row [$field_new] = $item_r->$field_old;
				}

				
				 

				$row['alias'] = $fsstring -> stringStandart($item_r -> Name);
				
				$row ['updated_time'] = $time;

				$check_exist = $this->get_record('id =' .$item_r ->Id,'fs_manufactories');
				
				if(empty($check_exist)){
					$this->_add ( $row, 'fs_manufactories', 1 );
				}
				
			}
		}


		function add_products_suachualt() {
		
			$arr_syn = array (
				'ProductID' => 'id',
				'CategoryID' => 'category_id',
				'LandProjectId' => 'manufactory',
				'ImageUrl' => 'image_old',
				'ProductCode' => 'code',
				'Price_old' => 'price_old',
				'Price' => 'price',
				'Promote' => 'quantity',
				'ViewsCount' => 'hits',
				'Status' => 'published',
				'Type' => 'is_hot',
				'Order' => 'ordering',
				'New' => 'is_new',
				'CreatedBy' => 'creator_name',
				'LastEditedBy' => 'action_username',

				'Name' => 'name',
				'TitleName' => 'seo_title',
				'Keyword' => 'seo_keyword',
				'Description' => 'seo_description',

				'Warranty' => 'warranty',
				'BasicFeauture' => 'summary',
				'TechnicalParametter' => 'specifications',
				'Detail' => 'description',
				'BriefDescription' => 'video',

				'LandTypeId' => 'LandTypeId', //gia
				'LandNeedId' => 'LandNeedId', //nhu cau
				'DirectionId' => 'DirectionId', //manhinh
				'CurrencyId' => 'CurrencyId', //CPU
				

			);


			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();

			// $select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[Product] AS a INNER JOIN [suachualaptop].[dbo].[ProductDetails] AS b ON a.ProductID = b.ProductID AND a.ProductID >3486 ORDER BY a.ProductID";

			$select = "SELECT a.*, b.* FROM [suachua24hnew].[dbo].[Product] AS a INNER JOIN [suachua24hnew].[dbo].[ProductDetails] AS b ON a.ProductID = b.ProductID AND a.ProductID >3486 ORDER BY a.ProductID";
			// die;

			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			printr($list_remote);

			
			
			$categories = $this->get_records ( '', 'fs_products_categories', '*', '', '', 'id' );
			$manus = $this->get_records ( '', 'fs_manufactories', 'name,alias,id', '', '', 'id' );

			$time = date ( 'Y-m-d H:i:s' );
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$row = array ();
				$item_r = $list_remote [$i];
				
				// check exist
				$exist = $this->check_exist ( $item_r->ProductID, 0, 'id', 'fs_products' );
				if ($exist) {
					echo "<br/>Da ton tai " . $item_r->ProductID . "<br/>";
					continue;
				}

		
				$cat = isset ( $categories [$item_r->CategoryID] ) ? $categories [$item_r->CategoryID] : null;
				// echo $item_r->id_catpd . "++";
				
				if (! $cat) {
					echo "==" . $item_r->ProductID . "== NOT convert by cat_id = " . $item_r->CategoryID . "not found </br>";
					continue;
				}
				
				foreach ( $arr_syn as $field_old => $field_new ) {
					$row [$field_new] = $item_r->$field_old;
				}
	
				$row ['manufactory_alias'] = @$manus[$item_r->LandProjectId]->alias;
				$row ['manufactory_name'] = @$manus[$item_r->LandProjectId]->name;
				$row['alias'] = $fsstring -> stringStandart($item_r -> Name);
				$row ['category_published'] = $cat->published;
				$row ['category_alias'] = $cat->alias;
				$row ['category_name'] = $cat->name;
				$row ['category_id_wrapper'] = $cat->list_parents;
				$row ['category_alias_wrapper'] = $cat->alias_wrapper;
				$row ['edited_time'] = $time;
				$row ['tablename'] = $cat->tablename;
	
				// echo "<pre>";
				// print_r($row);
				// die;
				$this->_add ( $row, 'fs_products', 1 );
			}
		}


		function update_products_suachualt() {
		
			$arr_syn = array (
				'ProductID' => 'id',
				'CategoryID' => 'category_id',
				// 'LandProjectId' => 'manufactory',
				'ImageUrl' => 'image_old',
				'ProductCode' => 'code',
				'Price_old' => 'price_old',
				'Price' => 'price',
				'Promote' => 'quantity',
				'ViewsCount' => 'hits',
				'Status' => 'published',
				'Type' => 'is_hot',
				// 'Order' => 'ordering',
				'New' => 'is_new',
				'CreatedBy' => 'creator_name',
				'LastEditedBy' => 'action_username',

				'Name' => 'name',
				'TitleName' => 'seo_title',
				'Keyword' => 'seo_keyword',
				'Description' => 'seo_description',

				'Warranty' => 'warranty',
				'BasicFeauture' => 'summary',
				'TechnicalParametter' => 'specifications',
				'Detail' => 'description',
				'BriefDescription' => 'video',

				'LandTypeId' => 'LandTypeId', //gia
				'LandNeedId' => 'LandNeedId', //nhu cau
				'DirectionId' => 'DirectionId', //manhinh
				'CurrencyId' => 'CurrencyId', //CPU

				'CreatedTime'=>'created_time',
				'LastEditedTime'=>'edited_time',
				

			);


			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();

			// $select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[Product] AS a INNER JOIN [suachualaptop].[dbo].[ProductDetails] AS b ON a.ProductID = b.ProductID AND a.ProductID >3486 ORDER BY a.ProductID";

			$select = "SELECT a.*, b.* FROM [suachua24hnew].[dbo].[Product] AS a INNER JOIN [suachua24hnew].[dbo].[ProductDetails] AS b ON a.ProductID = b.ProductID ORDER BY a.ProductID";
			// die;

			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);

			
			
			$categories = $this->get_records ( '', 'fs_products_categories', '*', '', '', 'id' );
			$manus = $this->get_records ( '', 'fs_manufactories', 'name,alias,id', '', '', 'id' );

			$time = date ( 'Y-m-d H:i:s' );
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$row = array ();
				$item_r = $list_remote [$i];
				
				

		
				$cat = isset ( $categories [$item_r->CategoryID] ) ? $categories [$item_r->CategoryID] : null;
				// echo $item_r->id_catpd . "++";
				
				if (! $cat) {
					echo "==" . $item_r->ProductID . "== NOT convert by cat_id = " . $item_r->CategoryID . "not found </br>";
					continue;
				}
				
				foreach ( $arr_syn as $field_old => $field_new ) {
					if($field_new == 'created_time' || $field_new == 'edited_time'){

						$arr = (array)$item_r -> $field_old;	
						$date = date_create(@$arr['date']);
						$row[$field_new] = date_format($date,"Y-m-d H:i:s"); 
					
					}else{
						$row [$field_new] = $item_r->$field_old;
					}
					
				}
	
				// $row ['manufactory_alias'] = @$manus[$item_r->LandProjectId]->alias;
				// $row ['manufactory_name'] = @$manus[$item_r->LandProjectId]->name;
				$row['alias'] = $fsstring -> stringStandart($item_r -> Name);
				$row ['category_published'] = $cat->published;
				$row ['category_alias'] = $cat->alias;
				$row ['category_name'] = $cat->name;
				$row ['category_id_wrapper'] = $cat->list_parents;
				$row ['category_alias_wrapper'] = $cat->alias_wrapper;
				// $row ['edited_time'] = $time;
				$row ['tablename'] = $cat->tablename;
				
				// echo "<pre>";
				// print_r($row);
				// die;

				// check exist
				$exist = $this->check_exist ( $item_r->ProductID, 0, 'id', 'fs_products' );
				if ($exist) {
					$row ['is_update2'] = 1;
					$this->_update ( $row, 'fs_products', 'id = ' .$item_r->ProductID );
				}else{
					$this->_add ( $row, 'fs_products', 1 );
				}
				// die;
				
			} 
		}

		// chuyển bảng
		function update_fields_fs_tables(){
			$products = $this->get_records ("category_id_wrapper LIKE '%,323,%'", 'fs_products', '*','id ASC', '');
			// printr($products);
			// include_once 'remote_db.php';
			// $remote_db = new Remote_db ();
			foreach ($products as $k => $value) {
				$fields = $this->get_records ( '', 'fs_tables', '*', '', '', 'id' );
				$row_ex = array();
				$row = (array)$value;
				foreach ($fields as $key => $field) {
					if(isset($row[$field->field_name])){
						$row_ex[$field->field_name] = $row[$field->field_name];
					}
				}

				$row_ex['record_id'] = $value->id;
				unset($row_ex['tablename ']);
				// printr($row_ex);
				
				$check_exit = $this->get_count('record_id = ' . $value->id, $value->tablename );
				if($check_exit){
					// $this->_update ($row_ex, $value->tablename, 'record_id ='.  $value->id  );
				}else{
					$this->_add ($row_ex, $value->tablename, 1 );
				}
			}
		}


		function synd_cat_news_suachualt() {
			$arr_syn = array (
				'CategoryID' => 'id',
				'Status' => 'published',
				'Order' => 'ordering',
				'TreeCode' => 'treeCode_old',
				'Level' => 'level',
				'ImageUrl' => 'image_old',
				'CategoryKey' => 'alias_old',
				'Name' => 'name',
				'Keyword'=>'seo_keyword',
				'Description'=>'seo_description',
				'TitleName'=>'seo_title',
				'Preview'=>'summary',
				'Detail'=>'description'
				
			);

			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );

			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[Category] AS a INNER JOIN [suachualaptop].[dbo].[CategoryDetails] AS b ON a.CategoryID = b.CategoryID WHERE a.TypeCode = 'News' ORDER BY a.Level ASC";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);


			$time = date ( 'Y-m-d H:i:s' );
			$row = array ();
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$item_r = $list_remote [$i];
				foreach ( $arr_syn as $field_old => $field_new ){
					$row [$field_new] = $item_r->$field_old;
				}



				// printr($item_r);
				// $parent_tree_code = $item_r -> TreeCode[strlen($item_r -> TreeCode)-2];
				$parent_tree_code = substr($item_r -> TreeCode, 0, -5);
				if($parent_tree_code == ''){
					// $row ['parent_id'] = 0;
				}else{
					global $db;
					$get_pr = ' SELECT * FROM fs_news_categories WHERE treeCode_old = "' .$parent_tree_code.'"' ;
					$sql = $db->query ( $get_pr );
					$it = $db->getObject();
					if(!empty($it)){
						$row ['parent_id'] = $it->id;
					}
					
				}
				
				// die;

				
				$row['alias'] = $fsstring -> stringStandart($item_r -> Name);
				$row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
				$row ['list_parents'] = isset($row ['parent_id']) ? ',' .$row ['parent_id'].','. $row ['id'] . ',': ','.$row ['id'] . ',';
				
				$row ['updated_time'] = $time;

				$check_exist = $this->get_record('id =' .$item_r ->CategoryID,'fs_news_categories');
				
				if(empty($check_exist)){
					// $this->_add ( $row, 'fs_news_categories', 1 );
				}else{
					$this->_update ( $row, 'fs_news_categories', 'id = ' . $check_exist->id);
				}
				
			}
		}


		function update_news_suachualt() {
		
			$arr_syn = array (
				'NewsID' => 'id',
				'CategoryID' => 'category_id',
				// 'ImageUrl' => 'image_old',
				// 'Title' => 'title',
				// 'TitleName' => 'seo_title',
				// 'Keyword' => 'seo_keyword',
				// 'Description' => 'seo_description',
				// 'Status' => 'published',
				// 'Order' => 'ordering',
				// 'ViewsCount' => 'hits',
				// 'Preview' => 'summary',
				'Content' => 'content',
				// 'CreatedBy' => 'creator',
				// 'LastModifiedBy' => 'action_username',
				// 'FileAttackUrl' => 'FileAttackUrl',
				// 'Type' => 'is_hot',
				// 'CreatedTime'=>'created_time',
				// 'LastModifiedTime'=>'updated_time',
				
				
			);


			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();

			$select = "SELECT a.*, b.* FROM [suachua24hnew].[dbo].[News] AS a INNER JOIN [suachua24hnew].[dbo].[NewsDetails] AS b ON a.NewsID = b.NewsID WHERE a.NewsID > 2384  ORDER BY a.NewsID";

			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);

			
			
			$categories = $this->get_records ( '', 'fs_news_categories', '*', '', '', 'id' );
			
			$time = date ( 'Y-m-d H:i:s' );
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$row = array ();
				$item_r = $list_remote [$i];
				
				// check exist
				// $exist = $this->check_exist ( $item_r->NewsID, 0, 'id', 'fs_news' );
				// if ($exist) {
				// 	echo "<br/>Da ton tai " . $item_r->NewsID . "<br/>";
				// 	continue;
				// }

		
				$cat = isset ( $categories [$item_r->CategoryID] ) ? $categories [$item_r->CategoryID] : null;
				// echo $item_r->id_catpd . "++";
				
				if (! $cat) {
					echo "==" . $item_r->NewsID . "== NOT convert by cat_id = " . $item_r->CategoryID . "not found </br>";
					continue;
				}
				
				foreach ( $arr_syn as $field_old => $field_new ) {

					
					if($field_new == 'created_time' || $field_new == 'updated_time'){

						$arr = (array)$item_r -> $field_old;
						

						$date = date_create(@$arr['date']);
			
						$row[$field_new] = date_format($date,"Y-m-d H:i:s"); 
					
					}else{
						$row [$field_new] = $item_r->$field_old;
					}
				}
	
			
				// $row['alias'] = $fsstring -> stringStandart($item_r -> Title);
				// $row ['category_published'] = $cat->published;
				// $row ['category_alias'] = $cat->alias;
				// $row ['category_name'] = $cat->name;
				// $row ['category_id_wrapper'] = $cat->list_parents;
				// $row ['category_alias_wrapper'] = $cat->alias_wrapper;
				// $row ['updated_time'] = $time;
			
				// unset($row['category_id']);
				// unset($row['id']);
				// echo "<pre>";
				// print_r($row);
				// die;
				$this->_update ( $row, 'fs_news', 'id = ' . $item_r->NewsID );
			}
			// die;
		}


		function add_news_suachualt() {
		
			$arr_syn = array (
				'NewsID' => 'id',
				'CategoryID' => 'category_id',
				'ImageUrl' => 'image_old',
				'Title' => 'title',
				'TitleName' => 'seo_title',
				'Keyword' => 'seo_keyword',
				'Description' => 'seo_description',
				'Status' => 'published',
				'Order' => 'ordering',
				'ViewsCount' => 'hits',
				'Preview' => 'summary',
				'Content' => 'content',
				'CreatedBy' => 'creator',
				'LastModifiedBy' => 'action_username',
				'FileAttackUrl' => 'FileAttackUrl',
				'Type' => 'is_hot',
				
			);


			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[News] AS a INNER JOIN [suachualaptop].[dbo].[NewsDetails] AS b ON a.NewsID = b.NewsID AND a.NewsID = 6521 ORDER BY a.NewsID";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);

			
			
			$categories = $this->get_records ( '', 'fs_news_categories', '*', '', '', 'id' );
			
			$time = date ( 'Y-m-d H:i:s' );
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$row = array ();
				$item_r = $list_remote [$i];
				
				// check exist
				$exist = $this->check_exist ( $item_r->NewsID, 0, 'id', 'fs_news' );
				if ($exist) {
					echo "<br/>Da ton tai " . $item_r->NewsID . "<br/>";
					continue;
				}

		
				$cat = isset ( $categories [$item_r->CategoryID] ) ? $categories [$item_r->CategoryID] : null;
				// echo $item_r->id_catpd . "++";
				
				if (! $cat) {
					echo "==" . $item_r->NewsID . "== NOT convert by cat_id = " . $item_r->CategoryID . "not found </br>";
					continue;
				}
				global $db;	
				foreach ( $arr_syn as $field_old => $field_new ) {

					if($field_new == "content"){
						$str = str_replace('👉','',$item_r->$field_old);
						$str = str_replace('💟','',$str);
						$row [$field_new] = $str;
						
					}else{
						$row [$field_new] = $item_r->$field_old;
					}
					
				}
				
				
			
				$row['alias'] = $fsstring -> stringStandart($item_r -> Title);
				$row ['category_published'] = $cat->published;
				$row ['category_alias'] = $cat->alias;
				$row ['category_name'] = $cat->name;
				$row ['category_id_wrapper'] = $cat->list_parents;
				$row ['category_alias_wrapper'] = $cat->alias_wrapper;
				$row ['updated_time'] = $time;
		
	
				// echo "<pre>";
				// print_r($row);
				// die;
				$this->_add ( $row, 'fs_news', 1 );
			}
		}

		function synd_cat_aq_suachualt() {
			$arr_syn = array (
				'CategoryID' => 'id',
				'Status' => 'published',
				'Order' => 'ordering',
				'TreeCode' => 'treeCode_old',
				'Level' => 'level',
				'ImageUrl' => 'image_old',
				'CategoryKey' => 'alias_old',
				'Name' => 'name',
				'Keyword'=>'seo_keyword',
				'Description'=>'seo_description',
				'TitleName'=>'seo_title',
				'Preview'=>'summary',
				'Detail'=>'description'
			);

			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );

			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[Category] AS a INNER JOIN [suachualaptop].[dbo].[CategoryDetails] AS b ON a.CategoryID = b.CategoryID WHERE a.TypeCode = 'QABasic' ORDER BY a.Level ASC";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);

			$time = date ( 'Y-m-d H:i:s' );
			$row = array ();
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$item_r = $list_remote [$i];
				foreach ( $arr_syn as $field_old => $field_new ){
					$row [$field_new] = $item_r->$field_old;
				}

				// printr($item_r);
				// $parent_tree_code = $item_r -> TreeCode[strlen($item_r -> TreeCode)-2];
				$parent_tree_code = substr($item_r -> TreeCode, 0, -5);
				if($parent_tree_code == ''){
					// $row ['parent_id'] = 0;
				}else{
					global $db;
					$get_pr = ' SELECT * FROM fs_aq_categories WHERE treeCode_old = "' .$parent_tree_code.'"' ;
					$sql = $db->query ( $get_pr );
					$it = $db->getObject();
					if(!empty($it)){
						$row ['parent_id'] = $it->id;
					}
					
				}
				
				// die;

				
				$row['alias'] = $fsstring -> stringStandart($item_r -> Name);
				$row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
				$row ['list_parents'] = isset($row ['parent_id']) ? ',' .$row ['parent_id'].','. $row ['id'] . ',': ','.$row ['id'] . ',';
				$row ['updated_time'] = $time;

				$check_exist = $this->get_record('id =' .$item_r ->CategoryID,'fs_aq_categories');
				
				if(empty($check_exist)){
					$this->_add ( $row, 'fs_aq_categories', 1 );
				}
				
			}
		}


		function add_aq_suachualt() {
		
			$arr_syn = array (
				'QAID' => 'id',
				'CategoryID' => 'category_id',
				'QuestionUser' => 'asker',
				'Status' => 'published',
				'Order' => 'ordering',
				'ViewCounts' => 'hits',
				'Email' => 'email',
				'Phone' => 'phone',
				'Question' => 'question',
				'Answer' => 'content',
			

				
			);


			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[QABasic] AS a INNER JOIN [suachualaptop].[dbo].[QABasicDetail] AS b ON a.QAID = b.QAID ORDER BY a.QAID";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			printr($list_remote);

			
			
			$categories = $this->get_records ( '', 'fs_aq_categories', '*', '', '', 'id' );
			
			$time = date ( 'Y-m-d H:i:s' );
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$row = array ();
				$item_r = $list_remote [$i];
				
				// check exist
				$exist = $this->check_exist ( $item_r->QAID, 0, 'id', 'fs_aq' );
				if ($exist) {
					echo "<br/>Da ton tai " . $item_r->QAID . "<br/>";
					continue;
				}

		
				$cat = isset ( $categories [$item_r->CategoryID] ) ? $categories [$item_r->CategoryID] : null;
				// echo $item_r->id_catpd . "++";
				
				if (! $cat) {
					echo "==" . $item_r->QAID . "== NOT convert by cat_id = " . $item_r->CategoryID . "not found </br>";
					continue;
				}
				
				foreach ( $arr_syn as $field_old => $field_new ) {
					$row [$field_new] = $item_r->$field_old;
				}
	
				$row ['title'] = get_word_by_length(70,$item_r -> Question);
				$row['alias'] = $fsstring -> stringStandart($row ['title']);
				$row ['category_published'] = $cat->published;
				$row ['category_alias'] = $cat->alias;
				$row ['category_name'] = $cat->name;
				$row ['category_id_wrapper'] = $cat->list_parents;
				$row ['category_alias_wrapper'] = $cat->alias_wrapper;
				$row ['updated_time'] = $time;
		
	
				// echo "<pre>";
				// print_r($row);
				// die;
				$this->_add ( $row, 'fs_aq', 1 );
			}
		}


		function synd_cat_video_suachualt() {
			$arr_syn = array (
				'CategoryID' => 'id',
				'Status' => 'published',
				'Order' => 'ordering',
				'TreeCode' => 'treeCode_old',
				'Level' => 'level',
				'ImageUrl' => 'image_old',
				'CategoryKey' => 'alias_old',
				'Name' => 'name',
				'Keyword'=>'seo_keyword',
				'Description'=>'seo_description',
				'TitleName'=>'seo_title',

			);

			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );

			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[Category] AS a INNER JOIN [suachualaptop].[dbo].[CategoryDetails] AS b ON a.CategoryID = b.CategoryID WHERE a.TypeCode = 'video' ORDER BY a.Level ASC";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);

			$time = date ( 'Y-m-d H:i:s' );
			$row = array ();
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$item_r = $list_remote [$i];
				foreach ( $arr_syn as $field_old => $field_new ){
					$row [$field_new] = $item_r->$field_old;
				}

				// printr($item_r);
				// $parent_tree_code = $item_r -> TreeCode[strlen($item_r -> TreeCode)-2];
				$parent_tree_code = substr($item_r -> TreeCode, 0, -5);
				if($parent_tree_code == ''){
					// $row ['parent_id'] = 0;
				}else{
					global $db;
					$get_pr = ' SELECT * FROM fs_videos_categories WHERE treeCode_old = "' .$parent_tree_code.'"' ;
					$sql = $db->query ( $get_pr );
					$it = $db->getObject();
					if(!empty($it)){
						$row ['parent_id'] = $it->id;
					}
					
				}
				
				// die;

				
				$row['alias'] = $fsstring -> stringStandart($item_r -> Name);
				$row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
				$row ['list_parents'] = isset($row ['parent_id']) ? ',' .$row ['parent_id'].','. $row ['id'] . ',': ','.$row ['id'] . ',';
				$row ['updated_time'] = $time;

				$check_exist = $this->get_record('id =' .$item_r ->CategoryID,'fs_videos_categories');
				
				if(empty($check_exist)){
					$this->_add ( $row, 'fs_videos_categories', 1 );
				}
				
			}
		}


		function add_video_suachualt() {
		
			$arr_syn = array (
				'VideoID' => 'id',
				'CategoryID' => 'category_id',
				'Html' => 'file_flash',
				'Status' => 'published',
				'ORDER' => 'ordering',
				'ViewsCount' => 'hits',
				'ImageUrl' => 'image_old',
				'Name' => 'title',
				'TitleName' => 'seo_title',
				'Keyword' => 'seo_keyword',
				'Description' => 'seo_description',
				'Type' => 'show_in_homepage'
			);


			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[Video] AS a INNER JOIN [suachualaptop].[dbo].[VideoDetails] AS b ON a.VideoID = b.VideoID ORDER BY a.VideoID";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);

			
			
			$categories = $this->get_records ( '', 'fs_videos_categories', '*', '', '', 'id' );
			
			$time = date ( 'Y-m-d H:i:s' );
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$row = array ();
				$item_r = $list_remote [$i];
				
				// check exist
				$exist = $this->check_exist ( $item_r->VideoID, 0, 'id', 'fs_videos' );
				if ($exist) {
					echo "<br/>Da ton tai " . $item_r->VideoID . "<br/>";
					continue;
				}

		
				$cat = isset ( $categories [$item_r->CategoryID] ) ? $categories [$item_r->CategoryID] : null;
				// echo $item_r->id_catpd . "++";
				
				if (! $cat) {
					echo "==" . $item_r->NewsID . "== NOT convert by cat_id = " . $item_r->CategoryID . "not found </br>";
					continue;
				}
				
				foreach ( $arr_syn as $field_old => $field_new ) {
					$row [$field_new] = $item_r->$field_old;
				}
	
				$file_flash = str_replace('&feature=player_embedded#!','',$item_r -> Html);
				$file_flash = str_replace('&feature=player_embedded','',$file_flash);
				$file_flash = str_replace('http://youtu.be/','http://www.youtube.com/watch?v=',$file_flash);
	




				$row['file_flash'] = $file_flash;
				$row['alias'] = $fsstring -> stringStandart($item_r -> Name);
				$row ['category_published'] = $cat->published;
				$row ['category_alias'] = $cat->alias;
				$row ['category_name'] = $cat->name;
				$row ['category_id_wrapper'] = $cat->list_parents;
				$row ['category_alias_wrapper'] = $cat->alias_wrapper;
				$row ['updated_time'] = $time;
		
	
				// echo "<pre>";
				// print_r($row);
				// die;
				$this->_add ( $row, 'fs_videos', 1 );
			}
		}

		function synd_cat_album_suachualt() {
			$arr_syn = array (
				'CategoryID' => 'id',
				'Status' => 'published',
				'Order' => 'ordering',
				'TreeCode' => 'treeCode_old',
				'Level' => 'level',
				'ImageUrl' => 'image_old',
				'CategoryKey' => 'alias_old',
				'Name' => 'title',
				'Keyword'=>'seo_keyword',
				'Description'=>'seo_description',
				'TitleName'=>'seo_title',

			);

			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );

			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT a.*, b.* FROM [suachualaptop].[dbo].[Category] AS a INNER JOIN [suachualaptop].[dbo].[CategoryDetails] AS b ON a.CategoryID = b.CategoryID WHERE a.TypeCode = 'AlbumIMG' ORDER BY a.Level ASC";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);

			$time = date ( 'Y-m-d H:i:s' );
			$row = array ();
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$item_r = $list_remote [$i];
				foreach ( $arr_syn as $field_old => $field_new ){
					$row [$field_new] = $item_r->$field_old;
				}

				// printr($item_r);
				// $parent_tree_code = $item_r -> TreeCode[strlen($item_r -> TreeCode)-2];
				$parent_tree_code = substr($item_r -> TreeCode, 0, -5);
				if($parent_tree_code == ''){
					// $row ['parent_id'] = 0;
				}else{
					global $db;
					$get_pr = ' SELECT * FROM fs_albums_categories WHERE treeCode_old = "' .$parent_tree_code.'"' ;
					$sql = $db->query ( $get_pr );
					$it = $db->getObject();
					if(!empty($it)){
						$row ['parent_id'] = $it->id;
					}
					
				}
				
				// die;

				
				$row['alias'] = $fsstring -> stringStandart($item_r -> Name);
				$row ['alias_wrapper'] = ',' . $row ['alias'] . ',';
				$row ['list_parents'] = isset($row ['parent_id']) ? ',' .$row ['parent_id'].','. $row ['id'] . ',': ','.$row ['id'] . ',';
				$row ['edited_time'] = $time;

				$check_exist = $this->get_record('id =' .$item_r ->CategoryID,'fs_albums_categories');
				
				if(empty($check_exist)){
					$this->_add ( $row, 'fs_albums_categories', 1 );
				}
				
			}
		}


		function add_album_suachualt() {
		
			$arr_syn = array (
				'ImageID' => 'id',
				'CategoryID' => 'category_id',
				'CreateedBy' => 'action_username',
				'Status' => 'published',
				'Order' => 'ordering',
				'ImageUrl' => 'image_old',
				'LinkUrl' => 'link',

			);


			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT * FROM [suachualaptop].[dbo].[AlbumImages]";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);

			
			
			$categories = $this->get_records ( '', 'fs_albums_categories', '*', '', '', 'id' );
			
			$time = date ( 'Y-m-d H:i:s' );
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$row = array ();
				$item_r = $list_remote [$i];
				
				// check exist
				$exist = $this->check_exist ( $item_r->ImageID, 0, 'id', 'fs_albums' );
				if ($exist) {
					echo "<br/>Da ton tai " . $item_r->ImageID . "<br/>";
					continue;
				}

		
				$cat = isset ( $categories [$item_r->CategoryID] ) ? $categories [$item_r->CategoryID] : null;
				// echo $item_r->id_catpd . "++";
				
				if (! $cat) {
					echo "==" . $item_r->ImageID . "== NOT convert by cat_id = " . $item_r->CategoryID . "not found </br>";
					continue;
				}
				
				foreach ( $arr_syn as $field_old => $field_new ) {
					$row [$field_new] = $item_r->$field_old;
				}
				$row['title'] = "Hình ảnh".$item_r -> ImageID;
				$row['alias'] ="hinh-anh".$item_r -> ImageID;
				$this->_add ( $row, 'fs_albums', 1 );
			}
		}


		function add_image_other_products_suachualt() {
		
			$arr_syn = array (
				'Id' => 'id',
				'ObjId' => 'record_id',
				'ImageUrl' => 'image_old',
			);


			$fsstring = FSFactory::getClass ( 'FSString', '', '../' );
			
			// remote db
			include_once 'remote_sqlsrv.php';
			$remote_db = new Remote_db();
			$select = "SELECT * FROM [suachualaptop].[dbo].[Pictures]";
			$sql = $remote_db->query($select);
			$list_remote = $remote_db->getObjectList();
			// printr($list_remote);

			$time = date ( 'Y-m-d H:i:s' );
			for($i = 0; $i < count ( $list_remote ); $i ++) {
				$row = array ();
				$item_r = $list_remote [$i];
	
				
				foreach ( $arr_syn as $field_old => $field_new ) {
					$row [$field_new] = $item_r->$field_old;
				}
				$this->_add ( $row, 'fs_products_images', 1 );
			}
		}


		function products_resize_images_product_suachualt() {
			global $db;
			// $select = ' SELECT id, image, image_old,tablename FROM fs_products';
			$select = ' SELECT id, image,image_old,tablename FROM fs_products WHERE id >= 4586 ORDER BY id';
			
			$sql = $db->query ( $select );
			
			$list = $db->getObjectList ();
			$day = '17';
			$month = '04';
			
			// $folder_image_begin = 'G:\project\minhanh\code\\';
			// $folder_image_destination = 'G:\project\minhanh\code\images\products\2019\\'.$month.'\\'.$day.'\original\\';

			// /home/duyanh2/domains/donghoduyanh2.delectech.com/public_html/uploads

			// $folder_image_begin = DS.'home'.DS.'duyanh2'.DS.'domains'.DS.'donghoduyanh2.delectech.com'.DS.'public_html'.DS.'upload'.DS.'images'.DS;

			// $folder_image_destination = DS.'home'.DS.'duyanh2'.DS.'domains'.DS.'donghoduyanh2.delectech.com'.DS.'public_html'.DS.'images'.DS.'products'.DS.'2020'.DS.$month.DS.$day.DS.'original'.DS;

			// /home/suachualt2/domains/suachualaptop.delectech.vn/public_html/Pictures
			// /home/suachualt2/domains/suachualaptop.delectech.vn/public_html/images/products

			$folder_image_begin = DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'/suachualaptop.delectech.vn'.DS.'public_html'.DS.'Pictures'.DS;

			$folder_image_destination = DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'suachualaptop.delectech.vn'.DS.'public_html'.DS.'images'.DS.'products'.DS.'2020'.DS.$month.DS.$day.DS.'original'.DS;

			$arr_img_paths = array (array ('large',800,800, 'resize_image' ), array ('resized',300,300, 'resize_image' ), array ('small', 100,100, 'resize_image' ) );

			// $arr_img_paths = array (array ('small', 100,100, 'resize_image' ) );

			$fsFile = FSFactory::getClass ( 'FsFiles', '' );
			
			for($i = 0; $i < count ( $list ); $i ++) {
				$item = $list [$i];
				$image = $item->image_old;
				//				$image = PATH_BASE.str_replace('/',DS,$item -> image_old);
				$image_new = basename ( $image );
				// $image_new = $fsFile->genarate_filename_standard ( $image_new );

				$image_new = preg_replace('/\s/i', '_', $image_new);
				$image_new = $fsFile->genarate_filename_standard ( $image_new );
				// echo $image_new;
				// die;

				$fsFile->create_folder ( $folder_image_destination );

				if (! $fsFile->copy_file ( $folder_image_begin . str_replace ( '/', DS, $image ), $folder_image_destination . $image_new ))
					continue;

				foreach ( $arr_img_paths as $path ) {
					$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination );
					$fsFile->create_folder ( $path_resize );
					$method_resize = $path [3] ? $path [3] : 'cut_image';
					//					$fsFile -> remove_file_by_path($path_resize);
					if (! $fsFile->$method_resize ( $folder_image_destination . $image_new, $path_resize . $image_new, $path [1], $path [2] )) {
						echo $item->id . '_';
					}

			//						return false;
				}
				
				$row = array ();
				$tablename = $row['tablename'];
				$row ['image'] = 'images/products/2020/04/17/original/'. $image_new;
				$this->_update( $row, 'fs_products', 'id = ' . $item->id );
				unset($row['tablename']);
				$this->_update( $row,$tablename, 'record_id = ' . $item->id ); 
			}
		}

		function update_ngu() {
			global $db;
			$select = ' SELECT id,show_product_special_cat,tablename FROM fs_products WHERE show_product_special_cat = 1 ';
			$sql = $db->query ( $select );
			$list = $db->getObjectList ();
			foreach ($list as $key => $value) {
				$row = array ();
				$row ['show_product_special_cat'] = $value->show_product_special_cat;
				// $this->_update( $row, 'fs_products', 'id = ' . $value->id ); 
				$this->_update( $row, $value->tablename, 'record_id = ' . $value->id ); 
			}
		}


		function update_discount() {
			global $db;
			$select = ' SELECT id, price,price_old,tablename FROM fs_products ORDER BY id';
			$sql = $db->query ( $select );
			$list = $db->getObjectList ();
			foreach ($list as $key => $value) {
				$row = array ();
				$row ['discount'] = $value->price_old - $value->price;
				$row ['discount_unit'] = 'price';
				// printr($row);
				$this->_update( $row, 'fs_products', 'id = ' . $value->id ); 
				$this->_update( $row, $value->tablename, 'record_id = ' . $value->id ); 
			}
		}

		function products_resize_images_other_product_suachualt() {
			global $db;
			// $select = ' SELECT id, image, image_old FROM fs_products_images WHERE id >= 15240 AND id <= 15438 ORDER BY id ASC';
			$select = 'SELECT * FROM fs_products_images';

			//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
			$sql = $db->query ( $select );
			
			$list = $db->getObjectList ();
			$day = '18';
			$month = '04';
			
			// $folder_image_begin = 'G:\project\minhanh\code\\';
			// $folder_image_destination = 'G:\project\minhanh\code\images\products\2019\\'.$month.'\\'.$day.'\original\\';


			// $folder_image_begin = DS.'home'.DS.'duyanh2'.DS.'domains'.DS.'donghoduyanh2.delectech.com'.DS.'public_html'.DS.'upload'.DS.'images'.DS;

			// $folder_image_destination = DS.'home'.DS.'duyanh2'.DS.'domains'.DS.'donghoduyanh2.delectech.com'.DS.'public_html'.DS.'images'.DS.'products'.DS.'2020'.DS.$month.DS.$day.DS.'original'.DS;





			$folder_image_begin = DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'/suachualaptop.delectech.vn'.DS.'public_html'.DS.'Pictures'.DS;

			$folder_image_destination = DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'suachualaptop.delectech.vn'.DS.'public_html'.DS.'images'.DS.'products'.DS.'2020'.DS.$month.DS.$day.DS.'original'.DS;

			
			$arr_img_paths = array (array ('large',800,800, 'resize_image' ), array ('resized',300,300, 'resize_image' ), array ('small', 100,100, 'resize_image' ) );





			$fsFile = FSFactory::getClass ( 'FsFiles', '' );
			
			for($i = 0; $i < count ( $list ); $i ++) {
				$item = $list [$i];
				$image = $item-> image_old;
				$image_new = basename ( $image );
				$image_new = $fsFile->genarate_filename_standard ( $image_new );
				
				$fsFile->create_folder ( $folder_image_destination );
				if (! $fsFile->copy_file ( $folder_image_begin . str_replace ( '/', DS, $image ), $folder_image_destination . $image_new ))
					continue;
				foreach ( $arr_img_paths as $path ) {
					$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination );
					$fsFile->create_folder ( $path_resize );
					$method_resize = $path [3] ? $path [3] : 'cut_image';
					if (! $fsFile->$method_resize ( $folder_image_destination . $image_new, $path_resize . $image_new, $path [1], $path [2] )) {
						echo $item->id . '_';
					}

				}
				
				$row = array ();
				$row ['image'] = 'images/products/2020/04/18/original/'. $image_new;
				$this->_update ( $row, 'fs_products_images', ' id = ' . $item->id );
			}
		}


		function news_resize_images_suachua() {
			global $db;
			$select = "SELECT id, image,image_old,published FROM fs_news WHERE id <= 5557  AND image_old !='' ORDER BY id DESC";
			//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
			$sql = $db->query ( $select );
			
			$list = $db->getObjectList ();
			$day = '17';
			$month = '04';


			$folder_image_begin = DS.'home'.DS.'suachua'.DS.'domains'.DS.'suachualaptop24h.com'.DS.'public_html'.DS.'Pictures'.DS;

			$folder_image_destination = DS.'home'.DS.'suachua'.DS.'domains'.DS.'suachualaptop24h.com'.DS.'public_html'.DS.'images'.DS.'news'.DS.'2020'.DS.$month.DS.$day.DS.'original'.DS;

			$arr_img_paths = array (array ('resized', 375, 200, 'cut_image' ), array ('small', 120, 80, 'cut_image' ), array ('large', 750, 400, 'cut_image' ) );


			$fsFile = FSFactory::getClass ( 'FsFiles', '' );

			
			for($i = 0; $i < count ( $list ); $i ++) {
				$item = $list [$i];
				$image = $item-> image_old;
				$image_new = basename ( $image );
				$image_new = $fsFile->genarate_filename_standard ( $image_new );
				
				$fsFile->create_folder ( $folder_image_destination );
				if (! $fsFile->copy_file ( $folder_image_begin . str_replace ( '/', DS, $image ), $folder_image_destination . $image_new ))
					continue;

				foreach ( $arr_img_paths as $path ) {
					$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination );
					$fsFile->create_folder ( $path_resize );
					$method_resize = $path [3] ? $path [3] : 'cut_image';
					if (! $fsFile->$method_resize ( $folder_image_destination . $image_new, $path_resize . $image_new, $path [1], $path [2] )) {
						echo $item->id . '_';
					}
				}
				
				$row = array ();
				$row ['image'] = 'images/news/2020/04/17/original/' . $image_new;
				$this->_update ( $row, 'fs_news', ' id = ' . $item->id );

				echo  $item->id  ."+";
			}
		}

		function news_resize_images_suachua1() {
			global $db;
			$select = "SELECT id, image,published FROM fs_news WHERE id < 6700 AND id > 6020 ORDER BY id ASC";
			//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
			$sql = $db->query ( $select );

		


			$list = $db->getObjectList ();
			// $day = '13';
			// $month = '06';


			

			
			$arr_img_paths = array (array ('resized', 375, 200, 'cut_image' ), array ('small', 120, 80, 'cut_image' ), array ('large', 750, 400, 'cut_image' ) );


			$fsFile = FSFactory::getClass ( 'FsFiles', '' );
			for($i = 0; $i < count ( $list ); $i ++) {

				$item = $list [$i];
				$arr_date=explode('/',$item->image);
				$day = $arr_date[4];
				$month = $arr_date[3];
				$year = $arr_date[2];
				
				$folder_image_begin =  DS.'home'.DS.'suachua'.DS.'domains'.DS.'suachualaptop24h.com'.DS.'public_html'.DS.'images'.DS.'news'.DS.$year.DS.$month.DS.$day.DS.'original'.DS;

				$folder_image_destination =  DS.'home'.DS.'suachua'.DS.'domains'.DS.'suachualaptop24h.com'.DS.'public_html'.DS.'images'.DS.'news'.DS.$year.DS.$month.DS.$day.DS.'original'.DS;


				$image = $item-> image;
				$image_new = basename ( $image );
				$image_new = $fsFile->genarate_filename_standard ( $image_new );
				


				$fsFile->create_folder ( $folder_image_destination );
				// if (! $fsFile->copy_file ( $folder_image_begin . str_replace ( '/', DS, $image_new ), $folder_image_destination . $image_new ))
				// 	continue;
				// die;
					
				foreach ( $arr_img_paths as $path ) {
					$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination );
					// $path_resize . $image_new;

					// $fsFile->create_folder ( $path_resize );
					$method_resize = $path [3] ? $path [3] : 'cut_image';
					if (! $fsFile->$method_resize ( $folder_image_destination . $image_new, $path_resize . $image_new, $path [1], $path [2] )) {
						echo $item->id . '_';
					}
					// echo 111;
					// die;
				}
				
				
				// $row = array ();
				// $row ['image'] = 'images/news/'.$year.'/'.$month.'/'.$day.'/original/' . $image_new;
				// $this->_update ( $row, 'fs_news', ' id = ' . $item->id );

				echo  $item->id  ."+";
			}
		}

		function album_resize_images_suachua() {
			global $db;
			$select = "SELECT id, image,image_old,published FROM fs_albums";
			//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
			$sql = $db->query ( $select );
			
			$list = $db->getObjectList ();
			$day = '17';
			$month = '04';


			$folder_image_begin = DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'/suachualaptop.delectech.vn'.DS.'public_html'.DS.'Pictures'.DS;

			$folder_image_destination = DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'suachualaptop.delectech.vn'.DS.'public_html'.DS.'images'.DS.'albums'.DS.'2020'.DS.$month.DS.$day.DS.'original'.DS;

			$arr_img_paths = array(array('resized',600,400,'cut_image'),array('large',1000,667,'resized_not_crop'));


			$fsFile = FSFactory::getClass ( 'FsFiles', '' );
			for($i = 0; $i < count ( $list ); $i ++) {
				$item = $list [$i];
				$image = $item-> image_old;
				$image_new = basename ( $image );
				$image_new = $fsFile->genarate_filename_standard ( $image_new );
				
				$fsFile->create_folder ( $folder_image_destination );
				if (! $fsFile->copy_file ( $folder_image_begin . str_replace ( '/', DS, $image ), $folder_image_destination . $image_new ))
					continue;
				foreach ( $arr_img_paths as $path ) {
					$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination );
					$fsFile->create_folder ( $path_resize );
					$method_resize = $path [3] ? $path [3] : 'cut_image';
					if (! $fsFile->$method_resize ( $folder_image_destination . $image_new, $path_resize . $image_new, $path [1], $path [2] )) {
						echo $item->id . '_';
					}
				}
				
				$row = array ();
				$row ['image'] = 'images/albums/2020/04/17/original/' . $image_new;
				$this->_update ( $row, 'fs_albums', ' id = ' . $item->id );

				echo  $item->id  ."+";
			}
		}

		function video_resize_images_suachua() {
			global $db;
			$select = "SELECT id, image,image_old,published FROM fs_videos";
			//			$select = ' SELECT * FROM fs_products WHERE id < 1500 AND id >=1000';
			$sql = $db->query ( $select );
			
			$list = $db->getObjectList ();
			$day = '17';
			$month = '04';


			$folder_image_begin = DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'/suachualaptop.delectech.vn'.DS.'public_html'.DS.'Pictures'.DS;

			$folder_image_destination = DS.'home'.DS.'suachualt2'.DS.'domains'.DS.'suachualaptop.delectech.vn'.DS.'public_html'.DS.'images'.DS.'videos'.DS.'2020'.DS.$month.DS.$day.DS.'original'.DS;

			$arr_img_paths = array(array('resized',270,145,'cut_image'),array('small',180,132,'cut_image'),array('large',570,369,'cut_image'));


			$fsFile = FSFactory::getClass ( 'FsFiles', '' );
			for($i = 0; $i < count ( $list ); $i ++) {
				$item = $list [$i];
				$image = $item-> image_old;
				$image_new = basename ( $image );
				$image_new = $fsFile->genarate_filename_standard ( $image_new );
				
				$fsFile->create_folder ( $folder_image_destination );
				if (! $fsFile->copy_file ( $folder_image_begin . str_replace ( '/', DS, $image ), $folder_image_destination . $image_new ))
					continue;
				foreach ( $arr_img_paths as $path ) {
					$path_resize = str_replace ( DS . 'original' . DS, DS . $path [0] . DS, $folder_image_destination );
					$fsFile->create_folder ( $path_resize );
					$method_resize = $path [3] ? $path [3] : 'cut_image';
					if (! $fsFile->$method_resize ( $folder_image_destination . $image_new, $path_resize . $image_new, $path [1], $path [2] )) {
						echo $item->id . '_';
					}
				}
				
				$row = array ();
				$row ['image'] = 'images/videos/2020/04/17/original/' . $image_new;
				$this->_update ( $row, 'fs_videos', ' id = ' . $item->id );

				echo  $item->id  ."+";
			}
		}



		function hailinh_update_cat_id_wraper() {
			global $db;
			$cats = $this->get_records('','fs_products_categories','*','','','id');
			$select = 'SELECT id,tablename,category_id FROM fs_products ORDER BY id';
			$sql = $db->query ( $select );
			$list = $db->getObjectList ();
			foreach ($list as $key => $value) {
				$row = array ();
				$row ['category_id_wrapper_root'] = $cats[$value-> category_id]-> list_parents;
				$this->_update( $row, 'fs_products', 'id = ' . $value->id ); 
				// $this->_update( $row, $value->tablename, 'record_id = ' . $value->id ); 
			}
		}


		function update_type_price_table() {
			global $db;
			
			$select = 'SELECT DISTINCT(table_name) FROM fs_products_tables';
			$sql = $db->query ( $select );
			$list = $db->getObjectList ();
			foreach ($list as $key => $value) {
				$db->query ('ALTER TABLE '.$value->table_name.' MODIFY price DOUBLE;');
				$db->query ('ALTER TABLE '.$value->table_name.' MODIFY price_old DOUBLE;');
			}
		}


		function create_field_table_extend() {
			$column_add = "category_id_wrapper_extra";
			$type = 'VARCHAR(255)';
			global $db;
			$select = 'SELECT DISTINCT(table_name) FROM fs_products_tables';
			$sql = $db->query ( $select );
			$list = $db->getObjectList ();

			foreach ($list as $key => $value) {

				//kiểm tra bảng này tồn tại ko
				$select3 = 'SELECT * FROM information_schema.tables WHERE table_schema = "hailinh_thang" AND table_name = "' . $value->table_name.'"';
				$sql3 = $db->query ( $select3 );
				$list3 = $db->getObject();

				if(empty($list3)){
					continue;
				}

				//kiểm tra trường này đã tồn tại chưa
				$select2 = 'SHOW COLUMNS FROM ' . $value->table_name;
				$sql2 = $db->query ( $select2 );
				$list2 = $db->getObjectList ();
				$check = 0;
				foreach ($list2 as $value2) {
					if($value2->Field == $column_add){
						$check = 1;
					}
				}
				
				if($check == 1){
					continue;
				}
				
				$db->query ('ALTER TABLE '.$value->table_name.' ADD COLUMN '.$column_add.' '.$type.' AFTER id');
				echo $value->table_name;
				
			}
		}

		// chuyển bảng
		function update_manu_for_cat(){
			$cats = $this->get_records('level > 0', 'fs_products_categories', 'id');
			foreach ($cats as $cat) {
				$get_manus = $this->get_records('category_id_wrapper LIKE "%,'.$cat->id.',%"','fs_products','DISTINCT(manufactory)');
				

				$str_manu ='';
				if(!empty($get_manus)){
					$i = 1;
					foreach ($get_manus as $item) {
						if(empty($item) || !$item || $item->manufactory == ''){
							$i++;
							continue;
						}
						if(count($get_manus) == $i){
							$str_manu .= $item->manufactory;
						}else{
							$str_manu .=$item->manufactory.',';
						}
						$i++;
					}
				}
				$row = array();
				$row['manufactory_related'] = $str_manu;
				
				$this->_update ($row,'fs_products_categories','id = '.$cat->id);
			}

		}

		function update_cat_id_wraper_extra_history(){
			global $db;
			$products = $this->get_records('id > 8311','fs_products','id,tablename,category_id_wrapper,category_alias_wrapper');
			foreach ($products as $item) {
				$product_history = $this->get_records('record_id = ' .$item ->id,'fs_products_history','category_id_wrapper,category_alias_wrapper');

				if(empty($product_history)){
					$row = array();
					$row['category_id_wrapper_extra'] = $item->category_id_wrapper;
					$row['category_alias_wrapper_extra'] = $item->category_alias_wrapper;
					$this->_update($row,'fs_products','id = ' .$item->id);
					if($item->tablename != 'fs_products' ){
						$this->_update($row,$item->tablename,'record_id = ' .$item->id);
					}
					continue;
				}
				$count = 0;
				$i = 0;

				foreach ($product_history as $item_his) {
					$i++;

					$cat = substr($item_his->category_id_wrapper, 1, -1);
					$cat_arr = explode(',',$cat);
					$count_arr = count($cat_arr);
					if($count_arr > $count){
						$count = $count_arr;
						$str_id = $item_his->category_id_wrapper;
						$str_alias = $item_his->category_alias_wrapper;
					}

					if($i == count($product_history)){
						$row = array();
						$row['category_id_wrapper_extra'] = $str_id;
						$row['category_alias_wrapper_extra'] = $str_alias;
						$this->_update($row,'fs_products','id = ' .$item->id);
						if($item->tablename != 'fs_products' ){
							$this->_update($row,$item->tablename,'record_id = ' .$item->id);
						}
					}
				}
			}
		}

		function update_city_for_ward(){
			$ward = $this->get_records('ISNULL(city_id)', 'fs_wards', 'district_id,id');
			foreach ($ward as $item) {
				$district = $this->get_record('id = ' .$item->district_id , 'fs_districts', '*');
				$row = array();
				$row['city_id'] = $district->city_id;
				$this->_update ($row,'fs_wards','id = '.$item->id);
			}

		}

		function cv_html_entity_decode(){
			$products = $this->get_records('id > 4289', 'fs_products', 'description,id,summary');
			foreach ($products as $item) {
				$row = array();
				$row['description'] =  html_entity_decode($item->description);
				$row['summary'] = html_entity_decode($item->summary);
				$this->_update2 ($row,'fs_products','id = '.$item->id);
			}
		}

		function update_hdshop_order(){
			$list = $this->get_records('user_id_manage_shop > 0', 'fs_order_uploads', '*');
			// dd($list);
			foreach ($list as $item) {
				$row = array();
				$row['list_user_id_manage_shop'] = ','.$item-> user_id_manage_shop.',';
				$this->_update($row,'fs_order_uploads','id = '.$item->id);
			}
		}

		function update_loi_kho_11(){
			$products = $this->get_records('bill_id = 134','fs_warehouses_bill_detail','DISTINCT product_id');
			
			foreach ($products as $product){

				$bill_detail = $this->get_record('status = 4 AND bill_id < 134 AND warehouses_id = 2 AND product_id = '.$product-> product_id,'fs_warehouses_bill_detail','*','id DESC');
				// dd($product);

				if(!empty($bill_detail)){
					$row = array();
					$row['amount'] = $bill_detail-> ton;
					$this->_update($row,'fs_warehouses_products','product_id = '.$product-> product_id . ' AND warehouses_id = 2');
				}	
			}
		}



		function update_loi_ton11(){
			$list_products = $this->get_records('created_time > "2022-10-25 23:59:55" AND status = 4 AND warehouses_id = 2','fs_warehouses_bill_detail','DISTINCT product_id');
			
			foreach ($list_products as $product_id_item){
				$list_detail = $this -> get_records('created_time > "2022-10-25 23:59:55" AND status = 4 AND warehouses_id = 2 AND product_id = '.$product_id_item-> product_id,'fs_warehouses_bill_detail','*','id DESC');
				$ton = -100000000;
				//tồn thực tế hiện tại
				$amount_product = $this-> get_record('product_id = '.$product_id_item-> product_id.' AND warehouses_id = 2','fs_warehouses_products','amount');
				foreach($list_detail as $item_detail) {
					$row_10 = array();
					$row_10['bill_detail_id'] = $item_detail-> id;
					$row_10['bill_id'] = $item_detail-> bill_id;
					$row_10['created_time'] = $item_detail-> created_time;
					$row_10['product_id']   = $item_detail-> product_id;
					$row_10['product_code'] = $item_detail-> product_code;
					$row_10['product_name'] = $item_detail-> product_name;

					$row_10['warehouses_id'] = $item_detail-> warehouses_id;
					$row_10['warehouses_name'] = $item_detail-> warehouses_name;

					$row_10['type'] = $item_detail-> type;
					$row_10['amount'] = $item_detail-> amount;
					$row_10['price'] = $item_detail-> price;
					$row_10['tong_tien'] = $item_detail-> price * $item_detail-> amount;
					$row_10['note'] = $item_detail-> note;
					$row_10['status'] = $item_detail-> status;
					$row_10['time_add'] = date('Y-m-d H:i:s');

					// dd($amount_product );

					if($item_detail-> type == 1){
						$row_10['type_action_name'] = "Phiếu nhập";
						if($ton == -100000000){
							// tính toán đã cộng bao nhiêu trc đó.
							
							$ton_luc_dau = $amount_product->amount;
							$ton = $ton_luc_dau;
							$ton_vong_truoc = $ton_luc_dau - $item_detail-> amount;
						}else{
							$ton = $ton_vong_truoc;
							// die;
							$ton_vong_truoc = $ton - $item_detail-> amount;
						}	

					}elseif($item_detail-> type == 2){
						
						$row_10['type_action_name'] = "Phiếu xuất";
						if($ton == -100000000){
							$ton_luc_dau = $amount_product->amount ;
							$ton = $ton_luc_dau;
							$ton_vong_truoc = $ton_luc_dau + $item_detail-> amount;
						}else{
							$ton = $ton_vong_truoc;
							$ton_vong_truoc = $ton + $item_detail-> amount;
						}
					}

					$row_10['ton'] = $ton;
					// dd($row_10);
					$rs_add = $this-> _update($row_10,'fs_warehouses_bill_detail_history','id = '.$row_10['bill_detail_id']);
					if($rs_add){
						$row_11 = array();
						$row_11['ton'] =  $row_10['ton'];
						$this-> _update($row_11,'fs_warehouses_bill_detail','id = '.$row_10['bill_detail_id']);
					}
				}
				//end lưu lịch sử

			}
		}

		function update_loi_ton_2_12(){
			$list_products = $this -> get_records('bill_id = 250','fs_warehouses_bill_detail_history','*');
			foreach ($list_products as $product_item) {
				$data_bf = $this -> get_record('warehouses_id = 1 AND bill_id < 250 AND product_id = '.$product_item->product_id,'fs_warehouses_bill_detail_history','*','id DESC');

				if(!empty($data_bf) && $data_bf->ton == $product_item->ton ){
					$row = array();
					$row['is_erorr'] = 1;
					$this -> _update($row,'fs_warehouses_bill_detail_history','product_id = '.$product_item->product_id . ' AND bill_id = 250');
				}
			}
			// dd($list_products);
		}


		function add_history_detail_bill($bill_id = 292){
			// cứ hoàn thành thì lưu lại lịch sử
			//lấy ra item
			$list_products = $this -> get_records('bill_id = '.$bill_id,'fs_warehouses_bill_detail_history','DISTINCT product_id');
			
			foreach ($list_products as $product_id_item) {
				//31283 id dau cua bill sai

				$list_detail = $this -> get_records('product_id = '.$product_id_item-> product_id.' AND warehouses_id = 1 AND status = 4 AND  id >= 31283','fs_warehouses_bill_detail_history','*','id ASC');
				// dd($list_detail);
		
				if(empty($list_detail)){
					continue;
				}
				$i=0;
				foreach($list_detail as $item_detail) {
					$row_10 = array();
					$row_10['bill_detail_id'] = $item_detail-> id;
					$row_10['bill_id'] = $item_detail-> bill_id;
					$row_10['created_time'] = $item_detail-> created_time;
					$row_10['product_id']   = $item_detail-> product_id;
					$row_10['product_code'] = $item_detail-> product_code;
					$row_10['product_name'] = $item_detail-> product_name;

					$row_10['warehouses_id'] = $item_detail-> warehouses_id;
					$row_10['warehouses_name'] = $item_detail-> warehouses_name;

					$row_10['type'] = $item_detail-> type;
					$row_10['amount'] = $item_detail-> amount;
					$row_10['price'] = $item_detail-> price;
					$row_10['tong_tien'] = $item_detail-> price * $item_detail-> amount;
					$row_10['note'] = $item_detail-> note;
					$row_10['status'] = $item_detail-> status;

					$row_10['time_add'] = date('Y-m-d H:i:s');


					if($i == 0){
						//reset ton ve cai dau tien bi sai
						$row_cnt =  array();
						$row_cnt['amount'] = $item_detail->ton;
						// dd($row_cnt['amount']);
						$this->_update($row_cnt,'fs_warehouses_products','product_id = '.$item_detail-> product_id.' AND warehouses_id = '.$item_detail-> warehouses_id);

					}
					//tồn thực tế hiện tại

					
					$amount_product = $this-> get_record('product_id = '.$item_detail-> product_id.' AND warehouses_id = '.$item_detail-> warehouses_id,'fs_warehouses_products','amount');


					if($item_detail-> type == 1 || $item_detail-> type == 4){
						$ton = $amount_product->amount + $item_detail-> amount;
					}elseif($item_detail-> type == 2 || $item_detail-> type == 3){
						$ton = $amount_product->amount - $item_detail-> amount;
					}

					if($i == 1){
						// echo $item_detail-> warehouses_id;
						// echo "+++";
						// echo $item_detail-> amount;
						// echo "+++";
						// echo  $amount_product->amount;
						// echo "+++";
						// echo $ton;
						// dd("====");
					}

					$row_10['ton'] = $ton;
					$rs_add = $this-> _update($row_10,'fs_warehouses_bill_detail_history','id = '. $item_detail-> id);

					$row22 = array();
					$row22['amount'] = $ton;

					$this->_update($row22,'fs_warehouses_products','product_id = '.$item_detail-> product_id.' AND warehouses_id = '.$item_detail-> warehouses_id);
					$i++;
				}
				//end lưu lịch sử
			}
		}

		function update_loi_nhuan_1(){
			$list = $this -> get_records('id >= 31760','fs_order_uploads');
			// dd($list[1]);
			foreach ($list as $item) {
				$row = array();
				$row['is_seeding'] = $item->is_seeding ? $item->is_seeding : 0;
				// dd($row);
				$this->_update($row,'fs_order_uploads_detail','record_id = ' .$item->id);
			}
		}

		function update_loi_nhuan_2(){
			$list_detail = $this -> get_records('record_id >= 31760','fs_order_uploads_detail');
			$produts = $this->get_records('','fs_products','price_pack,price,code','','','code');
			foreach ($list_detail as $item_detail) {
				$row2 = array();
				

				if(empty($produts[$item_detail->product_code])){
					continue;
				}

				$produt = $produts[$item_detail->product_code];
				// printr($produt);
				$row2['product_price'] = $produt-> price;
				if($item_detail-> is_seeding == 1){
					$row2['price_package'] =0;
					$row2['profit'] = 0;
				}else{
					$row2['price_package'] = $produt-> price_pack ? $produt-> price_pack : 0;
					$row2['profit'] = $item_detail-> gia_tri_don_hang - $produt-> price -  $row2['price_package'];
				}
				$this->_update($row2,'fs_order_uploads_detail','id ='.$item_detail->id);
			}
		}


		function update_loi_nhuan_3(){
			$row = array();
			$row['is_seeding'] = 1;
			$this->_update($row,'fs_order_uploads_detail','house_id = 4 OR house_id = 15 OR house_id = 14');
			$this->_update($row,'fs_order_uploads','house_id = 4 OR house_id = 15 OR house_id = 14');
		}


		function update_loi_nhuan_4(){
			// echo 111;
			// die;
			//chuyển lơi nhuận , đóng hàng về 0  trước
			// $row3 = array();
			// $row3['price_package'] = 0;
			// $row3['profit'] = 0;
			// $this->_update($row3,'fs_order_uploads_detail','is_seeding = 1 AND shop_code ="SCL" ');
			//dựa vào tracking_code để tính ra số đơn (1 đơn là mất 6000k đóng hàng fake) 
		
			$list_tracking_code = $this->get_records('is_seeding = 1 AND shop_code ="SCL" ','fs_order_uploads_detail','DISTINCT tracking_code','id DESC');
			// dd($list_tracking_code);

			foreach ($list_tracking_code as $item_tracking_code){	
				if(!$item_tracking_code->tracking_code || $item_tracking_code->tracking_code == ""){
					continue;
				}
				// echo $item_tracking_code->tracking_code;
				// die;
				//đơn mất phí đóng gói
				$data_detail = $this->get_record('tracking_code = "'.$item_tracking_code->tracking_code.'"','fs_order_uploads_detail','id','id DESC');
				// dd($data_detail);
				$row2 = array();
				$row2['price_package'] = 6000;
				$row2['profit'] = -6000;
				
				$this->_update($row2,'fs_order_uploads_detail','id ='.$data_detail->id);
			}
		}



}
?>
