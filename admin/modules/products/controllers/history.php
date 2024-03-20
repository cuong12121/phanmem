<?php
	class ProductsControllersHistory extends Controllers
	{
		function __construct()
		{
			$this->view = 'history' ; 
			parent::__construct(); 
			//$this -> arr_status = array(1=>'Lưu nháp',2=>'BTV từ chối',3=>'Chờ BTV duyệt',4=>'Đã biên tập',5=>'Hạ bài (kéo về)',6=>'Xuất bản');
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			die;
//			$model = $this -> model;
//			$categories = $model->get_categories_tree();
//			
//			// data from fs_products_categories
//			$categories_home  = $model->get_categories_tree();
//			$maxOrdering = $model->getMaxOrdering();
				
//			
//			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;

			$data = $model->get_record_by_id($id);
			// data from fs_products_categories
			//$arr_status = $this -> arr_status;
			include 'modules/'.$this->module.'/views/'.$this->view.'/view.php';
		}
		function compare()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;

			$data = $model->get_record_by_id($id);
			// data from fs_products_categories
			// $arr_status = $this -> arr_status;
			
			$data_older = $model -> get_data_older($id,$data -> record_id);
			FSFactory::include_class('finediff','textdiff');
//			echo $opcodes = FineDiff::getDiffOpcodes('Phạm Văn Huy', 'Phạm Vân Huy');
//			echo $to_text = FineDiff::renderToTextFromOpcodes('Phạm Văn Huy', $opcodes); 
//			die;

			$fields_in_compare  = array('name'=>'Tiêu đề','alias'=>'Tên hiệu','published'=>'Trạng thái','image'=>'Ảnh','summary'=>'Tóm tắt','description'=>'Nội dung','specs_copy'=>'Đặc tả kỹ thuật','tags'=>'Tags','category_name'=>'Danh mục','seo_title'=>'Seo title','seo_keyword'=>'Seo keyword','seo_description'=>'Mô tả','quantity'=>'Số lượng','sale'=>'Số lượng bán','warranty'=>'Bảo hành','price'=>'Giá','ordering'=>'Thứ tự','show_in_home'=>'Show trang chủ','promotion'=>'Khuyến mãi',);
			
			$from_text = 'Phạm Văn Huy';
			$to_text 	= 'Phạm Vân Huy1';
			$granularityStacks = array(
				FineDiff::$paragraphGranularity,
				FineDiff::$sentenceGranularity,
				FineDiff::$wordGranularity,
				FineDiff::$characterGranularity
			);
//			$diff = new FineDiff($from_text, $to_text, $granularityStacks[3]);
//			$edits = $diff->getOps();
//			$rendered_diff = $diff->renderDiffToHTML();
//			echo $rendered_diff;
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/compare.php';
		}
		
		function view_compare($data,$total_his,$i){
			if($i+ 1 < $total_his){	
				$link = 'index.php?module=products&view=history&task=compare&id[]='.$data ->id.'&record_id='.$data->record_id;
				return '<a href="'.$link.'">So sánh</a>';
			}
		}
		
		function back()
		{
			// $record_id = FSInput::get('record_id',0,'int');
			$link = 'index.php?module=products&view=products';
			setRedirect($link);	
		}
	}
			function view_compare($data,$total_his,$i){
			if($i+ 1 < $total_his){	
				$link = 'index.php?module=products&view=history&task=compare&id[]='.$data ->id.'&record_id='.$data->record_id;
				return '<a href="'.$link.'">So sánh</a>';
			}
		}
	
?>